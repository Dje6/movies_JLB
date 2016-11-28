<?php
include 'includes/pdo.php';
include 'includes/functions.php';

// Sinon on affiche des films random frère
$sql = "SELECT * FROM movies_full ORDER BY RAND() LIMIT 6";
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();

$success = false;

if (!empty($_GET['submit'])) {

  $sql = "SELECT * FROM movies_full WHERE 1 = 1";
  if (!empty($_GET['searchbar'])){
    $sql .= "AND directors = :search AND title = :search";
  } elseif (!empty($_GET['genres[]'])){
    $sql .= "AND genres = :genres";
  } elseif (!empty($_GET['annees'])){
    $sql .= "AND annees = :annees";
  }
  echo $sql;
} 





include 'includes/header.php';





?>

        <!-- Titre et filtres -->
<div class="titrePage container-fluid">
  <div class="row">
    <h1>Consultez les films proposés</h1>
  </div>
  <!-- filtres recherche -->
  <div class="row">
    <div class="container">
      <button id="showFiltres" type="button" class="btn btn-warning btn-lg">Filtres de recherche</button>
      <form class="filtresRecherche container hidden" action="" method="GET">

        <div class="form-group">
          <input type="text" name="searchbar" class="form-control" placeholder="Auteur, Titre...">
        </div>

        <div class="checkbox">
          <input type="checkbox" name="categorie[]" value="drama">Drama<br>
          <input type="checkbox" name="categorie[]" value="thriller">Thriller<br>
          <input type="checkbox" name="categorie[]" value="action">Action<br>
          <input type="checkbox" name="categorie[]" value="adventure">Adventure<br>
          <input type="checkbox" name="categorie[]" value="comedy">Comedy<br>
          <input type="checkbox" name="categorie[]" value="short">Short<br>
          <input type="checkbox" name="categorie[]" value="romance">Romance<br>
          <input type="checkbox" name="categorie[]" value="sci-fi">Sci-Fi<br>
          <input type="checkbox" name="categorie[]" value="mystery">Mystery<br>
          <input type="checkbox" name="categorie[]" value="war">War<br>
          <input type="checkbox" name="categorie[]" value="western">Western<br>
          <input type="checkbox" name="categorie[]" value="horror">Horror<br>
          <input type="checkbox" name="categorie[]" value="animation">Animation<br>
        </div>

        <select class="form-control" name="annees">
          <option>Années</option>
          <option>1900-1950</option>
          <option>1960</option>
          <option>1970</option>
          <option>1980</option>
          <option>1990</option>
          <option>2000</option>
          <option>2010</option>
        </select>

        <br>
        <input type="submit" name="submit" value="Chercher un film">
      </form>
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
    <a href="index.php">
      <button type="button" class="btn btn-warning btn-lg btn-block">
        <h2 class="plusFilm">Plus de films !</h2>
      </button>
    </a>
  </div>
</div>





<?php include 'includes/footer.php';
