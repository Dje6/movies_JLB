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
    $sql .= " LIMIT 20";
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
  <div class="container">
    <div class="row">
      <button id="showFiltres" type="button" class="btn btn-warning btn-lg">Filtres de recherche</button>
      <form class="filtresRecherche container" action="" method="GET">


        <div class="form-group col-md-4">
          <input type="text" name="searchbar" class="form-control " placeholder="Réalisateur, Titre...">
        </div>

        <div class="checkbox col-md-4">
          <?php  global $pdo;
          $sql = "SELECT genres FROM movies_full GROUP BY genres";
          $query = $pdo->prepare($sql);
          $query->execute();
          $all = $query->fetchAll();

          $genres = array();
          $liste_genre = array();
          $i=0;
          foreach ($all as $key => $value) {
            $genres[$key] = str_replace(' ','',explode(',',$value['genres']));
          }
          foreach ($genres as $key => $value) {
            foreach ($value as $key_y => $value_y) {
              $i++;
              $liste_genre[$i]= $value_y;
            }
          }
          foreach (array_unique($liste_genre) as $key => $value) {
            if($key > 1){
              echo '<input type="checkbox" name="genres[]" value="'.$value.'">'.$value.'<br>' ;
            }
          } ?>
        </div>


        <div class="col-md-4">

          <select class="form-control" name="annees_debut">
            <?php for($i=1950 ; $i <= date('Y') ;$i++){
              echo '<option value="'.$i.'">'.$i.'</option>';
            } ?>
          </select>
          <select class="form-control" name="annees_fin">
            <?php for($i=1950 ; $i <= date('Y') ;$i++){
              if($i == date('Y')){
                echo '<option value="'.$i.'" selected>'.$i.'</option>';
              }else{
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
            } ?>

                  </select>
          <br>
          <select class="form-control" name="rating_debut">
            <?php for($i=0 ; $i <= 100 ;$i++){
              echo '<option value="'.$i.'">'.$i.'</option>';
            } ?>
          </select>
          <select class="form-control" name="rating_fin">
            <?php for($i=0 ; $i <= 100 ;$i++){
              if($i == 100){
                echo '<option value="'.$i.'" selected>'.$i.'</option>';
              }else{
                  echo '<option value="'.$i.'">'.$i.'</option>';
              }
            } ?>
          </select>
          <br>

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
