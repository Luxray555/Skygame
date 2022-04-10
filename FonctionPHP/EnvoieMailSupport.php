<?php
require_once "../Setup/database.php";
session_start();

require '../FonctionPHP/phpFunction.php';
require "../RessourceAPI/PHPMailer/PHPMailerAutoload.php";

if(isset($_POST['email']) && isset($_POST['sujet']) && isset($_POST['description']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $to   = 'skygameprojet@gmail.com';
    $from = 'skygameprojet@gmail.com';
    $name = $_POST['email'];
    $subj = $_POST['sujet'];
    $msg = '<div style="background-color:#c9c9c9;padding:20px; max-width:600px;min-width:200px;">
            <h1 style="text-align:center;margin-bottom:50px;color:black">Support</h1>
            <p style="font-size:18px;color:black;display:unset;width:100%;"><span style="font-weight:bold;">Email : </span><span style="padding:5px;">'.$_POST['email'].'</span></p><br><br>
            <p style="font-size:18px;color:black;display:unset;width:100%;"><span style="font-weight:bold;">Sujet : </span><span style="padding:5px;">'.$_POST['sujet'].'</span></p><br><br>
            <p style="font-size:18px;color:black;display:unset;width:100%;"><span style="font-weight:bold">Description : </span></p><br>
            <p style="font-size:18px;color:black;display:inherit;border:solid black 2px;padding:5px;border-radius:5px;width: 100%">'.$_POST['description'].'</p>
        </div>';
    $error=smtpmailer($to,$from, $name ,$subj, $msg);
    $_SESSION['notif']="Le message a été envoyer au support.";
}else{
    $_SESSION['notif']="Erreur";
}
header("Location: ../Support.php");
?>  