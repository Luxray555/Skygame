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
    if(isset($_SESSION['notif'])){
      echo '<div id="error" style="background-color:green"><p class="error">'.$_SESSION['notif'].'</p></div>';
    }
    ?>
    <section class="accueil">
      <img src="Public/Images/background/stars.png" id="stars">
      <div id="title">
        <h1>Sky Game</h1>
        <p>Bienvenue</p>
      </div>
      <img src="Public/Images/background/montain.png" id="mountains_front">
      <div class="content">
    </section>
    <div class="sec" id="sec">
      <div class="imgGif"><img src="Public/Images/icon/LogoSkyGame.gif" alt="Logo Skygame"></div>
      <div class="home-block">
        <img class="img1" src="Public/Images/background/accueil1.png">
        <p class="text1">Skygame est un catalogue de jeux vidéo où vous pouvez avoir accès à tous les jeux en utilisant des skycoins. Grâce à nos nombreux partenaires, nous pouvons vous donner accès à quasiment la totalité des jeux du moment. De plus, Skygame est le meilleur dans sa catégorie grâce à son aspect social minutieusement réfléchi. </p>
        <p class="text2">Skygame vous propose en plus des derniers jeux sortis, un système communautaire entre chaque utilisateur, ce qui vous permet d'ajouter en ami d'autres utilisateurs mais en plus de pouvoir communiquer avec eux par message.</p>
        <img class="img2" src="Public/Images/background/accueil2.png">
      </div>
      <div class="slider">
        <h3>Les meilleurs jeux du moments</h3>
      </div>
      <div class="info">
      <h2>Statistique(s)</h2>
        <div class="part">
          <div>
            <h3><?php
            $stmt=$bdd->prepare("SELECT COUNT(idUtilisateur) FROM utilisateurs");
            $stmt->execute();
            $nb = $stmt->fetch()[0];
            if($nb !=false){
              echo $nb;
            }else{
              echo 0;
            }
            ?></h3>
            <h4>Utilisateur(s)</h4>
          </div>
          <div>
            <h3><?php
            $stmt=$bdd->prepare("SELECT COUNT(idTransactionJeu) FROM transactions_jeu");
            $stmt->execute();
            $nb = $stmt->fetch()[0];
            if($nb !=false){
              echo $nb;
            }else{
              echo 0;
            }
            ?></h3>
            <h4>Clé(s) acheté</h4>
          </div>
          <div>
            <h3><?php
            $stmt=$bdd->prepare("SELECT ROUND((SELECT COUNT(idTransactionJeu) FROM transactions_jeu)/(SELECT COUNT(idUtilisateur) FROM utilisateurs),2)");
            $stmt->execute();
            $nb = $stmt->fetch()[0];
            if($nb !=false){
              echo $nb;
            }else{
              echo 0;
            }
            ?></h3>
            <h4>Clé(s) acheté par personne</h4>
          </div>
          <div>
            <h3><?php
            $stmt=$bdd->prepare("SELECT SUM(totalSkycoin) FROM transactions_skycoin INNER JOIN skycoins ON transactions_skycoin.idSkycoin=skycoins.idSkycoin");
            $stmt->execute();
            $nb = $stmt->fetch()[0];
            if($nb !=false){
              echo $nb;
            }else{
              echo 0;
            }
            ?></h3>
            <h4>Skycoin(s) acheté</h4>
          </div>
        </div>
        <p><i>Informations en temps réel.</i></p>
      </div>
      <div class="nous">
        <h2>Qui sommes nous ?</h2>
        <div class="part">
          <div>
            <img src="Public/Images/background/nous1.png">
            <h3>Votre vision, notre savoir faire</h3>
            <p>Toujours à l'écoute de nos clients, nous essayons de toujours vous satisfaire en mettant régulièrement le site à jour dans le but que les jeux les plus récent soient à votre disposition.</p>
          </div>
          <div>
            <img src="Public/Images/background/nous2.png">
            <h3>Vos données, notre écosystème</h3>
            <p>Vous avez un libre accès à notre écosystème qui vous met à votre disposition un large choix de personnalisation de votre profil et toutes données personnelles stockées dans notre base de données sont sécurisés afin de protéger votre vie privée.</p>
          </div>
          <div>
            <img src="Public/Images/background/nous3.png">
            <h3>Nos services, notre catalogue</h3>
            <p>Le catalogue qui est mis à votre disposition est constamment mis à jour par notre équipe. Ce qui vous permet d'avoir toujours accès aux derniers jeux proposer dans le monde. De plus, les informations de chaque jeux sont modifiées en temps réel.</p>
          </div>
        </div>
      </div>
    </div>
    <?php
      include "footer.php";
    ?>
    </main>
  </body>
  <script>
    <?php
    if(isset($_SESSION['notif'])){
      notifJs($_SESSION['notif']);
      unset($_SESSION['notif']);
    }
    ?>
  </script>
  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="Public/js/Accueil.js"></script>
</html>

