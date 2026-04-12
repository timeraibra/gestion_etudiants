<?php
class Etudiant {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // 📊 Liste avec recherche
    public function getAll($search = '') {
        $sql = "SELECT etudiants.*, classes.nom_classe 
                FROM etudiants 
                JOIN classes ON etudiants.classe_id = classes.id";

        if (!empty($search)) {
            $sql .= " WHERE etudiants.nom LIKE :search 
                      OR etudiants.prenom LIKE :search 
                      OR etudiants.email LIKE :search";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['search' => "%$search%"]);
        } else {
            $stmt = $this->pdo->query($sql);
        }

        return $stmt->fetchAll();
    }

    // ➕ Ajouter
    public function create($nom, $prenom, $email, $classe_id) {
        $stmt = $this->pdo->prepare("INSERT INTO etudiants (nom, prenom, email, classe_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nom, $prenom, $email, $classe_id]);
    }

    // 🔍 Trouver par ID
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ✏️ Modifier
    public function update($id, $nom, $prenom, $email) {
        $stmt = $this->pdo->prepare("UPDATE etudiants SET nom=?, prenom=?, email=? WHERE id=?");
        return $stmt->execute([$nom, $prenom, $email, $id]);
    }

    // 🗑️ Supprimer
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM etudiants WHERE id=?");
        return $stmt->execute([$id]);
    }

    // 📊 Statistiques
    public function count() {
        return $this->pdo->query("SELECT COUNT(*) FROM etudiants")->fetchColumn();
    }
}