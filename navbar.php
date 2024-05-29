<!-- navbar.php -->
<?php
// Check if the session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine the user greeting
$userGreeting = isset($_SESSION['user_nom']) ? "Bonjour " . htmlspecialchars($_SESSION['user_prenom']) . "!" : "Invité";
?>

  <!-- Navbar -->
  <nav class="bg-black text-white h-24 flex items-center justify-between w-full px-4 md:px-12 fixed top-0 z-50">
      <div class="flex items-center">
      <a href="index.php">
    <img src="images/logo.png" alt="Car Choix Logo" class="h-16 mr-4">
</a>

        <ul class="md:flex space-x-4">
            <li><a href="catalogue.php" class="hover:text-red-600">Catalogue</a></li>
             <li><a href="comparaison.php" class="hover:text-red-600">Comparaison</a></li>
             <li><a href="preferences.php" class="hover:text-red-600">Besoin d'aide?</a></li>

            <!-- Add more navigation items here -->
        </ul>
    </div>
          
      </div>
      <div class="flex items-center">
          <div class="relative mr-4">

          <?php if (isset($_SESSION['user_nom'])): ?>
              <a href="logout.php" class="bg-red-600 px-4 py-1 rounded-full hover:bg-red-700">Déconnexion</a>
          <?php else: ?>
              <button id="loginBtn" class="bg-red-600 px-4 py-1 rounded-full hover:bg-red-700 mr-2" onclick="openModal('Login')">Connexion</button>
              <button id="signupBtn" class="bg-red-600 px-4 py-1 rounded-full hover:bg-red-700" onclick="openModal('SignUp')">S'inscrire</button>
          <?php endif; ?>
      </div>
  </nav>
<div id="myModal" class="modal" style="<?php echo ($userGreeting == 'Invité') ? 'display:block;' : 'display:none;'; ?>">
    <div class="modal-content">
      <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
      <div class="tabs">
        <button class="tablink" data-target="Login" onclick="openForm(event, 'Login')">Se connecter</button>
        <button class="tablink" data-target="SignUp" onclick="openForm(event, 'SignUp')">S'inscrire</button>
      </div>

      <div id="Login" class="tabcontent">
        <!-- Login form -->
        <form method="post" action="login_process.php">
          <div class="mb-4">
            <label for="login_email" class="block text-sm font-medium leading-5 text-gray-700">Adresse mail</label>
            <input id="login_email" name="email" type="email" required class="form-input block w-full">
          </div>
          <div class="mb-4">
            <label for="login_password" class="block text-sm font-medium leading-5 text-gray-700">Mot de passe</label>
            <input id="login_password" name="password" type="password" required class="form-input block w-full">
          </div>
          <div class="flex justify-end">
            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-indigo active:bg-blue-700 transition duration-150 ease-in-out">
              Se connecter
            </button>
            
          </div>
        </form>
      </div>

      <div id="SignUp" class="tabcontent">
        <!-- Sign Up form -->
        <form method="post" action="signup_process.php">
          <div class="mb-4">
            <label for="signup_email" class="block text-sm font-medium leading-5 text-gray-700">Adresse mail</label>
            <input id="signup_email" name="email" type="email" required class="form-input block w-full">
          </div>
          <div class="mb-4">
            <label for="signup_first_name" class="block text-sm font-medium leading-5 text-gray-700">Nom</label>
            <input id="signup_first_name" name="first_name" type="text" required class="form-input block w-full">
          </div>
          <div class="mb-4">
            <label for="signup_last_name" class="block text-sm font-medium leading-5 text-gray-700">Prénom</label>
            <input id="signup_last_name" name="last_name" type="text" required class="form-input block w-full">
          </div>
          <div class="mb-4">
            <label for="signup_password" class="block text-sm font-medium leading-5 text-gray-700">Mot de passe</label>
            <input id="signup_password" name="password" type="password" required class="form-input block w-full">
          </div>
          <div class="mb-6">
            <label for="signup_confirm_password" class="block text-sm font-medium leading-5 text-gray-700">Confirmer le mot de passe</label>
            <input id="signup_confirm_password" name="confirm_password" type="password" required class="form-input block w-full">
          </div>
          <div class="flex justify-end">
            <button type="submit" name="register" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-indigo active:bg-green-700 transition duration-150 ease-in-out">
              S'inscrire
            </button>
            
          </div>
        </form>
      </div>
    </div>
  </div>

<script src="script.js" defer></script>