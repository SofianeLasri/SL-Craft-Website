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
                    <li id="joinServerIcon">
                        <a href="#" class="nav-link">
                            <i class="nav-icon">
                                <img src="<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-buy.png" alt="Join icon">
                            </i>
                            Nous rejoindre
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    const joinServerIcon = document.getElementById('joinServerIcon');

    joinServerIcon.addEventListener('mouseenter', e => {
        animatedIcon("joinServerIcon", "enter");
    });

    joinServerIcon.addEventListener('mouseleave', e => {
        animatedIcon("joinServerIcon", "leave");
    });

    function animatedIcon(id, action){
        console.log($("#"+id).find("img").html());
        if(action == 'enter'){
            $("#"+id).find("img").attr("src", "<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-buy.gif");
        }else{
            $("#"+id).find("img").attr("src", "<?=getWebsiteSetting("websiteUrl")?>data/images/navbar/menu-buy--reversed.gif");
        }
    }
</script>