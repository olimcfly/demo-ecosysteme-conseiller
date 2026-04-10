<?php
if (!function_exists('isActive')) {
    function isActive($path, $currentUri = null) {
        if ($currentUri === null) {
            $currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }
        return $currentUri === $path || strpos($currentUri, $path) === 0;
    }
}
if (!function_exists('url')) {
    function url($path) { return $path; }
}

$currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

/*
 * Structure des items :
 *   path   — utilisé pour isActive()
 *   href   — null = item désactivé (span), false = pas de lien parent (button)
 *   label  — texte affiché
 *   sub    — sous-menu : peut contenir des items de type 'label' (séparateur)
 *   wide   — true = dropdown plus large (deux colonnes)
 *   type   — 'label' = séparateur de section (non cliquable)
 */
$navItems = [

    // ── Accueil ──────────────────────────────────────────────────
    [
        'path'  => '/',
        'href'  => url('/'),
        'label' => 'Accueil',
    ],

    // ── Nos biens ────────────────────────────────────────────────
    [
        'path'  => '/biens',
        'href'  => url('/biens'),
        'label' => 'Nos biens',
        'sub'   => [
            ['path' => '/biens',              'href' => url('/biens'),              'label' => 'Tous les biens'],
            ['path' => '/biens/maisons',      'href' => url('/biens/maisons'),      'label' => 'Maisons'],
            ['path' => '/biens/appartements', 'href' => url('/biens/appartements'), 'label' => 'Appartements'],
            ['path' => '/biens/prestige',     'href' => url('/biens/prestige'),     'label' => 'Prestige'],
            ['path' => '/biens/vendus',       'href' => url('/biens/vendus'),       'label' => 'Biens vendus'],
        ],
    ],

    // ── Secteurs ─────────────────────────────────────────────────
    [
        'path'  => '/secteurs',
        'href'  => url('/secteurs'),
        'label' => 'Secteurs',
        'wide'  => true,
        'sub'   => [
            // ── Section Villes ────────────────────────────────────
            ['type' => 'label', 'label' => 'Villes'],
            ['path' => '/secteurs/villes/aix-en-provence', 'href' => url('/secteurs/villes/aix-en-provence'), 'label' => 'Aix-en-Provence'],
            ['path' => '/secteurs/villes/venelles',        'href' => url('/secteurs/villes/venelles'),        'label' => 'Venelles'],
            ['path' => '/secteurs/villes/bouc-bel-air',    'href' => url('/secteurs/villes/bouc-bel-air'),    'label' => 'Bouc-Bel-Air'],
            ['path' => '/secteurs/villes/le-tholonet',     'href' => url('/secteurs/villes/le-tholonet'),     'label' => 'Le Tholonet'],
            ['path' => '/secteurs/villes/eguilles',        'href' => url('/secteurs/villes/eguilles'),        'label' => 'Eguilles'],
            ['path' => '/secteurs/villes/simiane-collongue','href' => url('/secteurs/villes/simiane-collongue'),'label' => 'Simiane-Collongue'],
            // ── Section Quartiers ─────────────────────────────────
            ['type' => 'label', 'label' => "Quartiers d'Aix"],
            ['path' => '/secteurs/quartiers/mazarin',        'href' => url('/secteurs/quartiers/mazarin'),        'label' => 'Mazarin'],
            ['path' => '/secteurs/quartiers/centre-ville',   'href' => url('/secteurs/quartiers/centre-ville'),   'label' => 'Centre-ville'],
            ['path' => '/secteurs/quartiers/puyricard',      'href' => url('/secteurs/quartiers/puyricard'),      'label' => 'Puyricard'],
            ['path' => '/secteurs/quartiers/jas-de-bouffan', 'href' => url('/secteurs/quartiers/jas-de-bouffan'), 'label' => 'Jas de Bouffan'],
            // ── Voir tous ─────────────────────────────────────────
            ['type' => 'divider'],
            ['path' => '/secteurs', 'href' => url('/secteurs'), 'label' => '→ Voir tous les secteurs'],
        ],
    ],

    // ── Vendre ───────────────────────────────────────────────────
    [
        'path'  => '/estimation-gratuite',
        'href'  => false,
        'label' => 'Vendre',
        'sub' => [
            ['path' => '/vendre', 'href' => url('/vendre'), 'label' => 'Vendre mon bien'],
            ['path' => '/estimation-gratuite', 'href' => url('/estimation-gratuite'), 'label' => 'Estimation gratuite'],
            ['path' => '/services', 'href' => url('/ressources/guide-vendeur'), 'label' => 'Méthode de vente'],
            ['path' => '/services', 'href' => url('/services'), 'label' => 'Mise en valeur du bien'],
            ['path' => '/services', 'href' => url('/services#faq-vendeur'), 'label' => 'FAQ vendeur'],
        ],
    ],
    [
        'path' => '/acheter',
        'href' => url('/acheter'),
        'label' => 'Acheter',
        'sub' => [
            ['path' => '/acheter', 'href' => url('/acheter'), 'label' => 'Acheter un bien'],
            ['path' => '/biens', 'href' => url('/biens'), 'label' => 'Nos biens disponibles'],
            ['path' => '/acheter', 'href' => url('/ressources/guide-acheteur'), 'label' => 'Accompagnement acquéreur'],
            ['path' => '/acheter', 'href' => url('/contact?sujet=Recherche+personnalisee'), 'label' => 'Recherche personnalisée'],
            ['path' => '/acheter', 'href' => url('/acheter#faq-acheteur'), 'label' => 'FAQ acheteur'],
        ],
    ],
    [
        'path' => '/financement',
        'href' => url('/financement'),
        'label' => 'Financement',
        'sub' => [
            ['path' => '/financement', 'href' => url('/financement'), 'label' => 'Financer mon projet'],
            ['path' => '/financement', 'href' => url('/financement#formulaire-financement'), 'label' => 'Déposer ma demande'],
            ['path' => '/financement', 'href' => url('/financement#etapes-financement'), 'label' => 'Comment ça fonctionne'],
            ['path' => '/financement', 'href' => url('/financement#faq-financement'), 'label' => 'FAQ financement'],
        ],
    ],

    // ── Guide local ──────────────────────────────────────────────
    [
        'path'  => '/guide-local',
        'href'  => url('/guide-local'),
        'label' => 'Guide local',
    ],

    // ── Blog ─────────────────────────────────────────────────────
    [
        'path'  => '/blog',
        'href'  => url('/blog'),
        'label' => 'Blog',
    ],

    // ── À propos ─────────────────────────────────────────────────
    [
        'path'  => '/a-propos',
        'href'  => url('/a-propos'),
        'label' => 'À propos',
    ],
];
?>

