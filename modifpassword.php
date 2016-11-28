<?php
session_start();
include 'includes/pdo.php';
include 'includes/functions.php';
include 'includes/header.php';
//recupérer les informations passées danzs le GET
if ( (!empty($_GET['email'])) && (!empty($_GET['token'])) ) {
  $email = $_GET['email'];
  $token = $_GET['token'];


//comparer les infos à la base de donnée (email et token)
$sql = "SELECT email, token FROM users WHERE email = :email AND token = :token";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':token', $token, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch();


    // si les infos sont bonnes, afficher le formaulaire de changement de mot de passe
if(!empty($user)) {
  $error = array();
  if(($user['email'] == $email) && ($user['token'] == $token)) {
    if (!empty($_POST['submit'])) {
      $newPassword = trim(strip_tags($_POST['newpassword']));
      $confirmPassword = trim(strip_tags($_POST['retapepassword']));

      //faire les verifications habituelles du formulaire
      // newpassword
      if(!empty($newPassword)) {
        if(strlen($newPassword) < 5 ) {
          $error['password'] = 'votre password est trop court';
        } elseif(strlen($newPassword) > 20) {
          $error['password'] = 'votre password est trop long';
        }
      } else {
        $error['password'] = 'veuillez renseigner ce champs';
      }
      // confirmPassword
      if(!empty($confirmPassword)) {
        //allez revérifier si le token et l'email sont toujours les bons (re comparer les infos du get avec le resultat de la premier requette)
        if($confirmPassword != $newPassword ) {
          $error['reapeatPassword'] = 'votre password est différent';
        }
      } else {
        $error['reapeatPassword'] = 'veuillez renseigner ce champs';
      }

      if (count($error) == 0) {
        if ( ($user['email'] == $email) && ($user['token'] == $token) ) {
          //si les infos sont bonnes changer le token faire un update des informations de l'utilisateur avec le nouveau mot de passe et le nouveau token
          $newToken = generateRandomString(50);
          $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

          $sql = "UPDATE users SET password = :newpassword, token = :newtoken WHERE email = :email AND token = :token";
          $query = $pdo->prepare($sql);
          $query->bindValue(':newpassword', $hashedNewPassword, PDO::PARAM_STR);
          $query->bindValue(':newtoken', $newToken, PDO::PARAM_STR);
          $query->bindValue(':email', $email, PDO::PARAM_STR);
          $query->bindValue(':token', $token, PDO::PARAM_STR);
          $query->execute();

          // rediriger vers la page de connexion

          header('Location: connexion.php');

        }
      }


    }



    ?>
    <form class="" action="#" method="POST">
      <label for="newpassword">Nouveau mot de passe</label>
      <span><?php if(!empty($error['password'])) { echo $error['password']; } ?></span>
      <input type="password" name="newpassword" value="<?php if (!empty($_POST['newpassword'])) { echo $_POST['newpassword']; } ?>">

      <label for="retapepassword">Retappez votre mot de passe</label>
      <span><?php if(!empty($error['reapeatPassword'])) { echo $error['reapeatPassword']; } ?></span>
      <input type="password" name="retapepassword" value="<?php if (!empty($_POST['retapepassword'])) { echo $_POST['retapepassword']; } ?>">

      <input type="submit" name="submit" value="Envoyer">

    </form>
    <?php
  }
}


} else {
 header('Location: index.php');
  }
