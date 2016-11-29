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

  $sql = "(SELECT COUNT(*) FROM movies_user_note WHERE id_movie = :id_movie AND id_user = :id_user)";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id_movie',$r_POST['id'],PDO::PARAM_INT);
  $query->bindValue(':id_user',$_SESSION['user']['id'],PDO::PARAM_INT);
  $query->execute();
  $deja_vote = $query->fetchColumn();

  if($deja_vote == 0){
    $sql = "INSERT INTO movies_user_note (id_movie,id_user,note,created_at,status) VALUES (:id_movie,:id_user,:note,NOW();1)";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id_movie',$r_POST['id'],PDO::PARAM_INT);
    $query->bindValue(':id_user',$_SESSION['user']['id'],PDO::PARAM_INT);
    $query->bindValue(':note',$r_POST['note'],PDO::PARAM_INT);
    if($query->execute()){
      $error['success'] = true;
      $error['message'] = 'Vote enregistrer';
    }else{
      $error['success'] = false;
      $error['message'] = 'Erreur lors de l\'ajout';
    }
  }else{
    $error['success'] = false;
    $error['message'] = 'Vous avez deja voter';
  }
}else{
  $error['success'] = false;
  $error['message'] = 'Donnée manquante';
}
return showJson($error)
;
 ?>
