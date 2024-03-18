<?php
// Connexion à la base de données MySQL
$pdo = new PDO('mysql:host=localhost;dbname=voiture;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des valeurs uniques pour les champs spécifiques
$typesBoiteVitesses = $pdo->query("SELECT DISTINCT type_de_boite_de_vitesses FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
$typesCarrosserie = $pdo->query("SELECT DISTINCT type_de_carrosserie FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
$typesMoteur = $pdo->query("SELECT DISTINCT type_de_moteur FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
$marques = $pdo->query("SELECT DISTINCT marque FROM vehicules")->fetchAll(PDO::FETCH_COLUMN); // Récupération des marques
// Récupération de toutes les marques uniques
$marques = $pdo->query("SELECT DISTINCT marque FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);

// Liste des marques "TOP"
$marquesTop = ['Audi', 'BMW', 'Citroen', 'Mercedes-Benz', 'Alpine', 'Peugeot'];

// Liste des marques "AUTRE" (toutes les marques qui ne sont pas dans $marquesTop)
$marquesAutre = array_diff($marques, $marquesTop);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Formulaire de recherche de voiture</h1>
    <form action="resultat.php" method="post">
        <label for="marque">Marque:</label><br>
        <select id="marque" name="marque">
            <optgroup label="TOP MARQUES">
                <?php foreach ($marquesTop as $marque): ?>
                    <option value="<?= $marque ?>"><?= $marque ?></option>
                <?php endforeach; ?>
            </optgroup>
            <optgroup label="AUTRES MARQUES">
                <?php foreach ($marquesAutre as $marque): ?>
                    <option value="<?= $marque ?>"><?= $marque ?></option>
                <?php endforeach; ?>
            </optgroup>
        </select><br>
        
        <label for="type_de_carrosserie">Type de carrosserie:</label><br>
        <select id="type_de_carrosserie" name="type_de_carrosserie">
            <?php foreach ($typesCarrosserie as $type): ?>
                <option value="<?= $type ?>"><?= $type ?></option>
            <?php endforeach; ?>
        </select><br>
        
        <label for="nombre_de_sieges">Nombre de sièges:</label><br>
        <input type="number" id="nombre_de_sieges" name="nombre_de_sieges" min="1" max="10"><br>
        
        <label for="type_de_moteur">Type de moteur:</label><br>
        <select id="type_de_moteur" name="type_de_moteur">
            <?php foreach ($typesMoteur as $type): ?>
                <option value="<?= $type ?>"><?= $type ?></option>
            <?php endforeach; ?>
        </select><br>
        
        <label for="type_de_boite_de_vitesses">Type de boîte de vitesses:</label><br>
        <select id="type_de_boite_de_vitesses" name="type_de_boite_de_vitesses">
            <?php foreach ($typesBoiteVitesses as $type): ?>
                <option value="<?= $type ?>"><?= $type ?></option>
            <?php endforeach; ?>
        </select><br>
        
        <input type="submit" value="Rechercher">
    </form>
</body>
</html>
