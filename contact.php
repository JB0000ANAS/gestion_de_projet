<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous - CarChoix</title>
    <link rel="stylesheet" href="style.css">
    <style>
       /* Réinitialisation des styles par défaut */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

nav ul {
    list-style-type: none;
    padding: 0;
    display: flex;
    justify-content: center;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
}

main {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 5px;
}

input[type="text"], input[type="password"] {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #444;
}

p {
    text-align: center;
    margin-top: 20px;
}

p a {
    color: #333;
    text-decoration: none;
}

p a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo CarChoix">
        </div>
        <nav>
            <ul>
            <li><a href="index.php">Accueil</a></li>
                <li><a href="login.php">Connexion</a></li>
                <li><a href="register.php">Inscription</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="contact-form">
            <h2>Contactez-nous</h2>
            <form action="contact_process.php" method="post">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                <div class="form-group">
                    <label for="objet">Objet :</label>
                    <input type="text" id="objet" name="objet" required>
                </div>
                <div class="form-group">
                    <label for="demande">Demande :</label>
                    <textarea id="demande" name="demande" rows="4" required></textarea>
                </div>
                <button type="submit" class="button">Envoyer</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 CarChoix</p>
    </footer>
</body>
</html>
