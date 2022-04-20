<?php
setlocale (LC_TIME, 'fr_FR.utf8','fra');
error_reporting(E_ALL);
$page = array( "Accueil" => 0, "Catalogue" => 1, "Bibliotheque" => 2, "Support" => 3, "Inscription" => 4, "Connexion" => 5, "Profil" => 6, "PageJeu" => 7 ,"Boutique" => 8,"VerifMail" => 9,"Amis" => 10,"NotFound" => 11,"Message" => 12,"MotDePasseOublier"=> 13);
$URI=explode(".",explode("?",explode("/",$_SERVER['REQUEST_URI'])[2])[0])[0];
if(isset($page[$URI])){
  $header=$page[$URI];
}
?>
<head>
    <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="Public/Images/icon/logo.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="Public/Images/icon/logo.ico" type="image/x-icon"/>
    <title>
      Skygame
      <?php
      if((isset($header) && $header!=7 && $header!=6) || !isset($header)){
        echo ' - '.$URI;
      }else{
        if($header==7 && isset($game)){
          echo ' - '.$game[0]->name;
        }
        if($header==6 && $profil!=false){
          echo ' - '.$profil['pseudo'];
        }
      }
      ?></title>
    <link rel="stylesheet" type="text/css" href="Public/css/General.css">
    <?php
    if(isset($page[$URI])){
      echo '<link rel="stylesheet" type="text/css" href="Public/css/'.$URI.'.css">';
    }
    ?>
    
  </head>
  <body>
  <?php
    if(isset($user['idUtilisateur']) && $user['verifMail'] == 1){
      echo '<div class="skycoin">
              <span class="coin">'.$user['skyCoin'].'<img src="Public/Images/icon/skyCoin.png" alt="Skycoin"></span>
            </div>';
    }
  ?>
