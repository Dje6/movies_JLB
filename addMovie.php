<!-- ICI J AJOUTE LES MOVIES -->
<?php
session_start();
include 'includes/functions.php';
if(!isAdmin()) {
  header('location: ../connexion.php');
  exit;
}

$error = array();
$success = false;

if (!empty($_POST['submit'])) {

  $r_POST = nettoyage($_POST);

  // debug($r_POST);

$title = verif($r_POST['title'],3,50,'titre');
$genre = verif($r_POST['genre'],3,50,'genre');
$year = verif($r_POST['year'],4,4,'année','',true);
$plot = verif($r_POST['plot'],20,500,'intrigue');
$cast = verif($r_POST['cast'],3,100,'cast');
$time = verif($r_POST['time'],2,3,'durée','',true);
$director = verif($r_POST['director'],5,50,'réalisateur');
$writers = verif($r_POST['writers'],5,150,'scénaristes');

//debug($error);
  if (count($error) == 0) {
    $slug = slugify($r_POST['title']);
    $slug .= '-'.$r_POST['year'];
    $success = true;
    $sql = "INSERT INTO movies_full (title,genres,year,plot,cast,runtime,directors,writers,slug,created) VALUES (:title,:genres,:year,:plot,:cast,:runtime,:directors,:writers,:slug,NOW())";
    $query = $pdo->prepare($sql);
    $query->bindvalue(':title',$r_POST['title'],PDO::PARAM_STR);
    $query->bindvalue(':genres',$r_POST['genre'],PDO::PARAM_STR);
    $query->bindvalue(':year',$r_POST['year'],PDO::PARAM_INT);
    $query->bindvalue(':plot',$r_POST['plot'],PDO::PARAM_STR);
    $query->bindvalue(':cast',$r_POST['cast'],PDO::PARAM_STR);
    $query->bindvalue(':runtime',$r_POST['time'],PDO::PARAM_INT);
    $query->bindvalue(':directors',$r_POST['director'],PDO::PARAM_STR);
    $query->bindvalue(':writers',$r_POST['writers'],PDO::PARAM_STR);
    $query->bindvalue(':slug',$slug,PDO::PARAM_STR);

    $query->execute();

  }



}






include 'includes/header_back.php';?>


<div class="container-fluid">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-2 col-lg-10 blue">
      <h1 class="text-center blue">Ajouter un film</h1>
      <form class="addMovie" action="" method="POST">
        <div class="form-group">
          <div class="col-md-4 col-lg-4">
            <label for="title">Titre</label>
            <span><?php if (!empty($title)) {echo $title;}?></span>
            <input type="text" name="title" class="form-control" value="<?php if(!empty($_POST['title'])) {echo $_POST['title'];} ?>">
          </div>
          <div class="col-md-4 col-lg-4">
            <label for="genre">Genre</label>
            <span><?php if (!empty($genre)) {echo $genre;}?></span>
            <input type="text" name="genre" class="form-control" value="<?php if(!empty($_POST['genre'])) {echo $_POST['genre'];} ?>">
          </div>
          <div class="col-md-4 col-lg-4">
            <label for="year">Année</label>
            <span><?php if (!empty($year)) {echo $year;}?></span>
            <input type="text" name="year" class="form-control" value="<?php if(!empty($_POST['year'])) {echo $_POST['year'];} ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 col-lg-12">
            <label for="plot">Intrigue</label>
            <span><?php if (!empty($plot)) {echo $plot;}?></span>
            <textarea name="plot" class="form-control" rows="8" cols="80"><?php if(!empty($_POST['plot'])) {echo $_POST['plot'];} ?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-10 col-lg-10">
            <label for="cast">Cast</label>
            <span><?php if (!empty($cast)) {echo $cast;}?></span>
            <input type="text" name="cast" class="form-control" value="<?php if(!empty($_POST['cast'])) {echo $_POST['cast'];} ?>">
          </div>
          <div class="col-md-2 col-lg-2">
            <label for="time">Durée (en minutes)</label>
            <span><?php if (!empty($time)) {echo $time;}?></span>
            <input type="text" name="time" class="form-control" value="<?php if(!empty($_POST['time'])) {echo $_POST['time'];} ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6 col-lg-6">
            <label for="director">Réalisateur</label>
            <span><?php if (!empty($director)) {echo $director;}?></span>
            <input type="text" name="director" class="form-control" value="<?php if(!empty($_POST['director'])) {echo $_POST['director'];} ?>">
          </div>
          <div class="col-md-6 col-lg-6">
            <label for="writers">Scénaristes</label>
            <span><?php if (!empty($writers)) {echo $writers;}?></span>
            <input type="text" name="writers" class="form-control" value="<?php if(!empty($_POST['writers'])) {echo $_POST['writers'];} ?>">
          </div>
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn-lg btn-primary alimage2" value="Ajouter">
        </div>
      </form>
    </div>
  </div>

</div>













<?php include 'includes/header_back.php'; ?>
