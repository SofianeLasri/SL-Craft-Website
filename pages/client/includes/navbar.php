<!-- Navbar -->
<div class="barreDeNavigation">
    <div class="superieure">
        <nav class="container d-flex justify-content-end">
            <a class="nav-link" href="#">Associer son compte</a>
            <a class="nav-link" href="#">Se connecter</a>
        </nav>
    </div>
    <div class="inferieure" style="background-image: url('<?=getWebsiteSetting("websiteUrl")?>data/images/backgrounds/bg-wood-dark.png');">
        <div class="container d-flex align-items-center h-100">
            <div class="flex-grow-1">
                <a href="<?=getWebsiteSetting("websiteUrl")?>" class="siteName">SL-Craft</a>
            </div>
            <div>
                <ul class="menuList">
                    <li id="menu-buy">
                        <a href="#" class="nav-link" onmouseover="animatedIcon(this, 'enter')" onmouseout="animatedIcon(this, 'leave')">
                            <i class="nav-icon">
                                <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-buy.png" alt="Join icon">
                            </i>
                            Carte du monde
                        </a>
                    </li>
                    <li id="menu-comm">
                        <a href="#" class="nav-link" onmouseover="animatedIcon(this, 'enter')" onmouseout="animatedIcon(this, 'leave')">
                            <i class="nav-icon">
                                <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-comm.svg" alt="Community icon">
                            </i>
                            Communauté
                        </a>
                    </li>
                    <li id="menu-store">
                        <a href="#" class="nav-link" onmouseover="animatedIcon(this, 'enter')" onmouseout="animatedIcon(this, 'leave')">
                            <i class="nav-icon">
                                <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-store.svg" alt="Community icon">
                            </i>
                            Liste des magasins
                        </a>
                    </li>
                    <li id="menu-support">
                        <a href="#" class="nav-link" onmouseover="animatedIcon(this, 'enter')" onmouseout="animatedIcon(this, 'leave')">
                            <i class="nav-icon">
                                <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-support.svg" alt="Staff icon">
                            </i>
                            Staff
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    const joinServerIcon = document.getElementById('joinServerIcon');

    function animatedIcon(object, action){
        console.log($("#"+id).find("img").html());
        if(action == 'enter'){
            $("#"+object.id).find("img").attr("src", "<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/"+object.id+".gif");
        }else{
            $("#"+object.id).find("img").attr("src", "<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/"+object.id+"--reversed.gif");
        }
    }
</script>