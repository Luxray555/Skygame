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
						<a href="Connexion.php"><p class="inscription">J'."'".'ai déjà un <span>compte</span>. Je me <span>connecte</span> maintenant.</p></a>
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
	<script>
  		feather.replace();
		const eye1 = document.querySelector(".eye1");
		const eyeoff1 = document.querySelector(".eye-off1");
		const passwordField1 = document.querySelector("#mdp");
		eye1.addEventListener("click", () => {
  			eye1.style.display = "none";
  			eyeoff1.style.display = "block";
  			passwordField1.type = "password";
		});

		eyeoff1.addEventListener("click", () => {
  			eyeoff1.style.display = "none";
  			eye1.style.display = "block";
  			passwordField1.type = "text";
		})

		feather.replace();
		const eye2 = document.querySelector(".eye2");
		const eyeoff2 = document.querySelector(".eye-off2");
		const passwordField2 = document.querySelector("#mdpv");
		eye2.addEventListener("click", () => {
  			eye2.style.display = "none";
  			eyeoff2.style.display = "block";
  			passwordField2.type = "password";
		});

		eyeoff2.addEventListener("click", () => {
  			eyeoff2.style.display = "none";
  			eye2.style.display = "block";
  			passwordField2.type = "text";
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
		const form = document.getElementById("form-inscription"),
		 	bouton = document.getElementById("bouton-inscription");

		let	interalErrorId = null,
			timeoutErrorId = null;
		form.addEventListener ("submit", function(e) {
			e.preventDefault();
				var httpr = new XMLHttpRequest(),
				pseudo = document.getElementById("pseudo").value,
				email = document.getElementById("email").value;
				httpr.open("POST", "FonctionPHP/IdentificationVerification.php");
				httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				httpr.send("email="+email+"&pseudo="+pseudo);
				httpr.onload = function(){
					document.getElementById("error").innerHTML = httpr.responseText;
					if(httpr.responseText=="" && validatePassword()){
						form.submit();
					}else if(httpr.responseText!=""){
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

		function validatePassword(){
			var password = document.getElementById("mdp")
  			, confirm_password = document.getElementById("mdpv");
  			if(password.value != confirm_password.value) {
    			confirm_password.setCustomValidity("Mot de passe non identique");
				return false;
  			} else {
    			confirm_password.setCustomValidity('');
				return true;
  			}
		}
		document.getElementById("mdp").onchange = validatePassword;
		document.getElementById("mdpv").onkeyup = validatePassword;

	</script>
</html>