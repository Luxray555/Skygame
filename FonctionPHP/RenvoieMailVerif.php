<?php
require_once "../Setup/database.php";
session_start();

require '../FonctionPHP/phpFunction.php';

if(isset($_POST['email']) && isset($_POST['mdp'])){
	$code=randomVerifCode();
    $to   = $_POST['email'];
    $from = 'skygamecorporation@gmail.com';
    $name = 'SkyGame Corporation';
    $subj = 'SkyGame Mail Verification';
    $msg = '<div style="background:linear-gradient(#130b3d,#000000);padding:20px;">
                <h1 style="text-align:center;margin-bottom:50px;color:white">SkyGame</h1>
                <p style="text-align:center;font-size:18px;color:white;"><span style="font-weight:bold;">Nouveau code de verification : </span><span style="border:solid white 2px;padding:5px;border-radius:5px;">'.$code.'</span></p>
            </div>';
    $error=smtpmailer($to,$from, $name ,$subj, $msg);
	$stmt = $bdd->prepare("UPDATE utilisateurs SET codeVerifMail=? WHERE email=?");
	$stmt->execute(array($code,$_POST['email']));
	$_SESSION["notif"]= "Un nouveau code vous a été envoyer pas mail.";
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['mdp'] = $_POST['mdp'];
	header("Location:".  $_SERVER['HTTP_REFERER']);
}
?>