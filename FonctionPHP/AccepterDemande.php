<?php
require_once "../Setup/database.php";
session_start();
require 'phpFunction.php';
    if(isset($_POST['idAmi']) && isset($_SESSION['idUtilisateur'])){
        $stmt=$bdd->prepare("UPDATE amis SET demande=1 WHERE idUtilisateur1=? AND idUtilisateur2=?");
        $stmt->execute([$_POST['idAmi'],$_SESSION['idUtilisateur']]);
        $ami = $bdd->prepare("SELECT pseudo FROM utilisateurs WHERE idUtilisateur=?");
        $ami->execute([$_POST['idAmi']]);
        $ami = $ami->fetch();
        $_SESSION['notif']="Vous êtes maintenant amis avec ".$ami['pseudo'].".";
        header("Location:".  $_SERVER['HTTP_REFERER']);
    }else{
        header("Location:".  $_SERVER['HTTP_REFERER']);
    }
?>