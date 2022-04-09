<?php
// Récupération du lien du site (évite de devoir appeler la base de donnée)
function getWebsiteUrl(): string
{
    global $httpProtocol;
    return $httpProtocol."://" . $_SERVER['HTTP_HOST'] . "/";
}

//Chargement des pages
function loadPage(){
    global $urlPath;
    // S'il existe un paramètre on l'affecte à pageName

    $alias = $urlPath;

    if(empty($alias[0])){
        // Si le premier alias est vide, on va donc charger la page vitrine
        $alias[0] = "vitrine";
    }

    // Maintenant qu'alias[0] aura toujours une valeur, on peut commencer à la comparer
    if($alias[0]=="admin"){
        if(empty($alias[1])){
            $alias[1] = "index";
        }

        // Si le premier alias est admin, on va donc appeller la fonction qui se charge de gérer les pages admin
        array_shift($alias); // On supprime le /admin pour que la fonction loadAdminPage puisse directement vérifier les pages
        require "core/classes/Admin.php";
        Admin::loadPage($alias);
    }else{
        // Il s'agit d'une page client
        require "core/classes/Client.php";
        Client::loadPage($alias);
    }
}

// Vérifie les permissions
/**
 * @throws Exception
 */
function verifyUserPermission($userUUID, $permission): bool
{
    // $permission doit être un string
    if (!is_string($permission)) {
        throw new Exception("La permission doit être une chaîne de caractères");
    }
    // On va vérifier la permission dans les tables de LuckPerms
    $permission = strtolower($permission);

    // On va regarder si l'utilisateur a une autorisation particulière
    $permissionExists = BddConn::getPdo()->prepare("SELECT * FROM luckperms_user_permissions WHERE uuid = :user_uuid AND permission = :permission AND value = 1");
    $permissionExists->bindParam(":user_uuid", $userUUID);
    $permissionExists->bindParam(":permission", $permission);
    $permissionExists->execute();
    $permissionExists = $permissionExists->fetch(PDO::FETCH_ASSOC);

    if($permissionExists){
        $hasPermission = true;
    }else{
        // L'utilisateur n'a pas d'autorisation particulière
        // Du coup on va regarder à quel groupe appartient l'utilisateur
        $groupName = BddConn::getPdo()->prepare("SELECT primary_group FROM luckperms_players WHERE uuid = :uuid");
        $groupName->bindParam(":uuid", $userUUID);
        $groupName->execute();
        $groupName = $groupName->fetch(PDO::FETCH_COLUMN);

        // Maintenant on va chercher si le groupe a la permission
        $hasPermission = verifyGroupPermission($groupName, $permission);
    }
    // On retourne le résultat
    return $hasPermission;
}

// Vérifie les permissions d'un groupe
/**
 * @throws Exception
 */
function verifyGroupPermission($groupName, $permission): bool
{
    // $permission doit être un string
    if (!is_string($permission)) {
        throw new Exception("La permission doit être une chaîne de caractères");
    }
    // On va dire que par défaut, il n'a pas les perms
    $hasPermission = false;

    // On va vérifier si le groupe a toutes les permissions
    $permissionExists = BddConn::getPdo()->prepare("SELECT * FROM luckperms_group_permissions WHERE name = :name AND permission = '*' AND value = 1");
    $permissionExists->bindParam(":name", $groupName);
    $permissionExists->execute();
    $permissionExists = $permissionExists->fetch(PDO::FETCH_ASSOC);

    if($permissionExists){
        // Le groupe a toutes les permissions
        $hasPermission = true;
    }else{
        $permissionExists = BddConn::getPdo()->prepare("SELECT * FROM luckperms_group_permissions WHERE name = :name AND permission LIKE :permission");
        $permissionExists->bindParam(":name", $groupName);
        $permissionExists->bindParam(":permission", $permission);
        $permissionExists->execute();
        $permissionExists = $permissionExists->fetch(PDO::FETCH_ASSOC);

        if ($permissionExists) {
            $hasPermission = true;
        }
    }
    return $hasPermission;
}

// Récupère les paramètres du site
function getWebsiteSetting($setting){
    // On va vérifier qu'on ne demande pas l'url du site, vu qu'on a créé une fonction pour la récupérer
    if($setting == "websiteUrl"){
        return getWebsiteUrl();
    }
    $response = BddConn::getPdo()->prepare("SELECT value FROM site_siteSetting WHERE name=?");
    $response->execute([$setting]);
    return $response->fetchColumn(); // Retourne null si le paramètre n'existe pas
}

function getRandomString($length): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($index = 0; $index < $length; $index++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}