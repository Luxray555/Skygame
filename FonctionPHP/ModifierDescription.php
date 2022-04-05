<?php
require_once "../Setup/database.php";
session_start();
require 'phpFunction.php';
    if(isset($_POST['description']) && isset($_SESSION['idUtilisateur'])){
        $stmt=$bdd->prepare("UPDATE utilisateurs SET description=? WHERE idUtilisateur=?");
        $stmt->execute([substr($_POST['description'],0,4950),$_SESSION['idUtilisateur']]);
        $_SESSION['notif']= "Description modifier avec succès.";
        header("Location:../Profil.php?idUtilisateur=".$_SESSION['idUtilisateur']);
    }else{
        header("Location:".  $_SERVER['HTTP_REFERER']);
    }
?>