<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous - CarChoix</title>
    <link rel="stylesheet" href="style.css">
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
