<?php
require_once "../Setup/database.php";
session_start();
require 'phpFunction.php';
    if(isset($_POST['idAmi']) && isset($_SESSION['idUtilisateur']) && isset($_POST['message'])){
        $_SESSION['idAmi']=$_POST['idAmi'];
        try{
            $stmt=$bdd->prepare("INSERT INTO messages(idUtilisateur1,idUtilisateur2,message) VALUES (?,?,?)");
            $stmt->execute([$_SESSION['idUtilisateur'],$_POST['idAmi'],$_POST['message']]);
        }catch(PDOException $e){
            header("Location:".  $_SERVER['HTTP_REFERER']);
        }
        header("Location:".$_SERVER['HTTP_REFERER']);
    }else{
        header("Location:".  $_SERVER['HTTP_REFERER']);
    }
?>