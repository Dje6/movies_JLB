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

    $sql = "DELETE FROM movies_user_liste WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindvalue(':id',$r_POST['id'],PDO::PARAM_INT);
    if ($query->execute()) {
      $error['success'] = true;
    }else {
      $error['success'] = false;
    }
} else{
  $error['success'] = false;
}
return showJson($error);
?>
