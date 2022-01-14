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
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/css/bloc.css">
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
                        <label>Trier par entité/bloc</label>
                        <select multiple class="form-control" name="blocs[]">
                            <option value="">Aucune</option>
                            <?php
                            $items = Shop::getAllProducts();
                            foreach($items as $item) {
                                if(isset($_GET["blocs"]) && in_array($item->getId(), $_GET["blocs"])){
                                    $selected = "selected";
                                }else{
                                    $selected = "";
                                }
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

                <div class="row">
                    <?php
                    $shops = Shop::getShops();
                    foreach($shops as $shop){
                        $texture = $shop['item']->getTexture();
                        echo ('<div class="col-sm">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <div class="card-top">
                                                <div class="object">
                                                    <div class="block grass">
                                                        <div style="background: url(\''.getWebsiteSetting("websiteUrl").$texture[1].'\');"><!--top --></div>
                                                        <div style="background: url(\''.getWebsiteSetting("websiteUrl").$texture[1].'\');"><!--bottom--></div>
                                                        <div style="background: url(\''.getWebsiteSetting("websiteUrl").$texture[0].'\');"><!--left--></div>
                                                        <div style="background: url(\''.getWebsiteSetting("websiteUrl").$texture[0].'\');"><!--right--></div>
                                                        <div style="background: url(\''.getWebsiteSetting("websiteUrl").$texture[0].'\');"><!--back--></div>
                                                        <div style="background: url(\''.getWebsiteSetting("websiteUrl").$texture[0].'\');"><!--front--></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <h5 class="card-title">'.$shop['item']->getLabel().'</h5>
                                            <p class="card-text">Test content</p>
                                            <div class="mc-button normal">
                                                <div class="title">Se téléporter</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>');
                    }
                    ?>
                    <div class="col-sm">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <div class="card-top">
                                    <div class="object">
                                        <div class="block grass">
                                            <div><!--top --></div>
                                            <div><!--bottom--></div>
                                            <div><!--left--></div>
                                            <div><!--right--></div>
                                            <div><!--back--></div>
                                            <div><!--front--></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <div class="mc-button normal">
                                    <div class="title">Se téléporter</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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