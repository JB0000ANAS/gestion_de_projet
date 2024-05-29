<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $budget = $_POST['budget'] ?? null;
    $marque = $_POST['marque'] ?? null;
    $type_de_boite_de_vitesses = $_POST['type_de_boite_de_vitesses'] ?? null;

    // Mettre à jour les préférences de l'utilisateur
    $stmt = $pdo->prepare("UPDATE utilisateur SET budget = :budget WHERE id = :user_id");
    $stmt->execute([
        'budget' => $budget,
         
        'user_id' => $user_id
    ]);

    // Enregistrer les préférences de recherche dans la session
    $_SESSION['preferences'] = [
        'budget' => $budget,
        'marque' => $marque,
        'type_de_boite_de_vitesses' => $type_de_boite_de_vitesses
    ];

    header('Location: resultats.php');
    exit;
}

// Récupérer les options depuis la base de données
$marques = $pdo->query("SELECT DISTINCT marque FROM vehicules")->fetchAll(PDO::FETCH_ASSOC);
$type_de_boite_de_vitesses = $pdo->query("SELECT DISTINCT type_de_boite_de_vitesses FROM vehicules")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les IDs des voitures préférées de l'utilisateur
$user_preferences_stmt = $pdo->prepare("SELECT preferences FROM utilisateur WHERE id = :user_id");
$user_preferences_stmt->execute(['user_id' => $user_id]);
$user = $user_preferences_stmt->fetch(PDO::FETCH_ASSOC);

// Décoder les préférences JSON en tableau
$preferences = json_decode($user['preferences'], true) ?? [];
if (json_last_error() !== JSON_ERROR_NONE) {
    $preferences = [];
    error_log('Erreur de décodage JSON: ' . json_last_error_msg());
}

// Récupérer les détails des voitures préférées
$preferred_cars = [];
foreach ($preferences as $car_id) {
    $stmt = $pdo->prepare("SELECT * FROM vehicules WHERE id = :car_id");
    $stmt->execute(['car_id' => $car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($car) {
        $preferred_cars[] = $car;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préférences Utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .preferred-cars-list {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .preferred-car-item {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .preferred-car-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>

    <div class="container mx-auto p-4 mt-20">
        <h1 class="text-3xl font-bold mb-4">Préférences de Recherche</h1>
        <form action="preferences.php" method="post" class="bg-white p-6 rounded shadow-md">
            <div class="mb-4">
                <label for="budget" class="block text-gray-700 font-semibold">Budget (€)</label>
                <input type="number" name="budget" id="budget" class="w-full border-gray-300 rounded mt-1 p-2">
            </div>
            <div class="mb-4">
                <label for="marque" class="block text-gray-700 font-semibold">Marque</label>
                <select name="marque" id="marque" class="w-full border-gray-300 rounded mt-1 p-2">
                    <?php foreach ($marques as $marque): ?>
                        <option value="<?php echo htmlspecialchars($marque['marque']); ?>"><?php echo htmlspecialchars($marque['marque']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="type_de_boite_de_vitesses" class="block text-gray-700 font-semibold">Type de boite de vitesse</label>
                <select name="type_de_boite_de_vitesses" id="type_de_boite_de_vitesses" class="w-full border-gray-300 rounded mt-1 p-2">
                    <?php foreach ($type_de_boite_de_vitesses as $type): ?>
                        <option value="<?php echo htmlspecialchars($type['type_de_boite_de_vitesses']); ?>"><?php echo htmlspecialchars($type['type_de_boite_de_vitesses']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Enregistrer</button>
        </form>

        <h2 class="text-2xl font-bold mt-8">Voitures Préférées</h2>
        <?php if (!empty($preferred_cars)): ?>
            <div class="preferred-cars-list mt-4">
                <?php foreach ($preferred_cars as $car): ?>
                    <div class="preferred-car-item">
                        <span class="text-lg font-semibold"><?php echo htmlspecialchars($car['marque'] . ' ' . $car['nom_modele']); ?></span>
                        <!-- Ajoutez d'autres détails de la voiture ici si nécessaire -->
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="mt-4 text-gray-600">Aucune voiture préférée enregistrée.</p>
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