<nav class="sidebar close">
        <header>
        <div class="image-text" style ="margin-bottom:20px;">
              <span class="image">
                <img src="Public/Images/icon/logo.png" alt="Logo Skygame">
              </span>
              <div class="text logo-text">
                <span class="name" style="font-family:RaceSportFree;font-size:21px;">Skygame</span>
              </div>
            </div>
                <?php
                if(isset($user['idUtilisateur']) && $user['verifMail'] == 1){
                    echo '<div class="image-text" style="background: #131313;border-radius:10px;padding:10px 0px;">
                    <span class="image">
                            <img src="Public/Images/profil/';
                    imgProfil($user);
                    echo '.jpg" alt="Photo de Profil">
                          </span>';
                          echo '<div class="text logo-text">
                              <span class="name">'.$user['pseudo'].'</span>
                              <span class="coin"><img src="Public/Images/icon/skyCoin.png" alt="Bouton Skycoin"> '.$user['skyCoin'].' Skycoin</span>
                            </div>
                          </div>';
                  }
                    ?>
            <i class='bx toggle'><img src="Public/Images/icon/arrow.png" alt="Bouton Fléche"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link" <?php
                    if(isset($header) && $header==0){
                        echo 'id="active"';
                    }
                    ?>>
                        <a href="index.php">
                            <i class='bx icon' ><img width="35px" src="Public/Images/icon/home.png" alt="Bouton Accueil"></i>
                            <span class="text nav-text">Accueil</span>
                        </a>
                    </li>

                    <li class="nav-link" <?php
                    if(isset($header) && $header==1){
                        echo 'id="active"';
                    }
                    ?>>
                        <a href="Catalogue.php">
                            <i class='bx icon' ><img width="35px" src="Public/Images/icon/catalogue.png" alt="Bouton Catalogue")></i>
                            <span class="text nav-text">Catalogue</span>
                        </a>
                    </li>
                    <?php
                      if(isset($_SESSION['idUtilisateur']) && $user['verifMail']==1){
                        echo '<li class="nav-link"';
                          if(isset($header) && $header==2){
                            echo 'id="active"';
                          }
                          echo '>
                                  <a href="Bibliotheque.php"><i class="bx icon" ><img width="35px" src="Public/Images/icon/bibliotheque.png" alt="Bouton Bibliothèque"></i>
                                  <span class="text nav-text">Bibliotheque</span>
                                  </a>
                                </li>';
                        echo '<li class="nav-link"';
                          if(isset($header) && $header==10){
                             echo 'id="active"';
                          }
                          echo '>
                            <a href="Amis.php"><i class="bx icon" ><img width="35px" src="Public/Images/icon/amis.png" alt="Bouton Amis"></i>
                              <span class="text nav-text">Amis</span>
                            </a>
                          </li>';
                        echo '<li class="nav-link"';
                          if(isset($header) && $header==12){
                             echo 'id="active"';
                          }
                          echo '>
                            <a href="Message.php"><i class="bx icon" ><img width="35px" src="Public/Images/icon/messages.png" alt="Bouton Messages"></i>
                              <span class="text nav-text">Messages</span>
                            </a>
                          </li>';
                        echo '<li class="nav-link"';
                          if(isset($header) && $header==8){
                            echo 'id="active"';
                          }
                          echo '>
                            <a href="Boutique.php"><i class="bx icon" ><img width="35px" src="Public/Images/icon/skyCoin.png" alt="Bouton Boutique"></i>
                              <span class="text nav-text">Skycoin</span>
                            </a>
                          </li>';
                        }
                    ?>

                    <li class="nav-link" <?php
                    if(isset($header) && $header==3){
                        echo 'id="active"';
                    }
                    ?>>
                        <a href="Support.php">
                            <i class='bx icon' ><img width="35px" src="Public/Images/icon/support.png" alt="Bouton Support"></i>
                            <span class="text nav-text">Support</span>
                        </a>
                    </li>

                </ul>
            </div>
              <?php
                if(isset($user['idUtilisateur']) && $user['verifMail']==1){
                  if(!isset($_SESSION['chargement'])){
                    $_SESSION['chargement']='deconnexion';
                  }
                  echo '<div style="margin-bottom:20px;" class="bottom-content">
                          <li ';
                    if(isset($header) && $header==6 && $_SESSION['idUtilisateur']==$_GET['idUtilisateur']){
                        echo 'id="active"';
                    }
                  echo '>
                          <a href="Profil.php?idUtilisateur='.$user['idUtilisateur'].'">
                            <i class="bx icon"><img style="border-radius:10px;" width="35px" src="Public/Images/profil/';
                            imgProfil($user);
                            echo '.jpg" alt="Bouton profil"></i>
                            <span class="text logo-text">Mon Profil</span>
                          </a>
                        </li>
                        <li>
                          <a href="Chargement.php">
                            <i class="bx icon"><img width="35px"src="Public/Images/icon/deconnection.png" alt="Buuton Deconnexion"></i>
                            <span class="text logo-text">Deconnexion</span>
                          </a>
                        </li>
                      </div>';
                }else{
                  echo '<div class="bottom-content">
                          <li ';
                  if(isset($header) && $header==4){
                    echo 'id="active"';
                  }
                  echo '>
                          <a href="Inscription.php">
                            <i class="bx icon"><img style="border-radius:10px;" width="35px" src="Public/Images/icon/inscription.png" alt="Bouton Inscription"></i>
                            <span class="text nav-text">Inscription</span>
                          </a>
                        </li>
                        <li ';
                    if(isset($header) && $header==5){
                        echo 'id="active"';
                    }
                        echo '>
                          <a href="Connexion.php">
                            <i class="bx icon"><img width="35px"src="Public/Images/icon/connexion.png" alt="Bouton Connexion"></i>
                            <span class="text nav-text">Connexion</span>
                          </a>
                        </li>
                      </div>';
                }
              ?>
        </div>
    </nav>