<!-- ICI J AJOUTE LES MOVIES -->
<?php
session_start();
include 'includes/functions.php';
if(!isAdmin()) {
  header('location: ../connexion.php');
  exit;
}






include 'includes/header_back.php';?>


<div class="container-fluid">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-2 col-lg-10">
      <h1 class="text-center">Ajouter un film</h1>
      <form class="addMovie" action="" method="POST">
        <div class="form-group">
          <div class="col-md-4 col-lg-4">
            <label for="title">Titre</label>
            <input type="text" name="title" class="form-control" value="">
          </div>
          <div class="col-md-4 col-lg-4">
            <label for="genre">Genre</label>
            <input type="text" name="genre" class="form-control" value="">
          </div>
          <div class="col-md-4 col-lg-4">
            <label for="year">Année</label>
            <input type="text" name="year" class="form-control" value="">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12 col-lg-12">
            <label for="plot">Intrigue</label>
            <textarea name="plot" class="form-control" rows="8" cols="80"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-10 col-lg-10">
            <label for="cast">Cast</label>
            <input type="text" name="cast" class="form-control" value="">
          </div>
          <div class="col-md-2 col-lg-2">
            <label for="time">Durée (en minutes)</label>
            <input type="text" name="time" class="form-control" value="">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6 col-lg-6">
            <label for="director">Réalisateur</label>
            <input type="text" name="director" class="form-control" value="">
          </div>
          <div class="col-md-6 col-lg-6">
            <label for="writers">Scénaristes</label>
            <input type="text" name="writers" class="form-control" value="">
          </div>
        </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn-lg btn-primary" value="Ajouter">
        </div>
      </form>
    </div>
  </div>

</div>













<?php include 'includes/header_back.php'; ?>
