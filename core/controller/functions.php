<?php
//Chargement des pages
function loadPage(){
    global $localSettings, $urlPath;
    // S'il existe un paramètre on l'affecte à pageName

    // Ici on va vérifier le mode de récupération de l'url
    if($localSettings["urlMode"] == "parameters"){
        // Ici on fonctionne en mode paramètres, on va donc reconstruire l'alias

        $alias = array();
        // Si le paramètre admin existe (pas besoin qu'il ai de valeur)
        if(isset($_GET['admin'])){
            $alias[] = "admin"; // Alors on l'ajoute à l'alias
        }
        // Pareil pour les pages
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $alias[] = $_GET['page'];
        }else{
            // Maisi ici on va donner une valeur par défaut
            $alias[] = "vitrine";
        }
    }else{
        // Si on est en mode alias, alors on récupère directement la variable $urlPath
        $alias = $urlPath;
    }

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

// Générer les liens
function genPageLink($path="/"){
    global $localSettings;
    if (substr($path, 0, 1) != '/') {
        $path = '/' . $path;
    }

    $pages = explode("/", $path);
    array_shift($pages);

    $return = "index.php?";
    // Ici on va vérifier le mode de récupération de l'url
    // On prend l'exemple de ces appels: 
    // /login, /recettes?search=valeur, /admin/recettes?filterBy=DESC
    // 
    if($localSettings["urlMode"] == "parameters"){
        // est-ce que c'est une page admin?
        if($pages[0]=="admin"){
            // Oui
            if(isset($pages[1]) && !empty($pages[1])){
                $return = $return . "page=".$pages[1];
            }else{
                $return = $return . "page=index";
            }
            $return = $return . "&admin";
            if(isset($pages[2]) && !empty($pages[2])){
                $return = $return . "&".str_replace("?", "", $pages[2]);
            }
        }else{
            // Non
            if(isset($pages[0]) && !empty($pages[0])){
                $return = $return . "page=".$pages[0];
            }
            if(isset($pages[1]) && !empty($pages[1])){
                $return = $return . "&".str_replace("?", "", $pages[1]);
            }
        }
    }else{
        // Pas besoin de travailler, on donne les alias par défaut
        $path = ltrim($path, '/');
        $return = $path;
    }
    return $return;
}

