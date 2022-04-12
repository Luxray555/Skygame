<?php
require_once "../Setup/database.php";
require "phpFunction.php";
session_start();
if(isset($_SESSION['idUtilisateur'])){
    $user = informationUser($_SESSION['idUtilisateur'],$bdd);
}
if(isset($_POST['idSkycoin'])){
    $stmt = $bdd->prepare('SELECT * FROM skycoins WHERE idSkycoin=?');
	$stmt->execute([$_POST['idSkycoin']]);
    $skycoin = $stmt->fetch();
    if($skycoin!=false){
        if($skycoin['idSkycoin']==1){
            date_default_timezone_set("Europe/Paris");
            if($user['lastRecompence'] == null || strtotime(date('Y-m-d',strtotime($user['lastRecompence'])))<strtotime(date('Y-m-d'))){
                $stmt = $bdd->prepare("UPDATE utilisateurs SET skyCoin=skyCoin+?,lastRecompence=? WHERE idUtilisateur=?");
                $stmt->execute([$skycoin['totalSkycoin'],date('Y-m-d H:i:s'),$user['idUtilisateur']]);
                $_SESSION['notif']="Achat effectué avec succès.<br>+".$skycoin['totalSkycoin']." Skycoin";
            }
        }else{
            $stmt = $bdd->prepare("UPDATE utilisateurs SET skyCoin=skyCoin+? WHERE idUtilisateur=?");
            $stmt->execute([$skycoin['totalSkycoin'],$user['idUtilisateur']]);
            $_SESSION['notif']="Achat effectué avec succès.<br>+".$skycoin['totalSkycoin']." Skycoin";
        }
    }else{
        header('Location: ../Boutique.php');
    }
    $stmt = $bdd->prepare("INSERT INTO transactionsskycoin(idUtilisateur,idSkycoin) VALUES (?,?)");
    $stmt->execute([$user['idUtilisateur'],$skycoin['idSkycoin']]);
}
header('Location: ../Boutique.php');
?>