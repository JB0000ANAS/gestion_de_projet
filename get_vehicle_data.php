<?php
session_start();
function get_vehicle_data($id) {
  $pdo = new PDO("mysql:host=localhost;dbname=voiture", "root", "");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT * FROM vehicules WHERE id = :id");
  $stmt->execute(['id' => $id]);

  $vehicleData = $stmt->fetch(PDO::FETCH_ASSOC);

  // Ajout de la conversion des valeurs numériques pour une meilleure comparaison
  foreach ($vehicleData as $key => &$value) {
    if (is_numeric($value)) {
        $value = number_format($value, 2, '.', '');
    }
  }

  return $vehicleData;
}





 
