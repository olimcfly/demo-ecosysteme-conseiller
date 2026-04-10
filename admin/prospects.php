<?php
// ============================================================
// ADMIN — Gestion des prospects démo
// ============================================================
require_once dirname(__DIR__) . '/core/bootstrap.php';

// Vérification admin (session admin du site principal)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /admin/login.php', true, 302);
    exit;
}

$pdo    = ProspectsDB::getInstance();
$action = $_GET['action'] ?? '';
$id     = (int)($_GET['id'] ?? 0);

// ── Actions POST ─────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($action, ['valider','refuser','supprimer'], true) && $id > 0) {
    if ($action === 'valider') {
        $pdo->prepare("UPDATE prospects SET statut = 'valide' WHERE id = ?")->execute([$id]);
    } elseif ($action === 'refuser') {
        $pdo->prepare("UPDATE prospects SET statut = 'refuse' WHERE id = ?")->execute([$id]);
    } elseif ($action === 'supprimer') {
        $pdo->prepare("DELETE FROM prospects WHERE id = ?")->execute([$id]);
    }
    header('Location: /admin/prospects.php', true, 302);
    exit;
}

// ── Filtres ───────────────────────────────────────────────────
$statut  = $_GET['statut'] ?? '';
$search  = trim($_GET['q'] ?? '');
$where   = ['1=1'];
$params  = [];

if (in_array($statut, ['valide','refuse','en_attente','expire'], true)) {
    $where[]  = 'statut = ?';
    $params[] = $statut;
}
if ($search !== '') {
    $where[]  = '(email LIKE ? OR nom LIKE ? OR prenom LIKE ? OR reseau LIKE ? OR ville LIKE ?)';
    $like = '%' . $search . '%';
    array_push($params, $like, $like, $like, $like, $like);
}

$sql      = 'SELECT * FROM prospects WHERE ' . implode(' AND ', $where) . ' ORDER BY created_at DESC';
$stmt     = $pdo->prepare($sql);
$stmt->execute($params);
$prospects = $stmt->fetchAll();

