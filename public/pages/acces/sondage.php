<?php
// Récupérer le prospect depuis la session cookie
$prospect = null;
try {
    $token = $_COOKIE['demo_access'] ?? '';
    if ($token !== '') {
        $pdo  = ProspectsDB::getInstance();
        $stmt = $pdo->prepare("
            SELECT p.id, p.prenom, p.nom, p.statut_professionnel
            FROM prospects_sessions ps
            JOIN prospects p ON p.id = ps.prospect_id
            WHERE ps.session_token = ? AND ps.expire_at > NOW() AND p.statut = 'valide'
            LIMIT 1
        ");
        $stmt->execute([$token]);
        $prospect = $stmt->fetch();
    }
} catch (Exception $e) {
    error_log('Sondage: ' . $e->getMessage());
}

if (!$prospect) {
    header('Location: /acces', true, 302);
    exit;
}

$prospectId = (int)$prospect['id'];
$prenom     = htmlspecialchars($prospect['prenom'] ?? 'Conseiller');

// Vérifier si sondage déjà terminé
try {
    $pdo2 = ProspectsDB::getInstance();
    $row  = $pdo2->prepare("SELECT statut FROM eppe_responses WHERE prospect_id = ? LIMIT 1");
    $row->execute([$prospectId]);
    $eppe = $row->fetch();
    if ($eppe && $eppe['statut'] === 'termine') {
        header('Location: /', true, 302);
        exit;
    }
} catch (Exception $e) {}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex,nofollow">
  <title>Sondage EPPE — Ecosystème Conseiller</title>
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
      --blue:#1a56db;--blue-d:#1347c4;--blue-l:#eff6ff;
      --bg:#f0f4ff;--card:#fff;--text:#1e293b;--muted:#64748b;
      --border:#e2e8f0;--err:#ef4444;--ok:#22c55e;
      --r:14px;--sh:0 8px 40px rgba(26,86,219,.13);
    }
    body{min-height:100vh;background:var(--bg);font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;color:var(--text);padding:0;}
    /* Top bar */
    .topbar{background:var(--blue);color:#fff;padding:14px 24px;display:flex;align-items:center;justify-content:space-between;}
    .topbar-brand{display:flex;align-items:center;gap:9px;font-weight:700;font-size:.95rem;}
    .topbar-step{font-size:.8rem;opacity:.8;}
    /* Progress */
    .progress-wrap{background:#1347c4;padding:0 24px 16px;}
    .progress-info{display:flex;justify-content:space-between;font-size:.78rem;color:rgba(255,255,255,.75);margin-bottom:8px;}
    .progress-bar{height:5px;background:rgba(255,255,255,.25);border-radius:99px;overflow:hidden;}
    .progress-fill{height:100%;background:#fff;border-radius:99px;transition:width .4s ease;}
    /* Sections nav */
    .sections-nav{background:#fff;border-bottom:1px solid var(--border);padding:0 24px;display:flex;gap:0;overflow-x:auto;}
    .nav-item{padding:12px 16px;font-size:.78rem;font-weight:600;color:var(--muted);border-bottom:2px solid transparent;white-space:nowrap;cursor:default;}
    .nav-item.active{color:var(--blue);border-color:var(--blue);}
    .nav-item.done{color:var(--ok);}
    /* Main */
    .main{max-width:680px;margin:0 auto;padding:32px 20px 60px;}
    /* Question card */
    .q-card{background:var(--card);border-radius:var(--r);box-shadow:var(--sh);padding:32px;margin-bottom:20px;display:none;}
    .q-card.active{display:block;animation:fadeIn .3s ease;}
    @keyframes fadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
    .q-num{font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--blue);margin-bottom:8px;}
    .q-text{font-size:1.15rem;font-weight:700;line-height:1.35;margin-bottom:20px;}
    .q-sub{font-size:.85rem;color:var(--muted);margin-top:-14px;margin-bottom:20px;line-height:1.5;}
    /* Options grid */
    .opts{display:grid;gap:10px;}
    .opts.cols-2{grid-template-columns:1fr 1fr;}
    .opts.cols-3{grid-template-columns:1fr 1fr 1fr;}
    .opt{position:relative;}
    .opt input[type=radio],.opt input[type=checkbox]{display:none;}
    .opt label{display:flex;align-items:center;gap:12px;padding:13px 16px;border:1.5px solid var(--border);border-radius:10px;cursor:pointer;transition:all .15s;font-size:.88rem;font-weight:500;color:var(--text);}
    .opt-icon{font-size:1.3rem;flex-shrink:0;}
    .opt input:checked+label{border-color:var(--blue);background:var(--blue-l);color:var(--blue);font-weight:600;}
    .opt-card label{flex-direction:column;text-align:center;padding:16px 12px;gap:8px;}
    .opt-card label .opt-icon{font-size:1.8rem;}
    /* Inputs */
    .inp{width:100%;padding:12px 14px;border:1.5px solid var(--border);border-radius:9px;font-size:.93rem;color:var(--text);background:#fff;font-family:inherit;outline:none;transition:border-color .15s;}
    .inp:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(26,86,219,.1);}
    textarea.inp{resize:vertical;min-height:90px;}
    /* Scale */
    .scale{display:flex;gap:6px;flex-wrap:wrap;}
    .scale-opt input[type=radio]{display:none;}
    .scale-opt label{width:44px;height:44px;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;font-weight:700;font-size:.9rem;transition:all .15s;}
    .scale-opt input:checked+label{background:var(--blue);color:#fff;border-color:var(--blue);}
    .scale-legend{display:flex;justify-content:space-between;font-size:.72rem;color:var(--muted);margin-top:6px;}
    /* Nav buttons */
    .q-nav{display:flex;justify-content:space-between;align-items:center;margin-top:22px;}
    .btn-prev,.btn-next,.btn-submit{padding:11px 24px;border-radius:8px;font-size:.9rem;font-weight:700;cursor:pointer;border:none;font-family:inherit;display:flex;align-items:center;gap:8px;transition:all .15s;}
    .btn-prev{background:#f1f5f9;color:var(--muted);}
    .btn-prev:hover{background:var(--border);}
    .btn-next{background:var(--blue);color:#fff;}
    .btn-next:hover{background:var(--blue-d);}
    .btn-submit{background:var(--ok);color:#fff;width:100%;justify-content:center;padding:14px;}
    .btn-submit:hover{background:#16a34a;}
    .btn-skip{font-size:.78rem;color:var(--muted);background:none;border:none;cursor:pointer;text-decoration:underline;}
    /* Final */
    .final-card{background:var(--card);border-radius:var(--r);box-shadow:var(--sh);padding:40px;text-align:center;display:none;}
    .final-card.active{display:block;}
    .final-icon{font-size:3.5rem;margin-bottom:16px;}
    .final-card h2{font-size:1.5rem;font-weight:800;margin-bottom:10px;}
    .final-card p{color:var(--muted);font-size:.93rem;line-height:1.6;margin-bottom:24px;}
    /* Spinner */
    .spinner{width:16px;height:16px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;}
    @keyframes spin{to{transform:rotate(360deg)}}
    @media(max-width:500px){.opts.cols-2,.opts.cols-3{grid-template-columns:1fr 1fr;}.q-card{padding:20px;}.main{padding:20px 12px 60px;}}
  </style>
</head>
<body>

<div class="topbar">
  <div class="topbar-brand">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    Ecosystème Conseiller
  </div>
  <div class="topbar-step">Sondage EPPE — Étape 2/3</div>
</div>

<div class="progress-wrap">
  <div class="progress-info">
    <span id="progressLabel">Question 1 sur 20</span>
    <span id="progressPct">5%</span>
  </div>
  <div class="progress-bar"><div class="progress-fill" id="progressFill" style="width:5%"></div></div>
</div>

<div class="sections-nav">
  <div class="nav-item active" id="nav-E">🧠 Expérience</div>
  <div class="nav-item" id="nav-P">🔥 Problème</div>
  <div class="nav-item" id="nav-Proj">🎯 Projection</div>
  <div class="nav-item" id="nav-Emp">🚧 Empêchement</div>
  <div class="nav-item" id="nav-Q">⚡ Qualification</div>
</div>

<div class="main">

<!-- ═══ SECTION E : EXPÉRIENCE ═══ -->

<div class="q-card active" data-q="1" data-section="E">
  <div class="q-num">EXPÉRIENCE · 1/6</div>
  <div class="q-text">Depuis combien de temps es-tu conseiller immobilier ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="exp_anciennete" id="ea1" value="Moins de 6 mois"><label for="ea1"><span class="opt-icon">🌱</span>Moins de 6 mois</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_anciennete" id="ea2" value="6 mois à 2 ans"><label for="ea2"><span class="opt-icon">📈</span>6 mois à 2 ans</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_anciennete" id="ea3" value="2 à 5 ans"><label for="ea3"><span class="opt-icon">💼</span>2 à 5 ans</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_anciennete" id="ea4" value="Plus de 5 ans"><label for="ea4"><span class="opt-icon">🏆</span>Plus de 5 ans</label></div>
  </div>
  <div class="q-nav"><span></span><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="2" data-section="E">
  <div class="q-num">EXPÉRIENCE · 2/6</div>
  <div class="q-text">Combien de mandats rentres-tu en moyenne par mois ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="exp_mandats_mois" id="em1" value="0-1 mandat"><label for="em1"><span class="opt-icon">😅</span>0 à 1 mandat</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_mandats_mois" id="em2" value="2-3 mandats"><label for="em2"><span class="opt-icon">🙂</span>2 à 3 mandats</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_mandats_mois" id="em3" value="4-6 mandats"><label for="em3"><span class="opt-icon">😊</span>4 à 6 mandats</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_mandats_mois" id="em4" value="+6 mandats"><label for="em4"><span class="opt-icon">🚀</span>Plus de 6</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="3" data-section="E">
  <div class="q-num">EXPÉRIENCE · 3/6</div>
  <div class="q-text">Combien de ventes réalises-tu par an ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="exp_ventes_an" id="ev1" value="0-2 ventes/an"><label for="ev1"><span class="opt-icon">🌱</span>0 à 2</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_ventes_an" id="ev2" value="3-6 ventes/an"><label for="ev2"><span class="opt-icon">📊</span>3 à 6</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_ventes_an" id="ev3" value="7-12 ventes/an"><label for="ev3"><span class="opt-icon">💪</span>7 à 12</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_ventes_an" id="ev4" value="+12 ventes/an"><label for="ev4"><span class="opt-icon">🏆</span>Plus de 12</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="4" data-section="E">
  <div class="q-num">EXPÉRIENCE · 4/6</div>
  <div class="q-text">D'où viennent principalement tes clients aujourd'hui ?</div>
  <div class="q-sub">Plusieurs choix possibles</div>
  <div class="opts">
    <div class="opt"><input type="checkbox" name="exp_sources_clients" id="esc1" value="Bouche à oreille / recommandation"><label for="esc1"><span class="opt-icon">🗣️</span>Bouche à oreille / recommandation</label></div>
    <div class="opt"><input type="checkbox" name="exp_sources_clients" id="esc2" value="Prospection terrain"><label for="esc2"><span class="opt-icon">🚶</span>Prospection terrain</label></div>
    <div class="opt"><input type="checkbox" name="exp_sources_clients" id="esc3" value="Réseaux sociaux"><label for="esc3"><span class="opt-icon">📱</span>Réseaux sociaux</label></div>
    <div class="opt"><input type="checkbox" name="exp_sources_clients" id="esc4" value="Site internet / SEO"><label for="esc4"><span class="opt-icon">🌐</span>Site internet / SEO</label></div>
    <div class="opt"><input type="checkbox" name="exp_sources_clients" id="esc5" value="Publicité (Facebook Ads, Google)"><label for="esc5"><span class="opt-icon">📢</span>Publicité (Facebook Ads, Google)</label></div>
    <div class="opt"><input type="checkbox" name="exp_sources_clients" id="esc6" value="Portails immobiliers"><label for="esc6"><span class="opt-icon">🏠</span>Portails (SeLoger, LBC…)</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="5" data-section="E">
  <div class="q-num">EXPÉRIENCE · 5/6</div>
  <div class="q-text">Utilises-tu des outils digitaux pour générer des leads ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="exp_outils_digitaux" id="eod1" value="1"><label for="eod1"><span class="opt-icon">✅</span>Oui, régulièrement</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_outils_digitaux" id="eod2" value="0"><label for="eod2"><span class="opt-icon">❌</span>Non, pas du tout</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_outils_digitaux" id="eod3" value="2"><label for="eod3"><span class="opt-icon">🔄</span>J'essaie parfois</label></div>
    <div class="opt opt-card"><input type="radio" name="exp_outils_digitaux" id="eod4" value="3"><label for="eod4"><span class="opt-icon">🤔</span>Je ne sais pas comment</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="6" data-section="E">
  <div class="q-num">EXPÉRIENCE · 6/6</div>
  <div class="q-text">As-tu déjà testé des solutions marketing ? Avec quels résultats ?</div>
  <div class="opts">
    <div class="opt"><input type="radio" name="pb_solutions_testees" id="pst1" value="Non, jamais essayé"><label for="pst1"><span class="opt-icon">🙈</span>Non, jamais essayé</label></div>
    <div class="opt"><input type="radio" name="pb_solutions_testees" id="pst2" value="Oui, sans résultat"><label for="pst2"><span class="opt-icon">😞</span>Oui, sans résultat concret</label></div>
    <div class="opt"><input type="radio" name="pb_solutions_testees" id="pst3" value="Oui, résultats mitigés"><label for="pst3"><span class="opt-icon">😐</span>Oui, résultats mitigés</label></div>
    <div class="opt"><input type="radio" name="pb_solutions_testees" id="pst4" value="Oui, bons résultats"><label for="pst4"><span class="opt-icon">😊</span>Oui, avec de bons résultats</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<!-- ═══ SECTION P : PROBLÈME ═══ -->

<div class="q-card" data-q="7" data-section="P">
  <div class="q-num">PROBLÈME · 1/4</div>
  <div class="q-text">Qu'est-ce qui te bloque pour rentrer plus de mandats ?</div>
  <div class="opts">
    <div class="opt"><input type="radio" name="pb_blocage_mandats" id="pb1" value="Manque de visibilité locale"><label for="pb1"><span class="opt-icon">📡</span>Manque de visibilité locale</label></div>
    <div class="opt"><input type="radio" name="pb_blocage_mandats" id="pb2" value="Pas assez de contacts vendeurs"><label for="pb2"><span class="opt-icon">📞</span>Pas assez de contacts vendeurs</label></div>
    <div class="opt"><input type="radio" name="pb_blocage_mandats" id="pb3" value="Concurrence trop forte"><label for="pb3"><span class="opt-icon">⚔️</span>Concurrence trop forte</label></div>
    <div class="opt"><input type="radio" name="pb_blocage_mandats" id="pb4" value="Manque de méthode / organisation"><label for="pb4"><span class="opt-icon">📋</span>Manque de méthode / organisation</label></div>
    <div class="opt"><input type="radio" name="pb_blocage_mandats" id="pb5" value="Pas de système d'acquisition"><label for="pb5"><span class="opt-icon">⚙️</span>Pas de système d'acquisition automatique</label></div>
    <div class="opt"><input type="radio" name="pb_blocage_mandats" id="pb6" value="Autre"><label for="pb6"><span class="opt-icon">💬</span>Autre</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="8" data-section="P">
  <div class="q-num">PROBLÈME · 2/4</div>
  <div class="q-text">As-tu du mal à trouver des vendeurs, des acheteurs, ou les deux ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="pb_manque_vendeurs_acheteurs" id="pva1" value="Vendeurs surtout"><label for="pva1"><span class="opt-icon">🏡</span>Vendeurs surtout</label></div>
    <div class="opt opt-card"><input type="radio" name="pb_manque_vendeurs_acheteurs" id="pva2" value="Acheteurs surtout"><label for="pva2"><span class="opt-icon">🔑</span>Acheteurs surtout</label></div>
    <div class="opt opt-card"><input type="radio" name="pb_manque_vendeurs_acheteurs" id="pva3" value="Les deux"><label for="pva3"><span class="opt-icon">⚖️</span>Les deux</label></div>
    <div class="opt opt-card"><input type="radio" name="pb_manque_vendeurs_acheteurs" id="pva4" value="Ça va pour l'instant"><label for="pva4"><span class="opt-icon">✅</span>Ça va pour l'instant</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="9" data-section="P">
  <div class="q-num">PROBLÈME · 3/4</div>
  <div class="q-text">Qu'est-ce qui te frustre le plus dans ton activité aujourd'hui ?</div>
  <div class="opts">
    <div class="opt"><input type="radio" name="pb_frustration" id="pf1" value="Travailler beaucoup pour peu de résultats"><label for="pf1"><span class="opt-icon">😓</span>Travailler beaucoup pour peu de résultats</label></div>
    <div class="opt"><input type="radio" name="pb_frustration" id="pf2" value="Être invisible face à la concurrence"><label for="pf2"><span class="opt-icon">👻</span>Être invisible face à la concurrence</label></div>
    <div class="opt"><input type="radio" name="pb_frustration" id="pf3" value="Ne pas savoir quoi faire pour progresser"><label for="pf3"><span class="opt-icon">🤷</span>Ne pas savoir quoi faire pour progresser</label></div>
    <div class="opt"><input type="radio" name="pb_frustration" id="pf4" value="Dépendre uniquement du réseau/recommandations"><label for="pf4"><span class="opt-icon">🔗</span>Dépendre uniquement du bouche-à-oreille</label></div>
    <div class="opt"><input type="radio" name="pb_frustration" id="pf5" value="Manque de revenus réguliers"><label for="pf5"><span class="opt-icon">💸</span>Manque de revenus réguliers</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="10" data-section="P">
  <div class="q-num">PROBLÈME · 4/4</div>
  <div class="q-text">As-tu l'impression d'être en forte concurrence avec d'autres agents sur ta zone ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="pb_concurrence" id="pc1" value="1"><label for="pc1"><span class="opt-icon">🔥</span>Oui, très forte concurrence</label></div>
    <div class="opt opt-card"><input type="radio" name="pb_concurrence" id="pc2" value="0"><label for="pc2"><span class="opt-icon">😌</span>Non, ma zone est OK</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<!-- ═══ SECTION PROJ : PROJECTION ═══ -->

<div class="q-card" data-q="11" data-section="Proj">
  <div class="q-num">PROJECTION · 1/4</div>
  <div class="q-text">Combien de mandats aimerais-tu rentrer chaque mois idéalement ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="proj_mandats_mois_cible" id="pmc1" value="2-3 mandats/mois"><label for="pmc1"><span class="opt-icon">🎯</span>2 à 3</label></div>
    <div class="opt opt-card"><input type="radio" name="proj_mandats_mois_cible" id="pmc2" value="4-6 mandats/mois"><label for="pmc2"><span class="opt-icon">🚀</span>4 à 6</label></div>
    <div class="opt opt-card"><input type="radio" name="proj_mandats_mois_cible" id="pmc3" value="7-10 mandats/mois"><label for="pmc3"><span class="opt-icon">💥</span>7 à 10</label></div>
    <div class="opt opt-card"><input type="radio" name="proj_mandats_mois_cible" id="pmc4" value="+10 mandats/mois"><label for="pmc4"><span class="opt-icon">👑</span>Plus de 10</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="12" data-section="Proj">
  <div class="q-num">PROJECTION · 2/4</div>
  <div class="q-text">Quel revenu mensuel souhaites-tu atteindre ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="proj_revenu_cible" id="prc1" value="Moins de 3 000€/mois"><label for="prc1"><span class="opt-icon">💶</span>Moins de 3 000€</label></div>
    <div class="opt opt-card"><input type="radio" name="proj_revenu_cible" id="prc2" value="3 000-5 000€/mois"><label for="prc2"><span class="opt-icon">💰</span>3 000 – 5 000€</label></div>
    <div class="opt opt-card"><input type="radio" name="proj_revenu_cible" id="prc3" value="5 000-10 000€/mois"><label for="prc3"><span class="opt-icon">🏦</span>5 000 – 10 000€</label></div>
    <div class="opt opt-card"><input type="radio" name="proj_revenu_cible" id="prc4" value="+10 000€/mois"><label for="prc4"><span class="opt-icon">🤑</span>Plus de 10 000€</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="13" data-section="Proj">
  <div class="q-num">PROJECTION · 3/4</div>
  <div class="q-text">Préfères-tu prospecter activement ou attirer des clients automatiquement ?</div>
  <div class="opts">
    <div class="opt"><input type="radio" name="proj_mode_prospection" id="pmp1" value="Prospecter activement (terrain, phoning)"><label for="pmp1"><span class="opt-icon">🏃</span>Prospecter activement (terrain, phoning)</label></div>
    <div class="opt"><input type="radio" name="proj_mode_prospection" id="pmp2" value="Attirer automatiquement (web, contenu, SEO)"><label for="pmp2"><span class="opt-icon">🧲</span>Attirer automatiquement (web, contenu, SEO)</label></div>
    <div class="opt"><input type="radio" name="proj_mode_prospection" id="pmp3" value="Les deux en parallèle"><label for="pmp3"><span class="opt-icon">⚡</span>Les deux en parallèle</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="14" data-section="Proj">
  <div class="q-num">PROJECTION · 4/4</div>
  <div class="q-text">Quels résultats aimerais-tu obtenir dans les 3 à 6 prochains mois ?</div>
  <div class="opts">
    <div class="opt"><input type="radio" name="proj_objectif_3_6_mois" id="po1" value="Avoir un site qui génère des leads"><label for="po1"><span class="opt-icon">🌐</span>Avoir un site qui génère des leads</label></div>
    <div class="opt"><input type="radio" name="proj_objectif_3_6_mois" id="po2" value="Doubler mes mandats"><label for="po2"><span class="opt-icon">×2</span>Doubler mes mandats</label></div>
    <div class="opt"><input type="radio" name="proj_objectif_3_6_mois" id="po3" value="Être connu sur ma zone"><label for="po3"><span class="opt-icon">📍</span>Être reconnu sur ma zone</label></div>
    <div class="opt"><input type="radio" name="proj_objectif_3_6_mois" id="po4" value="Automatiser ma prospection"><label for="po4"><span class="opt-icon">🤖</span>Automatiser ma prospection</label></div>
    <div class="opt"><input type="radio" name="proj_objectif_3_6_mois" id="po5" value="Atteindre mes objectifs de revenu"><label for="po5"><span class="opt-icon">💎</span>Atteindre mes objectifs de revenu</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<!-- ═══ SECTION EMP : EMPÊCHEMENT ═══ -->

<div class="q-card" data-q="15" data-section="Emp">
  <div class="q-num">EMPÊCHEMENT · 1/3</div>
  <div class="q-text">Qu'est-ce qui t'empêche d'atteindre tes objectifs aujourd'hui ?</div>
  <div class="opts">
    <div class="opt"><input type="radio" name="emp_frein_principal" id="ef1" value="Manque de temps"><label for="ef1"><span class="opt-icon">⏰</span>Manque de temps</label></div>
    <div class="opt"><input type="radio" name="emp_frein_principal" id="ef2" value="Manque de méthode"><label for="ef2"><span class="opt-icon">🗺️</span>Manque de méthode / je ne sais pas comment faire</label></div>
    <div class="opt"><input type="radio" name="emp_frein_principal" id="ef3" value="Manque de visibilité"><label for="ef3"><span class="opt-icon">👁️</span>Manque de visibilité / personne ne me connaît</label></div>
    <div class="opt"><input type="radio" name="emp_frein_principal" id="ef4" value="Manque de budget"><label for="ef4"><span class="opt-icon">💳</span>Manque de budget pour investir</label></div>
    <div class="opt"><input type="radio" name="emp_frein_principal" id="ef5" value="Manque de confiance"><label for="ef5"><span class="opt-icon">🧠</span>Manque de confiance en moi</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="16" data-section="Emp">
  <div class="q-num">EMPÊCHEMENT · 2/3</div>
  <div class="q-text">Quels freins t'empêchent d'investir dans ton développement ?</div>
  <div class="q-sub">Plusieurs choix possibles</div>
  <div class="opts">
    <div class="opt"><input type="checkbox" name="emp_type_frein" id="etf1" value="Peur de ne pas avoir de retour sur investissement"><label for="etf1"><span class="opt-icon">😰</span>Peur de ne pas avoir de retour sur investissement</label></div>
    <div class="opt"><input type="checkbox" name="emp_type_frein" id="etf2" value="Budget limité actuellement"><label for="etf2"><span class="opt-icon">💰</span>Budget limité actuellement</label></div>
    <div class="opt"><input type="checkbox" name="emp_type_frein" id="etf3" value="Je ne sais pas par où commencer"><label for="etf3"><span class="opt-icon">🤔</span>Je ne sais pas par où commencer</label></div>
    <div class="opt"><input type="checkbox" name="emp_type_frein" id="etf4" value="Déjà essayé, sans résultat"><label for="etf4"><span class="opt-icon">😤</span>Déjà essayé des choses, sans résultat</label></div>
    <div class="opt"><input type="checkbox" name="emp_type_frein" id="etf5" value="Pas assez de temps pour apprendre"><label for="etf5"><span class="opt-icon">⌛</span>Pas assez de temps pour apprendre de nouvelles choses</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="17" data-section="Emp">
  <div class="q-num">EMPÊCHEMENT · 3/3</div>
  <div class="q-text">As-tu déjà essayé de changer les choses sans réussir à progresser ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="emp_echecs_passes" id="eep1" value="1"><label for="eep1"><span class="opt-icon">😞</span>Oui, j'ai essayé sans succès</label></div>
    <div class="opt opt-card"><input type="radio" name="emp_echecs_passes" id="eep2" value="0"><label for="eep2"><span class="opt-icon">🆕</span>Non, je n'ai pas encore essayé</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<!-- ═══ SECTION Q : QUALIFICATION ═══ -->

<div class="q-card" data-q="18" data-section="Q">
  <div class="q-num">QUALIFICATION · 1/3</div>
  <div class="q-text">Es-tu prêt à investir dans ton développement si la solution est adaptée à tes besoins ?</div>
  <div class="opts">
    <div class="opt"><input type="radio" name="qual_pret_investir" id="qpi1" value="Oui, dès maintenant"><label for="qpi1"><span class="opt-icon">🟢</span>Oui, dès maintenant si ça correspond</label></div>
    <div class="opt"><input type="radio" name="qual_pret_investir" id="qpi2" value="Oui, dans les prochaines semaines"><label for="qpi2"><span class="opt-icon">🟡</span>Oui, dans les prochaines semaines</label></div>
    <div class="opt"><input type="radio" name="qual_pret_investir" id="qpi3" value="Je dois réfléchir d'abord"><label for="qpi3"><span class="opt-icon">🟠</span>Je dois réfléchir / comparer d'abord</label></div>
    <div class="opt"><input type="radio" name="qual_pret_investir" id="qpi4" value="Non, pas pour l'instant"><label for="qpi4"><span class="opt-icon">🔴</span>Non, pas pour l'instant</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="19" data-section="Q">
  <div class="q-num">QUALIFICATION · 2/3</div>
  <div class="q-text">Sous combien de temps veux-tu voir des résultats concrets ?</div>
  <div class="opts cols-2">
    <div class="opt opt-card"><input type="radio" name="qual_delai_resultats" id="qdr1" value="Le plus vite possible"><label for="qdr1"><span class="opt-icon">⚡</span>Le plus vite possible</label></div>
    <div class="opt opt-card"><input type="radio" name="qual_delai_resultats" id="qdr2" value="Dans 1 à 3 mois"><label for="qdr2"><span class="opt-icon">📅</span>Dans 1 à 3 mois</label></div>
    <div class="opt opt-card"><input type="radio" name="qual_delai_resultats" id="qdr3" value="Dans 3 à 6 mois"><label for="qdr3"><span class="opt-icon">🗓️</span>Dans 3 à 6 mois</label></div>
    <div class="opt opt-card"><input type="radio" name="qual_delai_resultats" id="qdr4" value="Je suis patient"><label for="qdr4"><span class="opt-icon">🧘</span>Je suis patient</label></div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next" onclick="next()">Suivant →</button></div>
</div>

<div class="q-card" data-q="20" data-section="Q">
  <div class="q-num">QUALIFICATION · 3/3</div>
  <div class="q-text">Sur une échelle de 1 à 10, à quel point es-tu motivé pour développer ton activité ?</div>
  <div class="scale" id="scale-motivation">
    <?php for ($i = 1; $i <= 10; $i++): ?>
    <div class="scale-opt"><input type="radio" name="qual_motivation_score" id="qm<?= $i ?>" value="<?= $i ?>"><label for="qm<?= $i ?>"><?= $i ?></label></div>
    <?php endfor; ?>
  </div>
  <div class="scale-legend"><span>Pas du tout</span><span>Extrêmement motivé</span></div>
  <div style="margin-top:24px">
    <label style="font-size:.85rem;font-weight:600;margin-bottom:8px;display:block">Acceptes-tu de changer ta façon de travailler si c'est nécessaire ?</label>
    <div class="opts cols-2" style="margin-top:6px">
      <div class="opt opt-card"><input type="radio" name="qual_pret_changer" id="qpc1" value="1"><label for="qpc1"><span class="opt-icon">💪</span>Oui, totalement</label></div>
      <div class="opt opt-card"><input type="radio" name="qual_pret_changer" id="qpc2" value="0"><label for="qpc2"><span class="opt-icon">🤔</span>Ça dépend</label></div>
    </div>
  </div>
  <div class="q-nav"><button class="btn-prev" onclick="prev()">← Retour</button><button class="btn-next btn-submit" id="btnSubmit" onclick="submitSurvey()">Terminer le sondage ✓</button></div>
</div>

<!-- ═══ ÉCRAN FINAL ═══ -->
<div class="final-card" id="finalCard">
  <div class="final-icon">🎉</div>
  <h2>Merci <?= $prenom ?> !</h2>
  <p>Ton profil a été analysé. Tu vas être redirigé vers la plateforme de démonstration personnalisée.<br><br>Explore librement toutes les fonctionnalités pendant 72h.</p>
  <div id="finalRedirect" style="color:var(--muted);font-size:.85rem;margin-top:8px">Redirection dans <span id="countdown">3</span>s...</div>
</div>

</div><!-- .main -->

<script>
const TOTAL = 20;
let current = 1;

const questions = document.querySelectorAll('.q-card');
const sections  = { E:[1,6], P:[7,10], Proj:[11,14], Emp:[15,17], Q:[18,20] };
const navIds    = { E:'nav-E', P:'nav-P', Proj:'nav-Proj', Emp:'nav-Emp', Q:'nav-Q' };

function updateUI() {
  // Show/hide questions
  questions.forEach(q => {
    q.classList.toggle('active', +q.dataset.q === current);
  });
  // Progress
  const pct = Math.round(((current - 1) / TOTAL) * 100);
  document.getElementById('progressFill').style.width = pct + '%';
  document.getElementById('progressLabel').textContent = `Question ${current} sur ${TOTAL}`;
  document.getElementById('progressPct').textContent   = pct + '%';
  // Nav highlight
  Object.entries(sections).forEach(([key, [min, max]]) => {
    const el = document.getElementById(navIds[key]);
    if (!el) return;
    if (current >= min && current <= max) {
      el.className = 'nav-item active';
    } else if (current > max) {
      el.className = 'nav-item done';
    } else {
      el.className = 'nav-item';
    }
  });
  // Scroll
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function next() { if (current < TOTAL) { current++; updateUI(); } }
function prev() { if (current > 1)     { current--; updateUI(); } }

function collectData() {
  const data = { prospect_id: <?= $prospectId ?> };
  // Radio
  document.querySelectorAll('input[type=radio]:checked').forEach(r => { data[r.name] = r.value; });
  // Checkbox (JSON array)
  const cbGroups = {};
  document.querySelectorAll('input[type=checkbox]:checked').forEach(c => {
    if (!cbGroups[c.name]) cbGroups[c.name] = [];
    cbGroups[c.name].push(c.value);
  });
  Object.assign(data, cbGroups);
  return data;
}

async function submitSurvey() {
  const btn = document.getElementById('btnSubmit');
  btn.disabled = true;
  btn.innerHTML = '<div class="spinner"></div> Analyse en cours...';

  const data = collectData();
  try {
    const r = await fetch('/api/prospect/sondage', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });
    const j = await r.json();
    if (j.success) {
      // Afficher écran final
      document.querySelectorAll('.q-card').forEach(q => q.classList.remove('active'));
      document.querySelector('.progress-wrap').style.display = 'none';
      document.querySelector('.sections-nav').style.display  = 'none';
      document.getElementById('finalCard').classList.add('active');
      let c = 3;
      const t = setInterval(() => {
        document.getElementById('countdown').textContent = --c;
        if (c <= 0) { clearInterval(t); window.location.href = '/'; }
      }, 1000);
    } else {
      btn.disabled = false;
      btn.innerHTML = 'Terminer le sondage ✓';
      alert('Erreur : ' + (j.message || 'réessayez'));
    }
  } catch {
    btn.disabled = false;
    btn.innerHTML = 'Terminer le sondage ✓';
    alert('Erreur réseau, réessayez.');
  }
}

// Sauvegarde auto toutes les 60s
setInterval(async () => {
  const data = { ...collectData(), autosave: true };
  try { await fetch('/api/prospect/sondage', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(data) }); } catch {}
}, 60000);

updateUI();
</script>
</body>
</html>
