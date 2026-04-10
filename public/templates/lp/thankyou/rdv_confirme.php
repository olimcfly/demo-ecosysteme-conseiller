<?php
// public/templates/lp/thankyou/rdv_confirme.php
$tyConfig = $funnel['thankyou_config'] ?? [];
$ville    = htmlspecialchars($funnel['ville'] ?? '');
?>

<div class="lp-thankyou">
    <div class="lp-thankyou__icon">📅</div>
    <h1 class="lp-thankyou__title">Demande de rendez-vous reçue !</h1>
    <p class="lp-thankyou__text">
        Votre conseiller immobilier<?= $ville ? " à $ville" : '' ?> vous contactera dans les
        <strong>24 heures ouvrées</strong> pour confirmer votre rendez-vous.
    </p>

    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:20px;max-width:440px;margin:0 auto 28px;text-align:left">
        <p style="font-size:.88rem;color:#166534;margin:0;line-height:1.6">
            <strong>Ce qui va se passer :</strong><br>
            ✅ Confirmation par email dans quelques minutes<br>
            📞 Appel de votre conseiller sous 24h<br>
            🏠 Rendez-vous à votre domicile ou en agence
        </p>
    </div>

    <?php if (!empty($tyConfig['cta_url'])): ?>
    <a href="<?= htmlspecialchars($tyConfig['cta_url']) ?>" class="lp-btn-cta" style="max-width:360px">
        <?= htmlspecialchars($tyConfig['cta_label'] ?? 'Découvrir nos services') ?>
    </a>
    <?php endif; ?>
</div>
