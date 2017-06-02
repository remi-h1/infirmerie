<!-- Nom page : élève
Description : Cette page permet l'ajout à la base de données des différents passages faits par les élèves a l'infirmerie.
Nom de l'auteur : Mabon Marin -->
<?php
include '../start.php'; // le fichier start.php vérifie si l'utilisateur est bien connecté
$nomPage="nouvelleVisite";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    	<title>Eleve</title>
		<?php include '../header.php'; // le fichier header.php contient des informations sur le site : <meta>, et la localisation du fichier css ?> 

</head>
<body>

	<?php include "../nav2.php"; // Le fichier nav.php contient le menue du site 
	?>
	<div class="page">
		
		<?php
			try
				{
					$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u860854326_infir;charset=utf8', 'u860854326_infir', 'StMarie'); // connexion à la base de données
				}
				catch(Exception $e)
				{
					die('Erreur : '.$e->getMessage()); // En cas d'échec, il affiche un message d'erreur
				}

// Vérification des champs envoyés et affichage de messages d'erreur lorsque la saisie est fausse.
$erreur['general']=false;
if(isset($_POST['id']))
{
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

	 // on vérifie les données envoyés
	if(empty($_POST['heureDebut']) OR $_POST['heureDebut']<8 OR $_POST['heureDebut']>17)
		{
			$erreur['general']=true;
			$erreur['heureDebut']=true;
		}
	if(empty($_POST['heureFin']) OR $_POST['heureFin']<8 OR $_POST['heureFin']>17)
		{
			$erreur['general']=true;
			$erreur['heureFin']=true;
		}
	if(empty($_POST['commentaire']))
		{
			$erreur['general']=true;
			$erreur['commentaire']=true;
		}
	if(empty($_POST['jour']) OR $_POST['jour']<=0 OR $_POST['jour']>$limJour)
		{
			$erreur['general']=true;
			$erreur['jour']=true;
		}
		
}

// Requête SQL d'ajout du passage avec des vérifications de champs, cette première requete permet d'afficher la suite du formulaire dans des menu déroulants.

