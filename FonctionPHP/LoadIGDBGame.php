<?php
require_once "../Setup/database.php";
require 'phpFunction.php';

if(isset($_POST)){
  require_once "../RessourceAPI/IGDB/src/class.igdb.php";

  $igdb = new IGDB("e19o82j85kk6ghwi039ny07xi8stf5", verifyAccessToken($bdd));
  $builder = new IGDBQueryBuilder();
  if(isset($_POST['limit']) && isset($_POST['platforms']) && isset($_POST['genres']) && isset($_POST['custom_where'])){
    $platformes_total = $_POST['platforms'];
    $genres_total = $_POST['genres'];
    $custom_where=$_POST['custom_where'];
      $options = array(
        "fields" => "id,name,cover.*,genres.name,platforms.name,summary",
        "limit" => $_POST['limit'],
        "sort" => $_POST['sort'],
        "custom_where" => "platforms =($platformes_total) & genres =($genres_total) & $custom_where",
      );
      try {
        $query = $builder->options($options)->build();
      } catch (IGDBInvaliParameterException $e) {
        echo $e->getMessage();
      }
      $game = $igdb->game($query);
      echo json_encode($game);
  }elseif(isset($_POST['search']) && isset($_POST['platforms']) && isset($_POST['genres'])){
    $platformes_total = $_POST['platforms'];
    $genres_total = $_POST['genres'];
    if(!empty($_POST['search'])){
      $options = array(
        "search" => $_POST['search'],
        "limit" => 500,
        "fields" => "id,name,cover.*,genres.name,platforms.name,summary,screenshots.*",
        "custom_where" => "platforms =($platformes_total) & genres =($genres_total)",
      );
    }else{
      $options = array(
        "limit" => 500,
        "fields" => "id,name,cover.*,genres.name,platforms.name,summary,screenshots.*",
        "custom_where" => "platforms =($platformes_total) & genres =($genres_total)",
      );
    }
      try {
        $query = $builder->options($options)->build();
      } catch (IGDBInvaliParameterException $e) {
        echo $e->getMessage();
      }
      $game = $igdb->game($query);
      echo json_encode($game);
  }
}
  ?>