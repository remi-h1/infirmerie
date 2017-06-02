<!-- Nom page : motif
Description : cette page permet de trier les passages à l'infirmerie en fonction du type de motif 
Nom de l'auteur : Maxime Dupont -->
<?php
include '../start.php'; // le fichier start.php vérifie si l'utilisateur est bien connecté
$nomPage="motif";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    	<title>Motif</title>
		<?php include '../header.php'; // le fichier header.php contient des informations sur le site : <meta>, et la localisation du fichier css ?> 

</head>
<body>

<?php include "../nav.php"; // Le fichier nav.php contient le menue du site 

// on initialise les variables non définie par l'utilisateur pour faire des recherches par défaut

if(!isset($_POST['motif'])) // Si aucun nom a été définit
	$_POST['motif']=""; // alors il rechercher tout les nom élèves


if(!isset($_POST['trier'])) // Si le mode de trie n'a pas été choisie
	$_POST['trier']="typeMotif"; // alors trier par nom
if(!isset($_POST['sens'])) // Si le sens n'a pas été choisie
	$_POST['sens']="ASC"; // alors le sens est croissant

?>
	
		<div class="page">
			<form method="post" action="http://localhost/infirmerie/motif/">
				<label for="motif">motif : </label> 
				<select name="motif">
				    <option value="blessures" selected="selected">blessures</option>
				    <option value="maladies">maladies</option>
				    <option value="troubles psychologiques">troubles psychologiques</option>

				<input type="submit" value="rechercher"/>
			</form>

			<?php 
				if(!empty($_POST['motif']))
					echo "<p>Recherche pour : " . $_POST['motif'];
				 //accès à la base de données 
				try
				{
					$bdd = new PDO('mysql:host=localhost;dbname=infirmerie15;charset=utf8', 'root', ''); // connexion à la base de données
				}
				catch(Exception $e)
				{
					die('Erreur : '.$e->getMessage()); // En cas d'échec, il affiche un message d'erreur
				}

				// On compte le nombre d'enregistrements correspondant à la recherche
				$nombreEnregistrement=0;
				// requête d'accès a la base données en fonction du motif choisi 
				$req = $bdd->prepare(
					'SELECT COUNT(*) as "nb"
					FROM passage P, eleve E, classe C, motif M
					Where P.idEleve=E.id
					AND E.id_Classe=C.id
					AND M.id=P.idMotif
					AND typeMotif LIKE ?');
				$req->execute(array('%' . $_POST['motif'].'%'));

				while ($donnees = $req->fetch())
				{
					$nombreEnregistrement=$donnees['nb'];
				}
				$req->closeCursor();
				?>
					<p><?php echo $nombreEnregistrement; ?> enregistrement<?php if($nombreEnregistrement>1) echo 's'; ?> trouvé<?php if($nombreEnregistrement>1) echo 's'; ?></p>
				<?php

				// On affiche les enregistrements correspondants à la recherche
				if($nombreEnregistrement>=1)
				{
					// On définit le nombre de pages necessaires
					$nombrePage=ceil($nombreEnregistrement/10);
					if(!isset($_POST['page']))
						$_POST['page']=1;
					$_POST['premierEnregristrement']=0+10*($_POST['page']-1); // Initialisation pour la LIMIT de la requête SQL, valeur à laquel il commencera a ajouter les enregistrements

					?>

						<table class="tableauEleve">
							<tr class="titre"> 
								<td style="width: 200px;"><form action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="motif" value="<?php echo $_POST['motif']?>"/> <input type="hidden" name="trier" value="typeMotif"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='typeMotif' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="motif" /></form></td>
								<td style="width: 200px;"><form action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="motif" value="<?php echo $_POST['motif']; ?>"/> <input type="hidden" name="trier" value="commentaire"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='commentaire' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="commentaire" /></form></td>
								<td><form action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="motif" value="<?php echo $_POST['motif']?>"/> <input type="hidden" name="trier" value="nom"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='nom' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="nom" /></form></td>
								<td><form action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="motif" value="<?php echo $_POST['motif']?>"/> <input type="hidden" name="trier" value="prenom"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='prenom' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="prenom" /></form></td>
								<td><form action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="motif" value="<?php echo $_POST['motif']?>"/> <input type="hidden" name="trier" value="libelleClasse"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='libelleClasse' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="classe" /></form></td>
								<td><form action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="motif" value="<?php echo $_POST['motif']?>"/> <input type="hidden" name="trier" value="date"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='date' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="date" /></form></td>
								<td><form action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="motif" value="<?php echo $_POST['motif']?>"/> <input type="hidden" name="trier" value="heureDebut"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='heureDebut' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="heure début" /></form></td>
								<td><form action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="motif" value="<?php echo $_POST['motif']?>"/> <input type="hidden" name="trier" value="heureFin"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='heureFin' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="heure fin" /></form></td>
								</tr>
					<?php
					// requête d'accès a la base données en fonction du motif choisi 
					$req = $bdd->prepare('SELECT nom, prenom, prenom2, libelleClasse, date, heureDebut, heureFin, typeMotif, commentaire
						FROM passage P, eleve E, classe C, motif M
						Where P.idEleve=E.id
						AND E.id_Classe=C.id
						AND M.id=P.idMotif
						AND typeMotif LIKE ?						
						ORDER BY `' . str_replace('`', '``', $_POST['trier']) . '`' . str_replace('`', '``', $_POST['sens']) . ', typeMotif, nom, prenom, date, heureDebut
						LIMIT ' . str_replace('`', '``', $_POST['premierEnregristrement']) . ', 10
						');
						

					$req->execute(array('%' . $_POST['motif'].'%'));

					if (!$req) 
					{
					    echo "la requête ne fonctionne pas";
					} else 
					{
					    while ($donnees = $req->fetch()) 
					    {
					        ?><!-- affichage du tableau des données -->
							<tr class="enregistrement">
								<td style="width: 200px;"><?php echo $donnees['typeMotif'];?></td>
								<td style="width: 200px;"><?php echo $donnees['commentaire'];?></td>
								<td><?php echo $donnees['nom'];?></td>
								<td><?php echo $donnees['prenom']; if(!empty($donnees['prenom2'])) { echo ', ' . $donnees['prenom2'];}?></td>
								<td><?php echo $donnees['libelleClasse'];?></td>
								<td><?php echo $donnees['date'];?></td>
								<td><?php echo $donnees['heureDebut'];?></td>
								<td><?php echo $donnees['heureFin'];?></td>
								
							</tr>
							<?php
					    }
					    $req->closeCursor();
					}
					?>
						</table>
						<div class="diffPage">
							<div class="precedent">
								<?php
								
								if($nombrePage>1 and $_POST['page']!=1)
								{
									?>
										<form  action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']-1; ?>"/><input type="hidden" name="motif" value="<?php echo $_POST['motif']?>"/> <input type="hidden" name="trier" value="<?php echo $_POST['trier']; ?>"/> <input type="hidden" name="sens" value="<?php if(isset($_POST['sens']) AND $_POST['sens']=='DESC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="prédédent" /></form>						<?php
								}
								?>
							</div>
							<div class="Nbpage">
							<span >page <?php echo $_POST['page'] . " / " . $nombrePage; ?></span>
							</div>
							<div class="suivent">
								<?php
								if($nombrePage>$_POST['page'])
								{
									?>
										<form  action="http://localhost/infirmerie/motif/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']+1; ?>"/><input type="hidden" name="motif" value="<?php echo $_POST['motif']?>"/> <input type="hidden" name="trier" value="<?php echo $_POST['trier']; ?>"/> <input type="hidden" name="sens" value="<?php if(isset($_POST['sens']) AND $_POST['sens']=='DESC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="suivant" /></form>
									<?php
								}
								?>
							</div>
						</div>
					<?php
				}
				else
				{
					?>
						<p class="alerteViolet">Aucun passage à l'infirmerie n'est enregistré pour cet(te) élève</p>
					<?php
				}
					
			?>
			<?php include('..\footer.php'); ?>
		</div>


	</body>
</html>