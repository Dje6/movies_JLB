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
      <button class="btn btn-warning btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filtres de recherche<span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><input type="checkbox" name="categorie1">Fantastique</li>
        <li>TEST</li>
        <li></li>
      </ul>
    </div>
  </div>
  <!-- Deuxieme button années -->

</div>
<hr>

<!-- Listing des affiches de films -->
<br>
<div class="container affichesFilms">
  <div class="row">
    <?php
      foreach ($movies as $movie) { ?>
        <div class="col-xs-6 col-md-4">


          <?php


            if(file_exists("posters/". $movie['id']. ".jpg")) {
              echo  '<a href="details.php?slug='.$movie['slug'].'"><img class="displayAffiches" src="posters/'.$movie['id'].'.jpg"></a>';
            } else {
              echo '<a href="details.php?slug='.$movie['slug'].'"><img class="displayAffiches" src="http://placehold.it/220x300"></a>';
              // print_r ($size);
            }
           ?>
        </div>
<?php } ?>
  </div>
</div>
<hr>

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
