<!-- Nom page : déconnexion
Description : Fermer la session de l'utilisateur
Nom de l'auteur : Rémi Hillériteau -->
<?php
session_start();
session_destroy(); // Détruire toutes les variables "SESSION"
header('Location: http://localhost/infirmerie'); // Rediriger l'utilisateur vers la page d'accueil
?>