<?php
session_start();
include 'includes/pdo.php';
include 'includes/functions.php';

$error = array();
if (!empty($_GET['slug'])) {
  $slug = $_GET['slug'];
  $sql = "(SELECT mf.*,AVG(mun.note),COUNT(mun.note) FROM movies_full AS mf LEFT JOIN movies_user_note AS mun
  ON mf.id = mun.id_movie WHERE mf.slug = :slug GROUP BY mf.id)";
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
        <!-- Moyenne des evaluations --><?php
        if(isset($_SESSION['user']['id'])){
            $sql = "(SELECT COUNT(*) FROM movies_user_note WHERE id_movie = :id_movie AND id_user = :id_user)";
            $query = $pdo->prepare($sql);
            $query->bindValue(':id_movie',$movie['id'],PDO::PARAM_INT);
            $query->bindValue(':id_user',$_SESSION['user']['id'],PDO::PARAM_INT);
            $query->execute();
            $deja_vote = $query->fetchColumn();
        } ?>

        <div class="evaluation">
          <h4><strong>Moyenne des évaluations Utilisateur</strong></h4>
          <h2><span class="moyenne-user-text"><?php echo ($movie['AVG(mun.note)']*20); ?></span><small class="red">/100</small></h2>
          <span class="moyenne-user-notes"><?php echo $movie['COUNT(mun.note)']; ?> note<?php if($movie['COUNT(mun.note)'] > 1){ echo 's';} ?></span><br/>
          <span class="moyenne-user-etoile"><?php echo etoile_rating_return(($movie['AVG(mun.note)']*20),100); ?></span><?php

      if(isset($_SESSION['user']['id'])){
          if($deja_vote == 0){ ?>
              <div id="star-rating">
                  <input type="radio" name="example" class="rating" value="1" id="<?php echo $movie['id'] ?>"/>
                  <input type="radio" name="example" class="rating" value="2" id="<?php echo $movie['id'] ?>"/>
                  <input type="radio" name="example" class="rating" value="3" id="<?php echo $movie['id'] ?>"/>
                  <input type="radio" name="example" class="rating" value="4" id="<?php echo $movie['id'] ?>"/>
                  <input type="radio" name="example" class="rating" value="5" id="<?php echo $movie['id'] ?>"/>
              </div>
         <?php
          }else{
            echo '<br/><br/>Vous avez deja noté ce film';
          }
      }else{
          echo '<br/><br/>Connectez-vous pour voter';
      } ?>
        </div>
        <br>

        <!-- note moyenne utilisateurs -->
        <div class="col-sm-12 ">
          <div class="rating-block">
            <h4 class="note">Rating du film</h4>
            <h2><?php   echo $movie['rating']; ?> <small class="red">/ 100</small></h2>
            <?php echo etoile_rating_return($movie['rating'],100) ;?><br/>
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
          <a name="fb_share" type="box_count" share_url="http://localhost/projet_commun_movies/movies_JLB/index.php" class="btn btn-primary social-login-btn social-facebook" href="/auth/facebook"><i class="fa fa-facebook"></i></a>
          <a href="http://twitter.com/share" class="btn btn-primary social-login-btn social-twitter" href="/auth/twitter"><i class="fa fa-twitter"></i></a>
        </p>
        <p>
          <a class="btn btn-primary social-login-btn social-linkedin" href="/auth/linkedin"><i class="fa fa-linkedin"></i></a>
          <a class="btn btn-primary social-login-btn social-google" href="/auth/google"><i class="fa fa-google-plus"></i></a>
        </p>
        <br>


        <!-- <iframe src="http://www.facebook.com/plugins/like.php?href=http://www.example.com/page.html&layout=box_count&show_faces=true&width=65&action=like&font=arial&colorscheme=light&height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:65px; height:65px; margin-top:3px;" allowTransparency="true"></iframe> -->

        <a name="fb_share" type="box_count" share_url="http://localhost/projet_commun_movies/movies_JLB/index.php"></a>
        <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>

      </form>
    </div> <!-- end social network -->
  </div> <!-- end div affichage -->



<?php include 'includes/footer.php'; ?>
