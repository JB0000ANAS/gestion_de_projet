<?php
// Connexion à la base de données MySQL
$pdo = new PDO('mysql:host=localhost;dbname=voiture;charset=utf8', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérification si l'identifiant du véhicule est spécifié dans la requête
if (isset($_POST['id'])) {
    // Récupération de l'identifiant du véhicule depuis la requête
    $id = $_POST['id'];

    // Requête SQL pour récupérer les données du véhicule depuis la base de données
    $stmt = $pdo->prepare("SELECT * FROM vehicules WHERE id = ?");
    $stmt->execute([$id]);
    $vehicleData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification si des données ont été trouvées pour le véhicule spécifié
    if ($vehicleData) {
        // Conversion des données en format JSON et envoi de la réponse
        echo json_encode($vehicleData);
    } else {
        // Si aucun véhicule correspondant à l'identifiant n'est trouvé, renvoyer une réponse d'erreur
        http_response_code(404);
        echo json_encode(array("message" => "Aucun véhicule trouvé avec cet identifiant."));
    }
} else {
    // Si aucun identifiant de véhicule n'est spécifié dans la requête, renvoyer une réponse d'erreur
    http_response_code(400);
    echo json_encode(array("message" => "Identifiant de véhicule non spécifié."));
}
?>
