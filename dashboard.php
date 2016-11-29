<?php
include 'includes/pdo.php';
include 'includes/functions.php';

$sql ="SELECT count(*) FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$nb_abo = $query->fetchColumn();

$sql ="SELECT count(*) FROM movies_full";
$query = $pdo->prepare($sql);
$query->execute();
$nb_films = $query->fetchColumn();

// debug ($nb_films);
$sql ="SELECT count(*) FROM movies_user_liste";
$query = $pdo->prepare($sql);
$query->execute();
$nb_Ajfilms = $query->fetchColumn();

// test
$sql ="SELECT count(*) FROM movies_full WHERE rating > 90";
$query = $pdo->prepare($sql);
$query->execute();
$ratingfilm = $query->fetchColumn();


?>
<?php include 'includes/header_back.php'; ?>

	<!-- <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>Back-Office</span>JLBS Production</a>
				<ul class="user-menu"> -->
					<!-- <li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
						<! ul class="dropdown-menu" role="menu">
							<li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
							<li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul> -->
					<!-- </li>  -->
				<!-- </ul>
			</div>
		</div><! /.container-fluid -->
	<!-- </nav> -->

	<!-- <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
			<ul class="nav menu">
			<li class="active"><a href="index.html"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li><a href="users_back.php"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg> Utilisateurs</a></li>
			<li><a href="movies_back.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Films</a></li>
			<li><a href="#"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> page3</a></li>
			<li><a href="#"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> page4</a></li>
		</ul>

	</div>sidebar-->

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo $nb_Ajfilms ;?></div>
							<div class="text-muted">Films ajoutés</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked empty-message"><use xlink:href="#stroked-empty-message"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo $nb_films ;?></div>
							<div class="text-muted">Nombre de films Total</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?php echo $nb_abo ;?></div>
							<div class="text-muted">Nombre d'abonnés</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">
								<p><?php

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
								?></p>
							</div>
							<div class="text-muted">Nombre de visites</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Statistiques du site</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->

		<div class="row">
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4 class="dash">Films notés plus de 90/100</h4>
						<?php echo $ratingfilm; ?>
						<div class="easypiechart" id="easypiechart-blue" data-percent="92" ><span class="percent">
							<?php
								$Pourcent =  Pourcentage($ratingfilm, 100);
								echo $Pourcent.'%';
								?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4 class="dash">Objectif Nombre de films enregistrés 10000</h4>
						<?php echo $nb_films ;?>
						<div class="easypiechart" id="easypiechart-orange"><span class="percent">
							<?php
								$Pourcent =  Pourcentage($nb_films, 10000);
								echo $Pourcent.'%';
								?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4 class="dash">Obhectif nombre d'abonnés 500</h4>
						<p><?php echo $nb_abo; ?></p>
						<div class="easypiechart" id="easypiechart-teal" ><span class="percent">
							<?php
								$Pourcent =  Pourcentage($nb_abo, 500);
								echo $Pourcent.'%';
								?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-body easypiechart-panel">
						<h4 class="dash">Objectif Visiteurs 250/jour</h4>
							<p><?php
			      		echo '<strong>'.$compte.'</strong> visites.';
			      		?></p>
								<div class="easypiechart" id="easypiechart-red" ><span class="percent">
							<?php
								$Pourcent =  Pourcentage($compte, 250);
								echo $Pourcent.'%';
								?>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->


				</div>

			</div><!--/.col-->
		</div><!--/.row-->
	</div>	<!--/.main-->

  <?php include 'includes/footer_back.php';
