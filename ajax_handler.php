<?php
require 'db.php'; // Ensure you include your database connection file

// Check if the request is from AJAX and the method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize an SQL query and parameters array
    $sql = "SELECT * FROM vehicules";
    $where = [];
    $params = [];

    // Check for each filter and prepare the SQL query
    foreach (['marque', 'type_de_boite_de_vitesses', 'type_de_carrosserie', 'type_de_moteur'] as $field) {
        if (!empty($_POST[$field])) {
            $where[] = "$field = :$field";
            $params[$field] = $_POST[$field];
        }
    }

    // Construct the SQL query with filters
    if (!empty($where)) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Start the output buffer to capture HTML content
    ob_start();
    
    // Generate the HTML content for vehicle listings
    echo "<div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4'>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='car-card overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300'>";
        echo "<a href='caracteristique.php?id=" . $row['id'] . "'>";
        echo "<img src='" . $row['image_url'] . "' alt='" . $row['marque'] . " " . $row['nom_modele'] . "' class='car-image' data-car-id='" . $row['id'] . "' data-prix='" . $row['prix'] . "' data-type-de-moteur='" . $row['type_de_moteur'] . "' data-type-de-boite-de-vitesses='" . $row['type_de_boite_de_vitesses'] . "'>";
        echo "<div class='p-4'>";
        echo "<p class='text-lg text-black font-bold'>" . $row['marque'] . " " . $row['nom_modele'] . "</p>";
        echo "</div>";
        echo "</a>";
        echo "</div>";
    }
    echo "</div>"; // Close the grid container

    // Capture the output and clear the buffer
    $html_output = ob_get_clean();

    // Return the HTML content as the response
    echo $html_output;
} else {
    // Handle non-AJAX or wrong method requests
    header('HTTP/1.1 400 Bad Request');
    echo "Invalid request.";
}
