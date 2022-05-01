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
                                <span class="bonus">+'.$key['bonusSkycoin'].' Bonus</span>
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
											<i>Réssayer dans <span></span></i>';
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
		if(isset($user['idUtilisateur']) && $user['lastRecompence'] != null || strtotime(date('Y-m-d',strtotime($user['lastRecompence'])))>=strtotime(date('Y-m-d'))){
			echo '
			function timeString(t){
				if(t.toString().length<=1){
					t="0"+t;
				}
				return t;
			}
			let compteur_recompence = document.querySelector("form i span");
			let now_time= new Date();
			now_time = now_time.getHours()*3600+now_time.getMinutes()*60+now_time.getSeconds()
			let rebour = 86400-now_time;
			if(rebour>=0){
				var hour = Math.floor(rebour/3600),
					minute = Math.floor((rebour%3600)/60),
					second = Math.floor((rebour%3600)%60);
					compteur_recompence.innerHTML = timeString(hour)+"h"+timeString(minute)+"m"+timeString(second)+"s" ;
				rebour--;
			}
			let intervalId1 = setInterval(function(){
				if(rebour>=0){
					var hour = Math.floor(rebour/3600),
						minute = Math.floor((rebour%3600)/60),
						second = Math.floor((rebour%3600)%60);
						compteur_recompence.innerHTML = timeString(hour)+"h"+timeString(minute)+"m"+timeString(second)+"s" ;
					rebour--;
				}else{
					document.querySelector(".button-buy input[type='."'".'submit'."'".']").value = "Obtenir";
					document.querySelector(".button-buy input[type='."'".'submit'."'".']").disabled = false;
					document.querySelector("form i").innerHTML="";
					clearInterval(intervalId1);
				}
			},1000)
			';
		}
    ?>
	</script>
	<script src="Public/js/Parallax.js"></script>
</html>