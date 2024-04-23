<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue de Voitures</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/catalogue.css">
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>

    <header class="banner">
        <h1 class="text-3xl text-center text-black my-8">Explorez notre Collection de Voitures</h1>
        <form action="" method="get" class="text-center mb-8">
            <select name="marque">
                <option value="">Choisissez une marque</option>
                <?php
                require 'db.php';
                $marques = $pdo->query("SELECT DISTINCT marque FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
                foreach ($marques as $marque) {
                    echo "<option value='$marque'>$marque</option>";
                }
                ?>
            </select>
            <select name="type_de_boite_de_vitesses">
                <option value="">Type de boîte de vitesses</option>
                <?php
                $typesBoiteVitesses = $pdo->query("SELECT DISTINCT type_de_boite_de_vitesses FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
                foreach ($typesBoiteVitesses as $type) {
                    echo "<option value='$type'>$type</option>";
                }
                ?>
            </select>
            <select name="type_de_carrosserie">
                <option value="">Type de carrosserie</option>
                <?php
                $typesCarrosserie = $pdo->query("SELECT DISTINCT type_de_carrosserie FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
                foreach ($typesCarrosserie as $carrosserie) {
                    echo "<option value='$carrosserie'>$carrosserie</option>";
                }
                ?>
            </select>
            <select name="type_de_moteur">
                <option value="">Type de moteur</option>
                <?php
                $typesMoteur = $pdo->query("SELECT DISTINCT type_de_moteur FROM vehicules")->fetchAll(PDO::FETCH_COLUMN);
                foreach ($typesMoteur as $moteur) {
                    echo "<option value='$moteur'>$moteur</option>";
                }
                ?>
            </select>
            <button type="submit" class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600">Filtrer</button>
        </form>
    </header>

    <main id="catalogue" class="container mx-auto">
    <?php
    // Prepare the SQL query with placeholders
    $sql = "SELECT * FROM vehicules";
    $where = [];
    $params = [];

    foreach (['marque', 'type_de_boite_de_vitesses', 'type_de_carrosserie', 'type_de_moteur'] as $field) {
        if (!empty($_GET[$field])) {
            $where[] = "$field = :$field";
            $params[$field] = $_GET[$field];
        }
    }

    if (!empty($where)) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    $stmt = $pdo->prepare($sql);

    // Execute the query with bound parameters
    $stmt->execute($params);

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
    ?>
    </main>
    <footer>
        <ul>
            <li><a href="index.php">Accueil</a></li>
        </ul>
        <ul>
             <li><a href="contact.php">Nous contacter</a></li>
         </ul>
    </footer>
    <style>footer {
    background-color: #343a40;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

footer ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

footer ul li {
    display: inline;
    margin-right: 20px;
}

footer ul li:last-child {
    margin-right: 0;
}

footer a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
}

footer a:hover {
    text-decoration: underline;
}</style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(form);
            fetch('ajax_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('catalogue').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        });
    });
    </script>
</body>
</html>