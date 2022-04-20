<?php
    require_once "Setup/database.php";
    session_start();

    require "FonctionPHP/phpFunction.php";

    if(isset($_SESSION['idUtilisateur'])){
        if ($_SESSION['timestamp']!=null) {
          $_SESSION['timestamp'] = expiredSession($_SESSION['timestamp']);
        }else{
          $_SESSION['chargement'] = 'deconnexion par innactivité';
          header('Location: Chargement.php');
        }
        $user = informationUser($_SESSION['idUtilisateur'],$bdd);
        if($user){
          if($user['verifMail']==0){
            session_destroy();
          }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
  <?php
  include "header.php";
  ?>
    <main class="main close">
      <?php
      if(isset($user['idUtilisateur'])){
        echo '<h1>Amis</h1>
        <div class="container">
          <div class="recherche">
          <form class="search" method="GET" action="">
              <input type="search" name="search" placeholder="Rechercher un utilisateur" value="';
              if(isset($_GET['search']) && !empty($_GET['search'])){
                echo $_GET['search'];
              }
              echo'" autocomplete="off">
          </form>
          <ul>';
              if(isset($_GET['search']) && !empty($_GET['search'])){
                $stmt=$bdd->prepare("SELECT idUtilisateur,pseudo,photo,civilite FROM utilisateurs WHERE  idUtilisateur<>? AND pseudo LIKE ? ORDER BY pseudo DESC");
                $stmt->execute([$user['idUtilisateur'],"%".$_GET['search']."%"]);
                $utilisateurTotal= $stmt->fetchAll();
                if($utilisateurTotal==false){
                  echo '<h2>Utilisateur introuvable</h2>';
                }else{
                  for($i=0;$i<count($utilisateurTotal);$i++){
                    echo'
                    <li><a href="Profil.php?idUtilisateur='.$utilisateurTotal[$i]['idUtilisateur'].'">
                      <img src="Public/Images/profil/';
                      imgProfil($utilisateurTotal[$i]);
                      echo '.jpg" alt="Photo de '.$utilisateurTotal[$i]['pseudo'].'">
                      <span>'.$utilisateurTotal[$i]['pseudo'].'</span>
                    </a></li>';
                  }
                }
              }else{
                echo "<h2>Effectuer une recherche<h2>";
              }
          echo '</ul>
          </div>
          <div class="amis">';
            $stmt=$bdd->prepare("SELECT idUtilisateur,pseudo,photo,civilite FROM utilisateurs WHERE idUtilisateur IN (SELECT IF(idUtilisateur1=?,idUtilisateur2,idUtilisateur1) FROM amis  WHERE (idUtilisateur1=? OR idUtilisateur2=?) AND demande=1) ORDER BY pseudo DESC");
            $stmt->execute([$user['idUtilisateur'],$user['idUtilisateur'],$user['idUtilisateur']]);
            $amisTotal=$stmt->fetchAll();
            $stmt=$bdd->prepare("SELECT idUtilisateur,pseudo,photo,civilite FROM utilisateurs WHERE idUtilisateur IN (SELECT idUtilisateur1 FROM amis WHERE idUtilisateur2=? AND demande=0) ORDER BY pseudo DESC");
            $stmt->execute([$user['idUtilisateur']]);
            $demandeTotal=$stmt->fetchAll();
            echo '<div class="btnAmis">
              <button id="active">Mes Amis ( ';
              if($amisTotal!=false){
                echo count($amisTotal);
              }else{
                echo 0;
              };
              echo ' )</button>
              <button>Demande d'."'".'amis ( ';
              if($demandeTotal!=false){
                echo count($demandeTotal);
              }else{
                echo 0;
              }
              echo ' )</button>
            </div>
            <ul id="mesAmis">';
                if($amisTotal==false){
                  echo "<h2>Vous n'avez pas d'amis.</h2>";
                }else{
                  for($i=0;$i<count($amisTotal);$i++){
                    echo'
                    <li><a href="Profil.php?idUtilisateur='.$amisTotal[$i]['idUtilisateur'].'">
                    <img src="Public/Images/profil/';
                    imgProfil($amisTotal[$i]);
                    echo '.jpg" alt=" Photo de '.$amisTotal[$i]['pseudo'].'">
                      <span>'.$amisTotal[$i]['pseudo'].'</span>
                    </a></li>';
                  }
                }
          echo '</ul>
          <ul id="demandeAmis">';
                if($demandeTotal==false){
                  echo "<h2>Vous n'avez pas de demande d'amis.</h2>";
                }else{
                  for($i=0;$i<count($demandeTotal);$i++){
                    echo'
                    <li><a href="Profil.php?idUtilisateur='.$demandeTotal[$i]['idUtilisateur'].'">
                    <img src="Public/Images/profil/';
                    imgProfil($demandeTotal[$i]);
                    echo '.jpg" alt="Photo de '.$demandeTotal[$i]['pseudo'].'">
                      <span>'.$demandeTotal[$i]['pseudo'].'</span>
                    </a></li>';
                  }
                }
          echo '</ul>
          </div>
        </div>';
        }else{
          echo "<div class='no-access-page'>
					<h1 >Vous n'avez pas accès à cette page</h1>
					<button><a href='index.php'>Accueil</a></button>
				  </div>";
        }
            include "footer.php";
        ?>
    </main>
    </body>
    <script src="Public/js/Amis.js"></script>
</html>