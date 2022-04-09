<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title><?=getWebsiteSetting("websiteName")?> | Paramètres</title>
	<?=Admin::getDependencies()?>
</head>
<body>
	<?=Admin::getNavbar()?>

	<!-- Contenu -->
	<div leftSidebar="240" rightSidebar="0" class="page-content">
		<h3>Paramètres</h4>
        <p>J'avais la flemme de faire un truc propre, alors je sort les données de la BDD en brute. :)</p>

        <form id="settingsForm" class="width-50em">
            <?php
                $settings = BddConn::getPdo()->query("SELECT * FROM m_siteSetting")->fetchAll(PDO::FETCH_ASSOC);
                foreach($settings as $setting){
                    echo ('<div class="form-group">
                        <label>'.$setting["name"].'</label>
                        <input type="text" class="form-control" name="'.$setting["name"].'" value="'.$setting["value"].'">
                    </div>');
                }
            ?>
            <button type="button" class="btn btn-orange" onclick="saveChanges()">Sauvegarder</button>
        </form>
	</div>
<script type="text/javascript">
function saveChanges(){
    $.post( "<?=genPageLink("/admin/backTasks/")?>?saveSettings", $( "#settingsForm" ).serialize() )
    .done(function( data ) {
        if(data!=""){
            SnackBar({
                message: data,
                status: "danger",
                timeout: false
            });
        } else {
            SnackBar({
                message: 'Sauvegarde réussie',
                status: "success"
            });
        }
    });
}
</script>
</body>
</html>