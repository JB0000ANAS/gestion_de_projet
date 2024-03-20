<?php
session_start(); // Démarre la session

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voiture";

// Tentative de connexion à la base de données
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$errorMessage = ""; // Initialisation de $errorMessage
$successMessage = ""; // Initialisation de $successMessage

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $errorMessage = "L'adresse e-mail et le mot de passe sont obligatoires.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE mail = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Utilisateur trouvé, on tente maintenant de vérifier le mot de passe
                if (password_verify($password, $user['mdp'])) {
                    // Le mot de passe est correct, on stocke les informations de l'utilisateur dans la session
                    $_SESSION['user_id'] = $user['ID'];
                    $_SESSION['user_nom'] = $user['nom'];
                    $_SESSION['user_prenom'] = $user['prenom'];
                   
                    // Redirection vers la page d'accueil après connexion réussie
                    header('Location: index.php');
                    exit();
                } else {
                    // Le mot de passe ne correspond pas
                    $errorMessage = "Le mot de passe est incorrect.";
                }
            } else {
                // Utilisateur non trouvé
                $errorMessage = "Aucun utilisateur trouvé avec cette adresse e-mail.";
            }
        } catch (PDOException $e) {
            $errorMessage = "Erreur lors de la connexion : " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarChoix - Connexion</title>
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
    max-width: 600px;
    margin: 50px auto;
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

input[type="text"], input[type="password"] {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #444;
}

p {
    text-align: center;
    margin-top: 20px;
}

p a {
    color: #333;
    text-decoration: none;
}

p a:hover {
    text-decoration: underline;
}

.user-info {
    text-align: right;
    padding: 10px;
    background-color: #333;
    color: #fff;
}

    </style>
</head>
<body>
    <header>
        <h1>Connexion</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="register.php">Inscription</a></li>
                <li><a href="contact.php">Nous contacter</a></li>
            </ul>
        </nav>
        <?php if(isset($_SESSION['user_nom']) && isset($_SESSION['user_prenom'])): ?>
            <div class="user-info">Bonjour <?php echo $_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']; ?> | <a href="logout.php">Déconnexion</a></div>
        <?php 
    endif; ?>
    </header>
    <main>
        <?php if ($errorMessage): ?>
            <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php elseif ($successMessage): ?>
            <p class="success"><?php echo htmlspecialchars($successMessage); ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="username">Adresse e-mail :</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore inscrit ? <a href="register.php">Inscrivez-vous ici</a>.</p>
    </main>
</body>
</html>



