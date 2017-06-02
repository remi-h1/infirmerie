<!-- Nom page : élève
Description : Cette page affiche les visites des élèves à l'infirmerie et permet de faire des recherches pour un ou plusieurs élèves.
Nom de l'auteur : Rémi Hillériteau -->
<?php
include '../start.php'; // le fichier start.php vérifie si l'utilisateur est bien connecté, si ce n'est pas la cas, il est renvoyé sur la page de connexion
$nomPage="eleve";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    	<title>Eleve</title>
		<?php include '../header.php'; // le fichier header.php contient des informations sur le site : <meta>, et la localisation du fichier css ?> 

</head>
<body>

<?php include "../nav.php"; // Le fichier nav.php contient le premier menue du site 

	//******************************** INITIALISATION DE VARIABLE *******************************

// on initialise les variables non définie par l'utilisateur pour faire des recherches par défaut

if(!isset($_POST['nomEleve'])) // Si aucun nom a été définit
	$_POST['nomEleve']=""; // alors il rechercher tout les nom élèves
if(!isset($_POST['prenomEleve'])) // Si aucun prénom a été définit
	$_POST['prenomEleve']=""; // alors il rechercher tout les prénoms élèves

if(!isset($_POST['trier'])) // Si le mode de trie n'a pas été choisie
	$_POST['trier']="nom"; // alors trier par nom
if(!isset($_POST['sens'])) // Si le sens n'a pas été choisie
	$_POST['sens']="ASC"; // alors le sens est croissant