// Stats
$stats = $pdo->query("
    SELECT
      COUNT(*) AS total,
      SUM(statut='valide') AS valides,
      SUM(statut='refuse') AS refuses,
      SUM(DATE(created_at) = CURDATE()) AS aujourdhui
    FROM prospects
")->fetch();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Prospects Démo — Admin</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f8fafc; color: #1e293b; font-size: .9rem; }
    .header { background: #1a56db; color: #fff; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; }
    .header h1 { font-size: 1.1rem; font-weight: 700; }
    .header a { color: #93c5fd; text-decoration: none; font-size: .85rem; }
    .container { max-width: 1200px; margin: 0 auto; padding: 24px 16px; }
    .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .stat-card { background: #fff; border-radius: 10px; padding: 18px 20px; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .stat-card .value { font-size: 2rem; font-weight: 800; color: #1a56db; }
    .stat-card .label { font-size: .8rem; color: #64748b; margin-top: 2px; }
    .toolbar { display: flex; gap: 12px; margin-bottom: 16px; flex-wrap: wrap; align-items: center; }
    .toolbar input { padding: 8px 12px; border: 1.5px solid #e2e8f0; border-radius: 7px; font-size: .88rem; width: 220px; outline: none; }
    .toolbar input:focus { border-color: #1a56db; }
    .filter-links { display: flex; gap: 6px; }
    .filter-links a { padding: 6px 14px; border-radius: 20px; font-size: .8rem; text-decoration: none; background: #e2e8f0; color: #475569; }
    .filter-links a.active { background: #1a56db; color: #fff; }
    .table-wrap { background: #fff; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,.06); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f1f5f9; padding: 11px 14px; text-align: left; font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; color: #64748b; font-weight: 600; }
    td { padding: 11px 14px; border-top: 1px solid #f1f5f9; vertical-align: middle; }
    tr:hover td { background: #fafbff; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: .75rem; font-weight: 600; }
    .badge.valide   { background: #dcfce7; color: #16a34a; }
    .badge.refuse   { background: #fee2e2; color: #dc2626; }
    .badge.en_attente { background: #fef9c3; color: #ca8a04; }
    .btn-sm { padding: 5px 11px; border-radius: 6px; font-size: .78rem; cursor: pointer; border: none; font-weight: 600; }
    .btn-danger  { background: #fee2e2; color: #dc2626; }
    .btn-success { background: #dcfce7; color: #16a34a; }
    .btn-warning { background: #fef3c7; color: #d97706; }
    form.inline { display: inline; }
    .empty { text-align: center; padding: 48px; color: #94a3b8; }
    @media(max-width:700px){ .stats{grid-template-columns:1fr 1fr;} }
  </style>
</head>
<body>
<div class="header">
  <h1>Prospects Démo</h1>
  <a href="/admin/">← Retour admin</a>
</div>
<div class="container">

  <div class="stats">
    <div class="stat-card"><div class="value"><?= (int)$stats['total'] ?></div><div class="label">Total prospects</div></div>
    <div class="stat-card"><div class="value"><?= (int)$stats['valides'] ?></div><div class="label">Accès actifs</div></div>
    <div class="stat-card"><div class="value"><?= (int)$stats['refuses'] ?></div><div class="label">Refusés</div></div>
    <div class="stat-card"><div class="value"><?= (int)$stats['aujourdhui'] ?></div><div class="label">Inscrits aujourd'hui</div></div>
  </div>

  <div class="toolbar">
    <form method="GET" style="display:flex;gap:8px;align-items:center;">
      <input type="search" name="q" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>">
      <?php if ($statut): ?><input type="hidden" name="statut" value="<?= htmlspecialchars($statut) ?>"><?php endif; ?>
      <button type="submit" class="btn-sm btn-success">Chercher</button>
    </form>
    <div class="filter-links">
      <a href="/admin/prospects.php" class="<?= $statut === '' ? 'active' : '' ?>">Tous</a>
      <a href="?statut=valide" class="<?= $statut === 'valide' ? 'active' : '' ?>">Actifs</a>
      <a href="?statut=en_attente" class="<?= $statut === 'en_attente' ? 'active' : '' ?>">En attente</a>
      <a href="?statut=refuse" class="<?= $statut === 'refuse' ? 'active' : '' ?>">Refusés</a>
    </div>
  </div>

  <div class="table-wrap">
    <?php if (empty($prospects)): ?>
      <div class="empty">Aucun prospect trouvé.</div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nom / Prénom</th>
          <th>Email</th>
          <th>Téléphone</th>
          <th>Ville</th>
          <th>Réseau</th>
          <th>Statut</th>
          <th>Connexions</th>
          <th>Inscrit le</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($prospects as $p): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><strong><?= htmlspecialchars($p['prenom'] . ' ' . $p['nom']) ?></strong></td>
          <td><?= htmlspecialchars($p['email']) ?></td>
          <td><?= htmlspecialchars($p['telephone']) ?></td>
          <td><?= htmlspecialchars($p['ville']) ?></td>
          <td><?= htmlspecialchars($p['reseau']) ?></td>
          <td><span class="badge <?= $p['statut'] ?>"><?= $p['statut'] ?></span></td>
          <td><?= $p['nb_connexions'] ?></td>
          <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
          <td style="display:flex;gap:6px;flex-wrap:wrap;">
            <?php if ($p['statut'] !== 'valide'): ?>
            <form class="inline" method="POST" action="?action=valider&id=<?= $p['id'] ?>">
              <button class="btn-sm btn-success" type="submit">Valider</button>
            </form>
            <?php endif; ?>
            <?php if ($p['statut'] !== 'refuse'): ?>
            <form class="inline" method="POST" action="?action=refuser&id=<?= $p['id'] ?>">
              <button class="btn-sm btn-warning" type="submit">Refuser</button>
            </form>
            <?php endif; ?>
            <form class="inline" method="POST" action="?action=supprimer&id=<?= $p['id'] ?>" onsubmit="return confirm('Supprimer ce prospect ?')">
              <button class="btn-sm btn-danger" type="submit">Suppr.</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>

</div>
</body>
</html>
