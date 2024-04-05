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
