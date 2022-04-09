<?php
class Admin{
    // Charger une page admin
    /**
     * @throws Exception
     */
    public static function loadPage($alias){
        if(Admin::checkAdmin()){
            if($alias[0]=="backTasks" && (!empty($_POST)||!empty($_GET))){
                // Si le premier alias est backTasks, on va donc charger la page backTasks
                // backTasks est un alias que l'on appel pour toutes requêtes Javascript ex: vérification de l'existence d'un email dans la bdd
                // Cette page n'est pas censée être accessible au public, c'est pourquoi on renverra 404 si aucune requête n'est demandée
                require "core/controller/adminBackTasks.php";
            }else{
                // On va vérifier que la page existe
                if(file_exists('pages/admin/'.$alias[0].'.php')){
                    if(verifyUserPermission($_SESSION['uuid'], "slcraft.website.admin.".$alias[0]."access")){
                        require 'pages/admin/'.$alias[0].'.php';
                    }else{
                        Admin::show403($alias[0]);
                    }
                }else{
                    // Si elle n'existe pas, on va charger la page 404
                    Admin::show404($alias[0]);
                }
            }
        }else{
            // Retrour sur la page de connexion si non conneté, ou s'il n'a pas les perms
            header("Location: /login");
        }
        
    }

    // Afficher la page 404
    public static function show404($pageName){
        require 'pages/admin/404.php';
    }
    // Afficher la page 403
    public static function show403($pageName){
        require 'pages/admin/403.php';
    }

    // Récupérer les dépendances
    public static function getDependencies(){
        require 'pages/admin/includes/dependencies.php';
    }

    //récupère la barre de navigation
    public static function getNavbar(){
        require 'pages/admin/includes/navbar.php';
    }
    //récupère le footer
    public static function getFooter(){
        require 'pages/admin/includes/footer.php';
    }

    // Vérifie que l'utilisateur a le droit d'accéder au panel admin
    public static function checkAdmin(){
        if(!isset($_SESSION['userId']) || verifyUserPermission($_SESSION['userId'], "adminPanel.access")==false){
            return false;
        }else{
            return true;
        }
    }
}