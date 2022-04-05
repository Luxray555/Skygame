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
      }
    
    $header = 10;
    include "header.php";
?>
    <main class="main close">
        <h1>Amis</h1>
        <div class="container">
          <div class="recherche">
          <form class="search" method="GET" action="">
              <input type="search" name="search" placeholder="Rechercher un utilisateur" value="<?php
              if(isset($_GET['search']) && !empty($_GET['search'])){
                echo $_GET['search'];
              }
              ?>" autocomplete="off">
          </form>
          <ul>
          <?php
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
            ?>
          </ul>
          </div>
          <div class="amis">
            <?php
            $stmt=$bdd->prepare("SELECT idUtilisateur,pseudo,photo,civilite FROM utilisateurs WHERE idUtilisateur IN (SELECT IF(idUtilisateur1=?,idUtilisateur2,idUtilisateur1) FROM amis  WHERE (idUtilisateur1=? OR idUtilisateur2=?) AND demande=1) ORDER BY pseudo DESC");
            $stmt->execute([$user['idUtilisateur'],$user['idUtilisateur'],$user['idUtilisateur']]);
            $amisTotal=$stmt->fetchAll();
            $stmt=$bdd->prepare("SELECT idUtilisateur,pseudo,photo,civilite FROM utilisateurs WHERE idUtilisateur IN (SELECT idUtilisateur1 FROM amis WHERE idUtilisateur2=? AND demande=0) ORDER BY pseudo DESC");
            $stmt->execute([$user['idUtilisateur']]);
            $demandeTotal=$stmt->fetchAll();
            ?>
            <div class="btnAmis">
              <button id="active">Mes Amis <?php echo " ( "; if($amisTotal!=false){ echo count($amisTotal);}else{echo 0;}; echo " )";?></button>
              <button>Demande d'amis <?php echo " ( "; if($demandeTotal!=false){ echo count($demandeTotal);}else{echo 0;}; echo " )";?></button>
            </div>
            <ul id="mesAmis">
              <?php
                if($amisTotal==false){
                  echo "<h2>Vous n'avez pas d'amis.</h2>";
                }else{
                  for($i=0;$i<count($amisTotal);$i++){
                    echo'
                    <li><a href="Profil.php?idUtilisateur='.$amisTotal[$i]['idUtilisateur'].'">
                    <img src="Public/Images/profil/';
                    imgProfil($amisTotal[$i]);
                    echo '.jpg" alt=" Photo de '.$utilisateurTotal[$i]['pseudo'].'">
                      <span>'.$amisTotal[$i]['pseudo'].'</span>
                    </a></li>';
                  }
                }
              ?>
          </ul>
          <ul id="demandeAmis">
              <?php
                if($demandeTotal==false){
                  echo "<h2>Vous n'avez pas de demande d'amis.</h2>";
                }else{
                  for($i=0;$i<count($demandeTotal);$i++){
                    echo'
                    <li><a href="Profil.php?idUtilisateur='.$demandeTotal[$i]['idUtilisateur'].'">
                    <img src="Public/Images/profil/';
                    imgProfil($demandeTotal[$i]);
                    echo '.jpg" alt="Photo de '.$utilisateurTotal[$i]['pseudo'].'">
                      <span>'.$demandeTotal[$i]['pseudo'].'</span>
                    </a></li>';
                  }
                }
              ?>
          </ul>
          </div>
        </div>
        <?php
            include "footer.php";
        ?>
    </main>
    </body>
    <script>
        var btnAmis = document.querySelectorAll(".btnAmis button");
        var mesAmis = document.getElementById("mesAmis");
        var demandeAmis = document.getElementById("demandeAmis");
        console.log(demandeAmis);
        btnAmis[0].onclick = function(){
          btnAmis[0].id = "active";
          btnAmis[1].removeAttribute("id");
          mesAmis.style.display = "inherit";
          demandeAmis.style.display = "none";
        }

        btnAmis[1].onclick = function(){
          btnAmis[1].id="active";
          btnAmis[0].removeAttribute("id");
          demandeAmis.style.display = "inherit";
          mesAmis.style.display = "none";

        }
    </script>
</html>