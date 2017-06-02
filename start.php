<!-- Nom page : start
Description : Cette page vérifie que l'utilisateur est bien connecté et ainsi qu'il puisse accéder à des données confidentielles
Nom de l'auteur : Rémi Hillériteau -->
<?php
session_start();
if(!isset($_SESSION["connexion"])) // si la variable $_SESSION['connexion'], alors...
{
	header('Location: http://localhost/infirmerie/connexion'); // redirection vers la page connexion
}
?>