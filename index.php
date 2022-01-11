<?php
session_start();

// Ici on commence par intégrer les différents fichiers qui nous serviront à faire fonctionner le site
require_once "core/conf/ConfigurationGenerale.php"; // Ce fichier contient divers paramètres
require_once "core/conf/Connexion.php"; // Ce fichier se charge de la connexion à la base de donnée
require_once "core/controller/variables.php"; // Ce fichier se charge de récupérer les variables globales
require_once "core/controller/functions.php"; // Et celui-ci des différentes fonctions

// On initialise la connexion à la base de données
Connexion::connect();
// Et on appelle la page demandée
loadPage();