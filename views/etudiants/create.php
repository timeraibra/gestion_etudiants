<?php 
require_once '../views/layout/header.php'; 

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

// Initialisation
$nom = '';
$prenom = '';
$email = '';
$classe_id = '';
$message = '';

// Traitement formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $classe_id = (int) $_POST['classe_id'];

    // Validation
    if ($nom === '' || $prenom === '' || $email === '' || $classe_id === 0) {
        $message = "⚠️ Tous les champs sont obligatoires";
    } else {

        // ✅ UNE SEULE INSERTION
        $stmt = $pdo->prepare("INSERT INTO etudiants (nom, prenom, email, classe_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $classe_id]);

        header("Location: index.php?page=dashboard");
        exit;
    }
}
?>

<div style="max-width: 550px; margin: 40px auto; font-family: Arial, sans-serif;">

    <h2 style="margin-bottom: 20px; color: #2c3e50;">➕ Ajouter un étudiant</h2>

    <?php if (!empty($message)) : ?>
        <div style="
            background-color: #fdecea;
            color: #c0392b;
            border: 1px solid #e74c3c;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        ">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    ">

        <!-- Nom -->
        <div style="margin-bottom: 18px;">
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">
                Nom
            </label>
            <input 
                type="text" 
                name="nom" 
                value="<?= htmlspecialchars($nom) ?>" 
                required
                style="
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    font-size: 14px;
                    box-sizing: border-box;
                "
            >
        </div>

        <!-- Prénom -->
        <div style="margin-bottom: 18px;">
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">
                Prénom
            </label>
            <input 
                type="text" 
                name="prenom" 
                value="<?= htmlspecialchars($prenom) ?>" 
                required
                style="
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    font-size: 14px;
                    box-sizing: border-box;
                "
            >
        </div>

        <!-- Email -->
        <div style="margin-bottom: 18px;">
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">
                Email
            </label>
            <input 
                type="email" 
                name="email" 
                value="<?= htmlspecialchars($email) ?>" 
                required
                style="
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    font-size: 14px;
                    box-sizing: border-box;
                "
            >
        </div>

        <!-- Classe -->
        <div style="margin-bottom: 24px;">
            <label style="display: block; margin-bottom: 6px; font-weight: bold; color: #333;">
                Classe
            </label>
            <select 
                name="classe_id" 
                required
                style="
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    font-size: 14px;
                    box-sizing: border-box;
                    background: #fff;
                "
            >
                <option value="">-- Choisir classe --</option>

                <?php
                $stmt = $pdo->query("SELECT * FROM classes");
                while ($classe = $stmt->fetch()) {
                    $selected = ($classe_id == $classe['id']) ? 'selected' : '';
                    echo "<option value='{$classe['id']}' $selected>{$classe['nom_classe']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Bouton -->
        <button 
            type="submit"
            style="
                background-color: #27ae60;
                color: white;
                padding: 11px 24px;
                border: none;
                border-radius: 5px;
                font-size: 15px;
                cursor: pointer;
                width: 100%;
            "
        >
            ✅ Ajouter l'étudiant
        </button>

    </form>

</div>

<?php require_once '../views/layout/footer.php'; ?>