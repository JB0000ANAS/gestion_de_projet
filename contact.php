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
            <h2>Contactez-nous</h2>

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
            <form action="contact_process.php" method="post">
                <div class="form">
                    <div class="line1">
                        <div class="form-group">
                            <input type="text" id="nom" name="nom" placeholder="Nom" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="line2">
                        <div class="form-group">
                            <input type="text" id="adresse" name="adresse" placeholder="Adresse mail" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="tel" name="tel" placeholder="Numéro de téléphone" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea id="demande" name="demande" rows="4" placeholder="Message" required></textarea>
                    </div>
                    <button type="submit" class="button">Envoyer</button>
                </div>
            </form>
        </section>
    </main>
     <footer>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Se connecter</a></li>
            <li><a href="#">S'inscrire</a></li>
            <li><a href="#">Qui sommes-nous?</a></li>
        </ul>
        <ul>
            <li><a href="#">Vos recherches</a></li>
            <li><a href="#">Fichier d'informations</a></li>
            <li><a href="#">Comparez</a></li>
            <li><a href="#">Nos engagements</a></li>
        </ul>
    </footer>
</body>
</html>
