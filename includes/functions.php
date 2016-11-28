<?php
//permet de faire une inclusion meme si tu include dans un sous dossier
if(dirname('includes')){
  include 'pdo.php';
  include 'verif.php';
}else{
  include 'includes/pdo.php';
  include 'includes/verif.php';
}
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

function isAdmin() {
    if (isLogged() && $_SESSION['user']['status'] == 'Admin') {
      return true;
    }else {
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

function movies($limit,$page)
{
  global $pdo;
  $offset = (($limit)*($page-1));
  $sql = "(SELECT id,title,year,rating FROM movies_full ORDER BY id LIMIT $limit OFFSET $offset)";
  $query = $pdo->prepare($sql);
  $query->execute();
  $nb['total'] = calcule_page(count_page('id','users'),$limit,$page);
  return $nb;
}

function count_page($colone,$table,$where='')
{
  $where_full ='';
  if($where != ''){
    $where_full = 'WHERE '.$where;
  }
  global $pdo;
  $sql = "(SELECT COUNT($colone) FROM $table $where_full)";
  $query = $pdo->prepare($sql);
  $query->execute();
  $nb = $query->fetchColumn();
  return $nb;
}
function calcule_page($count,$num,$page)
{
  //on calcule le nombre de page en divisan le total par mon nombre d'article
  //et on arrondi avec ceil pour avoir un nombre entier
  $nb_page = ceil($count/$num);
  $result['nb_page'] = $nb_page;
  //on declare page et offset
  if(!empty($page) && is_numeric($page) && ctype_digit($page) && ($page <= $nb_page) && ($page > 0)){
    $result['page'] = $page;
    $result['offset'] = (($page-1)*$num);
  }else {
    $result['page'] = 1;
    $result['offset'] = 0;
  }
  return $result;
}
function pagination($page,$nb_page,$destination,$complement= '',$num='')
{
  if($nb_page > 1){ echo '<br/>';};
  echo '<div class="pagin">';
  if($page == $nb_page && $page != 1){?>
    <a href="<?php echo $destination;?>?page=<?php echo ($page-1).$complement;?>"> << </a><?php
    liste($nb_page,$destination,$page,$complement);
  }elseif ($page < $nb_page && $page > 1) { ?>
    <a href="<?php echo $destination;?>?page=<?php echo ($page-1).$complement;?>"> << </a>
    <?php liste($nb_page,$destination,$page,$complement); ?>
    <a href="<?php echo $destination;?>?page=<?php echo ($page+1).$complement;?>">  >> </a> <?php
  }elseif($page == 1 && $nb_page > 1){
  echo liste($nb_page,$destination,$page,$complement);?>
    <a href="<?php echo $destination;?>?page=<?php echo ($page+1).$complement;?>">  >> </a> <?php
  }
  echo '</div>';
  if($nb_page > 1){ echo '<br/>';};
}
function liste($nb_page,$destination,$page,$complement)
{
  for($i=1; $i <= $nb_page; $i++) {
    if($i == $page){
      $style = '<span class="actuel"><a href="'.$destination.'?page='.$i.$complement.'">'.$i.'</a></span>';
    }else {
      $style = '<span class="voisin"><a href="'.$destination.'?page='.$i.$complement.'">'.$i.'</a></span>';
    }

    if($i ==1 && $i != $page){
      echo $style;
    }elseif($i ==1 && $i == $page){
      echo $style.'<span class="voisin">...</span>';
    }elseif($i == $nb_page  && $i != $page){
      echo $style;
    }elseif($i == $nb_page  && $i == $page){
      echo '<span class="voisin">...</span>'.$style;
    }elseif($i == $page) {
      echo '<span class="voisin">...</span>'.$style.'<span class="voisin">...</span>';
    }
  }
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
