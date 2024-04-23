<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voiture";
$response = ['success' => false, 'message' => ''];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $response['message'] = "Erreur de connexion : " . $e->getMessage();
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_email = $_POST['email']; // Ensure this matches the 'name' attribute in your form
    $user_password = $_POST['password']; // Same here for the 'password'

    if (empty($user_email) || empty($user_password)) {
        $response['message'] = "L'adresse e-mail et le mot de passe sont obligatoires.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE mail = :email");
        $stmt->bindParam(':email', $user_email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($user_password, $user['mdp'])) {
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];

            $response['success'] = true;
            $response['message'] = "Connexion réussie.";
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } else {
            $response['message'] = "Identifiants de connexion invalides.";
        }
    }
} else {
    header('Location: login.php'); // Redirect back to login page if the method is not POST
    exit();
}

header('Content-Type: application/json');
echo json_encode($response);
?>

