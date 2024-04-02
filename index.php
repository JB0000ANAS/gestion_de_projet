<?php
session_start();

// Vérification de la connexion
if (isset($_SESSION['user_nom']) && isset($_SESSION['user_prenom'])) {
  $nom = $_SESSION['user_nom'];
  $prenom = $_SESSION['user_prenom'];
} else {
  // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
  header('Location: login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CarChoix - Accueil</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="logo.png" alt="Logo CarChoix">
    </div>
    <p>BIENVENUE CHEZ CarChoix !</p>
    <nav>
  <ul>
  <li><a href="profile.php">Mon profil</a></li>
    <li><a href="contact.php">Nous contacter</a></li>
    <li class="user-info">
      <span class="initials"><?php echo strtoupper($prenom[0]) . strtoupper($nom[0]); ?></span>
      <span class="name"><?php echo $prenom; ?></span>
      <a href="Deconnexion.php">Déconnexion</a>
    </li>
  </ul>
</nav>
  </header>
  <main>
    <section class="hero">
      <h2>À la recherche de la voiture idéale ?</h2>
      <p>Sur CarChoix, nous vous aidons à trouver la voiture parfaite pour vos besoins.</p>
      <p>Que vous recherchiez une voiture économique, sportive ou familiale, nous avons ce qu'il vous faut !</p>
      <a href="recherche.php" class="button">Recherche de voiture</a>
      <a href="comparaison.php" class="button">Comparer</a>

    </section>
    <section class="about">
    <a href="aproposdenous.php" style="text-decoration: none; color: inherit;">
    <h2>Qui sommes-nous ?</h2>
  </a>
  <p>Nous sommes une équipe passionnée par l'automobile, dévouée à vous fournir les meilleurs conseils pour votre prochaine véhicule.</p>
</section>
  </main>
  <footer>
    <p>&copy; 2024 CarChoix</p>
  </footer>
</body>
</html>


