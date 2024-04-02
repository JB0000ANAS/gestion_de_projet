<?php
// Connexion à la base de données MySQL
$pdo = new PDO('mysql:host=localhost;dbname=voiture;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des résultats de la recherche depuis le formulaire de recherche
$marque = $_POST['marque'];
$type_de_carrosserie = $_POST['type_de_carrosserie'];
$nombre_de_sieges = $_POST['nombre_de_sieges'];
$type_de_moteur = $_POST['type_de_moteur'];
$type_de_boite_de_vitesses = $_POST['type_de_boite_de_vitesses'];

// Requête SQL pour récupérer les résultats des voitures correspondant aux critères de recherche
$query = "SELECT * FROM vehicules WHERE marque = :marque AND type_de_carrosserie = :type_de_carrosserie AND nombre_de_sieges = :nombre_de_sieges AND type_de_moteur = :type_de_moteur AND type_de_boite_de_vitesses = :type_de_boite_de_vitesses";
$stmt = $pdo->prepare($query);
$stmt->execute([
    'marque' => $marque,
    'type_de_carrosserie' => $type_de_carrosserie,
    'nombre_de_sieges' => $nombre_de_sieges,
    'type_de_moteur' => $type_de_moteur,
    'type_de_boite_de_vitesses' => $type_de_boite_de_vitesses
]);
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la recherche</title>
    <link rel="stylesheet" href="style_resultat.css">
    
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo CarChoix">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">Inscription</a></li>
            </ul>
        </nav>
    </header>
    <h1>Résultats de la recherche</h1>
    <div class="results">
        <?php foreach ($resultats as $resultat): ?>
            <div class="car">
                <img src="<?= $resultat['image_url'] ?>" alt="<?= $resultat['nom_modele'] ?>">
                <h2><?= $resultat['nom_modele'] ?></h2>
                <ul>
                    <li><strong>Nombre de sièges:</strong> <?= $resultat['nombre_de_sieges'] ?></li>
                    <li><strong>Largeur:</strong> <?= $resultat['largeur'] ?></li>
                    <li><strong>Longueur:</strong> <?= $resultat['longueur'] ?></li>
                    <li><strong>Hauteur:</strong> <?= $resultat['hauteur'] ?></li>
                    <li><strong>Capacité du moteur:</strong> <?= $resultat['capacite_du_moteur'] ?></li>
                    <li><strong>Puissance du moteur:</strong> <?= $resultat['puissance_du_moteur'] ?></li>
                    <li><strong>Nombre de cylindres:</strong> <?= $resultat['nombre_de_cylindres'] ?></li>
                    <li><strong>Type de boîte de vitesses:</strong> <?= $resultat['type_de_boite_de_vitesses'] ?></li>
                    <li><strong>Vitesse maximale:</strong> <?= $resultat['vitesse_maximale'] ?></li>
                    <li><strong>Accélération:</strong> <?= $resultat['acceleration'] ?></li>
                    <li><strong>Autonomie électrique:</strong> <?= $resultat['autonomie_electrique'] ?></li>
                    <li><strong>Capacité de la batterie:</strong> <?= $resultat['capacite_de_la_batterie'] ?></li>
                    <li><strong>Prix:</strong> <?= $resultat['prix'] ?></li>
                </ul>
 

                
            </div>
        <?php endforeach; ?>
    </div>
    <footer>
        <p>&copy; 2024 CarChoix</p>
    </footer>
</body>
</html>
