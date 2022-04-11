<?php
require_once "../Setup/database.php";
session_start();

require '../FonctionPHP/phpFunction.php';
require "../RessourceAPI/PHPMailer/PHPMailerAutoload.php";
if(!empty($_POST)){
	$code=randomVerifCode();
    $to   = $_POST['email'];
    $from = 'skygameprojet@gmail.com';
    $name = 'SkyGame Corporation';
    $subj = 'SkyGame Mail Verification';
    $msg = '<div style="background-color:#070831;padding:20px;">
                <h1 style="text-align:center;margin-bottom:50px;color:white">SkyGame</h1>
                <p style="text-align:center;font-size:18px;color:white;"><span style="font-weight:bold;">Code de verification : </span><span style="border:solid white 2px;padding:5px;border-radius:5px;">'.$code.'</span></p>
            </div>';
    $error=smtpmailer($to,$from, $name ,$subj, $msg);
	$insertUser = $bdd->prepare("INSERT INTO utilisateurs(civilite,nom,prenom,pseudo,email,password,codeVerifMail)VALUES(?,?,?,?,?,?,?)");
	$insertUser->execute(array(substr($_POST['civilite'],0,1),substr(htmlspecialchars($_POST["nom"]),0,25),substr(htmlspecialchars($_POST["prenom"]),0,25),substr(htmlspecialchars($_POST["pseudo"]),0,15),substr(htmlspecialchars($_POST["email"]),0,255),substr(sha1($_POST["mdp"]),0,50),$code));
	$_SESSION["chargement"]= "Création du compte";
	header('Location: ../Chargement.php');
}
?>