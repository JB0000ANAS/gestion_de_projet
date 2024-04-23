<?php
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les identifiants des véhicules et les critères sélectionnés
    $vehicle1 = isset($_POST['vehicle1']) ? $_POST['vehicle1'] : null;
    $vehicle2 = isset($_POST['vehicle2']) ? $_POST['vehicle2'] : null;
    $criteria = isset($_POST['criteria']) ? $_POST['criteria'] : [];

    // Stocker les données des véhicules en session
    $_SESSION['vehicle1'] = $vehicle1;
    $_SESSION['vehicle2'] = $vehicle2;
    $_SESSION['criteria'] = $criteria;

    // Redirection vers la même page pour afficher les résultats
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=voiture", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Initialiser les données des véhicules à vide
$vehicle1Data = $vehicle2Data = $comparisonData = [];

// Vérifier si les véhicules sont sélectionnés
if (isset($_SESSION['vehicle1'], $_SESSION['vehicle2'])) {
    // Préparer et exécuter les requêtes pour récupérer les données des véhicules
    $stmt1 = $pdo->prepare("SELECT * FROM vehicules WHERE id = ?");
    $stmt2 = $pdo->prepare("SELECT * FROM vehicules WHERE id = ?");
    $stmt1->execute([$_SESSION['vehicle1']]);
    $stmt2->execute([$_SESSION['vehicle2']]);
    $vehicle1Data = $stmt1->fetch(PDO::FETCH_ASSOC);
    $vehicle2Data = $stmt2->fetch(PDO::FETCH_ASSOC);

    // Préparation des données pour le graphique si les véhicules sont trouvés
    if ($vehicle1Data && $vehicle2Data) {
        foreach ($_SESSION['criteria'] as $criterion) {
            $comparisonData[$criterion] = [
                'vehicule1' => $vehicle1Data[$criterion],
                'vehicule2' => $vehicle2Data[$criterion],
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparaison de véhicules</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/comparaison.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body>
<header>
<?php include 'navbar.php'; ?>
</header>


<h1>Comparaison de véhicules</h1>

<div class="selection">
    <h2>Sélectionner des véhicules à comparer :</h2>
    <form id="comparison-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <!-- Vehicle selection dropdowns -->
        <?php
        // Fetch all vehicles once and reuse the list for both dropdowns
        $stmt = $pdo->query("SELECT id, nom_modele FROM vehicules");
        $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <select id="vehicle1" name="vehicle1">
            <option value="">Sélectionner un véhicule</option>
            <?php foreach ($vehicles as $row): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nom_modele']); ?></option>
            <?php endforeach; ?>
        </select>

        <select id="vehicle2" name="vehicle2">
            <option value="">Sélectionner un véhicule</option>
            <?php foreach ($vehicles as $row): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nom_modele']); ?></option>
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


<?php if ($comparisonData): ?>
    <div class="comparison">
        <h2>Résultats de la comparaison :</h2>

        <!-- Ajout des images des voitures -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <img src="<?= htmlspecialchars($vehicle1Data['image_url']) ?>" alt="<?= htmlspecialchars($vehicle1Data['nom_modele']) ?>" style="max-width: 45%;">
            <img src="<?= htmlspecialchars($vehicle2Data['image_url']) ?>" alt="<?= htmlspecialchars($vehicle2Data['nom_modele']) ?>" style="max-width: 45%;">
        </div>

        <table>
            <thead>
            <tr>
                <th>Critère</th>
                <th><?= htmlspecialchars($vehicle1Data['nom_modele']) ?></th>
                <th><?= htmlspecialchars($vehicle2Data['nom_modele']) ?></th>
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
            const jsonData = <?= json_encode($comparisonData); ?>;
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: Object.keys(jsonData),
                    datasets: [{
                        label: '<?= htmlspecialchars($vehicle1Data['nom_modele']) ?>',
                        data: Object.values(jsonData).map(data => data.vehicule1),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }, {
                        label: '<?= htmlspecialchars($vehicle2Data['nom_modele']) ?>',
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
<?php endif; ?>
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
</body>
</html>