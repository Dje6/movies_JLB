<?php
include('vendor/autoload.php');
include('includes/functions.php');
include('includes/header.php');
$error = array();
if($_GET){
  $r_GET = nettoyage($_GET);
  if(!empty($r_GET['email']) && !empty($r_GET['token'])){
    // ($email , $typeverif) $typeverif = 1 , on verifie si il exist si oui erreur ; $typeverif = 2 erreur si il n'exsit pas
    if(!empty(verif($r_GET['email'],'','','Email',true,1,'users','email'))){
        $error['error'] = verif($r_GET['email'],'','','Email',true,1,'users','email');
    }else{
      if(is_array(is_token($r_GET['email'],$r_GET['token']))){
        $error['token'] = is_token($r_GET['email'],$r_GET['token'])['info'];
      }else{
        $_password = is_token($r_GET['email'],$r_GET['token']);
      }
    }
  }else{
    echo 'il manque des donnee';
  }
  $_email = $r_GET['email'];
  $_token = $r_GET['token'];
}
if($_POST){
  $r_POST = nettoyage($_POST);
  if ($r_POST['cap'] == NULL)
  {
    if(!empty($r_POST['email']) && !empty($r_POST['token']) && !empty($r_POST['old'])){
      // ($email , $typeverif) $typeverif = 1 , on verifie si il exist si oui erreur ; $typeverif = 2 erreur si il n'exsit pas

      if(!empty(verif($r_POST['email'],'','','Email',true,1,'users','email'))){
        $error['email'] = verif($r_POST['email'],'','','Email',true,1,'users','email');;
      }else{
        if(is_array(is_token($r_POST['email'],$r_POST['token']))){
          $error['token'] = is_token($r_POST['email'],$r_POST['token'])['info'];
        }else{
          $_password = is_token($r_POST['email'],$r_POST['token']);
        }
      }
      if(!empty(is_password($r_POST['password'],6,255))){
        $error['password'] = is_password($r_POST['password'],6,255);
      }else{
        if(!empty(is_r_password($r_POST['password'],$r_POST['r_password']))){
          $error['r_password'] = is_r_password($r_POST['password'],$r_POST['r_password']);
        }else{
          if(password_verify($r_POST['r_password'], $r_POST['old'])){
            $error['r_password'] = 'Vous ne pouvez pas reutiliser le meme mot de passe';
          }
        }
      }
      $_email = $r_POST['email'];
      $_token = $r_POST['token'];
    }else{
      $error['post'] = 'il manque des donnee';
    }
  }
  else
  {
  $error['bot'] = "vous etes un brute force ou un robot";
  }
}

if(!empty($error) || !$_POST){
  ?>
    <form action="" method="post">
  <label for="password">New Password* :</label><br />
  <?php if(isset($error['password'])){echo "<span style='font-weight:bold;color:red;'>".$error['password']."</span><br/>";}?>
    <input type="password" id="password" name="password" value="<?php if(isset($r_POST['password'])){echo $r_POST['password'] ; }?>" />
    <br />
    <label for="r_password">Repeat Password* :</label><br />
    <?php if(isset($error['r_password'])){echo "<span style='font-weight:bold;color:red;'>".$error['r_password']."</span><br/>";}?>
      <input type="password" id="r_password" name="r_password" />
      <input type="hidden" id="email" name="email" value="<?php echo $_email ;?>"/>
      <input type="hidden" id="token" name="token" value="<?php echo $_token ;?>"/>
      <input type="hidden" id="old" name="old" value="<?php echo $_password ;?>"/>
      <input type="hidden" id="cap" name="cap" />
      <input type="submit" value="Valider"/>
    </form>
      <?php
}else{
    global $pdo;
    $token = str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $pass = password_hash($r_POST['password'], PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = :password,token = :token WHERE email= :email";
    $query = $pdo->prepare($sql);
    $query->bindValue(':email',$r_POST['email'],PDO::PARAM_STR);
    $query->bindValue(':password',$pass,PDO::PARAM_STR);
    $query->bindValue(':token',$token,PDO::PARAM_STR);
    if($query->execute()){

    echo 'Votre mot de passe a bien ete changer <br/>';
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

    $mail->Subject = 'Mot de passe changer';
    $mail->Body    = 'Bonjour , <br/>
    Votre mot de passe a ete remplacer par l\' IP : '.$_SERVER['REMOTE_ADDR'].' le '.date("d/m/Y").' a '.date("H:i:s").' <br/>
    Si vous n\'avez pas effectuer cette action , contacter au plus vite notre administrateur afin de recuperer votre compte' ;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Un email de confirmation vous a été envoyer';
    }
  }else{
    echo 'une erreur est survenu';
  }
}
include('includes/footer.php');
