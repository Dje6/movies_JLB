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

  $sql = "(SELECT COUNT(*) FROM movies_user_liste WHERE id_movie = :id_movie AND id_user = :id_user)";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id_movie',$r_POST['id'],PDO::PARAM_INT);
  $query->bindValue(':id_user',$_SESSION['user']['id'],PDO::PARAM_INT);
  $query->execute();
  $a_voir = $query->fetchColumn();

  if($a_voir == 0){
    $sql = "INSERT INTO movies_user_liste (id_movie,id_user) VALUES (:id_movie,:id_user)";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id_movie',$r_POST['id'],PDO::PARAM_INT);
    $query->bindValue(':id_user',$_SESSION['user']['id'],PDO::PARAM_INT);
    if($query->execute()){
      $error['success'] = true;
      $error['message'] = 'Film ajouté! Y acceder ?';
    }else{
      $error['success'] = false;
      $error['message'] = 'Erreur lors de l\'ajout';
    }
  }else{
    $error['success'] = false;
    $error['message'] = 'Ce film fait deja partie de la liste';
  }
}else{
  $error['success'] = false;
  $error['message'] = 'Donnée manquante';
}
return showJson($error)
;
 ?>
