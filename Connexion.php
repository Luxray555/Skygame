<?php
require_once "Setup/database.php";
session_start();

require 'FonctionPHP/phpFunction.php';

if(isset($_SESSION['idUtilisateur'])){
    if ($_SESSION['timestamp']!=null) {
      $_SESSION['timestamp'] = expiredSession($_SESSION['timestamp']);
    }else{
      $_SESSION['chargement'] = 'deconnexion par innactivité';
      header('Location: Chargement.php');
    }
    $user = informationUser($_SESSION['idUtilisateur'],$bdd);
}
?>
<!DOCTYPE html>
<html lang="fr">
  <?php
  include "header.php";
  ?>
    <main class="main close">
		<?php
		if(!isset($user['idUtilisateur'])){
			echo '<div class="wrapper">
				</div>
		<div class="formulaire">
		<form id="form-connexion" method="POST" action="VerifMail">
     				<h1>Se connecter</h1>
						<label>
							<input id="email" class="input" type="email" name="email" placeholder="email@email.com" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" autocomplete="on" required/>
						</label><br>
						<label>
							<input id="mdp" type="password" name="mdp" placeholder="Mot de passe" autocomplete="off" required minlength="6" maxlength="50">
							<div class="password-icon">
    							<i data-feather="eye"></i>
    							<i data-feather="eye-off"></i>
  							</div>
						</label>
					<a href="Inscription.php"><p class="inscription">Je n'."'".'ai pas de <span>compte</span>. Je m'."'".'en <span>crée</span> un.</p></a>
					<div align="center">
						<input id="bouton-connexion" type="submit" name="envoi" value="Connexion" autocomplete="off">
					</div>
		  		</form>
		</form>
		</div>
				<div id="error"></div>'; 
		}else{
			echo "<div class='no-access-page'>
					<h1 >Vous n'avez pas accès à cette page</h1>
					<button><a href='index.php'>Accueil</a></button>
				</div>";
		}
		?>
    <?php
    	include "footer.php";
    ?>
  </main>
	</body>
	<script src="https://unpkg.com/feather-icons"></script>
	<script src="Public/js/eyeCheck.js"></script>
	<script>
  		feather.replace();
		const eye = document.querySelector(".feather-eye");
		const eyeoff = document.querySelector(".feather-eye-off");
		const passwordField = document.querySelector("input[type=password]");

		eyeCheck(eye,eyeoff,passwordField);
	</script>
	<script src="Public/js/Parallax.js"></script>
	<script src="Public/js/Connexion.js"></script>
</html>