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

<div class="container table-responsive">
  <div class="row">
    <div class="col-xs-9 col-md-9 col-lg-10">

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

        <tr>
          <td><?php echo $movie['id']; ?></td>
          <td><?php echo $movie['title']; ?></td>
          <td><?php echo $movie['year']; ?></td>
          <td><?php echo $movie['rating']; ?></td>
          <td></td>
        </tr>

    <?php
  }
  } ?>
      </table>
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
