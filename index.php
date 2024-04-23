<?php
// Start the session and error reporting
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require 'db.php';

$nom = '';
$prenom = '';

// Verify if the user is logged in
if (isset($_SESSION['user_nom']) && isset($_SESSION['user_prenom'])) {
    $nom = $_SESSION['user_nom'];
    $prenom = $_SESSION['user_prenom'];
    $userGreeting = "Bonjour " . htmlspecialchars($prenom) . "!";
} else {
    $userGreeting = "Invité";
}

// Fetch multiple articles from the database
try {
    $sql = 'SELECT * FROM article ORDER BY id DESC';
    $stmt = $pdo->query($sql);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CarChoix - Accueil</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>
<body class="bg-gray-100">

<?php include 'navbar.php'; ?>

<script src="https://cdn.botpress.cloud/webchat/v1/inject.js"></script>
<script src="https://mediafiles.botpress.cloud/f992eda9-5c40-4979-b04b-14baad2aaa60/webchat/config.js" defer></script>

  
  
<main>

<div class="slider-container relative bg-gray-800 text-white py-20 overflow-hidden">
  <!-- Left arrow button for scrolling -->
  <button id="prevButton" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-transparent border-none cursor-pointer z-10">
    <img src="images/gauche.png" alt="Previous" class="h-10 w-10">
  </button>

  <!-- Slider -->
 
     <!-- Slider -->
  <div id="articleSlider" class="whitespace-nowrap overflow-hidden">
    <!-- Dynamic articles from PHP -->
    <?php if (!empty($articles)): ?>
      <?php foreach ($articles as $index => $article): ?>
        <!-- Article card -->
        <div class="slide block w-full transition-transform duration-300 ease-in-out transform">
          <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
              <div class="w-full lg:w-2/3">
                <!-- Display the featured image -->
                <img src="<?php echo htmlspecialchars($article['imgurl']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="rounded-lg shadow-lg">
              </div>
              <div class="w-full lg:w-1/3 pl-4">
              <div class="article-content p-2 rounded-lg bg-opacity-75 bg-gray-900 overflow-hidden">
    <h2 class="text-4xl font-bold mb-2">Actualité</h2>
    <h4 class="text-md mb-5 max-w-full white-space-pre"><?php echo htmlspecialchars($article['title']); ?></h4>
    <p class="subtitle text-sm"><?php echo htmlspecialchars($article['subtitle']); ?></p>
    <a href="article.php?id=<?php echo $article['id']; ?>" class="button-container mt-4 inline-block bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700 transition ease-in-out duration-150">
        Lire l'article
    </a>
</div>
                

              </div>
            </div>
          </div>
        </div>
 
      <?php endforeach; ?>
    <?php else: ?>
      <p>No articles found.</p>
    <?php endif; ?>
  </div>

  <!-- Right arrow button for scrolling -->
  <button id="nextButton" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-transparent border-none cursor-pointer z-10">
    <img src="images/droite.png" alt="Next" class="h-10 w-10">
  </button>
</div>








<section class="py-8">
  <div class="container mx-auto px-4">
    <h2 class="text-4xl font-bold text-gray-800 mb-4">Catégories</h2>
    <div class="categories-container">
      <!-- Each category is now a link -->
      <!-- Category: Berline -->
      <a href="catalogue.php?type_de_carrosserie=Berline" class="category-card">
        <img src="images/Ber.PNG" alt="Berline">
        <h3>Berline</h3>
      </a>
      <!-- Category: SUV -->
      <a href="catalogue.php?type_de_carrosserie=SUV" class="category-card">
        <img src="images/suv.PNG" alt="SUV">
        <h3>SUV</h3>
      </a>
      <!-- Category: Compacte -->
      <a href="catalogue.php?type_de_carrosserie=Compacte" class="category-card">
        <img src="images/com.PNG" alt="Compacte">
        <h3>Compacte</h3>
      </a>
      <!-- Category: Utilitaire -->
      <a href="catalogue.php?type_de_carrosserie=pick-up" class="category-card">
        <img src="images/utu.PNG" alt="Utilitaire">
        <h3>Utilitaire</h3>
      </a>
      <!-- Category: Voiture de Sport -->
      <a href="catalogue.php?type_de_carrosserie=Coupé+sportif" class="category-card">
        <img src="images/spo.PNG" alt="Voiture de Sport">
        <h3>Voiture de Sport</h3>
      </a>
    </div>
  </div>
</section>
      <!-- mena yabda lfaza -->
      <section class="py-8 bg-gray-100">
  <div class="container mx-auto px-4">
    <h2 class="text-4xl font-bold text-gray-800 mb-4">Marques Plus Connues</h2>
    <div class="brands-container">
      <!-- Marque: Abarth -->
      <a href="catalogue.php?marque=Abarth" class="brand-button brand-marque">
        <img src="car_imgs/abarth.png" alt="Abarth Logo" class="brand-logo">
        <span class="brand-name"> </span>
      </a>
      
      <!-- Marque: Alpha Romeo -->
      <a href="catalogue.php?marque=Alfa Romeo" class="brand-button brand-marque">
        <img src="car_imgs/alpharomeo.png" alt="Alpha Romeo Logo" class="brand-logo">
        <span class="brand-name"> </span>
      </a>

      <!-- Marque: Alpine -->
      <a href="catalogue.php?marque=Alpine" class="brand-button brand-marque">
        <img src="car_imgs/alpine.png" alt="Alpine Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>

      <!-- Marque: Audi -->
      <a href="catalogue.php?marque=Audi" class="brand-button brand-marque">
        <img src="car_imgs/audi.png" alt="Audi Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>

      <!-- Marque: BMW -->
      <a href="catalogue.php?marque=BMW" class="brand-button brand-marque">
        <img src="car_imgs/bmw.png" alt="BMW Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>

      <!-- Marque: Citroen -->
      <a href="catalogue.php?marque=Citroen" class="brand-button brand-marque">
        <img src="car_imgs/citroen.png" alt="Citroen Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>

      <!-- Marque: Cupra -->
      <a href="catalogue.php?marque=Cupra" class="brand-button brand-marque">
        <img src="car_imgs/cupra.png" alt="Cupra Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>

      <!-- Marque: Dacia -->
      <a href="catalogue.php?marque=Dacia" class="brand-button brand-marque">
        <img src="car_imgs/dacia.png" alt="Dacia Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>

      <!-- Marque: Fiat -->
      <a href="catalogue.php?marque=Fiat" class="brand-button brand-marque">
        <img src="car_imgs/fiat.png" alt="Fiat Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>

      <!-- Marque: Ford -->
      <a href="catalogue.php?marque=Ford" class="brand-button brand-marque">
        <img src="car_imgs/ford.png" alt="Ford Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>

      <!-- Marque: Honda -->
      <a href="catalogue.php?marque=Honda" class="brand-button brand-marque">
        <img src="car_imgs/honda.png" alt="Honda Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>

      <!-- Marque: Mercedes-Benz -->
      <a href="catalogue.php?marque=Mercedes-Benz" class="brand-button brand-marque">
        <img src="car_imgs/mercedes.png" alt="Mercedes Logo" class="brand-logo">
        <span class="brand-name"></span>
      </a>
    </div>
  </div>
</section>
<style>/* CSS spécifique aux boutons de marque */
.brands-container {
  display: grid;
  grid-template-columns: repeat(4, 1fr); /* 4 voitures par ligne */
  grid-gap: 20px; /* Espacement entre les éléments */
}

.brand-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  transition: all 0.3s ease;
}

