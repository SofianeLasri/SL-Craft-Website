<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <!-- Dépendances -->
    <?php Client::getDependencies(); ?>
    <title><?=getWebsiteSetting("websiteName")?></title>
    
    <!-- Embed -->
    <meta content="<?=getWebsiteSetting("websiteName")?>" property="og:title" />
    <meta content="<?=getWebsiteSetting("websiteDescription")?>" property="og:description" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>" property="og:url" />
    <meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon-color.png" property="og:image" />
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />

    <!-- Uniquement pour la vitrine -->
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/css/flickity.css" media="screen">
</head>
<body>
    <!-- Inclusion dynamique de la navbar -->
    <?php Client::getNavbar(); ?>

    <!-- Intro -->
    <div id="intro">
        <div id="vitrine-background-image" style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('<?=getWebsiteSetting("websiteUrl")?>data/images/backgrounds/sildur-vibrant.png');" bgImageUrl="<?=getWebsiteSetting("websiteUrl")?>data/images/backgrounds/sildur-vibrant.png"></div>
        <div class="container intro-vitrine">
            <div id="intro-presentation" class="presentation">
                <div class="description">
                    <h1>Prêt pour la survie?</h1>
                    <p>Rejoins-nous et découvre une communauté construite autour de l’amour pour la survie !
                    <br>Nous disposons de nombreux plugins favorisants l’interaction entre les joueurs, et enrichissant ton expérience de jeu.</p>
                    <div class="mc-button normal" data-toggle="modal" data-target="#connectModal">
                        <div class="title">Rejoindre</div>
                    </div>
                </div>
                <div class="illustration" style="background-image: url('<?=getWebsiteSetting("websiteUrl")?>data/images/vitrine/letsgo.png');" bgImageUrl="<?=getWebsiteSetting("websiteUrl")?>data/images/vitrine/letsgo.png"></div>
            </div>
        </div>
    </div>
    
    <!-- Fin de l'intro -->

    <?php Client::getFooter(); ?>

    <!-- connectModal -->
    <div class="modal fade" id="connectModal">
        <div class="modal-dialog">
            <div class="modal-content" style="background-image: url('<?=getWebsiteSetting("websiteUrl")?>data/images/backgrounds/bg-wood-dark.png');">
                <div class="modal-header">
                    <h5 class="modal-title">Rejoindre le serveur</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ipJava">Minecraft Java Edition</label>
                        <input id="ipJava" type="text" class="form-control" value="play.sl-craft.fr" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ipBedrock">Minecraft Bedrock Edition</label>
                        <input id="ipBedrock" type="text" class="form-control" value="proxy.sl-craft.fr:19132" readonly>
                    </div>
                    <p>*Le serveur est cross-plateformes, vous jouez sur une unique map.</p>
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
        // On va définir la taille de l'intro
        setVitrineHeight();
        function setVitrineHeight() {
            let vitrineHeight = window.innerHeight - document.getElementById("navbar").offsetHeight;
            $("#intro").css("height", vitrineHeight);
        }
        window.onresize = setVitrineHeight;


        // https://stackoverflow.com/a/56341485
        async function loadImages(imageUrlArray) {
            const promiseArray = []; // create an array for promises
            const imageArray = []; // array for the images

            for (let imageUrl of imageUrlArray) {

                promiseArray.push(new Promise(resolve => {

                    const img = new Image();
                    // if you don't need to do anything when the image loads,
                    // then you can just write img.onload = resolve;

                    img.onload = function() {
                        // do stuff with the image if necessary

                        // resolve the promise, indicating that the image has been loaded
                        resolve();
                    };

                    img.src = imageUrl;
                    imageArray.push(img);
                }));
            }

            await Promise.all(promiseArray); // wait for all the images to be loaded
            console.log("Toutes les images ont été chargées.");
            return imageArray;
        }

        $(window).on("load", async function() {
            // 


            // On va regarder si dans ce que l'on va afficher, il n'y a pas des images à charger
            let imagesToLoad = [];
            let presentationElems = $(".intro-vitrine .presentation > *");
            presentationElems.each(async function() {
                let hasABgImageToLoad = $(this).attr('bgImageUrl');
                if (typeof hasABgImageToLoad !== 'undefined' && hasABgImageToLoad !== false) {
                    imagesToLoad.push(hasABgImageToLoad);
                }
            });
            console.log("Images à charger:"+imagesToLoad);
            await loadImages(imagesToLoad);
            presentationElems.fadeIn(1000);
            $(".intro-vitrine .presentation .description").css("display", "flex"); // On a retiré la propriété flex pour faire le fadeIn

            imagesToLoad = [];
            setTimeout(async function(){
                let hiddenVitrineBackground = $("#vitrine-background-image:hidden");
                let hasABgImageToLoad = hiddenVitrineBackground.attr('bgImageUrl');
                if (typeof hasABgImageToLoad !== 'undefined' && hasABgImageToLoad !== false) {
                    imagesToLoad.push(hasABgImageToLoad);
                }
                console.log("Images à charger:"+imagesToLoad);
                await loadImages(imagesToLoad);
                hiddenVitrineBackground.fadeIn(4000);
            }, 1000)
            
        });
        
    </script>
</body>
</html>