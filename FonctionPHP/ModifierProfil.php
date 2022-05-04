<?php
require_once "../Setup/database.php";
session_start();
require 'phpFunction.php';
    if(isset($_POST['pseudo']) && isset($_POST['banniere']) && isset($_SESSION['idUtilisateur'])){
        $stmt=$bdd->prepare("SELECT idUtilisateur FROM utilisateurs WHERE pseudo=? AND pseudo<>(SELECT pseudo FROM utilisateurs WHERE idUtilisateur=?)");
        $stmt->execute([$_POST['pseudo'],$_SESSION['idUtilisateur']]);
        $pseudo=$stmt->fetch();
        $verif=false;
        if($_POST['photo']>4 || $_POST['photo']<1){
            $_SESSION['notif']="Photo de profil introuvable.";
            $verif=true;
        }
        if($_POST['banniere']>3 || $_POST['banniere']<1){
            $_SESSION['notif']="Banniere introuvable.";
            $verif=true;
        }
        if($pseudo!=false){
            $_SESSION['notif']="Pseudo déjà utiliser.";
            $verif=true;
        }
        if($verif==false){
            if(isset($_POST['mdp']) && strlen($_POST['mdp'])>=6 && strlen($_POST['mdp'])<=50){
                $stmt=$bdd->prepare("UPDATE utilisateurs SET password=? WHERE idUtilisateur=?");
                $stmt->execute([sha1(substr($_POST['mdp'],0,50)),$_SESSION['idUtilisateur']]);
            }
            $stmt=$bdd->prepare("UPDATE utilisateurs SET pseudo=?,photo=?,banniere=? WHERE idUtilisateur=?");
            $stmt->execute([substr($_POST['pseudo'],0,15),$_POST['photo'],$_POST['banniere'],$_SESSION['idUtilisateur']]);
            $_SESSION['notif']= "Profil modifier avec succès.";
        }
    }
    header("Location:".$_SERVER['HTTP_REFERER']);
?>