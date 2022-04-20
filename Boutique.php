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
        if(isset($user['idUtilisateur'])){
			if(isset($_SESSION['notif'])){
				echo '<div id="error" style="background-color:';
				if(substr($_SESSION['notif'],0,28)=="Achat effectué avec succès"){
				  echo 'green';
				}else{
					echo 'red';
				}
				echo '"><p class="error">'.$_SESSION['notif'].'</p></div>';
			  }
			$stmt = $bdd->prepare('SELECT * FROM skycoins');
			$stmt->execute();
            $skycoin = $stmt->fetchAll();
            echo '<div class="wrapper">
				</div>
                <div class="boutique-panel">
                    <h1>Skycoin</h1>
                    <div class="block-boutique">';
                    foreach($skycoin as $key){
                        echo '<form class="coin-box" method="POST" action="FonctionPHP/AchatSkycoin.php">
                                <h2 class="euro">'.$key['prixSkycoin'].'</h2>
                                <img src="Public/Images/icon/skyCoin.png" alt="Image Skycoin">
                                <h2 class="skyCoin">'.$key['convertSkycoin'].'</h2>
                                <span>+'.$key['bonusSkycoin'].' Bonus</span>
                                <div class="button-buy">
                                    <input type="hidden" name="idSkycoin" value="'.$key['idSkycoin'].'">
                                    <input type="submit" value="';
                                    if($key['idSkycoin']==1){
										date_default_timezone_set("Europe/Paris");
                                        if($user['lastRecompence'] == null || strtotime(date('Y-m-d',strtotime($user['lastRecompence'])))<strtotime(date('Y-m-d'))){
											echo'Obtenir"/>
											</div>';
										}else{
											echo'Expirer" disabled/>
											</div>
											<i>Réssayer demain.</i>';
										}
                                    }else{
                                        echo 'Acheter" />
										</div>';
                                    }
                                    
                            echo'</form>';
                    }
                    echo '</div>
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
	<script>
	<?php
    	if(isset($_SESSION['notif'])){
    		notifJs($_SESSION['notif']);
        	unset($_SESSION['notif']);
      	}
    ?>
	</script>
	<script src="Public/js/Parallax.js"></script>
</html>