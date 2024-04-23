<?php
$host = 'localhost';
$dbname = 'voiture';
$user = 'root';
$pass = '';

// Initialize article variable
$article = null;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $article_id = $_GET['id'];

        $stmt = $pdo->prepare("SELECT * FROM article WHERE id = :id");
        $stmt->execute(['id' => $article_id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$article) {
            // Article not found, redirect to an error page or show a 404 message
            header("Location: error_page.php");
            exit;
        }
    } else {
        // ID not set or not numeric, redirect to an error page or show a 404 message
        header("Location: error_page.php");
        exit;
    }
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données: ' . $e->getMessage());
}
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($article['title']); ?> - CarChoix</title>
  <link href="css/article_style.css" rel="stylesheet">
</head>
<body>
  

<article class="article-container">
  <header class="article-header">
    <h1><?php echo htmlspecialchars($article['title']); ?></h1>
    <img src="<?php echo htmlspecialchars($article['imgurl']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="article-main-image">
  </header>

  <section class="article-content">
    <div class="article-text">
      <?php echo nl2br(htmlspecialchars($article['text'])); ?>
    </div>
    <?php if (!empty($article['videourl'])): ?>
      <div class="article-video">

        <?php
          $videoUrl = $article['videourl'];
          $videoId = null;

          // Extract video ID from YouTube URL (if present)
          if (preg_match('/^.*((v\/|embed\/|watch\?v=)|([^#]\/[^#?]*))([^#&?]*)/', $videoUrl, $matches)) {
            $videoId = $matches[4];
          }
        ?>

        <?php if ($videoId): ?>
          <iframe src="https://www.youtube.com/embed/<?php echo $videoId; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <?php else: ?>
          <p class="error-message">Une erreur est survenue. Le lien vidéo fourni est invalide.</p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </section>
</article>

</body>
<footer>
        <ul>
        <div class="w-full md:w-full lg:w-1/2 text-center md:text-left">
            <p class="text-sm text-gray-400 mt-4 md:mt-0">&copy; 2024 CarChoix. Tous droits réservés.</p>
          </div>
             
        </ul>
    </footer>
</html>