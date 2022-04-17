<?php
require_once "Setup/database.php";
session_start();

require 'FonctionPHP/phpFunction.php';
require "RessourceAPI/PHPMailer/PHPMailerAutoload.php";

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
			$_SESSION['text']='deconnexion';
                echo '<div class="wrapper">
					</div>
				<div class="formulaire">
				<form id="form-inscription" method="POST" action="FonctionPHP/AddInscription.php">
					<h1>S'."'".'inscrire</h1>
					<div class="inputs">
						<label class="civilite">
							Civilité :
							<input type="radio" name="civilite" title="M." autocomplete="off" value="0" required minlength="4" maxlength="25" checked>M.
							<input type="radio" name="civilite" title="Mme." autocomplete="off" value="1" required minlength="4" maxlength="25">Mme.
						</label><br>
						<label>
							<input type="text" value="" name="nom" placeholder="Nom" pattern="[a-zA-ZÀ-ÿ]{2,25}" title="nom entre 2 et 25 caractéres, sans caractere spéciaux , chiffres et espaces" autocomplete="off" required minlength="2" maxlength="25"/>
						</label><br>
						<label>
							<input type="text" value="" name="prenom" placeholder="Prenom" pattern="[a-zA-ZÀ-ÿ]{2,25}" title="prenom entre 2 et 25 caractéres, sans caractere spéciaux , chiffres et espaces" autocomplete="off" required minlength="2" maxlength="25">
						</label><br>
						<label>
							<input class="input" type="text" value="" name="pseudo" id="pseudo" placeholder="Pseudo" pattern="[a-zA-Z0-9_-]{3,15}" title="pseudo entre 4 et 15 caractéres, sans caractere spéciaux (sauf _ et - ), sans lettres accentués et sans espaces" autocomplete="off" required minlength="4" maxlength="15"/>
						</label><br>
						<label>
							<input id="email" type="email" name="email" placeholder="Email" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" autocomplete="off" required/>
						</label><br>
						<label>
							<input id="mdp" type="password" name="mdp" placeholder="Mot de passe" autocomplete="off" required minlength="6" maxlength="50">
							<div class="password-icon">
    							<i class="eye1" data-feather="eye"></i>
    							<i class="eye-off1" data-feather="eye-off"></i>
  							</div>
						</label><br>
						<label>
							<input id="mdpv" type="password" name="mdpv" placeholder="Verification du mot de passe" autocomplete="off" required minlength="6" maxlength="50">
							<div class="password-icon">
    							<i class="eye2" data-feather="eye"></i>
    							<i class="eye-off2" data-feather="eye-off"></i>
  							</div>
						</label>
					</div>
					<p class="connexion"><a href="Connexion.php">J'."'".'ai déjà un <span>compte</span>. Je me <span>connecte</span> maintenant.</a></p>
					<div align="center">
						<input id="bouton-inscription" type="submit" name="envoi" value="Inscription" autocomplete="off">
					</div>
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
		const eye1 = document.querySelector(".eye1");
		const eyeoff1 = document.querySelector(".eye-off1");
		const passwordField1 = document.querySelector("#mdp");

		eyeCheck(eye1,eyeoff1,passwordField1);

		feather.replace();
		const eye2 = document.querySelector(".eye2");
		const eyeoff2 = document.querySelector(".eye-off2");
		const passwordField2 = document.querySelector("#mdpv");

		eyeCheck(eye2,eyeoff2,passwordField2);
	</script>
	<script src="Public/js/Parallax.js"></script>
	<script src="Public/js/Inscription.js"></script>
</html>