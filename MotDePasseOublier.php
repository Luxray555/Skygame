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
	if($user){
		if($user['verifMail']==0){
		  session_destroy();
		}
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
  <?php
  include "header.php";
  ?>
    <main class="main close">
		<?php
		if(isset($_SESSION['notif'])){
			echo '<div id="error" style="background-color:';
			if($_SESSION['notif']=="Erreur"){
				echo 'red';
			}else{
				echo 'green';
			}
			echo '"><p class="error">'.$_SESSION['notif'].'</p></div>';
		}
		if(!isset($user['idUtilisateur'])){
			echo '<div class="wrapper">
				</div>
		<div class="formulaire">
		<form id="form-mdp" method="POST" action="FonctionPHP/EnvoieMdpOublier.php">
     				<h1>Mot de passe oublier</h1>
                        <p class="r-email" >Renseignez votre email</p>
					<label>
						<input id="email" class="input" type="email" name="email" placeholder="email@email.com" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" autocomplete="on" required/>
					</label><br>
					<div align="center">
						<input id="bouton-connexion" type="submit" name="envoi" value="Envoyer un mail" autocomplete="off">
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
		<?php
		if(isset($_SESSION['notif'])){
      		notifJs($_SESSION['notif']);
      		unset($_SESSION['notif']);
    	}
		?>

  		feather.replace();
		const eye = document.querySelector(".feather-eye");
		const eyeoff = document.querySelector(".feather-eye-off");
		const passwordField = document.querySelector("input[type=password]");

		eyeCheck(eye,eyeoff,passwordField);
	</script>
	<script src="Public/js/Parallax.js"></script>
	<script src="Public/js/Connexion.js"></script>
</html>