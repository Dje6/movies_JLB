<?php
session_start();
include 'includes/pdo.php';
include 'includes/functions.php';

// Sinon on affiche des films random frère


if (!empty($_GET['submit'])) {

  // $search_str = trim(strip_tags($_GET['searchbar']));
  $search = $_GET['searchbar'];
  $annees = $_GET['annees'];
  $popularity = $_GET['popularite'];

    $sql = "SELECT * FROM movies_full WHERE 1 = 1";
    if (!empty($_GET['searchbar'])){
      $sql .= " AND directors LIKE '%$search%' OR title LIKE '%$search%'";
    }
    if (!empty($_GET['genres'])){
      foreach ($_GET['genres'] as $selected) {
        $sql .= " AND genres LIKE '%$selected%' ";
      }
    }
    if (!empty($_GET['annees'])){
      $sql .= " AND year = $annees";
    }
    if (!empty($_GET['popularite'])){
      $sql .= " AND popularity = $popularity";
    }
    $sql .= " LIMIT 6";
    echo $sql;

    $query = $pdo->prepare($sql);
    $query->bindvalue(':search',$search,PDO::PARAM_STR);
    $query->execute();
    $movies = $query->fetchAll();


} else {
  $sql = "SELECT * FROM movies_full ORDER BY RAND() LIMIT 6";
  $query = $pdo->prepare($sql);
  $query->execute();
  $movies = $query->fetchAll();

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
      <form class="filtresRecherche container" action="" method="GET">

        <div class="form-group col-md-4">
          <input type="text" name="searchbar" class="form-control" placeholder="Réalisateur, Titre...">
        </div>

        <div class="checkbox col-md-4">
        <fieldset>
          <input type="checkbox" name="genres[]" value="Drama">Drama<br>
          <input type="checkbox" name="genres[]" value="Thriller">Thriller<br>
          <input type="checkbox" name="genres[]" value="Action">Action<br>
          <input type="checkbox" name="genres[]" value="Adventure">Adventure<br>
          <input type="checkbox" name="genres[]" value="Comedy">Comedy<br>
          <input type="checkbox" name="genres[]" value="Short">Short<br>
          <input type="checkbox" name="genres[]" value="Romance">Romance<br>
          <input type="checkbox" name="genres[]" value="Sci-fi">Sci-Fi<br>
          <input type="checkbox" name="genres[]" value="Mystery">Mystery<br>
          <input type="checkbox" name="genres[]" value="War">War<br>
          <input type="checkbox" name="genres[]" value="Western">Western<br>
          <input type="checkbox" name="genres[]" value="Horror">Horror<br>
          <input type="checkbox" name="genres[]" value="Animation">Animation<br>
        </fieldset>
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
        <br>
        <input type="submit" name="submit" class="btn btn-warning" value ="Chercher un film">
      </form>
    </div>
  </div>


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
