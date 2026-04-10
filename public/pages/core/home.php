<?php
$pageTitle    = 'Immobilier Aix-en-Provence & Pays d\'Aix — Pascal Hamm | Vente, Achat, Estimation';
$metaDesc     = 'Expert immobilier indépendant à Aix-en-Provence : vente, achat, estimation immobilière et accompagnement 360° dans le Pays d\'Aix.';
$metaKeywords = 'immobilier Aix-en-Provence, expert immobilier Aix-en-Provence, estimation immobilière Aix-en-Provence, achat immobilier Pays d\'Aix, vente immobilière Pays d\'Aix, conseiller immobilier indépendant Pays d\'Aix';
$extraCss     = ['/assets/css/home.css', '/assets/css/mere.css'];

$featuredProperties = [
    [
        'title'  => 'Villa familiale avec jardin arboré',
        'city'   => 'Aix-en-Provence',
        'price'  => '895 000 €',
        'surface'=> '165 m²',
        'rooms'  => '5 pièces',
        'badge'  => 'Exclusivité',
        'image'  => '/assets/images/featured1.jpg',
    ],
    [
        'title'  => 'Appartement terrasse centre historique',
        'city'   => 'Aix-en-Provence',
        'price'  => '545 000 €',
        'surface'=> '88 m²',
        'rooms'  => '4 pièces',
        'badge'  => 'Nouveau',
        'image'  => '/assets/images/featured2.jpg',
    ],
    [
        'title'  => 'Maison provençale proche nature',
        'city'   => 'Le Tholonet',
        'price'  => '1 240 000 €',
        'surface'=> '210 m²',
        'rooms'  => '6 pièces',
        'badge'  => 'Coup de cœur',
        'image'  => '/assets/images/property2.jpg',
    ],
];
?>

<!-- ═══════════════════════════════════════════════════════════
     MERE:M — Hero : accroche, promesse, CTA
     Objectif : créer le désir, poser la promesse, inviter.
     ═══════════════════════════════════════════════════════════ -->
<section class="hero hero--premium" aria-labelledby="home-hero-title">
    <div class="hero__bg" style="background-image:linear-gradient(110deg, rgba(26,60,94,.92) 0%, rgba(15,38,68,.86) 58%, rgba(26,60,94,.92) 100%), url('/assets/images/hero-bg.jpg');"></div>
    <div class="container">
        <div class="hero__content" data-animate>
            <span class="section-label hero__label">Immobilier Aix-en-Provence · Pays d'Aix</span>
            <h1 id="home-hero-title">Vendre, acheter et estimer sereinement dans le Pays d'Aix, avec un conseiller local unique.</h1>
            <p class="hero__subtitle">Pascal Hamm vous accompagne de la stratégie jusqu'à la signature : estimation immobilière, vente et recherche ciblée d'opportunités à Aix-en-Provence.</p>
            <div class="hero__actions">
                <a href="/estimation-gratuite" class="btn btn--accent btn--lg">Demander une estimation gratuite</a>
                <a href="/biens" class="btn btn--outline-white btn--lg">Voir les biens à vendre</a>
            </div>
            <div class="hero__pillars" role="list" aria-label="Domaines d'expertise">
                <span role="listitem">Vente</span>
                <span role="listitem">Achat</span>
                <span role="listitem">Estimation</span>
                <span role="listitem">Accompagnement 360°</span>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:M — Stat Strip : crédibilité immédiate
     Objectif : ancrer la confiance en 4 chiffres, sans bruit.
     ═══════════════════════════════════════════════════════════ -->
