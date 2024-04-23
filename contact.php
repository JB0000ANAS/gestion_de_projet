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
    $avis = $_POST['demande'];

    if ($nom == $user['nom'] && $prenom == $user['prenom']) {
        if (empty($user['avis'])) {
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
       /* Styles globaux */
       body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #333333;
  color: #333;
  line-height: 1.6;
  margin: 0;
  padding: 0;
}

footer {
  background-color: #404040;
  color: #ffffff;
  text-align: center;
  padding: 10px 0;
}
 

 

main {
    width: 80%;
    max-width: 800px;
    margin: 50px auto; /* Augmentez la marge supérieure */
    padding: 20px;
    background-color: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
/* Modified section for form background color */
.form-group {
  margin-bottom: 20px;
  background-color: #cccccc; /* Dark gray background for forms */
}

label {
  display: block;
  margin-bottom: .5em;
  font-weight: bold;
}

input[type="text"], textarea {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.button {
  background-color: #0056b3;
  color: white;
  border: 0;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 5px;
  font-size: 1em;
}

.button:hover {
  background-color: #003d7a;
}

.error-message, .success-message {
  color: white;
  background-color: #d9534f;
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 20px;
  text-align: center;
}

.success-message {
  background-color: #5cb85c;
}

/* Wrap the Main Content and Footer */
.parent-container {
  display: flex; /* Enable flexbox layout */
  flex-direction: column; /* Arrange items vertically */
  align-items: stretch; /* Stretch content to full width */
  height: 100vh; /* Set height to 100% of viewport height */
}

/* Maintain existing footer styles */
footer {
  margin: auto; 
  font-size: 0.8em;
}

#background-video {
  width: 100vw;
  height: 100vh;
  object-fit: cover;
  position: fixed;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  z-index: -1;
}
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

    <main>
        <h2>Contactez-nous</h2>
        <form method="post">
            <div class="form-group">
                <label for="nom">Prenom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Nom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="demande">Avis :</label>
                <textarea id="demande" name="demande" rows="4" required></textarea>
            </div>
            <button type="submit" class="button">Envoyer</button>
        </form>
        <video id="background-video" autoplay loop muted poster="images/poster.jpg">
 <source src="video1.mp4" type="video/mp4">
</video>

    </main>
    <footer>
        <p>&copy; 2024 CarChoix. Tous droits réservés.</p>
    </footer>
</body>
</html>
