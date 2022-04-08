<?php
require_once "../Setup/database.php";
session_start();

require '../FonctionPHP/phpFunction.php';
require "../RessourceAPI/PHPMailer/PHPMailerAutoload.php";
if(isset($_SESSION['email']) &&isset($_SESSION['mdp'])){
	$code=randomVerifCode();
    $to   = $_SESSION['email'];
    $from = 'skygameprojet@gmail.com';
    $name = 'SkyGame Corporation';
    $subj = 'SkyGame Mail Verification';
    $msg = '<div style="background-color:#070831;padding:20px;">
                <h1 style="text-align:center;margin-bottom:50px;color:white">SkyGame</h1>
                <p style="text-align:center;font-size:18px;color:white;"><span style="font-weight:bold;">Nouveau code de verification : </span><span style="border:solid white 2px;padding:5px;border-radius:5px;">'.$code.'</span></p>
            </div>';
    $error=smtpmailer($to,$from, $name ,$subj, $msg);
	$insertUser = $bdd->prepare("UPDATE utilisateurs SET codeVerifMail=? WHERE email=?");
	$insertUser->execute(array($code,$_SESSION['email']));
	$_SESSION["notif"]= "Un nouveau code vous a été envoyer pas mail.";
	header("Location: ../VerifMail.php");
}
?>