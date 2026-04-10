<?php
$redirect = '/sondage';
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
      --blue: #1a56db; --blue-d: #1347c4; --bg: #f0f4ff;
      --card: #fff; --text: #1e293b; --muted: #64748b;
      --border: #e2e8f0; --err: #ef4444; --ok: #22c55e;
      --r: 12px; --sh: 0 8px 32px rgba(26,86,219,.12);
    }
    body { min-height:100vh; background:var(--bg); display:flex; align-items:center; justify-content:center; padding:24px 16px; font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif; color:var(--text); }
    .wrap { width:100%; max-width:560px; }
    /* Logo */
    .logo { text-align:center; margin-bottom:24px; }
    .logo-badge { display:inline-flex; align-items:center; gap:10px; background:var(--blue); color:#fff; padding:10px 22px; border-radius:50px; font-weight:700; font-size:.95rem; }
    /* Steps indicator */
    .steps { display:flex; align-items:center; justify-content:center; gap:0; margin-bottom:24px; }
    .step { display:flex; flex-direction:column; align-items:center; gap:4px; }
    .step-dot { width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:.78rem; font-weight:700; }
    .step.active .step-dot { background:var(--blue); color:#fff; }
    .step.done .step-dot { background:#dcfce7; color:#16a34a; }
    .step.pending .step-dot { background:#f1f5f9; color:var(--muted); }
    .step-label { font-size:.7rem; color:var(--muted); font-weight:500; }
    .step.active .step-label { color:var(--blue); font-weight:700; }
    .step-line { width:40px; height:2px; background:var(--border); margin-bottom:16px; }
    .step-line.done { background:var(--blue); }
    /* Card */
    .card { background:var(--card); border-radius:var(--r); box-shadow:var(--sh); overflow:hidden; }
    .card-head { background:linear-gradient(135deg,var(--blue),#3b82f6); color:#fff; padding:28px 32px 24px; }
    .card-head .badge { display:inline-block; background:rgba(255,255,255,.2); font-size:.72rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; padding:4px 12px; border-radius:50px; margin-bottom:12px; }
    .card-head h1 { font-size:1.45rem; font-weight:800; line-height:1.25; margin-bottom:8px; }
    .card-head p { font-size:.88rem; opacity:.85; line-height:1.5; }
    .card-body { padding:28px 32px 32px; }
    /* Section title */
    .section-title { font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--blue); margin:20px 0 12px; padding-bottom:6px; border-bottom:2px solid #dbeafe; }
    .section-title:first-child { margin-top:0; }
    /* Form */
    .row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .fg { margin-bottom:14px; }
    label { display:block; font-size:.8rem; font-weight:600; margin-bottom:5px; }
    label .req { color:var(--blue); }
    input, select { width:100%; padding:10px 13px; border:1.5px solid var(--border); border-radius:8px; font-size:.9rem; color:var(--text); background:#fff; font-family:inherit; outline:none; transition:border-color .15s; }
    input:focus, select:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(26,86,219,.1); }
    input.err, select.err { border-color:var(--err); }
    .ferr { font-size:.75rem; color:var(--err); margin-top:3px; display:none; }
    .ferr.show { display:block; }
    /* Cards radio */
    .card-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-top:2px; }
    .card-grid.cols-3 { grid-template-columns:1fr 1fr 1fr; }
    .card-opt input[type=radio] { display:none; }
    .card-opt label { display:flex; flex-direction:column; align-items:center; gap:6px; padding:12px 8px; border:1.5px solid var(--border); border-radius:10px; cursor:pointer; transition:all .15s; font-size:.8rem; font-weight:500; text-align:center; color:var(--muted); }
    .card-opt label .icon { font-size:1.5rem; }
    .card-opt input:checked + label { border-color:var(--blue); background:#eff6ff; color:var(--blue); font-weight:700; }
    /* Submit */
    .btn { width:100%; padding:13px; background:var(--blue); color:#fff; font-size:.95rem; font-weight:700; border:none; border-radius:8px; cursor:pointer; margin-top:20px; font-family:inherit; display:flex; align-items:center; justify-content:center; gap:8px; transition:background .15s; }
    .btn:hover { background:var(--blue-d); }
    .btn:disabled { opacity:.6; cursor:not-allowed; }
    .spinner { width:16px; height:16px; border:2px solid rgba(255,255,255,.4); border-top-color:#fff; border-radius:50%; animation:spin .7s linear infinite; display:none; }
    @keyframes spin { to { transform:rotate(360deg); } }
    /* Alert */
    .alert { padding:11px 14px; border-radius:8px; font-size:.87rem; margin-bottom:12px; display:none; }
    .alert.err { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
    .alert.ok { background:#f0fdf4; border:1px solid #bbf7d0; color:#16a34a; }
    .alert.show { display:block; }
    .privacy { text-align:center; font-size:.72rem; color:var(--muted); margin-top:14px; line-height:1.5; }
    @media(max-width:500px) { .card-head,.card-body{padding:20px;} .row{grid-template-columns:1fr;} .card-grid{grid-template-columns:1fr 1fr;} .card-grid.cols-3{grid-template-columns:1fr 1fr;} }
  </style>
</head>
<body>
<div class="wrap">

  <div class="logo">
    <div class="logo-badge">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Ecosystème Conseiller
    </div>
  </div>

  <div class="steps">
    <div class="step active">
      <div class="step-dot">1</div>
      <div class="step-label">Votre profil</div>
    </div>
    <div class="step-line"></div>
    <div class="step pending">
      <div class="step-dot">2</div>
      <div class="step-label">Sondage EPPE</div>
    </div>
    <div class="step-line"></div>
    <div class="step pending">
      <div class="step-dot">3</div>
      <div class="step-label">Démo</div>
    </div>
  </div>

  <div class="card">
    <div class="card-head">
      <span class="badge">Étape 1 sur 3 — Accès gratuit</span>
      <h1>Parlez-nous de vous</h1>
      <p>Quelques infos pour personnaliser votre accès à la plateforme de démonstration.</p>
    </div>
    <div class="card-body">

      <div class="alert err" id="alertErr"></div>
      <div class="alert ok" id="alertOk">Profil enregistré ! Redirection vers le sondage...</div>

      <form id="form" novalidate>
        <input type="hidden" name="redirect" value="/sondage">

        <div class="section-title">Vos coordonnées</div>

        <div class="row">
          <div class="fg">
            <label>Prénom <span class="req">*</span></label>
            <input type="text" name="prenom" id="prenom" placeholder="Jean" autocomplete="given-name">
            <div class="ferr" id="err-prenom"></div>
          </div>
          <div class="fg">
            <label>Nom <span class="req">*</span></label>
            <input type="text" name="nom" id="nom" placeholder="Dupont" autocomplete="family-name">
            <div class="ferr" id="err-nom"></div>
          </div>
        </div>

        <div class="fg">
          <label>Email professionnel <span class="req">*</span></label>
          <input type="email" name="email" id="email" placeholder="jean.dupont@reseau.fr" autocomplete="email">
          <div class="ferr" id="err-email"></div>
        </div>

        <div class="row">
          <div class="fg">
            <label>Téléphone <span class="req">*</span></label>
            <input type="tel" name="telephone" id="telephone" placeholder="06 12 34 56 78" autocomplete="tel">
            <div class="ferr" id="err-telephone"></div>
          </div>
          <div class="fg">
            <label>Ville <span class="req">*</span></label>
            <input type="text" name="ville" id="ville" placeholder="Lyon" autocomplete="address-level2">
            <div class="ferr" id="err-ville"></div>
          </div>
        </div>

        <div class="fg">
          <label>Réseau immobilier <span class="req">*</span></label>
          <select name="reseau" id="reseau">
            <option value="">— Sélectionnez votre réseau —</option>
            <option>IAD France</option><option>Safti</option><option>Megagence</option>
            <option>Optimhome</option><option>BL Agents</option><option>Capifrance</option>
            <option>Propriétés Privées</option><option>Human Immobilier</option>
            <option>Expertimo</option><option>EZIMMO</option><option>Liberkeys</option>
            <option>Réseau Mandataires (autre)</option>
            <option>Agent indépendant</option><option>Agence traditionnelle</option><option>Autre</option>
          </select>
          <div class="ferr" id="err-reseau"></div>
        </div>

        <div class="section-title">Votre situation</div>

        <div class="fg">
          <label>Vous êtes <span class="req">*</span></label>
          <div class="card-grid">
            <div class="card-opt">
              <input type="radio" name="statut_professionnel" id="sp1" value="Conseiller indépendant">
              <label for="sp1"><span class="icon">🏠</span>Conseiller indépendant</label>
            </div>
            <div class="card-opt">
              <input type="radio" name="statut_professionnel" id="sp2" value="Agent immobilier">
              <label for="sp2"><span class="icon">🏢</span>Agent immobilier</label>
            </div>
            <div class="card-opt">
              <input type="radio" name="statut_professionnel" id="sp3" value="Responsable d'agence">
              <label for="sp3"><span class="icon">👔</span>Responsable d'agence</label>
            </div>
            <div class="card-opt">
              <input type="radio" name="statut_professionnel" id="sp4" value="En reconversion">
              <label for="sp4"><span class="icon">🔄</span>En reconversion</label>
            </div>
          </div>
          <div class="ferr" id="err-statut_professionnel"></div>
        </div>

        <div class="fg">
          <label>Situation actuelle en vente</label>
          <select name="situation_vente" id="situation_vente">
            <option value="">— Sélectionnez —</option>
            <option value="0-2 ventes/an">0 à 2 ventes par an</option>
            <option value="3-6 ventes/an">3 à 6 ventes par an</option>
            <option value="7-12 ventes/an">7 à 12 ventes par an</option>
            <option value="+12 ventes/an">Plus de 12 ventes par an</option>
            <option value="Débutant / pas encore">Débutant / pas encore de vente</option>
          </select>
        </div>

        <div class="fg">
          <label>Votre objectif principal</label>
          <div class="card-grid">
            <div class="card-opt">
              <input type="radio" name="objectif_principal" id="obj1" value="Rentrer plus de mandats">
              <label for="obj1"><span class="icon">📋</span>Rentrer plus de mandats</label>
            </div>
            <div class="card-opt">
              <input type="radio" name="objectif_principal" id="obj2" value="Trouver plus d'acheteurs">
              <label for="obj2"><span class="icon">👥</span>Trouver plus d'acheteurs</label>
            </div>
            <div class="card-opt">
              <input type="radio" name="objectif_principal" id="obj3" value="Augmenter ma visibilité">
              <label for="obj3"><span class="icon">📡</span>Augmenter ma visibilité</label>
            </div>
            <div class="card-opt">
              <input type="radio" name="objectif_principal" id="obj4" value="Automatiser ma prospection">
              <label for="obj4"><span class="icon">⚡</span>Automatiser ma prospection</label>
            </div>
          </div>
        </div>

        <div class="fg">
          <label>Expérience avec internet pour trouver des clients</label>
          <div class="card-grid cols-3">
            <div class="card-opt">
              <input type="radio" name="experience_internet" id="ei1" value="Aucune">
              <label for="ei1"><span class="icon">🚫</span>Aucune</label>
            </div>
            <div class="card-opt">
              <input type="radio" name="experience_internet" id="ei2" value="Quelques essais">
              <label for="ei2"><span class="icon">🌱</span>Quelques essais</label>
            </div>
            <div class="card-opt">
              <input type="radio" name="experience_internet" id="ei3" value="Régulièrement">
              <label for="ei3"><span class="icon">💡</span>Régulièrement</label>
            </div>
          </div>
        </div>

        <button type="submit" class="btn" id="btn">
          <span id="btnTxt">Continuer vers le sondage</span>
          <div class="spinner" id="spin"></div>
          <svg id="btnIco" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>

        <p class="privacy">Données utilisées uniquement pour personnaliser votre accès démo. Aucune prospection.</p>
      </form>
    </div>
  </div>
</div>

<script>
const form=document.getElementById('form'),alertErr=document.getElementById('alertErr'),alertOk=document.getElementById('alertOk'),btn=document.getElementById('btn'),btnTxt=document.getElementById('btnTxt'),spin=document.getElementById('spin'),btnIco=document.getElementById('btnIco');

function setLoad(on){btn.disabled=on;spin.style.display=on?'block':'none';btnIco.style.display=on?'none':'block';btnTxt.textContent=on?'Envoi en cours...':'Continuer vers le sondage';}
function clearErr(){document.querySelectorAll('.ferr').forEach(e=>{e.textContent='';e.classList.remove('show');});document.querySelectorAll('input,select').forEach(e=>e.classList.remove('err'));alertErr.classList.remove('show');}
function fieldErr(name,msg){const el=document.getElementById('err-'+name),inp=document.getElementById(name)||document.querySelector('[name="'+name+'"]');if(el){el.textContent=msg;el.classList.add('show');}if(inp)inp.classList.add('err');}

form.addEventListener('submit',async e=>{
  e.preventDefault();clearErr();setLoad(true);
  const d={
    prenom:form.prenom.value.trim(),nom:form.nom.value.trim(),
    email:form.email.value.trim(),telephone:form.telephone.value.trim(),
    ville:form.ville.value.trim(),reseau:form.reseau.value,
    statut_professionnel:(form.querySelector('[name=statut_professionnel]:checked')||{}).value||'',
    situation_vente:form.situation_vente.value,
    objectif_principal:(form.querySelector('[name=objectif_principal]:checked')||{}).value||'',
    experience_internet:(form.querySelector('[name=experience_internet]:checked')||{}).value||'',
    redirect:'/sondage'
  };
  try{
    const r=await fetch('/api/prospect/register',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(d)});
    const j=await r.json();
    if(j.success){alertOk.classList.add('show');setTimeout(()=>{window.location.href=j.redirect||'/sondage';},1000);}
    else if(j.errors){j.errors.forEach(err=>{
      const f=err.includes('prénom')?'prenom':err.includes('nom')?'nom':err.includes('mail')?'email':err.includes('élép')?'telephone':err.includes('ville')?'ville':err.includes('réseau')?'reseau':err.includes('statut')?'statut_professionnel':null;
      if(f)fieldErr(f,err);else{alertErr.textContent=err;alertErr.classList.add('show');}
    });setLoad(false);}
    else{alertErr.textContent=j.message||'Erreur';alertErr.classList.add('show');setLoad(false);}
  }catch{alertErr.textContent='Erreur réseau, réessayez.';alertErr.classList.add('show');setLoad(false);}
});
</script>
</body>
</html>
