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

  if(verif($r_POST['title'],3,50,'titre')){
    $error['title'] = verif($r_POST['title'],3,50,'titre');
  }
  if(verif($r_POST['genres'],3,50,'genre')){
    $error['genres'] = verif($r_POST['genres'],3,50,'genre');
  }
  if(verif($r_POST['year'],4,4,'année','',true)){
    $error['year'] = verif($r_POST['year'],4,4,'année','',true);
  }
  if(verif($r_POST['plot'],20,500,'intrigue')){
    $error['plot'] = verif($r_POST['plot'],20,500,'intrigue');
  }
  if(verif($r_POST['cast'],3,100,'cast')){
    $error['cast'] = verif($r_POST['cast'],3,100,'cast');
  }
  if(verif($r_POST['runtime'],2,3,'durée','',true)){
    $error['runtime'] = verif($r_POST['runtime'],2,3,'durée','',true);
  }
  if(verif($r_POST['directors'],5,50,'réalisateur')){
    $error['directors'] = verif($r_POST['directors'],5,50,'réalisateur');
  }
  if(verif($r_POST['writers'],5,150,'scénaristes')){
    $error['writers'] = verif($r_POST['writers'],5,150,'scénaristes');
  }

  if(isset($r_POST['update']) && $r_POST['update'] == 'update' && count($error) == 0){

    $slug = slugify($r_POST['title']);
    $slug .= '-'.$r_POST['year'];

    $genres = array_string($_POST['genres']);

    $sql = "UPDATE movies_full SET title=:title,genres=:genres,year=:year,plot=:plot,
    cast=:cast,runtime=:runtime,directors=:directors,writers=:writers,slug=:slug,modified=NOW() WHERE id= :id" ;
    $query = $pdo->prepare($sql);
    $query->bindvalue(':id',$r_POST['id'],PDO::PARAM_STR);
    $query->bindvalue(':title',$r_POST['title'],PDO::PARAM_STR);
    $query->bindvalue(':genres',$genres,PDO::PARAM_STR);
    $query->bindvalue(':year',$r_POST['year'],PDO::PARAM_INT);
    $query->bindvalue(':plot',$r_POST['plot'],PDO::PARAM_STR);
    $query->bindvalue(':cast',$r_POST['cast'],PDO::PARAM_STR);
    $query->bindvalue(':runtime',$r_POST['runtime'],PDO::PARAM_INT);
    $query->bindvalue(':directors',$r_POST['directors'],PDO::PARAM_STR);
    $query->bindvalue(':writers',$r_POST['writers'],PDO::PARAM_STR);
    $query->bindvalue(':slug',$slug,PDO::PARAM_STR);
    $query->execute();
    echo 'mise a jour ok';
    exit;

  }
  if (count($error) == 0 && empty($r_POST['update'])) {
    $slug = slugify($r_POST['title']);
    $slug .= '-'.$r_POST['year'];
    $success = true;
    $sql = "INSERT INTO movies_full (title,genres,year,plot,cast,runtime,directors,writers,slug,created) VALUES (:title,:genres,:year,:plot,:cast,:runtime,:directors,:writers,:slug,NOW())";
    $query = $pdo->prepare($sql);
    $query->bindvalue(':title',$r_POST['title'],PDO::PARAM_STR);
    $query->bindvalue(':genres',$r_POST['genres'],PDO::PARAM_STR);
    $query->bindvalue(':year',$r_POST['year'],PDO::PARAM_INT);
    $query->bindvalue(':plot',$r_POST['plot'],PDO::PARAM_STR);
    $query->bindvalue(':cast',$r_POST['cast'],PDO::PARAM_STR);
    $query->bindvalue(':runtime',$r_POST['runtime'],PDO::PARAM_INT);
    $query->bindvalue(':directors',$r_POST['directors'],PDO::PARAM_STR);
    $query->bindvalue(':writers',$r_POST['writers'],PDO::PARAM_STR);
    $query->bindvalue(':slug',$slug,PDO::PARAM_STR);
    $query->execute();
    echo 'film ajouter';
    exit;

  }
}
if($_GET && !$_POST){
  $r_GET = nettoyage($_GET);

  $sql = "SELECT * FROM movies_full WHERE id = :id";
  $query = $pdo->prepare($sql);
  $query->bindvalue(':id',$r_GET['id'],PDO::PARAM_INT);
  $query->execute();
  $movie = $query->fetch();

}

