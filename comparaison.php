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
    $pdo = new PDO('mysql:host=localhost;dbname=voiture;charset=utf8', 'root', 'root');
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
    <style>
        
        /* Styles CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
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

        h2 {
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
        }

        .comparison {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
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

<div class="selection">
    <h2>Sélectionner des véhicules à comparer :</h2>
    <form id="comparison-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <select id="vehicle1" name="vehicle1">
            <option value="">Sélectionner un véhicule</option>
            <?php
            $stmt = $pdo->query("SELECT id, nom_modele FROM vehicules");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['id'] . '">' . $row['nom_modele'] . '</option>';
            }
            ?>
        </select>

        <select id="vehicle2" name="vehicle2">
            <option value="">Sélectionner un véhicule</option>
            <?php
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['id'] . '">' . $row['nom_modele'] . '</option>';
            }
            ?>
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


</body>
</html>
