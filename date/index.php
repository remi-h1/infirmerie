<!-- Nom page : date
Description : cette page permet de trier les passages a l'infirmerie en fonction de la date choisie
Nom de l'auteur : Maxime Dupont -->
<?php
 include '../start.php'; // le fichier start.php vérifie si l'utilisateur est bien connecté
 $nomPage="date";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>
    	<title>Date</title>
		<?php include '../header.php'; // le fichier header.php contient des informations sur le site : <meta>, et la localisation du fichier css ?> 
	</head>
	<body>
		<?php  include "../nav.php"; // Le fichier nav.php contient le menue du site ?>

		<div class="page">
			<form method="post" action="http://localhost/infirmerie/date/">
				
				<!-- menu déroulant pour l'année -->

				<label>Annee : </label>
				<select name="annee">
				    <option value="2016" selected="selected">2016</option>
				    <option value="2015">2015</option>
				</select>
				<!-- menu déroulant pour le mois -->
				<label>Mois : </label>
				<select name="mois">
				    <option value="01" selected="selected">janvier</option>
				    <option value="02">février</option>
				    <option value="03">mars</option>
				    <option value="04">avril</option>
				    <option value="05">mai</option>
				    <option value="06">juin</option>
				    <option value="07">juillet</option>
				    <option value="08">août</option>
				    <option value="09">septembre</option>
				    <option value="10">novembre</option>
				    <option value="11">octobre</option>
				    <option value="12">décembre</option>
				</select>
				<!-- choix du jour -->
				<label for="jour">jour : </label> <input type="jour" name="jour" id="jour" size="2" maxlength="2" autofocus /> <!-- Le nom de l'élève ne peut pas dépasser 25 caractères, car les noms dans la base de donnée ne dépassent pas cette valeur-->
				<input type="submit" value="rechercher"/>
			</form>

			<!-- accès à la base de données -->
			<?php

			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=infirmerie15;charset=utf8', 'root', ''); // connexion à la base de données
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage()); // En cas d'échec, il affiche un message d'erreur
			}

			// on initialise les variables non définie par l'utilisateur pour faire des recherches par défaut
			if(!empty($_POST['jour']))
				$date=$_POST['annee'] . '-' . $_POST['mois'] . '-' . $_POST['jour'];
			elseif(isset($_POST['date']))
				$date=$_POST['date'];
			else
				$date=date("Y-m-d");
			if(!isset($_POST['trier'])) // Si le mode de trie n'a pas été choisie
				$_POST['trier']="nom"; // alors trier par nom
			if(!isset($_POST['sens'])) // Si le sens n'a pas été choisie
				$_POST['sens']="ASC"; // alors le sens est croissant
				
			// afficher date recherché
			echo "<p>Recherche pour le : " . $date . "</p>";

			// On compte le nombre d'enrechistrements correspondant à la recherche
			$nombreEnregistrement=0;

			$req = $bdd->prepare(
				'SELECT COUNT(*) as "nb"
				FROM passage P, eleve E, classe C, motif M
				Where P.idEleve=E.id
				AND E.id_Classe=C.id
				AND M.id=P.idMotif
				AND date=?');
			$req->execute(array($date));

			while ($donnees = $req->fetch())
			{
				$nombreEnregistrement=$donnees['nb'];
			}
			$req->closeCursor();
			?>
				<p><?php echo $nombreEnregistrement; ?> enregistrement<?php if($nombreEnregistrement>1) echo 's'; ?> trouvé<?php if($nombreEnregistrement>1) echo 's'; ?></p>
			<?php

			// On affiche les enregistrements correspondant à la recherche
			if($nombreEnregistrement>=1)
			{
				// On définit le nombre de page necessaire
				$nombrePage=ceil($nombreEnregistrement/10);
				if(!isset($_POST['page']))
					$_POST['page']=1;
				$_POST['premierEnregristrement']=0+10*($_POST['page']-1); // Initialisation pour la LIMIT de la requête SQL, valeur à lquel il commencera a ajouter les enregistrements

				?>

				<table class="tableauEleve">
					<tr class="titre">
						<td><form action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="date"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='date' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="date" /></form></td>
						<td><form action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="heureDebut"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='heureDebut' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="heure début" /></form></td>
						<td><form action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="heureFin"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='heureFin' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="heure fin" /></form></td>
						<td><form action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="nom"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='nom' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="nom" /></form></td>
						<td><form action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo  $date; ?>"/> <input type="hidden" name="trier" value="prenom"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='prenom' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="prenom" /></form></td>
						<td><form action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo  $date; ?>"/> <input type="hidden" name="trier" value="libelleClasse"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='libelleClasse' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="classe" /></form></td>
						<td style="width: 200px;"><form action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="typeMotif"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='typeMotif' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="motif" /></form></td>
						<td style="width: 200px;"><form action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="commentaire"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='commentaire' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="commentaire" /></form></td>
					</tr>
				
				<!-- requête d'accès a la base données en fonction de la date choisie -->
				<?php
				$req = $bdd->prepare(
					'SELECT nom, prenom, prenom2, libelleClasse, date, heureDebut, heureFin, typeMotif, commentaire
					FROM passage P, eleve E, classe C, motif M
					Where P.idEleve=E.id
					AND E.id_Classe=C.id
					AND M.id=P.idMotif
					AND date=?
					ORDER BY `' . str_replace('`', '``', $_POST['trier']) . '`' . str_replace('`', '``', $_POST['sens']) . ', date, heureDebut, nom, prenom
					LIMIT ' . str_replace('`', '``', $_POST['premierEnregristrement']) . ', 10
					');
				$req->execute(array($date));

				while ($donnees = $req->fetch())
				{
					?>
						<!-- affichage du tableau des données -->
						<tr class="enregistrement">
							<td><?php echo $donnees['date'];?></td>
							<td><?php echo $donnees['heureDebut'];?></td>
							<td><?php echo $donnees['heureFin'];?></td>
							<td><?php echo $donnees['nom'];?></td>
							<td><?php echo $donnees['prenom']; if(!empty($donnees['prenom2'])) { echo ', ' . $donnees['prenom2'];}?></td>
							<td><?php echo $donnees['libelleClasse'];?></td>
							<td style="width: 200px;"><?php echo $donnees['typeMotif'];?></td>
							<td style="width: 200px;"><?php echo $donnees['commentaire'];?></td>
						</tr>


					<?php
				}
				$req->closeCursor();

				?>
				</table>
				<div class="diffPage">
					<div class="precedent">
						<?php
						
						if($nombrePage>1 and $_POST['page']!=1)
						{
							?>
								<form  action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']-1; ?>"/><input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="<?php echo $_POST['trier']; ?>"/> <input type="hidden" name="sens" value="<?php if(isset($_POST['sens']) AND $_POST['sens']=='DESC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="prédédent" /></form>						<?php
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
								<form  action="http://localhost/infirmerie/date/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']+1; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="<?php echo $_POST['trier']; ?>"/> <input type="hidden" name="sens" value="<?php if(isset($_POST['sens']) AND $_POST['sens']=='DESC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="suivant" /></form>
							<?php
						}
						?>
					</div>
				</div>
			<?php
			}
			elseif(!empty($_POST['jour']))// La requete sql ne renvoie aucune valeur, mais l'utilisateur à bien lancé une recherche
			{

				// Vérifier que la date est correcte
			    $r=$_POST['annee']%4;
			    if($r==0 && $_POST['mois']==2)
			        $limJour=29;
			    else
			    {
				        switch($_POST['mois'])
				        {
				            case 1 : $limJour=31;
				            break;
				            case 2 : $limJour=28;
				            break;
				            case 3 : $limJour=31;
				            break;
				            case 4 : $limJour=30;
				            break;
				            case 5 : $limJour=31;
				            break;
				            case 6 : $limJour=30;
				            break;
				            case 7 : $limJour=31;
				            break;
				            case 8 : $limJour=31;
				            break;
				            case 9 : $limJour=30;
				            break;
				            case 10 : $limJour=31;
				            break;
				            case 11 : $limJour=30;
				            break;
				            case 12 : $limJour=31;
				            break;
				        }
				 }
				 
				 if($_POST['jour']<=0 or $_POST['jour']>$limJour)
				 {
				 	?>
					<p class="alerte">La date rentrée est incorecte</p>
				<?php
				 }
				 else
				 {
				?>
					<p class="alerteViolet">Aucun passage à l'infirmerie n'est enregistré à cette date</p>
				<?php
				}

			}
			else
			{
				?>
					<p class="alerteViolet">Aucun passage à l'infirmerie n'est enregistré à cette date</p>
				<?php
			}
			?>
			<?php include('..\footer.php'); ?>
		</div>
	</body>
</html>