<?php
session_start();
include('includes/functions.php');
include('includes/header_back.php');

$sql ="SELECT count(*) FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$nb_abo = $query->fetchColumn();


if(isLogged())
{
  if($_SESSION['user']['status'] == 'Admin'){
    $retour_get = nettoyage($_GET);
    $type = 'consulter';
    if(!empty($retour_get['type'])){
      $type = $retour_get['type'];
    }

    if($type == 'consulter'){
      if(!isset($retour_get['page'])){
        $retour_get['page'] = 1 ;
      }
      $num = 20;
      $users = users($num,$retour_get['page']);
      $pagination = pagination($retour_get['page'],$users['total']['nb_page'],basename($_SERVER['PHP_SELF']));

      ?>

      <!-- Tableau des utilisateurs -->
      <div class="blue container-fluid table-responsive">
        <div class="row">
          <div class="col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-2 col-lg-10">

            <?php echo $pagination; ?>

            <table class="use table">
               <th>ID</th>
               <th>Pseudo</th>
               <th>Email</th>
               <th>Creation</th>
               <th>Role</th>
               <th>Action</th>
               <?php
            foreach ($users as $key => $ligne) {
              if(is_numeric($key)){
                $retour = bouton($ligne,$retour_get['page'],basename($_SERVER['PHP_SELF']));
                ?>
               <tr>
                  <td><?php echo $ligne['id'] ?></td>
                  <td><?php echo $ligne['pseudo'] ?></td>
                  <td><?php echo $ligne['email'] ?></td>
                  <td><?php echo $ligne['createdat'] ?></td>
                  <td><?php echo $ligne['status'] ?></td>
                  <td><?php echo $retour['bouton']; ?></td>
               </tr> <?php
              }
            } ?>
           </table>

           <?php echo $pagination; ?>

         </div>
       </div>

       <!-- Nombres de users + images  -->
       <div class="row">
         <div class="col-lg-12 ">
           <div class="large alimage">
             <h4 class="blue"><?php echo $nb_abo ;?> Utilisateurs</h4>
             <img src="assets/img/ut.png" alt="">
           </div>
         </div>
       </div>

      </div>
      <!-- Fin tableau utilisateurs -->

       <?php
     }
     elseif($type == 'supprimer'){
       supprimer($retour_get['id'],"users");
       header('Location:'.$_SERVER['HTTP_REFERER']);
     }
     elseif($type == 'update'){
      global $pdo;
      $sql = "UPDATE users SET status = :role WHERE id= :id";
      $query = $pdo->prepare($sql);
      $query->bindValue(':role',$retour_get['role'],PDO::PARAM_INT);
      $query->bindValue(':id',$retour_get['id'],PDO::PARAM_INT);
      $query->execute();
      header('Location:'.$_SERVER['HTTP_REFERER']);
    }

    }else{
      header('Location: index.php');
    }
}else {
  header('Location:index.php');
}
?>



<?php include('includes/footer_back.php'); ?>
