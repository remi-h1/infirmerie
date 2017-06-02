<?php
//gestion des absences
//page accueil
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<link rel="stylesheet" href="style.css">

<h1><center>Visites à l'infirmerie</center></h1>
<center>Cette page permet de trier le nombre de visites par jour.</center>
</head>

<body>

<!-- Menu de navigation du site -->
<ul class="navbar">
  <li><a href="Accueil.html">Accueil</a>
  <li><a href="Visites.html">Visites</a>
  <li><a href="jour.html">Jour</a>
  <li><a href="Periode.html">Periode</a>
  <li><a href="Elève.html">Elève</a>
  <li><a href="Motif.html">Motif</a>
  <li><a href="Connexion.html">Connexion</a>
</ul>

<!-- Contenu principal -->
<?php
try
{
  $bdd = new PDO('mysql:host=localhost;dbname=infirmerie15;charset=utf8', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

$jour = "2015-12-20";
$req = $bdd->prepare('SELECT *
FROM passage
WHERE date=?') ;
$req->execute(array($jour));

while ($donnees = $req->fetch())
{
	echo "date : " . $donnees['date'] . '<br>';

}
	
$req->closeCursor();
?>

</body>
</html>