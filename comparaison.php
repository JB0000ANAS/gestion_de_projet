<?php
session_start();  
?>
<!DOCTYPE html>
<html lang="fr">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Comparaison de véhicules</title>
 <link rel="stylesheet" href="style.css">
 <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

header {
    background-color: #343a40;
    color: #fff;
    padding: 10px 0;
    text-align: center;
}

.logo img {
    height: 50px;
}

nav ul {
    list-style-type: none;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

h1 {
    text-align: center;
}

.selection {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h2 { color: #000;
    font-size: 24px;
    margin-bottom: 20px;
    
}

form {
    display: flex;
    flex-direction: column;
}

select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
}

label {
    margin-bottom: 10px;
    color: #000;
}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
}

button[type="submit"]:hover {
    background-color: #0056b3;
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
            </ul>
        </nav>
 </header>
 <h1>Comparaison de véhicules</h1>

 <div class="selection">
    <h2>Sélectionner des véhicules à comparer :</h2>
    <?php
    // Récupération des véhicules depuis la base de données
    $pdo = new PDO("mysql:host=localhost;dbname=voiture", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT id, nom_modele FROM vehicules");
    $vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <form id="comparison-form" action="resultat_comparaison.php" method="post">
      <select id="vehicle1" name="vehicle1">
        <option value="">Sélectionner un véhicule</option>
        <?php foreach ($vehicules as $vehicule): ?>
          <option value="<?= $vehicule['id'] ?>"><?= $vehicule['nom_modele'] ?></option>
        <?php endforeach; ?>
      </select>
      
      <select id="vehicle2" name="vehicle2">
        <option value="">Sélectionner un véhicule</option>
        <?php foreach ($vehicules as $vehicule): ?>
          <option value="<?= $vehicule['id'] ?>"><?= $vehicule['nom_modele'] ?></option>
        <?php endforeach; ?>
      </select>
      
      <div id="criteria">
        <h2>Sélectionner les critères de comparaison :</h2>
        <label><input type="checkbox" name="criteria[]" value="prix"> Prix</label>
        <label><input type="checkbox" name="criteria[]" value="capacite_de_la_batterie"> Capacité de la batterie</label>
        <label><input type="checkbox" name="criteria[]" value="autonomie_electrique"> Autonomie électrique</label>
        <label><input type="checkbox" name="criteria[]" value="acceleration"> Accélération</label>
        <label><input type="checkbox" name="criteria[]" value="vitesse_maximale"> Vitesse maximale</label>
        <label><input type="checkbox" name="criteria[]" value="nombre_de_cylindres"> Nombre de cylindres</label>
        <label><input type="checkbox" name="criteria[]" value="couple_maximal"> Couple maximal</label>
        <label><input type="checkbox" name="criteria[]" value="puissance_du_moteur"> Puissance moteur</label>
      </div>
      <button type="submit">Comparer</button>
    </form>
 </div>

</body>
</html>


