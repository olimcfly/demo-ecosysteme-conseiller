<?php
// public/templates/lp/guide_vendeur_v1.php
// Template : Guide Vendeur Local
// Usage : Google Ads, Facebook Ads, Social
// Formulaire : email + prénom + téléphone (optionnel)
// Above the fold : H1 + promesse + formulaire

$h1          = htmlspecialchars($funnel['h1'] ?? 'Vendez votre bien au meilleur prix');
$promise     = htmlspecialchars($funnel['promise'] ?? 'Téléchargez gratuitement notre guide complet');
$ctaLabel    = htmlspecialchars($funnel['cta_label'] ?? 'Télécharger le guide gratuit');
$ville       = htmlspecialchars($funnel['ville'] ?? '');
$slug        = htmlspecialchars($funnel['slug'] ?? '');
$formAction  = rtrim(APP_URL, '/') . '/lp/' . $slug . '/submit';

// Bénéfices du guide (configurables via body_html en V2)
$benefits = [
    ['icon' => '📊', 'title' => 'Prix du marché local',      'text' => 'Données actualisées sur les transactions dans votre secteur.'],
    ['icon' => '✅', 'title' => '12 étapes pour réussir',     'text' => 'De l\'évaluation jusqu\'à la signature chez le notaire.'],
    ['icon' => '⚡', 'title' => 'Éviter les 5 erreurs clés',  'text' => 'Les pièges qui font perdre 10 à 20 % du prix de vente.'],
    ['icon' => '🤝', 'title' => 'Négocier avec confiance',    'text' => 'Scripts et arguments pour défendre votre prix.'],
    ['icon' => '📅', 'title' => 'Timing optimal',             'text' => 'Quand et comment mettre en vente pour maximiser les offres.'],
    ['icon' => '🔒', 'title' => 'Aspects juridiques clés',    'text' => 'Les documents indispensables et les obligations légales.'],
];

$advisorName = htmlspecialchars(setting('advisor_name', defined('ADVISOR_NAME') ? ADVISOR_NAME : ''));
?>

<!-- HERO -->
<section class="lp-hero">
    <div class="lp-hero--split">
        <div class="lp-hero__content">
            <span class="lp-hero__badge">
                <i class="fas fa-gift" style="margin-right:6px"></i>Guide gratuit
                <?php if ($ville): ?> — <?= $ville ?><?php endif; ?>
            </span>
            <h1 class="lp-hero__h1"><?= $h1 ?></h1>
            <p class="lp-hero__promise"><?= $promise ?></p>

            <!-- Réassurance -->
            <div style="display:flex;flex-wrap:wrap;gap:16px;margin-top:8px;opacity:.9;">
                <span style="font-size:.85rem;display:flex;align-items:center;gap:6px">
                    <i class="fas fa-check-circle" style="color:#86efac"></i>100% gratuit
                </span>
                <span style="font-size:.85rem;display:flex;align-items:center;gap:6px">
                    <i class="fas fa-check-circle" style="color:#86efac"></i>Sans engagement
                </span>
                <span style="font-size:.85rem;display:flex;align-items:center;gap:6px">
                    <i class="fas fa-check-circle" style="color:#86efac"></i>Envoi immédiat
                </span>
            </div>
        </div>

        <!-- FORMULAIRE above the fold -->
        <div class="lp-hero__form-wrapper" id="form-top">
            <p class="lp-hero__form-title">Recevez votre guide maintenant</p>

            <form class="lp-form" action="<?= $formAction ?>" method="POST" id="lp-form">
                <!-- Honeypot anti-spam -->
                <input type="text" name="website" class="lp-form__honey" tabindex="-1" autocomplete="off">

                <div class="lp-form__group">
                    <label class="lp-form__label" for="first_name">Votre prénom *</label>
                    <input type="text" id="first_name" name="first_name" class="lp-form__input"
                           placeholder="ex: Marie" required autocomplete="given-name">
                </div>

                <div class="lp-form__group">
                    <label class="lp-form__label" for="email">Votre email *</label>
                    <input type="email" id="email" name="email" class="lp-form__input"
                           placeholder="marie@exemple.fr" required autocomplete="email">
                </div>

                <div class="lp-form__group">
                    <label class="lp-form__label" for="phone">Téléphone (optionnel)</label>
                    <input type="tel" id="phone" name="phone" class="lp-form__input"
                           placeholder="06 xx xx xx xx" autocomplete="tel">
                </div>

                <label class="lp-form__consent">
                    <input type="checkbox" name="consent" value="1" required>
                    <span class="lp-form__consent-text">
                        J'accepte de recevoir ce guide et d'être recontacté(e) par email.
                        Voir notre <a href="<?= rtrim(APP_URL, '/') ?>/politique-de-confidentialite" target="_blank">politique de confidentialité</a>.
                        Désinscription à tout moment.
                    </span>
                </label>

                <button type="submit" class="lp-btn-cta" data-track-cta>
                    <i class="fas fa-download" style="margin-right:8px"></i><?= $ctaLabel ?>
                </button>

                <p style="font-size:.75rem;color:#9ca3af;text-align:center;margin:10px 0 0">
                    <i class="fas fa-lock" style="margin-right:4px"></i>
                    Vos données sont sécurisées et ne seront jamais vendues.
                </p>
            </form>
        </div>
    </div>
