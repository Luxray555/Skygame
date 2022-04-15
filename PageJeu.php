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
    require_once "RessourceAPI/IGDB/src/class.igdb.php";

    $igdb = new IGDB("e19o82j85kk6ghwi039ny07xi8stf5", verifyAccessToken($bdd));
    $platforme = array("Toutes" => "6,14,7,8,9,38,48,167,11,12,49,169,5,20,37,41,130","PC" => "6,14","Playstation" => "7,8,9,38,48,167","Xbox" => "11,12,49,169","Nintendo" => "5,20,37,41,130");
    $genre = array("Tous" => "5,7,8,9,10,12,13,14,15,25,31,32,36","Adventure" => "31","Shooter" => "5","Role-playing (RPG)" => "12","Sport" => "14","Simulator" => "13","Racing" => "10","Platform" => "8","Strategy" => "15","Indie" => "32","Hack and slash/Beat 'em up" => "25","Puzzle" => "9","MOBA" => "9","Music" => "7");
    if(isset($_GET['idJeu']) && is_numeric($_GET['idJeu']) && $_GET['idJeu']>0){
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
        $stmt = $bdd->prepare("SELECT * FROM jeux WHERE idJeu=?");
          $stmt ->execute([$game[0]->id]);
          $jeu = $stmt->fetch();
          if(isset($_POST['rate'])){
            $stmt = $bdd->prepare('SELECT note FROM notes_jeu WHERE idUtilisateur=? AND idJeu=? ');
            $stmt->execute([$user['idUtilisateur'],$jeu['idJeu']]);
            $askRate = $stmt->fetch();
            if($askRate!=false){
              $stmt = $bdd->prepare('UPDATE notes_jeu SET note=? WHERE idUtilisateur=? AND idJeu=?');
              $stmt->execute([$_POST['rate'],$user['idUtilisateur'],$jeu['idJeu']]);
            }else{
              $stmt = $bdd->prepare('INSERT INTO notes_jeu(note,idUtilisateur,idJeu) VALUES (?,?,?)');
              $stmt->execute([$_POST['rate'],$user['idUtilisateur'],$jeu['idJeu']]);
            }
          }
          if($jeu==false){
            if(isset($game[0]->cover)){
              $stmt = $bdd->prepare("INSERT INTO jeux(idJeu,nomJeu,idImageJeu,prixJeu) VALUES (?,?,?,?)");
              $stmt ->execute([$game[0]->id,$game[0]->name,$game[0]->cover->image_id,rand(1,70)*100]);
            }else{
              $stmt = $bdd->prepare("INSERT INTO jeux(idJeu,nomJeu,prixJeu) VALUES (?,?,?)");
              $stmt ->execute([$game[0]->id,$game[0]->name,rand(1,70)*100]);
            }
          }else{
            $stmt = $bdd->prepare('UPDATE jeux SET noteMoyenne=(SELECT AVG(note) FROM notes_jeu WHERE idJeu=?) WHERE idJeu=?');
            $stmt->execute([$jeu['idJeu'],$jeu['idJeu']]);
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
        if(isset($game) && count($game)!=0){
          if(isset($_SESSION['notif'])){
            echo '<div id="error" style="background-color:';
            if(substr($_SESSION['notif'],0,28)=="Achat effectué avec succès"){
              echo 'green';
            }else{
                echo 'red';
            }
            echo '"><p class="error">'.$_SESSION['notif'].'</p></div>';
          }
          echo '<div class="game-block">
                  <div class="top-game">
                    <img src="'.verifImageIGDB($game[0]->cover).'" alt="Cover de '.$game[0]->name.'">
                    <h1>'.$game[0]->name.'</h1>
                    <div class="info">
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
                <form class="buy-button" method="POST" action="';
                if(isset($user['idUtilisateur'])){
                  echo 'FonctionPHP/AchatJeu.php';
                }else{
                  echo 'Connexion';
                }
                echo '">
                  <input type="hidden" name="idJeu" value="'.$game[0]->id.'">
                  <input id="acheter" type="submit" value="Acheter une clé">
                </form>
              </div>';
            $stmt = $bdd->prepare("SELECT idJeu,prixJeu,noteMoyenne FROM jeux WHERE idJeu=?");
            $stmt ->execute([$game[0]->id]);
            $jeu = $stmt->fetch();
            if(isset($_SESSION['idUtilisateur'])){
              $stmt = $bdd->prepare('SELECT note FROM notes_jeu WHERE idUtilisateur=? AND idJeu=?');
              $stmt->execute([$user['idUtilisateur'],$jeu['idJeu']]);
              $note=$stmt->fetch();
            }
            echo '<div class="prix">
            <span>Prix :  '.$jeu['prixJeu'].' <img src="Public/Images/icon/skyCoin.png" alt="Skycoin"></span>
            </div>';
            if(isset($_SESSION['idUtilisateur'])){
              echo '<form class="note" method="POST" action="PageJeu.php?idJeu='.$_GET['idJeu'].'">
              <input type="radio" id="five" name="rate" value="5" onclick="submit()" ';
              if($note!=false && $note['note']==5){
                echo 'checked';
              }
              echo'>
              <label for="five"></label>
              <input type="radio" id="four" name="rate" value="4" onclick="submit()" ';
              if($note!=false && $note['note']==4){
                echo 'checked';
              }
              echo'>
              <label for="four"></label>
              <input type="radio" id="three" name="rate" value="3" onclick="submit()" ';
              if($note!=false && $note['note']==3){
                echo 'checked';
              }
              echo'>
              <label for="three"></label>
              <input type="radio" id="two" name="rate" value="2" onclick="submit()" ';
              if($note!=false && $note['note']==2){
                echo 'checked';
              }
              echo'>
              <label for="two"></label>
              <input type="radio" id="one" name="rate" value="1" onclick="submit()" ';
              if($note!=false && $note['note']==1){
                echo 'checked';
              }
              echo'>
              <label for="one"></label>
            </form>';
            }
            echo '<div class="note-generale">';
              if(isset($_SESSION['idUtilisateur'])){
                echo '<span class="maNote">Ma note :&nbsp;&nbsp;';
                if($note!=false){
                  echo $note['note'].'/5';
                }else{
                  echo 'Aucune';
                }
                echo '</span>';
              }
              echo '<span class="noteGen">Note Generale :&nbsp;&nbsp;';
              if($jeu['noteMoyenne']!=null){
                echo $jeu['noteMoyenne'].'/5';
              }else{
                echo 'Aucune';
              }
              echo '</span
            </div>';
            echo '</div></div>';
          if(isset($game[0]->summary)){
            echo '<div class="description">
                    <h2>A propos du jeu :</h2>
                    <p>'.$game[0]->summary.'</p>
                  </div>';
          }


          if(isset($game[0]->screenshots) && count($game[0]->screenshots)!=0){
            echo '<h2>Screenshot(s):</h2>
            <div id="sliderImage" class="slider">';
            for($i=0;$i<count($game[0]->screenshots);$i++){
                if($i==0){
                    echo '<div class="slide active">';
                }else{
                    echo '<div class="slide">';
                }
                echo '<img src="https://images.igdb.com/igdb/image/upload/t_1080p/'.$game[0]->screenshots[$i]->image_id.'.jpg" alt="Screenshot de '.$game[0]->name.' numéro '.($i+1).'">
                </div>';
            }
            echo '<div class="navigation">
            <i class="fas fa-chevron-left prev-btn"><img width="20px" style="transform: rotate(180deg);filter:invert(100%);" src="Public/Images/icon/arrow.png"></i>
            <i class="fas fa-chevron-right next-btn"><img width="20px" style="filter:invert(100%);" src="Public/Images/icon/arrow.png"></i>
                </div>
                <div class="navigation-visibility">';
            for($i=0;$i<count($game[0]->screenshots);$i++){
                echo '<div class="slide-icon';
                if($i==0){
                    echo ' active';
                }
                echo '">
                </div>';
            }
            echo '</div>
            </div>';
          }else{
            echo '<div id="sliderImage" class="slider">
                    <div class="slide active">
                        <img src="Public/Images/background/no-screenshot-image.png" alt="Aucun Screenshot">
                    </div>
                    <div class="navigation">
                        <i class="fas fa-chevron-left prev-btn"><img width="20px" style="transform: rotate(180deg);filter:invert(100%);" src="Public/Images/icon/arrow.png"></i>
                        <i class="fas fa-chevron-right next-btn"><img width="20px" style="filter:invert(100%);" src="Public/Images/icon/arrow.png"></i>
                    </div>
                    <div class="navigation-visibility">
                        <div class="slide-icon active"></div>
                    </div>
                </div>';
        }
        if(isset($game[0]->videos) && count($game[0]->videos)!=0){
          echo '<h2>Video(s):</h2>
          <div id="sliderVideo" class="slider">';
            for($i=0;$i<count($game[0]->videos);$i++){
                if($i==0){
                  echo '<div class="slide active">';
                }else{
                  echo '<div class="slide">';
                }
                echo '<iframe width="900" src="https://www.youtube.com/embed/'.$game[0]->videos[$i]->video_id.'" frameborder="0" allowfullscreen alt="Vidéo de '.$game[0]->name.' numéro '.($i+1).'"></iframe>
                </div>';
            }
            echo '<div class="navigation">
            <i class="fas fa-chevron-left prev-btn"><img width="20px" style="transform: rotate(180deg);filter:invert(100%);" src="Public/Images/icon/arrow.png"></i>
            <i class="fas fa-chevron-right next-btn"><img width="20px" style="filter:invert(100%);" src="Public/Images/icon/arrow.png"></i>
              </div>
              <div class="navigation-visibility">';
            for($i=0;$i<count($game[0]->videos);$i++){
              echo '<div class="slide-icon';
              if($i==0){
                  echo ' active';
              }
              echo '">
              </div>';
            }
            echo '</div>
            </div>';
        }
        echo '</div>';
      }else{
        echo "<div class='no-access-page'>
            <h1>Ce jeu n'existe pas</h1>
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
      if(!isset($user['idUtilisateur'])){
        echo'form = document.querySelector(".buy-button");
        first_button = true;
        form.addEventListener ("submit", function(e) {
          if(first_button){
            e.preventDefault();
            document.getElementById("acheter").value = "Se connecter";
            first_button = false;
          }
        });';
      }
      if(isset($_SESSION['notif'])){
        notifJs($_SESSION['notif']);
        unset($_SESSION['notif']);
      }
      ?>
      function slide(slider){
        const nextBtn = slider.querySelector(".next-btn");
        const prevBtn = slider.querySelector(".prev-btn");
        const slides = slider.querySelectorAll(".slide");
        const slideIcons = slider.querySelectorAll(".slide-icon");
        const numberOfSlides = slides.length;
        var slideNumber = 0;

        nextBtn.addEventListener("click", () => {
          slides.forEach((slide) => {
            slide.classList.remove("active");
          });
          slideIcons.forEach((slideIcon) => {
            slideIcon.classList.remove("active");
          });

          slideNumber++;

          if(slideNumber > (numberOfSlides - 1)){
            slideNumber = 0;
          }

          slides[slideNumber].classList.add("active");
          slideIcons[slideNumber].classList.add("active");
        });

        prevBtn.addEventListener("click", () => {
          slides.forEach((slide) => {
            slide.classList.remove("active");
          });
          slideIcons.forEach((slideIcon) => {
            slideIcon.classList.remove("active");
          });

          slideNumber--;

          if(slideNumber < 0){
            slideNumber = numberOfSlides - 1;
          }

          slides[slideNumber].classList.add("active");
          slideIcons[slideNumber].classList.add("active");
        });

        var playSlider;

        var repeater = () => {
          playSlider = setInterval(function(){
            slides.forEach((slide) => {
              slide.classList.remove("active");
            });
            slideIcons.forEach((slideIcon) => {
              slideIcon.classList.remove("active");
            });

            slideNumber++;

            if(slideNumber > (numberOfSlides - 1)){
              slideNumber = 0;
            }

            slides[slideNumber].classList.add("active");
            slideIcons[slideNumber].classList.add("active");
          }, 5000);
        }
        repeater();

        slider.addEventListener("mouseover", () => {
          clearInterval(playSlider);
        });

        slider.addEventListener("mouseout", () => {
          repeater();
        });
      }

    slide(document.getElementById("sliderImage"));
    slide(document.getElementById("sliderVideo"));

    </script>

</html>