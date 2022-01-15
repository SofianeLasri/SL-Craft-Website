<?php
//Chargement des pages
function loadPage(){
    global $localSettings, $urlPath;
    // S'il existe un paramètre on l'affecte à pageName

    $alias = $urlPath;

    if(empty($alias[0])){
        // Si le premier alias est vide, on va donc charger la page vitrine
        $alias[0] = "vitrine";
    }

    // Maintenant qu'alias[0] aura toujours une valeur, on peut commencer à la comparer
    if($alias[0]=="admin"){
        if(!isset($alias[1])||empty($alias[1])){
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

// Vérifie si un username ou un email existe dans la bdd
function checkUsernameEmail($data){
	$pos = strpos($data, "@");
	if ($pos !== false) {
		$response = Connexion::pdo()->prepare("SELECT * FROM site_userSetting WHERE name='email' AND value=?");
		$response->execute([strtolower($data)]);
		if (empty($response->fetch())) {
			return false;
		} else {
			return true;
		}
	} else {
		$response = Connexion::pdo()->prepare("SELECT * FROM site_user WHERE username=?");
		$response->execute([strtolower($data)]);
		if (empty($response->fetch())) {
			return false;
		} else {
			return true;
		}
	}
}
function login($usernameEmail, $password){
    global $ip;
    $usernameEmail = strtolower($usernameEmail);
    $pos = strpos($usernameEmail, "@");
    if ($pos !== false) {
        $response = Connexion::pdo()->prepare("SELECT userId FROM site_userSetting WHERE name='email' AND value=?");
        $response->execute([$usernameEmail]);
        $supposedUserId = $response->fetchColumn();

        $response = Connexion::pdo()->prepare("SELECT * FROM site_user WHERE id=?");
        $response->execute([$supposedUserId]);
    } else {
        $response = Connexion::pdo()->prepare("SELECT * FROM site_user WHERE username=?");
        $response->execute([$usernameEmail]);
    }
    $user=$response->fetch(PDO::FETCH_ASSOC);
    if (!empty($user)) {
        if(password_verify($password, $user["password"])){
            // On vérifie l'ip
            $response = Connexion::pdo()->prepare("SELECT * FROM site_userSetting WHERE userId=? AND name='lastIp'");
            $response->execute([$user['id']]);
            $result = $response->fetch(PDO::FETCH_ASSOC);

            if (empty($result)) {
                // Aucun champ d'ip n'existe
                $response = Connexion::pdo()->prepare("INSERT INTO site_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
                $response->execute([$user['id'], 'lastIp', $ip]);
            }else{
                if($result["value"]!=$ip){
                    // Il existe un champ, on va le comparer
                    $response = Connexion::pdo()->prepare("UPDATE site_userSetting SET `value`=? WHERE `userId`=? AND name='lastIp'");
                    $response->execute([$ip, $user['id']]);
                }
                
            }

            $_SESSION['userId'] = $user['id'];
            $_SESSION['userName'] = $user['username'];
            $_SESSION['userGroupId'] = $user['groupId'];

            $userProfilPic = Connexion::pdo()->prepare("SELECT value FROM site_userSetting WHERE userId=? AND name='profilPic'");
            $userProfilPic->execute([$user['id']]);
            $userProfilPic = $userProfilPic->fetchColumn();

            if (empty($userProfilPic)) {
                $userProfilPic = "data/images/misc/user.png";
            }
            $userProfilPic = getWebsiteSetting("websiteUrl") . $userProfilPic;
            
            $_SESSION['userProfilePic'] = $userProfilPic;
            $return["success"] = "Connexion réussie, bienvenue " . $_SESSION['userName'] . "! 🥳";
        } else {
            $return["error"] = "Mauvais couple identifiant/mot de passe.";
        }
    } else {
        $return["error"] = "Mauvais couple identifiant/mot de passe.";
    }
    return $return;
}

function registerUser($username, $password, $email){
    if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}$/', $password)==1) {
        $username = strtolower(htmlspecialchars($username));
        $email = strtolower(htmlspecialchars($email)); // ici on converti l'email donné en casse minuscule
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Ici on récupère l'id du groupe des utilisateurs
        $userGroupId = Connexion::pdo()->query("SELECT id FROM site_userGroup WHERE nom='utilisateur'")->fetchColumn();

        // Là on va insérer l'utilisateur dans la table des utilisateurs
        $query = Connexion::pdo()->prepare("INSERT INTO site_user (id, groupId, username, password) VALUES (?,?, ?, ?)");
        $query->execute([null, $userGroupId, $username, $password]);

        // Maintenant on va récuper son id
        $query = Connexion::pdo()->prepare("SELECT id FROM site_user WHERE username=?");
        $query->execute([$username]);
        $userId = $query->fetchColumn();
        
        // On va insérer son adresse mail
        $query = Connexion::pdo()->prepare("INSERT INTO site_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
        $query->execute([$userId, 'email', $email]);

        // Sa date d'inscription
        $query = Connexion::pdo()->prepare("INSERT INTO site_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
        $query->execute([$userId, 'joinedDate', date("Y-m-d H:i:s")]);

        $return["success"] = "Inscription réussie, tu peux désormais te connecter! 🥳";
    } else {
        $return["error"] = 'Ton mot de passe doit être long d\'au moins 8 caractères et doit contenir au moins 1 majuscule, 1 minuscule et 1 nombre.';
    }
    return $return;
}

// Vérifie les permissions
function verifyUserPermission($userId, $permission){
    // $permission peut être un tableau ou un string
    if(is_array($permission)){
        if(count($permission)!=2){
            throw new Exception('Erreur! Le tableau doit être composé de 2 éléments.');
        }
        $groupName = $permission[0];
        $permissionName = $permission[1];
    }else{
        if(strpos($permission, '.') == false){
            throw new Exception('Erreur! La permission doit suivre la règle suivante: groupeName.permissionName');
        }else{
            $temp = explode('.', $permission);
            if(count($temp)!=2){
                throw new Exception('Erreur! La permission doit suivre la règle suivante: groupeName.permissionName');
            }
            $groupName = $temp[0];
            $permissionName = $temp[1];
        }
    }
    // On peut maintenant vérifier dans la bdd
    $response = Connexion::pdo()->prepare("SELECT site_permission.id FROM site_permissionGroup INNER JOIN site_permission ON site_permissionGroup.id=site_permission.groupId WHERE site_permissionGroup.name=? AND site_permission.name=?");
    $response->execute([$groupName, $permissionName]);
    $targetPermId = $response->fetchColumn();

    if(empty($targetPermId)){
        throw new Exception('Erreur! La permission \''.$groupName.'.'.$permissionName.'\' n\'existe pas.');
    }
    
    // On va commencer par vérifier les permissions de l'utilisateur
    if(isSuperAdmin($userId)){
        return true;
    }else{
        $response = Connexion::pdo()->prepare("SELECT COUNT(*) FROM site_userPermission WHERE userId=? AND permId=?");   
        $response->execute([$userId, $targetPermId]);
        $hasPermission = $response->fetchColumn();
        if($hasPermission == 0)$hasPermission = false;
        else $hasPermission = true;
    }
    

    // Si l'utilisateur n'a pas la permission, on va vérifier si le groupe l'a
    if(!$hasPermission){
        $response = Connexion::pdo()->prepare("SELECT groupId FROM site_user WHERE id=?");
        $response->execute([$userId]);
        $userGroupId = $response->fetchColumn();

        if(empty($userGroupId)){
            throw new Exception('Erreur! L\'utilisateur n\'existe pas.');
        }

        $response = Connexion::pdo()->prepare("SELECT COUNT(*) FROM site_userGroupPermission WHERE groupId=? AND permId=?");   
        $response->execute([$userGroupId, $targetPermId]);
        $hasPermission = $response->fetchColumn();
        if($hasPermission == 0)$hasPermission = false;
        else $hasPermission = true;
    }

    return $hasPermission;
}

// Check si l'utilisateur est surper utilisateur
function isSuperAdmin($userId){
    $superAdminGroupId = Connexion::pdo()->query("SELECT id FROM site_userGroup WHERE nom='superAdmin'")->fetchColumn();
    $response = Connexion::pdo()->prepare("SELECT COUNT(*) FROM site_user WHERE id=? AND groupId=?");
    $response->execute([$userId, $superAdminGroupId]);
    $isSuperAdmin = $response->fetchColumn();
    if($isSuperAdmin == 0) return false;
    else return true;
}

// Récupère les paramètres du site
function getWebsiteSetting($setting){
    $response = Connexion::pdo()->prepare("SELECT value FROM site_siteSetting WHERE name=?");
    $response->execute([$setting]);
    $settingValue = $response->fetchColumn();
    return $settingValue; // Retourne null si le paramètre n'existe pas
}

// Récupère les utilisateurs
function getUtilisateur($search=""){
    if(is_array($search)){
        $userId = $search["userId"] ?? "";

        // Si l'id utilisateur passé en paramètre est vide, il s'agit du compte Marmiton
        if($userId==0){
            $userMarmiton["username"] = "Marmiton";
            return $userMarmiton;
        } // S'arrête ici

        $username = $search["username"] ?? "";

        $queryString = "SELECT * FROM site_user WHERE 1=1";
        if(!empty($userId)){
            $queryString .= " AND id=:userId";
        }
        if(!empty($username)){
            $queryString .= " AND id LIKE :username";
        }

        // On la prépare
        $query = Connexion::pdo()->prepare($queryString." ORDER BY username");

        // On rempli les paramètres
        if(!empty($userId)){
            $query->bindParam(':userId', $userId);
        }
        if(!empty($username)){
            $query->bindParam(':username', "%".$username."%");
        }
        
        // On exécute
        $query->execute();
        // Et on retourne le résultat
        return $query->fetch(PDO::FETCH_ASSOC);
    }else{
        // Si $search n'est pas un array, on va chercher tous les utilisateurs
        $query = Connexion::pdo()->prepare("SELECT * FROM site_user ORDER BY username");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Regarde si l'utilisateur est connecté, le renvoie vers la page de connexion s'il ne l'est pas
function isConnected(){
    if(empty($_SESSION["userId"])){
        header("Location: ".genPageLink("/login"));
        exit();
    }
}

function getRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}