<?php
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
    echo '<p class="detailcss">' . $movie['genres'] . '<p>';
    echo '<br>';
    echo '<p class="detailcss">' . $movie['plot'] . '<p>';

    echo '<p class="detailcss">' . $movie['directors'] . '<p>';

    echo '<p class="detailcss">' . $movie['cast'] . '<p>';
      //print_r($movie['id']);
  } else {
    $error['id'] = "N'est pas dans la bdd";
    print_r($error);
  }
} else {
  header('Location: index.php');
}
?>
      <div class="evaluation">
        <h4>Moyenne des évaluations</h4>
        <h2><?php   echo $movie['popularity']; ?> <small class="red">Popularité</small></h2>
        <h2><?php   echo $movie['rating']; ?> <small class="red">/ 100</small></h2>
      </div>
    </div>
  </div>
  <div class="container text-center">
    <form class="form-signin" data-ember-action="2">
      <h2 class="form-signin-heading">Social network</h2>
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
  </div>
</div>






<?php include 'includes/footer.php'; ?>
