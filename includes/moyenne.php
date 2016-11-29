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

  $sql = "(SELECT AVG(note),COUNT(note) FROM movies_user_note WHERE id_movie = :id_movie)";
  $query = $pdo->prepare($sql);
  $query->bindValue(':id_movie',$r_POST['id'],PDO::PARAM_INT);
  $query->execute();
  $moyenne_vote = $query->fetchAll();
      $error['success'] = true;
      $error['texte'] = $moyenne_vote[0]['AVG(note)'] ;
      $suffix='';
      if($moyenne_vote[0]['COUNT(note)'] > 1){
        $suffix ='s';
      }
      $error['note'] = $moyenne_vote[0]['COUNT(note)'].' note'.$suffix ;
      $error['etoile'] = etoile_rating_return(($moyenne_vote[0]['AVG(note)']*20),100);

}else{
  $error['success'] = false;
  $error['message'] = 'Donnée manquante';
}
return showJson($error)
;
 ?>
