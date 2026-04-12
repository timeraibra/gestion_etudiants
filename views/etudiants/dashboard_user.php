<?php
require_once '../views/layout/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

$username = htmlspecialchars($_SESSION['user']['username']);
$date     = date('d/m/Y H:i');
?>

<!-- BARRE DU HAUT -->
<div style="background:#2c3e50; color:white; padding:15px 30px; display:flex; justify-content:space-between; align-items:center;">
    <h2 style="margin:0;">🎓 Espace Étudiant</h2>
    <span>👤 <?= $username ?> &nbsp;|&nbsp; 📅 <?= $date ?></span>
</div>

<!-- CONTENU PRINCIPAL -->
<div style="max-width:900px; margin:30px auto; padding:0 20px;">

    <!-- MESSAGE DE BIENVENUE -->
    <div style="background:#eaf4fb; border-left:5px solid #3498db; padding:15px 20px; border-radius:4px; margin-bottom:25px;">
        <h3 style="margin:0 0 5px;">👋 Bienvenue, <?= $username ?> !</h3>
        <p style="margin:0; color:#555;">Vous êtes connecté en tant qu'étudiant.</p>
    </div>

    <!-- CARTES INFO -->
    <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:30px;">

        <div style="flex:1; min-width:200px; background:white; border:1px solid #ddd; border-radius:6px; padding:20px; text-align:center;">
            <div style="font-size:36px;">📚</div>
            <h4 style="margin:10px 0 5px;">Mes Cours</h4>
            <p style="color:#888; font-size:14px;">Accédez à vos cours</p>
            <a href="index.php?page=cours" style="display:inline-block; margin-top:10px; padding:8px 16px; background:#3498db; color:white; border-radius:4px; text-decoration:none;">Voir</a>
        </div>

        <div style="flex:1; min-width:200px; background:white; border:1px solid #ddd; border-radius:6px; padding:20px; text-align:center;">
            <div style="font-size:36px;">📝</div>
            <h4 style="margin:10px 0 5px;">Mes Notes</h4>
            <p style="color:#888; font-size:14px;">Consultez vos résultats</p>
            <a href="index.php?page=notes" style="display:inline-block; margin-top:10px; padding:8px 16px; background:#2ecc71; color:white; border-radius:4px; text-decoration:none;">Voir</a>
        </div>

        <div style="flex:1; min-width:200px; background:white; border:1px solid #ddd; border-radius:6px; padding:20px; text-align:center;">
            <div style="font-size:36px;">📅</div>
            <h4 style="margin:10px 0 5px;">Mon Emploi du temps</h4>
            <p style="color:#888; font-size:14px;">Planifiez vos semaines</p>
            <a href="index.php?page=emploi" style="display:inline-block; margin-top:10px; padding:8px 16px; background:#9b59b6; color:white; border-radius:4px; text-decoration:none;">Voir</a>
        </div>

    </div>

    <!-- INFOS COMPTE -->
    <div style="background:white; border:1px solid #ddd; border-radius:6px; padding:20px;">
        <h4 style="margin:0 0 15px; border-bottom:1px solid #eee; padding-bottom:10px;">📋 Informations du compte</h4>

        <table style="width:100%; border-collapse:collapse;">
            <tr style="border-bottom:1px solid #f0f0f0;">
                <td style="padding:10px; color:#888; width:40%;">Nom d'utilisateur</td>
                <td style="padding:10px; font-weight:bold;"><?= $username ?></td>
            </tr>
            <tr style="border-bottom:1px solid #f0f0f0;">
                <td style="padding:10px; color:#888;">Rôle</td>
                <td style="padding:10px;">
                    <span style="background:#eaf4fb; color:#3498db; padding:3px 10px; border-radius:20px; font-size:13px;">Étudiant</span>
                </td>
            </tr>
            <tr>
                <td style="padding:10px; color:#888;">Dernière connexion</td>
                <td style="padding:10px;"><?= $date ?></td>
            </tr>
        </table>
    </div>

    <!-- BOUTON DECONNEXION -->
    <div style="text-align:right; margin-top:20px;">
      
    </div>

</div>

<?php require_once '../views/layout/footer.php'; ?>