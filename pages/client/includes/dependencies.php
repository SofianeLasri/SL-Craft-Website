<?php
// Ce fichier contient les dépendances HTML/CSS/JS des pages du site
// Il faut donc l'inclure dans le "head" de chaque page
?>
<!-- Icône du site -->
<link rel="icon" type="image/svg+xml" href="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon.svg">
<link rel="alternate icon" href="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon.ico">
<link rel="mask-icon" href="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/favicon.svg" color="#ed8930">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<!-- Polices d'écriture -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/fontawesome/css/all.min.css">
<script src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/fontawesome/js/all.min.js" data-auto-replace-svg="nest"></script>

<!-- Intégration de JS Snackbar -->
<link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/js-snackbar/css/js-snackbar.css?v=2.0.0" />
<script src="<?=getWebsiteSetting("websiteUrl")?>pages/assets/vendors/js-snackbar/js/js-snackbar.js?v=1.2.0"></script>

<!-- Styles -->
<link rel="stylesheet" href="<?=getWebsiteSetting("websiteUrl")?>pages/assets/css/styles.css">