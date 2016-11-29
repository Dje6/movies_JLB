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

  $sql = "(SELECT AVG(note) FROM movies_user_note WHERE id_movie = :id_movie)";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id_movie',$r_POST['id'],PDO::PARAM_INT);
  $query->execute();
  $moyenne_vote = $query->fetchColumn();

      $error['success'] = true;
      $error['texte'] = $moyenne_vote;
      $error['etoile'] = etoile_rating_return(($moyenne_vote*20),100);

}else{
  $error['success'] = false;
  $error['message'] = 'Donnée manquante';
}
return showJson($error)
;
 ?>
