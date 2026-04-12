<?php 
require_once '../views/layout/header.php';

// Initialisation
$error = '';

// Traitement login
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = md5($_POST['password']); // 🔐 Hash du mot de passe

    // 🔎 Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);

    $user = $stmt->fetch();

    if ($user) {
        // ✅ Stocker l'utilisateur en session
        $_SESSION['user'] = $user;

        // 🔥 REDIRECTION SELON LE RÔLE
        if ($user['role'] == 'admin') {
            // 👉 Admin → accès complet
            header("Location: index.php?page=dashboard");
        } else {
            // 👉 Étudiant → accès limité
            header("Location: index.php?page=dashboard_user");
        }

        exit;

    } else {
        // ❌ Mauvais identifiants
        $error = "Identifiants incorrects";
    }
}
?>

<style>
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
    }

    .login-box {
        background: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .login-box h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 22px;
        color: #2c3e50;
    }

    .login-box input {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .login-box input:focus {
        border-color: #3498db;
        outline: none;
    }

    .login-box button {
        width: 100%;
        padding: 11px;
        background-color: #2c3e50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        cursor: pointer;
    }

    .login-box button:hover {
        background-color: #3498db;
    }

    .error-msg {
        background-color: #fdecea;
        color: #c0392b;
        border: 1px solid #e74c3c;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
        text-align: center;
    }
    
</style>

<div class="login-wrapper">
    <div class="login-box">

        <h2>🔐 Connexion</h2>

        <form method="POST">

            <?php if (!empty($error)) : ?>
                <div class="error-msg"><?= $error ?></div>
            <?php endif; ?>

            <input 
                type="text" 
                name="username" 
                placeholder="Nom utilisateur" 
                required
            >

            <input 
                type="password" 
                name="password" 
                placeholder="Mot de passe" 
                required
            >

            <button type="submit">Se connecter</button>

        </form>

        <!-- 🔥 AJOUT : lien vers la page d'inscription -->
        <div class="text-center mt-3">
            <a href="index.php?page=register">Créer un compte</a>
        </div>

    </div>
</div>

<?php require_once '../views/layout/footer.php'; ?>