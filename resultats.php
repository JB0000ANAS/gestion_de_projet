<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupérer les préférences de recherche de l'utilisateur depuis la session
$preferences = $_SESSION['preferences'] ?? [];

// Construire la requête SQL en fonction des préférences de l'utilisateur
$sql = "SELECT * FROM vehicules WHERE 1=1";
$params = [];

if (!empty($preferences['budget'])) {
    $sql .= " AND prix <= ?";
    $params[] = $preferences['budget'];
}

if (!empty($preferences['type_de_boite_de_vitesses'])) {
    $sql .= " AND type_de_boite_de_vitesses = ?";
    $params[] = $preferences['type_de_boite_de_vitesses'];
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Recherche</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>

    <div class="container mx-auto p-4 mt-20">
        <h1 class="text-3xl font-bold mb-4">Résultats de Recherche</h1>
        <?php if (count($vehicules) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($vehicules as $vehicule): ?>
                    <a href="caracteristique.php?id=<?php echo $vehicule['id']; ?>" class="block rounded-lg overflow-hidden border border-gray-300 hover:border-gray-500 transition duration-300 ease-in-out transform hover:-translate-y-1">
                        <img src="<?php echo htmlspecialchars($vehicule['image_url']); ?>" alt="<?php echo htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['nom_modele']); ?>" class="w-full h-auto">
                        <div class="p-4">
                            <h2 class="text-lg font-bold"><?php echo htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['nom_modele']); ?></h2>
                         </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="mt-8 text-center text-gray-600">Aucun résultat trouvé pour les critères de recherche.</p>
        <?php endif; ?>
    </div>
    
    <footer class="bg-gray-800 text-white py-4 mt-8">
        <div class="container mx-auto text-center">
            <ul class="list-none p-0">
                <li class="inline-block mr-4"><a href="index.php" class="hover:underline">Accueil</a></li>
                <li class="inline-block"><a href="contact.php" class="hover:underline">Nous contacter</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
