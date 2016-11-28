<?php
session_start();
include 'includes/pdo.php';
include 'includes/functions.php';
?>


<?php  include 'includes/header.php';

$error = array();



 // verifie si mon formulaire est soumis

 //verifie si mon formulaire est soumis

 if(!empty($_POST['submit'])) {
    //sécurité +++++ faille XSS
   $pseudo = trim(strip_tags($_POST['pseudo']));
   $email = trim(strip_tags($_POST['email']));
   $password = trim(strip_tags($_POST['password']));
   $reapeatPassword = trim(strip_tags($_POST['reapeatPassword']));


        //NOM
         if(!empty($pseudo)) {
                 if(strlen($pseudo) < 3 ) {
                    $error['pseudo'] = 'votre pseudo est trop court';
                 } elseif(strlen($pseudo) > 40) {
                    $error['pseudo'] = 'votre pseudo est trop long';
                 }  else {
                       $sql = "SELECT id FROM users WHERE pseudo = :pseudo";
                       $query = $pdo->prepare($sql);
                       $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
                       $query->execute();

                        // bind value

                       $user = $query->fetch();
                     if(!empty($user)) {
                       $error['pseudo'] = 'Ce pseudo est déjà utilisé';
                     }
                 }
         } else {
             $error['pseudo'] = 'veuillez renseigner ce champs';
         }

        //Email
           if(!empty($email)) {
             if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
               $error['email'] = 'adresse email invalide';
             } else {
                 $sql = "SELECT id FROM users WHERE email = :email";
                 $query = $pdo->prepare($sql);
                 $query->bindValue(':email',$email,PDO::PARAM_STR);
                 $query->execute();
                 $users = $query->fetch();
               if(!empty($users)) {
                 $error['email'] = 'Cet email est déjà utilisé';
               }
             }
           } else {
                 $error['email'] = 'veuillez renseigner ce champs';
           }

        //password
           if(!empty($password)) {
             if(strlen($password) < 5 ) {
                $error['password'] = 'votre password est trop court';
             } elseif(strlen($password) > 20) {
                $error['password'] = 'votre password est trop long';
             }
       } else {
               $error['password'] = 'veuillez renseigner ce champs';
       }

        //reapeat Password
       if(!empty($reapeatPassword)) {
         if($reapeatPassword != $password ) {
            $error['reapeatPassword'] = 'votre password est différent';
           }
        } else {
            $error['reapeatPassword'] = 'veuillez renseigner ce champs';
        }

   if(count($error) == 0 ) {


        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $token = generateRandomString(50);

        $role = 'user';
       $inscription = "INSERT INTO users VALUES('',:pseudo,:email,:password,:token,NOW(),'user')";
       $smtp = $pdo->prepare($inscription);
       $smtp->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
       $smtp->bindValue(':email',$email,PDO::PARAM_STR);
       $smtp->bindValue(':password',$hashedPassword,PDO::PARAM_STR);
       $smtp->bindValue(':token',$token,PDO::PARAM_STR);
       $smtp->execute();
       $success = true;

       header('location: index.php');

   }
 }

?>
<div class="container">
  <div class="row">

    <form id="form_inscription" action="" method="POST" class="col-md-offset-2">
      <br>
      <fieldset>
        <legend>INSCRIPTION</legend>
            <label for="pseudo">Votre Pseudo</label>
            <span id="error_pseudo"></span>
            <input type="text" id="pseudo_ins" name="pseudo" value="">
            <br><br>

            <label for="email">Votre Email</label>
            <span id="error_email"></span>
            <input type="text" id="email_ins" name="email" value="">
            <br><br>

            <label for="password">Mot de Passe</label>
            <span id="error_password"></span>
            <input type="password" id="password_ins" name="password"  value="">
            <br>

            <label for="reapeatPassword">Vérif Mot de Passe</label>
            <span></span>
            <input type="password" name="reapeatPassword"  value="">
            <br>
            <br>
            <input type="checkbox" name="souvenir" value="souvenir"> Se souvenir de moi.<br>
      </fieldset>
      <input class="boutonRegister" type="submit" name="submit" value="Je m'inscris">
      <input class="boutonReset" type="reset">
    </form>

  </div>
</div>




















<?php include 'includes/footer.php'; ?>
