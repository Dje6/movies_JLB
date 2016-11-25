<?php
include 'includes/pdo.php';
include 'includes/functions.php';





include 'includes/header.php';





?>
<div class="evaluation">
  <h4>Moyenne des évaluations</h4>
  <h2><?php   echo $movie['popularity']; ?> <small class="red">Popularité</small></h2>
  <h2><?php   echo $movie['rating']; ?> <small class="red">/ 100</small></h2>
</div>


	<div class="container text-center">
	    <form class="form-signin" data-ember-action="2">
	    	<h2 class="form-signin-heading">Sign in</h2>

			<small class="text-muted">Connect [your service] with your favorite social network</small>
			<br><br>


<p>
<a class="btn btn-primary social-login-btn social-facebook" href="/auth/facebook"><i class="fa fa-facebook"></i></a>
<a class="btn btn-primary social-login-btn social-twitter" href="/auth/twitter"><i class="fa fa-twitter"></i></a>
</p>
<p>
<a class="btn btn-primary social-login-btn social-linkedin" href="/auth/linkedin"><i class="fa fa-linkedin"></i></a>
<a class="btn btn-primary social-login-btn social-google" href="/auth/google"><i class="fa fa-google-plus"></i></a>
</p>



	        <button class="btn btn-lg btn-primary btn-block btn-center" type="submit" data-bindattr-3="3">Sign in</button>
	        <br>

	    </form>
    </div>
