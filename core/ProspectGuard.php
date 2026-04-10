<?php
// ============================================================
// PROSPECT GUARD — Middleware d'accès à la démo
// ============================================================

class ProspectGuard
{
    private const COOKIE_NAME    = 'demo_access';
    private const SESSION_HOURS  = 72; // accès valide 72h

    // Routes accessibles sans authentification
    private const PUBLIC_PATHS = [
        '/acces',
        '/acces/merci',
        '/api/prospect/register',
        '/robots.txt',
        '/sitemap.xml',
        '/health',
        '/healthz',
    ];

    public static function check(): void
    {
        $path = parse_url((string)($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/';

        // Laisser passer les routes publiques et assets statiques
        if (self::isPublicPath($path)) {
            return;
        }

        // Vérifier le cookie de session prospect
        $token = $_COOKIE[self::COOKIE_NAME] ?? '';
        if ($token !== '' && self::validateToken($token)) {
            return; // Accès autorisé
        }

        // Rediriger vers la page de capture
        $redirect = urlencode($_SERVER['REQUEST_URI'] ?? '/');
        header('Location: /acces?redirect=' . $redirect, true, 302);
        exit;
    }

    private static function isPublicPath(string $path): bool
    {
        foreach (self::PUBLIC_PATHS as $public) {
            if ($path === $public || str_starts_with($path, '/acces/') || str_starts_with($path, '/public/assets/')) {
                return true;
            }
        }
        // Assets statiques
        if (preg_match('/\.(css|js|jpg|jpeg|png|gif|webp|svg|ico|woff2?|ttf|otf)$/i', $path)) {
            return true;
        }
        return false;
    }

    private static function validateToken(string $token): bool
    {
        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            return false;
        }

        try {
            $pdo  = ProspectsDB::getInstance();
            $stmt = $pdo->prepare("
                SELECT ps.id, ps.prospect_id, ps.expire_at, p.statut
                FROM prospects_sessions ps
                JOIN prospects p ON p.id = ps.prospect_id
                WHERE ps.session_token = ?
                  AND ps.expire_at > NOW()
                  AND p.statut = 'valide'
                LIMIT 1
            ");
            $stmt->execute([$token]);
            $session = $stmt->fetch();

            if (!$session) {
                return false;
            }

            // Mettre à jour la dernière connexion
            $pdo->prepare("UPDATE prospects SET nb_connexions = nb_connexions + 1, derniere_connexion = NOW() WHERE id = ?")
                ->execute([$session['prospect_id']]);

            return true;
        } catch (PDOException $e) {
            error_log('ProspectGuard::validateToken error: ' . $e->getMessage());
            return false;
        }
    }

    public static function createSession(int $prospectId): string
    {
        $token     = bin2hex(random_bytes(32));
        $expireAt  = date('Y-m-d H:i:s', time() + self::SESSION_HOURS * 3600);
        $ip        = $_SERVER['REMOTE_ADDR'] ?? '';
        $ua        = substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500);

        $pdo = ProspectsDB::getInstance();
        $pdo->prepare("
            INSERT INTO prospects_sessions (prospect_id, session_token, ip, user_agent, expire_at)
            VALUES (?, ?, ?, ?, ?)
        ")->execute([$prospectId, $token, $ip, $ua, $expireAt]);

        // Poser le cookie 72h
        setcookie(
            self::COOKIE_NAME,
            $token,
            [
                'expires'  => time() + self::SESSION_HOURS * 3600,
                'path'     => '/',
                'secure'   => true,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );

        return $token;
    }
}
