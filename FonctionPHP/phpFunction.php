<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
  $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
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

function randomMdp(){
  $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  $randstring = '';
  $randlen = random_int(6,25);
  for ($i = 0; $i < $randlen; $i++) {
    $randstring .= $characters[rand(0, strlen($characters)-1)];
  }
  return $randstring;
}

function smtpmailer($to, $from, $from_name, $subject, $body){
  require '../RessourceAPI/PHPMailer/Exception.php';
  require '../RessourceAPI/PHPMailer/PHPMailer.php';
  require '../RessourceAPI/PHPMailer/SMTP.php';

  $mail = new PHPMailer(true);
  try {
    //Server settings                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'skygamecorporation@gmail.com';                     //SMTP username
    $mail->Password   = 'SkygameCorporation10';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($from, $from_name);
    $mail->addAddress($to);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    return 'Message has been sent';
} catch (Exception $e) {
    return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

function mailExist($email,$bdd){
  $stmt = $bdd->prepare("SELECT idUtilisateur FROM utilisateurs WHERE email=?");
  $stmt->execute([$_POST['email']]); 
  $user = $stmt->fetch() ;
  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
      echo "<p class='error'>Format du mail incompatible.</p>";
  }
  if ($user) {
     return true;
  }else{
      false;
  }
}
?>