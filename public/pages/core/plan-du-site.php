<?php
$pageTitle = 'Plan du site';
$metaDesc = 'Plan du site HTML de Pascal Hamm Immobilier : accès rapide à toutes les pages principales.';
?>
<section class="section">
    <div class="container">
        <h1>Plan du site</h1>
        <p>Retrouvez ci-dessous les pages principales du site.</p>

        <h2>Pages principales</h2>
        <ul>
            <li><a href="<?= e(url('/')) ?>">Accueil</a></li>
            <li><a href="<?= e(url('/a-propos')) ?>">À propos</a></li>
            <li><a href="<?= e(url('/contact')) ?>">Contact</a></li>
            <li><a href="<?= e(url('/services')) ?>">Services</a></li>
            <li><a href="<?= e(url('/biens')) ?>">Biens à vendre</a></li>
            <li><a href="<?= e(url('/guide-local')) ?>">Guide local</a></li>
            <li><a href="<?= e(url('/ressources')) ?>">Ressources</a></li>
            <li><a href="<?= e(url('/blog')) ?>">Blog</a></li>
            <li><a href="<?= e(url('/actualites')) ?>">Actualités</a></li>
            <li><a href="<?= e(url('/avis')) ?>">Avis clients</a></li>
        </ul>

        <h2>Pages légales</h2>
        <ul>
            <li><a href="<?= e(url('/mentions-legales')) ?>">Mentions légales</a></li>
            <li><a href="<?= e(url('/politique-confidentialite')) ?>">Politique de confidentialité</a></li>
            <li><a href="<?= e(url('/politique-cookies')) ?>">Politique cookies</a></li>
            <li><a href="<?= e(url('/cgv')) ?>">Conditions générales de vente</a></li>
        </ul>
    </div>
</section>
