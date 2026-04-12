<?php 
// Vérification session EN PREMIER avant tout le reste
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

require_once '../views/layout/header.php'; 

// Vérification que l'ID existe dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?page=dashboard");
    exit;
}

$id = (int) $_GET['id']; // (int) pour sécuriser l'ID

$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch();

// Vérification que l'étudiant existe vraiment en base
if (!$etudiant) {
    header("Location: index.php?page=dashboard");
    exit;
}

// Traitement du formulaire EN HAUT avant l'affichage HTML
$erreurs = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom    = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email  = trim($_POST['email']);

    // Validations
    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire.";
    }
    if (empty($prenom)) {
        $erreurs[] = "Le prénom est obligatoire.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email est invalide.";
    }

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("UPDATE etudiants SET nom=?, prenom=?, email=? WHERE id=?");
        $stmt->execute([$nom, $prenom, $email, $id]);

        header("Location: index.php?page=dashboard");
        exit; // Toujours mettre exit après header()
    }
}
?>

<h2>Modifier l'étudiant</h2>

<!-- Affichage des erreurs -->
<?php if (!empty($erreurs)): ?>
    <ul style="color: red;">
        <?php foreach ($erreurs as $erreur): ?>
            <li><?= htmlspecialchars($erreur) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
    <form method="POST">

        <tr>
            <td><label for="nom">Nom</label></td>
            <td>
                <input 
                    type="text" 
                    id="nom"
                    name="nom" 
                    value="<?= htmlspecialchars($etudiant['nom']) ?>" 
                    required
                >
            </td>
        </tr>

        <tr>
            <td><label for="prenom">Prénom</label></td>
            <td>
                <input 
                    type="text" 
                    id="prenom"
                    name="prenom" 
                    value="<?= htmlspecialchars($etudiant['prenom']) ?>" 
                    required
                >
            </td>
        </tr>

        <tr>
            <td><label for="email">Email</label></td>
            <td>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    value="<?= htmlspecialchars($etudiant['email']) ?>" 
                    required
                >
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <button type="submit">✅ Modifier</button>
                &nbsp;
                <a href="index.php?page=dashboard">❌ Annuler</a>
            </td>
        </tr>

    </form>
</table>

<?php require_once '../views/layout/footer.php'; ?>