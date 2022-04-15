<?php

function expiredSession(int $time){
if($time + 1800 > time()){
    return time();
}else{
	$_SESSION['chargement'] = 'deconnexion par inactivité';
  header('Location: Chargement.php');
}
}

function informationUser(int $id, PDO $bdd){
	$stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE idUtilisateur=?");
  $stmt->execute([$id]);
  $user = $stmt->fetch();
  if($user!=false){
    return $user;
  }else{
    session_destroy();
    return null;
  }
}

function informationProfil(int $id, PDO $bdd){
	$stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE idUtilisateur=?");
  $stmt->execute([$id]);
  $user = $stmt->fetch();
  if($user!=false){
    return $user;
  }else{
    return null;
  }
}

function verifImageIGDB($img){
  if(isset($img)){
    return 'https://images.igdb.com/igdb/image/upload/t_1080p/'.$img->image_id.'.jpg';
  }else{
    return 'Public/Images/background/no-cover-image.png';
  }
}
function afficheJeuxCatalogue(){
  echo'<li class="game">
  <div class="block">
      <div class="info">
          <h4></h4>
          <p></p>
          <div class="platforms">
              <h4>Platforme(s) :</h4>
          </div>
          <div class="genres">
              <h4>Genre(s) :</h4>
          </div>
          <a href=""><button>Aller à la page</button></a>
      </div>
      <img class="gameImg"src="Public/Images/icon/chargement.gif">
</div>
<h3 class="title-game"></h3>
</li>';
}

function verifyAccessToken($bdd){
  date_default_timezone_set("Europe/Paris");
  $stmt = $bdd->prepare("SELECT * FROM access_token");
  $stmt->execute();
  $token_information = $stmt->fetch();
  if($token_information==false){
    try {
      $access_token = IGDBUtils::authenticate('e19o82j85kk6ghwi039ny07xi8stf5', 'alqwtznqef5oa9ih1ze2hh98ig2lh6');
    }catch (Exception $e) {
      echo $e->getMessage();
    }
    $stmt = $bdd->prepare("INSERT INTO access_token (token,expireTokenTime) VALUES (?,?)");
    $stmt->execute([$access_token->access_token,date('Y-m-d H:i:s',$access_token->expires_in+time()-500)]);
    return $access_token->access_token;
  }else{
    $actualTime = time();
    if(strtotime($token_information['expireTokenTime'])<$actualTime){
      try {
        $access_token = IGDBUtils::authenticate('e19o82j85kk6ghwi039ny07xi8stf5', 'alqwtznqef5oa9ih1ze2hh98ig2lh6');
      }catch (Exception $e) {
        echo $e->getMessage();
      }
      $stmt = $bdd->prepare("UPDATE access_token SET token=?, expireTokenTime=?");
      $stmt->execute([$access_token->access_token,date('Y-m-d H:i:s',$access_token->expires_in+time()-500)]);
      return $access_token->access_token;
    }else{
      return $token_information['token'];
    }
  }
}

function notifJs($value){
  echo '
    setTimeout(() => {
      document.getElementById("error").style.opacity = 1;
		  document.getElementById("error").style.transform = "scale(1.2)";
    },100);
		setTimeout(() => {
			document.getElementById("error").style.opacity = 0;
			document.getElementById("error").style.transform = "scale(0.1) translateY(-50%)";
			error=true;
			document.getElementById("error").removeChild(document.querySelector("#error .error"));
		},5000);';
}

function randomKey(){
  $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randstring = '';
  for ($i = 0; $i < 12; $i++) {
    $randstring .= $characters[rand(0, strlen($characters)-1)];
  }
  return $randstring;
}

function randomVerifCode(){
  $characters = '0123456789';
  $randstring = '';
  for ($i = 0; $i < 4; $i++) {
    $randstring .= $characters[rand(0, strlen($characters)-1)];
  }
  return $randstring;
}

function smtpmailer($to, $from, $from_name, $subject, $body){
  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPAuth = true; 

  $mail->SMTPSecure = 'ssl';
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 465;  
  $mail->Username = 'skygamecorporation@gmail.com';
  $mail->Password = 'SkygameCorporation2022';

  $mail->IsHTML(true);
  $mail->From="skygameprojet@gmail.com";
  $mail->FromName=$from_name;
  $mail->Sender=$from;
  $mail->AddReplyTo($from, $from_name);
  $mail->Subject = $subject;
  $mail->Body = $body;
  $mail->AddAddress($to);
  if(!$mail->Send())
  {
      $error ="Please try Later, Error Occured while Processing...";
      return $error; 
  }
  else 
  {
      $error = "Thanks You !! Your email is sent.";  
      return $error;
  }
}

function keyArrayExistArray($array,$key_array){
  $e = 0;
  for($i=0;$i<count($array);$i++){
      foreach($key_array as $key => $value){
          if($array[$i] == $key){
              $e++;
          }
      }
  }
  if($e==count($array)){
      return true;
  }else{
      return false;
  }
}

function imgProfil($user){
    if($user['photo']==null){
        echo 'image-profil-';
      if($user['civilite']==0){
        echo 'male';
      }else{
        echo 'female';
      }
    }else{
      echo 'pp'.$user['photo'];
    }
}
?>