<!-- Nom page : nav (menue)
Description : Menue de navigation du site pour les pages nouvelles entrées
Nom de l'auteur : Rémi Hillériteau -->
<div class="nav">

	<div class="lien">
		<p>Nouvelle entrée</p>
	</div>
	<div class="<?php if($nomPage=="nouvelleVisite") { echo 'pageActif'; } else { echo 'lien'; } ?>"> <!-- On vérifie si la page est actif -->
		<p><a href="http://localhost/infirmerie/nouvelleVisite/">Nouvelle visite</a></p>
	</div>
	<div class="<?php if($nomPage=="nouveauEleve") { echo 'pageActif'; } else { echo 'lien'; } ?>">
		<p><a href="http://localhost/infirmerie/nouvelEleve/">Nouvel élève</a></p>
	</div>
</div>

</div>
<div class="menue-gauche">
	<div class="bouton">
		<p><a href="http://localhost/infirmerie/eleve/">Historique des visites</a></p>
	</div>
	<div class="bouton">
		<p><a href="http://localhost/infirmerie/deconnexion.php">Déconnexion</a></p>
	</div>
</div>
