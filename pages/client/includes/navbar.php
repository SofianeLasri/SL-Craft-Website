<?php
// On est pas censé avoir de code dans les vues, mais est-ce réellement une vue? :D
if(isset($_SESSION['userId'])){
    // On va afficher une petite barre de navigation supplémentaire ?>
<div class="container-fluid memberNavbar">
    <div class="d-flex align-items-center flex-grow-1">
        <div class="userProfilPic" style="background-image:url('<?=$_SESSION["userProfilePic"]?>');"></div>
        <span class="mx-2">Bonjour <strong><?=$_SESSION["userName"]?></strong></span>
        <?php if(verifyUserPermission($_SESSION['userId'], "adminPanel.access"))
        echo ('<a href="'.genPageLink("/admin/").'" class="text-light mx-2"><i class="fas fa-toolbox"></i> Administration</a>'); ?>
        <a href="<?=genPageLink("/ecrireRecette/")?>" class="text-light mx-2"><i class="fas fa-pencil-alt"></i> Écrire une recette</a>
    </div>
    <div>
        <a href="<?=genPageLink("/lesRecettes")?>" class="text-light">Se déconnecter</a>
    </div>
</div>

<?php }

if(!isset($_COOKIE["topBarInfos"]) || $_COOKIE["topBarInfos"] == "true"){
?>
<!-- Barre du dessus pour les infos peu ou pas importantes -->
<div id="topBarInfos" class="container-fluid mainColor-bg">
    <div class="container text-center py-2">
        <span class="badge badge-pill badge-danger">Spécial Noël</span> <span>Une sélection de recettes très spéciales pour les fêtes de Noël.</span> <a href="#" class="btn btn-outline-light btn-sm rounded-pill">Découvrir</a> <a href="#" onclick="closeTopBarInfos()" class="text-light"><i class="fas fa-times"></i></a>
    </div>
</div>
<!-- Fin -->
<?php } ?>
<!-- J'ai un peu honte de cette navbar car c'est ni plus, ni moins, qu'un C/C de la doc de Bootstrap, mais bon le prof n'y verra que du feu x) -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="<?=getWebsiteSetting("websiteUrl")?>">
            <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/logo/large.svg" width="131" height="30" class="d-inline-block align-top" alt="" loading="<?=getWebsiteSetting("websiteName")?>">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?=getWebsiteSetting("websiteUrl")?>">Accueil</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Recettes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">                    
                        <a class="dropdown-item" href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/recettes/")?>">Toutes les recettes</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/recettes/")?>?categoryId=1">Appéritifs</a>
                        <a class="dropdown-item" href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/recettes/")?>?categoryId=2">Entrées</a>
                        <a class="dropdown-item" href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/recettes/")?>?categoryId=3">Plats</a>
                        <a class="dropdown-item" href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/recettes/")?>?categoryId=4">Desserts</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?=genPageLink("/recettes/")?>?categoryId=5">Pâtisserie</a>
                        <a class="dropdown-item" href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/recettes/")?>?categoryId=7">Boissons</a>
                        <a class="dropdown-item" href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/recettes/")?>?categoryId=6">Petit-dej/Brunch</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Idées recettes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Communauté</a>
                </li>
            </ul>
            <form action="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("/recettes")?>" method="get" id="search" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2 rounded-pill" type="search" name="name" placeholder="Blanquette au saumon">
                <button type='submit' class='btn btn-orange rounded-pill' ><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
</nav>
  