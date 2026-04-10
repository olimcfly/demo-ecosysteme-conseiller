<?php
// ============================================================
// API — Sauvegarde & scoring sondage EPPE
// ============================================================

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false]);
    exit;
}

$input      = json_decode(file_get_contents('php://input'), true) ?? [];
$prospectId = (int)($input['prospect_id'] ?? 0);
$autosave   = !empty($input['autosave']);

if ($prospectId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID prospect manquant']);
    exit;
}

// ── Vérifier que le prospect est bien authentifié ────────────
$cookieToken = $_COOKIE['demo_access'] ?? '';
if ($cookieToken === '') {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit;
}
try {
    $pdo  = ProspectsDB::getInstance();
    $stmt = $pdo->prepare("SELECT p.id FROM prospects_sessions ps JOIN prospects p ON p.id=ps.prospect_id WHERE ps.session_token=? AND ps.expire_at>NOW() AND p.id=? LIMIT 1");
    $stmt->execute([$cookieToken, $prospectId]);
    if (!$stmt->fetch()) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Session invalide']);
        exit;
    }
} catch (PDOException $e) {
    error_log('Sondage auth error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false]);
    exit;
}

// ── Extraire les réponses ─────────────────────────────────────
$s = fn(string $k) => trim((string)($input[$k] ?? ''));
$b = fn(string $k) => isset($input[$k]) ? ($input[$k] === '1' || $input[$k] === true ? 1 : 0) : null;

$exp_sources   = is_array($input['exp_sources_clients'] ?? null) ? json_encode($input['exp_sources_clients']) : null;
$emp_type_frein= is_array($input['emp_type_frein'] ?? null)      ? json_encode($input['emp_type_frein'])      : null;
$motivation    = isset($input['qual_motivation_score']) ? (int)$input['qual_motivation_score'] : null;

// ── Scoring ───────────────────────────────────────────────────
function scoreExperience(array $d): int {
    $score = 0;
    $anc = $d['exp_anciennete'] ?? '';
    if (str_contains($anc, 'Plus de 5')) $score += 30;
    elseif (str_contains($anc, '2 à 5'))  $score += 20;
    elseif (str_contains($anc, '6 mois')) $score += 10;

    $ventes = $d['exp_ventes_an'] ?? '';
    if (str_contains($ventes, '+12'))   $score += 40;
    elseif (str_contains($ventes, '7')) $score += 30;
    elseif (str_contains($ventes, '3')) $score += 15;

    $outils = (string)($d['exp_outils_digitaux'] ?? '');
    if ($outils === '1') $score += 20; // régulièrement
    elseif ($outils === '2') $score += 10;

    return min($score, 100);
}

function scoreProjection(array $d): int {
    $score = 0;
    $rev = $d['proj_revenu_cible'] ?? '';
    if (str_contains($rev, '+10 000'))   $score += 40;
    elseif (str_contains($rev, '5 000')) $score += 30;
    elseif (str_contains($rev, '3 000')) $score += 20;

    $obj = $d['proj_objectif_3_6_mois'] ?? '';
    if ($obj !== '') $score += 30;

    $mode = $d['proj_mode_prospection'] ?? '';
    if (str_contains($mode, 'automatiquement') || str_contains($mode, 'parallèle')) $score += 30;

    return min($score, 100);
}

function scoreAction(array $d): int {
    $score = 0;
    $invest = $d['qual_pret_investir'] ?? '';
    if (str_contains($invest, 'maintenant'))  $score += 40;
    elseif (str_contains($invest, 'semaines'))$score += 25;
    elseif (str_contains($invest, 'réfléchir'))$score += 10;

    $motiv = (int)($d['qual_motivation_score'] ?? 0);
    $score += $motiv * 4; // max 40

    $changer = (string)($d['qual_pret_changer'] ?? '');
    if ($changer === '1') $score += 20;

    return min($score, 100);
}

function scoreProblem(array $d): int {
    // Plus le problème est identifié clairement, plus c'est actionnable
    $score = 0;
    if (!empty($d['pb_blocage_mandats']))        $score += 25;
    if (!empty($d['pb_frustration']))            $score += 25;
    if (!empty($d['emp_frein_principal']))       $score += 25;
    if (!empty($d['pb_manque_vendeurs_acheteurs']))$score += 25;
    return min($score, 100);
}

// ── Tags automatiques ─────────────────────────────────────────
function computeTags(array $d): array {
    $tags = [];
    $anc = $d['exp_anciennete'] ?? '';
    if (str_contains($anc, 'Moins de') || str_contains($anc, '6 mois'))
        $tags[] = 'debutant';
    elseif (str_contains($anc, '2 à 5'))
        $tags[] = 'intermediaire';
    elseif (str_contains($anc, 'Plus de 5'))
        $tags[] = 'avance';

    $sources = $d['exp_sources_clients'] ?? [];
    if (is_string($sources)) $sources = json_decode($sources, true) ?? [];
    if (in_array('Bouche à oreille / recommandation', $sources) && count($sources) === 1)
        $tags[] = 'dependance-reseau';

    $outils = (string)($d['exp_outils_digitaux'] ?? '');
    if ($outils === '0') $tags[] = 'pas-de-strategie-digitale';

    $frein = $d['emp_frein_principal'] ?? '';
    if (str_contains($frein, 'budget')) $tags[] = 'budget-faible';
    if (str_contains($frein, 'méthode')) $tags[] = 'besoin-methode';
    if (str_contains($frein, 'confiance')) $tags[] = 'frein-psychologique';
    if (str_contains($frein, 'temps')) $tags[] = 'manque-temps';
    if (str_contains($frein, 'visibilité')) $tags[] = 'besoin-visibilite';

    $invest = $d['qual_pret_investir'] ?? '';
    if (str_contains($invest, 'maintenant') || str_contains($invest, 'semaines'))
        $tags[] = 'prospect-chaud';
    elseif (str_contains($invest, 'réfléchir'))
        $tags[] = 'prospect-tiede';
    else
        $tags[] = 'prospect-froid';

    $motiv = (int)($d['qual_motivation_score'] ?? 0);
    if ($motiv >= 8) $tags[] = 'motive-fort';
    elseif ($motiv <= 4) $tags[] = 'motivation-faible';

    $delai = $d['qual_delai_resultats'] ?? '';
    if (str_contains($delai, 'vite') || str_contains($delai, '1 à 3'))
        $tags[] = 'urgence-elevee';

    $ventes = $d['exp_ventes_an'] ?? '';
    if (str_contains($ventes, '0-2') || str_contains($ventes, 'Débutant'))
        $tags[] = 'besoin-leads';

    $obj = $d['proj_objectif_3_6_mois'] ?? '';
    if (str_contains($obj, 'site') || str_contains($obj, 'Automatiser'))
        $tags[] = 'besoin-digital';

    if (!empty($d['emp_echecs_passes']) && (string)$d['emp_echecs_passes'] === '1')
        $tags[] = 'a-deja-tente';

    return array_values(array_unique($tags));
}

// ── Niveau de maturité ────────────────────────────────────────
function computeNiveau(int $scoreExp, int $scoreAction): string {
    $avg = ($scoreExp + $scoreAction) / 2;
    if ($avg >= 70) return 'expert';
    if ($avg >= 50) return 'avance';
    if ($avg >= 30) return 'intermediaire';
    return 'debutant';
}

// ── Priorités & recommandations ───────────────────────────────
function computePriorites(array $tags): array {
    $prio = [];
    if (in_array('pas-de-strategie-digitale', $tags) || in_array('besoin-visibilite', $tags))
        $prio[] = 'Activer une stratégie de visibilité locale (SEO + GMB)';
    if (in_array('dependance-reseau', $tags))
        $prio[] = 'Construire un système d\'acquisition indépendant du réseau';
    if (in_array('besoin-leads', $tags) || in_array('besoin-digital', $tags))
        $prio[] = 'Mettre en place un tunnel de génération de leads vendeurs';
    if (in_array('besoin-methode', $tags))
        $prio[] = 'Structurer une méthode de travail et un CRM';
    if (in_array('frein-psychologique', $tags))
        $prio[] = 'Travailler la légitimité et la confiance (contenu, preuves sociales)';
    if (in_array('motive-fort', $tags) && in_array('urgence-elevee', $tags))
        $prio[] = 'Démarrer rapidement avec un plan d\'action prioritaire';
    return $prio;
}

function computeRecommandations(array $tags): array {
    $reco = [];
    if (in_array('besoin-visibilite', $tags) || in_array('pas-de-strategie-digitale', $tags)) {
        $reco[] = ['module' => 'SEO Local', 'raison' => 'Pas de stratégie de visibilité détectée'];
        $reco[] = ['module' => 'Google My Business', 'raison' => 'Renforcer la présence locale'];
    }
    if (in_array('besoin-leads', $tags) || in_array('dependance-reseau', $tags)) {
        $reco[] = ['module' => 'Tunnels de conversion', 'raison' => 'Créer un système d\'acquisition automatique'];
        $reco[] = ['module' => 'Landing pages vendeurs', 'raison' => 'Capturer des leads vendeurs qualifiés'];
    }
    if (in_array('besoin-methode', $tags)) {
        $reco[] = ['module' => 'CRM & suivi', 'raison' => 'Structurer le suivi des prospects et clients'];
    }
    if (in_array('motive-fort', $tags) && in_array('urgence-elevee', $tags)) {
        $reco[] = ['module' => 'Onboarding accéléré', 'raison' => 'Prospect chaud avec urgence élevée — à contacter rapidement'];
    }
    return $reco;
}

// ── Calcul ────────────────────────────────────────────────────
$scoreExp  = scoreExperience($input);
$scoreProj = scoreProjection($input);
$scoreAct  = scoreAction($input);
$scorePb   = scoreProblem($input);
$scoreGlob = (int)round(($scoreExp + $scoreProj + $scoreAct + $scorePb) / 4);
$niveau    = computeNiveau($scoreExp, $scoreAct);
$tags      = computeTags($input);
$priorites = computePriorites($tags);
$recos     = computeRecommandations($tags);
$statut    = $autosave ? 'en_cours' : 'termine';

// ── Sauvegarde ────────────────────────────────────────────────
try {
    $pdo = ProspectsDB::getInstance();

    // Upsert
    $sql = "
        INSERT INTO eppe_responses (
            prospect_id, statut, etape_courante,
            exp_anciennete, exp_mandats_mois, exp_ventes_an,
            exp_sources_clients, exp_outils_digitaux, pb_solutions_testees,
            pb_blocage_mandats, pb_manque_vendeurs_acheteurs, pb_concurrence,
            pb_frustration,
            proj_mandats_mois_cible, proj_revenu_cible, proj_mode_prospection, proj_objectif_3_6_mois,
            emp_frein_principal, emp_type_frein, emp_echecs_passes,
            qual_pret_investir, qual_delai_resultats, qual_motivation_score, qual_pret_changer,
            score_experience, score_probleme, score_projection, score_action, score_global,
            niveau_maturite, tags, priorites, recommandations
        ) VALUES (
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?,
            ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?
        )
        ON DUPLICATE KEY UPDATE
            statut              = IF(statut='termine', 'termine', VALUES(statut)),
            etape_courante      = VALUES(etape_courante),
            exp_anciennete      = COALESCE(VALUES(exp_anciennete), exp_anciennete),
            exp_mandats_mois    = COALESCE(VALUES(exp_mandats_mois), exp_mandats_mois),
            exp_ventes_an       = COALESCE(VALUES(exp_ventes_an), exp_ventes_an),
            exp_sources_clients = COALESCE(VALUES(exp_sources_clients), exp_sources_clients),
            exp_outils_digitaux = COALESCE(VALUES(exp_outils_digitaux), exp_outils_digitaux),
            pb_solutions_testees= COALESCE(VALUES(pb_solutions_testees), pb_solutions_testees),
            pb_blocage_mandats  = COALESCE(VALUES(pb_blocage_mandats), pb_blocage_mandats),
            pb_manque_vendeurs_acheteurs = COALESCE(VALUES(pb_manque_vendeurs_acheteurs), pb_manque_vendeurs_acheteurs),
            pb_concurrence      = COALESCE(VALUES(pb_concurrence), pb_concurrence),
            pb_frustration      = COALESCE(VALUES(pb_frustration), pb_frustration),
            proj_mandats_mois_cible = COALESCE(VALUES(proj_mandats_mois_cible), proj_mandats_mois_cible),
            proj_revenu_cible   = COALESCE(VALUES(proj_revenu_cible), proj_revenu_cible),
            proj_mode_prospection = COALESCE(VALUES(proj_mode_prospection), proj_mode_prospection),
            proj_objectif_3_6_mois = COALESCE(VALUES(proj_objectif_3_6_mois), proj_objectif_3_6_mois),
            emp_frein_principal = COALESCE(VALUES(emp_frein_principal), emp_frein_principal),
            emp_type_frein      = COALESCE(VALUES(emp_type_frein), emp_type_frein),
            emp_echecs_passes   = COALESCE(VALUES(emp_echecs_passes), emp_echecs_passes),
            qual_pret_investir  = COALESCE(VALUES(qual_pret_investir), qual_pret_investir),
            qual_delai_resultats= COALESCE(VALUES(qual_delai_resultats), qual_delai_resultats),
            qual_motivation_score = COALESCE(VALUES(qual_motivation_score), qual_motivation_score),
            qual_pret_changer   = COALESCE(VALUES(qual_pret_changer), qual_pret_changer),
            score_experience    = VALUES(score_experience),
            score_probleme      = VALUES(score_probleme),
            score_projection    = VALUES(score_projection),
            score_action        = VALUES(score_action),
            score_global        = VALUES(score_global),
            niveau_maturite     = VALUES(niveau_maturite),
            tags                = VALUES(tags),
            priorites           = VALUES(priorites),
            recommandations     = VALUES(recommandations)
    ";

    $pdo->prepare($sql)->execute([
        $prospectId, $statut, 20,
        $s('exp_anciennete'), $s('exp_mandats_mois'), $s('exp_ventes_an'),
        $exp_sources, $s('exp_outils_digitaux'), $s('pb_solutions_testees'),
        $s('pb_blocage_mandats'), $s('pb_manque_vendeurs_acheteurs'), $b('pb_concurrence'),
        $s('pb_frustration'),
        $s('proj_mandats_mois_cible'), $s('proj_revenu_cible'), $s('proj_mode_prospection'), $s('proj_objectif_3_6_mois'),
        $s('emp_frein_principal'), $emp_type_frein, $b('emp_echecs_passes'),
        $s('qual_pret_investir'), $s('qual_delai_resultats'), $motivation, $b('qual_pret_changer'),
        $scoreExp, $scorePb, $scoreProj, $scoreAct, $scoreGlob,
        $niveau, json_encode($tags), json_encode($priorites), json_encode($recos),
    ]);

    // Mettre à jour le statut sondage du prospect
    if (!$autosave) {
        $pdo->prepare("UPDATE prospects SET sondage_statut = 'termine' WHERE id = ?")
            ->execute([$prospectId]);
    }

    echo json_encode(['success' => true, 'score' => $scoreGlob, 'niveau' => $niveau, 'tags' => $tags]);

} catch (PDOException $e) {
    error_log('Sondage save error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
}
