<?php
$pageTitle = 'À propos — Pascal Hamm | Expert Immobilier 360° à Aix-en-Provence';
$metaDesc = 'Découvrez Pascal Hamm, expert immobilier clef en main à Aix-en-Provence. Spécialiste des biens d\'exception, viager éthique et solutions de financement sur le Pays d\'Aix.';
?>

<div class="page-header">
    <div class="container">
        <nav class="breadcrumb"><a href="/">Accueil</a><span>À propos</span></nav>
        <h1>Pascal Hamm - Votre partenaire immobilier 360°</h1>
        <p>Immobilier clef en main, viager éthique et solutions de financement dans le Pays d\'Aix</p>
    </div>
</div>

<!-- Section Présentation -->
<section class="section">
    <div class="container">
        <div class="grid-2" style="gap:4rem;align-items:center">
            <div data-animate>
                <div class="about-portrait-container">
                    <img src="/assets/images/pascal-hamm.jpeg"
                         alt="Pascal Hamm - Expert immobilier Aix-en-Provence"
                         width="600" height="1009"
                         class="about-portrait"
                         loading="eager">
                </div>
            </div>
            <div data-animate>
                <span class="section-label">Mon approche</span>
                <h2 class="section-title">Votre allié 360° pour tous vos projets immobiliers</h2>
                <p>Spécialiste des <strong>biens d'exception</strong> en Provence et en Espagne, je vous accompagne avec une approche <strong>clef en main</strong> pour tous vos projets :</p>
                <ul class="feature-list">
                    <li>✓ Achat et vente de propriétés haut de gamme</li>
                    <li>✓ Solutions de <strong>viager éthique</strong> innovantes</li>
                    <li>✓ <strong>Financement</strong> et optimisation fiscale</li>
                    <li>✓ Gestion locative et investissement</li>
                </ul>
                <p>Mon expertise couvre Aix-en-Provence, le Pays d\'Aix et les plus belles communes de Provence.</p>

                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">15+ ans</div>
                        <div class="stat-label">d'expertise locale</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">360°</div>
                        <div class="stat-label">Accompagnement complet</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">Viager</div>
                        <div class="stat-label">Solutions éthiques</div>
                    </div>
                </div>

                <div class="contact-info">
                    <?php if (!empty($advisorPhone)): ?>
                    <a href="tel:<?= e($advisorPhone) ?>" class="contact-link">
                        <span class="contact-icon">📞</span> <?= e($advisorPhoneDisplay) ?>
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($advisorEmail)): ?>
                    <a href="mailto:<?= e($advisorEmail) ?>" class="contact-link">
                        <span class="contact-icon">✉️</span> <?= e($advisorEmail) ?>
                    </a>
                    <?php endif; ?>
                </div>
                <a href="/contact" class="btn btn--primary">Discutons de votre projet</a>
            </div>
        </div>
    </div>
</section>

<!-- Section Valeurs -->
<section class="section section--alt">
    <div class="container">
        <div class="section__header text-center">
            <span class="section-label">Mes engagements</span>
            <h2 class="section-title">Ce qui fait ma différence</h2>
            <p class="section-subtitle">Une approche unique pour des résultats exceptionnels</p>
        </div>
        <div class="grid-3" data-animate>
            <div class="value-card">
                <div class="value-icon">🏡</div>
                <h3>Immobilier clef en main</h3>
                <p>De la recherche à la signature, je gère tous les aspects de votre projet pour une expérience sans stress.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">💎</div>
                <h3>Biens d'exception</h3>
                <p>Spécialiste des propriétés haut de gamme en Provence et en Espagne, avec un réseau exclusif.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🔄</div>
                <h3>Viager éthique</h3>
                <p>Des solutions innovantes pour vendre ou investir en viager, avec une approche humaine et transparente.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">💰</div>
                <h3>Financement sur mesure</h3>
                <p>Partenaire en solutions de financement pour optimiser votre investissement immobilier.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">📍</div>
                <h3>Expertise locale</h3>
                <p>Connaissance approfondie du marché aixois et des communes environnantes (Le Tholonet, Beaurecueil, etc.).</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3>Relation client</h3>
                <p>Accompagnement personnalisé avec écoute et transparence à chaque étape de votre projet.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section Parcours -->
<section class="section">
    <div class="container">
        <div class="grid-2" style="gap:4rem;align-items:center">
            <div data-animate>
                <img src="https://nhkxpqunzawllesgatth.supabase.co/storage/v1/object/public/agent-images/1772066730896-bp1i9bn225s.jpeg"
                     alt="Pascal Hamm en rendez-vous client"
                     class="about-image">
            </div>
            <div data-animate>
                <span class="section-label">Mon parcours</span>
                <h2 class="section-title">15 ans d'expertise au service de vos projets</h2>
                <p>Après une carrière réussie dans la finance, j'ai choisi de me spécialiser dans l'immobilier pour allier mon expertise des marchés à ma passion pour les belles propriétés.</p>
                <p>Mon approche combine :</p>
                <ul class="feature-list">
                    <li>✓ Analyse financière approfondie des opportunités</li>
                    <li>✓ Réseau exclusif de biens d'exception</li>
                    <li>✓ Solutions innovantes comme le viager éthique</li>
                    <li>✓ Accompagnement 360° de la recherche à la signature</li>
                </ul>
                <p>Mon objectif : vous faire bénéficier d'une expertise complète pour concrétiser vos projets immobiliers dans les meilleures conditions.</p>
            </div>
        </div>
    </div>
