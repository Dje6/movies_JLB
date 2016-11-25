<?php
include 'includes/pdo.php';
include 'includes/functions.php';

 $sql = "SELECT * FROM movies_full ORDER BY RAND() LIMIT 6";
 $query = $pdo->prepare($sql);
 $query->execute();
 $movies = $query->fetchAll();







include 'includes/header.php';





?>

        <!-- Titre et filtres -->
<div class="titrePage container-fluid">
  <div class="row">
    <h1>Consultez les films proposés</h1>
  </div>
  <div class="row">
    <!-- Premier button catégories -->
    <div class="btn-group">
      <button class="btn btn-warning btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catégorie<span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><input type="checkbox" name="categorie1">Fantastique</li>
        <li>TEST</li>
        <li></li>
      </ul>
    </div>
  </div>
  <!-- Deuxieme button années -->

</div>

<!-- Listing des affiches de films -->
<br>
<div class="container affichesFilms">
  <div class="row">
    <?php
      foreach ($movies as $movie) { ?>
        <div class="col-xs-4 col-md-4">
          <?php echo '<a href="details.php?slug='.$movie['slug'].'"><img src="posters/'.$movie['id'].'.jpg"></a>'; ?>
        </div>
<?php } ?>
  </div>
</div>

<!-- Button + de films -->
<br>
<div class="container">
  <div class="row">
    <a href="index.php"><button type="button" class="btn btn-warning btn-lg btn-block">
      <h2 class="plusFilm">Plus de films !</h2>
    </button></a>
  </div>
</div>





<?php include 'includes/footer.php';
