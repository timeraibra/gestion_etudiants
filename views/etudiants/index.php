<?php 
require_once '../views/layout/header.php';

// 🔒 Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

// 🔍 Recherche
$search = $_GET['search'] ?? '';

// 🔥 Requête de base
$sql = "SELECT etudiants.*, classes.nom_classe 
        FROM etudiants 
        JOIN classes ON etudiants.classe_id = classes.id";

// 🔍 Si recherche → filtrer
if (!empty($search)) {
    $sql .= " WHERE etudiants.nom LIKE :search 
              OR etudiants.prenom LIKE :search 
              OR etudiants.email LIKE :search";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $pdo->query($sql);
}

// 📊 STATISTIQUES (AJOUT IMPORTANT)
$totalEtudiants = $pdo->query("SELECT COUNT(*) FROM etudiants")->fetchColumn();
$totalClasses = $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn();
?>

<div class="card shadow p-4 mb-4">

    <!-- Ligne 1 : Bienvenue -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            👋 Bienvenue <?= htmlspecialchars($_SESSION['user']['username']); ?>
        </h4>
    </div>

    <!-- Ligne 2 : Cartes statistiques -->
    <div class="row text-center">

        <div class="col-md-6 mb-3">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body">
                    <h5>👨‍🎓 Étudiants</h5>
                    <h2><?= $totalEtudiants ?></h2>
                    <small>Total des étudiants</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body">
                    <h5>🏫 Classes</h5>
                    <h2><?= $totalClasses ?></h2>
                    <small>Total des classes</small>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- 🔒 Bouton Ajouter visible uniquement pour ADMIN -->
<?php if ($_SESSION['user']['role'] == 'admin'): ?>
<div class="mb-3">
    <a href="index.php?page=create" class="btn btn-primary shadow">
        ➕ Ajouter un étudiant
    </a>
</div>
<?php endif; ?>

<h3 class="mb-3">📋 Liste des étudiants</h3>

<!-- 🔍 Barre de recherche -->
<div class="card p-3 shadow mb-4">
    <form method="GET" class="d-flex">
        <!-- ⚠️ Important pour rester sur dashboard -->
        <input type="hidden" name="page" value="dashboard">

        <input type="text" name="search" class="form-control me-2" 
               placeholder="🔍 Rechercher un étudiant..." 
               value="<?= htmlspecialchars($search) ?>">

        <button class="btn btn-primary">Rechercher</button>
    </form>
</div>

<table class="table table-bordered table-striped shadow">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Classe</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
<?php
while ($etudiant = $stmt->fetch()) {
?>
    <tr>
        <td><?= $etudiant['id'] ?></td>
        <td><?= htmlspecialchars($etudiant['nom']) ?></td>
        <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
        <td><?= htmlspecialchars($etudiant['email']) ?></td>
        <td><?= $etudiant['nom_classe'] ?></td>

        <td>
            <!-- 🔒 Actions seulement pour ADMIN -->
            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                <a href="index.php?page=edit&id=<?= $etudiant['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
                <a href="index.php?page=delete&id=<?= $etudiant['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">🗑️</a>
            <?php else: ?>
                <!-- 👁️ Étudiant = lecture seule -->
                <span class="text-muted">👁️ Lecture seule</span>
            <?php endif; ?>
        </td>
    </tr>
<?php
}

// 🔥 Message si aucun résultat
if ($stmt->rowCount() == 0) {
    echo "<tr><td colspan='6' class='text-center'>Aucun étudiant trouvé</td></tr>";
}
?>
    </tbody>
</table>

<?php require_once '../views/layout/footer.php'; ?>