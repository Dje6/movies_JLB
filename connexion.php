<?php
session_start();
include 'includes/pdo.php';
include 'includes/functions.php';


include 'includes/header.php';
 $error = array();
   if(!empty($_POST['submit'])) {

     $pseudo = trim(strip_tags($_POST['pseudo']));
     $password = trim(strip_tags($_POST['password']));

  $sql = "SELECT * FROM users WHERE pseudo = :pseudo
          OR email = :pseudo";

    $query = $pdo->prepare($sql);
    $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();



    if(!empty($user)){
          if(password_verify($password, $user['password'])) {

                $_SESSION['user']= array(
                 'pseudo'=> $user['pseudo'],
                 'id'=>$user['id'],
                 'status'=>$user['status'],
                 'ip'=> $_SERVER['REMOTE_ADDR']
               );
               header('Location: index.php');
               exit;
          } else {
            echo '<h4 class="invalide"> Votre mot de passe est invalide. </h4>';
          }


     } else {
 	    $error['pseudo'] = '<h4 class="invalide">L\'utilisateur n\'existe pas </h4>';
     }



  }






?>

<div class="container">
  <div class="row">
    <form id="form_connexion" action="" method="POST" class="">
      <br>
      <fieldset style="margin: auto;">
        <legend>CONNEXION</legend>

        <label for="pseudo">Votre Pseudo</label>
        <span id="error_pseudo"><?php if(!empty($error['pseudo'])) { echo $error['pseudo']; } ?></span>
        <input type="text" id="pseudo_connexion" name="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>">
        <br><br>

        <label for="password">Votre Password</label>
        <input type="password" id="password_connexion" name="password" value="">
        <br><br>

        <input type="checkbox" name="souvenir" value="souvenir"><span> Se souvenir de moi</span>
        <br><br>

        <input class="bouton" type="submit" name="submit" value="Se connecter">

        <br>
        <a href="password_rescue.php"><span class="small">Mot de passe oublié ?</span></a>
        <br>
      </fieldset>

    </form>
  </div>
</div>







<?php include 'includes/footer.php'; ?>
