<?php
//permet de retourner la date et lheure au format francais
//trim stip tag la totaliter de l'array recu ex : $_POST ou $_GET
function nettoyage($array)
{
  $monarray = array();
  foreach ($array as $key => $value) {
      if(is_array($value)){
        foreach ($value as $key_y => $value_y) {
              $monarray[$key][$key_y] = trim(strip_tags($value_y));
        }
      }else{
        $monarray[$key] = trim(strip_tags($value));
      }
  }
  return($monarray);
}
//Full verif en une
//(element a verifier, minimum,maximum,text d'erreur, verif si c un mail, la verif en bdd, la table , la colone)
function verif($verif,$min=NULL,$max=NULL,$text_error,$verif_mail = false,$verif_num = false,$exist=NULL,$table=NULL,$colone=NULL)
{
 $error = '';

 if(!empty($verif)) {
   if ($verif_mail == true) {
     if(filter_var($verif, FILTER_VALIDATE_EMAIL) == false) {
       $error = '* Votre email n\'est pas valide';
     }
   }
   if ($verif_num == true) {
     if(!is_numeric($verif)) {
       $error = '* N\'est pas un nombre';
     }
   }
   if($min && $max){
     if(strlen($verif) < $min) {
       $error =  '* Le '.$text_error.' est trop court';
     } elseif(strlen($verif) > $max) {
       $error =  '* Le '.$text_error.' est trop long';
     }
   }
     if($table && $colone){
       global $pdo;
       $sql = "SELECT COUNT(*) FROM $table WHERE $colone = :argument ";
       $query = $pdo->prepare($sql);
       $query->bindValue(':argument', $verif, PDO::PARAM_STR);
       $query->execute();
       if($exist == 1){
         if($query->fetchColumn() <= 0){
           $error = 'Ce '.$text_error.' n\'existe pas';
         }
       }elseif($exist == 0){
         if($query->fetchColumn() >= 1){
           $error = 'Ce '.$text_error.' exist deja';
         }
       }
     }
 } else {
   $error = '* Veuillez renseigner ce champs';
 }

 return $error;

}


function is_password($password,$min,$max)
{

  if(!empty($password)){
    if(strlen($password)< $min){
      $error ='Votre mot de passe est trop court ('.$min.' Caracteres minimum)';
    }elseif(strlen($password) > $max) {
      $error ='Votre mot de passe est trop long ('.$max.' Caracteres maximum)';
    }
  }else{
    $error ='Merci d\'ecrir un mot de passe entre '.$min.' et '.$max.' caracteres';
  }
  if(isset($error))
  {
    return $error;
  }
}
// (le password repeter , le password orignal , min max)
function is_r_password($r_password,$password)
{
  if(!empty($r_password)){
    if($r_password != $password){
      $error ='Vos mots de passe doivent etre identique';
    }
  }else{
    $error ='Merci d\'ecrir de nouveau votre mot de passe';
  }
  if(isset($error))
  {
    return $error;
  }
}
function is_token($mail,$token)
{
  $error = array();
  if (!empty($mail) && !empty($token)){

    global $pdo;
    $sql = "SELECT password FROM users WHERE email = :email AND token = :token ";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $mail, PDO::PARAM_STR);
    $query->bindValue(':token', $token, PDO::PARAM_STR);
    $query->execute();
    $nb = $query->fetch();
    if(empty($nb)){
      $error['info'] = 'une erreur d\identifiation es survenu, merci de contacter l\'administration';
    }else{
      return $nb['password'];
    }
  }
  else{
    $error['info'] ="il manque des information";
  }
  if(isset($error))
  {
    return $error;
  }
}

// AUTRE
function Hfrance($time)
{
  echo strftime("%d/%m/%Y à %H:%M", strtotime($time));
}
//verifie qu il y a un contenu ainsi que les limit de caractere
function is_content($content,$min,$max)
{

  if(!empty($content)){
    if(strlen($content)< $min){
      $error ='Votre message est trop court ('.$min.' Caracteres minimum)';
    }elseif(strlen($content) > $max) {
      $error ='Votre message est trop long ('.$max.' Caracteres maximum)';
    }
  }else {
    $error ='Vous devez ecrir un texte entre '.$min.' et '.$max.' caracteres';
  }
  if(isset($error))
  {
    return $error;
  }
}

function is_date()
{

  if(isset($error))
  {
    return $error;
  }

}
function is_age()
{

  if(isset($error))
  {
    return $error;
  }

}
//verifie que la recherche n'est ni vide ni tro longue
function is_search($search,$max)
{
  if(!empty($search)){
    if(strlen($search) > $max) {
      $error ='Votre recherche est trop long ('.$max.' Caracteres maximum)';
    }
  }else{
    $error ='Merci d\'ecrir une recherche de maximum '.$max.' caracteres et minimum 1';
  }
  if(isset($error))
  {
    return $error;
  }
}

function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}
?>