include 'includes/header_back.php'; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-2 col-lg-10 blue">
      <h1 class="text-center blue">Ajouter un film</h1>
      <form class="addMovie" action="" method="POST">
        <div class="form-group">
          <div class="col-md-4 col-lg-4">
            <label for="title">Titre</label>
            <span><?php if (!empty($error['title'])) {echo $error['title'];}?></span>
            <input type="text" name="title" class="form-control" value="<?php if(!empty($_POST['title'])) {
              echo $_POST['title'];}elseif(!empty($movie['title'])) {echo $movie['title'];} ?>">
          </div>
          <div class="col-md-4 col-lg-4">
            <label for="genres">Genre</label>
            <span><?php if (!empty($error['genres'])) {echo $error['genres'];}?></span>
            <input type="text" name="genres" class="form-control" value="<?php if(!empty($_POST['genres'])){
              echo array_string($_POST['genres']);;}elseif(!empty($movie['genres'])) {echo array_string($movie['genres']);} ?>">
          </div>
          <div class="col-md-4 col-lg-4">
            <label for="year">Année</label>
            <span><?php if (!empty($error['year'])) {echo $error['year'];}?></span>
            <input type="text" name="year" class="form-control" value="<?php if(!empty($_POST['year'])){
              echo $_POST['year'];}elseif(!empty($movie['year'])) {echo $movie['year'];} ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 col-lg-12">
            <label for="plot">Intrigue</label>
            <span><?php if (!empty($error['plot'])) {echo $error['plot'];}?></span>
            <textarea name="plot" class="form-control" rows="8" cols="80"><?php if(!empty($_POST['plot'])) {
              echo $_POST['plot'];}elseif(!empty($movie['plot'])) {echo $movie['plot'];} ?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-10 col-lg-10">
            <label for="cast">Cast</label>
            <span><?php if (!empty($error['cast'])) {echo $error['cast'];}?></span>
            <input type="text" name="cast" class="form-control" value="<?php if(!empty($_POST['cast'])) {
              echo $_POST['cast'];}elseif(!empty($movie['cast'])) {echo $movie['cast'];} ?>">
          </div>
          <div class="col-md-2 col-lg-2">
            <label for="runtime">Durée (en minutes)</label>
            <span><?php if (!empty($error['runtime'])) {echo $error['runtime'];}?></span>
            <input type="text" name="runtime" class="form-control" value="<?php if(!empty($_POST['runtime'])) {
              echo $_POST['runtime'];}elseif(!empty($movie['runtime'])) {echo $movie['runtime'];} ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6 col-lg-6">
            <label for="directors">Réalisateur</label>
            <span><?php if (!empty($error['directors'])) {echo $error['directors'];}?></span>
            <input type="text" name="directors" class="form-control" value="<?php if(!empty($_POST['directors'])) {
              echo $_POST['directors'];}elseif(!empty($movie['directors'])) {echo $movie['directors'];} ?>">
          </div>
          <div class="col-md-6 col-lg-6">
            <label for="writers">Scénaristes</label>
            <span><?php if (!empty($error['writers'])) {echo $error['writers'];}?></span>
            <input type="text" name="writers" class="form-control" value="<?php if(!empty($_POST['writers'])) {
              echo $_POST['writers'];}elseif(!empty($movie['writers'])) {echo $movie['writers'];} ?>">
          </div>
        </div>
        <div class="form-group">
          <input type="hidden" name="id" value="<?php if(isset($r_GET['id'])){
            echo $r_GET['id'] ;}elseif(isset($r_POST['id'])){ echo $r_POST['id'] ;} ?>">

          <input type="hidden" name="update" value="<?php if(isset($r_GET['type'])){
            echo $r_GET['type'] ;}elseif(isset($r_POST['update'])){ echo $r_POST['update'] ;} ?>">
          <?php  if(isset($r_POST['update']) || isset($r_GET['type'])){ ?>
              <input type="submit" name="submit" class="btn-lg btn-primary alimage2" value="Mettre a jour">
            <?php }else{ ?>
          <input type="submit" name="submit" class="btn-lg btn-primary alimage2" value="Ajouter">
          <?php } ?>
        </div>
      </form>
    </div>
  </div>

</div>

<?php include 'includes/header_back.php'; ?>
