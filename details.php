<?php
include 'includes/pdo.php';
include 'includes/functions.php';

$error = array();

if (!empty($_GET['slug'])) {


  $slug = $_GET['slug'];

  $sql = "SELECT * FROM movies_full WHERE slug = :slug";
  $query = $pdo->prepare($sql);
  $query->bindvalue(":slug",$slug,PDO::PARAM_STR);
  $query->execute();
  $movie = $query->fetch();

  if (!empty($movie['slug'])) {
    echo $movie['title'];
    echo '<br>';
    echo $movie['slug'];
    echo '<br>';
    echo $movie['year'];
    echo '<br>';
    echo '<img src="posters/'.$movie['id'].'.jpg">';
    echo '<br>';
    echo $movie['genres'];
    echo '<br>';
    echo $movie['plot'];
    echo '<br>';
    echo $movie['directors'];
    echo '<br>';
    echo $movie['cast'];
    echo '<br>';
    echo $movie['rating'];
    echo '<br>';
    echo $movie['popularity'];
    print_r($movie['id']);
  } else {
    $error['id'] = "n'est pas dans la bdd";
    print_r($error);
  }
} else {
  header('Location: index.php');
}







include 'includes/header.php';
?>








<?php include 'includes/footer.php'; ?>