<div class="stat-strip" role="region" aria-label="Chiffres clés">
    <div class="container">
        <div class="stat-strip__inner">
            <div class="stat-item">
                <span class="stat-item__value">4,9/5</span>
                <span class="stat-item__label">Avis clients Google</span>
            </div>
            <div class="stat-item">
                <span class="stat-item__value">Pays d'Aix</span>
                <span class="stat-item__label">Expertise terrain locale</span>
            </div>
            <div class="stat-item">
                <span class="stat-item__value">24h</span>
                <span class="stat-item__label">Délai de réponse</span>
            </div>
            <div class="stat-item">
                <span class="stat-item__value">360°</span>
                <span class="stat-item__label">Accompagnement complet</span>
            </div>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     MERE:M+E — Réalité prospect : douleurs nommées, enjeux posés
     Objectif : montrer qu'on comprend le projet et ses vraies contraintes.
     ═══════════════════════════════════════════════════════════ -->
<section class="section section--alt" id="realite-prospect">
    <div class="container">
        <div class="section__header">
            <span class="section-label">Votre réalité immobilière</span>
            <h2 class="section-title">Vous avez un projet sérieux.<br>Vous méritez un accompagnement à la hauteur.</h2>
            <p class="section-subtitle">Vendre sans brader, acheter au bon prix, éviter les erreurs administratives : ce sont les vraies préoccupations des propriétaires et acquéreurs à Aix-en-Provence.</p>
        </div>
        <div class="grid-3">
            <article class="card" data-animate>
                <div class="card__body">
                    <h3 class="card__title">Vendre au bon prix</h3>
                    <p class="card__text">Vous voulez une estimation fiable, pas un prix vitrine. L'objectif : vendre dans les bonnes conditions et dans un délai cohérent avec votre projet.</p>
                </div>
            </article>
            <article class="card" data-animate>
                <div class="card__body">
                    <h3 class="card__title">Trouver les bonnes opportunités</h3>
                    <p class="card__text">Le marché bouge vite. Les biens qualitatifs partent rapidement. Vous avez besoin d'un tri pertinent et d'un accès aux opportunités locales avant tout le monde.</p>
                </div>
            </article>
            <article class="card" data-animate>
                <div class="card__body">
                    <h3 class="card__title">Réduire la charge mentale</h3>
                    <p class="card__text">Visites, négociation, compromis, suivi notaire : vous ne voulez pas gérer seul chaque détail ni prendre de risques inutiles sur une décision de cette ampleur.</p>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:E — Distinction : accompagné vs seul, concrètement
     Objectif : clarifier ce qui change avant de montrer la méthode.
     ═══════════════════════════════════════════════════════════ -->
<section class="section" id="distinction">
    <div class="container">
        <div class="section__header text-center">
            <span class="section-label">Ce qui change vraiment</span>
            <h2 class="section-title">Avec ou sans un conseiller indépendant : la différence concrète.</h2>
            <p class="section-subtitle">Pas une question d'honoraires. Une question de résultat, de sécurité et de tranquillité d'esprit.</p>
        </div>
        <div class="grid-2 insight-grid">
            <article class="insight-card insight-card--gain" data-animate>
                <span class="insight-card__tag">Avec accompagnement</span>
                <h3>Un projet structuré, sécurisé, sans mauvaise surprise.</h3>
                <ul>
                    <li>Estimation fondée sur les données réelles du marché local</li>
                    <li>Stratégie de commercialisation ou de recherche sur mesure</li>
                    <li>Négociation cadrée, argumentée, documentée</li>
                    <li>Un interlocuteur unique de la première discussion jusqu'à la signature</li>
                </ul>
            </article>
            <article class="insight-card insight-card--risk" data-animate>
                <span class="insight-card__tag">Sans accompagnement</span>
                <h3>Des risques réels sur une décision à fort impact.</h3>
                <ul>
                    <li>Surestimation ou sous-estimation du bien fréquente</li>
                    <li>Visibilité limitée aux portails généralistes</li>
                    <li>Négociation souvent subie, sans données pour tenir</li>
                    <li>Charge administrative et juridique portée seul, jusqu'au notaire</li>
                </ul>
            </article>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:E+R — Pascal Hamm : la personne derrière la méthode
     Objectif : humaniser, crédibiliser, préparer le passage à la Recette.
     ═══════════════════════════════════════════════════════════ -->
