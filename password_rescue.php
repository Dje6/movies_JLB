<?php
include('vendor/autoload.php');
include ('includes/functions.php');
include('includes/header.php');
$error =array();
if($_POST){
  $r_POST = nettoyage($_POST);
  if(empty($r_POST['capcha'])){
    // (element , taille mini , taille maxi , erreur a retourner , si c un mail ,la verif dexistence, la table , la colone)

    $error['error'] = verif($r_POST['email'],'','','Email',true,1,'users','email');
    if(empty($error['error']))
    {
      global $pdo;
      $sql = "SELECT token FROM users WHERE email = :email";
      $query = $pdo->prepare($sql);
      $query->bindValue(':email', $r_POST['email'], PDO::PARAM_STR);
      $query->execute();
      $nb = $query->fetch();
      $mail = new PHPMailer;

      //$mail->SMTPDebug = 3;                              // Enable verbose debug output
      $mail->isMail();
      $mail->setFrom('sim.oignon@xamp.com', 'Mailer');
      $mail->addAddress($r_POST['email'], '');
      $mail->addReplyTo('dans-ton-cu@xamp.com', 'Information');
      // $mail->addCC('cc@example.com');
      // $mail->addBCC('bcc@example.com');
      // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
      $mail->isHTML(true);                                  // Set email format to HTML

      $mail->Subject = 'Restauration de votre mot de passe';
      $mail->Body    = 'Bonjour , <br/>
      Une demande de changement de mot de passe a ete faite par l\' IP : '.$_SERVER['REMOTE_ADDR'].' le '.date("d/m/Y").' a '.date("H:i:s").' <br/>
      Si vous etes le demandeur veuillez cliquer sur ce lien pour changer votre mot de passe :
      <a href="http://127.0.0.1/ecole/php/commun/movies_JLB/resetpassword.php?email='.$r_POST['email'].'&token='.$nb['token'].'">Cliquez ici</a><br/>
      Sinon merci de contacter l\'administration pour signaler le probleme.' ;
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      if(!$mail->send()) {
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
      } else {
        echo 'un email vous a ete envoyer , merci de cliquer sur le lien
        contenu dans le mail pour reinitialiser votre mot de passe';
      }
      exit();
    }
  }else{
    echo 'tu es un robo';
    exit();
  }
}
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
          <input type="hidden" name="capcha" value="">
          <br><br>
          <input class="bouton" type="submit" name="submit" value="Demande de renvoie de mot de passe">
      </form>
    </div>
  </div>
</div>

<?php include('includes/footer.php');
