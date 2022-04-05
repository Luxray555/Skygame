<?php
require_once "Setup/database.php";
session_start();
require "FonctionPHP/phpFunction.php";

if(isset($_POST['email']) && isset($_POST['mdp'])){
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
            $header=9;
            include "header.php";
            echo '<main class="main close">
            <form class="verification-box" action="" method="POST">
                <h1>Vérifier votre adresse mail</h1>
                <h2>( '.$_POST['email'].' )</h2>
                <input type="hidden" name="email" value="'.$_POST['email'].'">
                <input type="hidden" name="mdp" value="'.$_POST['mdp'].'">
                <input type="text" name="code" placeholder="Code" autocomplete="off" size="4" pattern="[0-9]{4}"><br>
                <input type="submit" value="Vérifier">
            </form>';
            include "footer.php";
            echo '</main>
            </body>
            </html>';
        }
    }else{
        header('Location:Connexion.php');
    }
}else{
    header('Location:Connexion.php');
}

?>