<section class="section section--alt">
    <div class="container grid-2 about-split">
        <div data-animate>
            <span class="section-label">Votre conseiller</span>
            <h2 class="section-title">Pascal Hamm — conseiller immobilier indépendant, Pays d'Aix.</h2>
            <p>Interlocuteur unique, Pascal accompagne les projets d'achat, de vente et d'estimation immobilière à Aix-en-Provence et dans le Pays d'Aix avec une approche humaine, structurée et rigoureuse.</p>
            <ul class="benefits-list">
                <li>Expert local : Aix-en-Provence, Le Tholonet, Ventabren, Luynes, Puyricard.</li>
                <li>Accompagnement 360° : stratégie, commercialisation, négociation, sécurisation.</li>
                <li>Suivi personnalisé du premier échange jusqu'à la signature chez le notaire.</li>
            </ul>
            <a href="/a-propos" class="btn btn--outline">Découvrir son parcours</a>
        </div>
        <figure class="about-photo">
            <img src="/assets/images/pascal-hamm-immobiliier.jpeg" alt="Pascal Hamm, conseiller immobilier au Pays d'Aix" loading="lazy">
        </figure>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:R — Méthode : le process en 5 étapes
     Objectif : rendre la solution tangible, concrète, rassurante.
     ═══════════════════════════════════════════════════════════ -->
<section class="section" id="methode">
    <div class="container">
        <div class="section__header text-center">
            <span class="section-label">La méthode Pascal Hamm</span>
            <h2 class="section-title">Une méthode claire en 5 étapes pour sécuriser votre projet.</h2>
            <p class="section-subtitle">Chaque étape a une fonction précise. Rien n'est improvisé.</p>
        </div>
        <div class="grid-5-steps">
            <?php foreach ([
                ['01', 'Comprendre votre projet',         'Objectifs, contraintes, timing et contexte familial ou patrimonial.'],
                ['02', 'Définir la stratégie',             'Positionnement prix, plan de commercialisation ou cahier de recherche acheteur.'],
                ['03', 'Valoriser ou cibler',              'Mise en valeur du bien vendeur ou sélection affinée des biens acheteur.'],
                ['04', 'Négocier et sécuriser',            'Négociation argumentée, vérifications et cadre juridique sécurisé.'],
                ['05', 'Accompagner jusqu\'à la signature','Suivi notarial, coordination des parties et pilotage jusqu\'à l\'acte authentique.'],
            ] as $step): ?>
            <article class="step-card" data-animate>
                <span class="step-card__num"><?= e($step[0]) ?></span>
                <h3><?= e($step[1]) ?></h3>
                <p><?= e($step[2]) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-32">
            <a href="/contact" class="btn btn--primary">Réserver un rendez-vous</a>
            <a href="/secteurs" class="btn btn--outline">Consulter les secteurs</a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:R support — Preuves sociales : les avis clients
     Objectif : valider la méthode par des résultats réels.
     ═══════════════════════════════════════════════════════════ -->
<section class="section section--alt" id="preuves-sociales">
    <div class="container">
        <div class="section__header">
            <span class="section-label">Ils l'ont fait</span>
            <h2 class="section-title">Des résultats concrets, des avis authentiques.</h2>
        </div>
        <div class="grid-3">
            <article class="testimonial" data-animate>
                <div class="testimonial__stars">★★★★★</div>
                <p class="testimonial__text">"Accompagnement clair du début à la fin. Notre vente à Aix-en-Provence a été structurée, fluide et sécurisée."</p>
                <p class="testimonial__author">Sophie & Marc — Vente</p>
            </article>
            <article class="testimonial" data-animate>
                <div class="testimonial__stars">★★★★★</div>
                <p class="testimonial__text">"Nous avons acheté dans le Pays d'Aix avec une vraie stratégie. Pascal a filtré efficacement les biens, on a gagné beaucoup de temps."</p>
                <p class="testimonial__author">Julie R. — Achat</p>
            </article>
            <article class="testimonial" data-animate>
                <div class="testimonial__stars">★★★★★</div>
                <p class="testimonial__text">"Estimation immobilière très précise, communication excellente, et un interlocuteur vraiment disponible à chaque étape."</p>
                <p class="testimonial__author">Nicolas T. — Estimation</p>
            </article>
        </div>
        <div class="text-center mt-32">
            <a href="/avis-clients" class="btn btn--outline">Voir tous les avis clients</a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:R — Biens en vente : l'offre réelle
     Objectif : concrétiser la méthode par des biens réels.
     ═══════════════════════════════════════════════════════════ -->
