<?php
include 'includes/pdo.php';
include 'includes/functions.php';

 $sql = "SELECT * FROM movies_full ORDER BY RAND() LIMIT 6";
 $query = $pdo->prepare($sql);
 $query->execute();
 $movies = $query->fetchAll();







include 'includes/header.php';


foreach ($movies as $movie) {
  echo '<a href="details.php?id='.$movie['id'].'"><img src="posters/'.$movie['id'].'.jpg"></a>';
}


?>

<div class="titrePage container-fluid">
  <div class="row">
    <h1>Consultez les films proposés</h1>
  </div>
  <div class="row">
    
  </div>
</div>








<?php include 'includes/footer.php';
