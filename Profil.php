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
if(isset($_GET['idUtilisateur'])){
		$profil = informationProfil($_GET['idUtilisateur'],$bdd);
}else{
	if(isset($_SESSION['idUtilisateur'])){
		header('Location:Profil.php?idUtilisateur='.$_SESSION['idUtilisateur']);
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
  <?php
  $header=6;
  include "header.php";
  ?>
  <main class="main close">
		<?php
		if(isset($profil['idUtilisateur'])){
			if(isset($user['idUtilisateur'])){
				if(isset($_SESSION['notif'])){
					echo '<div id="error" style="background-color:';
					if($_SESSION['notif']=="Pseudo déjà utiliser." || $_SESSION['notif']=="Photo de profil introuvable." || $_SESSION['notif']=="Banniere introuvable."){
						echo 'red';
					}else{
						echo 'green';
					}
					echo'"><p class="error">'.$_SESSION['notif'].'</p></div>';
				}
				if($profil['idUtilisateur']==$user['idUtilisateur']){
					echo'<div id="myModal1" class="modal1">

						<form class="modal-content1" action="FonctionPHP/ModifierDescription.php" method="POST">
				  			<h2>Modification description :</h2>
							<textarea maxlength="4950" id="descriptionModif" name="description"></textarea>
							<br><br>
							<div class="button"><button type="submit" class="modifier">Modifier</button></div>
						</form>
			  
			  		</div>
					  <div id="myModal2" class="modal2">
						<form class="modal-content2" action="FonctionPHP/ModifierProfil.php" method="POST">
						<div class="pseudo"><label>
							Pseudo:
							<input type="text" value="'.$profil['pseudo'].'" name="pseudo" id="pseudo" placeholder="Pseudo" pattern="[a-zA-Z0-9_-]{3,15}" title="pseudo entre 4 et 15 caractéres, sans caractere spéciaux (sauf _ et - ), sans lettres accentués et sans espaces" autocomplete="off" required minlength="4" maxlength="15"/>
						</label></div><br>
						<h2>Photo de profil:</h2>
						<div class="photo">';
						for($i=1;$i<5;$i++){
							echo '<label>
  							<input type="radio" name="photo" value="'.$i.'" ';
							  if($i==$profil['photo']){
								  echo 'checked';
							  }
  							echo '>
							  <img src="Public/Images/profil/pp'.$i.'.jpg">';
						echo '</label>';
						}
						echo '</div>
						<h2>Banniere:</h2>
						<div class="banniere">';
						for($i=1;$i<4;$i++){
							echo '<label>
  							<input type="radio" name="banniere" value="'.$i.'" ';
							  if($i==$profil['banniere']){
								  echo 'checked';
							  }
  							echo '>
							  <img src="Public/Images/background/banner'.$i.'.jpg">';
						echo '</label>';
						}
						echo '</div>
						<div class="button"><button type="submit" class="modifier">Modifier</button></div>
						</form>
			  
			  		</div>';
				}else{
					$stmt=$bdd->prepare("SELECT * FROM amis WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur2=? AND idUtilisateur1=?)");
					$stmt->execute([$user['idUtilisateur'],$profil['idUtilisateur'],$user['idUtilisateur'],$profil['idUtilisateur']]);
					$demande = $stmt->fetch();
				}
			}
				echo '<div class="container" style='."'".'background-image:url("Public/Images/background/banner'.$profil['banniere'].'.jpg");'."'".');">
				<div class="informations-bar">';
				if(isset($user['idUtilisateur'])){
					if($profil['idUtilisateur']==$user['idUtilisateur']){
						echo '<div class="modif-bar">
								<div class="button"><button id="popButton2" class="modifier">Modifier</button></div>
							</div>';
					}else{
						if($demande==false){
							echo '<form class="modif-bar" action="FonctionPHP/AjouterAmis.php" method="POST">
								<input type="hidden" name="idAmi" value="'.$profil['idUtilisateur'].'">
								<div class="button"><button type="submit">Ajouter en ami</button></div>
							</form>';
						}else{
							if($demande['demande']==1){
								echo '<form class="modif-bar" action="FonctionPHP/SupprimerAmis.php" method="POST">
									<input type="hidden" name="idAmi" value="'.$profil['idUtilisateur'].'">
									<div class="button"><button style="border:2px solid red;">Supprimer l'."'".'ami</button></div>
								</form>';
							}else{
								if($demande['idUtilisateur1']==$user['idUtilisateur']){
									echo '<form class="modif-bar" action="FonctionPHP/EnAttenteAmis.php" method="POST">
										<input type="hidden" name="idAmi" value="'.$profil['idUtilisateur'].'">
										<div class="button"><button style="background-color:#2F4F4F;">En attente</button></div>
									</form>';
								}else{
									echo '<form class="modif-bar" action="FonctionPHP/AccepterDemande.php" method="POST">
										<input type="hidden" name="idAmi" value="'.$profil['idUtilisateur'].'">
										<div class="button"><button style="border:2px solid cyan;">Accepter la demande</button></div>
										<div class="button"><button style="border:2px solid red;">Refuser la demande</button></div>
									</form>';
								}
							}
						}
					}
				}
				echo '<div class="profile">
				<img src="Public/Images/profil/';
				imgProfil($profil);
				echo '.jpg" alt="Photo de Profil">
					<p class="name">'.$profil['pseudo'].'</p>
				  </div>
				</div>
			  </div>
			  <div class="description">
			  	<h2>Description :</h2>
				<p id="description">'.nl2br($profil['description']).'</p>';
				if($profil['idUtilisateur']==$user['idUtilisateur']){
					echo '<div class="button"><button id="popButton1" class="modifier">Modifier</button></div>';
				}
			  echo '</div>
			';
		}else{
			if(isset($_GET['id'])){
				echo "<div class='no-access-page'>
								<h1>L'utilisateur séléctionner n'existe pas</h1>
								<button><a href='index.php'>Accueil</a></button>
							</div>";
			}else{
			echo "<div class='no-access-page'>
							<h1>Vous n'avez pas séléctionner d'utilisateur</h1>
							<button class='no-access-button'><a href='index.php'>Accueil</a></button>
					</div>";
			}
		}
		?>
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
	if($profil['idUtilisateur']==$user['idUtilisateur']){
		echo 'var modal1 = document.getElementById("myModal1");
		
		var btn1 = document.getElementById("popButton1");
		
		var	description = document.getElementById("description");

		var descriptionModif = document.getElementById("descriptionModif");
		
		btn1.onclick = function() {
		  modal1.style.display = "block";
		  descriptionModif.innerHTML=description.innerHTML.replaceAll("<br>","");
		}
		
		window.onclick = function(event) {
		  if (event.target == modal1) {
			modal1.style.display = "none";
		  }
		  if (event.target == modal2) {
			modal2.style.display = "none";
		  }
		}

		var modal2 = document.getElementById("myModal2");
		
		var btn2 = document.getElementById("popButton2");
		
		btn2.onclick = function() {
		  	modal2.style.display = "block";
		}';
	}
	?>
	</script>
</html>