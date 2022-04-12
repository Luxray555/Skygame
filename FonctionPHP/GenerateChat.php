<?php
    require_once "../Setup/database.php";
    require "phpFunction.php";
    session_start();
    setlocale (LC_TIME, 'fr_FR.utf8','fra');
    if(isset($_POST['idUtilisateur1']) && isset($_POST['idUtilisateur2'])){
              $stmt=$bdd->prepare("SELECT * FROM messages WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR (idUtilisateur2=? AND idUtilisateur1=?) ORDER BY dateMessage ASC");
              $stmt->execute([$_POST['idUtilisateur1'],$_POST['idUtilisateur2'],$_POST['idUtilisateur1'],$_POST['idUtilisateur2']]);
              $msg =$stmt->fetchAll();
              if($msg){
                $stmt=$bdd->prepare("SELECT idUtilisateur,pseudo,photo,civilite FROM utilisateurs WHERE idUtilisateur=?");
                $stmt->execute([$_POST['idUtilisateur2']]);
                $ami=$stmt->fetch();
                  for($i=0;$i<count($msg);$i++){
                      if($msg[$i]['idUtilisateur1']==$_POST['idUtilisateur1']){
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
                              <div class="incoming_msg_img"> <img src="Public/Images/profil/';
                              imgProfil($ami);
                              echo '.jpg" alt="sunil"> </div>
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
            }
        }
?>