<!-- ── Navigation desktop ─────────────────────────────────────── -->
<nav class="nav" id="nav" aria-label="Menu principal">
    <ul class="nav__list">
        <?php foreach ($navItems as $item): ?>
        <li class="nav__item <?= !empty($item['sub']) ? 'has-submenu' : '' ?>">

            <?php if (!empty($item['sub'])): ?>
                <?php if ($item['href'] !== false && $item['href'] !== null): ?>
                    <a href="<?= htmlspecialchars($item['href']) ?>"
                       class="nav__toggle <?= isActive($item['path'], $currentUri) ? 'active' : '' ?>">
                        <span><?= htmlspecialchars($item['label']) ?></span>
                        <span class="nav__caret" aria-hidden="true">▾</span>
                    </a>
                <?php else: ?>
                    <button class="nav__toggle <?= isActive($item['path'], $currentUri) ? 'active' : '' ?>"
                            type="button" aria-haspopup="true" aria-expanded="false">
                        <span><?= htmlspecialchars($item['label']) ?></span>
                        <span class="nav__caret" aria-hidden="true">▾</span>
                    </button>
                <?php endif; ?>

                <ul class="submenu <?= !empty($item['wide']) ? 'submenu--wide' : '' ?>">
                    <?php foreach ($item['sub'] as $sub): ?>
                        <?php if (($sub['type'] ?? '') === 'label'): ?>
                            <li class="submenu__section-label"><?= htmlspecialchars($sub['label']) ?></li>
                        <?php elseif (($sub['type'] ?? '') === 'divider'): ?>
                            <li class="submenu__divider" role="separator"></li>
                        <?php elseif ($sub['href'] === null): ?>
                            <li><span class="submenu__link disabled-link"><?= htmlspecialchars($sub['label']) ?></span></li>
                        <?php else: ?>
                            <li>
                                <a href="<?= htmlspecialchars($sub['href']) ?>"
                                   class="submenu__link <?= isActive($sub['path'], $currentUri) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($sub['label']) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>

            <?php elseif ($item['href'] === null): ?>
                <span class="nav__link disabled-link"><?= htmlspecialchars($item['label']) ?></span>
            <?php else: ?>
                <a href="<?= htmlspecialchars($item['href']) ?>"
                   class="nav__link <?= ($item['path'] === '/' ? $currentUri === '/' : isActive($item['path'], $currentUri)) ? 'active' : '' ?>">
                    <?= htmlspecialchars($item['label']) ?>
                </a>
            <?php endif; ?>

        </li>
        <?php endforeach; ?>
    </ul>
