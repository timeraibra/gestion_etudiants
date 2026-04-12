<?php
$totalEtudiants = $pdo->query("SELECT COUNT(*) FROM etudiants")->fetchColumn();
$totalClasses = $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion Étudiants</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ton CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">🎓 Gestion Étudiants</span>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="d-flex align-items-center">

            <span class="text-white me-3">
                👤 <?= htmlspecialchars($_SESSION['user']['username']) ?>
            </span>

            <a href="index.php?page=logout" class="btn btn-danger btn-sm">
                Déconnexion
            </a>

        </div>
    <?php endif; ?>
</nav>

<div class="container mt-4">