<section class="section" id="biens-en-vente">
    <div class="container">
        <div class="section__header">
            <span class="section-label">Biens sélectionnés</span>
            <h2 class="section-title">Des opportunités à Aix-en-Provence et dans le Pays d'Aix.</h2>
            <p class="section-subtitle">Chaque bien est présenté avec ses informations clés pour vous permettre une décision rapide et éclairée.</p>
        </div>
        <div class="grid-3">
            <?php foreach ($featuredProperties as $property): ?>
            <article class="card property-card-premium">
                <img class="card__img" src="<?= e($property['image']) ?>" alt="<?= e($property['title']) ?> à <?= e($property['city']) ?>" loading="lazy">
                <div class="card__body">
                    <span class="property-badge"><?= e($property['badge']) ?></span>
                    <h3 class="card__title"><?= e($property['title']) ?></h3>
                    <p class="card__text property-meta"><?= e($property['city']) ?> · <?= e($property['surface']) ?> · <?= e($property['rooms']) ?></p>
                    <p class="property-price"><?= e($property['price']) ?></p>
                    <a href="/biens" class="btn btn--primary btn--sm">Voir le bien</a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-32">
            <a href="/biens" class="btn btn--outline btn--lg">Voir tous les biens disponibles</a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:E — Marché local : comprendre le contexte (SEO + pédagogie)
     Objectif : éduquer, rassurer, positionner l'expertise.
     ═══════════════════════════════════════════════════════════ -->
<section class="section section--alt" id="marche-immobilier-aix">
    <div class="container">
        <div class="section__header">
            <span class="section-label">Le marché local</span>
            <h2 class="section-title">Immobilier à Aix-en-Provence : comprendre le marché</h2>
            <p class="section-subtitle">
                Le marché immobilier à Aix-en-Provence est l'un des plus actifs de la région Provence-Alpes-Côte d'Azur,
                avec une demande structurellement supérieure à l'offre dans les secteurs les plus recherchés.
            </p>
        </div>
        <div class="grid-3">
            <article class="card">
                <div class="card__body">
                    <h3 class="card__title">Un marché porteur et exigeant</h3>
                    <p class="card__text">
                        Les prix se maintiennent entre 3 500 et 6 000 €/m² selon les quartiers. Maisons avec extérieur,
                        appartements bien situés et biens de prestige restent très recherchés. Un positionnement prix juste
                        est déterminant pour attirer des acheteurs sérieux dans des délais raisonnables.
                    </p>
                </div>
            </article>
            <article class="card">
                <div class="card__body">
                    <h3 class="card__title">Des acheteurs bien informés</h3>
                    <p class="card__text">
                        Les acquéreurs aixois connaissent les prix pratiqués et n'hésitent pas à négocier si le bien est surestimé.
                        Une estimation immobilière réaliste, fondée sur des données objectives, est indispensable
                        avant toute mise en vente.
                    </p>
                </div>
            </article>
            <article class="card">
                <div class="card__body">
                    <h3 class="card__title">Aix-en-Provence et le Pays d'Aix</h3>
                    <p class="card__text">
                        Venelles, Luynes, Puyricard, Le Tholonet, Eguilles, Bouc-Bel-Air : chaque commune a ses propres
                        réalités de marché et ses profils d'acheteurs. Une connaissance fine du territoire est indispensable
                        pour conduire une transaction dans de bonnes conditions.
                    </p>
                </div>
            </article>
        </div>
        <div class="text-center mt-32">
            <a href="/estimation-gratuite" class="btn btn--primary">Obtenir une estimation de mon bien</a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:E — Comment vendre : pédagogie actionnable
     Objectif : donner les clés au prospect, poser l'expertise.
     ═══════════════════════════════════════════════════════════ -->
