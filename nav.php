<!-- Nom page : nav (menue)
Description : Menue de navigation du site pour les pages recherches
Nom de l'auteur : Rémi Hillériteau -->
<div class="nav">

	<div class="lien">
		<p>Critère de sélection</p>
	</div>
	<div class="<?php if($nomPage=="eleve") { echo 'pageActif'; } else { echo 'lien'; } ?>"> <!-- On vérifie si la page est actif -->
		<p><a href="http://localhost/infirmerie/eleve/">élève</a></p>
	</div>
	<div class="<?php if($nomPage=="date") { echo 'pageActif'; } else { echo 'lien'; } ?>">
		<p><a href="http://localhost/infirmerie/date/">date</a></p>
	</div>
	<div class="<?php if($nomPage=="periode") { echo 'pageActif'; } else { echo 'lien'; } ?>">
		<p><a href="http://localhost/infirmerie/periode/">période</a></p>
	</div>
	<div class="<?php if($nomPage=="motif") { echo 'pageActif'; } else { echo 'lien'; } ?>">
		<p><a href="http://localhost/infirmerie/motif/">motif</a></p>
	</div>

</div>
<div class="menue-gauche">
	<div class="bouton">
		<p><a href="http://localhost/infirmerie/nouvelleVisite/">Nouvelle entrée</a></p>
	</div>
	<div class="bouton">
		<p><a href="http://localhost/infirmerie/deconnexion.php">Déconnexion</a></p>
	</div>
</div>
