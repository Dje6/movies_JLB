<?php
include 'includes/pdo.php';
include 'includes/functions.php';

$error = array();

if (!empty($_GET['id'])) {


  $id = $_GET['id'];

  $sql = "SELECT * FROM movies_full WHERE id = :id";
  $query = $pdo->prepare($sql);
  $query->bindvalue(":id",$id,PDO::PARAM_INT);
  $query->execute();
  $movie = $query->fetch();

  if (!empty($movie['id'])) {
    //fais ts operations 1+1 = 2
  } else {
    $error['id'] = "n'est pas dans la bdd";
    print_r($error);
  }



  print_r($movie['id']);
} else {
  header('Location: index.php');
}







include 'includes/header.php';
?>








<?php include 'includes/footer.php'; ?>
