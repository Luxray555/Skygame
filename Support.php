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
		if(isset($_SESSION['notif'])){
			echo '<div id="error" style="background-color:';
			if($_SESSION['notif']=="Erreur"){
				echo "red";
			}else{
				echo "green";
			}
			echo '"><p class="error">'.$_SESSION['notif'].'</p></div>';
		}
		?>
		<h1>Support</h1>
		<div class="mail">
			<h2>Nous contactez par mail</h2>
			<fieldset>
			<form action="FonctionPHP/EnvoieMailSupport.php" method="POST">
				<label>
					Adresse email :
					<input id="email" class="input" type="email" name="email" placeholder="email@email.com" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" autocomplete="on" required/>
				</label><br>
				<label>
					Sujet :
					<select name="sujet">
						<option value="Jeu">Jeu</option>
						<option value="Skycoin">Skycoin</option>
						<option value="Connexion">Connexion</option>
						<option value="Inscription">Inscription</option>
						<option value="Autres">Autres</option>
					</select>
				</label><br>
				<label>Description :<br><textarea name="description" resize="none" required></textarea></label><br>
				<div class="button">
					<input type="submit" value="Envoyer">
				</div>
			</form>
			</fieldset>
		</div>
		<div class="tel">
			<h2>Nous contactez par téléphone</h2>
			<fieldset>
				<h3><span>Numéro Tél :</span> <span class="num">02 22 22 22 22</span></h3>
			</fieldset>
		</div>
	<?php
	include "footer.php";
	?>
    </main>
	</body>
	<script>
		<?php
    		if(isset($_SESSION['notif'])){
      			notifJs($_SESSION['notif']);
      			unset($_SESSION['notif']);
    		}
    	?>
	</script>
</html>