<?php
session_start();
include ('functions.php');
if(!isLogged()) {
  header('location: ../connexion.php');
  exit;
}
$error = array();
if($_POST)
{
  $r_POST = nettoyage($_POST);

  global $pdo;

  $sql = "(SELECT id,title,year,rating FROM movies_full WHERE id = :id )";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id',$r_POST['id'],PDO::PARAM_INT);
  $query->execute();
  $movie = $query->fetchAll();
  if($movie){

    $sql = "DELETE FROM movies_full WHERE id =:id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id',$movie[0]['id'],PDO::PARAM_INT);
    if($query->execute()){

      $error['success'] = true;
      $error['message'] = 'Film correctement supprimer';
      $error['id'] = $movie[0]['id'];
      $error['title'] = strip_tags(trim(str_replace(' ','-',str_replace('\'','-',$movie[0]['title']))));;
      $error['year'] = $movie[0]['year'];
      $error['rating'] = $movie[0]['rating'];
      $error['bouton'] = 'bouton';
      if(file_exists(realpath('../posters/').'\\'.$movie[0]['id'].'.jpg')){
        unlink(realpath('../posters/').'\\'.$movie[0]['id'].'.jpg');
      }

    }else{
      $error['success'] = false;
      $error['message'] = 'Probleme de suppression';
    }
  }else{
    $error['success'] = false;
    $error['message'] = 'Le film est introuvable';
  }
}else{
  $error['success'] = false;
  $error['message'] = 'donnee manquante';
}
return showJson($error);
 ?>