<section class="section" id="comment-vendre-bien-immobilier">
    <div class="container">
        <div class="section__header">
            <span class="section-label">Vendre sereinement</span>
            <h2 class="section-title">Comment vendre un bien immobilier à Aix-en-Provence</h2>
            <p class="section-subtitle">
                Une vente réussie ne s'improvise pas. De l'estimation aux diagnostics, de la mise en valeur à la négociation,
                chaque étape demande méthode et disponibilité.
            </p>
        </div>
        <div class="grid-2 sell-guide">
            <div class="sell-guide__item">
                <h3 class="sell-guide__step">1. Estimer juste, pas haut</h3>
                <p>Un prix surestimé génère peu de visites, aucune offre, et force à baisser après plusieurs semaines — au détriment de la crédibilité de l'annonce. Une estimation sérieuse compare les transactions récentes et anticipe ce que des acheteurs réels sont prêts à payer aujourd'hui.</p>
            </div>
            <div class="sell-guide__item">
                <h3 class="sell-guide__step">2. Préparer les documents en amont</h3>
                <p>DPE, amiante, plomb, électricité, gaz, état des risques : anticiper ces démarches évite des délais inutiles et rassure les acquéreurs dès la première visite. Un dossier complet est un signal positif pour le notaire lors de la rédaction du compromis.</p>
            </div>
            <div class="sell-guide__item">
                <h3 class="sell-guide__step">3. Valoriser et diffuser intelligemment</h3>
                <p>Photos soignées, description claire, mise en avant des vrais atouts du logement : ces éléments permettent d'attirer des acheteurs qualifiés. La diffusion doit être ciblée — les bons canaux, la bonne cible, au bon moment.</p>
            </div>
            <div class="sell-guide__item">
                <h3 class="sell-guide__step">4. Négocier et sécuriser la transaction</h3>
                <p>Une négociation menée avec méthode évite de laisser de l'argent sur la table ou de perdre un acquéreur sérieux. Après l'accord, le compromis puis l'acte authentique chez le notaire finalisent la transaction.</p>
            </div>
        </div>
        <div class="text-center mt-32">
            <a href="/avis-de-valeur" class="btn btn--outline">Demander un avis de valeur gratuit</a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:E — FAQ : lever les dernières objections
     Objectif : répondre aux questions non posées, avant le CTA.
     ═══════════════════════════════════════════════════════════ -->
