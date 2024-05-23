<?php
header('Content-Type: application/json');

// Database configuration settings
$host = 'localhost';
$dbname = 'voiture';
$user = 'root';
$pass = '';

// Create a PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch data
    $stmt = $pdo->prepare("SELECT * FROM co2_emissions_car__1_");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data as JSON
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database Connection Error: ' . $e->getMessage()]);
}
?>
