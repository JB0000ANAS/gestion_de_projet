<?php
session_start(); // Assurez-vous de démarrer la session au début du script

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voiture";

// Tentative de connexion à la base de données
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification de la méthode de requête et de la connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validation des entrées
    if (empty($username) || empty($password)) {
        $errorMessage = "Veuillez remplir tous les champs.";
    } else {
        // Recherche de l'utilisateur dans la base de données
        try {
            $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE mail = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe
            if ($user && password_verify($password, $user['mdp'])) {
                // Connexion réussie, redirection vers index.php
                $_SESSION['user'] = $user; // Définition des variables de session
                header('Location: index.php');
                exit();
            } else {
                $errorMessage = "Identifiants incorrects.";
            }
        } catch(PDOException $e) {
            $errorMessage = "Une erreur est survenue lors de la vérification de l'utilisateur.";
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
    </header>
    <main>
        <?php if (isset($errorMessage)): ?>
            <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
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

