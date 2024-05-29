<?php
$modelParams = json_decode(file_get_contents('random_forest_model_simplified.json'), true);

function predictEmissions($engineSize, $cylinders, $fuelConsumption, $modelParams) {
    $estimators = $modelParams['estimators'];
    $numEstimators = count($estimators);
    
    $predictions = [];
    foreach ($estimators as $estimator) {
        $prediction = traverseTree($estimator, [$engineSize, $cylinders, $fuelConsumption]);
        $predictions[] = $prediction;
    }
    
    $predictedEmissions = array_sum($predictions) / $numEstimators;
    return $predictedEmissions;
}

function traverseTree($tree, $features) {
    $nodeIndex = 0;
    
    while (true) {
        $featureIndex = $tree['feature_indices'][$nodeIndex];
        $threshold = $tree['threshold'][$nodeIndex];
        
        if ($featureIndex == -2) {
            $value = $tree['value'][$nodeIndex][0][0];
            return $value;
        }
        
        if ($features[$featureIndex] <= $threshold) {
            $nodeIndex = $tree['children_left'][$nodeIndex];
        } else {
            $nodeIndex = $tree['children_right'][$nodeIndex];
        }
    }
}

if (isset($_POST['engineSize']) && isset($_POST['cylinders']) && isset($_POST['fuelConsumption'])) {
    $engineSize = $_POST['engineSize'];
    $cylinders = $_POST['cylinders'];
    $fuelConsumption = $_POST['fuelConsumption'];

    $predictedEmissions = predictEmissions($engineSize, $cylinders, $fuelConsumption, $modelParams);

    header('Content-Type: application/json');
    echo json_encode(['predictedEmissions' => $predictedEmissions]);
    exit();
}
include 'run_python.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prédiction des Émissions de CO2</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.css">
    <style>
        .score-meter {
            width: 100%;
            height: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
        }
        .score-meter-fill {
            height: 100%;
            background-color: #4CAF50;
            transition: width 0.5s ease;
        }
        .score-label {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }
        .slider-label {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Prédiction des Émissions de CO2</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ajuster les Caractéristiques du Véhicule</h5>
                        <div class="mb-3">
                            <div id="engineSizeSlider"></div>
                            <div class="slider-label">Taille du Moteur (L) : <span id="engineSizeValue"></span></div>
                        </div>
                        <div class="mb-3">
                            <div id="cylindersSlider"></div>
                            <div class="slider-label">Cylindres : <span id="cylindersValue"></span></div>
                        </div>
                        <div class="mb-3">
                            <div id="fuelConsumptionSlider"></div>
                            <div class="slider-label">Consommation de Carburant (L/100 km) : <span id="fuelConsumptionValue"></span></div>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="predictCO2Emissions()">Prédire</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Résultat de la Prédiction</h5>
                        <div id="predictionResult" class="mb-3"></div>
                        <div class="score-meter">
                            <div id="scoreMeterFill" class="score-meter-fill"></div>
                        </div>
                        <div id="scoreLabel" class="score-label"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.4/nouislider.min.js"></script>
    <script>
        const engineSizeSlider = document.getElementById('engineSizeSlider');
        const cylindersSlider = document.getElementById('cylindersSlider');
        const fuelConsumptionSlider = document.getElementById('fuelConsumptionSlider');

        noUiSlider.create(engineSizeSlider, {
            start: 2.0,
            range: {
                'min': 1.0,
                'max': 6.0
            },
            step: 0.1,
            connect: 'lower',
            format: {
                to: function(value) {
                    return value.toFixed(1);
                },
                from: function(value) {
                    return parseFloat(value);
                }
            }
        });

        noUiSlider.create(cylindersSlider, {
            start: 4,
            range: {
                'min': 1,
                'max': 12
            },
            step: 1,
            connect: 'lower',
            format: {
                to: function(value) {
                    return value.toFixed(0);
                },
                from: function(value) {
                    return parseInt(value);
                }
            }
        });

        noUiSlider.create(fuelConsumptionSlider, {
            start: 7.0,
            range: {
                'min': 3.0,
                'max': 20.0
            },
            step: 0.1,
            connect: 'lower',
            format: {
                to: function(value) {
                    return value.toFixed(1);
                },
                from: function(value) {
                    return parseFloat(value);
                }
            }
        });

        engineSizeSlider.noUiSlider.on('update', function(values, handle) {
            document.getElementById('engineSizeValue').textContent = values[handle];
        });

        cylindersSlider.noUiSlider.on('update', function(values, handle) {
            document.getElementById('cylindersValue').textContent = values[handle];
        });

        fuelConsumptionSlider.noUiSlider.on('update', function(values, handle) {
            document.getElementById('fuelConsumptionValue').textContent = values[handle];
        });

        function calculateScore(emissions) {
            if (emissions <= 100) {
                return 100;
            } else if (emissions <= 150) {
                return 90;
            } else if (emissions <= 200) {
                return 80;
            } else if (emissions <= 250) {
                return 70;
            } else if (emissions <= 300) {
                return 60;
            } else {
                return 50;
            }
        }

        function getScoreColor(score) {
            if (score >= 90) {
                return '#4CAF50';
            } else if (score >= 70) {
                return '#FFC107';
            } else {
                return '#F44336';
            }
        }

        function predictCO2Emissions() {
            const engineSize = parseFloat(engineSizeSlider.noUiSlider.get());
            const cylinders = parseInt(cylindersSlider.noUiSlider.get());
            const fuelConsumption = parseFloat(fuelConsumptionSlider.noUiSlider.get());

            const predictionResult = document.getElementById('predictionResult');
            const scoreMeterFill = document.getElementById('scoreMeterFill');
            const scoreLabel = document.getElementById('scoreLabel');

            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    const predictedEmissions = response.predictedEmissions;

                    predictionResult.textContent = `Émissions de CO2 Prédites : ${predictedEmissions.toFixed(2)} g/km`;

                    const score = calculateScore(predictedEmissions);
                    scoreMeterFill.style.width = `${score}%`;
                    scoreMeterFill.style.backgroundColor = getScoreColor(score);
                    scoreLabel.textContent = `Score : ${score}`;
                }
            };
            xhr.open('POST', '');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(`engineSize=${engineSize}&cylinders=${cylinders}&fuelConsumption=${fuelConsumption}`);
        }
    </script>
</body>
</html>
