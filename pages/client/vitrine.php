<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=Client::getDependencies()?>
    <title><?=getWebsiteSetting("websiteName")?></title>
    
    <!-- Embed -->
    <meta content="<?=getWebsiteSetting("websiteName")?>" property="og:title" />
    <meta content="<?=getWebsiteSetting("websiteDescription")?>" property="og:description" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>" property="og:url" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon.png" property="og:image" />
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />

    <!-- Uniquement pour la vitrine -->
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/css/flickity.css" media="screen">
</head>
<body>
    <!-- Inclusion dynamique de la navbar -->
    <?=Client::getNavbar()?>

    <!-- Carroussel de la vitrine -->
    <div class="carrousselVitrine js-flickity" data-flickity-options='{ "wrapAround": true }'>
        <div class="item">...</div>
        <div class="item">...</div>
        <div class="item">...</div>
    </div>
    <!-- Fin -->

    <!-- Newsletter -->
    <div class="container rounded d-flex newsletter my-5 p-4">
        <div class="flex-fill align-self-center d-flex flex-column">
            <h3><strong>Abonnez-vous à notre Newsletter</strong></h3>
            <span class="text-muted">Et recevez toutes nos dernières recettes en avant première.</span>
        </div>
        <div class="d-flex flex-fillalign-self-center">
            <div class="form-inline">
                <input class="form-control mr-2" type="email" placeholder="Votre email">
                <button type="button" class="btn btn-orange rounded-pill">S'abonner</button>
            </div>
        </div>
    </div>
    <!-- Fin -->

    <!-- Recettes -->
    <div class="container">
        <div class="block-titres">
            <h3><strong>Recettes faciles</strong></h3>
            <span class="text-muted">Une sélection de recettes simple à préparer pour vos repas.</span>
        </div>

        <div class="row pb-3">
            <?php
                $search["difficulte"] = 1;
                $recettes = getRecettes($search);
                foreach($recettes as $recette){
                    $array["userId"] = $recette["auteurId"];
                    $utilisateur = getUtilisateur($array);

                    echo('<!-- Carte recette -->
                    <div class="col-md-6">
                        <div class="carte-recette">
                            <a href="'.getWebsiteSetting("websiteUrl").genPageLink("/recette/").'?recetteId='.$recette["id"].'">
                                <div class="carte-recette-img" style="background-image: url(\''.$recette["image"].'\');"></div>
                            </a>
                            <div class="carte-recette-infos">
                                <a href="'.getWebsiteSetting("websiteUrl").genPageLink("/recette/").'?recetteId='.$recette["id"].'" class="text-dark">
                                    <h4><strong>'.utf8_decode($recette["nom"]).'</strong></h4>
                                </a>
                                <p>'.utf8_decode($recette["description"]).'</p>
                                <i><a href="'.getWebsiteSetting("websiteUrl").genPageLink("/utilisateur/").'?id='.$recette["auteurId"].'" class="text-orange">'.$utilisateur['username'].'</a> <span class="text-muted"><i class="far fa-stopwatch"></i> '.$recette["tempsPreparation"].' minutes</span></i>
                            </div>
                        </div>
                    </div>
                    <!-- Fin -->');
                }
            ?>
        </div>
    </div>

    <?=Client::getFooter()?>

    <script src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/js/flickity.pkgd.min.js"></script>
    <script type="text/javascript">
        
    </script>
</body>
</html>