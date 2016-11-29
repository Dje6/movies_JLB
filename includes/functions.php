<?php
//permet de faire une inclusion meme si tu include dans un sous dossier
if(dirname('includes')){
  $prefix = '';
}else{
  $prefix='includes/';
}
  include $prefix.'pdo.php';
  include $prefix.'verif.php';
  include $prefix.'authentification.php';
  include $prefix.'sql_affichage.php';
  include $prefix.'pagination.php';

function debug ($array) {
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}

//function generer une random string (pour token)
function generateRandomString($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
};

function etoile_rating_return($note,$echelle)
{
  $total = $echelle;

  if($total == 0)
  {
    $note = 1;
  }else {
    $note = ($note/($total/100));
  }

  $vide = '<i class="fa fa-star-o"></i>';
  $demi = '<i class="fa fa-star-half-empty"></i>';
  $plein = '<i class="fa fa-star"></i>';
  $entiere = (int)($note/20) ;
  $moitier = (int)(($note % 20) / 10);
  $creuse = (5 - ($moitier + $entiere));

  return (str_repeat($plein, $entiere)).(str_repeat($demi, $moitier)).(str_repeat($vide, $creuse));
}




function bouton($ligne,$page,$destination)
{
 if(isset($ligne['status'])){
   if($ligne['status'] == 'Admin'){
     $bouton = '<a href="'.$destination.'?id='.$ligne['id'].'&page='.$page.'&type=update&role=User" title="User">
     <button name="button" ><i class="fa fa-arrow-down"></i></button></a>
     <a href="'.$destination.'?id='.$ligne['id'].'&page='.$page.'&type=supprimer" title="supprimer">
     <button name="button" ><i class="fa fa-trash"></i></button></a>';
     $retour = array('bouton'=> $bouton);
     return($retour);
   }elseif($ligne['status'] == 'User' || $ligne['role'] == 'user'){
     $bouton = '<a href="'.$destination.'?id='.$ligne['id'].'&page='.$page.'&type=update&role=Admin" title="Admin">
     <button name="button" ><i class="fa fa-arrow-up"></i></button></a>
     <a href="'.$destination.'?id='.$ligne['id'].'&page='.$page.'&type=supprimer" title="supprimer">
     <button name="button" ><i class="fa fa-trash"></i></button></a>';
     $retour = array('bouton'=> $bouton);
     return($retour);
   }
 }
}
function showJson($data)
{
  header("Content-type: application/json");
  $json = json_encode($data,JSON_PRETTY_PRINT);
  if($json){
    die($json);
  }else{
    die("error in Json encoding");
  }
}

// test Pourcentage
function Pourcentage($Nombre, $Total) {
  return $Nombre * 100 / $Total;
}
