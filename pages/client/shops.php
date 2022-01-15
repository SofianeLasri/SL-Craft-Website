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
    <meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon-color.png" property="og:image" />
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />

    <!-- Uniquement pour la vitrine -->
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/css/flickity.css" media="screen">

    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/css/icons-minecraft-0.49.css">
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/css/minecraft-skinviewer.css">
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
                        $representation = $shop['item']->getRepresentation();
                        if($representation["type"] == "block"){
                            $cardTop = ('<div class="object">
                            <div class="block grass">
                                <div style="background: url(\''.getWebsiteSetting("websiteUrl").$representation["texture"][1].'\');"><!--top --></div>
                                <div style="background: url(\''.getWebsiteSetting("websiteUrl").$representation["texture"][1].'\');"><!--bottom--></div>
                                <div style="background: url(\''.getWebsiteSetting("websiteUrl").$representation["texture"][0].'\');"><!--left--></div>
                                <div style="background: url(\''.getWebsiteSetting("websiteUrl").$representation["texture"][0].'\');"><!--right--></div>
                                <div style="background: url(\''.getWebsiteSetting("websiteUrl").$representation["texture"][0].'\');"><!--back--></div>
                                <div style="background: url(\''.getWebsiteSetting("websiteUrl").$representation["texture"][0].'\');"><!--front--></div>
                            </div>
                        </div>');
                            
                        }else{
                            $cardTop = ('<img src="'.getWebsiteSetting("websiteUrl").$representation["texture"][0].'" alt="'.$shop['item']->getLabel().'">');
                        }

                        // Affichage du stock
                        if($shop['stock'] <=10){
                            $badge = "warning";
                            if($shop['stock'] <= 0){
                                $badge = "danger";
                            }
                        }else{
                            $badge = "success";
                        }

                        // Si l'item possède un nom custom, on va l'afficher
                        if($shop['item']->getDisplayName() != null){
                            $displayName = '<i class="icon-minecraft icon-minecraft-name-tag" data-toggle="tooltip" data-placement="bottom" title="Item renommé"></i> ';
                            $displayName .= (strlen($shop['item']->getDisplayName()) > 16) ? substr($shop['item']->getDisplayName(),0,13).'...' : $shop['item']->getDisplayName();
                        }else{
                            $displayName = $shop['item']->getLabel();
                        }

                        // Si l'item est enchant, on va lui appliquer un style custom
                        if($shop['item']->getEnchants() != null){
                            $displayName = '<span class="enchant">'.$displayName.'</span>';
                        }

                        $shopId = getRandomString(4);
                        echo ('<div class="col-3 mb-2" id="'.$shopId.'" x="'.$shop['x'].'" y="'.$shop['y'].'" z="'.$shop['z'].'" world="'.$shop['world'].'" displayName="'.urlencode($shop['item']->getDisplayName()).'" enchants="'.urlencode(json_encode($shop['item']->getEnchants())).'" type="'.$shop['item']->getId().'" price="'.$shop['price'].'">
                                    <div class="card" style="width: 18rem;">
                                        <div class="card-body">
                                            <span class="badge badge-'.$badge.'">Stock: '.$shop['stock'].'</span>
                                            <div class="card-top">
                                                '.$cardTop.'
                                            </div>
                                            
                                            <h5 class="card-title">'.$displayName.'</h5>
                                            <div class="d-flex align-items-center">
                                                <div class="mc-face-viewer-4x" style="background-image:url(\''.$shop['seller']->getSkin().'\')"></div>
                                                <div class="d-flex flex-column pl-2">
                                                    <span><strong>Vendu par:</strong> '.$shop['seller']->getUsername().'</span>
                                                    <span><strong>Prix:</strong> '.$shop['price'].'€</span>
                                                </div>
                                            </div>
                                            <div class="mc-button normal" onclick="goToShop(\''.$shopId.'\')">
                                                <div class="title">Acheter</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>');
                        
                    }
                    ?>
                    <?php /*
                    <!-- exemple -->
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
                    <!-- exemple -->

                    <!-- exemple -->
                    <div class="col-sm">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <div class="card-top">
                                    <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/textures/item/copper_ingot.png" alt="Item">
                                </div>
                                
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <div class="mc-button normal">
                                    <div class="title">Se téléporter</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- exemple -->
                    */ ?>

                </div>
            </div>
        </div>
    </div>

    <?=Client::getFooter()?>

    <!-- shopModal -->
    <div class="modal fade" id="shopModal">
        <div class="modal-dialog">
            <div class="modal-content" style="background-image: url('<?=getWebsiteSetting("websiteUrl")?>data/images/backgrounds/bg-wood-dark.png');">
                <div class="modal-header">
                    <h5 class="modal-title">Détails de l'article</h5>
                </div>
                <div class="modal-body" id="shopModalBody">
                    <div id="shopItemDetail"></div>
                    <div class="form-group">
                        <label>Coordonnées du magasin</label>
                        <div class="d-flex">
                            <div class="text-center px-2">
                                <label>x</label>
                                <input id="shopXPos" type="number" class="form-control" value="0" readonly>
                            </div>
                            <div class="text-center px-2">
                                <label>y</label>
                                <input id="shopYPos" type="number" class="form-control" value="0" readonly>
                            </div>
                            <div class="text-center px-2">
                                <label>z</label>
                                <input id="shopZPos" type="number" class="form-control" value="0" readonly>
                            </div>
                        </div>
                    </div>
                    <a id="shopMapLink" href="#" class="text-white" target="_blank"><i class="icon-minecraft icon-minecraft-filled-map"></i> Voir sur la carte</a>
                </div>
                <div class="modal-footer">
                    <div class="mc-button normal" data-dismiss="modal">
                        <div class="title">Fermer</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/js/flickity.pkgd.min.js"></script>
    <script type="text/javascript">
        // On va définir la taille de la div derrière la navbar
        function goToShop(id){
            var shopItemDetail='<p>Type: <strong>'+$('#'+id).attr('type')+'</strong></p>';
            if($("#"+id).attr("displayName") != ""){
                shopItemDetail+='<p>Nom personnalisé: <strong>'+decodeURIComponent($("#"+id).attr("displayName"))+'</strong></p>';
            }
            if($("#"+id).attr("enchants") != ""){
                let enchants = JSON.parse(decodeURIComponent($("#"+id).attr("enchants")));
                for(const [key, value] of Object.entries(enchants)){
                    shopItemDetail+='<p>Enchantement: <strong>'+key+'</strong> ('+value+')</p>';
                }
            }
            shopItemDetail+='<p>Prix: <strong>'+$("#"+id).attr("price")+'€</strong></p>';

            $("#shopItemDetail").html(shopItemDetail);
            $("#shopXPos").val($("#"+id).attr("x"));
            $("#shopYPos").val($("#"+id).attr("y"));
            $("#shopZPos").val($("#"+id).attr("z"));
            $("#shopMapLink").attr("href", "https://live.mc.sl-projects.com/#"+$("#"+id).attr("world")+";flat;"+$("#"+id).attr("x")+","+$("#"+id).attr("y")+","+$("#"+id).attr("z")+";5");
            $("#shopModal").modal("show");
        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        
    </script>
</body>
</html>