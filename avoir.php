<?php
session_start();
  include 'includes/functions.php';
if(!isLogged()) {
  header('location: connexion.php');
  exit;
}
include 'includes/header.php'; ?>

<!-- Titre page -->
<div class="titrePage container-fluid">
  <div class="row">
    <h1>Ma liste de films à voir</h1>
  </div>
</div>

<hr>
<!-- Display des films à voir -->
<div class="container affichesFilms">
  <div class="row">
<?php
global $pdo;
$sql = "(SELECT mf.* FROM movies_user_liste AS mul LEFT JOIN movies_full AS mf
ON mf.id = mul.id_movie WHERE id_user = :id_user GROUP BY mul.id)";
$query = $pdo->prepare($sql);
$query->bindValue(':id_user',$_SESSION['user']['id'],PDO::PARAM_STR);
$query->execute();
$movies = $query->fetchAll();

foreach ($movies as $key => $value) {
  if(file_exists("posters/". $value['id']. ".jpg")) {
    echo  '<a href="details.php?slug='.$value['slug'].'"><img class="displayAffiches" src="posters/'.$value['id'].'.jpg"></a>';
  } else {
    echo '<a href="details.php?slug='.$value['slug'].'"><img class="displayAffiches" src="http://placehold.it/220x300"></a>';
  }
}
?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