</nav>

<!-- ── Navigation mobile ──────────────────────────────────────── -->
<div class="nav-mobile" id="nav-mobile" aria-hidden="true">
    <button class="nav-mobile__close" id="nav-close" aria-label="Fermer le menu">×</button>

    <ul class="nav-mobile__list">
        <?php foreach ($navItems as $item): ?>
        <li class="nav-mobile__item">

            <?php if (!empty($item['sub'])): ?>
                <button class="nav-mobile__toggle <?= isActive($item['path'], $currentUri) ? 'active' : '' ?>"
                        type="button" aria-expanded="false">
                    <span><?= htmlspecialchars($item['label']) ?></span>
                    <span class="nav-mobile__caret" aria-hidden="true">▾</span>
                </button>
                <ul class="mobile-sub" hidden>
                    <?php foreach ($item['sub'] as $sub): ?>
                        <?php if (($sub['type'] ?? '') === 'label'): ?>
                            <li class="mobile-sub__label"><?= htmlspecialchars($sub['label']) ?></li>
                        <?php elseif (($sub['type'] ?? '') === 'divider'): ?>
                            <li class="mobile-sub__divider"></li>
                        <?php elseif ($sub['href'] === null): ?>
                            <li><span class="disabled-link"><?= htmlspecialchars($sub['label']) ?></span></li>
                        <?php else: ?>
                            <li>
                                <a href="<?= htmlspecialchars($sub['href']) ?>"
                                   class="<?= isActive($sub['path'], $currentUri) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($sub['label']) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>

            <?php elseif ($item['href'] === null): ?>
                <span class="nav-mobile__link disabled-link"><?= htmlspecialchars($item['label']) ?></span>
            <?php else: ?>
                <a href="<?= htmlspecialchars($item['href']) ?>"
                   class="nav-mobile__link <?= ($item['path'] === '/' ? $currentUri === '/' : isActive($item['path'], $currentUri)) ? 'active' : '' ?>">
                    <?= htmlspecialchars($item['label']) ?>
                </a>
            <?php endif; ?>

        </li>
        <?php endforeach; ?>

        <li class="nav-mobile__cta-wrap">
            <a href="<?= htmlspecialchars(url('/avis-de-valeur')) ?>" class="btn btn--outline btn--full" style="margin-bottom:.5rem">
                Avis de valeur
            </a>
            <a href="<?= htmlspecialchars(url('/prendre-rendez-vous')) ?>" class="btn btn--primary btn--full">
                Prendre RDV
            </a>
        </li>

        <?php if (defined('APP_PHONE') && APP_PHONE): ?>
        <li style="padding:0 1rem .5rem">
            <a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', APP_PHONE)) ?>" class="btn btn--outline btn--full">
                📞 <?= htmlspecialchars(APP_PHONE) ?>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</div>

<div class="nav-overlay" id="nav-overlay"></div>
