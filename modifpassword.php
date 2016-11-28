<?php

include 'includes/pdo.php';
include 'includes/functions.php';



include('includes/header.php');
?>




<div class="container">
  <div class="row">
    <div class="form_modif">
    <p>MOT DE PASSE OUBLIÉ</p>
    <p>Pour récupérer votre mot de passe : veuillez saisir ci-dessous votre adresse mail. </p>
      <form action="" method="POST">
        <br>
        <label for="email">Entrez votre Email</label>
          <span><?php if(!empty($error['email'])) { echo $error['email']; } ?></span>
          <input type="email" name="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
          <br><br>
          <input class="bouton" type="submit" name="submit" value="Demande de renvoie de mot de passe">
      </form>
    </div>
  </div>
</div>














<?php include('includes/footer.php');
