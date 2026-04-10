<?php

declare(strict_types=1);

require_once __DIR__ . '/../core/bootstrap.php';

if (!class_exists('Router')) {
    die('La classe Router n\'est pas définie.');
}
if (!class_exists('ZoneController')) {
    die('La classe ZoneController n\'est pas définie.');
}

$maintenanceFlag = STORAGE_PATH . '/cache/maintenance.flag';
$requestPath = parse_url((string)($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/';
$isMaintenanceBypass = isset($_GET['preview']) && $_GET['preview'] === '1';
$isHealthcheck = in_array($requestPath, ['/health', '/healthz'], true);

if (is_file($maintenanceFlag) && !$isMaintenanceBypass && !$isHealthcheck) {
    http_response_code(503);
    header('Retry-After: 3600');
    header('Content-Type: text/html; charset=UTF-8');

    $siteName = htmlspecialchars(APP_NAME ?: 'Site immobilier');
    echo <<<HTML
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Maintenance — {$siteName}</title>
  <style>
    :root { color-scheme: light; }
    body {
      margin: 0;
      min-height: 100vh;
      display: grid;
      place-items: center;
      font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background: #f5f7fb;
      color: #0f172a;
      padding: 24px;
    }
    .card {
      max-width: 620px;
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
      padding: 32px;
      text-align: center;
    }
    h1 { margin: 0 0 12px; font-size: 1.8rem; }
    p { margin: 0; line-height: 1.6; color: #334155; }
  </style>
</head>
<body>
  <main class="card">
    <h1>Le site est temporairement en maintenance</h1>
    <p>Nous effectuons une intervention technique pour améliorer votre expérience.<br>Merci de revenir dans quelques instants.</p>
  </main>
</body>
</html>
HTML;
    exit;
}

$router = new Router();

// ── Helper : charge une page dans le layout ────────────────────
function servePage(string $file): void {
    if (!is_file($file)) {
        http_response_code(404);
        $pageTitle   = 'Page introuvable';
        $pageContent = '<section class="section"><div class="container"><h1>404</h1><p>Cette page est introuvable.</p></div></section>';
        require ROOT_PATH . '/public/templates/layout.php';
        return;
    }
    ob_start();
    require $file;
    $pageContent = ob_get_clean();
    require ROOT_PATH . '/public/templates/layout.php';
}

// ══════════════════════════════════════════════════════════════
//  ACCUEIL
// ══════════════════════════════════════════════════════════════
$router->get('/', function() {
    servePage(ROOT_PATH . '/public/pages/core/home.php');
});

// ══════════════════════════════════════════════════════════════
//  BIENS IMMOBILIERS
// ══════════════════════════════════════════════════════════════

// Liste principale (page autonome avec header intégré)
$router->get('/biens', function() {
    servePage(ROOT_PATH . '/public/pages/biens/index.php');
});

// Sous-catégories (doivent être déclarées AVANT /biens/{slug})
$router->get('/biens/maisons', function() {
    servePage(ROOT_PATH . '/public/pages/biens/maisons.php');
});
$router->get('/biens/appartements', function() {
    servePage(ROOT_PATH . '/public/pages/biens/appartements.php');
});
$router->get('/biens/prestige', function() {
    servePage(ROOT_PATH . '/public/pages/biens/prestige.php');
});
$router->get('/biens/vendus', function() {
    servePage(ROOT_PATH . '/public/pages/biens/vendus.php');
});

// Détail d'un bien via slug dynamique
$router->get('/bien/{slug}', function(string $slug) {
    $GLOBALS['bienSlug'] = $slug;
    servePage(ROOT_PATH . '/public/pages/biens/bien-detail.php');
});

// ══════════════════════════════════════════════════════════════
//  ESTIMATION & CONVERSION
// ══════════════════════════════════════════════════════════════

// Tunnel d'estimation — URL canonique SEO
$router->get('/estimation-gratuite', function() {
    servePage(ROOT_PATH . '/public/pages/estimation/tunnel.php');
});

// /estimation → 301 vers /estimation-gratuite (alias court)
$router->get('/estimation', function() {
    header('Location: /estimation-gratuite', true, 301);
    exit;
});

// API — Calcul estimation
$router->post('/api/estimation/calculate', function() {
    require ROOT_PATH . '/public/api/estimation/calculate.php';
});

// API — Conversion (lead capture)
$router->post('/api/estimation/convert', function() {
    require ROOT_PATH . '/public/api/estimation/convert.php';
});

$router->get('/avis-de-valeur', function() {
    servePage(ROOT_PATH . '/public/pages/conversion/avis-valeur.php');
});
$router->post('/avis-de-valeur', function() {
    servePage(ROOT_PATH . '/public/pages/conversion/avis-valeur.php');
});

$router->get('/prendre-rendez-vous', function() {
    servePage(ROOT_PATH . '/public/pages/conversion/prendre-rendez-vous.php');
});
$router->post('/prendre-rendez-vous', function() {
    servePage(ROOT_PATH . '/public/pages/conversion/prendre-rendez-vous.php');
});

$router->get('/merci', function() {
    servePage(ROOT_PATH . '/public/pages/conversion/merci.php');
});


$router->get('/fr/estimation-immobiliere-aix-en-provence', function() {
    $GLOBALS['landingLocale'] = 'fr';
    servePage(ROOT_PATH . '/public/pages/conversion/international-valuation.php');
});

$router->get('/en/property-valuation-aix-en-provence', function() {
    $GLOBALS['landingLocale'] = 'en';
    servePage(ROOT_PATH . '/public/pages/conversion/international-valuation.php');
});

$router->get('/es/valoracion-inmobiliaria-aix-en-provence', function() {
    $GLOBALS['landingLocale'] = 'es';
    servePage(ROOT_PATH . '/public/pages/conversion/international-valuation.php');
});


// ══════════════════════════════════════════════════════════════
//  SECTEURS GÉOGRAPHIQUES
// ══════════════════════════════════════════════════════════════

// Page index des secteurs
$router->get('/secteurs', function() {
    servePage(ROOT_PATH . '/public/pages/secteurs/index.php');
});

// Route avec type explicite : /secteurs/villes/aix-en-provence
$router->get('/secteurs/{type}/{slug}', 'ZoneController@show');

// Route simplifiée sans type : /secteurs/aix-en-provence (fallback)
$router->get('/secteurs/{slug}', function(string $slug) {
    (new ZoneController())->show('', $slug);
});


// ══════════════════════════════════════════════════════════════
//  LANDING PAGES — Funnels (nouveau système) + legacy
// ══════════════════════════════════════════════════════════════

// Thank you page funnel (avant la route générique /lp/{slug})
$router->get('/lp/{slug}/merci', function(string $slug) {
    require_once ROOT_PATH . '/core/controllers/FunnelPublicController.php';
    (new FunnelPublicController())->thankyou(['slug' => $slug]);
});

// Soumission formulaire funnel
$router->post('/lp/{slug}/submit', function(string $slug) {
    require_once ROOT_PATH . '/core/controllers/FunnelPublicController.php';
    (new FunnelPublicController())->submit(['slug' => $slug]);
});

// Téléchargement ressource sécurisé
$router->get('/ressource/{token}', function(string $token) {
    require_once ROOT_PATH . '/core/controllers/FunnelPublicController.php';
    (new FunnelPublicController())->download(['token' => $token]);
});

// Affichage LP — tente le système Funnels, fallback legacy
$router->get('/lp/{slug}', function(string $slug) {
    require_once ROOT_PATH . '/core/controllers/FunnelPublicController.php';
    require_once MODULES_PATH . '/funnels/repositories/FunnelRepository.php';
    $repo   = new FunnelRepository(\Database::getInstance());
    $funnel = $repo->findBySlug($slug);
    if ($funnel) {
        (new FunnelPublicController())->show(['slug' => $slug]);
    } else {
        (new LandingPageController())->show($slug);
    }
});

// Legacy POST (ancien système)
$router->post('/lp/{slug}', function(string $slug) {
    (new LandingPageController())->submit($slug);
});

// ══════════════════════════════════════════════════════════════
//  FINANCEMENT
// ══════════════════════════════════════════════════════════════
$router->get('/financement', function() {
    servePage(ROOT_PATH . '/public/pages/financement/financement.php');
});

// ══════════════════════════════════════════════════════════════
//  BLOG & ACTUALITÉS
// ══════════════════════════════════════════════════════════════
$router->get('/blog', function() {
    servePage(ROOT_PATH . '/public/pages/blog/index.php');
});

$router->get('/blog/{slug}', function(string $slug) {
    $GLOBALS['articleSlug'] = $slug;
    servePage(ROOT_PATH . '/public/pages/blog/article.php');
});

// ══════════════════════════════════════════════════════════════
//  AVIS CLIENTS
// ══════════════════════════════════════════════════════════════
$router->get('/avis-clients', function() {
    servePage(ROOT_PATH . '/public/pages/social-proof/avis.php');
});

// ══════════════════════════════════════════════════════════════
//  PAGES PRINCIPALES
// ══════════════════════════════════════════════════════════════
$router->get('/a-propos', function() {
    servePage(ROOT_PATH . '/public/pages/core/a-propos.php');
});

$router->get('/contact', function() {
    servePage(ROOT_PATH . '/public/pages/core/contact.php');
});
$router->post('/contact', function() {
    servePage(ROOT_PATH . '/public/pages/core/contact.php');
});

// ══════════════════════════════════════════════════════════════
//  SERVICES (page dynamique par slug)
// ══════════════════════════════════════════════════════════════
$router->get('/services/{slug}', function(string $slug) {
    servePage(ROOT_PATH . '/public/pages/services/' . $slug . '.php');
});

// ══════════════════════════════════════════════════════════════
//  MENTIONS LÉGALES
// ══════════════════════════════════════════════════════════════
$router->get('/mentions-legales', function() {
    servePage(ROOT_PATH . '/public/pages/legal/mentions-legales.php');
});

$router->get('/politique-confidentialite', function() {
    servePage(ROOT_PATH . '/public/pages/legal/politique-confidentialite.php');
});

$router->get('/politique-cookies', function() {
    servePage(ROOT_PATH . '/public/pages/legal/politique-cookies.php');
});

$router->get('/cgv', function() {
    servePage(ROOT_PATH . '/public/pages/legal/cgv.php');
});

$router->get('/plan-du-site', function() {
    servePage(ROOT_PATH . '/public/pages/legal/plan-du-site.php');
});

// ══════════════════════════════════════════════════════════════
//  404 PAR DÉFAUT
// ══════════════════════════════════════════════════════════════
$router->set404(function() {
    http_response_code(404);
    $pageTitle   = 'Page introuvable';
    $pageContent = '<section class="section"><div class="container text-center"><h1 style="font-size:4rem;color:var(--clr-primary)">404</h1><p>La page demandée est introuvable.</p><a href="/" class="btn btn--primary" style="margin-top:1.5rem">Retour à l\'accueil</a></div></section>';
    require ROOT_PATH . '/public/templates/layout.php';
});

$router->dispatch();
