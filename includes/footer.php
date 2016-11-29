    <footer>
     <h3>MOVIES : notre super base de données de films</h3>
    <?php if(isLogged()) {
       echo '<a>Session de '. $_SESSION['user']['pseudo'] .' !</a>';
     } else { ?>
       <p><a href="register.php">Inscrivez-vous ici</a></p>
       <a href="connexion.php">Connectez-vous ici</a>
    <?php  } ?>
      <br>
      <?php

      if(file_exists('compteur_visites.txt'))
      {
              $compteur_f = fopen('compteur_visites.txt', 'r+');
              $compte = fgets($compteur_f);
      }
      else
      {
              $compteur_f = fopen('compteur_visites.txt', 'a+');
              $compte = 0;
      }
      if(!isset($_SESSION['compteur_de_visite']))
      {
              $_SESSION['compteur_de_visite'] = 'visite';
              $compte++;
              fseek($compteur_f, 0);
              fputs($compteur_f, $compte);
      }
      fclose($compteur_f);
      echo '<strong>'.$compte.'</strong> visites.';
      ?>
    </footer>

  <script type="text/javascript" src="assets/js/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/app.js"></script>
  </body>
</html>