if($erreur['general']==false AND !empty($_POST['heureDebut']) AND !empty($_POST['heureDebut']) AND !empty($_POST['heureFin']) AND !empty($_POST['annee']) AND !empty($_POST['id']) AND !empty($_POST['mois']) AND !empty($_POST['jour']) AND !empty($_POST['commentaire']) AND !empty($_POST['idMotif']))
{
	if(isset($_POST['jour']))
		$date=$_POST['annee'] . '-' . $_POST['mois'] . '-' . $_POST['jour'];
	$req = $bdd->prepare('INSERT INTO passage(date, heureDebut, heureFin, commentaire, idEleve, idMotif) VALUES(?, ?, ?, ?, ?, ?)');
	$req->execute(array($date,$_POST['heureDebut'],$_POST['heureFin'],$_POST['commentaire'],$_POST['id'], $_POST['idMotif']));
	echo "<p class='ok'>Votre enregistrement a bien été effectué</p>";
}
elseif(!isset($_POST['classe']) AND !isset($_POST['id']))
{

	?>

				<form method="post" action="#">
				<fieldset>
				<legend> Choisir la classe </legend>
				<label>Classe : </label></br>
						<select name="classe" id="classe">
		    				<option value="01" selected="selected">3è Bleue</option>
		    				<option value="02">3è Rouge</option>
		    				<option value="03">3è Verte</option>
		    				<option value="04">4è Bleue</option>
		    				<option value="05">4è Rouge</option>
		    				<option value="06">4è Verte</option>				<!-- Formulaire de sélection de la classe --> 
		    				<option value="07">5è Bleue</option>
		    				<option value="08">5è Rouge</option>
		    				<option value="09">5è Verte</option>
		    				<option value="10">6è Bleue</option>
		    				<option value="11">6è Rouge</option>
		    				<option value="12">6è Verte</option>
		    			</select></br>
					<input type="submit" value="Valider"/>
				</fieldset>
				</form>
<?php
}
else
{
// association des valeurs affichées à des valeurs de travail correspondantes
	$classe=array('01' => '3è Bleue', '02' => '3è Rouge', '03' => '3è Verte', '04' => '4è Bleue', '05' => '4è Rouge', '06' => '4è Verte', '07' => '5è Bleue', '08' => '5è Rouge', '09' => '5è Verte', '10' => '6è Bleue', '11' => '6è Rouge', '12' => '6è Verte');
	$idClasse=$_POST['classe'];
?>
			
			<form method="post" action="#">
			<fieldset>
			<legend> Enregistrer un nouveau Passage </legend>
			<p>Classe : <?php echo $classe[$idClasse]; ?></p>
			<label for="EleveNom">Nom Elève :      </label> <br />						<!-- formulaire d'ajout du passage avec les champs a competer --> 
			<select name="id">															<!-- pour ajouter le passage a la base de données .-->
				<?php
				$tour=0;
					$req = $bdd->prepare('SELECT id, nom, prenom, prenom2 FROM eleve WHERE id_classe=? ORDER BY nom, prenom' );
					$req->execute(array($_POST['classe']));

					while ($donnees = $req->fetch())
					{
						?>
							<option value="<?php echo $donnees['id']; ?>" <?php if(isset($_POST['id']) AND $_POST['id']==$donnees['id']) { echo "selected='selected'"; } ?> > <?php echo $donnees['nom'] . " " . $donnees['prenom'] .  " " . $donnees['prenom2']; ?></option> <br />
							$tour++;
						<?php 
					}
					$req->closeCursor();
					
				?>
			</select>
 			</br>
 			<?php 
 			if(isset($erreur['heureDebut']) AND $erreur['heureDebut']==true)
 				echo "<p style='color: red;'>Rentrer une heure correcte</p>";
 			?>
			<label for="heureDebut">Heure Début :  </label> <br /><input placeholder="00:00" type="time" name="heureDebut" id="heureDebut" size="25" maxlenght="25" <?php if(isset($_POST['heureDebut'])) { echo 'value="' . $_POST["heureDebut"] .'"'; } ?> /> <br /> <!-- si la rêquete ne c'est pas effectué et que les données on été envoyés, alors on redéfini les variables -->
			<?php 
 			if(isset($erreur['heureFin']) AND $erreur['heureFin']==true)
 				echo "<p style='color: red;'>Rentrer une heure correcte</p>";
 			?>
			<label for="heureFin">Heure Fin :      </label> <br /><input placeholder="00:00" type="time" name="heureFin" id="heureFin" size="25" maxlenght="25"  <?php if(isset($_POST['heureFin'])) { echo 'value="' . $_POST["heureFin"] .'"'; } ?> /> <br />
			<label for="idMotif">Type de motif : </label><br />
			<select name="idMotif">
			    <option value="1" <?php if(isset($_POST['idMotif']) AND $_POST['idMotif']=='1') { echo "selected='selected'"; } ?> >blessures</option>
			    <option value="2" <?php if(isset($_POST['idMotif']) AND $_POST['idMotif']=='2') { echo "selected='selected'"; } ?> >troubles psychologiques</option>
			    <option value="3" <?php if(isset($_POST['idMotif']) AND $_POST['idMotif']=='3') { echo "selected='selected'"; } ?> >maladies</option>
			</select></br>

			<?php 
				if(isset($erreur['commentaire']) AND $erreur['commentaire']==true)
					echo "<p style='color: red;'>Rentrer un commentaire</p>";
			?>
			<label for="commentaire">commentaire : </label> <br /><input type="text" name="commentaire" id="commentaire" size="25" maxlenght="255" <?php if(isset($_POST['commentaire'])) { echo 'value="' . $_POST["commentaire"] .'"'; } ?> /> <br />
			
	<?php 
		if(isset($erreur['jour']) AND $erreur['jour']==true)
			echo "<p style='color: red;'>Rentrer une date correcte</p>";
	?>
	<label>Date : </label></br>
	<label>Annee : </label>
	<select name="annee">
	    <option value="2016" <?php if(isset($_POST['annee']) AND $_POST['annee']=='2016') { echo "selected='selected'"; } ?> >2016</option>
	    <option value="2015" <?php if(isset($_POST['annee']) AND $_POST['annee']=='2015') { echo "selected='selected'"; } ?> >2015</option>
	</select>
	<label>Mois : </label>
	<select name="mois">
	    <option value="01" <?php if(isset($_POST['mois']) AND $_POST['mois']=='01') { echo "selected='selected'"; } ?> >janvier</option>
	    <option value="02" <?php if(isset($_POST['mois']) AND $_POST['mois']=='02') { echo "selected='selected'"; } ?> >février</option>
	    <option value="03" <?php if(isset($_POST['mois']) AND $_POST['mois']=='03') { echo "selected='selected'"; } ?> >mars</option>
	    <option value="04" <?php if(isset($_POST['mois']) AND $_POST['mois']=='04') { echo "selected='selected'"; } ?> >avril</option>
	    <option value="05" <?php if(isset($_POST['mois']) AND $_POST['mois']=='05') { echo "selected='selected'"; } ?> >mai</option>
	    <option value="06" <?php if(isset($_POST['mois']) AND $_POST['mois']=='06') { echo "selected='selected'"; } ?> >juin</option>
	    <option value="07" <?php if(isset($_POST['mois']) AND $_POST['mois']=='07') { echo "selected='selected'"; } ?> >juillet</option>
	    <option value="08" <?php if(isset($_POST['mois']) AND $_POST['mois']=='08') { echo "selected='selected'"; } ?> >août</option>
	    <option value="09" <?php if(isset($_POST['mois']) AND $_POST['mois']=='09') { echo "selected='selected'"; } ?> >septembre</option>
	    <option value="10" <?php if(isset($_POST['mois']) AND $_POST['mois']=='10') { echo "selected='selected'"; } ?> >novembre</option>
	    <option value="11" <?php if(isset($_POST['mois']) AND $_POST['mois']=='11') { echo "selected='selected'"; } ?> >octobre</option>
	    <option value="12" <?php if(isset($_POST['mois']) AND $_POST['mois']=='12') { echo "selected='selected'"; } ?> >décembre</option>
	</select>
	<label for="jour">jour : </label> <input type="jour" name="jour" id="jour" size="2" maxlenght="2" <?php if(!empty($_POST['jour'])) { echo 'value="' . $_POST["jour"] .'"'; } else { echo 'value="' . date('d') . '"';} ?> /> <br /><!-- Le nom de l'élève ne peut pas dépasser 25 caractères, car les noms dans la base de donnée ne dépassent pas cette valeur-->
		<input type="hidden" name="classe" value="<?php echo $_POST['classe']; ?>"/>
		<input type="submit" value="Valider"/>
		</fieldset>
		
			</form>

	<?php
	

	if(isset($_POST['EleveNom']) and isset($_POST['ElevePrenom']) and isset($_POST['heureDebut']) and isset($_POST['HeureFin']) and isset($_POST['commentaire']))
	{
															// Envoi du formulaire grace a une requête préparée et ajout du passage à la base

		$req = $bdd->prepare(
			'SELECT id
			FROM eleve
			WHERE nom=?
			AND prenom=?');
		$req->execute(array($_POST['EleveNom'], $_POST['ElevePrenom']));
		while ($donnees = $req->fetch())
		{
			$idEleve=$donnees['id'];
		}
		$req->closeCursor();



	}
}


?>
		<?php include('../footer.php'); ?>
	</div>
</body>