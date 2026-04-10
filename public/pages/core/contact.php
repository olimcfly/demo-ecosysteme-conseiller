<?php
$contactFormError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();

    $email      = trim((string)($_POST['email'] ?? ''));
    $prenom     = trim((string)($_POST['prenom'] ?? ''));
    $message    = trim((string)($_POST['message'] ?? ''));
    $maxMessage = 2000;

    if (
        $email !== ''
        && $prenom !== ''
        && filter_var($email, FILTER_VALIDATE_EMAIL)
        && $message !== ''
        && mb_strlen($message) <= $maxMessage
    ) {
        LeadService::capture([
            'source_type' => LeadService::SOURCE_CONTACT,
            'pipeline'    => LeadService::SOURCE_CONTACT,
            'stage'       => 'a_traiter',
            'first_name'  => $prenom,
            'last_name'   => trim((string)($_POST['nom']       ?? '')),
            'email'       => $email,
            'phone'       => trim((string)($_POST['telephone'] ?? '')),
            'intent'      => trim((string)($_POST['sujet']     ?? 'Contact général')),
            'notes'       => $message,
            'consent'     => !empty($_POST['rgpd']),
            'metadata'    => [
                'origin_path' => $_SERVER['REQUEST_URI'] ?? '/contact',
            ],
        ]);

        redirect('/merci');
    }
}

$pageTitle = 'Contact — Pascal Hamm | Expert Immobilier 360° Aix-en-Provence';
$metaDesc  = 'Contactez Pascal Hamm, expert immobilier 360° à Aix-en-Provence. Réponse personnelle sous 24h.';
$extraCss  = ['/assets/css/contact.css'];
$extraJs   = ['/assets/js/contact.js'];

$contactTitle     = trim((string) setting('contact_title',      'Contactez-moi'));
$contactAddress   = trim((string) setting('contact_address',    APP_ADDRESS));
$contactPhone     = trim((string) setting('contact_phone',      APP_PHONE));
$contactEmail     = trim((string) setting('contact_email',      APP_EMAIL));
$contactMapEmbed  = trim((string) setting('contact_map_embed',  ''));
$contactFormTitle = trim((string) setting('contact_form_title', 'Envoyez-moi un message'));

$contactPhoneHref = preg_replace('/\s+/', '', $contactPhone) ?: '';
?>

