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
  $sql = "INSERT INTO movies_user_liste (id_movie,id_user) VALUES (:id_movie,:id_user)";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id_movie',$r_POST['id'],PDO::PARAM_INT);
  $query->bindValue(':id_user',$_SESSION['user']['id'],PDO::PARAM_INT);
  if($query->execute()){
    $error['success'] = true;
  }else{
    $error['success'] = false;
  }
}else{
  $error['success'] = false;
}
return showJson($error)
;
 ?>
