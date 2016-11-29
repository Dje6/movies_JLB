<?php
session_start();
include('includes/functions.php');
include('includes/header_back.php');
if(isAdmin()) {

  $sql = "SELECT id,title,year,rating FROM movies_full ORDER BY title ASC";
  $query = $pdo->prepare($sql);
  $query->execute();
  $movies = $query->fetchAll();

?>
<div class="container table-responsive">
  <div class="row">
    <div class="col-xs-9 col-md-9 col-lg-10">


      <table class="use table">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Year</th>
          <th>Rating</th>
          <th>Actions</th>
        </tr>

  <?php foreach ($movies as $movie) { ?>

        <tr>
          <td><?php echo $movie['id']; ?></td>
          <td><?php echo $movie['title']; ?></td>
          <td><?php echo $movie['year']; ?></td>
          <td><?php echo $movie['rating']; ?></td>
          <td></td>
        </tr>

    <?php } ?>
      </table>
    </div>
  </div>
</div>
<?php }else{
      header('Location: index.php');
    }

include('includes/footer_back.php');
 ?>
