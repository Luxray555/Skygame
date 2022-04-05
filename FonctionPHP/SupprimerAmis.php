<?php
require_once "../Setup/database.php";
session_start();
require 'phpFunction.php';
    if(isset($_POST['idAmi']) && isset($_SESSION['idUtilisateur'])){
        $stmt=$bdd->prepare("DELETE FROM amis WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur2=? AND idUtilisateur1=?)");
        $stmt->execute([$_SESSION['idUtilisateur'],$_POST['idAmi'],$_SESSION['idUtilisateur'],$_POST['idAmi']]);
        $ami = $bdd->prepare("SELECT pseudo FROM utilisateurs WHERE idUtilisateur=?");
        $ami->execute([$_POST['idAmi']]);
        $ami = $ami->fetch();
        $_SESSION['notif']="Vous n'étes plus amis avec ".$ami['pseudo'].".";
        header("Location:../Profil.php?idUtilisateur=".$_POST['idAmi']);
    }else{
        header("Location:".  $_SERVER['HTTP_REFERER']);
    }
?>