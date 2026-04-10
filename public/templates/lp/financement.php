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
        :root{--bg:#f8fafc;--txt:#0f172a;--muted:#475569;--pri:#1d4ed8;--card:#fff;--ok:#16a34a}*{box-sizing:border-box}
        body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:var(--bg);color:var(--txt)}
        .container{max-width:980px;margin:0 auto;padding:16px}.card{background:#fff;border-radius:14px;box-shadow:0 8px 24px rgba(15,23,42,.08)}
        .hero{display:grid;gap:14px}.h1{font-size:1.7rem;line-height:1.2;margin:.25rem 0}.sub{color:var(--muted)}
        .form{padding:16px;display:grid;gap:10px}.input,select,textarea,button{width:100%;padding:12px;border-radius:10px;border:1px solid #cbd5e1;font:inherit}
        button{background:var(--pri);color:#fff;border:none;font-weight:700}.small{font-size:.9rem;color:var(--muted)}
        .advisor{display:grid;grid-template-columns:84px 1fr;gap:12px;padding:16px}.avatar{width:84px;height:84px;border-radius:50%;object-fit:cover;background:#e2e8f0}
        .reviews,.steps,.list{padding:16px;display:grid;gap:10px}.review{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:10px}
        .grid3{display:grid;gap:10px}@media (min-width:768px){.hero{grid-template-columns:1.15fr .85fr}.h1{font-size:2.1rem}.grid3{grid-template-columns:repeat(3,1fr)}}
    </style>
</head>
<body>
<main class="container">
    <section class="hero">
        <div>
            <div style="font-weight:700"><?= e($companyName ?: $advisorName) ?></div>
            <h1 class="h1"><?= e((string)$page['headline']) ?></h1>
            <p class="sub"><?= e((string)$page['sous_titre']) ?></p>
        </div>
        <form class="form card" method="post" action="/lp/<?= e((string)$page['slug']) ?>">
            <?php if ($success): ?><p style="color:var(--ok);margin:0">Merci, nous vous rappelons sous 24h.</p><?php endif; ?>
            <?php foreach ($errors as $error): ?><p style="margin:0;color:#b91c1c"><?= e((string)$error) ?></p><?php endforeach; ?>
            <input type="hidden" name="utm_source" value="<?= e((string)($_GET['utm_source'] ?? '')) ?>">
            <input type="hidden" name="utm_medium" value="<?= e((string)($_GET['utm_medium'] ?? '')) ?>">
            <input type="hidden" name="utm_campaign" value="<?= e((string)($_GET['utm_campaign'] ?? '')) ?>">
            <label>Prénom<input class="input" type="text" name="first_name" value="<?= e((string)($old['first_name'] ?? '')) ?>" required></label>
            <label>Téléphone<input class="input" type="tel" name="phone" value="<?= e((string)($old['phone'] ?? '')) ?>" required></label>
            <label>Votre projet
                <select name="project_type" required>
                    <option value="">Choisir</option>
                    <option value="acheter" <?= (($old['project_type'] ?? '') === 'acheter') ? 'selected' : '' ?>>Je veux acheter</option>
                    <option value="renegocier" <?= (($old['project_type'] ?? '') === 'renegocier') ? 'selected' : '' ?>>Je veux renégocier</option>
                    <option value="investir" <?= (($old['project_type'] ?? '') === 'investir') ? 'selected' : '' ?>>Je veux investir</option>
                </select>
            </label>
            <label>Message (optionnel)<textarea name="message" rows="3" maxlength="400"><?= e((string)($old['message'] ?? '')) ?></textarea></label>
            <label class="small"><input type="checkbox" name="rgpd_consent" value="1" <?= !empty($old['rgpd_consent']) ? 'checked' : '' ?> required> En soumettant ce formulaire, vous acceptez d'être contacté par <?= e($advisorName) ?> concernant votre projet immobilier. <a href="<?= e($privacyUrl) ?>">Politique de confidentialité</a>.</label>
            <button type="submit">Je veux être rappelé gratuitement</button>
            <p class="small"><?= e($advisorName) ?> vous rappelle sous 24h pour étudier votre projet. Aucun engagement, aucun frais.</p>
        </form>
    </section>

    <section class="card list" style="margin-top:14px">
        <h2>Réassurance</h2>
        <div class="grid3"><div>✅ Gratuit et sans engagement</div><div>✅ Rappel sous 24h</div><div>✅ Expert local de <?= e((string)$page['ville']) ?></div></div>
    </section>

    <section class="card advisor" style="margin-top:14px">
        <?php if ($advisorPhoto !== ''): ?><img loading="lazy" class="avatar" src="<?= e($advisorPhoto) ?>" alt="<?= e($advisorName) ?>"><?php else: ?><div class="avatar"></div><?php endif; ?>
        <div>
            <h2 style="margin:.2rem 0"><?= e($advisorName) ?></h2>
            <p style="margin:.2rem 0;color:var(--muted)"><?= e($advisorBio ?: 'Conseiller indépendant, je vous accompagne sur votre capacité de financement et votre stratégie d achat.') ?></p>
            <p style="margin:.2rem 0"><a href="tel:<?= e(preg_replace('/\s+/', '', $advisorPhone)) ?>"><?= e($advisorPhone) ?></a></p>
            <p style="margin:.2rem 0">Zone d'intervention : <?= e($advisorZone ?: (string)$page['ville']) ?></p>
        </div>
    </section>

    <section class="card steps" style="margin-top:14px">
        <h2>Ce qui se passe ensuite</h2>
        <div>1. Vous remplissez le formulaire (2 min)</div>
        <div>2. Je prépare une première analyse de votre projet</div>
        <div>3. On échange ensemble, sans pression</div>
    </section>

    <section class="card reviews" style="margin-top:14px">
        <h2>Avis clients</h2>
        <?php if (!empty($page['review_1_text'])): ?><article class="review"><strong><?= e((string)$page['review_1_firstname']) ?> — <?= e((string)$page['review_1_city']) ?></strong><p><?= e((string)$page['review_1_text']) ?></p></article><?php endif; ?>
        <?php if (!empty($page['review_2_text'])): ?><article class="review"><strong><?= e((string)$page['review_2_firstname']) ?> — <?= e((string)$page['review_2_city']) ?></strong><p><?= e((string)$page['review_2_text']) ?></p></article><?php endif; ?>
    </section>

    <footer style="text-align:center;padding:20px 0;color:#64748b;font-size:.9rem">
        <div><?= e($companyName ?: $advisorName) ?></div>
        <a href="<?= e($legalUrl) ?>">Mentions légales</a> • <a href="<?= e($privacyUrl) ?>">Politique de confidentialité</a>
    </footer>
</main>
</body>
</html>
