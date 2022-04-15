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
	<script>
  		feather.replace();
		const eye = document.querySelector(".feather-eye");
		const eyeoff = document.querySelector(".feather-eye-off");
		const passwordField = document.querySelector("input[type=password]");
		eye.addEventListener("click", () => {
  			eye.style.display = "none";
  			eyeoff.style.display = "block";
  			passwordField.type = "password";
		});

		eyeoff.addEventListener("click", () => {
  			eyeoff.style.display = "none";
  			eye.style.display = "block";
  			passwordField.type = "text";
		});
	</script>
	<script>
		
	document.querySelector(".wrapper").style.backgroundImage="url('Public/Images/background/inscription-background"+Math.ceil(Math.random() * 3)+".jpg')";
	
	(function() {

    	document.addEventListener("mousemove", parallax);
    	const elem = document.querySelector(".wrapper");

    	function parallax(e) {
        	let _w = window.innerWidth/2;
        	let _h = window.innerHeight/2;
        	let _mouseX = e.clientX;
        	let _mouseY = e.clientY;
        	let _depth1 = `${50 - (_mouseX - _w) * 0.005}% ${50 - (_mouseY - _h) * 0.04}%`;
        	let _depth2 = `${50 - (_mouseX - _w) * 0.005}% ${50 - (_mouseY - _h) * 0.04}%`;
        	let _depth3 = `${50 - (_mouseX - _w) * 0.005}% ${50 - (_mouseY - _h) * 0.04}%`;
        	let x = `${_depth3}, ${_depth2}, ${_depth1}`;
        	elem.style.backgroundPosition = x;
    	}
	})();
	</script>
	<script>
		const form = document.getElementById('form-connexion'),
			bouton = document.getElementById('bouton-connexion');

		let	interalErrorId = null,
			timeoutErrorId = null;
		form.addEventListener ("submit", function(e) {
			e.preventDefault();
				var httpr = new XMLHttpRequest(),
				email = document.getElementById("email").value,
				mdp = document.getElementById("mdp").value;
				httpr.open("POST", "FonctionPHP/IdentificationVerification.php");
				httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				httpr.send("email="+email+"&mdp="+mdp);
				httpr.onload = function(){
					document.getElementById("error").innerHTML = httpr.responseText;
					if(httpr.responseText==""){
						form.submit();
					}else{
						bouton.disabled=true;
						document.getElementById("error").style.opacity = 1;
						document.getElementById("error").style.transform = "scale(1.2)";
						now_time = 5;
						document.getElementById("error").innerHTML = httpr.responseText+'<p class="time_error">Réssayer dans '+now_time+" seconde(s)</p>";
						interalErrorId = setInterval(function(){
							now_time--;
							document.getElementById("error").innerHTML = httpr.responseText+'<p class="time_error">Réssayer dans '+now_time+" seconde(s)</p>";
						},1000);
						timeoutErrorId = setTimeout(() => {
							bouton.disabled=false;
							clearInterval(interalErrorId);
							interalErrorId = null;
							clearTimeout(timeoutErrorId);
							timeoutErrorId = null;
							document.getElementById("error").style.opacity = 0;
							document.getElementById("error").style.transform = "scale(0.1) translateY(-50%)";
							document.getElementById("error").removeChild(document.querySelector("#error .error"));
						},5000);
					}
				}
		})
	</script>
</html>