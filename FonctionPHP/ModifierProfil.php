<?php
require_once "../Setup/database.php";
session_start();
require 'phpFunction.php';
    if(isset($_POST['pseudo']) && isset($_POST['photo']) && isset($_POST['banniere']) && isset($_SESSION['idUtilisateur'])){
        $stmt=$bdd->prepare("SELECT idUtilisateur FROM utilisateurs WHERE pseudo=? AND pseudo<>(SELECT pseudo FROM utilisateurs WHERE idUtilisateur=?)");
        $stmt->execute([$_POST['pseudo'],$_SESSION['idUtilisateur']]);
        $pseudo=$stmt->fetch();
        if(($_POST['photo']>4 || $_POST['photo']<1) || ($_POST['banniere']>3 || $_POST['banniere']<1) || $pseudo != false){
            if($pseudo!=false){
                $_SESSION['notif']="Pseudo déjà utiliser.";
            }
            if($_POST['photo']>4 || $_POST['photo']<1){
                $_SESSION['notif']="Photo de profil introuvable.";
            }
            if($_POST['banniere']>3 || $_POST['banniere']<1){
                $_SESSION['notif']="Banniere introuvable.";
            }
            header("Location:../Profil.php?idUtilisateur=".$_SESSION['idUtilisateur']);
        }else{
            if(isset($_POST['modifMdp'])){
                $stmt=$bdd->prepare("UPDATE utilisateurs SET password=? WHERE idUtilisateur=?");
                $stmt->execute([sha1(substr($_POST['mdp'],0,50)),$_SESSION['idUtilisateur']]);
            }
            $stmt=$bdd->prepare("UPDATE utilisateurs SET pseudo=?,photo=?,banniere=? WHERE idUtilisateur=?");
            $stmt->execute([substr($_POST['pseudo'],0,15),$_POST['photo'],$_POST['banniere'],$_SESSION['idUtilisateur']]);
            $_SESSION['notif']= "Profil modifier avec succès.";
            header("Location:../Profil.php?idUtilisateur=".$_SESSION['idUtilisateur']);
        }
    }else{
        header("Location:".  $_SERVER['HTTP_REFERER']);
    }
?>