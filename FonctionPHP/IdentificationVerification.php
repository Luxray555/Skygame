<?php
require_once "../Setup/database.php";

if(isset($_POST['pseudo'])){
  $stmt = $bdd->prepare("SELECT idUtilisateur FROM utilisateurs WHERE pseudo=?");
  $stmt->execute([$_POST['pseudo']]); 
  $user = $stmt->fetch() ;
  if ($user) {
    echo '<p class="error">Pseudo déjà utilisé.</p>';
  }
}

if(isset($_POST['email']) && !isset($_POST['mdp'])){
  $stmt = $bdd->prepare("SELECT idUtilisateur FROM utilisateurs WHERE email=?");
  $stmt->execute([$_POST['email']]); 
  $user = $stmt->fetch() ;
  if ($user) {
    echo '<p class="error">Email déjà utilisé.</p>';
  }
}

if(isset($_POST['email']) && isset($_POST['mdp'])){
	$stmt = $bdd->prepare("SELECT password FROM utilisateurs WHERE email=?");
	$stmt->execute([$_POST['email']]);
	$user = $stmt->fetch() ;
	if (!$user || $user['password'] != sha1($_POST['mdp'])) {
    echo "<p class='error'>Email ou mot de passe éronné.</p>";
  }
}
?>