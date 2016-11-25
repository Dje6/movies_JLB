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



  print_r($movie['id']);
} else {
  header('Location: index.php');
}







include 'includes/header.php';
?>








<?php include 'includes/footer.php'; ?>
