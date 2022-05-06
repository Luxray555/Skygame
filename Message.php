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
    echo '
    <div class="container">
    <div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Message</h4>
            </div>
          </div>
          <div class="inbox_chat">';
            $stmt=$bdd->prepare("SELECT idUtilisateur,pseudo,photo,civilite FROM utilisateurs WHERE idUtilisateur IN (SELECT IF(idUtilisateur1=?,idUtilisateur2,idUtilisateur1) FROM amis  WHERE (idUtilisateur1=? OR idUtilisateur2=?) AND demande=1) ORDER BY pseudo DESC");
            $stmt->execute([$user['idUtilisateur'],$user['idUtilisateur'],$user['idUtilisateur']]);
            $amisTotal=$stmt->fetchAll();
            for($i=0;$i<count($amisTotal);$i++){
                echo '
                <form class="chat_list ';
                if(isset($_SESSION['idAmi'])){
                  $_POST['idAmi']=$_SESSION['idAmi'];
                  unset($_SESSION['idAmi']);
                }
                if(isset($_POST['idAmi']) ){
                    if($_POST['idAmi']==$amisTotal[$i]['idUtilisateur']){
                        echo 'active_chat';
                    }
                }else{
                    if($i==0){
                        $_POST['idAmi']=$amisTotal[$i]['idUtilisateur'];
                        echo 'active_chat';
                    }
                }
                echo '" action="Message" method="POST">
                    <input type="hidden" name="idAmi" value="'.$amisTotal[$i]['idUtilisateur'].'">
                    <button type="submit" class="chat_people">
                    <div class="chat_img"> <img src="Public/Images/profil/';
                    imgProfil($amisTotal[$i]);
                    echo '.jpg" alt="Photo de profil de'.$amisTotal[$i]['pseudo'].'"> </div>
                    <div class="chat_ib">';
                    $stmt=$bdd->prepare("SELECT * FROM messages WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur2=? AND idUtilisateur1=?) ORDER BY dateMessage DESC LIMIT 1");
                    $stmt->execute([$user['idUtilisateur'],$amisTotal[$i]['idUtilisateur'],$user['idUtilisateur'],$amisTotal[$i]['idUtilisateur']]);
                    $lastMsg =$stmt->fetch();
                        echo '<h5>'.$amisTotal[$i]['pseudo'];
                        if($lastMsg!=false){
                            echo '<span class="chat_date">'.strftime("%d ",strtotime($lastMsg['dateMessage'])).ucwords(substr(strftime("%B",strtotime($lastMsg['dateMessage'])),0,3)).'</span>';
                        }
                        echo '</h5>';
                    if($lastMsg!=false){
                        echo '<p ';
                        if($lastMsg['vuMessage']==0 && $lastMsg['idUtilisateur2']==$user['idUtilisateur']){
                          echo 'style="color:#d66060;"';
                        }
                        echo '>'.substr($lastMsg['message'],0,35);
                        if(strlen($lastMsg['message'])>35){
                            echo '...';
                        }
                        echo '</p>';
                    }else{
                        echo'<p>Aucun Message</p>';
                    }    
                    echo '</div>
                    </button>
                </form>
                ';
            }
        echo '</div>
        </div>
        <div class="mesgs" id="msg">';
        if(isset($_POST['idAmi'])){
          $stmt=$bdd->prepare("SELECT * FROM amis WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur2=? AND idUtilisateur1=?) LIMIT 1");
          $stmt->execute([$user['idUtilisateur'],$_POST['idAmi'],$user['idUtilisateur'],$_POST['idAmi']]);
          $verifAmi =$stmt->fetchAll();
          if($verifAmi!=false){
            echo '<div class="msg_history">';
              $stmt=$bdd->prepare("SELECT * FROM messages WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur2=? AND idUtilisateur1=?) ORDER BY dateMessage ASC");
              $stmt->execute([$user['idUtilisateur'],$_POST['idAmi'],$user['idUtilisateur'],$_POST['idAmi']]);
              $msg =$stmt->fetchAll();
              if($msg){
                $stmt=$bdd->prepare("UPDATE messages SET vuMessage=1 WHERE idUtilisateur1=? && idUtilisateur2=?");
                $stmt->execute([$_POST['idAmi'],$user['idUtilisateur']]);
                $stmt=$bdd->prepare("SELECT idUtilisateur,pseudo,photo,civilite FROM utilisateurs WHERE idUtilisateur=?");
                $stmt->execute([$_POST['idAmi']]);
                $ami=$stmt->fetch();
                  for($i=0;$i<count($msg);$i++){
                      if($msg[$i]['idUtilisateur1']==$user['idUtilisateur']){
                          echo '
                          <div ';
                          if($i==count($msg)-1){
                            echo 'id="lastMsg"';
                          }
                          echo ' class="outgoing_msg">
                              <div class="sent_msg">
                                  <p>'.nl2br($msg[$i]['message']).'</p>
                                  <span class="time_date">'.ucwords(strftime("%A %d %B | ",strtotime($msg[$i]['dateMessage']))).date("H:i:s",strtotime($msg[$i]['dateMessage'])).'</span>
                              </div>
                          </div>';
                      }else{
                          //("%A %d %B %G");
                          echo '
                          <div ';
                          if($i==count($msg)-1){
                            echo 'id="lastMsg"';
                          }
                          echo ' class="incoming_msg">
                              <div class="incoming_msg_img"> <a href="Profil.php?idUtilisateur='.$ami['idUtilisateur'].'"><img src="Public/Images/profil/';
                              imgProfil($ami);
                              echo '.jpg" alt="sunil"></a> </div>
                              <div class="received_msg">
                                  <div class="received_withd_msg">
                                      <p>'.nl2br($msg[$i]['message']).'</p>
                                      <span class="time_date">'.ucwords(strftime("%A %d %B | ",strtotime($msg[$i]['dateMessage']))).date("H:i:s",strtotime($msg[$i]['dateMessage'])).'</span>
                                  </div>
                              </div>
                          </div>
                          ';
                      }
                  }
              }else{
                  echo '
                    <h1>Aucun message</h1>
                    <style>
                    .msg_history{
                      display: flex;
                      align-items: center;
                      justify-content:center;
                    }
                    </style>
                ';
              }
        }else{
          echo '<h1>Vous n'."'".'étes pas amis</h1>
          <style>
            .mesgs{
              display: flex;
              align-items: center;
              justify-content:center;
            }
          </style>';
        }
            echo'
            </div>
          <div class="type_msg">
            <form class="input_msg_write" action="FonctionPHP/EnvoieMessage.php" method="POST">
              <input type="hidden" name="idAmi" value="'.$_POST['idAmi'].'">
              <textarea rows="2" name="message" class="write_msg" placeholder="Type a message"></textarea>
              <button type="submit" class="msg_send_btn" type="button"><img src="Public/Images/icon/sendMessage.png"></button>
            </form>
          </div>';
        }else{
          echo '
                <h1>Vous n'."'".'avez pas d'."'".'ami</h1>
                    <style>
                    .mesgs{
                      display: flex;
                      align-items: center;
                      justify-content:center;
                    }
                    </style>
                ';
        }
        echo '</div>
      </div>
    </div>
    </div>';
    }else{
        echo "
        <div class='no-access-page'>
			<h1 >Vous n'avez pas accès à cette page</h1>
			<button><a href='index.php'>Accueil</a></button>
		</div>
        ";
    }
        include "footer.php";
    ?>
    </main>
    </body>
    <?php
    if(isset($_POST['idAmi'])){
      echo'
      <script>
        const scrollMsg = document.querySelector(".msg_history");
        const output = document.getElementById("lastMsg");
        scrollMsg.scroll(0,100000);
        setInterval(function(){
          var httpr = new XMLHttpRequest(); 
          httpr.open("POST", "FonctionPHP/GenerateChat.php");
				  httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				  httpr.send("idUtilisateur1="+';
          if(isset($user)){
            echo $user['idUtilisateur'];
          }
          echo '+"&idUtilisateur2="+';
          if(isset($_POST['idAmi'])){
            echo $_POST['idAmi'];
          }
          echo ');
          httpr.onload = function(){
            document.querySelector(".msg_history").innerHTML = httpr.responseText;
          }
        },3000);
    </script>';
    }
    ?>
</html>