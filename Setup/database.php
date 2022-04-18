<?php
$hostdb = "localhost";
$namedb = "skygame";
$utilisateurdb = "root";
$passworddb = "";
try {
    $bdd=new PDO("mysql:host=$hostdb;dbname=$namedb;charset=utf8",$utilisateurdb,$passworddb);
}catch (PDOException $e) {
    echo "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>