// Vérifie si un username ou un email existe dans la bdd
function checkUsernameEmail($data){
	$pos = strpos($data, "@");
	if ($pos !== false) {
		$response = Connexion::pdo()->prepare("SELECT * FROM m_userSetting WHERE name='email' AND value=?");
		$response->execute([strtolower($data)]);
		if (empty($response->fetch())) {
			return false;
		} else {
			return true;
		}
	} else {
		$response = Connexion::pdo()->prepare("SELECT * FROM m_utilisateur WHERE username=?");
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
        $response = Connexion::pdo()->prepare("SELECT userId FROM m_userSetting WHERE name='email' AND value=?");
        $response->execute([$usernameEmail]);
        $supposedUserId = $response->fetchColumn();

        $response = Connexion::pdo()->prepare("SELECT * FROM m_utilisateur WHERE id=?");
        $response->execute([$supposedUserId]);
    } else {
        $response = Connexion::pdo()->prepare("SELECT * FROM m_utilisateur WHERE username=?");
        $response->execute([$usernameEmail]);
    }
    $user=$response->fetch(PDO::FETCH_ASSOC);
    if (!empty($user)) {
        if(password_verify($password, $user["password"])){
            // On vérifie l'ip
            $response = Connexion::pdo()->prepare("SELECT * FROM m_userSetting WHERE userId=? AND name='lastIp'");
            $response->execute([$user['id']]);
            $result = $response->fetch(PDO::FETCH_ASSOC);

            if (empty($result)) {
                // Aucun champ d'ip n'existe
                $response = Connexion::pdo()->prepare("INSERT INTO m_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
                $response->execute([$user['id'], 'lastIp', $ip]);
            }else{
                if($result["value"]!=$ip){
                    // Il existe un champ, on va le comparer
                    $response = Connexion::pdo()->prepare("UPDATE m_userSetting SET `value`=? WHERE `userId`=? AND name='lastIp'");
                    $response->execute([$ip, $user['id']]);
                }
                
            }

            $_SESSION['userId'] = $user['id'];
            $_SESSION['userName'] = $user['username'];
            $_SESSION['userGroupId'] = $user['groupId'];

            $userProfilPic = Connexion::pdo()->prepare("SELECT value FROM m_userSetting WHERE userId=? AND name='profilPic'");
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
        $userGroupId = Connexion::pdo()->query("SELECT id FROM m_groupeUtilisateur WHERE nom='utilisateur'")->fetchColumn();

        // Là on va insérer l'utilisateur dans la table des utilisateurs
        $query = Connexion::pdo()->prepare("INSERT INTO m_utilisateur (id, groupId, username, password) VALUES (?,?, ?, ?)");
        $query->execute([null, $userGroupId, $username, $password]);

        // Maintenant on va récuper son id
        $query = Connexion::pdo()->prepare("SELECT id FROM m_utilisateur WHERE username=?");
        $query->execute([$username]);
        $userId = $query->fetchColumn();
        
        // On va insérer son adresse mail
        $query = Connexion::pdo()->prepare("INSERT INTO m_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
        $query->execute([$userId, 'email', $email]);

        // Sa date d'inscription
        $query = Connexion::pdo()->prepare("INSERT INTO m_userSetting (`userId`, `name`, `value`) VALUES (?,?,?)");
        $query->execute([$userId, 'joinedDate', date("Y-m-d H:i:s")]);

        $return["success"] = "Inscription réussie, tu peux désormais te connecter! 🥳";
    } else {
        $return["error"] = 'Ton mot de passe doit être long d\'au moins 8 caractères et doit contenir au moins 1 majuscule, 1 minuscule et 1 nombre.';
    }
    return $return;
}

// Recettes
function getRecettes($search=""){
    // C'est gitcopilot qui écrit 75% de cette fonction

    // On va récupérer les recettes selon la recherche
    // Si $search est une liste, on va chercher selon son contenu
    // $search["categoryId"], $search["name"], ["ingredientId"], ["difficulte"], ["time"], ["auteurId"]
    if(is_array($search) && !empty($search)){
        // https://stackoverflow.com/a/18603279
        $categoryId = $search["categoryId"] ?? "";
        $name = $search["name"] ?? "";
        $ingredients = $search["ingredients"] ?? "";
        $difficulte = $search["difficulte"] ?? "";
        $tempsPreparation = $search["tempsPreparation"] ?? "";
        $auteurId = $search["auteurId"] ?? "";

        // On construit la requête
        $queryString = "SELECT * FROM m_recette INNER JOIN m_recetteIngredient ON m_recette.id=m_recetteIngredient.recetteId  WHERE 1=1";
        if(!empty($categoryId)){
            $queryString .= " AND categoryId=:categoryId";
        }
        if(!empty($name)){
            $queryString .= " AND nom LIKE :name";
        }
        if(!empty($ingredients)){
            $ingredientsIn = implode(',', $ingredients);
            $queryString .= " AND ingredientId IN (:ingredients)";
        }
        if(!empty($difficulte)){
            $queryString .= " AND difficulte=:difficulte";
        }
        if(!empty($tempsPreparation)){
            $queryString .= " AND tempsPreparation=:tempsPreparation";
        }
        if(!empty($auteurId)){
            $queryString .= " AND auteurId=:auteurId";
        }
        // On la prépare
        $query = Connexion::pdo()->prepare($queryString." ORDER BY nom");

        // On rempli les paramètres
        if(!empty($categoryId)){
            $query->bindParam(':categoryId', $categoryId);
        }
        if(!empty($name)){
            $name = "%".$name."%";
            $query->bindParam(':name', $name);
        }
        if(!empty($ingredientId)){
            $query->bindParam(':ingredients', $ingredientsIn);
        }
        if(!empty($difficulte)){
            $query->bindParam(':difficulte', $difficulte);
        }
        if(!empty($tempsPreparation)){
            $query->bindParam(':tempsPreparation', $tempsPreparation);
        }
        if(!empty($auteurId)){
            $query->bindParam(':auteurId', $auteurId);
        }

        // On exécute
        $query->execute();
        // Et on retourne le résultat
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }else{
        // Si $search n'est pas un array, on va chercher toutes les recettes
        $query = Connexion::pdo()->prepare("SELECT * FROM m_recette ORDER BY nom");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
function getRecette($recetteId){
    $query = Connexion::pdo()->prepare("SELECT * FROM m_recette WHERE id=?");
    $query->execute([$recetteId]);
    return $query->fetch(PDO::FETCH_ASSOC);
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
    $response = Connexion::pdo()->prepare("SELECT m_permission.id FROM m_permissionGroup INNER JOIN m_permission ON m_permissionGroup.id=m_permission.groupId WHERE m_permissionGroup.name=? AND m_permission.name=?");
    $response->execute([$groupName, $permissionName]);
    $targetPermId = $response->fetchColumn();

    if(empty($targetPermId)){
        throw new Exception('Erreur! La permission \''.$groupName.'.'.$permissionName.'\' n\'existe pas.');
    }
    
    // On va commencer par vérifier les permissions de l'utilisateur
    if(isSuperAdmin($userId)){
        return true;
    }else{
        $response = Connexion::pdo()->prepare("SELECT COUNT(*) FROM m_permissionUtilisateur WHERE userId=? AND permId=?");   
        $response->execute([$userId, $targetPermId]);
        $hasPermission = $response->fetchColumn();
        if($hasPermission == 0)$hasPermission = false;
        else $hasPermission = true;
    }
    

    // Si l'utilisateur n'a pas la permission, on va vérifier si le groupe l'a
    if(!$hasPermission){
        $response = Connexion::pdo()->prepare("SELECT groupId FROM m_utilisateur WHERE id=?");
        $response->execute([$userId]);
        $userGroupId = $response->fetchColumn();

        if(empty($userGroupId)){
            throw new Exception('Erreur! L\'utilisateur n\'existe pas.');
        }

        $response = Connexion::pdo()->prepare("SELECT COUNT(*) FROM m_permissionGroupeUtilisateur WHERE groupId=? AND permId=?");   
        $response->execute([$userGroupId, $targetPermId]);
        $hasPermission = $response->fetchColumn();
        if($hasPermission == 0)$hasPermission = false;
        else $hasPermission = true;
    }

    return $hasPermission;
}

// Check si l'utilisateur est surper utilisateur
function isSuperAdmin($userId){
    $superAdminGroupId = Connexion::pdo()->query("SELECT id FROM m_groupeUtilisateur WHERE nom='superAdmin'")->fetchColumn();
    $response = Connexion::pdo()->prepare("SELECT COUNT(*) FROM m_utilisateur WHERE id=? AND groupId=?");
    $response->execute([$userId, $superAdminGroupId]);
    $isSuperAdmin = $response->fetchColumn();
    if($isSuperAdmin == 0) return false;
    else return true;
}

// Récupère les paramètres du site
function getWebsiteSetting($setting){
    $response = Connexion::pdo()->prepare("SELECT value FROM m_siteSetting WHERE name=?");
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

        $queryString = "SELECT * FROM m_utilisateur WHERE 1=1";
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
        $query = Connexion::pdo()->prepare("SELECT * FROM m_utilisateur ORDER BY username");
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

// Récupréation diverses infos relatives aux recettes
function getCategories(){
    $query = Connexion::pdo()->prepare("SELECT * FROM m_categorie ORDER BY nom");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
function getUstensiles(){
    $query = Connexion::pdo()->prepare("SELECT * FROM m_ustensile ORDER BY nom");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
function getIngredients($recetteId=""){
    if(empty($recetteId)){
        $query = Connexion::pdo()->prepare("SELECT * FROM m_ingredient ORDER BY nom");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $query = Connexion::pdo()->prepare("SELECT * FROM m_ingredient WHERE id IN (SELECT ingredientId FROM m_recetteIngredient WHERE recetteId=:recetteId) ORDER BY nom");
        $query->bindParam(':recetteId', $recetteId);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

// Envoyer une recette
function sendRecette($recetteTitle, $recetteContent, $recetteDescription, $recetteCategory, $recetteIngredients, $recettePreparation, $recetteUstensiles, $recetteHeaderPic, $recetteDifficulte){
    $recetteTitle = utf8_encode(htmlspecialchars($recetteTitle));
    $recetteContent = utf8_encode(htmlspecialchars($recetteContent));
    $recetteDescription = utf8_encode(htmlspecialchars($recetteDescription));
    $quantite = 1; // Je suis un boulet j'ai oublié ça xD

    // On insert la recette
    $query = Connexion::pdo()->prepare("INSERT INTO m_recette (id, categoryId, auteurId, nom, description, contenu, image, tempsPreparation, difficulte, datePost, dateModif) VALUES (NULL, :categoryId, :auteurId, :nom, :description, :contenu, :image, :tempsPreparation, :difficulte, NOW(), NOW())");
    $query->bindParam(':categoryId', $recetteCategory);
    $query->bindParam(':auteurId', $_SESSION["userId"]);
    $query->bindParam(':nom', $recetteTitle);
    $query->bindParam(':description', $recetteDescription);
    $query->bindParam(':contenu', $recetteContent);
    $query->bindParam(':image', $recetteHeaderPic);
    $query->bindParam(':tempsPreparation', $recettePreparation);
    $query->bindParam(':difficulte', $recetteDifficulte);
    $query->execute();

    // Puis on répertorie les ingrédients
    $recetteId = Connexion::pdo()->lastInsertId();
    foreach($recetteIngredients as $ingredient){
        $query = Connexion::pdo()->prepare("INSERT INTO m_recetteIngredient (recetteId, ingredientId, quantite) VALUES (:recetteId, :ingredientId, :quantite)");
        $query->bindParam(':recetteId', $recetteId);
        $query->bindParam(':ingredientId', $ingredient);
        $query->bindParam(':quantite', $quantite); 
        $query->execute();
    }
    // Et on termine par les ustensiles
    foreach($recetteUstensiles as $ustensile){
        $query = Connexion::pdo()->prepare("INSERT INTO m_recetteUstensile (recetteId, ustensileId) VALUES (:recetteId, :ustensileId)");
        $query->bindParam(':recetteId', $recetteId);
        $query->bindParam(':ustensileId', $ustensile);
        $query->execute();
    }
    // On retourne l'id de la recette
    return $recetteId;
}