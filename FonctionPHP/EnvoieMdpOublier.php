<?php
require_once "../Setup/database.php";
session_start();

require '../FonctionPHP/phpFunction.php';
require "../RessourceAPI/PHPMailer/PHPMailerAutoload.php";

if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    if(mailExist($_POST['email'],$bdd)){
        $password = randomMdp();
        $to = $_POST['email'];
        $from = 'skygamecorporation@gmail.com';
        $name = "Skygame Corporation";
        $subj = "Mot de passe oublier";
        $msg = '<div style="background:linear-gradient(#130b3d,#000000);padding:20px; width:90%;">
                <h1 style="text-align:center;margin-bottom:50px;color:black">Skygame</h1>
                <p style="text-align:center;font-size:18px;color:white;"><span style="font-weight:bold;">Nouveau mot de passe : </span><span style="border:solid white 2px;padding:5px;border-radius:5px;">'.$password.'</span></p>
            </div>';
        $error=smtpmailer($to,$from, $name ,$subj, $msg);
        $stmt = $bdd->prepare("UPDATE utilisateurs SET password=? WHERE email=?");
        $stmt->execute([sha1($password),$_POST['email']]);
        $_SESSION['notif']="Un nouveau mot de passe a été envoyer par mail.";
    }else{
        $_SESSION['notif']="Aucun compte ne possède cette email";
        header("Location:".$_SERVER['HTTP_REFERER']);
    }
}else{
    $_SESSION['notif']="Erreur";
}
header("Location: ../Connexion.php");
?>  