<?php
require_once "../Setup/database.php";
session_start();
require 'phpFunction.php';
    if(isset($_POST['idAmi']) && isset($_SESSION['idUtilisateur'])){
        $stmt=$bdd->prepare("INSERT INTO amis(idUtilisateur1,idUtilisateur2) VALUES (?,?)");
        $stmt->execute([$_SESSION['idUtilisateur'],$_POST['idAmi']]);
        $ami = $bdd->prepare("SELECT pseudo FROM utilisateurs WHERE idUtilisateur=?");
        $ami->execute([$_POST['idAmi']]);
        $ami = $ami->fetch();
        $_SESSION['notif']='Vous venez d'."'".'envoyer une demande d'."'".'ami à '.$ami['pseudo'].".";
        header("Location:../Profil.php?idUtilisateur=".$_POST['idAmi']);
    }else{
        header("Location:".  $_SERVER['HTTP_REFERER']);
    }
?>