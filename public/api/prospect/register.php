<?php
// ============================================================
// API — Inscription prospect & création session
// ============================================================

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

// ── Validation ────────────────────────────────────────────────
$errors = [];

$prenom    = trim((string)($input['prenom']    ?? ''));
$nom       = trim((string)($input['nom']       ?? ''));
$email     = trim((string)($input['email']     ?? ''));
$telephone = trim((string)($input['telephone'] ?? ''));
$ville     = trim((string)($input['ville']     ?? ''));
$reseau    = trim((string)($input['reseau']    ?? ''));

if ($prenom === '')                      $errors[] = 'Le prénom est requis.';
if ($nom === '')                         $errors[] = 'Le nom est requis.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide.';
if (strlen($telephone) < 10)            $errors[] = 'Téléphone invalide.';
if ($ville === '')                       $errors[] = 'La ville est requise.';
if ($reseau === '')                      $errors[] = 'Le réseau est requis.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

try {
    $pdo = ProspectsDB::getInstance();

    // Vérifier si l'email existe déjà
    $existing = $pdo->prepare("SELECT id, statut FROM prospects WHERE email = ? LIMIT 1");
    $existing->execute([$email]);
    $prospect = $existing->fetch();

    if ($prospect) {
        if ($prospect['statut'] === 'refuse') {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Votre demande d\'accès a été refusée.']);
            exit;
        }
        // Déjà inscrit → créer une nouvelle session
        $prospectId = (int)$prospect['id'];
    } else {
        // Nouveau prospect → insérer
        $token = bin2hex(random_bytes(32));
        $ip    = $_SERVER['REMOTE_ADDR'] ?? '';

        $stmt = $pdo->prepare("
            INSERT INTO prospects (prenom, nom, email, telephone, ville, reseau, token_acces, ip_inscription)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$prenom, $nom, $email, $telephone, $ville, $reseau, $token, $ip]);
        $prospectId = (int)$pdo->lastInsertId();
    }

    // Créer la session d'accès
    ProspectGuard::createSession($prospectId);

    $redirect = urldecode((string)($input['redirect'] ?? '/'));
    if (!preg_match('/^\/[a-zA-Z0-9\/_\-?=&%]*$/', $redirect)) {
        $redirect = '/';
    }

    echo json_encode([
        'success'  => true,
        'redirect' => $redirect,
        'message'  => 'Accès accordé, bienvenue !',
    ]);

} catch (PDOException $e) {
    error_log('Prospect register error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur serveur, veuillez réessayer.']);
}
