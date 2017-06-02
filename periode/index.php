<!-- Nom page : periode
Description : Cette page permet de voir les passages à l'infirmerie sur une période
Nom de l'auteur : Rémi Hillériteau -->
<?php
include '../start.php'; // le fichier start.php vérifie si l'utilisateur est bien connecté
$nomPage="periode";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    	<title>Periode</title>
		<?php include '../header.php'; // le fichier header.php contient des informations sur le site : <meta>, et la localisation du fichier css ?> 

</head>
	<body>
		<?php  include "../nav.php"; // Le fichier nav.php contient le menue du site ?>

	<!-- *********************** FORMULAIRE DE RECHERCHE ********************************** -->

		<div class="page">
			<form method="post" action="http://localhost/infirmerie/periode/">
				<label>Annee : </label>
				<select name="annee">
				    <option value="2016" selected="selected">2016</option>
				    <option value="2015">2015</option>
				</select>
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
				<label for="jour">jour : </label> <input type="jour" name="jour" id="jour" size="2" maxlength="2" autofocus /> <br /> <!-- Le nom de l'élève ne peut pas dépasser 25 caractères, car les noms dans la base de donnée ne dépassent pas cette valeur-->
				<label>Annee : </label>
				<select name="annee2">
				    <option value="2016" selected="selected">2016</option>
				    <option value="2015">2015</option>
				</select>
				<label>Mois : </label>
				<select name="mois2">
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
				<label for="jour2">jour : </label> <input type="jour" name="jour2" id="jour2" size="2" maxlength="2" autofocus /> <!-- Le nom de l'élève ne peut pas dépasser 25 caractères, car les noms dans la base de donnée ne dépassent pas cette valeur-->
				<input type="submit" value="rechercher"/>
			</form>

			<?php
			// Connexion à la base de donnée
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=infirmerie15;charset=utf8', 'root', ''); // connexion à la base de données
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage()); // En cas d'échec, il affiche un message d'erreur
			}

	//******************************** INITIALISATION DE VARIABLE *******************************

			if(isset($_POST['mois']))
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

				 // Vérifier que la date2 est correcte
			    $r=$_POST['annee2']%4;
			    if($r==0 && $_POST['mois2']==2)
			        $limJour2=29;
			    else
			    {
				        switch($_POST['mois2'])
				        {
				            case 1 : $limJour2=31;
				            break;
				            case 2 : $limJour2=28;
				            break;
				            case 3 : $limJour2=31;
				            break;
				            case 4 : $limJour2=30;
				            break;
				            case 5 : $limJour2=31;
				            break;
				            case 6 : $limJour2=30;
				            break;
				            case 7 : $limJour2=31;
				            break;
				            case 8 : $limJour2=31;
				            break;
				            case 9 : $limJour2=30;
				            break;
				            case 10 : $limJour2=31;
				            break;
				            case 11 : $limJour2=30;
				            break;
				            case 12 : $limJour2=31;
				            break;
				        }
				 }
			}


			// on initialise les variables non définie par l'utilisateur pour faire des recherches par défaut
			if(!empty($_POST['jour'])) // Si le jour est rempli, alors l'année, le mois et le jour sont définis
				$date=$_POST['annee'] . '-' . $_POST['mois'] . '-' . $_POST['jour']; // On fait donc une concaténation des variables, pour que le format de la date soit le même que dans la base de données
			elseif(!empty($_POST['mois']) AND empty($_POST['jour'])) // Sionon, si le moi est défini, mais pas le jour
				{
					$date=$_POST['annee'] . '-' . $_POST['mois'] . '-' . "01"; // On fait une concaténation des variables, en initialisant le jour à 1
					$_POST['jour']="01"; // Pour le test par la suite on définit la variable $_POST['jour']="01"
				}
			elseif(isset($_POST['date'])) // Sinon, si $_POST['date'] exite déjà, alors on redonne le contenue de $_POST['date'] à $date
				$date=$_POST['date'];
			else
				{
					$date=date("Y-m-01"); // On définit pas défault le premier jour du mois et de l'année au moment du chargment de la page
					$_POST['annee']=date('Y');
					$_POST['mois']=date('m');
					$_POST['jour']='01';
				}

			if(!empty($_POST['jour2'])) // On fait la même chose pour la deuxième date
				$date2=$_POST['annee2'] . '-' . $_POST['mois2'] . '-' . $_POST['jour2'];
			elseif(isset($_POST['mois2']) and isset($_POST['annee2']) and ($_POST['mois2']!=date("m") or$_POST['annee2']!=date("Y")))
				{																		// sauf qu'ici, pour un mois différent du mois actuelle 
					$date2=$_POST['annee2'] . '-' . $_POST['mois2'] . '-' . $limJour2; // on met le jour maximum (du mois en question)
					$_POST['jour2']=$limJour2;
				}
			elseif(isset($_POST['date2']))
				$date2=$_POST['date2'];
			else
			{
				$date2=date("Y-m-d"); // Sinon on donne le jour d'aujourd'hui
				$_POST['annee2']=date('Y');
				$_POST['mois2']=date('m');
				$_POST['jour2']=date('d');
			}

			if(!isset($_POST['trier'])) // Si le mode de trie n'a pas été choisie
				$_POST['trier']="date"; // alors trier par nom
			if(!isset($_POST['sens'])) // Si le sens n'a pas été choisie
				$_POST['sens']="DESC"; // alors le sens est décroissant pour afficher le plus récent

	
