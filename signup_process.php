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
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($email) || empty($first_name) || empty($last_name) || empty($password) || empty($confirm_password)) {
        $response['message'] = "Tous les champs sont obligatoires.";
    } else if ($password !== $confirm_password) {
        $response['message'] = "Les mots de passe ne correspondent pas.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE mail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response['message'] = "Un utilisateur existe déjà avec cette adresse e-mail.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO utilisateur (nom, prenom, mail, mdp) VALUES (:nom, :prenom, :mail, :mdp)");
            $insert->bindParam(':nom', $last_name);
            $insert->bindParam(':prenom', $first_name);
            $insert->bindParam(':mail', $email);
            $insert->bindParam(':mdp', $hashed_password);

            if ($insert->execute()) {
                $response['success'] = true;
                $response['message'] = "Inscription réussie.";
                $_SESSION['user_nom'] = $first_name;
                $_SESSION['user_prenom'] = $last_name;
                $_SESSION['user_id'] = $conn->lastInsertId();
            } else {
                $response['message'] = "Une erreur s'est produite lors de l'inscription.";
            }
        }
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    header('Location: signup.php');
    exit();
}
?>

