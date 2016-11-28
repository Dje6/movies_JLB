<?php

include 'includes/pdo.php';
include 'includes/verif.php';
function debug ($array) {
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}

//Fonction qui verifie si l'utilisateur est connecté
function isLogged() {
  if (!empty($_SESSION['user']) && !empty($_SESSION['user']['id']) && !empty($_SESSION['user']['pseudo']) && !empty($_SESSION['user']['status']) && !empty($_SESSION['user']['ip'])) {

    //On recup l'IP de la machine quand le user est sur l'index apres connexion
    $ip = $_SERVER['REMOTE_ADDR'];
    //Si l'IP recupéré correspond a l'IP rentré au moment de la création de la session (connexion du user)
    if ($ip == $_SESSION['user']['ip']) {
      return true;
    }
  } else {
    return false;
  }
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
function etoile_rating($note,$echelle)
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

echo (str_repeat($plein, $entiere)).(str_repeat($demi, $moitier)).(str_repeat($vide, $creuse));
}

function etoile_like($like,$dislike)
{
$total = $like + $dislike;

if($total == 0)
{
  $note = 1;
}else {
  $note = ($like/($total/100));
}

$vide = '<i class="fa fa-star-o"></i>';
$demi = '<i class="fa fa-star-half-empty"></i>';
$plein = '<i class="fa fa-star"></i>';
$entiere = (int)($note/20) ;
$moitier = (int)(($note % 20) / 10);
$creuse = (5 - ($moitier + $entiere));

echo (str_repeat($plein, $entiere)).(str_repeat($demi, $moitier)).(str_repeat($vide, $creuse));
}