</section>

<!-- TRUST BAR -->
<div class="lp-trust">
    <span class="lp-trust__item">
        <i class="fas fa-shield-halved"></i>Données sécurisées
    </span>
    <span class="lp-trust__item">
        <i class="fas fa-bolt"></i>Envoi immédiat
    </span>
    <span class="lp-trust__item">
        <i class="fas fa-user-tie"></i>Expert local certifié
    </span>
    <span class="lp-trust__item">
        <i class="fas fa-star"></i>+200 vendeurs accompagnés
    </span>
</div>

<!-- BÉNÉFICES -->
<section class="lp-benefits">
    <h2 class="lp-benefits__title">Ce que vous trouverez dans ce guide</h2>
    <div class="lp-benefits__grid">
        <?php foreach ($benefits as $b): ?>
        <div class="lp-benefit-card">
            <div class="lp-benefit-card__icon"><?= $b['icon'] ?></div>
            <div class="lp-benefit-card__title"><?= htmlspecialchars($b['title']) ?></div>
            <p class="lp-benefit-card__text"><?= htmlspecialchars($b['text']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- CTA répété -->
    <div class="lp-text-center lp-mt-16">
        <a href="#form-top" class="lp-btn-cta" style="max-width:360px;display:inline-block" data-track-cta>
            <i class="fas fa-arrow-up" style="margin-right:8px"></i>Télécharger gratuitement
        </a>
    </div>
</section>

<!-- PROOF -->
<section class="lp-proof">
    <div class="lp-proof__inner">
        <h3 class="lp-proof__title">Ce que disent nos vendeurs</h3>
        <div class="lp-testimonial">
            <p class="lp-testimonial__quote">
                "Grâce à ce guide j'ai pu fixer le bon prix dès le départ.
                Mon bien s'est vendu en 3 semaines, sans négociation."
            </p>
            <span class="lp-testimonial__author">
                — Isabelle M., vendeuse <?= $ville ? "à $ville" : '' ?>
            </span>
        </div>
    </div>
</section>

<!-- ADVISOR -->
<?php if ($advisorName): ?>
<section class="lp-advisor">
    <div class="lp-advisor__inner">
        <img src="<?= rtrim(APP_URL, '/') ?>/assets/images/advisor-avatar.jpg"
             alt="Photo <?= $advisorName ?>"
             class="lp-advisor__avatar"
             onerror="this.style.background='#e5e7eb';this.src=''">
        <div>
            <div class="lp-advisor__name"><?= $advisorName ?></div>
            <div class="lp-advisor__title">Conseiller immobilier indépendant<?= $ville ? " — $ville" : '' ?></div>
            <p class="lp-advisor__bio">
                Spécialiste du marché local, je vous accompagne à chaque étape
                de votre projet immobilier avec transparence et expertise.
            </p>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FAQ (si définie) -->
<?php if (!empty($funnel['faq_json'])): ?>
<section class="lp-faq lp-container">
    <h3 class="lp-faq__title">Questions fréquentes</h3>
    <?php foreach ($funnel['faq_json'] as $faq): ?>
    <div class="lp-faq__item">
        <div class="lp-faq__question">
            <?= htmlspecialchars($faq['q'] ?? '') ?>
            <i class="fas fa-chevron-down" style="font-size:.8rem;flex-shrink:0"></i>
        </div>
        <div class="lp-faq__answer"><?= htmlspecialchars($faq['a'] ?? '') ?></div>
    </div>
    <?php endforeach; ?>
</section>
<?php endif; ?>

<!-- DISCLAIMER estimation légal -->
<?php if (!empty($funnel['form_type']) && $funnel['form_type'] === 'estimation'): ?>
<div class="lp-disclaimer">
    <strong>Information légale :</strong>
    Les valeurs indicatives présentées sont issues d'algorithmes et ne constituent pas un
    <em>avis de valeur professionnel</em> au sens de la loi Hoguet.
    Pour une expertise officielle (succession, divorce, contentieux), seul un professionnel mandaté peut délivrer un avis de valeur.
</div>
<?php endif; ?>
