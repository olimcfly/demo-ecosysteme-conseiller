<?php
// public/templates/lp/thankyou/telechargement.php
// Thank you page : téléchargement de ressource

$tyConfig  = $funnel['thankyou_config'] ?? [];
$message   = htmlspecialchars($tyConfig['message']   ?? 'Votre guide est en route !');
$ctaLabel  = htmlspecialchars($tyConfig['cta_label'] ?? 'Prendre rendez-vous');
$ctaUrl    = htmlspecialchars($tyConfig['cta_url']   ?? rtrim(APP_URL, '/') . '/contact');
$ville     = htmlspecialchars($funnel['ville'] ?? '');
?>

<div class="lp-thankyou">
    <div class="lp-thankyou__icon">📥</div>
    <h1 class="lp-thankyou__title">Votre guide est en route !</h1>
    <p class="lp-thankyou__text">
        <?= $message ?>
        Vérifiez votre boîte mail (et vos spams si besoin).
        Vous recevrez également quelques conseils pratiques dans les prochains jours.
    </p>

    <?php if ($ctaUrl): ?>
    <a href="<?= $ctaUrl ?>" class="lp-btn-cta lp-btn-cta--success" style="max-width:360px" data-track-cta>
        <i class="fas fa-calendar" style="margin-right:8px"></i><?= $ctaLabel ?>
    </a>
    <?php endif; ?>

    <p style="margin-top:24px;font-size:.82rem;color:#9ca3af">
        <?php if ($ville): ?>
        Votre conseiller immobilier local à <?= $ville ?> est disponible pour répondre à vos questions.
        <?php endif; ?>
    </p>
</div>
