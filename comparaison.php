<?php
session_start();

// Initialiser les valeurs des véhicules sélectionnés et des critères de comparaison
$vehicle1 = isset($_SESSION['vehicle1']) ? $_SESSION['vehicle1'] : null;
$vehicle2 = isset($_SESSION['vehicle2']) ? $_SESSION['vehicle2'] : null;
$criteria = isset($_SESSION['criteria']) ? $_SESSION['criteria'] : [];

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=voiture;charset=utf8', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Fonction pour récupérer les données d'un véhicule
function getVehicleData($pdo, $vehicleId)
{
    $stmt = $pdo->prepare("SELECT * FROM vehicules WHERE id = ?");
    $stmt->execute([$vehicleId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Récupérer les données des véhicules
$vehicle1Data = $vehicle1 ? getVehicleData($pdo, $vehicle1) : [];
$vehicle2Data = $vehicle2 ? getVehicleData($pdo, $vehicle2) : [];

// Préparation des données pour le graphique
$comparisonData = [];
if (!empty($criteria) && $vehicle1Data && $vehicle2Data) {
    foreach ($criteria as $criterion) {
        $comparisonData[$criterion] = [
            'vehicule1' => $vehicle1Data[$criterion],
            'vehicule2' => $vehicle2Data[$criterion],
        ];
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
    <style>
        /* Styles CSS */
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

<div class="selection">
    <h2>Sélectionner des véhicules à comparer :</h2>
    <form id="comparison-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <select id="vehicle1" name="vehicle1">
            <option value="">Sélectionner un véhicule</option>
            <?php
            $stmt = $pdo->query("SELECT id, nom_modele FROM vehicules");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($row['id'] == $vehicle1) ? 'selected' : '';
                echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['nom_modele'] . '</option>';
            }
            ?>
        </select>

        <select id="vehicle2" name="vehicle2">
            <option value="">Sélectionner un véhicule</option>
            <?php
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($row['id'] == $vehicle2) ? 'selected' : '';
                echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['nom_modele'] . '</option>';
            }
            ?>
        </select>

        <div id="criteria">
            <h2>Sélectionner le critère de comparaison :</h2>
            <select id="comparison-criteria" name="criteria">
                <option value="">Sélectionner un critère</option>
                <option value="prix" <?php if (in_array('prix', $criteria)) echo 'selected'; ?>>Prix</option>
                <option value="capacite_de_la_batterie" <?php if (in_array('capacite_de_la_batterie', $criteria)) echo 'selected'; ?>>Capacité de la batterie</option>
                <option value="autonomie_electrique" <?php if (in_array('autonomie_electrique', $criteria)) echo 'selected'; ?>>Autonomie électrique</option>
                <option value="acceleration" <?php if (in_array('acceleration', $criteria)) echo 'selected'; ?>>Accélération</option>
                <option value="vitesse_maximale" <?php if (in_array('vitesse_maximale', $criteria)) echo 'selected'; ?>>Vitesse maximale</option>
                <option value="nombre_de_cylindres" <?php if (in_array('nombre_de_cylindres', $criteria)) echo 'selected'; ?>>Nombre de cylindres</option>
                <option value="couple_maximal" <?php if (in_array('couple_maximal', $criteria)) echo 'selected'; ?>>Couple maximal</option>
                <option value="puissance_du_moteur" <?php if (in_array('puissance_du_moteur', $criteria)) echo 'selected'; ?>>Puissance moteur</option>
            </select>
        </div>
    </form>
</div>

<div class="comparison">
    <?php if (!empty($comparisonData)) : ?>
        <h2>Résultats de la comparaison :</h2>

        <table>
            <thead>
            <tr>
                <th>Critère</th>
                <th>Véhicule 1</th>
                <th>Véhicule 2</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($comparisonData as $criterion => $data) : ?>
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
            document.getElementById('comparison-criteria').addEventListener('change', function () {
                this.form.submit();
            });

            const jsonData = <?= json_encode($comparisonData); ?>;
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
    <?php endif; ?>
</div>

</body>
</html>
