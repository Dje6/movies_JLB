<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>JLB - Movies</title>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-default navbar-inverse">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><span>JLB - Productions</span></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- Recherche a gauche de header -->
            <form class="navbar-form navbar-left">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>

            <!-- Liens a droite de header -->
            <ul class="nav navbar-nav navbar-right">
              <!-- Si l'utilisateur est connecté, on dit bonjour et on propose deconnexion -->
              <?php if (isLogged()) {
                echo '<li><a>Bonjour '. $_SESSION['user']['pseudo'] .' !</a></li>'; ?>
                <li><a href="deconnexion.php">Déconnexion</li></a>

              <?php } else { ?>
                <!-- Si l'utilisateur n'est pas connecté, on affiche les deux liens -->
                <li><a href="register.php">Inscription</a></li>
                <li><a href="connexion.php">Connexion</a></li>
              <?php } ?>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </header>
