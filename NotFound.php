<?php
    require_once "Setup/database.php";
    session_start();
    
    require 'FonctionPHP/phpFunction.php';
  
    if(isset($_SESSION['idUtilisateur'])){
      if ($_SESSION['timestamp']!=null) {
        $_SESSION['timestamp'] = expiredSession($_SESSION['timestamp']);
      }else{
        $_SESSION['chargement'] = 'deconnexion par innactivité';
        header('Location: Chargement.php');
      }
      $user = informationUser($_SESSION['idUtilisateur'],$bdd);
    }
?>
<?php
    include "header.php";
?>
<main class="main close">
<?php
    include "footer.php";
?>
</main>