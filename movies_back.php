<?php
session_start();
include('includes/functions.php');
include('includes/header.php');
if(isAdmin()) {

  $sql = "SELECT id,title,year,rating FROM movies_full ORDER BY id"
  $query->prepare($sql);
  $query->execute();
  $movies = $query->fetchAll();

?>
  <table class="use table">
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Year</th>
      <th>Rating</th>
      <th>Actions</th>
    </tr>

<?php

  foreach ($movies as $movie => $value) { ?>

      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>


  <?php }
  }else{
      header('Location: index.php');
    }

include('includes/footer.php');
 ?>
