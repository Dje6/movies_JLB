<?php

include 'includes/pdo.php';
include 'includes/functions.php';

if(userlog()) {
  header('location: index.php');
}


//verifier si l'utilisateur est dans la base de donnée
if(!empty($_POST['submit'])) {
  $email = trim(strip_tags($_POST['email']));

  if(!empty($email)) {
    // on va chercher le mail dans la bdd
    $sql = "SELECT email, token FROM users WHERE email = :email";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();
        debug($user);



      if(!empty($user)) {
        $query = '';
        $query = '<a href="http://localhost/projet_commun_movies/movies_JLB//modifpassword.php?email=' . $user["email"] . '&token=' . $user["token"] . '">Cliquez ici</a>';


        // Etape envoyer le mail
        $to      = $user["email"];
        $subject = 'reinitialisation';
        $message = 'reinitialiser a cette adresse : ' . '<a href="http://localhost/projet_commun_movies/movies_JLB//modifpassword.php?email=' . urlencode($user["email"]) . '&token=' . $user["token"] . '">Cliquez ici</a>';
        // echo $message;
        // die();
        $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        // echo $to . $subject . $message . $headers;
        // die();

        mail($to, $subject, $message, $headers);


      }
  }
}








include('include/header.php');
?>

<p>MOT DE PASSE OUBLIÉ</p>
<p>Pour récupérer votre mot de passe : veuillez saisir ci-dessous votre adresse mail. </p>
<form action="" method="POST">
  <br>
<label for="email">Email</label>
  <span><?php if(!empty($error['email'])) { echo $error['email']; } ?></span>
  <input type="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
  <br><br>
<input class="bouton" type="submit" name="submit" value="Valider">
</form>






<a href="http://kjdsqbsqjhbds.php?email=emailenphp&token=tokenphp"></a>









<?php include('include/footer.php');