// *********************** RESULTAT(S) DE LA RECHECHE **********************************

			// On affiche la période recherché
			echo "<p>Recherche entre le : " . $date ;
			echo " et le : " . $date2 . "</p>";

// ************************* PRE-REQUETE pour déterminer le nombre d'enregistrement correspondant à la recherche ******************

			// On compte le nombre d'enrechistrements correspondant à la recherche
			$nombreEnregistrement=0;

			$req = $bdd->prepare(
				'SELECT COUNT(*) as "nb"
				FROM passage P, eleve E, classe C
				Where P.idEleve=E.id
				AND E.id_Classe=C.id
				AND date BETWEEN ? AND ?');
			$req->execute(array($date, $date2));

			while ($donnees = $req->fetch())
			{
				$nombreEnregistrement=$donnees['nb'];
			}
			$req->closeCursor();

			if(isset($_POST['jour']) AND isset($_POST['jour2']) AND isset($limJour) AND isset($limJour2) AND ($_POST['jour']>$limJour or $_POST['jour2']>$limJour2 or $_POST['jour']<=0 or $_POST['jour2']<=0))
				$nombreEnregistrement=0;
			/*if($annee2>$annee OR ($annee==$annee2 AND $mois2>$mois) OR ($annee==$annee2 AND $mois==$mois2 AND $jour2>$jour))
				$nombreEnregistrement=0;*/

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
						<td><form action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="trier" value="date"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='date' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="date" /></form></td>
						<td><form action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="trier" value="heureDebut"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='heureDebut' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="heure début" /></form></td>
						<td><form action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="heureFin"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='heureFin' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="heure fin" /></form></td>
						<td><form action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="nom"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='nom' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="nom" /></form></td>
						<td><form action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo  $date; ?>"/> <input type="hidden" name="trier" value="prenom"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='prenom' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="prenom" /></form></td>
						<td><form action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo  $date; ?>"/> <input type="hidden" name="trier" value="libelleClasse"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='libelleClasse' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="classe" /></form></td>
						<td style="width: 200px;"><form action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="typeMotif"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='typeMotif' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="motif" /></form></td>
						<td style="width: 200px;"><form action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']; ?>"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="trier" value="commentaire"/> <input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="sens" value="<?php if($_POST['trier']=='commentaire' AND $_POST['sens']=='ASC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="commentaire" /></form></td>
					</tr>
				<?php

				// requête sql, pour aller chercher les données à afficher dans le tableau
				$req = $bdd->prepare(
					'SELECT nom, prenom, prenom2, libelleClasse, date, heureDebut, heureFin, typeMotif, commentaire
					FROM passage P, eleve E, classe C, motif M
					Where P.idEleve=E.id
					AND E.id_Classe=C.id
					AND M.id=P.idMotif
					AND date BETWEEN ? AND ?
					ORDER BY `' . str_replace('`', '``', $_POST['trier']) . '`' . str_replace('`', '``', $_POST['sens']) . ', date, heureDebut, nom, prenom
					LIMIT ' . str_replace('`', '``', $_POST['premierEnregristrement']) . ', 10
					');
				/* dans la requête au dessus, on ordonne les données dabord par la méthode de trie demandé par l'utilisateur avec le sens définie,
						 puis on trie par nom, puis par prénom, par date et enfin par l'heure de début */
				$req->execute(array($date, $date2));

				// On complete le tableau par les enregistrements
				while ($donnees = $req->fetch())
				{
					?>

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

<!-- ********************* On affiche le nombre de page et le bouton précédent et le bouton suivent ************************* -->

				</table>
				<div class="diffPage">
					<div class="precedent">
						<?php
						
						if($nombrePage>1 and $_POST['page']!=1)
						{
							?>
								<!-- De même qu'au dessus, on retransfère les variables relatif aux recherches -->
								<form  action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']-1; ?>"/><input type="hidden" name="date" value="<?php echo $date;?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="trier" value="<?php echo $_POST['trier']; ?>"/> <input type="hidden" name="sens" value="<?php if(isset($_POST['sens']) AND $_POST['sens']=='DESC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="prédédent" /></form>						<?php
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
								<form  action="http://localhost/infirmerie/periode/" method="post"> <input type="hidden" name="page" value="<?php echo $_POST['page']+1; ?>"/><input type="hidden" name="date" value="<?php echo $date; ?>"/> <input type="hidden" name="date2" value="<?php echo $date2; ?>"/> <input type="hidden" name="trier" value="<?php echo $_POST['trier']; ?>"/> <input type="hidden" name="sens" value="<?php if(isset($_POST['sens']) AND $_POST['sens']=='DESC') { echo 'DESC';} else { echo 'ASC'; }?>"/><input type="submit" value="suivant" /></form>
							<?php
						}
						?>
					</div>
				</div>
			<?php
			}
			elseif(isset($_POST['jour']))// La requete sql ne renvoie aucune valeur, mais l'utilisateur à bien lancé une recherche
			{
				// Vérifier que la date est correcte
				 
				 if(($_POST['jour']<=0 or isset($limJour) and $_POST['jour']>$limJouror or isset($limJour2) AND $_POST['jour2']>$limJour2 or $_POST['jour2']<=0) OR ($_POST['annee2']<$_POST['annee'] OR ($_POST['annee']==$_POST['annee2'] AND $_POST['mois2']<$_POST['mois']) OR ($_POST['annee']==$_POST['annee2'] AND $_POST['mois']==$_POST['mois2'] AND $_POST['jour2']<$_POST['jour'])))
				 {
				 	?>
					<p class="alerte">La période rentrée est incorecte</p> <!-- Si la date est incorecte -->
				<?php
				 }
				 else
				 {
				?>
					<p class="alerteViolet">Aucun passage à l'infirmerie n'est enregistré pour cette période</p> <!-- Une recherche à été rentré, mais ne renvoie aucun résultat -->
				<?php
				}
				
			}
			else
			{
				?>
					<p class="alerteViolet">Aucun passage à l'infirmerie n'est enregistré pour cette période</p> <!-- Recherche par défaut, mais aucun résultat trouvé -->
				<?php
			}
			include('../footer.php'); ?> <!-- On inssert le pied de page -->
		</div>
	</body>
</html>