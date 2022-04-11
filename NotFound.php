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
<!doctype html>
<html lang="fr">
  <?php
  include "header.php";
  ?>
<main class="main close">
  <div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>404</h1>
				<h2>Page Introuvable</h2>
			</div>
			<a href="Accueil.php">Accueil</a>
		</div>
	</div>
<?php
    include "footer.php";
?>
</main>