<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    	<link rel="icon" href="Public/Images/icon/logo.ico" type="image/x-icon" />
    	<link rel="apple-touch-icon" href="Public/Images/icon/logo.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="Public/css/Chargement.css">
		<title>Skygame - Chargement</title>
	</head>
	<body>
		<div class="scene">
			<div class="rocket">
				<img width="400px"src="Public/Images/icon/rocket.png" alt="Image de rocket">
			</div>
			<div class="text">
			<?php
			session_start();
			if(isset($_SESSION['chargement'])){
				echo $_SESSION['chargement'];
			}else{
				echo 'ERREUR';
			}
			?></div>
		</div>
	</body>
	<script>
		function stars(){
			let count = 50;
			let scene=document.querySelector('.scene');
			let i=0;
			while(i<count){
				let star=document.createElement('i');
				let x=Math.floor(Math.random()*window.innerWidth);
				let duration = Math.random()*1;
				let h = Math.random()*100;
				star.style.left = x + 'px';
				star.style.width = '1px';
				star.style.height = h + 'px';
				star.style.animationDuration = duration + 's';

				scene.appendChild(star);
				i++;
			}
		}
		stars();
		setTimeout(function(){window.location.href = "<?php
		if(isset($_SESSION['chargement'])){
			if(substr($_SESSION['chargement'],0,11)=='deconnexion'){
				echo "Connexion.php";
				session_destroy();
			}elseif(substr($_SESSION['chargement'],0,9)=="Bienvenue"){
				echo "index.php";
				$_SESSION['notif']="Connexion avec succès.";
				unset($_SESSION['chargement']);
			}elseif($_SESSION['chargement']== "Création du compte"){
				echo "index.php";
				$_SESSION['notif']="Inscription effectuée. Vous allez recevoir un code de confirmation par mail.";
				unset($_SESSION['chargement']);
			}
		}else{
			echo "index.php";
		}
		?>";},1500);
		
	</script>
</html>