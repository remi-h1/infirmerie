<html>
<head>
    	<title>Eleve</title>
		<meta charset='UTF-8' />
		<link rel='stylesheet' href='http://localhost/infirmerie/connexion/style.css' />
	</head>
<body>

<?php
session_start(); // On ouvre une session
if(isset($_SESSION["connexion"]))
{
	header('Location: http://localhost/infirmerie/eleve/'); // Si l'utilisateur est déjà connecté, on le renvoi sur la page d'accueil
}

?>	
	<div class="pageConnexion">
		<div class="ChampConnexion">
			<h1 class="Connexion">Connexion</h1>
			<?php
				if(isset($_POST['password'])) // Si un mot de passe est envoyé
				{
					if($_POST['password']=="1234") // et qu'il est bon
					{
						$_SESSION['connexion']=true; // Alors dire que la connexion est bonne
						header('Location: http://localhost/infirmerie/eleve/'); // envoyer l'utilisateur sur la première page du site "page élève"
					}
					else
					{
						?>
							<p class="alerteViolet">Le mot de passe est incorrecte</p> <!-- Sinon, afficher un message -->
						<?php
					}
				}
			?>
			<p class="Connexion" style="">Ce site contient des informations confidentielles</p>
			
			<!-- formulaire pour se connexter -->
			<form method="post" action="http://localhost/infirmerie/connexion/">
				<label for="password" class="Connexion">Mot de passe : </label> <input class="passwordConnexion" type="password" name="password" id="password" size="25" maxlenght="25" autofocus  />
				<input type="submit" value="Envoyer" class="Connexion"/>
				
			</form>
		</div>
	</div>
</body>
</html>