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
    <meta content="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/short-blanc.png" property="og:image" />
    <meta content="<?=getWebsiteSetting("mainColor")?>" data-react-helmet="true" name="theme-color" />

    <!-- Uniquement pour la vitrine -->
    <link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/css/flickity.css" media="screen">
</head>
<body>
    <!-- Inclusion dynamique de la navbar -->
    <?=Client::getNavbar()?>

    <!-- Intro -->
    <div id="intro">
        <div id="vitrine-background-image" style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?=getWebsiteSetting("websiteUrl")?>data/images/backgrounds/sildur-vibrant.png');" bgImageUrl="<?=getWebsiteSetting("websiteUrl")?>data/images/backgrounds/sildur-vibrant.png"></div>
        <div class="container intro-vitrine">
            <div id="intro-presentation" class="presentation">
                <div class="description">
                    <h1>Starisland</h1>
                    <p>Un petit paradis sur terre où règnent les vieux retraités, venus finir leur jours paisiblements.
                    <br>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    </p>
                </div>
            </div>
            <div class="illustration" style="background-image: url('<?=getWebsiteSetting("websiteUrl")?>data/images/vitrine/let's%20go.png');" bgImageUrl="<?=getWebsiteSetting("websiteUrl")?>data/images/vitrine/let's%20go.png"></div>
        </div>
    </div>
    
    <!-- Fin de l'intro -->

    <?=Client::getFooter()?>

    <script src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/flickity/js/flickity.pkgd.min.js"></script>
    <script type="text/javascript">
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
            // On va regarder si dans ce que l'on va afficher, il n'y a pas des images à charger
            var imagesToLoad = [];
            $(".intro-vitrine .presentation > *").each(async function() {
                let hasABgImageToLoad = $(this).attr('bgImageUrl');
                if (typeof hasABgImageToLoad !== 'undefined' && hasABgImageToLoad !== false) {
                    imagesToLoad.push(hasABgImageToLoad);
                }
            });
            console.log("Images à charger:"+imagesToLoad);
            await loadImages(imagesToLoad);
            $(".intro-vitrine .presentation > *").fadeIn(1000);
            $(".intro-vitrine .presentation .description").css("display", "flex"); // On a retiré la propriété flex pour faire le fadeIn

            imagesToLoad = [];
            setTimeout(async function(){
                let hasABgImageToLoad = $("#vitrine-background-image:hidden").attr('bgImageUrl');
                if (typeof hasABgImageToLoad !== 'undefined' && hasABgImageToLoad !== false) {
                    imagesToLoad.push(hasABgImageToLoad);
                }
                console.log("Images à charger:"+imagesToLoad);
                await loadImages(imagesToLoad);
                $("#vitrine-background-image:hidden").fadeIn(4000);
            }, 1000)
            
        });
        
    </script>
</body>
</html>