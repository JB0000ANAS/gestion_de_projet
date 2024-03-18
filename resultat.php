<?php
// Connexion à la base de données MySQL
$pdo = new PDO('mysql:host=localhost;dbname=voiture;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$results = []; // Initialise les résultats pour éviter des erreurs en dehors du bloc POST
$afficherModelesDeLaMarque = false; // Flag pour savoir quand afficher les modèles de la marque

// Traitement du formulaire si soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marque = $_POST['marque'] ?? null;
    $type_de_carrosserie = $_POST['type_de_carrosserie'] ?? null;
    $nombre_de_sieges = $_POST['nombre_de_sieges'] ?? null;
    $type_de_moteur = $_POST['type_de_moteur'] ?? null;
    $type_de_boite_de_vitesses = $_POST['type_de_boite_de_vitesses'] ?? null;

    // Construction de la requête SQL avec tous les critères de recherche
    $sql = "SELECT * FROM vehicules WHERE 1=1";
    $params = [];

    if ($marque) {
        $sql .= " AND marque LIKE :marque";
        $params[':marque'] = "%$marque%";
    }
    
    if ($type_de_carrosserie) {
        $sql .= " AND type_de_carrosserie LIKE :type_de_carrosserie";
        $params[':type_de_carrosserie'] = "%$type_de_carrosserie%";
    }
    
    if ($nombre_de_sieges) {
        $sql .= " AND nombre_de_sieges LIKE :nombre_de_sieges";
        $params[':nombre_de_sieges'] = "%$nombre_de_sieges%";
    }
    
    if ($type_de_moteur) {
        $sql .= " AND type_de_moteur LIKE :type_de_moteur";
        $params[':type_de_moteur'] = "%$type_de_moteur%";
    }
    
    if ($type_de_boite_de_vitesses) {
        $sql .= " AND type_de_boite_de_vitesses LIKE :type_de_boite_de_vitesses";
        $params[':type_de_boite_de_vitesses'] = "%$type_de_boite_de_vitesses%";
    }
    
    }
    // Exécution de la requête
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Vérification si des résultats ont été trouvés
    if ($stmt->rowCount() > 0) {
        // Affichage des résultats
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Si aucun résultat trouvé, préparez-vous à afficher tous les modèles de la marque sélectionnée
        $afficherModelesDeLaMarque = true;
        $message = "Résultat pas trouvé. Merci de consulter notre catalogue de la marque choisie.";
        // Nouvelle requête pour récupérer tous les "nom_modele" avec la même "marque"
        $sql = "SELECT nom_modele FROM vehicules WHERE marque LIKE :marque";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':marque' => "%$marque%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de recherche de voiture</title>
</head>
<body>
    <h1>Résultats de recherche de voiture</h1>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && $afficherModelesDeLaMarque): ?>
        <p><?= htmlspecialchars($message) ?></p>
        <ul>
            <?php foreach ($results as $row): ?>
                <li><?= htmlspecialchars($row['nom_modele']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <table border="1">
            <tr>
                <th>Nom du modèle</th>
                <th>Marque</th>
            </tr>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom_modele']) ?></td>
                    <td><?= htmlspecialchars($row['marque']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
