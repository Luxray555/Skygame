<?php
require_once "../Setup/database.php";
session_start();

require '../FonctionPHP/phpFunction.php';

if(isset($_POST['email']) && isset($_POST['sujet']) && isset($_POST['description']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $to   = 'skygamecorporation@gmail.com';
    $from = 'skygamecorporation@gmail.com';
    $name = $_POST['email'];
    $subj = $_POST['sujet'];
    $msg = '<div style="background:linear-gradient(#130b3d,#000000);padding:20px; width:90%;">
            <h1 style="text-align:center;margin-bottom:50px;color:white">Support</h1>
            <p style="font-size:18px;color:white;display:unset;width:100%;"><span style="font-weight:bold;">Email : </span><span style="padding:5px;">'.$_POST['email'].'</span></p><br><br>
            <p style="font-size:18px;color:white;display:unset;width:100%;"><span style="font-weight:bold;">Sujet : </span><span style="padding:5px;">'.$_POST['sujet'].'</span></p><br><br>
            <p style="font-size:18px;color:white;display:unset;width:100%;"><span style="font-weight:bold">Description : </span></p><br>
            <p style="font-size:18px;color:white;display:inherit;border:solid white 2px;border-radius:5px;width: 90%;margin:auto;padding:20px;">'.$_POST['description'].'</p>
        </div>';
    $error=smtpmailer($to,$from, $name ,$subj, $msg);
    $_SESSION['notif']="Le message a été envoyer au support.";
}else{
    $_SESSION['notif']="Erreur";
}
header("Location:".  $_SERVER['HTTP_REFERER']);
?>  