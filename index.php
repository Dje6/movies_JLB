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
  <!-- filtres recherche -->
  <div class="row">
    <div class="container">
      <button id="showFiltres" type="button" class="btn btn-warning btn-lg">Filtres de recherche</button>
      <form class="filtresRecherche container" action="" method="GET">

        <div class="form-group col-md-4">
          <input type="text" name="searchbar" class="form-control" placeholder="Réalisateur, Titre...">
        </div>

        <div class="checkbox col-md-4">
          <input type="checkbox" name="genres[]" value="drama">Drama<br>
          <input type="checkbox" name="genres[]" value="thriller">Thriller<br>
          <input type="checkbox" name="genres[]" value="action">Action<br>
          <input type="checkbox" name="genres[]" value="adventure">Adventure<br>
          <input type="checkbox" name="genres[]" value="comedy">Comedy<br>
          <input type="checkbox" name="genres[]" value="short">Short<br>
          <input type="checkbox" name="genres[]" value="romance">Romance<br>
          <input type="checkbox" name="genres[]" value="sci-fi">Sci-Fi<br>
          <input type="checkbox" name="genres[]" value="mystery">Mystery<br>
          <input type="checkbox" name="genres[]" value="war">War<br>
          <input type="checkbox" name="genres[]" value="western">Western<br>
          <input type="checkbox" name="genres[]" value="horror">Horror<br>
          <input type="checkbox" name="genres[]" value="animation">Animation<br>
        </div>

        <div class="col-md-4">
          <select class="form-control" name="annees">
            <option value="">Années</option>
            <option value="1">1900-1950</option>
            <option value="2">1960</option>
            <option value="3">1970</option>
            <option value="4">1980</option>
            <option value="5">1990</option>
            <option value="6">2000</option>
            <option value="7">2010</option>
          </select>
          <br>
          <select class="form-control" name="popularite">
            <option value="">Popularité</option>
            <option value="1">0 - 20</option>
            <option value="2">20 - 40</option>
            <option value="3">40 - 60</option>
            <option value="4">60 - 80</option>
            <option value="5">80 - 100</option>
          </select>
        </div>

        <br>
        <button type="submit" name="submit" class="btn btn-warning">Chercher un film</button>
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
