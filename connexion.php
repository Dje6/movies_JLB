<?php
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

                $_SESSION['user']=array (
                 'pseudo'=> $user['pseudo'],
                 'id'=>$user['id'],
                 'role'=>$user['role'],
                 'ip'=> $_SERVER['REMOTE_ADDR']
               );
               echo 'BIENVENUE CHER UTILISATEUR';
               header('Location: index.php');

          } else {
            echo 'Votre mot de passe est invalide.';
          }


     } else {
 	    echo 'L\'utilisateur n\'existe pas';
     }



  }






?>
<div class="connexion">
  <form id="form_connexion" action="" method="POST">
    <br>
    <label for="pseudo">Pseudo</label>
    <span id="error_pseudo"><?php if(!empty($error['pseudo'])) { echo $error['pseudo']; } ?></span>
    <input type="text" id="pseudo_connexion" name="pseudo" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>">
    <br><br>

    <label for="password">Password</label>
    <input type="password" id="password_connexion" name="password" value="">
    <br>
    <br>
    <a href="modifpassword.php">Mot de Passe oublié</a>
    <br>


    <input class="bouton" type="submit" name="submit" value="envoyer">
  </form>
</div>







<?php include 'includes/footer.php'; ?>
