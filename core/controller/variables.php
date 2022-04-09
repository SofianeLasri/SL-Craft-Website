<?php
// Ce fichier ne contient que les variables qui seront constament utilisées

// On récupère l'ip
$clientIp = null;
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $clientIp = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $clientIp = $_SERVER['REMOTE_ADDR'];
}

// Vérifie le type de connexion
if(isset($_SERVER['HTTPS'])) $httpProtocol = "https"; else $httpProtocol = "http";

// Variables permettant la gestion des pages à afficher
$urlRequest = parse_url("$httpProtocol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$urlPath = explode("/", $urlRequest["path"]);
array_shift($urlPath); // Je suprime le premier élément car il sera toujours vide pour une raison que j'ignore