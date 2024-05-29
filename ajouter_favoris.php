<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit;
}

// Récupérer l'ID de l'utilisateur et l'ID de la voiture à ajouter aux favoris
$user_id = $_SESSION['user_id'];
$voiture_id = $_POST['voiture_id'] ?? null;

if ($voiture_id) {
    // Récupérer les préférences actuelles de l'utilisateur
    $stmt = $pdo->prepare("SELECT preferences FROM utilisateur WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mettre à jour les préférences
    $preferences = $user['preferences'] ? json_decode($user['preferences'], true) : [];
    if (!in_array($voiture_id, $preferences)) {
        $preferences[] = $voiture_id;
    }

    // Enregistrer les nouvelles préférences
    $stmt = $pdo->prepare("UPDATE utilisateur SET preferences = :preferences WHERE id = :user_id");
    $stmt->execute(['preferences' => json_encode($preferences), 'user_id' => $user_id]);

    echo "Voiture ajoutée aux favoris.";
} else {
    echo "Erreur : ID de la voiture manquant.";
}
?>
