<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=voiture", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Erreur lors de la connexion à la base de données : ' . $e->getMessage();
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE ID = :id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $avis = $_POST['demande']; // Assurez-vous que le nom du champ de texte dans le formulaire correspond à 'demande'

    // Modification ici : vérifiez si l'utilisateur a déjà laissé un avis
    if ($nom == $user['nom'] && $prenom == $user['prenom']) {
        if (empty($user['avis'])) { // Vérifiez si 'avis' est vide pour cet utilisateur
            try {
                $stmt = $pdo->prepare("UPDATE utilisateur SET avis = :avis WHERE ID = :id");
                $stmt->bindParam(':avis', $avis);
                $stmt->bindParam(':id', $user_id);
                $stmt->execute();

                echo "<div class='success-message'>Votre avis a été enregistré avec succès.</div>";
            } catch(PDOException $e) {
                echo '<div class="error-message">Erreur lors de l\'enregistrement de l\'avis : ' . $e->getMessage() . '</div>';
            }
        } else {
            // Si l'utilisateur a déjà un avis, vous pouvez choisir d'afficher un message différent ou de mettre à jour l'avis existant.
            echo "<div class='error-message'>Vous avez déjà laissé un avis.</div>";
        }
    } else {
        echo '<div class="error-message">Les informations fournies ne correspondent pas à celles de votre profil.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous - CarChoix</title>
    <link rel="stylesheet" href="style.css">
    <style>
       /* Réinitialisation des styles par défaut */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

nav ul {
    list-style-type: none;
    padding: 0;
    display: flex;
    justify-content: center;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

main {
    max-width: 400px; /* Largeur réduite pour le formulaire */
    margin: 20px auto; /* Ajustement de la marge pour centrer et réduire l'espace au-dessus */
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
}

input[type="text"], input[type="password"], textarea {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

input[type="submit"], .button {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover, .button:hover {
    background-color: #444;
}

.error-message, .success-message {
    color: #D8000C; /* Rouge pour l'erreur, changez si nécessaire */
    background-color: #FFD2D2; /* Fond pour l'erreur, ajustez pour le succès si désiré */
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    font-size: 14px; /* Taille de la police ajustée */
    text-align: center;
}
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo CarChoix">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">Inscription</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="contact-form">
            <h2>Contactez-nous</h2>
            <form method="post">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                <div class="form-group">
                    <label for="demande">Avis :</label>
                    <textarea id="demande" name="demande" rows="4" required></textarea>
                </div>
                <button type="submit" class="button">Envoyer</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 CarChoix</p>
    </footer>
</body>
</html>
