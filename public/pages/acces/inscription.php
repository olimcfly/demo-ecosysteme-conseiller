<?php
$redirect = htmlspecialchars(urldecode($_GET['redirect'] ?? '/'), ENT_QUOTES, 'UTF-8');
if (!preg_match('/^\/[a-zA-Z0-9\/_\-?=&%]*$/', $redirect)) {
    $redirect = '/';
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title>Accéder à la démo — Ecosystème Conseiller</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --clr-primary: #1a56db;
      --clr-primary-dark: #1347c4;
      --clr-bg: #f0f4ff;
      --clr-card: #ffffff;
      --clr-text: #1e293b;
      --clr-muted: #64748b;
      --clr-border: #e2e8f0;
      --clr-error: #ef4444;
      --clr-success: #22c55e;
      --radius: 12px;
      --shadow: 0 8px 32px rgba(26,86,219,.12);
    }

    body {
      min-height: 100vh;
      background: var(--clr-bg);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      color: var(--clr-text);
    }

    .wrapper {
      width: 100%;
      max-width: 520px;
    }

    .logo {
      text-align: center;
      margin-bottom: 28px;
    }

    .logo-badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: var(--clr-primary);
      color: #fff;
      padding: 10px 20px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 1rem;
      letter-spacing: -.01em;
    }

    .logo-badge svg {
      flex-shrink: 0;
    }

    .card {
      background: var(--clr-card);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: 40px 36px;
    }

    .card-header {
      text-align: center;
      margin-bottom: 32px;
    }

    .card-header h1 {
      font-size: 1.6rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 10px;
    }

    .card-header p {
      color: var(--clr-muted);
      font-size: .95rem;
      line-height: 1.5;
    }

    .badge-demo {
      display: inline-block;
      background: #dbeafe;
      color: var(--clr-primary);
      font-size: .78rem;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      padding: 4px 12px;
      border-radius: 50px;
      margin-bottom: 14px;
    }

    .features {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 12px;
    }

    .feature-tag {
      background: #f8fafc;
      border: 1px solid var(--clr-border);
      border-radius: 6px;
      font-size: .78rem;
      padding: 4px 10px;
      color: var(--clr-muted);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .form-group {
      margin-bottom: 16px;
    }

    label {
      display: block;
      font-size: .82rem;
      font-weight: 600;
      margin-bottom: 5px;
      color: var(--clr-text);
    }

    label span.req {
      color: var(--clr-primary);
    }

    input, select {
      width: 100%;
      padding: 11px 14px;
      border: 1.5px solid var(--clr-border);
      border-radius: 8px;
      font-size: .94rem;
      color: var(--clr-text);
      background: #fff;
      transition: border-color .15s;
      outline: none;
      font-family: inherit;
    }

    input:focus, select:focus {
      border-color: var(--clr-primary);
      box-shadow: 0 0 0 3px rgba(26,86,219,.1);
    }

    input.invalid, select.invalid {
      border-color: var(--clr-error);
    }

    .field-error {
      font-size: .78rem;
      color: var(--clr-error);
      margin-top: 4px;
      display: none;
    }

    .field-error.visible {
      display: block;
    }

    .btn-submit {
      width: 100%;
      padding: 14px;
      background: var(--clr-primary);
      color: #fff;
      font-size: 1rem;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 8px;
      transition: background .15s, transform .1s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-family: inherit;
    }

    .btn-submit:hover {
      background: var(--clr-primary-dark);
    }

    .btn-submit:active {
      transform: scale(.98);
    }

    .btn-submit:disabled {
      opacity: .65;
      cursor: not-allowed;
    }

    .alert {
      padding: 12px 16px;
      border-radius: 8px;
      font-size: .9rem;
      margin-bottom: 16px;
      display: none;
    }

    .alert.error {
      background: #fef2f2;
      border: 1px solid #fecaca;
      color: #dc2626;
    }

    .alert.success {
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
      color: #16a34a;
    }

    .alert.visible {
      display: block;
    }

    .privacy {
      text-align: center;
      font-size: .75rem;
      color: var(--clr-muted);
      margin-top: 16px;
      line-height: 1.5;
    }

    .spinner {
      width: 18px;
      height: 18px;
      border: 2.5px solid rgba(255,255,255,.4);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin .7s linear infinite;
      display: none;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    @media (max-width: 480px) {
      .card { padding: 28px 20px; }
      .form-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
  <div class="wrapper">

    <div class="logo">
      <div class="logo-badge">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
        Ecosystème Conseiller
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <span class="badge-demo">Accès Démo Gratuit</span>
        <h1>Découvrez votre futur site conseiller</h1>
        <p>Renseignez vos informations pour accéder à la démonstration complète de la plateforme.</p>
        <div class="features">
          <span class="feature-tag">Site vitrine pro</span>
          <span class="feature-tag">Gestion des biens</span>
          <span class="feature-tag">Estimation en ligne</span>
          <span class="feature-tag">Blog & SEO</span>
          <span class="feature-tag">CRM leads</span>
        </div>
      </div>

      <div class="alert error" id="alertError"></div>
      <div class="alert success" id="alertSuccess">Accès accordé ! Redirection en cours...</div>

      <form id="formProspect" novalidate>
        <input type="hidden" name="redirect" value="<?= $redirect ?>">

        <div class="form-row">
          <div class="form-group">
            <label for="prenom">Prénom <span class="req">*</span></label>
            <input type="text" id="prenom" name="prenom" placeholder="Jean" autocomplete="given-name">
            <div class="field-error" id="err-prenom"></div>
          </div>
          <div class="form-group">
            <label for="nom">Nom <span class="req">*</span></label>
            <input type="text" id="nom" name="nom" placeholder="Dupont" autocomplete="family-name">
            <div class="field-error" id="err-nom"></div>
          </div>
        </div>

        <div class="form-group">
          <label for="email">Email professionnel <span class="req">*</span></label>
          <input type="email" id="email" name="email" placeholder="jean.dupont@reseau.fr" autocomplete="email">
          <div class="field-error" id="err-email"></div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="telephone">Téléphone <span class="req">*</span></label>
            <input type="tel" id="telephone" name="telephone" placeholder="06 12 34 56 78" autocomplete="tel">
            <div class="field-error" id="err-telephone"></div>
          </div>
          <div class="form-group">
            <label for="ville">Ville <span class="req">*</span></label>
            <input type="text" id="ville" name="ville" placeholder="Lyon" autocomplete="address-level2">
            <div class="field-error" id="err-ville"></div>
          </div>
        </div>

        <div class="form-group">
          <label for="reseau">Votre réseau immobilier <span class="req">*</span></label>
          <select id="reseau" name="reseau">
            <option value="">— Sélectionnez votre réseau —</option>
            <option>IAD France</option>
            <option>Safti</option>
            <option>Megagence</option>
            <option>Optimhome</option>
            <option>BL Agents</option>
            <option>Capifrance</option>
            <option>Propriétés Privées</option>
            <option>Human Immobilier</option>
            <option>Expertimo</option>
            <option>EZIMMO</option>
            <option>Liberkeys</option>
            <option>Réseau Mandataires (autre)</option>
            <option>Agent indépendant</option>
            <option>Agence traditionnelle</option>
            <option>Autre</option>
          </select>
          <div class="field-error" id="err-reseau"></div>
        </div>

        <button type="submit" class="btn-submit" id="btnSubmit">
          <span id="btnText">Accéder à la démo</span>
          <div class="spinner" id="btnSpinner"></div>
          <svg id="btnIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14M12 5l7 7-7 7"/>
          </svg>
        </button>

        <p class="privacy">
          Vos données sont utilisées uniquement pour vous donner accès à la démo.<br>
          Aucune prospection commerciale sans votre accord.
        </p>
      </form>
    </div>

  </div>

  <script>
    const form     = document.getElementById('formProspect');
    const alertErr = document.getElementById('alertError');
    const alertOk  = document.getElementById('alertSuccess');
    const btn      = document.getElementById('btnSubmit');
    const btnText  = document.getElementById('btnText');
    const spinner  = document.getElementById('btnSpinner');
    const btnIcon  = document.getElementById('btnIcon');

    function setLoading(on) {
      btn.disabled    = on;
      spinner.style.display = on ? 'block' : 'none';
      btnIcon.style.display = on ? 'none'  : 'block';
      btnText.textContent   = on ? 'Envoi en cours...' : 'Accéder à la démo';
    }

    function clearErrors() {
      document.querySelectorAll('.field-error').forEach(el => {
        el.textContent = '';
        el.classList.remove('visible');
      });
      document.querySelectorAll('input, select').forEach(el => el.classList.remove('invalid'));
      alertErr.classList.remove('visible');
    }

    function showFieldError(name, msg) {
      const el  = document.getElementById('err-' + name);
      const inp = document.getElementById(name);
      if (el) { el.textContent = msg; el.classList.add('visible'); }
      if (inp) inp.classList.add('invalid');
    }

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      clearErrors();
      setLoading(true);

      const data = {
        prenom:    form.prenom.value.trim(),
        nom:       form.nom.value.trim(),
        email:     form.email.value.trim(),
        telephone: form.telephone.value.trim(),
        ville:     form.ville.value.trim(),
        reseau:    form.reseau.value,
        redirect:  form.redirect.value,
      };

      try {
        const res  = await fetch('/api/prospect/register', {
          method:  'POST',
          headers: { 'Content-Type': 'application/json' },
          body:    JSON.stringify(data),
        });
        const json = await res.json();

        if (json.success) {
          alertOk.classList.add('visible');
          setTimeout(() => { window.location.href = json.redirect || '/'; }, 1200);
        } else if (json.errors) {
          json.errors.forEach(err => {
            const field = err.toLowerCase().includes('prénom') ? 'prenom'
                        : err.toLowerCase().includes('nom')    ? 'nom'
                        : err.toLowerCase().includes('email')  ? 'email'
                        : err.toLowerCase().includes('télép')  ? 'telephone'
                        : err.toLowerCase().includes('ville')  ? 'ville'
                        : err.toLowerCase().includes('réseau') ? 'reseau'
                        : null;
            if (field) showFieldError(field, err);
            else { alertErr.textContent = err; alertErr.classList.add('visible'); }
          });
          setLoading(false);
        } else {
          alertErr.textContent = json.message || 'Une erreur est survenue.';
          alertErr.classList.add('visible');
          setLoading(false);
        }
      } catch {
        alertErr.textContent = 'Erreur réseau, veuillez réessayer.';
        alertErr.classList.add('visible');
        setLoading(false);
      }
    });
  </script>
</body>
</html>
