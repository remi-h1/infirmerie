<!-- Nom page : Ajout Elève
Description : Cette page permet l'ajout à la base de données d'un élève non enregistré.
Nom de l'auteur : Mabon Marin -->
<?php
include '../start.php'; // le fichier start.php vérifie si l'utilisateur est bien connecté
$nomPage="nouveauEleve";
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

if(isset($_POST['nomEleve']) AND !empty($_POST['nomEleve']) and !empty($_POST['prenomEleve']) and !empty($_POST['classe']))
{

$req = $bdd->prepare('INSERT INTO eleve(nom, prenom, prenom2, id_classe) VALUES(?, ?, ?, ?)');
$req->execute(array($_POST['nomEleve'],$_POST['prenomEleve'],$_POST['prenom2'],$_POST['classe']));
echo "<p class='ok'>L'élève a bien été engregistré</p>";
																										// requête préparée d'ajout de l'élève
$_POST['nomEleve']=NULL;
$_POST['prenomEleve']=NULL;
$_POST['prenom2']=NULL;
$_POST['classe']=NULL;

}

?>
																					<!-- Formulaire d'ajout de l'élève avec des champs a remplir -->

			<form method="post" action="">
			<fieldset>
			<legend> Enregistrer un nouvel Elève </legend>
				<?php if(isset($_POST['nomEleve']) AND empty($_POST['nomEleve'])) // si une reqête a échoué, on redonne la valeur du nom envoyé
						echo "<p style='color: red;'>Rentrer le nom de l'élève</p>"; // on vérifie si le nom est remplie
				?>
				<label for="nomEleve">Nom Elève :      </label> <br /><input type="text" name="nomEleve" id="nomEleve" size="25" maxlenght="25" autofocus <?php if(isset($_POST['nomEleve'])) { echo 'value="' . $_POST["nomEleve"] .'"'; } ?>/> <br /><!-- Le nom de l'élève ne peut pas dépasser 25 caractères, car les noms dans la base de donnée ne dépassent pas cette valeur-->
				<?php if(isset($_POST['prenomEleve']) AND empty($_POST['prenomEleve']))
						echo "<p style='color: red;'>Rentrer le prénom de l'élève</p>"; // on vérifie si le prénom est remplie
				?>
				<label for="prenomEleve">Prenom Elève :</label> <br /><input type="text" name="prenomEleve" id="prenomEleve" size="25" maxlenght="25" <?php if(isset($_POST['prenomEleve'])) { echo 'value="' . $_POST["prenomEleve"] .'"'; } ?> /> <br /> <!-- Le prenom de l'élève ne peut pas dépasser 25 caractères, car les prenoms dans la base de donnée ne dépassent pas cette valeur-->
				<label for="prenom2">Deuxième Prenom : </label> <br /><input type="text" name="prenom2" id="prenom2" size="25" maxlenght="25" <?php if(isset($_POST['prenom2'])) { echo 'value="' . $_POST["prenom2"] .'"'; } ?> /> <br />
				<form method="post" action="">
					<label>Classe : </label></br>
					<select name="classe" id="classe">
	    				<option value="01" <?php if(isset($_POST['classe']) AND $_POST['classe']=='01') { echo "selected='selected'"; } ?>>3è Bleue</option> <!-- si une reqête a échoué, on redonne la valeur de la classe envoyé -->
	    				<option value="02" <?php if(isset($_POST['classe']) AND $_POST['classe']=='02') { echo "selected='selected'"; } ?>>3è Rouge</option>
	    				<option value="03" <?php if(isset($_POST['classe']) AND $_POST['classe']=='03') { echo "selected='selected'"; } ?>>3è Verte</option>
	    				<option value="04" <?php if(isset($_POST['classe']) AND $_POST['classe']=='04') { echo "selected='selected'"; } ?>>4è Bleue</option>
	    				<option value="05" <?php if(isset($_POST['classe']) AND $_POST['classe']=='05') { echo "selected='selected'"; } ?>>4è Rouge</option>
	    				<option value="06" <?php if(isset($_POST['classe']) AND $_POST['classe']=='06') { echo "selected='selected'"; } ?>>4è Verte</option>
	    				<option value="07" <?php if(isset($_POST['classe']) AND $_POST['classe']=='07') { echo "selected='selected'"; } ?>>5è Bleue</option>
	    				<option value="08" <?php if(isset($_POST['classe']) AND $_POST['classe']=='08') { echo "selected='selected'"; } ?>>5è Rouge</option>
	    				<option value="09" <?php if(isset($_POST['classe']) AND $_POST['classe']=='09') { echo "selected='selected'"; } ?>>5è Verte</option>
	    				<option value="10" <?php if(isset($_POST['classe']) AND $_POST['classe']=='10') { echo "selected='selected'"; } ?>>6è Bleue</option>
	    				<option value="11" <?php if(isset($_POST['classe']) AND $_POST['classe']=='11') { echo "selected='selected'"; } ?>>6è Rouge</option>
	    				<option value="12" <?php if(isset($_POST['classe']) AND $_POST['classe']=='12') { echo "selected='selected'"; } ?>>6è Verte</option>
	    			</select></br></br>
				<input type="submit" value="Valider"/>						<!-- envoi de la requête -->
			</fieldset>
			</form>
		
</br>

		<?php include('../footer.php'); ?>
	</div>
</body>