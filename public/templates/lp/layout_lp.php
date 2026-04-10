<?php
// public/templates/lp/layout_lp.php
// Layout landing page — PAS de menu principal, pas de footer site
// Compatible Google Ads (noindex par défaut), mobile-first

$seoTitle    = htmlspecialchars($funnel['seo_title'] ?? 'Votre conseiller immobilier local');
$metaDesc    = htmlspecialchars($funnel['meta_description'] ?? '');
$indexable   = !empty($funnel['indexable']);
$canonicalUrl= !empty($funnel['canonical_url']) ? $funnel['canonical_url'] : (APP_URL . '/lp/' . $funnel['slug']);
$appUrl      = rtrim(APP_URL, '/');
$gaMeasurementId = setting('google_analytics_id', '');

// Error flash
$errorMsg = $_SESSION['funnel_error'] ?? null;
unset($_SESSION['funnel_error']);

// Détecter si on est sur la thank you page
$isThankyou = str_ends_with(($_SERVER['REQUEST_URI'] ?? ''), '/merci');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $seoTitle ?></title>

    <?php if (!$indexable): ?>
    <meta name="robots" content="noindex, nofollow">
    <?php else: ?>
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <?php endif; ?>

    <?php if ($metaDesc): ?>
    <meta name="description" content="<?= $metaDesc ?>">
    <?php endif; ?>

    <!-- Open Graph minimal -->
    <meta property="og:title"       content="<?= $seoTitle ?>">
    <meta property="og:description" content="<?= $metaDesc ?>">
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="<?= htmlspecialchars($canonicalUrl) ?>">

    <!-- Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="//www.google-analytics.com">

    <!-- CSS LP dédié (ultra-léger, sans Bootstrap) -->
    <link rel="stylesheet" href="<?= $appUrl ?>/assets/css/lp.css">

    <!-- Font Awesome (icons trust bar) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
          media="print" onload="this.media='all'" crossorigin="anonymous">

    <?php if ($gaMeasurementId): ?>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($gaMeasurementId) ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?= htmlspecialchars($gaMeasurementId) ?>');
    </script>
    <?php endif; ?>

    <!-- UTM persistence en cookie (30 jours) -->
    <script>
    (function(){
        const params = new URLSearchParams(location.search);
        ['utm_source','utm_medium','utm_campaign','utm_content','utm_term'].forEach(k => {
            if (params.has(k)) {
                document.cookie = k + '=' + encodeURIComponent(params.get(k)) + ';max-age=2592000;path=/;SameSite=Lax';
            }
        });
    })();
    </script>
</head>
<body class="lp-body">

<?php if ($errorMsg): ?>
<div class="lp-error-banner" role="alert">
    <i class="fas fa-exclamation-circle me-1"></i><?= htmlspecialchars($errorMsg) ?>
</div>
<?php endif; ?>

<?php if ($isThankyou): ?>
    <?php require $tplFile; // thank you template ?>
<?php else: ?>
    <?php require $templateFile; // LP template ?>
<?php endif; ?>

<!-- Footer LP minimal -->
<footer class="lp-footer">
    <p>
        <?= htmlspecialchars(setting('advisor_name', defined('ADVISOR_NAME') ? ADVISOR_NAME : '')) ?>
        — Agent commercial immo.
        <a href="<?= $appUrl ?>/politique-de-confidentialite" target="_blank">Politique de confidentialité</a> |
        <a href="<?= $appUrl ?>/mentions-legales" target="_blank">Mentions légales</a>
    </p>
    <p style="margin:4px 0 0">
        Les estimations présentées sont indicatives et non contractuelles.
        Elles ne constituent pas un avis de valeur au sens de la loi Hoguet.
    </p>
</footer>

<!-- Tracking clic CTA -->
<script>
document.querySelectorAll('[data-track-cta]').forEach(el => {
    el.addEventListener('click', () => {
        fetch('/t/e', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({type: 'cta_click', funnel_id: <?= (int)$funnel['id'] ?>})
        }).catch(() => {});
    });
});

// FAQ accordion
document.querySelectorAll('.lp-faq__item').forEach(item => {
    item.querySelector('.lp-faq__question')?.addEventListener('click', () => {
        item.classList.toggle('open');
    });
});
</script>

</body>
</html>
