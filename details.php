<?php
session_start();
include 'includes/pdo.php';
include 'includes/functions.php';
?>



<?php
$error = array();
if (!empty($_GET['slug'])) {
  $slug = $_GET['slug'];
  $sql = "(SELECT mf.*,AVG(mun.note) FROM movies_full AS mf LEFT JOIN movies_user_note AS mun
  ON mf.id = mun.id_movie WHERE slug = :slug GROUP BY mf.id)";
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
          <h4><strong>Moyenne des évaluations Utilisateur</strong></h4>
          <h2><?php etoile_rating($movie['AVG(mun.note)'],100); ?><small class="red"></small></h2><br/>

          <section class="container">
            <div id="star-rating">
                <input type="radio" name="example" class="rating" value="20" />
                <input type="radio" name="example" class="rating" value="40" />
                <input type="radio" name="example" class="rating" value="60" />
                <input type="radio" name="example" class="rating" value="80" />
                <input type="radio" name="example" class="rating" value="100" />
            </div>
          </section>
        </div>
        <br>

        <!-- note moyenne utilisateurs -->
        <div class="col-sm-12 ">
          <div class="rating-block">
            <h4 class="note">Rating du film</h4>
            <h2><?php   echo $movie['rating']; ?> <small class="red">/ 100</small></h2>
            <?php etoile_rating($movie['rating'],100) ;?><br/>
          </div>
        </div>


        <!-- Affiche le bouton ajouter a la liste a voir si le user est logged -->
        <?php if (isLogged()) {

          $sql = "(SELECT COUNT(*) FROM movies_user_liste WHERE id_movie = :id)";
          $query = $pdo->prepare($sql);
          $query->bindvalue(":id",$movie['id'],PDO::PARAM_STR);
          $query->execute();
          $a_voir = $query->fetchColumn();

            if($a_voir > 0){ ?>
              <a href="avoir.php" class="btn btn-success btn-md" >Ce film est déjà dans votre liste<br/>Y accéder ?</a> <?php
            }else{ ?>
              <a href="#" class="btn btn-warning btn-md addList" id="<?php echo $movie['id'] ; ?>">Ajouter aux films à voir</a> <?php
            }
         } else { ?>
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
