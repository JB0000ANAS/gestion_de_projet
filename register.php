<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarChoix - Inscription</title>
    <link rel="stylesheet" href="style.css">
    <style>
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
        <h1>Inscription</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="contact.php">Nous contacter</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        $errorMessage = ''; // Initialisation du message d'erreur
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupération des données du formulaire
            $nom = $_POST['n'] ?? '';
            $prenom = $_POST['p'] ?? '';
            $adresse = $_POST['adr'] ?? '';
            $email = $_POST['mail'] ?? '';
            $numero = $_POST['num'] ?? '';
            $motdepasse = $_POST['mdp1'] ?? ''; // Assurez-vous que mdp1 et mdp2 sont identiques

            $motdepasse_hache = password_hash($motdepasse, PASSWORD_DEFAULT);
             // Connexion à la base de données
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=voiture;charset=utf8', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Préparation de la requête d'insertion
                $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, adresse, numero, mail, mdp) VALUES (:nom, :prenom, :adresse, :numero, :email, :motdepasse)");
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':adresse', $adresse);
                $stmt->bindParam(':numero', $numero);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':motdepasse', $motdepasse_hache);

                // Exécution de la requête
                $stmt->execute();

                // Redirection après l'inscription réussie
                header('Location: index.php');
                exit();
            } catch(PDOException $e) {
                if ($e->getCode() == '23000') {
                    $errorMessage = "Le nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre.";
                } else {
                    $errorMessage = "Erreur lors de l'enregistrement : " . $e->getMessage();
                }
            }
        }
        ?>
        <form action="" method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="n" value="<?= isset($_POST['n']) ? htmlspecialchars($_POST['n']) : ''; ?>"><br><br>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="p" value="<?= isset($_POST['p']) ? htmlspecialchars($_POST['p']) : ''; ?>"><br><br>

            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adr" value="<?= isset($_POST['adr']) ? htmlspecialchars($_POST['adr']) : ''; ?>"><br><br>

            <label for="telephone">Numéro de téléphone :</label>
            <input type="text" id="telephone" name="num" value="<?= isset($_POST['num']) ? htmlspecialchars($_POST['num']) : ''; ?>"><br><br>

            <label for="email">Adresse e-mail :</label>
            <input type="text" id="email" name="mail" value="<?= isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : ''; ?>"><br><br>

            <label for="mdp1">Mot de passe :</label>
            <input type="password" id="mdp1" name="mdp1"><br><br>

            <label for="mdp2">Confirmer votre mot de passe :</label>
            <input type="password" id="mdp2" name="mdp2"><br><br>

            <input type="submit" value="Enregistrer">
        </form>
        
        <p><?= $errorMessage ?></p> <!-- Affichage du message d'erreur -->
        <p>Déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    </main>
</body>
</html>
