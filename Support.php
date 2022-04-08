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
	include "footer.php";
	?>
    </main>
	</body>
	<script>
		function Afficher(input,eye){
			if (input.type == "password"){
				input.type = "text";
				eye.src = "Public/Images/icon/eye-open.png";
			} else{
				input.type = "password";
				eye.src = "Public/Images/icon/eye-close.png"
			}
		}
		document.getElementById("c1").onclick = function(){Afficher(document.getElementById('mdp'),document.getElementById('eye1'))};
		document.getElementById("c2").onclick = function(){Afficher(document.getElementById('mdpv'),document.getElementById('eye2'))};
		form = document.getElementById("form-inscription");

		form.addEventListener ("submit", function(e) {
			e.preventDefault();
			document.getElementById("error").style.opacity = 0;
			document.getElementById("error").style.transform = "scale(1)";
  			var password = document.getElementById("mdp"),
  				repeat_password = document.getElementById("mdpv"),
				httpr = new XMLHttpRequest(),
				pseudo = document.getElementById("pseudo").value,
				email = document.getElementById("email").value;
				console.log(pseudo+" "+email);
  			if (password.value != repeat_password.value) {
    			repeat_password.setCustomValidity("Mot de passe non identique");
    			return false;
  			}
			httpr.open("POST", "FonctionPHP/IdentificationVerification.php");
			httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			httpr.send("pseudo="+pseudo+"&email="+email);
			httpr.onload = function(){
				console.log(this);
				document.getElementById("error").innerHTML = httpr.responseText;
				if(httpr.responseText==""){
					form.submit();
				}else{
					setTimeout(() => {
						document.getElementById("error").style.opacity = 1;
						document.getElementById("error").style.transform = "scale(1.2)";
					}, 100);
				}
			}
		})
		document.getElementById("mdpv").onchange = function(e) {
  			e.target.setCustomValidity('')
		}

	</script>
</html>