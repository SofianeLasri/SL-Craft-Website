<!-- Navbar -->
<div id="navbar" class="barreDeNavigation">
    <div class="superieure">
        <nav class="container d-flex justify-content-end">
            <a class="nav-link" href="#">Associer son compte</a>
            <a class="nav-link" href="#">Se connecter</a>
        </nav>
    </div>
    <div class="inferieure" style="background-image: url('<?=getWebsiteSetting("websiteUrl")?>data/images/backgrounds/bg-wood-dark.png');">
        <div class="container d-flex align-items-center h-100">
            <div>
                <a href="<?=getWebsiteSetting("websiteUrl")?>" class="siteName">SL-Craft</a>
            </div>
            <div class="flex-grow-1">
                <ul class="menuList float-right">
                    <li id="menu-buy" onmouseenter="animatedIcon(this, 'enter')" onmouseleave="animatedIcon(this, 'leave')">
                        <a href="https://live.mc.sl-projects.com/" class="nav-link" target="_blank">
                            <i class="nav-icon">
                                <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-buy.png" alt="Join icon">
                            </i>
                            Carte du monde
                        </a>
                    </li>
                    <li id="menu-comm" onmouseenter="animatedIcon(this, 'enter')" onmouseleave="animatedIcon(this, 'leave')">
                        <a href="https://discord.gg/9PYvGFDmDt" class="nav-link" target="_blank">
                            <i class="nav-icon">
                                <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-comm.svg" alt="Community icon">
                            </i>
                            Communauté
                        </a>
                    </li>
                    <li id="menu-store" onmouseenter="animatedIcon(this, 'enter')" onmouseleave="animatedIcon(this, 'leave')">
                        <a href="<?=getWebsiteSetting("websiteUrl")?>shops" class="nav-link">
                            <i class="nav-icon">
                                <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-store.svg" alt="Community icon">
                            </i>
                            Liste des magasins
                        </a>
                    </li>
                    <li id="menu-support" onmouseenter="animatedIcon(this, 'enter')" onmouseleave="animatedIcon(this, 'leave')">
                        <a href="<?=getWebsiteSetting("websiteUrl")?>staff" class="nav-link">
                            <i class="nav-icon">
                                <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-support.svg" alt="Staff icon">
                            </i>
                            Obtenir de l'aide
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function animatedIcon(object, action){
        if(action == 'enter'){
            $("#"+object.id).find("img").attr("src", "<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/"+object.id+".gif");
        }else{
            $("#"+object.id).find("img").attr("src", "<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/"+object.id+"--reversed.gif");
        }
    }
</script>