<?php
include 'includes/pdo.php';
include 'includes/functions.php';




include 'includes/header.php';




$host="localhost";
$utilisateur="root";
$motdepasse="";
$base="movies_user_list";
$conexion=mysql_connect($host,$utilisateur,$motdepasse) or die('Connexion impossible: ' . mysql_error());
$db=mysql_select_db($base, $conexion) or die('Connexion a la base impossible : ' . mysql_error());
$query=mysql_query('SELECT MONTH(dates) AS mois, libelle_produit,(SELECT SUM(quantite) FROM vente
WHERE produit.id_produit=vente.id_produit AND MONTH(dates)=mois AND YEAR(dates)=2008)as qtvendu FROM vente,produit
WHERE produit.id_produit=vente.id_produit AND produit.id_produit=1 AND YEAR(dates)=2008 GROUP BY mois ORDER BY mois ASC');




<?php include 'includes/footer.php'; ?>
