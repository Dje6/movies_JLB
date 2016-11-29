<?php

function url_transfert($r_GET)
{
  $url='';
  foreach ($r_GET as $key => $value) {
    if($key != 'page'){
      if(is_array($value)){
        foreach ($value as $key_y => $value_y) {
          $url .= '&'.$key.'%5B%5D='.$value_y ;
        }
      }else{
        $url .= '&'.$key.'='.$value;
      }
    }
  }
  return $url;
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
  $html = '';

  if($nb_page > 1){ $html .='<br/>';};
  $html .='<div class="pagin">';

  if($page == $nb_page && $page != 1){
    $html .='<a href="'.$destination.'?page='.($page-1).$complement.'"> << </a>';
    $html .= liste($nb_page,$destination,$page,$complement);
  }elseif ($page < $nb_page && $page > 1) {
    $html .= '<a href="'.$destination.'?page='.($page-1).$complement.'"> << </a>';
    $html .= liste($nb_page,$destination,$page,$complement);
    $html .= '<a href="'.$destination.'?page='.($page+1).$complement.'">  >> </a>';
  }elseif($page == 1 && $nb_page > 1){
    $html .= liste($nb_page,$destination,$page,$complement);
    $html .= '<a href="'.$destination.'?page='.($page+1).$complement.'">  >> </a>';
  }
  $html .='</div>';
  if($nb_page > 1){
    $html .='<br/>';
  }
  return $html;
}
function liste($nb_page,$destination,$page,$complement)
{
  $html ='';
  for($i=1; $i <= $nb_page; $i++) {
    if($i == $page){
      $style = '<span class="actuel"><a href="'.$destination.'?page='.$i.$complement.'">'.$i.'</a></span>';
    }else {
      $style = '<span class="voisin"><a href="'.$destination.'?page='.$i.$complement.'">'.$i.'</a></span>';
    }

    if($i ==1 && $i != $page){
      $html .= $style;
    }elseif($i ==1 && $i == $page){
      $html .= $style.'<span class="voisin">...</span>';
    }elseif($i == $nb_page  && $i != $page){
      $html .= $style;
    }elseif($i == $nb_page  && $i == $page){
      $html .= '<span class="voisin">...</span>'.$style;
    }elseif($i == $page) {
      $html .= '<span class="voisin">...</span>'.$style.'<span class="voisin">...</span>';
    }
  }
  return $html;
}
