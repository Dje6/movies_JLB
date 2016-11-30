<?php
function users($limit,$page)
{
 global $pdo;
 $offset = (($limit)*($page-1));
 $sql = "(SELECT id,pseudo,email,createdat,status FROM users ORDER BY pseudo LIMIT $limit OFFSET $offset)";
 $query = $pdo->prepare($sql);
 $query->execute();
 $nb = $query->fetchAll();
 $nb['total'] = calcule_page(count_page('id','users'),$limit,$page);
 return $nb;
}


function search($limit,$page,$r_GET)
{
   global $pdo;
    $offset = (($limit)*($page-1));
    // si la recherche contient un ou plusieur mot
    if(!empty($r_GET["searchbar"])){
      $i=0;
      foreach (explode(" ", $r_GET["searchbar"]) as $key => $value) {
        if($value != NULL){
          $mot_sj[$i] = "title LIKE '%$value%' OR plot LIKE '%$value%'";
          $i++;
        }
        $final_sj = '('.implode(" OR ", $mot_sj).') AND';
      }
    }else{
        $final_sj = '';
    }
    //si un ou plusieur genres sont selectionner
    if(!empty($r_GET["genres"])){
  $i=0;
  foreach ($r_GET["genres"] as $key => $value) {
    if($value != NULL){
      $genre_sj[$i] = "genres LIKE '%$value%'";
      $i++;
    }
    $final_genre_sj = '('.implode(" OR ", $genre_sj).') AND';
  }
}else{
    $final_genre_sj = '';
}
//par default la fourche est de 1950 a l'annee en cour
  $annee = '(year BETWEEN '.$r_GET["annees_debut"].' AND '.$r_GET["annees_fin"].')' ;
//par default la fouche est de 0 a 100
  $rating = 'AND (rating BETWEEN '.$r_GET["rating_debut"].' AND '.$r_GET["rating_fin"].')' ;

  $sql = "SELECT * FROM movies_full WHERE $final_sj $final_genre_sj $annee $rating LIMIT $limit OFFSET $offset";
  $par = $final_sj.$final_genre_sj.$annee.$rating;
  $query = $pdo->prepare($sql);
  $query->execute();
  $movies = $query->fetchAll();
  $movies['total'] = calcule_page(count_page('id','movies_full',$par),$limit,$page);
  return $movies;
}

function movies($limit,$page)
{
  global $pdo;
  $offset = (($limit)*($page-1));
  $sql = "(SELECT id,title,year,rating,slug FROM movies_full ORDER BY title LIMIT $limit OFFSET $offset)";
  $query = $pdo->prepare($sql);
  $query->execute();
  $nb = $query->fetchAll();
  $nb['total'] = calcule_page(count_page('id','movies_full'),$limit,$page);
  return $nb;
}
