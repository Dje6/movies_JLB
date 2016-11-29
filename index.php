<?php
session_start();
include 'includes/pdo.php';
include 'includes/functions.php';

// Sinon on affiche des films random frère
if (!empty($_GET['submit'])) {
  $r_GET = nettoyage($_GET);

// si la recherche contient un ou plusieur mot
if(!empty($r_GET["searchbar"])){
  $i=0;
  foreach (explode(" ", $r_GET["searchbar"]) as $key => $value) {
    if($value != NULL)
    {
      $mot_sj[$i] = "title LIKE '%$value%' OR plot LIKE '%$value%'";
      $i++;
    }
    $final_sj = '('.implode(" OR ", $mot_sj).') AND';
  }
}else{
    $final_sj = '';
}
//si un ou plusieur genres sont selectionner
if(!empty($r_GET["genres"])){
  $i=0;
  foreach ($r_GET["genres"] as $key => $value) {
    if($value != NULL)
    {
      $genre_sj[$i] = "genres LIKE '%$value%'";
      $i++;
    }
    $final_genre_sj = '('.implode(" OR ", $genre_sj).') AND';
  }
}else{
    $final_genre_sj = '';
}
//par default la fourche est de 1950 a l'annee en cour
  $annee = '(year BETWEEN '.$r_GET["annees_debut"].' AND '.$r_GET["annees_fin"].')' ;
//par default la fouche est de 0 a 100
  $rating = 'AND (rating BETWEEN '.$r_GET["rating_debut"].' AND '.$r_GET["rating_fin"].')' ;


    $sql = "SELECT * FROM movies_full WHERE $final_sj $final_genre_sj $annee $rating";
    echo $sql;
    $query = $pdo->prepare($sql);
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


        <div class="form-group col-xs-4 searchbar">
          <label for="searchbar">Recherche personnalisée</label>
          <input type="text" name="searchbar" class="form-control " placeholder="Réalisateur, Titre...">
        </div>

        <div class="alignv checkbox col-xs-4">
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
            $last_key = array_pop(array_keys(array_unique($liste_genre)));

          foreach (array_unique($liste_genre) as $key => $value) {
            if($key > 1 && $key < $last_key){
              echo '<input type="checkbox" name="genres[]" value="'.$value.'">'.$value.'<br>' ;
            }
          } ?>
        </div>


        <div class="col-xs-4">
          <!-- Recherche par année -->
          <div class="form-group">
            <label for="annees_debut">Année de</label>
            <select class="form-control" name="annees_debut">
              <?php for($i=1950 ; $i <= date('Y') ;$i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
              } ?>
            </select>
            <label for="annees_fin">à </label>
            <select class="form-control" name="annees_fin">
              <?php for($i=1950 ; $i <= date('Y') ;$i++){
                if($i == date('Y')){
                  echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }else{
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
              } ?>
            </select>
          </div>
          <br>
          <!-- Recherche par popularité -->
          <div class="form-group">
            <label class="form-group" for="rating_debut">Popularité de</label>
            <select class="form-control" name="rating_debut">
              <?php for($i=0 ; $i <= 100 ;$i++){
                echo '<option value="'.$i.'">'.$i.'</option>';
              } ?>
            </select>
            <label for="rating_fin">à </label>
            <select class="form-control" name="rating_fin">
              <?php for($i=0 ; $i <= 100 ;$i++){
                if($i == 100){
                  echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }else{
                    echo '<option value="'.$i.'">'.$i.'</option>';
                }
              } ?>
            </select>
          </div>
          <br>

        </div>

        <br>
        <br>
        <input type="submit" name="submit" class="btn btn-warning btn-lg" value ="Chercher un film">
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

    if(empty($movies)) {
      echo '<h2 class="text-center">Pas de film correspondant à cette recherche </h2>';
    } else {

      foreach ($movies as $movie) { ?>
        <div class="col-xs-6 col-md-4">


          <?php


            if(file_exists("posters/". $movie['id']. ".jpg")) {
              echo  '<a href="details.php?slug='.$movie['slug'].'"><img class="displayAffiches" title="'.$movie['title'].'" src="posters/'.$movie['id'].'.jpg"></a>';
            } else {
              echo '<a href="details.php?slug='.$movie['slug'].'"><img class="displayAffiches" title="'.$movie['title'].'" src="http://placehold.it/220x300"></a>';
              // print_r ($size);
            }
           ?>
        </div>
        <?php } ?>
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