</section>

<!-- Section Certifications -->
<section class="section section--alt">
    <div class="container">
        <div class="section__header text-center">
            <span class="section-label">Professionnalisme</span>
            <h2 class="section-title">Mes certifications</h2>
        </div>
        <div class="certifications-grid" data-animate>
            <div class="certification-card">
                <div class="certification-icon">📜</div>
                <h3>Carte professionnelle</h3>
                <p>Délivrée par la CCI Aix-Marseille Provence</p>
            </div>
            <div class="certification-card">
                <div class="certification-icon">⚖️</div>
                <h3>Conformité Loi Hoguet</h3>
                <p>Respect des réglementations immobilières</p>
            </div>
            <div class="certification-card">
                <div class="certification-icon">🛡️</div>
                <h3>Assurance RC Pro</h3>
                <p>Garantie professionnelle complète</p>
            </div>
            <div class="certification-card">
                <div class="certification-icon">🎓</div>
                <h3>Expert viager</h3>
                <p>Formation spécialisée en solutions viagères</p>
            </div>
        </div>
    </div>
</section>

<!-- Section Territoire -->
<section class="section">
    <div class="container">
        <div class="grid-2" style="gap:4rem;align-items:center">
            <div data-animate>
                <img src="https://nhkxpqunzawllesgatth.supabase.co/storage/v1/object/public/agent-images/1771852626487-lfp1hg6uhrl.jpeg"
                     alt="Pascal Hamm sur le terrain à Aix-en-Provence"
                     class="about-image">
            </div>
            <div data-animate>
                <span class="section-label">Mon territoire</span>
                <h2 class="section-title">Aix-en-Provence et le Pays d\'Aix</h2>
                <p>Mon expertise couvre l'ensemble du Pays d\'Aix, avec une connaissance approfondie de chaque commune :</p>
                <div class="location-grid">
                    <div class="location-item">Aix-en-Provence</div>
                    <div class="location-item">Le Tholonet</div>
                    <div class="location-item">Beaurecueil</div>
                    <div class="location-item">Puyricard</div>
                    <div class="location-item">Éguilles</div>
                    <div class="location-item">Ventabren</div>
                    <div class="location-item">Rognes</div>
                    <div class="location-item">Puy-Sainte-Réparade</div>
                    <div class="location-item">Lambesc</div>
                    <div class="location-item">Saint-Cannat</div>
                </div>
                <p>Que vous cherchiez une bastide provençale, un appartement en centre-ville ou un domaine viticole, je connais les meilleures opportunités du marché.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="cta-banner">
    <div class="container">
        <h2>Votre projet immobilier mérite l'expertise 360°</h2>
        <p>Que vous souhaitiez acheter, vendre, investir ou trouver une solution de financement, je suis à vos côtés pour concrétiser vos ambitions.</p>
        <div class="cta-actions">
            <a href="/contact" class="btn btn--accent btn--lg">Contactez-moi</a>
            <a href="/biens" class="btn btn--outline-white btn--lg">Voir les biens disponibles</a>
        </div>
    </div>
</section>

<style>
.about-portrait-container {
    background: linear-gradient(135deg, #f5f1eb 0%, #e8ddd4 100%);
    border-radius: 2rem;
    padding: 2rem;
    aspect-ratio: 3/4;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.about-portrait {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 1rem;
    transform: scale(1.05);
}

.about-image {
    width: 100%;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin: 2rem 0;
}

.stat-item {
    text-align: center;
    padding: 1.5rem;
    background: var(--clr-bg);
    border-radius: 1rem;
    border: 1px solid var(--clr-border);
}

.stat-value {
    font-family: var(--font-display);
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--clr-primary);
    margin-bottom: 0.3rem;
}

.stat-label {
    font-size: 0.9rem;
    color: var(--clr-text-muted);
}

.value-card {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    text-align: center;
    transition: transform 0.3s ease;
}

.value-card:hover {
    transform: translateY(-5px);
}

.value-icon {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: var(--clr-primary);
}

.certifications-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.certification-card {
    background: white;
    padding: 2rem;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    text-align: center;
}

.certification-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--clr-primary);
}

.location-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.8rem;
    margin: 1.5rem 0;
}

.location-item {
    background: var(--clr-bg);
    padding: 0.8rem 1.2rem;
    border-radius: 0.8rem;
    font-size: 0.9rem;
    text-align: center;
    border: 1px solid var(--clr-border);
}

.cta-banner {
    background: linear-gradient(135deg, var(--clr-primary) 0%, var(--clr-accent) 100%);
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.cta-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .grid-2, .grid-3 {
        grid-template-columns: 1fr;
    }

    .stats-grid, .certifications-grid {
        grid-template-columns: 1fr;
    }

    .location-grid {
        grid-template-columns: 1fr;
    }
}
</style>
