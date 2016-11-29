<?php
session_start();
include 'includes/pdo.php';
include 'includes/functions.php';
?>



<?php
$error = array();
if (!empty($_GET['slug'])) {
  $slug = $_GET['slug'];
  $sql = "SELECT * FROM movies_full WHERE slug = :slug";
  $query = $pdo->prepare($sql);
  $query->bindvalue(":slug",$slug,PDO::PARAM_STR);
  $query->execute();
  $movie = $query->fetch();
  include 'includes/header.php';
  ?>
  <div class="affichage">
    <div class="row">
      <div class="thumbnail">
        <?php
          if (!empty($movie['slug'])) {
            echo '<h1>' . $movie['title'] . '</H1>';
            echo '<h2>' . $movie['slug'] . '<H2>';
            if(file_exists("posters/". $movie['id']. ".jpg")) {
              echo '<img src="posters/'.$movie['id'].'.jpg">';
            }else {
              echo '<img class="displayAffiches" src="http://placehold.it/220x300">';
            }
            echo '<br>';
            echo '<p class="detailcss"><strong>Genre : </strong>' . $movie['genres'] . '<p>';
            echo '<br>';
            echo '<p class="detailcss"><strong>Synopsis : </strong>' . $movie['plot'] . '<p>';
            echo '<p class="detailcss"><strong>Réalisateur(s) : </strong>' . $movie['directors'] . '<p>';
            echo '<p class="detailcss"><strong>Casting : </strong>' . $movie['cast'] . '<p>';
              //print_r($movie['id']);
          } else {
            header('Location: index.php');
          }
        } else {
          header('Location: index.php');
        }
        ?>
        <!-- Moyenne des evaluations -->
        <div class="evaluation">
          <h4><strong>Moyenne des évaluations</strong></h4>
          <h2><?php   echo $movie['popularity']; ?> <small class="red">Popularité</small></h2>
        </div>
        <br>

        <!-- note moyenne utilisateurs -->
        <div class="col-sm-12 ">
          <div class="rating-block">
            <h4 class="note">Note moyenne des utilisateurs</h4>
            <h2><?php   echo $movie['rating']; ?> <small class="red">/ 100</small></h2>
            <?php etoile_rating($movie['rating'],100)?><br/>

            <!-- <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
              <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
              <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
              <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
              <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
              <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            </button> -->
          </div>
        </div>


        <!-- Affiche le bouton ajouter a la liste a voir si le user est logged -->
        <?php if (isLogged()) { ?>
          <a href="#" class="btn btn-warning btn-md addList" id="<?php echo $movie['id']; ?>">Ajouter aux films à voir</a>
        <?php } else { ?>
          <button class="btn btn-warning btn-md disabled">Connectez-vous pour ajouter ce film à votre liste</button>
        <?php } ?>
      </div> <!-- end thumbnail -->
    </div> <!-- end row -->

      <!-- Social network -->
    <div class="container text-center">
      <form class="form-signin" data-ember-action="2">
        <p>
          <a class="btn btn-primary social-login-btn social-facebook" href="/auth/facebook"><i class="fa fa-facebook"></i></a>
          <a class="btn btn-primary social-login-btn social-twitter" href="/auth/twitter"><i class="fa fa-twitter"></i></a>
        </p>
        <p>
          <a class="btn btn-primary social-login-btn social-linkedin" href="/auth/linkedin"><i class="fa fa-linkedin"></i></a>
          <a class="btn btn-primary social-login-btn social-google" href="/auth/google"><i class="fa fa-google-plus"></i></a>
        </p>
        <br>
      </form>
    </div> <!-- end social network -->
  </div> <!-- end div affichage -->



<?php include 'includes/footer.php'; ?>
