<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparaison de véhicules</title>
    <link rel="stylesheet" href="style.css">
    <!-- Inclure la bibliothèque Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        $pdo = new PDO('mysql:host=localhost;dbname=voiture;charset=utf8', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->query("SELECT id, nom_modele FROM vehicules");
        $vehicules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <select id="vehicle1">
            <option value="">Sélectionner un véhicule</option>
            <?php foreach ($vehicules as $vehicule): ?>
                <option value="<?= $vehicule['id'] ?>"><?= $vehicule['nom_modele'] ?></option>
            <?php endforeach; ?>
        </select>
        <select id="vehicle2">
            <option value="">Sélectionner un véhicule</option>
            <?php foreach ($vehicules as $vehicule): ?>
                <option value="<?= $vehicule['id'] ?>"><?= $vehicule['nom_modele'] ?></option>
            <?php endforeach; ?>
        </select>
        <button id="compare-btn">Comparer</button>
    </div>

    <div class="charts">
        <canvas id="chart1" width="400" height="300"></canvas>
        <canvas id="chart2" width="400" height="300"></canvas>
    </div>

    <script>
    // Code JavaScript pour la comparaison des véhicules
    $(document).ready(function() {
        // Gestion du clic sur le bouton "Comparer"
        $('#compare-btn').click(function() {
            // Récupération des ID des véhicules sélectionnés
            var vehicle1 = $('#vehicle1').val();
            var vehicle2 = $('#vehicle2').val();

            // Vérification si les deux véhicules sont sélectionnés
            if (vehicle1 && vehicle2) {
                // Chargement des données du premier véhicule
                $.ajax({
                    url: "get_vehicle_data.php",
                    method: 'POST',
                    data: { vehicleId: vehicle1 },
                    success: function(data1) {
                        // Chargement des données du deuxième véhicule
                        $.ajax({
                            url: "get_vehicle_data.php",
                            method: 'POST',
                            data: { vehicleId: vehicle2 },
                            success: function(data2) {
                                // Dessiner les graphiques
                                drawCharts(JSON.parse(data1), JSON.parse(data2));
                            }
                        });
                    }
                });
            } else {
                alert('Veuillez sélectionner deux véhicules à comparer.');
            }
        });
    });

    // Fonction pour dessiner les graphiques à l'aide de Chart.js
    function drawCharts(data1, data2) {
        const labels = Object.keys(data1);
        const data1Values = Object.values(data1);
        const data2Values = Object.values(data2);

        // Dessiner le premier graphique
        const ctx1 = document.getElementById('chart1').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Véhicule 1',
                    data: data1Values,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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

        // Dessiner le deuxième graphique
        const ctx2 = document.getElementById('chart2').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Véhicule 2',
                    data: data2Values,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
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
    }
</script>

</body>
</html>
