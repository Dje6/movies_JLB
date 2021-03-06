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

if(empty($movies)){
 echo '<h2 class="text-center">Il n\'y a pas de films dans votre liste </h2>';
 echo '<br>';
 echo '<h2 class="text-center">Cliquez <a href="index.php">ici</a></h2>';
}else{
// Display des films
    foreach ($movies as $key => $value) {
      if(file_exists("posters/". $value['id']. ".jpg")) { ?>

        <div class="col-xs-6 col-sm-4 col-md-3" id="<?php echo $value['id']; ?>">
          <a href="details.php?slug=<?php echo $value['slug']; ?>">
            <img class="displayAffiches" src="posters/<?php echo $value['id']; ?>.jpg">
          </a>
          <button class="btn btn-danger btn-xs removeList" id="<?php echo $value['id']; ?>">Retirer ce film de ma liste</button>
        </div>


        <!-- Si le poster existe pas, on affiche placeholder -->
    <?php } else { ?>
        <div class="col-xs-6 col-sm-4 col-md-3" id="<?php echo $value['id']; ?>">
            <a href="details.php?slug=<?php echo $value['slug']; ?>"><img class="displayAffiches" src="http://placehold.it/220x300"></a>
            <button class="btn btn-danger btn-xs removeList" id="<?php echo $value['id']; ?>">Retirer ce film de ma liste</button>
        </div>
    <?php }
    }
  }
?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
