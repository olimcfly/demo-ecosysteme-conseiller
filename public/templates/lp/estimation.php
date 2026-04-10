<?php
$advisorName = trim((string)($page['advisor_name'] ?? '')) ?: trim((string)(setting('advisor_firstname', '') . ' ' . setting('advisor_lastname', '')));
$advisorPhone = trim((string)($page['advisor_phone'] ?? '')) ?: trim((string)setting('advisor_phone', ''));
$advisorZone = trim((string)($page['advisor_zone'] ?? '')) ?: trim((string)setting('zone_city', ''));
$advisorPhoto = trim((string)($page['advisor_photo_webp'] ?? ''));

$advisorBio = trim((string)($page['advisor_bio'] ?? '')) ?: trim((string)setting('advisor_bio', ''));
$companyName = trim((string)($page['company_name'] ?? '')) ?: trim((string)setting('agency_name', ''));
$legalUrl = trim((string)($page['legal_url'] ?? '/mentions-legales'));
$privacyUrl = trim((string)($page['privacy_url'] ?? '/politique-confidentialite'));
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e((string)$page['headline']) ?></title>
    <meta name="description" content="<?= e((string)$page['sous_titre']) ?>">
    <style>
        :root{--bg:#f8fafc;--txt:#0f172a;--muted:#475569;--pri:#0f766e;--card:#fff;--ok:#16a34a}
        *{box-sizing:border-box} body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:var(--bg);color:var(--txt);line-height:1.45}
        .container{max-width:980px;margin:0 auto;padding:16px}.card{background:var(--card);border-radius:14px;box-shadow:0 8px 24px rgba(15,23,42,.08)}
        .hero{display:grid;gap:14px}.logo{font-weight:700;font-size:1rem}.h1{font-size:1.7rem;line-height:1.2;margin:.25rem 0}.sub{color:var(--muted);margin:0}
        .form{padding:16px;display:grid;gap:10px}.input,select,button{width:100%;padding:12px;border-radius:10px;border:1px solid #cbd5e1;font:inherit}
        button{background:var(--pri);color:#fff;border:none;font-weight:700}.consent{font-size:.9rem;color:var(--muted)}
        .cta{position:sticky;bottom:0;background:#fff;padding:8px 0}.grid3{display:grid;gap:10px}.list,.steps{display:grid;gap:10px;padding:16px}
        .badge{display:inline-block;background:#ecfeff;color:#155e75;padding:5px 8px;border-radius:999px;font-weight:600;font-size:.82rem}
        .advisor{display:grid;grid-template-columns:84px 1fr;gap:12px;align-items:start;padding:16px}.avatar{width:84px;height:84px;border-radius:50%;object-fit:cover;background:#e2e8f0}
        .reviews{display:grid;gap:10px;padding:16px}.review{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px}
        footer{font-size:.9rem;color:var(--muted);padding:20px 0;text-align:center}
        @media (min-width: 768px){.hero{grid-template-columns:1.15fr .85fr;align-items:start}.h1{font-size:2.1rem}.grid3{grid-template-columns:repeat(3,1fr)}}
    </style>
</head>
<body>
<main class="container">
    <section class="hero">
        <div>
            <div class="logo"><?= e($companyName ?: $advisorName) ?></div>
            <h1 class="h1"><?= e((string)$page['headline']) ?></h1>
            <p class="sub"><?= e((string)$page['sous_titre']) ?></p>
            <p><span class="badge">Recevez votre avis de valeur gratuit (non certifié)</span></p>
        </div>
        <form class="form card" method="post" action="/lp/<?= e((string)$page['slug']) ?>">
            <?php if ($success): ?><p style="color:var(--ok);margin:0">Merci, vous serez contacté sous 24h.</p><?php endif; ?>
            <?php foreach ($errors as $error): ?><p style="margin:0;color:#b91c1c"><?= e((string)$error) ?></p><?php endforeach; ?>
            <input type="hidden" name="utm_source" value="<?= e((string)($_GET['utm_source'] ?? '')) ?>">
            <input type="hidden" name="utm_medium" value="<?= e((string)($_GET['utm_medium'] ?? '')) ?>">
            <input type="hidden" name="utm_campaign" value="<?= e((string)($_GET['utm_campaign'] ?? '')) ?>">
            <label>Type de bien
                <select name="property_type" required>
                    <option value="">Choisir</option>
                    <?php foreach (['maison'=>'Maison','appartement'=>'Appartement','terrain'=>'Terrain'] as $k => $label): ?>
                        <option value="<?= $k ?>" <?= (($old['property_type'] ?? '') === $k) ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Surface approximative (m²)
                <input class="input" type="number" min="8" max="2000" name="surface" value="<?= e((string)($old['surface'] ?? '')) ?>" required>
            </label>
            <label>Votre email ou téléphone
                <input class="input" type="text" name="contact" value="<?= e((string)($old['contact'] ?? '')) ?>" required>
            </label>
            <label class="consent"><input type="checkbox" name="rgpd_consent" value="1" <?= !empty($old['rgpd_consent']) ? 'checked' : '' ?> required> En soumettant ce formulaire, vous acceptez d'être contacté par <?= e($advisorName) ?> concernant votre projet immobilier. <a href="<?= e($privacyUrl) ?>">Politique de confidentialité</a>.</label>
            <div class="cta"><button type="submit">Recevoir mon avis de valeur gratuit</button></div>
        </form>
    </section>

    <section class="card list" style="margin-top:14px">
        <h2>Pourquoi faire votre demande ici ?</h2>
        <div class="grid3">
            <div>✅ Gratuit et sans engagement</div>
            <div>✅ Avis de valeur sous 24h</div>
            <div>✅ Conseiller local expert de <?= e((string)$page['ville']) ?></div>
        </div>
    </section>

    <section class="card advisor" style="margin-top:14px">
        <?php if ($advisorPhoto !== ""): ?><img loading="lazy" class="avatar" src="<?= e($advisorPhoto) ?>" alt="<?= e($advisorName) ?>"><?php else: ?><div class="avatar"></div><?php endif; ?>
        <div>
            <h2 style="margin:.2rem 0"><?= e($advisorName) ?></h2>
            <p style="margin:.2rem 0;color:var(--muted)"><?= e($advisorBio ?: 'Conseiller indépendant spécialisé sur votre secteur, je vous accompagne avec des avis de valeur réalistes et argumentés.') ?></p>
            <p style="margin:.2rem 0"><a href="tel:<?= e(preg_replace('/\s+/', '', $advisorPhone)) ?>"><?= e($advisorPhone) ?></a></p>
            <p style="margin:.2rem 0">Zone d'intervention : <?= e($advisorZone ?: (string)$page['ville']) ?></p>
        </div>
    </section>

    <section class="card steps" style="margin-top:14px">
        <h2>Ce qui se passe ensuite</h2>
        <div>1. Vous remplissez le formulaire (2 min)</div>
        <div>2. Je prépare votre avis de valeur personnalisé</div>
        <div>3. On en discute ensemble, sans pression</div>
    </section>

    <section class="card reviews" style="margin-top:14px">
        <h2>Avis clients</h2>
        <?php if (!empty($page['review_1_text'])): ?><article class="review"><strong><?= e((string)$page['review_1_firstname']) ?> — <?= e((string)$page['review_1_city']) ?></strong><p><?= e((string)$page['review_1_text']) ?></p></article><?php endif; ?>
        <?php if (!empty($page['review_2_text'])): ?><article class="review"><strong><?= e((string)$page['review_2_firstname']) ?> — <?= e((string)$page['review_2_city']) ?></strong><p><?= e((string)$page['review_2_text']) ?></p></article><?php endif; ?>
    </section>

    <footer>
        <div><?= e($companyName ?: $advisorName) ?></div>
        <a href="<?= e($legalUrl) ?>">Mentions légales</a> • <a href="<?= e($privacyUrl) ?>">Politique de confidentialité</a>
    </footer>
</main>
</body>
</html>