.brand-card:hover {
  background-color: #f0f0f0;
}

.brand-logo {
  width: 100px; /* Ajustez la taille du logo selon vos besoins */
  height: auto;
}

.brand-name {
  margin-top: 5px;
  font-size: 14px;
  text-align: center;
}

</style>
 </main>

  <footer class="bg-gray-800 text-white">
    <footer class="bg-gray-800 text-white">
      <div class="container mx-auto px-4 py-6">
        <div class="flex flex-wrap justify-between">
          <!-- Left Column -->
          <div class="w-full md:w-1/2 lg:w-1/4 mb-6">
            <h3 class="text-xl font-bold mb-4">Se connecter</h3>
            <ul class="list-none footer-links">
 
              <li><a href="contact.php" class="text-white hover:text-gray-400">Contactez-nous</a></li>
              <li><a href="aproposdenous" class="text-white hover:text-gray-400">Qui sommes-nous?</a></li>
            </ul>
          </div>
          <!-- Right Column -->
          <div class="w-full md:w-1/2 lg:w-1/4 mb-6">
            <h3 class="text-xl font-bold mb-4">Vos recherches</h3>
            <ul class="list-none footer-links">
               <li><a href="comparaison.php" class="text-white hover:text-gray-400">Comparez</a></li>
              <li><a href="#" class="text-white hover:text-gray-400">Nos engagements</a></li>
            </ul>
          </div>
          <!-- Center Alignment for Trademark or Brand information -->
          <div class="w-full md:w-full lg:w-1/2 text-center md:text-left">
            <p class="text-sm text-gray-400 mt-4 md:mt-0">&copy; 2024 CarChoix. Tous droits réservés.</p>
          </div>
        </div>
      </div>
    </footer>

  </footer>
  </body>
  </html>

