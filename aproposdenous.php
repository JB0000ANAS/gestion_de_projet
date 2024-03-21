/* Réinitialisation des styles par défaut */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    color: #333;
}

header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
}

.logo img {
    width: 120px;
    height: auto;
}

.nav-links {
    list-style-type: none;
    padding: 0;
    margin-top: 20px;
}

.nav-links li {
    display: inline;
    margin-right: 20px;
}

.nav-links li a {
    color: #fff;
    text-decoration: none;
}

.nav-links li a:hover {
    text-decoration: underline;
}

main {
    padding: 50px;
}

.about {
    background-color: #fff;
    padding: 30px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 50px;
}

.about h2 {
    color: #333;
    font-size: 28px;
    margin-bottom: 20px;
}

.about p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 15px;
}

footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
}

footer p {
    margin: 0;
}

