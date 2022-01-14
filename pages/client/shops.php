<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?=Client::getDependencies()?>
    <title><?=getWebsiteSetting("websiteName")?> | Magasins</title>
    
    <!-- Embed -->
    <meta content="<?=getWebsiteSetting("websiteName")?> | Magasins" property="og:title" />
    <meta content="Liste des magasins créés par les joueurs en jeu." property="og:description" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>" property="og:url" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon-blanc.svg" property="og:image" />
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />

    <!-- Uniquement pour la vitrine -->
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/css/flickity.css" media="screen">

    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/css/icons-minecraft-0.49.css">
</head>
<body>
    <!-- Inclusion dynamique de la navbar -->
    <?=Client::getNavbar()?>
    <div id="navbarReplacement" style="z-index:-1;"></div>
    
    <!-- Contenu -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-6 col-md-2 border-right shopsFilters">
                <h3>Filtres</h3>
                <form method="get" name="filterForm">
                    <div class="form-group">
                        <label>Example multiple select</label>
                        <select multiple class="form-control" name="blocs[]">
                            <?php
                            $items = Shop::getAllProducts();
                            if(isset($_GET["blocs"]) && in_array($item->getId(), $_GET["blocs"])){
                                $selected = "selected";
                            }else{
                                $selected = "";
                            }
                            foreach($items as $item) {
                                echo '<option value="'.$item->getId().'" '.$selected.'><i class="icon-minecraft '.$item->getCss().'"></i> '.$item->getLabel().'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mc-button normal" onclick="document.forms['filterForm'].submit();">
                        <div class="title">Rejoindre</div>
                    </div>
                </form>
            </div>
            <div class="col-md-10">
                <h3>Liste des magasins</h3>
            </div>
        </div>
    </div>

    <?=Client::getFooter()?>

    <script src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/js/flickity.pkgd.min.js"></script>
    <script type="text/javascript">
        // On va définir la taille de la div derrière la navbar
        
        
        
    </script>
</body>
</html>