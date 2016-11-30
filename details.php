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
  <div class="affichage container-fluid">
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
              <a href="#" class="btn btn-primary btn-md addList" id="<?php echo $movie['id'] ; ?>">Ajouter aux films à voir</a> <?php
            }
         } else { ?>
          <button class="btn btn-primary btn-md disabled">Connectez-vous pour ajouter ce film à votre liste</button>
        <?php } ?>
      </div> <!-- end thumbnail -->
    </div> <!-- end row -->
  </div> <!-- end div affichage -->


          <!-- Social networks -->
  <div class="container">
    <div class="row">



      <iframe src="http://www.facebook.com/plugins/like.php?href=http://www.example.com/page.html&show_faces=true&width=65&action=like&font=arial&colorscheme=light&height=65"
        scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:65px; height:65px; margin-top:3px;" allowTransparency="true"></iframe>
        <a name="fb_share" type="box_count" share_url="http://www.example.com/page.html"></a>

        <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

      <g:plusone size="right"></g:plusone>

      <script type="in/share" data-counter="hidden"></script>

    </div>
  </div> <!-- end social network -->

          <script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
          <script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" type="text/javascript"></script>
          <script type="text/javascript" src="https://apis.google.com/js/plusone.js">{lang: 'fr'}</script>

<?php include 'includes/footer.php'; ?>