<section class="section section--alt" id="faq-immobilier-aix-en-provence">
    <div class="container">
        <div class="section__header text-center">
            <span class="section-label">Questions fréquentes</span>
            <h2 class="section-title">FAQ immobilier à Aix-en-Provence</h2>
            <p class="section-subtitle">Les questions que posent le plus souvent les vendeurs et acheteurs du Pays d'Aix.</p>
        </div>
        <div class="faq">
            <div class="faq__item">
                <h3 class="faq__question">Combien vaut mon bien immobilier à Aix-en-Provence ?</h3>
                <p class="faq__answer">Le prix d'un bien dépend de nombreux facteurs : surface, secteur, étage, état général, présence d'un extérieur, niveau du DPE et transactions récentes comparables. Une estimation sérieuse ne se fait pas en 2 minutes sur Internet — elle demande une analyse terrain et une connaissance du marché local. Je vous propose un avis de valeur précis et argumenté, sans engagement.</p>
            </div>
            <div class="faq__item">
                <h3 class="faq__question">Quelle est la différence entre un agent immobilier et un conseiller indépendant ?</h3>
                <p class="faq__answer">Un agent en agence gère généralement plusieurs dizaines de mandats en simultané, ce qui limite le suivi individuel. En tant que conseiller indépendant rattaché au réseau eXp Realty, j'interviens en interlocuteur unique sur un portefeuille limité. Chaque projet bénéficie d'un suivi personnalisé, d'une stratégie adaptée et d'une disponibilité réelle.</p>
            </div>
            <div class="faq__item">
                <h3 class="faq__question">Quels diagnostics immobiliers sont obligatoires pour vendre ?</h3>
                <p class="faq__answer">La liste dépend du type de bien et de sa date de construction. En général : DPE, diagnostic amiante, plomb (si avant 1949), électricité et gaz (si installation de plus de 15 ans), état des risques et pollutions, et selon les cas le diagnostic termites. Ces documents doivent être annexés au compromis de vente signé chez le notaire.</p>
            </div>
            <div class="faq__item">
                <h3 class="faq__question">Combien de temps faut-il pour vendre à Aix-en-Provence ?</h3>
                <p class="faq__answer">Un bien correctement estimé et bien présenté peut trouver un acquéreur en 3 à 8 semaines. Après l'acceptation de l'offre, comptez environ 3 mois entre le compromis et l'acte authentique (délai légal de rétractation, instruction du financement acheteur, etc.).</p>
            </div>
            <div class="faq__item">
                <h3 class="faq__question">Est-il possible de vendre sans agence à Aix-en-Provence ?</h3>
                <p class="faq__answer">Techniquement oui. Mais la vente entre particuliers demande de maîtriser l'estimation, la rédaction des annonces, la qualification des acheteurs, la gestion des visites, la négociation et les aspects juridiques. Elle expose à des risques si les diagnostics sont incomplets ou le dossier mal constitué. Faire appel à un conseiller, c'est déléguer ces étapes à quelqu'un qui les maîtrise.</p>
            </div>
            <div class="faq__item">
                <h3 class="faq__question">Pourquoi choisir Pascal Hamm pour votre projet immobilier ?</h3>
                <p class="faq__answer">Parce que je travaille avec peu de clients à la fois pour m'impliquer vraiment sur chacun. Pas de promesse irréaliste pour décrocher un mandat, pas de communication de masse sans résultat. Une approche structurée, un suivi transparent et un objectif simple : vous aider à vendre ou acheter dans de bonnes conditions, au bon prix, avec le moins de stress possible.</p>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MERE:E — CTA final : l'invitation à agir
     Objectif : convertir. 3 actions primaires, 3 secondaires.
     Pas plus — chaque bouton supplémentaire dilue la décision.
     ═══════════════════════════════════════════════════════════ -->
<section class="cta-banner" id="cta-final">
    <div class="container">
        <h2>Parlons de votre projet immobilier à Aix-en-Provence.</h2>
        <p>Choisissez votre prochain pas selon où vous en êtes.</p>
        <div class="cta-banner__actions">
            <a href="/estimation-gratuite" class="btn btn--accent btn--lg">Demander une estimation gratuite</a>
            <a href="/contact" class="btn btn--outline-white btn--lg">Prendre contact</a>
            <?php if (!empty($advisorPhone)): ?><a href="tel:<?= e($advisorPhone) ?>" class="btn btn--outline-white btn--lg">Appeler <?= e($advisorName) ?></a><?php endif; ?>
        </div>
        <div class="cta-banner__actions cta-banner__actions--secondary">
            <a href="/biens" class="btn btn--outline-white">Voir les biens</a>
            <a href="/secteurs" class="btn btn--outline-white">Consulter les secteurs</a>
            <a href="/avis-clients" class="btn btn--outline-white">Avis clients</a>
        </div>
    </div>
</section>
