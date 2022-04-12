<?php
require_once "../Setup/database.php";
require "phpFunction.php";
session_start();
if(isset($_SESSION['idUtilisateur'])){
    $user = informationUser($_SESSION['idUtilisateur'],$bdd);
}
if(isset($_POST['idJeu'])){
    $stmt = $bdd->prepare('SELECT * FROM jeux WHERE idJeu=?');
	$stmt->execute([$_POST['idJeu']]);
    $jeu = $stmt->fetch();
    $stmt = $bdd->prepare('SELECT * FROM transactionsJeu WHERE idJeu=? AND idUtilisateur=?');
	$stmt->execute([$jeu['idJeu'],$user['idUtilisateur']]);
    $transaction = $stmt->fetch();
    if($transaction==false){
        if($jeu['prixJeu']<=$user['skyCoin']){
            $stmt = $bdd->prepare("UPDATE utilisateurs SET skyCoin=skyCoin-? WHERE idUtilisateur=?");
            $stmt->execute([$jeu['prixJeu'],$user['idUtilisateur']]);

            $stmt = $bdd->prepare("INSERT INTO transactionsJeu(cleJeu,idUtilisateur,idJeu) VALUES (?,?,?)");
            $stmt->execute([randomKey(),$user['idUtilisateur'],$jeu['idJeu']]);
            $_SESSION['notif']="Achat effectué avec succès.<br>Retrouvez la clé dans votre bibliothéque.";
        }else{
            $_SESSION['notif']="Vous n'avez pas les fonds nécéssaire.";
        }
    }else{
        $_SESSION['notif']="Vous possèdez déjà une clé du jeu.<br>Allez dans votre bibliothéque.";
    }
}
header('Location: ../PageJeu.php?idJeu='.$jeu['idJeu']);
?>