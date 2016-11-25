<?php
include 'includes/pdo.php';
include 'includes/functions.php';
?>


<div class="affichage">

<?php
$error = array();

if (!empty($_GET['slug'])) {


  $slug = $_GET['slug'];

  $sql = "SELECT * FROM movies_full WHERE slug = :slug";
  $query = $pdo->prepare($sql);
  $query->bindvalue(":slug",$slug,PDO::PARAM_STR);
  $query->execute();
  $movie = $query->fetch();

  include 'includes/header.php';



  if (!empty($movie['slug'])) {
    echo '<h1>' . $movie['title'] . '</H1>';
    echo '<br>';
    echo '<h2>' . $movie['slug'] . '<H2>';
    echo '<br>';
    // echo $movie['year'];
    // echo '<br>';
    echo '<img src="posters/'.$movie['id'].'.jpg">';
    echo '<br>';
    echo '<p class="detailcss">' . $movie['genres'] . '<p>';
    echo '<br>';
    echo '<p class="detailcss">' . $movie['plot'] . '<p>';
    echo '<br>';
    echo '<p class="detailcss">' . $movie['directors'] . '<p>';
    echo '<br>';
    echo '<p class="detailcss">' . $movie['cast'] . '<p>';
    echo '<br>';
    // echo $movie['rating'];
    // echo '<br>';
    // echo $movie['popularity'];
    print_r($movie['id']);
  } else {
    $error['id'] = "N'est pas dans la bdd";
    print_r($error);
  }
} else {
  header('Location: index.php');
}

?>
  <div class="evaluation">
    <h4>Moyenne des évaluations</h4>
    <h2><?php   echo $movie['popularity']; ?> <small class="red">Popularité</small></h2>
    <h2><?php   echo $movie['rating']; ?> <small class="red">/ 100</small></h2>
  </div>
</div>








<?php include 'includes/footer.php'; ?>
