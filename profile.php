<?php
session_start(); // Assurez-vous d'appeler session_start() au début de votre script
 
if (isset($_SESSION['user_id'])) {
    // L'ID de l'utilisateur est stocké dans la session
    echo "L'utilisateur est connecté.";
} else {
    // L'ID de l'utilisateur n'est pas stocké dans la session
    echo "L'utilisateur n'est pas connecté.";
}

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=voiture", "root", ""); // Affectation de la connexion à la variable $pdo
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Erreur lors de la connexion à la base de données : ' . $e->getMessage();
    exit();
}

// Récupération des informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE ID = :id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo 'Utilisateur introuvable.';
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarChoix - Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Votre profil</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="contact.php">Nous contacter</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Informations personnelles</h2>
        <ul>
            <li>Nom : <?php echo $user['nom']; ?></li>
            <li>Prénom : <?php echo $user['prenom']; ?></li>
            <li>Adresse : <?php echo $user['adresse']; ?></li>
            <li>Numéro de téléphone : <?php echo $user['numero']; ?></li>
            <li>Adresse e-mail : <?php echo $user['mail']; ?></li>
        </ul>
        <a href="Deconnexion.php">Déconnexion</a>
    </main>
    <footer>
        <p>&copy; 2024 CarChoix</p>
    </footer>
</body>
</html>
