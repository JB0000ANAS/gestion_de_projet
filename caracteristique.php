<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Véhicule</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/caracteristique.css">
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    <?php
    require 'db.php';
    $id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM vehicules WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if (!$car) {
        echo "<p>Véhicule non trouvé.</p>";
        exit;
    }
    ?>

    <div class="flex flex-col items-center justify-center min-h-screen">
        <br><br>
        <section class="centered-content text-center my-8">
    <h1 class="text-3xl font-bold uppercase"><?php echo htmlspecialchars($car['marque'] . ' ' . $car['nom_modele']); ?></h1>
    <img src="<?php echo htmlspecialchars($car['image_url']); ?>" alt="Image of <?php echo htmlspecialchars($car['marque'] . ' ' . $car['nom_modele']); ?>" class="mx-auto mt-4" style="width: 700px; height: 500px;">
    <div class="mt-4 space-x-2">
        <!-- Link to comparaison.php with the current vehicle's id -->
        <a href="comparaison.php?vehicle1=<?php echo urlencode($id); ?>" class="px-4 py-2 border rounded bg-white hover:bg-gray-100 inline-block">Comparer avec un autre modèle</a>
        <!-- Link to catalogue with brand filter -->
        <a href="catalogue.php?marque=<?php echo urlencode($car['marque']); ?>" class="px-4 py-2 border rounded bg-white hover:bg-gray-100 inline-block">Voir véhicule similaire</a>
        <p class="text-lg font-bold mt-4">À partir de <?php echo number_format($car['prix'], 2, ',', ' '); ?> euro</p>
    </div>
</section>


        <div class="centered-content">

        <section class="container mx-auto p-4">
            <h2 class="text-2xl font-bold mb-4">FICHE TECHNIQUE</h2>
            <div class="grid grid-cols-2 gap-4 text-left mt-10">
                <p><strong>Carrosserie:</strong> <?php echo $car['type_de_carrosserie']; ?></p>
                <p><strong>Vitesse max:</strong> <?php echo $car['vitesse_maximale']; ?>km/h</p>
                <p><strong>Puissance:</strong> <?php echo $car['puissance_du_moteur']; ?> ch</p>
                <p><strong>couple:</strong> <?php echo $car['couple_maximal']; ?></p>
                <p><strong>type de transmission:</strong> <?php echo $car['type_de_boite_de_vitesses']; ?></p>
                <p><strong>acceleration 0->100km/h:</strong> <?php echo $car['acceleration']; ?></p>
                <p><strong>moteur:</strong> <?php echo $car['type_de_moteur']; ?></p>
            </div>
        </section>
        </div>
    </div>
    <footer>
        <ul>
            <li><a href="index.php">Accueil</a></li>
        </ul>
        <ul>
             <li><a href="contact.php">Nous contacter</a></li>
         </ul>
    </footer>
    <style>footer {
    background-color: #343a40;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

footer ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

footer ul li {
    display: inline;
    margin-right: 20px;
}

footer ul li:last-child {
    margin-right: 0;
}

footer a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
}

footer a:hover {
    text-decoration: underline;
}</style>

    <script src="js/main.js"></script>
</body>

</html>



