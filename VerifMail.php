<?php
require_once "Setup/database.php";
session_start();
require "FonctionPHP/phpFunction.php";
if(isset($_SESSION['email']) && isset($_SESSION['mdp'])){
    $_POST['email'] = $_SESSION['email'];
    $_POST['mdp'] = $_SESSION['mdp'];
    unset($_SESSION['email']);
    unset($_SESSION['mdp']);
}
if(isset($_POST['email']) && isset($_POST['mdp']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	$stmt = $bdd->prepare("SELECT civilite,idUtilisateur,email,pseudo,password,skyCoin,verifMail,codeVerifMail FROM utilisateurs WHERE email=?");
    $stmt->execute([$_POST['email']]);
    $user = $stmt->fetch();
	if($user && sha1($_POST['mdp']) == $user['password'] && $user['verifMail']==1){
	    $_SESSION['idUtilisateur']=$user['idUtilisateur'];
	    unset($_SESSION['chargement']);
	    $_SESSION['chargement'] = "Bienvenue ".$user['pseudo'];
	    $_SESSION['timestamp'] = time();
	    header('Location: Chargement.php');
    }elseif($user && sha1($_POST['mdp']) == $user['password'] && $user['verifMail']==0){
        if(isset($_POST['code']) && $_POST['code']==$user['codeVerifMail']){
            $stmt = $bdd->prepare('UPDATE utilisateurs SET verifMail=? WHERE idUtilisateur=?');
            $stmt->execute([1,$user['idUtilisateur']]);
            $_SESSION['idUtilisateur']=$user['idUtilisateur'];
	        unset($_SESSION['chargement']);
	        $_SESSION['chargement'] = "Bienvenue ".$user['pseudo'];
	        $_SESSION['timestamp'] = time();
	        header('Location: Chargement.php');
        }else {
            include "header.php";
            echo '<!DOCTYPE html>
            <html lang="fr">
            <main class="main close">';
            if(isset($_SESSION['notif'])){
                echo '<div id="error" style="background-color:green"><p class="error">'.$_SESSION['notif'].'</p></div>';
            }
            echo '<div class="formulaire">
            <form class="verification-box" action="" method="POST">
                <h1>Vérifier votre adresse mail</h1>
                <h2>( '.$_POST['email'].' )</h2>
                <input type="hidden" name="email" value="'.$_POST['email'].'">
                <input type="hidden" name="mdp" value="'.$_POST['mdp'].'">
                <input type="text" name="code" placeholder="Code" autocomplete="off" minlength="3" maxlength="4" size="4" pattern="[0-9]{4}"><br><br>
                <input id="btnVerif" type="submit" value="Vérifier">
            </form>
            <form action="FonctionPHP/RenvoieMailVerif.php" method="POST">
                <input type="hidden" name="email" value="'.$_POST['email'].'">
                <input type="hidden" name="mdp" value="'.$_POST['mdp'].'">
                <input id="btnRenvoie" type="submit" value="Renvoyer un mail">
            </form>
            </div>';
            include "footer.php";
            echo '</main>
            </body>
            <script>';
            if(isset($_SESSION['notif'])){
                notifJs($_SESSION['notif']);
                unset($_SESSION['notif']);
            }
            echo '</script>
            </html>';
        }
    }else{
        header('Location:Connexion.php');
    }
}else{
    header('Location:Connexion.php');
}

?>