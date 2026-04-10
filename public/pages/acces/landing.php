<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title>Ecosystème Conseiller — Plateforme démo</title>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
      --blue:#1a56db;--blue-d:#1347c4;--blue-l:#eff6ff;
      --bg:#0f172a;--card:#fff;--text:#1e293b;--muted:#64748b;
      --border:#e2e8f0;--err:#ef4444;
    }
    html{scroll-behavior:smooth;}
    body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;color:var(--text);background:#fff;}

    /* ── HERO ─────────────────────────────────────── */
    .hero{
      min-height:100vh;
      background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 60%,#1d4ed8 100%);
      display:flex;flex-direction:column;
      align-items:center;justify-content:center;
      padding:60px 24px;text-align:center;position:relative;overflow:hidden;
    }
    .hero::before{
      content:'';position:absolute;inset:0;
      background:radial-gradient(ellipse at 70% 30%,rgba(59,130,246,.25) 0%,transparent 60%),
                 radial-gradient(ellipse at 20% 80%,rgba(99,102,241,.2) 0%,transparent 50%);
    }
    .hero > *{position:relative;z-index:1;}
    .hero-badge{
      display:inline-flex;align-items:center;gap:8px;
      background:rgba(255,255,255,.12);backdrop-filter:blur(8px);
      border:1px solid rgba(255,255,255,.2);
      color:#93c5fd;font-size:.78rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
      padding:7px 18px;border-radius:50px;margin-bottom:28px;
    }
    .hero-badge span{display:inline-block;width:7px;height:7px;background:#4ade80;border-radius:50%;animation:pulse 2s infinite;}
    @keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}
    .hero h1{font-size:clamp(2rem,5vw,3.8rem);font-weight:900;color:#fff;line-height:1.15;margin-bottom:20px;letter-spacing:-.02em;}
    .hero h1 .accent{color:#60a5fa;}
    .hero .subtitle{font-size:clamp(1rem,2.5vw,1.25rem);color:rgba(255,255,255,.7);max-width:600px;line-height:1.6;margin-bottom:36px;}
    /* Promesses */
    .promises{display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin-bottom:44px;}
    .promise{display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:8px;padding:8px 16px;color:rgba(255,255,255,.85);font-size:.83rem;font-weight:500;}
    .promise .ico{font-size:1rem;}
    /* CTA button */
    .btn-cta{
      display:inline-flex;align-items:center;gap:10px;
      background:linear-gradient(135deg,#3b82f6,#1a56db);
      color:#fff;font-size:1.05rem;font-weight:700;
      padding:16px 36px;border-radius:12px;border:none;cursor:pointer;
      box-shadow:0 8px 32px rgba(59,130,246,.4);
      transition:transform .2s,box-shadow .2s;
      font-family:inherit;text-decoration:none;
    }
    .btn-cta:hover{transform:translateY(-2px);box-shadow:0 12px 40px rgba(59,130,246,.5);}
    .btn-cta:active{transform:translateY(0);}
    .btn-cta svg{transition:transform .2s;}
    .btn-cta:hover svg{transform:translateX(4px);}
    .hero-note{color:rgba(255,255,255,.4);font-size:.78rem;margin-top:14px;}
    /* Stats bar */
    .stats-bar{display:flex;gap:32px;justify-content:center;margin-top:56px;flex-wrap:wrap;}
    .stat{text-align:center;}
    .stat-val{font-size:1.6rem;font-weight:900;color:#fff;}
    .stat-lbl{font-size:.75rem;color:rgba(255,255,255,.5);margin-top:3px;}

    /* ── FEATURES ─────────────────────────────────── */
    .features{background:#f8fafc;padding:72px 24px;}
    .features-inner{max-width:1040px;margin:0 auto;}
    .section-label{font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--blue);margin-bottom:12px;}
    .section-title{font-size:clamp(1.5rem,3vw,2.2rem);font-weight:800;line-height:1.25;margin-bottom:48px;color:var(--text);}
    .feat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;}
    .feat-card{background:#fff;border-radius:12px;padding:24px;border:1px solid var(--border);transition:box-shadow .2s;}
    .feat-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.08);}
    .feat-ico{font-size:1.8rem;margin-bottom:12px;}
    .feat-card h3{font-size:.95rem;font-weight:700;margin-bottom:6px;}
    .feat-card p{font-size:.82rem;color:var(--muted);line-height:1.5;}

    /* ── FORM SECTION ─────────────────────────────── */
    .form-section{padding:72px 24px;background:#fff;}
    .form-inner{max-width:560px;margin:0 auto;}
    .form-card{background:#fff;border-radius:16px;box-shadow:0 8px 40px rgba(26,86,219,.13);border:1px solid #e0eaff;overflow:hidden;}
    .form-card-head{background:linear-gradient(135deg,var(--blue),#3b82f6);color:#fff;padding:28px 32px;}
    .form-card-head .step-badge{display:inline-block;background:rgba(255,255,255,.2);font-size:.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;padding:4px 12px;border-radius:50px;margin-bottom:10px;}
    .form-card-head h2{font-size:1.3rem;font-weight:800;margin-bottom:6px;}
    .form-card-head p{font-size:.85rem;opacity:.85;line-height:1.5;}
    .form-card-body{padding:28px 32px 32px;}
    /* steps bar */
    .steps-bar{display:flex;align-items:center;gap:0;margin-bottom:28px;}
    .sbar-item{display:flex;flex-direction:column;align-items:center;gap:4px;flex:1;}
    .sbar-dot{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;}
    .sbar-item.active .sbar-dot{background:var(--blue);color:#fff;}
    .sbar-item.pending .sbar-dot{background:#f1f5f9;color:var(--muted);}
    .sbar-lbl{font-size:.65rem;color:var(--muted);font-weight:600;}
    .sbar-item.active .sbar-lbl{color:var(--blue);}
    .sbar-line{flex:1;height:2px;background:var(--border);margin-bottom:16px;}
    /* form fields */
    .row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
    .fg{margin-bottom:13px;}
    label.lbl{display:block;font-size:.79rem;font-weight:600;margin-bottom:4px;}
    label.lbl .req{color:var(--blue);}
    input,select{width:100%;padding:10px 13px;border:1.5px solid var(--border);border-radius:8px;font-size:.88rem;color:var(--text);background:#fff;font-family:inherit;outline:none;transition:border-color .15s;}
    input:focus,select:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(26,86,219,.1);}
    input.err,select.err{border-color:var(--err);}
    .ferr{font-size:.72rem;color:var(--err);margin-top:3px;display:none;}
    .ferr.show{display:block;}
    /* card radio */
    .card-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px;}
    .card-opt input[type=radio]{display:none;}
    .card-opt label{display:flex;flex-direction:column;align-items:center;gap:5px;padding:11px 8px;border:1.5px solid var(--border);border-radius:9px;cursor:pointer;transition:all .15s;font-size:.77rem;font-weight:500;text-align:center;color:var(--muted);}
    .card-opt label .ic{font-size:1.3rem;}
    .card-opt input:checked+label{border-color:var(--blue);background:var(--blue-l);color:var(--blue);font-weight:700;}
    /* section sep */
    .sep{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--blue);margin:18px 0 10px;padding-bottom:5px;border-bottom:2px solid #dbeafe;}
    .sep:first-child{margin-top:0;}
    /* submit */
    .btn-sub{width:100%;padding:13px;background:var(--blue);color:#fff;font-size:.95rem;font-weight:700;border:none;border-radius:8px;cursor:pointer;margin-top:16px;font-family:inherit;display:flex;align-items:center;justify-content:center;gap:8px;transition:background .15s;}
    .btn-sub:hover{background:var(--blue-d);}
    .btn-sub:disabled{opacity:.6;cursor:not-allowed;}
    .spinner{width:15px;height:15px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none;}
    @keyframes spin{to{transform:rotate(360deg)}}
    .alert{padding:10px 14px;border-radius:7px;font-size:.85rem;margin-bottom:12px;display:none;}
    .alert.err{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;}
    .alert.ok{background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;}
    .alert.show{display:block;}
    .privacy{text-align:center;font-size:.7rem;color:var(--muted);margin-top:12px;line-height:1.5;}

    /* ── FOOTER ───────────────────────────────────── */
    .footer{background:#0f172a;color:rgba(255,255,255,.4);text-align:center;padding:24px;font-size:.78rem;}

    @media(max-width:500px){
      .form-card-head,.form-card-body{padding:20px;}
      .row{grid-template-columns:1fr;}
      .stats-bar{gap:20px;}
    }
  </style>
</head>
<body>

<!-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ -->
<section class="hero" id="top">
  <div class="hero-badge">
    <span></span>
    Démo gratuite disponible maintenant
  </div>

  <h1>
    Votre site conseiller<br>
    <span class="accent">qui génère des leads</span><br>
    automatiquement.
  </h1>

  <p class="subtitle">
    La plateforme tout-en-un pensée pour les conseillers immobiliers indépendants.<br>
    Site vitrine pro · CRM intégré · SEO local · Génération de mandats.
  </p>

  <div class="promises">
    <div class="promise"><span class="ico">✅</span> Accès démo immédiat</div>
    <div class="promise"><span class="ico">🔒</span> Sans engagement</div>
    <div class="promise"><span class="ico">⚡</span> Opérationnel en 48h</div>
    <div class="promise"><span class="ico">🎯</span> Personnalisé à votre zone</div>
  </div>

  <a href="#formulaire" class="btn-cta">
    Découvrir la plateforme
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
  </a>
  <p class="hero-note">Accès gratuit · 72h · Aucune carte bancaire requise</p>

  <div class="stats-bar">
    <div class="stat"><div class="stat-val">+200</div><div class="stat-lbl">Conseillers actifs</div></div>
    <div class="stat"><div class="stat-val">3,4×</div><div class="stat-lbl">Plus de mandats en moyenne</div></div>
    <div class="stat"><div class="stat-val">48h</div><div class="stat-lbl">Pour être en ligne</div></div>
    <div class="stat"><div class="stat-val">100%</div><div class="stat-lbl">Personnalisable</div></div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     FEATURES
══════════════════════════════════════════ -->
<section class="features">
  <div class="features-inner">
    <div class="section-label">La plateforme</div>
    <div class="section-title">Tout ce dont vous avez besoin<br>pour développer votre activité</div>
    <div class="feat-grid">
      <div class="feat-card"><div class="feat-ico">🏠</div><h3>Site vitrine pro</h3><p>Design premium, mobile-first, optimisé SEO local. Vos biens mis en valeur.</p></div>
      <div class="feat-card"><div class="feat-ico">📋</div><h3>Gestion des mandats</h3><p>Ajoutez, modifiez et publiez vos biens en quelques clics depuis votre admin.</p></div>
      <div class="feat-card"><div class="feat-ico">🎯</div><h3>Génération de leads</h3><p>Tunnels de conversion, estimation en ligne, landing pages vendeurs.</p></div>
      <div class="feat-card"><div class="feat-ico">🔍</div><h3>SEO local & GMB</h3><p>Soyez visible sur Google dans votre zone. Optimisation automatique.</p></div>
      <div class="feat-card"><div class="feat-ico">📊</div><h3>CRM intégré</h3><p>Suivez vos prospects, vos mandats et vos performances depuis un seul endroit.</p></div>
      <div class="feat-card"><div class="feat-ico">📱</div><h3>Réseaux sociaux</h3><p>Planifiez et publiez votre contenu sur Facebook, Instagram et LinkedIn.</p></div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     FORMULAIRE
══════════════════════════════════════════ -->
<section class="form-section" id="formulaire">
  <div class="form-inner">

    <div style="text-align:center;margin-bottom:32px;">
      <div class="section-label">Accès démo</div>
      <div class="section-title" style="margin-bottom:0">C'est gratuit, ça prend 60 secondes.</div>
    </div>

    <div class="form-card">
      <div class="form-card-head">
        <span class="step-badge">Étape 1 sur 3</span>
        <h2>Créez votre accès démo</h2>
        <p>Renseignez vos informations pour accéder à la démonstration complète.</p>
      </div>
      <div class="form-card-body">

        <div class="steps-bar">
          <div class="sbar-item active"><div class="sbar-dot">1</div><div class="sbar-lbl">Profil</div></div>
          <div class="sbar-line"></div>
          <div class="sbar-item pending"><div class="sbar-dot">2</div><div class="sbar-lbl">Sondage</div></div>
          <div class="sbar-line"></div>
          <div class="sbar-item pending"><div class="sbar-dot">3</div><div class="sbar-lbl">Démo</div></div>
        </div>

        <div class="alert err" id="alertErr"></div>
        <div class="alert ok" id="alertOk">Profil enregistré ! Redirection vers le sondage...</div>

        <form id="form" novalidate>
          <div class="sep">Vos coordonnées</div>

          <div class="row">
            <div class="fg">
              <label class="lbl">Prénom <span class="req">*</span></label>
              <input type="text" name="prenom" id="prenom" placeholder="Jean" autocomplete="given-name">
              <div class="ferr" id="err-prenom"></div>
            </div>
            <div class="fg">
              <label class="lbl">Nom <span class="req">*</span></label>
              <input type="text" name="nom" id="nom" placeholder="Dupont" autocomplete="family-name">
              <div class="ferr" id="err-nom"></div>
            </div>
          </div>

          <div class="fg">
            <label class="lbl">Email professionnel <span class="req">*</span></label>
            <input type="email" name="email" id="email" placeholder="jean.dupont@reseau.fr" autocomplete="email">
            <div class="ferr" id="err-email"></div>
          </div>

          <div class="row">
            <div class="fg">
              <label class="lbl">Téléphone <span class="req">*</span></label>
              <input type="tel" name="telephone" id="telephone" placeholder="06 12 34 56 78" autocomplete="tel">
              <div class="ferr" id="err-telephone"></div>
            </div>
            <div class="fg">
              <label class="lbl">Ville <span class="req">*</span></label>
              <input type="text" name="ville" id="ville" placeholder="Lyon" autocomplete="address-level2">
              <div class="ferr" id="err-ville"></div>
            </div>
          </div>

          <div class="fg">
            <label class="lbl">Réseau immobilier <span class="req">*</span></label>
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

          <div class="sep">Votre situation</div>

          <div class="fg">
            <label class="lbl">Vous êtes <span class="req">*</span></label>
            <div class="card-grid">
              <div class="card-opt"><input type="radio" name="statut_professionnel" id="sp1" value="Conseiller indépendant"><label for="sp1"><span class="ic">🏠</span>Conseiller indépendant</label></div>
              <div class="card-opt"><input type="radio" name="statut_professionnel" id="sp2" value="Agent immobilier"><label for="sp2"><span class="ic">🏢</span>Agent immobilier</label></div>
              <div class="card-opt"><input type="radio" name="statut_professionnel" id="sp3" value="Responsable d'agence"><label for="sp3"><span class="ic">👔</span>Responsable d'agence</label></div>
              <div class="card-opt"><input type="radio" name="statut_professionnel" id="sp4" value="En reconversion"><label for="sp4"><span class="ic">🔄</span>En reconversion</label></div>
            </div>
            <div class="ferr" id="err-statut_professionnel"></div>
          </div>

          <div class="fg">
            <label class="lbl">Situation actuelle en vente</label>
            <select name="situation_vente">
              <option value="">— Sélectionnez —</option>
              <option value="0-2 ventes/an">0 à 2 ventes par an</option>
              <option value="3-6 ventes/an">3 à 6 ventes par an</option>
              <option value="7-12 ventes/an">7 à 12 ventes par an</option>
              <option value="+12 ventes/an">Plus de 12 ventes par an</option>
              <option value="Débutant / pas encore">Débutant / pas encore de vente</option>
            </select>
          </div>

          <div class="fg">
            <label class="lbl">Votre objectif principal</label>
            <div class="card-grid">
              <div class="card-opt"><input type="radio" name="objectif_principal" id="obj1" value="Rentrer plus de mandats"><label for="obj1"><span class="ic">📋</span>Plus de mandats</label></div>
              <div class="card-opt"><input type="radio" name="objectif_principal" id="obj2" value="Trouver plus d'acheteurs"><label for="obj2"><span class="ic">👥</span>Plus d'acheteurs</label></div>
              <div class="card-opt"><input type="radio" name="objectif_principal" id="obj3" value="Augmenter ma visibilité"><label for="obj3"><span class="ic">📡</span>Plus de visibilité</label></div>
              <div class="card-opt"><input type="radio" name="objectif_principal" id="obj4" value="Automatiser ma prospection"><label for="obj4"><span class="ic">⚡</span>Automatiser</label></div>
            </div>
          </div>

          <div class="fg">
            <label class="lbl">Expérience internet pour trouver des clients</label>
            <div class="card-grid">
              <div class="card-opt"><input type="radio" name="experience_internet" id="ei1" value="Aucune"><label for="ei1"><span class="ic">🚫</span>Aucune</label></div>
              <div class="card-opt"><input type="radio" name="experience_internet" id="ei2" value="Quelques essais"><label for="ei2"><span class="ic">🌱</span>Quelques essais</label></div>
              <div class="card-opt"><input type="radio" name="experience_internet" id="ei3" value="Régulièrement"><label for="ei3"><span class="ic">💡</span>Régulièrement</label></div>
              <div class="card-opt"><input type="radio" name="experience_internet" id="ei4" value="Expert digital"><label for="ei4"><span class="ic">🚀</span>Expert digital</label></div>
            </div>
          </div>

          <button type="submit" class="btn-sub" id="btn">
            <span id="btnTxt">Accéder à la démo →</span>
            <div class="spinner" id="spin"></div>
          </button>

          <p class="privacy">🔒 Données confidentielles · Aucune prospection sans accord · Accès gratuit 72h</p>
        </form>
      </div>
    </div>

  </div>
</section>

<footer class="footer">
  © <?= date('Y') ?> Ecosystème Conseiller · Plateforme démo · Toutes les données sont sécurisées
</footer>

<script>
const form=document.getElementById('form'),alertErr=document.getElementById('alertErr'),alertOk=document.getElementById('alertOk'),btn=document.getElementById('btn'),btnTxt=document.getElementById('btnTxt'),spin=document.getElementById('spin');
function setLoad(on){btn.disabled=on;spin.style.display=on?'block':'none';btnTxt.style.display=on?'none':'inline';}
function clearErr(){document.querySelectorAll('.ferr').forEach(e=>{e.textContent='';e.classList.remove('show');});document.querySelectorAll('input,select').forEach(e=>e.classList.remove('err'));alertErr.classList.remove('show');}
function fieldErr(name,msg){const el=document.getElementById('err-'+name),inp=document.getElementById(name)||document.querySelector('[name="'+name+'"]');if(el){el.textContent=msg;el.classList.add('show');}if(inp)inp.classList.add('err');}
form.addEventListener('submit',async e=>{
  e.preventDefault();clearErr();setLoad(true);
  const d={
    prenom:form.prenom.value.trim(),nom:form.nom.value.trim(),
    email:form.email.value.trim(),telephone:form.telephone.value.trim(),
    ville:form.ville.value.trim(),reseau:form.reseau.value,
    statut_professionnel:(form.querySelector('[name=statut_professionnel]:checked')||{}).value||'',
    situation_vente:form.querySelector('[name=situation_vente]').value,
    objectif_principal:(form.querySelector('[name=objectif_principal]:checked')||{}).value||'',
    experience_internet:(form.querySelector('[name=experience_internet]:checked')||{}).value||'',
    redirect:'/sondage'
  };
  try{
    const r=await fetch('/api/prospect/register',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(d)});
    const j=await r.json();
    if(j.success){alertOk.classList.add('show');setTimeout(()=>{window.location.href='/sondage';},1000);}
    else if(j.errors){j.errors.forEach(err=>{
      const map={prénom:'prenom',nom:'nom',mail:'email','élép':'telephone',ville:'ville',réseau:'reseau',statut:'statut_professionnel'};
      const f=Object.entries(map).find(([k])=>err.toLowerCase().includes(k));
      if(f)fieldErr(f[1],err);else{alertErr.textContent=err;alertErr.classList.add('show');}
    });setLoad(false);}
    else{alertErr.textContent=j.message||'Erreur';alertErr.classList.add('show');setLoad(false);}
  }catch{alertErr.textContent='Erreur réseau, réessayez.';alertErr.classList.add('show');setLoad(false);}
});
</script>
</body>
</html>
