<?php
session_start();
include 'includes/pdo.php';
include 'includes/functions.php';
?>

<?php
if(!isLogged()) {
  header('location: connexion.php');
  exit;
}


?>

<?php include 'includes/header.php'; ?>

<!-- Titre page -->
<div class="titrePage container-fluid">
  <div class="row">
    <h1>Ma liste de films à voir</h1>
  </div>
</div>

<hr>
<!-- Display des films à voir -->
<div class="container affichesFilms">
  <div class="row">
    
  </div>
</div>





<?php include 'includes/footer.php'; ?>
