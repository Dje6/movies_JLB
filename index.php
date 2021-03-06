<?php
session_start();
include 'includes/functions.php';

// Sinon on affiche des films random frère
if (!empty($_GET['submit'])) {
  $r_GET = nettoyage($_GET); //verif.php

    if(!isset($r_GET['page'])){
      $r_GET['page'] = 1 ;
    }
    $num = 15;//nombre de video presenter sur la page par defaut

    if(isset($r_GET['nbr_par_page'])){ //si un choix est fait on utilise ce choix
      $num = $r_GET['nbr_par_page'] ;
    }
    $movies = search($num,$r_GET['page'],$r_GET) ; //affichage.php
    $url = url_transfert($r_GET); //pagination.php
    $pagination = pagination($r_GET['page'],$movies['total']['nb_page'],basename($_SERVER['PHP_SELF']),str_replace(' ','+',$url));//pagination.php

} else {
  $sql = "SELECT * FROM movies_full ORDER BY RAND() LIMIT 6";
  $query = $pdo->prepare($sql);
  $query->execute();
  $movies = $query->fetchAll();
}
include 'includes/header.php';?>

        <!-- Titre et filtres -->
<div class="titrePage container-fluid">
  <div class="row">
    <h1>Consultez les films proposés</h1>
  </div>
  <!-- filtres recherche -->
  <div class="container">
    <div class="row">
      <button id="showFiltres" type="button" class="btn btn-primary btn-lg">Filtres de recherche</button>
      <form class="filtresRecherche container" action="" method="GET">

        <div class="form-group col-xs-4 searchbar">
          <label for="searchbar">Recherche personnalisée</label>
          <input type="text" name="searchbar" class="form-control " placeholder="Réalisateur, Titre..."
          value="<?php if(isset($r_GET['searchbar']) && !empty($r_GET['searchbar'])){echo $r_GET['searchbar'] ;} ?> ">
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
          //pas fini
            function tcheck_genre($value_y,$array){
              foreach ($array as $key => $value) {
                if($value == $value_y){
                  return true;
                }
              }
              return false;
            }
          //pas fini
              //Un checkbox pour sélect tous les genres
          echo '<input type="checkbox" id="check_all"><b>Sélectionner tout</b><br>' ;
          foreach (array_unique($liste_genre) as $key => $value) {
            if($key > 1 && $value != 'N/A'){
               if(isset($r_GET['genres']) && !empty($r_GET['genres'])){ //pas fini
                 if(tcheck_genre($value,$r_GET['genres'])){
                   echo '<input type="checkbox" name="genres[]" value="'.$value.'" checked>'.$value.'<br>' ;
                 }else{
                   echo '<input type="checkbox" class="check_genres" name="genres[]" value="'.$value.'">'.$value.'<br>' ;
                 }
               }else{
                  echo '<input type="checkbox" class="check_genres" name="genres[]" value="'.$value.'">'.$value.'<br>' ;
               }
            }
          } ?>
        </div>

        <div class="col-xs-4">
          <!-- Recherche par année -->
          <?php
          $sql = "SELECT MIN(year) FROM movies_full";
          $query = $pdo->prepare($sql);
          $query->execute();
          $min = $query->fetchColumn(); ?>

          <div class="form-group">
            <label for="annees_debut">Année de</label>
            <select class="form-control" name="annees_debut">

              <?php for($i=$min ; $i <= date('Y') ;$i++){
                if(isset($r_GET['annees_debut']) && !empty($r_GET['annees_debut']) && $i == $r_GET['annees_debut']){
                  echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }else{
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
              } ?>
            </select>
            <label for="annees_fin">à </label>
            <select class="form-control" name="annees_fin">
              <?php for($i=$min ; $i <= date('Y') ;$i++){
                if($i == date('Y') && !isset($r_GET['annees_fin']) && empty($r_GET['annees_fin'])){
                  echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }elseif(isset($r_GET['annees_fin']) && !empty($r_GET['annees_fin']) && $i == $r_GET['annees_fin']){
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
                if(isset($r_GET['rating_debut']) && !empty($r_GET['rating_debut']) && $i == $r_GET['rating_debut']){
                  echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }else{
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
              } ?>
            </select>
            <label for="rating_fin">à </label>
            <select class="form-control" name="rating_fin">
              <?php for($i=0 ; $i <= 100 ;$i++){
                if($i == 100 && !isset($r_GET['rating_fin']) && empty($r_GET['rating_fin'])){
                  echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }elseif(isset($r_GET['rating_fin']) && !empty($r_GET['rating_fin']) && $i == $r_GET['rating_fin']){
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }else{
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
              } ?>
            </select>

            <br/><label for="nbr_par_page">Videos par page </label>
            <select class="form-control" name="nbr_par_page">
              <?php for($i=9 ; $i <= 30 ;($i+=3)){
                if($i == 15 && !isset($r_GET['nbr_par_page']) && empty($r_GET['nbr_par_page'])){
                  echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }elseif(isset($r_GET['nbr_par_page']) && !empty($r_GET['nbr_par_page']) && $i == $r_GET['nbr_par_page']){
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                }else{
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
              } ?>
            </select>

          </div><br>
        </div><br><br>
        <input type="submit" name="submit" class="btn btn-primary btn-lg" value ="Chercher un film">
      </form>
    </div>
  </div>
</div>

<hr>
<!-- Listing des affiches de films -->
<br><div class="container affichesFilms">
  <div class="row"><?php

    if(empty($movies)) {
      echo '<h2 class="text-center">Pas de film correspondant à cette recherche </h2>';
    }else{

      if(!empty($_GET['submit'])){
          echo $pagination;
      }
      foreach ($movies as $key => $movie) {
        if(is_numeric($key)){ ?>
          <div class="col-xs-6 col-md-4"><?php

            if(file_exists("posters/". $movie['id']. ".jpg")) {
              echo  '<a href="details.php?slug='.$movie['slug'].'"><img class="displayAffiches"
              title="'.$movie['title'].'" src="posters/'.$movie['id'].'.jpg"></a>';
            } else {
              echo '<a href="details.php?slug='.$movie['slug'].'"><img class="displayAffiches"
              title="'.$movie['title'].'" src="http://placehold.it/220x300"></a>';
            } ?>
          </div> <?php
        }
      }
    } ?>
  </div>
<?php  if(!empty($_GET['submit'])){ //pagination en dessous de la liste aussi
    echo $pagination;
  } ?>
</div>
<hr>
<!-- Button + de films -->
<br>
<div class="container">
  <div class="row">
    <a href="index.php">
      <button type="button" class="btn btn-primary btn-lg btn-block">
        <h2 class="plusFilm">Plus de films !</h2>
      </button>
    </a>
  </div>
</div>
<?php include 'includes/footer.php';
