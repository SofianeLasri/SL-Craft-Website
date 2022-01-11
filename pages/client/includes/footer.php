<!-- Footer -->
<footer class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="block-titres orange">
                    <h3><strong>À propos de nous</strong></h3>
                </div>
                <div>
                    <p>Le site Marmiuton a été créé par <a href="https://sl-projects.com" target="_blank">Sofiane Lasri</a><a href="mailto:sofiane.lasri-trienpont@universite-paris-saclay.fr"><i class="fas fa-envelope"></i></a>  et <a href="mailto:yann.jeanmaire-dit-cartier@universite-paris-saclay.fr">Yann Jeanmire-dit-Cartier</a>, dans le cadre d'un projet tutoré organisé par <a href="https://www.iut-orsay.universite-paris-saclay.fr/" target="_blank">L'IUT d'Orsay</a>.</p>
                </div>
            </div>
            <div class="col">
                <div class="block-titres orange">
                    <h3><strong>Liens utiles</strong></h3>
                </div>
                <div>
                    <ul>
                        <li><a href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("login")?>">Connexion espace membre</a></li>
                        <li><a href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("recettes")?>">Recettes</a></li>
                        <li><a href="<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("login")?>">Connexion espace membre</a></li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="block-titres orange">
                    <h3><strong>Dernières recettes</strong></h3>
                </div>
                <div>
                    <p>Plus-tard, trop la flemme là.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript">
	// Permet de correctement placer la barre de naviguation
	reportWindowSize();
	function reportWindowSize() {
		if (document.body.clientHeight<window.innerHeight) {
			$("footer").css("position", "fixed");
		} else {
			$("footer").css("position", "relative");
		}
	}
	window.onresize = reportWindowSize;

    function closeTopBarInfos(){
        $.get("<?=getWebsiteSetting("websiteUrl")?><?=genPageLink("backTasks")?>?closeTopBarInfos", function(data) {
            if (data!="") {
                SnackBar({
                    message: data,
                    status: "danger",
                    timeout: false
                });
            }else{
                $("#topBarInfos").hide();
            }
        });
    }
</script>