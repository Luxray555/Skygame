<?php
require_once "Setup/database.php";
session_start();
require "FonctionPHP/phpFunction.php";

if((isset($_POST['email']) && isset($_POST['mdp'])) || (isset($_SESSION['email']) && isset($_SESSION['mdp']))){
    if(isset($_POST['email']) && isset($_POST['mdp'])){
        $_SESSION['email']=$_POST['email'];
        $_SESSION['mdp']=$_POST['mdp'];
    }
    if(isset($_SESSION['email']) && isset($_SESSION['mdp'])){
        $_POST['email']=$_SESSION['email'];
        $_POST['mdp']=$_SESSION['mdp'];
    }
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
        if(isset($_POST['code']) && substr($_POST['code'],0,4)==$user['codeVerifMail']){
            $stmt = $bdd->prepare('UPDATE utilisateurs SET verifMail=? WHERE idUtilisateur=?');
            $stmt->execute([1,$user['idUtilisateur']]);
            $_SESSION['idUtilisateur']=$user['idUtilisateur'];
	        unset($_SESSION['chargement']);
	        $_SESSION['chargement'] = "Bienvenue ".$user['pseudo'];
	        $_SESSION['timestamp'] = time();
            unset($_SESSION['email']);
            unset($_SESSION['mdp']);
	        header('Location: Chargement.php');
        }else {
            include "header.php";
            echo '<main class="main close">';
            if(isset($_SESSION['notif'])){
                echo '<div id="error" style="background-color:green"><p class="error">'.$_SESSION['notif'].'</p></div>';
              }
            echo '<div class="center">
            <div class="verification-box">
            <form action="" method="POST">
                <h1>Vérifier votre adresse mail</h1>
                <h2>( '.$_POST['email'].' )</h2>
                <input type="hidden" name="email" value="'.$_POST['email'].'">
                <input type="hidden" name="mdp" value="'.$_POST['mdp'].'">
                <input type="text" name="code" placeholder="Code" autocomplete="off" size="4" pattern="[0-9]{4}"><br>
                <input id="verifier" type="submit" value="Vérifier"><br>
                <a href="FonctionPHP/RenvoieMailVerif.php">Renvoyer un mail</a>
            </form>
            </div>
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
        if(isset($_SESSION['email']) && isset($_SESSION['mdp'])){
            unset($_SESSION['email']);
            unset($_SESSION['mdp']);
        }
        header('Location:Connexion.php');
    }
}else{
    header('Location:Connexion.php');
}

?>