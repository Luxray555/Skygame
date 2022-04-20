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
    $stmt = $bdd -> prepare("SELECT * FROM ((utilisateurs INNER JOIN transactions_jeu ON utilisateurs.idUtilisateur=transactions_jeu.idUtilisateur) INNER JOIN jeux ON transactions_jeu.idJeu=jeux.idJeu) WHERE utilisateurs.idUtilisateur=? ORDER BY nomJeu ASC");
    $stmt ->execute([$user['idUtilisateur']]);
    $jeu = $stmt->fetchAll();
    if(!isset($_GET['idJeu']) && $jeu!=false){
      header("Location: Bibliotheque.php?idJeu=".$jeu[0]['idJeu']);
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
            echo '<h1>Bibliotheque</h1>';
            if($jeu!=false){
              echo '<div class="container">
              <ul class="listGame">';
              for($i=0;$i<count($jeu);$i++){
                echo '<a href="Bibliotheque.php?idJeu='.$jeu[$i]['idJeu'].'">
                        <li ';
                        if(isset($_GET['idJeu']) && $_GET['idJeu']==$jeu[$i]['idJeu']){
                          echo 'class="active"';
                        }
                        echo'>
                          <img src="';
                if($jeu[$i]['idImageJeu']!=null){
                  echo 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$jeu[$i]['idImageJeu'].'.jpg';
                }else{
                  echo 'Public/Images/background/no-cover-image.png';
                }
                echo '" alt="Cover du jeu '.$jeu[$i]['nomJeu'].'">
                      <h2>';
                      if(strlen($jeu[$i]['nomJeu'])>27){
                        echo substr($jeu[$i]['nomJeu'],0,27).'...';
                      }else{
                        echo $jeu[$i]['nomJeu'];
                      }
                    echo '</h2>
                      </li>
                    </a>';
              }
            echo '</ul>
                    <div class="Game" id="Game">';
            if(isset($_GET['idJeu']) && is_numeric($_GET['idJeu'])){
              $stmt = $bdd -> prepare("SELECT jeux.idJeu,transactions_jeu.cleJeu FROM ((utilisateurs INNER JOIN transactions_jeu ON utilisateurs.idUtilisateur=transactions_jeu.idUtilisateur) INNER JOIN jeux ON transactions_jeu.idJeu=jeux.idJeu) WHERE utilisateurs.idUtilisateur=? AND jeux.idJeu=?");
              $stmt->execute([$user['idUtilisateur'],$_GET['idJeu']]);
              $verifJeu = $stmt->fetch();
              if($verifJeu!=false){
                require_once "RessourceAPI/IGDB/src/class.igdb.php";
                $igdb = new IGDB("e19o82j85kk6ghwi039ny07xi8stf5", verifyAccessToken($bdd));
                $builder = new IGDBQueryBuilder(); 
                $idJeu = $_GET['idJeu'];
                $options = array(
                  "fields" => "id,name,cover.*,genres.name,platforms.name,summary,videos.*,screenshots.*,artworks.*",
                  "limit" => 1,
                  "custom_where" => "id = $idJeu & platforms=(6,14,7,8,9,38,48,167,11,12,49,169,5,20,37,41,130) & genres=(5,7,8,9,10,12,13,14,15,25,31,32,36)"
                );
                try {
                  $query = $builder->options($options)->build();
                } catch (IGDBInvaliParameterException $e) {
                  echo $e->getMessage();
                }
                $game = $igdb->game($query);
                if(isset($game) && count($game)!=0){
                  echo '<img src="'.verifImageIGDB($game[0]->cover).'" alt="Cover du jeu '.$game[0]->name.'">
                  <h1>'.$game[0]->name.'</h1><div class="info">
                  <div class="platforms">
                  <h4>Platforme(s):</h4>';
                  if(isset($game[0]->platforms)){
                    for($i=0;$i<count($game[0]->platforms);$i++){
                      echo '<span>'.$game[0]->platforms[$i]->name.'</span>';
                    }
                  }else{
                    echo '<span>Aucune</span>';
                  }
                  echo '</div>
                    <div class="genres">
                            <h4>Genre(s):</h4>';
                  if(isset($game[0]->genres)){
                    for($i=0;$i<count($game[0]->genres);$i++){
                      echo '<span>'.$game[0]->genres[$i]->name.'</span>';
                    }
                  }else{
                    echo '<span>Aucune</span>';
                  }
                  echo '</div>
                  <div class="discover-button">
                    <button>Decouvrir la clé</button>
                  </div>
                  </div>
                  <a href="PageJeu.php?idJeu='.$game[0]->id.'"><button>Aller  à la page du jeu</button></a>';
                }else{
                  echo '<h2>Ce jeu n'."'".'existe pas.</h2>
                    <style>
                      .Game{
                        display:unset;
                        position:relative;
                        max-height:100%;
                        min-height:200px;
                      }
                      .Game h2{
                        text-align: center;
                        margin: auto;
                        position: absolute;
                        left: 50%;
                        top: 45%;
                        -ms-transform: translateX(-50%) translateY(-50%);
                        transform: translateX(-50%) translateY(-50%);
                      }
                      </style>';
                }
                        
              }else{
                echo '<h2>Vous ne possédez pas ce jeu ou ce jeu n'."'".'existe pas</h2>
                      <style>
                      .Game{
                        height: 80vh;
                        display:unset;
                        position:relative;
                        max-height:100%;
                        min-height:200px;
                      }
                      .Game h2{
                        text-align: center;
                        margin: auto;
                        position: absolute;
                        left: 50%;
                        top: 45%;
                        -ms-transform: translateX(-50%) translateY(-50%);
                        transform: translateX(-50%) translateY(-50%);
                      }
                      </style>';
              }
            }else{
              echo '<h2>Vous ne possédez pas ce jeu ou ce jeu n'."'".'existe pas</h2>
                      <style>
                      .Game{
                        height: 80vh;
                        display:unset;
                        position:relative;
                      }
                      .Game h2{
                        text-align: center;
                        margin: auto;
                        position: absolute;
                        left: 50%;
                        top: 45%;
                        -ms-transform: translateX(-50%) translateY(-50%);
                        transform: translateX(-50%) translateY(-50%);
                      }
                      </style>';
            }
                    echo '</div>
                </div>';
            }else{
              echo '<div class="container-vide">
                      <div class="container-mid">
                        <img src="Public/Images/icon/no-game.png">
                        <h2>Vous ne possédez aucun jeu.</h2>
                        <a href="Catalogue.php"><button>Aller au catalogue</button></a>
                      </div>
                    </div>';
            }
        }else{
            echo "<div class='no-access-page'>
                <h1>Vous n'avez pas accès à cette page.</h1>
                <button><a href='index.php'>Accueil</a></button>
            </div>";
        }
        ?>
    <?php
    include "footer.php";
    ?>
    </main>
  </body>
    <script type="text/javascript">
      <?php
      if(isset($game[0]->artworks)){
        echo 'document.querySelector("body").style.backgroundImage="url('."'".'https://images.igdb.com/igdb/image/upload/t_1080p/'.$game[0]->artworks[0]->image_id.'.png'."'".')";';
      }
      ?>
      <?php
       if(isset($_SESSION['notif'])){
        notifJs($_SESSION['notif']);
        unset($_SESSION['notif']);
      }
      if($jeu!=false && isset($game) && count($game)!=0){
        echo 'discover=document.querySelector(".discover-button");
              button=document.querySelector(".discover-button button");
              
              button.onclick = function(){
                discover.removeChild(button);
                discover.innerHTML = "<h3>'.substr($verifJeu['cleJeu'],0,4).'-'.substr($verifJeu['cleJeu'],4,4).'-'.substr($verifJeu['cleJeu'],8,12).'</h3>";
              }';
      }
      ?>
    </script>

</html>