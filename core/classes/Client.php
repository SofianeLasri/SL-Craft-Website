<?php
class Client{
    // Charger une page client
    public static function loadPage($alias){
        // Charger le fichier de la page
        if($alias[0]=="backTasks" && (!empty($_POST)||!empty($_GET))){
            // Si le premier alias est backTasks, on va donc charger la page backTasks
            // backTasks est un alias que l'on appel pour toutes requêtes Javascript ex: vérification de l'existence d'un email dans la bdd
            // Cette page n'est pas censée être accessible au public, c'est pourquoi on renverra 404 si aucune requête n'est demandée
            require "core/controller/clientBackTasks.php";
        }else{
            // On va vérifier que la page existe
            if(file_exists('pages/client/'.$alias[0].'.php')){
                require 'pages/client/'.$alias[0].'.php';
            }else{
                // Si elle n'existe pas, on va charger la page 404
                Client::show404($alias[0]);
            }
        }
    }

    // Afficher la page 404
    public static function show404($pageName){
        require 'pages/client/404.php';
    }

    // Récupérer les dépendances
    public static function getDependencies(){
        require 'pages/client/includes/dependencies.php';
    }

    //récupère la barre de navigation
    public static function getNavbar(){
        require 'pages/client/includes/navbar.php';
    }
    //récupère le footer
    public static function getFooter(){
        require 'pages/client/includes/footer.php';
    }
}