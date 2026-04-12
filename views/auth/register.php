<?php 
require_once '../views/layout/header.php';

// Initialisation
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    // 🔒 Validation
    if ($username === '' || $password === '' || $confirm === '') {
        $error = "Tous les champs sont obligatoires";
    } elseif ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas";
    } else {

        // 🔍 Vérifier si utilisateur existe déjà
        $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE username = ?");
        $check->execute([$username]);

        if ($check->rowCount() > 0) {
            $error = "Ce nom d'utilisateur existe déjà";
        } else {

            // 🔐 Hash mot de passe (MD5 pour ton projet)
            $hashedPassword = md5($password);

            // 👨‍🎓 Insertion avec rôle = user
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (username, password, role) VALUES (?, ?, 'user')");
            $stmt->execute([$username, $hashedPassword]);

            $success = "Compte créé avec succès !";

            // 🔁 Redirection après 2 secondes
            header("refresh:2;url=index.php?page=login");
        }
    }
}
?>

<h2 class="text-center mb-4">📝 Inscription</h2>

<form method="POST" class="card p-4 shadow w-50 mx-auto">

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Nom utilisateur" required>
    </div>

    <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
    </div>

    <div class="mb-3">
        <input type="password" name="confirm" class="form-control" placeholder="Confirmer mot de passe" required>
    </div>

    <button class="btn btn-success w-100">S'inscrire</button>

    <div class="text-center mt-3">
        <a href="index.php?page=login">Déjà un compte ? Se connecter</a>
    </div>

</form>

<?php require_once '../views/layout/footer.php'; ?>