<div class="page-header">
    <div class="container">
        <nav class="breadcrumb" aria-label="Fil d'Ariane">
            <a href="/">Accueil</a><span>Contact</span>
        </nav>
        <h1><?= e($contactTitle !== '' ? $contactTitle : 'Contactez-moi') ?></h1>
        <p>Je vous réponds personnellement dans les 24 heures. N'hésitez pas à me poser toutes vos questions.</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="contact-layout">

            <!-- Formulaire -->
            <div class="contact-form-box">
                <h2><?= e($contactFormTitle !== '' ? $contactFormTitle : 'Envoyez-moi un message') ?></h2>
                <p>Décrivez votre projet ou posez votre question.</p>

                <?php if ($contactFormError !== ''): ?>
                    <div style="margin-bottom:1rem;padding:.9rem 1rem;border:1px solid #fda29b;background:#fef3f2;color:#b42318;border-radius:10px;">
                        <?= e($contactFormError) ?>
                    </div>
                <?php endif; ?>

                <form id="contact-form" action="/contact" method="POST" novalidate>
                    <?= csrfField() ?>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="prenom">
                                Prénom <span aria-hidden="true">*</span>
                            </label>
                            <input
                                type="text"
                                id="prenom"
                                name="prenom"
                                class="form-control"
                                placeholder="Jean"
                                required
                                autocomplete="given-name"
                                aria-describedby="prenom-err">
                            <div class="form-error" id="prenom-err"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="nom">
                                Nom <span aria-hidden="true">*</span>
                            </label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                class="form-control"
                                placeholder="Dupont"
                                required
                                autocomplete="family-name"
                                aria-describedby="nom-err">
                            <div class="form-error" id="nom-err"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="email">
                                Email <span aria-hidden="true">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="jean@exemple.fr"
                                required
                                autocomplete="email"
                                aria-describedby="email-err">
                            <div class="form-error" id="email-err"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="telephone">Téléphone</label>
                            <input
                                type="tel"
                                id="telephone"
                                name="telephone"
                                class="form-control"
                                placeholder="06 00 00 00 00"
                                autocomplete="tel"
                                aria-describedby="telephone-err">
                            <div class="form-error" id="telephone-err"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sujet">Sujet</label>
                        <select id="sujet" name="sujet" class="form-control">
                            <option value="Contact général">Contact général</option>
                            <option value="Achat immobilier">Achat immobilier</option>
                            <option value="Vente immobilier">Vente immobilier</option>
                            <option value="Viager">Viager</option>
                            <option value="Financement">Financement</option>
                            <option value="Estimation">Estimation gratuite</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">
                            Message <span aria-hidden="true">*</span>
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            class="form-control"
                            rows="6"
                            placeholder="Décrivez votre projet immobilier..."
                            required
                            maxlength="2000"
                            aria-describedby="message-err"></textarea>
                        <div class="form-error" id="message-err"></div>
                    </div>

                    <div class="form-group form-group--checkbox">
                        <label class="checkbox-label">
                            <input type="checkbox" name="rgpd" required>
                            <span style="margin-top:.2rem;flex-shrink:0">
                                J'accepte que mes données soient utilisées pour traiter ma demande,
                                conformément à la
                                <a href="/politique-confidentialite" target="_blank" style="color:var(--clr-primary)">
                                    politique de confidentialité</a>.
                                <span style="color:var(--clr-danger)">*</span>
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn--primary btn--lg btn--full">
                        Envoyer mon message
                    </button>
                </form>
            </div>

            <!-- Informations de contact -->
            <div class="contact-info">

                <div class="contact-info-box">
                    <h3>Coordonnées</h3>
                    <div class="info-item">
                        <span class="info-icon">📍</span>
                        <div class="info-text">
                            <strong>Adresse</strong>
                            <p><?= e($contactAddress !== '' ? $contactAddress : 'Aix-en-Provence, France') ?></p>
                        </div>
                    </div>
                    <?php if ($contactPhone !== ''): ?>
                    <div class="info-item">
                        <span class="info-icon">📞</span>
                        <div class="info-text">
                            <strong>Téléphone</strong>
                            <p><a href="tel:<?= e($contactPhoneHref) ?>"><?= e($contactPhone) ?></a></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="info-item">
                        <span class="info-icon">✉️</span>
                        <div class="info-text">
                            <strong>Email</strong>
                            <p>
                                <a href="mailto:<?= e($contactEmail !== '' ? $contactEmail : APP_EMAIL) ?>">
                                    <?= e($contactEmail !== '' ? $contactEmail : APP_EMAIL) ?>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="contact-info-box">
                    <h3>Horaires</h3>
                    <div class="horaires-grid">
                        <span class="jour">Lundi – Vendredi</span><span class="heure">9h – 19h</span>
                        <span class="jour">Samedi</span>         <span class="heure">10h – 17h</span>
                        <span class="jour">Dimanche</span>       <span class="heure">Fermé</span>
                    </div>
                    <p style="margin-top:1rem;font-size:.8rem;color:var(--clr-text-muted)">
                        Des rendez-vous en dehors de ces créneaux sont possibles sur demande.
                    </p>
                </div>

                <!-- Carte -->
                <div class="map-placeholder" aria-label="Carte de localisation — Aix-en-Provence">
                    <?php if ($contactMapEmbed !== ''): ?>
                        <?= $contactMapEmbed ?>
                    <?php else: ?>
                        <iframe
                            title="Localisation Pascal Hamm — Aix-en-Provence"
                            src="https://maps.google.com/maps?q=Aix-en-Provence&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            width="100%"
                            height="320"
                            style="border:0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen>
                        </iframe>
                    <?php endif; ?>
                </div>

                <!-- Badge réponse rapide -->
                <div style="background:var(--clr-primary);color:white;border-radius:var(--radius-lg);padding:1.5rem;text-align:center">
                    <div style="font-size:2rem;margin-bottom:.75rem">⚡</div>
                    <h4 style="color:white;margin-bottom:.5rem">Réponse garantie sous 24h</h4>
                    <p style="font-size:.875rem;opacity:.8">
                        Je m'engage à vous répondre personnellement dans les meilleurs délais.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>
