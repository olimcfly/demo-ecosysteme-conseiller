<?php
// config.php

// Configuration par défaut
$defaultConfig = [
    'pageTitle' => 'Titre par défaut',
    'metaDesc' => 'Description par défaut',
    'metaKeywords' => 'mots-clés, par, défaut',
    'extraCss' => ['/public/assets/css/style.css'],
    'extraJs' => []
];

// Configurations spécifiques aux pages
$pageConfigs = [
    'biens' => [
        'pageTitle' => 'Nos biens immobiliers à Aix-en-Provence — Pascal Hamm | Vente & Location',
        'metaDesc' => 'Découvrez notre sélection exclusive de biens immobiliers à Aix-en-Provence et dans le Pays d\'Aix : appartements, maisons, terrains et locaux commerciaux.',
        'metaKeywords' => 'biens immobiliers Aix-en-Provence, appartements à vendre Aix-en-Provence, maisons Aix-en-Provence, immobilier Pays d\'Aix, acheter Aix-en-Provence, location Aix-en-Provence',
        'extraCss' => ['/public/assets/css/style.css'],
        'extraJs' => []
    ],
    'contact' => [
        'pageTitle' => 'Contactez-nous — Pascal Hamm | Vente & Location',
        'metaDesc' => 'Contactez-nous pour toutes vos questions concernant l\'immobilier à Aix-en-Provence et dans le Pays d\'Aix.',
        'metaKeywords' => 'contact immobilier Aix-en-Provence, contacter agent immobilier, Pascal Hamm contact',
        'extraCss' => ['/public/assets/css/style.css'],
        'extraJs' => []
    ],
    'estimation' => [
        'pageTitle' => 'Estimation gratuite — Pascal Hamm | Vente & Location',
        'metaDesc' => 'Obtenez une estimation gratuite de votre bien immobilier à Aix-en-Provence et dans le Pays d\'Aix.',
        'metaKeywords' => 'estimation immobilière Aix-en-Provence, estimation gratuite, Pascal Hamm estimation',
        'extraCss' => ['/public/assets/css/style.css'],
        'extraJs' => []
    ],
    'guide' => [
        'pageTitle' => 'Guide de l\'immobilier — Pascal Hamm | Vente & Location',
        'metaDesc' => 'Découvrez notre guide complet de l\'immobilier à Aix-en-Provence et dans le Pays d\'Aix.',
        'metaKeywords' => 'guide immobilier Aix-en-Provence, Pascal Hamm guide, immobilier Pays d\'Aix',
        'extraCss' => ['/public/assets/css/style.css'],
        'extraJs' => []
    ],
    'secteurs' => [
        'pageTitle' => 'Secteurs immobiliers — Pascal Hamm | Vente & Location',
        'metaDesc' => 'Découvrez les différents secteurs immobiliers à Aix-en-Provence et dans le Pays d\'Aix.',
        'metaKeywords' => 'secteurs immobiliers Aix-en-Provence, Pascal Hamm secteurs, immobilier Pays d\'Aix',
        'extraCss' => ['/public/assets/css/style.css'],
        'extraJs' => []
    ],
    'home' => [
        'pageTitle' => 'Accueil — Pascal Hamm | Vente & Location',
        'metaDesc' => 'Bienvenue sur le site de Pascal Hamm, votre expert immobilier à Aix-en-Provence et dans le Pays d\'Aix.',
        'metaKeywords' => 'immobilier Aix-en-Provence, Pascal Hamm, vente location Aix-en-Provence',
        'extraCss' => ['/public/assets/css/style.css'],
        'extraJs' => []
    ]
];

function getPageConfig($pageName) {
    global $defaultConfig, $pageConfigs;

    // Retourner la configuration par défaut si la page n'est pas trouvée
    if (!isset($pageConfigs[$pageName])) {
        return $defaultConfig;
    }

    // Fusionner la configuration par défaut avec la configuration spécifique à la page
    return array_merge($defaultConfig, $pageConfigs[$pageName]);
}
