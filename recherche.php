<?php
// Connexion à la base de données MySQL
$pdo = new PDO('mysql:host=localhost;dbname=voiture;charset=utf8', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des valeurs uniques pour les champs spécifiques
$typesBoiteVitesses = $pdo->query("SELECT DISTINCT type_de_boite_de_vitesses FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
$typesCarrosserie = $pdo->query("SELECT DISTINCT type_de_carrosserie FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
$typesMoteur = $pdo->query("SELECT DISTINCT type_de_moteur FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
$marques = $pdo->query("SELECT DISTINCT marque FROM vehicules")->fetchAll(PDO::FETCH_COLUMN); // Récupération des marques

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
    <style>
        /* Reset CSS */
body, h1, h2, h3, p, ul, li, form, input, select, textarea, button {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Global Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo img {
    height: 50px;
}

nav ul {
    list-style-type: none;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

h1 {
    text-align: center;
    margin-top: 30px;
}

form {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    margin: 0 auto;
}

form label {
    display: block;
    font-size: 18px;
    margin-bottom: 10px;
}

input[type="text"],
select,
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="number"] {
    width: calc(100% - 22px); /* Pour prendre en compte les flèches du champ number */
}

select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('arrow.png'); /* Ajoute une flèche personnalisée */
    background-repeat: no-repeat;
    background-position: right center;
    background-size: 15px;
}

textarea {
    resize: vertical;
}

button {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #555;
}

        </style>
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
                <li><a href="contact.php">Nous contacter</a></li>
            </ul>
        </nav>
    </header>
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