?>

	<!-- *********************** FORMULAIRE DE RECHERCHE ********************************** -->

		<div class="page">
			<form method="post" action="http://localhost/infirmerie/eleve/">
				<label for="nomEleve">Nom Elève : </label> <input type="text" name="nomEleve" id="nomEleve" size="25" maxlength="25" autofocus /> <br /><!-- Le nom de l'élève ne peut pas dépasser 25 caractères, car les noms dans la base de donnée ne dépassent pas cette valeur-->
				<label for="prenomEleve">Prenom Elève : </label> <input type="text" name="prenomEleve" id="prenomEleve" size="25" maxlength="25"/> <!-- Le prenom de l'élève ne peut pas dépasser 25 caractères, car les prenoms dans la base de donnée ne dépassent pas cette valeur-->
				<input type="submit" value="rechercher"/>
			</form>


	<!-- *********************** RESULTAT(S) DE LA RECHECHE ********************************** -->

			<?php

				// On affiche le nombre d'enregistrements trouvés
				if(!empty($_POST['nomEleve']) and !empty($_POST['prenomEleve']))
					echo "<p>Recherche pour : " . $_POST['nomEleve'] . " " . $_POST['prenomEleve'];
				elseif(!empty($_POST['nomEleve']))
					echo "<p>Recherche pour : " . $_POST['nomEleve'];
				elseif(!empty($_POST['prenomEleve']))
					echo "<p>Recherche pour : " . $_POST['prenomEleve'];
				

				// Connexion à la base de donnée
				try
				{
					$bdd = new PDO('mysql:host=localhost;dbname=infirmerie15;charset=utf8', 'root', ''); // connexion à la base de données
				}
				catch(Exception $e)
				{
					die('Erreur : '.$e->getMessage()); // En cas d'échec, il affiche un message d'erreur
				}

				
	// ************************* PRE-REQUETE pour déterminer le nombre d'enregistrement correspondant à la recherche ******************

				$nombreEnregistrement=0;

				$req = $bdd->prepare(
					'SELECT COUNT(*) as "nb"
					FROM passage P, eleve E, classe C, motif M
					Where P.idEleve=E.id
					AND E.id_Classe=C.id
					AND M.id=P.idMotif
					AND nom LIKE ?
					AND prenom LIKE ?');
				$req->execute(array($_POST['nomEleve'].'%',$_POST['prenomEleve'].'%'));

				while ($donnees = $req->fetch())
				{
					$nombreEnregistrement=$donnees['nb'];
				}
				$req->closeCursor();
				?>
					<p><?php echo $nombreEnregistrement; ?> enregistrement<?php if($nombreEnregistrement>1) echo 's'; ?> trouvé<?php if($nombreEnregistrement>1) echo 's'; ?></p>
				<?php

	// ********************** On test si il y a des données à afficher ******************************************

				
				if($nombreEnregistrement>=1)
				{
					// On définit le nombre de page necessaire
					$nombrePage=ceil($nombreEnregistrement/10);
					if(!isset($_POST['page']))
						$_POST['page']=1;
					$_POST['premierEnregristrement']=0+10*($_POST['page']-1); // Initialisation pour la LIMIT de la requête SQL, valeur à lquel il commencera a ajouter les enregistrements
					

	// ********************* On affiche les enregistrements correspondant à la recherche dans un tableau *************************
					?>

						<!-- Des formulaires sont utilisés pour écrire les titres des colones,
						pour chaque formulaire on utilise un input avec le nom du titre de la colone pour envoyer le formulaire,
						dans ce même formulaire on initialise des inputs cachés avec des valeurs à transmettre pour conserver la recherche de l'utilisateur
						Ainsi lorsque l'utilisateur clique sur "nom", alros on va trier les données par nom en fonction de la recherche précédente
						-->
						<table class="tableauEleve">
							<tr class="titre"> 
								<td><form action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="nom"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='nom' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="nom" /></form></td>
								<td><form action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="prenom"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='prenom' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="prenom" /></form></td>
								<td><form action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="libelleClasse"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='libelleClasse' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="classe" /></form></td>
								<td><form action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="date"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='date' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="date" /></form></td>
								<td><form action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="heureDebut"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='heureDebut' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="heure début" /></form></td>
								<td><form action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="heureFin"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='heureFin' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="heure fin" /></form></td>
								<td style="width: 200px;"><form action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="typeMotif"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='typeMotif' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="motif" /></form></td>
								<td style="width: 200px;"><form action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="commentaire"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='commentaire' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="commentaire" /></form></td>
							</tr>
					<?php

					// requête sql, pour aller chercher les données à afficher dans le tableau
					$req = $bdd->prepare('SELECT nom, prenom, prenom2, libelleClasse, date, heureDebut, heureFin, typeMotif, commentaire
						FROM passage P, eleve E, classe C, motif M
						Where P.idEleve=E.id
						AND E.id_Classe=C.id
						AND M.id=P.idMotif
						AND nom LIKE ?
						AND prenom LIKE ?						
						ORDER BY `' . str_replace('`', '``', $_POST['trier']) . '`' . str_replace('`', '``', $_POST['sens']) . ', nom, prenom, date, heureDebut
						LIMIT ' . str_replace('`', '``', $_POST['premierEnregristrement']) . ', 10
						');
						/* dans la requête au dessus, on ordonne les données dabord par la méthode de trie demandé par l'utilisateur avec le sens définie,
						 puis on trie par nom, puis par prénom, par date et enfin par l'heure de début */

					$req->execute(array($_POST['nomEleve'].'%',$_POST['prenomEleve'].'%'));

					// On complete le tableau par les enregistrements
				    while ($donnees = $req->fetch()) 
				    {
				        ?>
						<tr class="enregistrement"><td><?php echo $donnees['nom'];?></td>
							<td><?php echo $donnees['prenom']; if(!empty($donnees['prenom2'])) { echo ', ' . $donnees['prenom2'];}?></td>
							<td><?php echo $donnees['libelleClasse'];?></td>
							<td><?php echo $donnees['date'];?></td>
							<td><?php echo $donnees['heureDebut'];?></td>
							<td><?php echo $donnees['heureFin'];?></td>
							<td style="width: 200px;"><?php echo $donnees['typeMotif'];?></td>
							<td style="width: 200px;"><?php echo $donnees['commentaire'];?></td>
						</tr>
						<?php
				    }

				    $req->closeCursor();
					?>
						</table>

	<!-- ********************* On affiche le nombre de page et le bouton précédent et le bouton suivent ************************* -->

						<div class="diffPage">
							<div class="precedent">
								<?php
								
								if($nombrePage>1 and $_POST['page']!=1)
								{
									?>
										<!-- De même qu'au dessus, on retransfère les variables relatif aux recherches -->
										<form  action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']-1; ?>"/><input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="<?php echo $_POST['trier']; ?>"/> <input type="hidden" name="sens" value="<?php if(isset($_POST['sens']) AND $_POST['sens']=='DESC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="prédédent" /></form>						<?php
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
										<!-- De même qu'au dessus, on retransfère les variables relatif aux recherches -->
										<form  action="http://localhost/infirmerie/eleve/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']+1; ?>"/><input type="hidden" name="nomEleve" value="<?php echo $_POST['nomEleve']?>"/> <input type="hidden" name="prenomEleve" value="<?php echo $_POST['prenomEleve']?>"/> <input type="hidden" name="trier" value="<?php echo $_POST['trier']; ?>"/> <input type="hidden" name="sens" value="<?php if(isset($_POST['sens']) AND $_POST['sens']=='DESC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="suivant" /></form>
									<?php
								}
								?>
							</div>
						</div>
					<?php
				}
				else
				{
	// ********************* Si le tableau ne s'affiche pas, on affiche un message d'erreur *************************
					?>
						<p class="alerteViolet">Aucun passage à l'infirmerie n'est enregistré pour cette élève</p>
					<?php
				}
					
			?>
			<?php include('..\footer.php'); ?> <!-- On inssert le pied de page -->
		</div>


	</body>
</html>