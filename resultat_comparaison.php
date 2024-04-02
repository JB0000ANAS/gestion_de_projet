Voici le code modifié avec des vérifications supplémentaires pour éviter les sorties indésirables avant la redirection :
<?php
session_start(); // Cette fonction doit être la première instruction pour travailler correctement avec les sessions.

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les identifiants des véhicules et les critères sélectionnés
    $vehicle1 = isset($_POST['vehicle1']) ? $_POST['vehicle1'] : null;
    $vehicle2 = isset($_POST['vehicle2']) ? $_POST['vehicle2'] : null;
    $criteria = isset($_POST['criteria']) ? $_POST['criteria'] : []; // Assurez-vous que $criteria est un tableau

    // Stocker les données des véhicules en session
    $_SESSION['vehicle1'] = $vehicle1;
    $_SESSION['vehicle2'] = $vehicle2;
    $_SESSION['criteria'] = $criteria;

    
} else {
    // Accéder aux données des véhicules depuis la session si la page n'est pas accédée via un POST
    $vehicle1 = isset($_SESSION['vehicle1']) ? $_SESSION['vehicle1'] : null;
    $vehicle2 = isset($_SESSION['vehicle2']) ? $_SESSION['vehicle2'] : null;
    $criteria = isset($_SESSION['criteria']) ? $_SESSION['criteria'] : [];
}

// Supprimer toutes les sorties avant la redirection
ob_clean();

// Connexion à la base de données et récupération des données des véhicules
$pdo = new PDO("mysql:host=localhost;dbname=voiture", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt1 = $pdo->prepare("SELECT * FROM vehicules WHERE id = :id");
$stmt1->execute(['id' => $vehicle1]);
$vehicle1Data = $stmt1->fetch(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare("SELECT * FROM vehicules WHERE id = :id");
$stmt2->execute(['id' => $vehicle2]);
$vehicle2Data = $stmt2->fetch(PDO::FETCH_ASSOC);

if (!$vehicle1Data || !$vehicle2Data) {
    echo "Aucun véhicule trouvé pour les identifiants fournis.";
    exit;
}

// Préparation des données pour le graphique
$comparisonData = [];
if (!empty($criteria)) {
    foreach ($criteria as $criterion) {
        $comparisonData[$criterion] = [
            'vehicule1' => $vehicle1Data[$criterion],
            'vehicule2' => $vehicle2Data[$criterion],
        ];
    }
}

$jsonData = json_encode($comparisonData);
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

.comparison {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.comparison h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

.comparison ul {
    list-style-type: none;
    padding: 0;
}

.comparison ul li {
    margin-bottom: 10px;
    color: #000;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    color: #000;
}

#chartContainer {
    margin-top: 20px;
}
</style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
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

<div class="comparison">
  <h2>Comparaison entre :</h2>
  <ul>
    <li><strong>Véhicule 1 :</strong> <?= htmlspecialchars($vehicle1Data['nom_modele']) ?></li>
    <li><strong>Véhicule 2 :</strong> <?= htmlspecialchars($vehicle2Data['nom_modele']) ?></li>
  </ul>

  <table>
    <thead>
      <tr>
        <th>Critère</th>
        <th>Véhicule 1</th>
        <th>Véhicule 2</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($comparisonData as $criterion => $data): ?>
        <tr>
          <td><?= htmlspecialchars(ucfirst($criterion)) ?></td>
          <td><?= htmlspecialchars($data['vehicule1']) ?></td>
          <td><?= htmlspecialchars($data['vehicule2']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div id="chartContainer">
   

 <canvas id="myChart"></canvas>
  </div>

  <script>
    const jsonData = JSON.parse('<?= $jsonData ?>');
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: Object.keys(jsonData),
        datasets: [{
          label: 'Véhicule 1',
          data: Object.values(jsonData).map(data => data.vehicule1),
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }, {
          label: 'Véhicule 2',
          data: Object.values(jsonData).map(data => data.vehicule2),
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</div>

</body>
</html>
 
 
