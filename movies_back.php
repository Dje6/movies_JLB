<?php
session_start();
include('includes/functions.php');
include('includes/header_back.php');

// calcul nombre de fileperms
$sql ="SELECT count(*) FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$nb_films = $query->fetchColumn();



if(isAdmin()) {
  $r_GET = nettoyage($_GET);

  if(!isset($r_GET['page'])){
    $r_GET['page'] = 1 ;
  }
  $num = 100;
  $movies = movies($num,$r_GET['page']);
$pagination = pagination($r_GET['page'],$movies['total']['nb_page'],basename($_SERVER['PHP_SELF'])); ?>

<div class="container-fluid table-responsive">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-2 col-lg-10">
      <br>
      <a href="addMovie.php">
        <button type="button" class="btn btn-primary btn-lg btn-block">Ajouter un film</button>
      </a>
      <hr style="border-color: white">

      <?php echo $pagination//peut etre afficher plusieur fois si besoin ?>

      <table class="use table blue">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Year</th>
          <th>Rating</th>
          <th>Actions</th>
        </tr>
  <?php foreach ($movies as $key => $movie) {
          if(is_numeric($key)){ ?>

        <tr class='liste_movies_back liste_movies_back<?php echo $movie['id']; ?>'>
          <td class='<?php echo $movie['id']; ?>'><?php echo $movie['id']; ?></td>
          <td class='<?php echo strip_tags(trim(str_replace(' ','-',str_replace('\'','-',$movie['title'])))); ?>'><?php echo $movie['title']; ?></td>
          <td class='<?php echo $movie['year']; ?>'><?php echo $movie['year']; ?></td>
          <td class='<?php echo $movie['rating']; ?>'><?php echo $movie['rating']; ?></td>
          <td class='bouton'><?php echo bouton_movies($movie,$r_GET['page'],basename($_SERVER['PHP_SELF'])); ?></td>
        </tr>

    <?php }
        } ?>
      </table>

      <?php echo $pagination//peut etre afficher plusieur fois si besoin ?>

    </div>
      <div class="col-xs-3 col-md-3 col-lg-2">
        <h4 class="blue" >Nombre de films</h4>
        	<div class="large blue"><?php echo $nb_films ;?></div>
      </div>

  </div>
</div>
<?php }else{
      header('Location: index.php');
    }

include('includes/footer_back.php');
 ?>
