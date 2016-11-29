<?php
session_start();
include ('functions.php');
if(!isLogged()) {
  header('location: ../connexion.php');
  exit;
}
$error = array();
if ($_POST) {
  $r_POST = nettoyage($_POST);

    global $pdo;

    $sql = "DELETE FROM movies_user_liste WHERE id_movie = :id_movie AND id_user = :id_user";
    $query = $pdo->prepare($sql);
    $query->bindvalue(':id_movie',$r_POST['id'],PDO::PARAM_INT);
    $query->bindvalue(':id_user',$_SESSION['user']['id'],PDO::PARAM_INT);
    if ($query->execute()) {
      $error['success'] = true;
      $error['message'] = 'tout est ok';
    }else {
      $error['success'] = false;
      $error['message'] = 'requete buguer';

    }
} else{
  $error['success'] = false;
  $error['message'] = 'manque des donnees';
}
return showJson($error);
?>
