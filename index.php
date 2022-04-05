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
<!doctype html>
<html lang="fr">
  <?php
  $header=0;
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
      <h1 id="title">Sky Game</h1>
      <img src="Public/Images/background/montain.png" id="mountains_front">
      <div class="content">
    </section>
    <div class="sec" id="sec">
      <h2><img src="Public/Images/icon/LogoSkyGame.gif" alt="Logo Skygame"></h2>
      <div class="home-block">
        <img class="img1" src="Public/Images/background/no-screenshot-image.png">
        <p class="text1">SKY GAME est le meilleur catalogue de jeu video du momment indipensable pour les gamer il permet de trouve rtous le snouveau et enciens jeu souvent remis a jours notre catalogue de jeu est un des plus consequent dans le domaine du jeu video</p>
        <p class="text2">SKY GAME est le meilleur catalogue de jeu video du momment indipensable pour les gamer il permet de trouve rtous le snouveau et enciens jeu souvent remis a jours notre catalogue de jeu est un des plus consequent dans le domaine du jeu video</p>
        <img class="img2" src="Public/Images/background/no-screenshot-image.png">
      </div>
    </div>
    <?php
      include "footer.php";
    ?>
    </main>
  </body>
  <script type="text/javascript">
    <?php
    if(isset($_SESSION['notif'])){
      notifJs($_SESSION['notif']);
      unset($_SESSION['notif']);
    }
    ?>
    let title = document.getElementById('title');
    let stars = document.getElementById('stars');
    let mountains_front = document.getElementById('mountains_front');
    let btn = document.getElementById('btn');
    let header = document.querySelector('header');
    window.addEventListener('scroll', function() {
      var value = window.scrollY;
      title.style.top = -value * -2.05 + 'px';
      stars.style.left = value * 0.25 + 'px';
      header.style.top =-value * -0.5 + 'px';
      mountains_front.style.top =-value * 0 + 'px';
    });
  </script>
  <script src="https://unpkg.com/scrollreveal"></script>
  <script type="text/javascript">
      ScrollReveal({
        reset: true,
        distance: '60px',
        duration: 2500,
      });
      ScrollReveal().reveal('h2 img', { delay: 100, origin: 'top' });
      ScrollReveal().reveal('.img1, .text2', { delay: 100, origin: 'left' });
      ScrollReveal().reveal('.text1, .img2', { delay: 100, origin: 'right' });
    </script>

</html>

