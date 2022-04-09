<?php
require_once "../Setup/database.php";
session_start();

require '../FonctionPHP/phpFunction.php';
require "../RessourceAPI/PHPMailer/PHPMailerAutoload.php";

if(isset($_POST['email']) && isset($_POST['sujet']) && isset($_POST['description'])){
    $to   = 'skygameprojet@gmail.com';
    $from = 'skygameprojet@gmail.com';
    $name = "no";
    $subj = $_POST['sujet'];
    $msg = '<div style="background-color:#c9c9c9;padding:20px;">
            <h1 style="text-align:center;margin-bottom:50px;color:white">Support</h1>
            <p style="text-align:center;font-size:18px;color:white;"><span style="font-weight:bold;">Email : </span><span style="border:solid white 2px;padding:5px;border-radius:5px;">'.$_POST['email'].'</span></p>
            <p style="text-align:center;font-size:18px;color:white;"><span style="font-weight:bold;">Sujet : </span><span style="border:solid white 2px;padding:5px;border-radius:5px;">'.$_POST['sujet'].'</span></p>
            <p style="text-align:center;font-size:18px;color:white;"><span style="font-weight:bold;">Description : </span><span style="border:solid white 2px;padding:5px;border-radius:5px;">'.$_POST['description'].'</span></p>
        </div>';
    $error=smtpmailer($to,$from, $name ,$subj, $msg);
    $_SESSION['notif']="Le message a été envoyer au support.";
}
header("Location: ../Support.php");
?>