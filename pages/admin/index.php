<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title><?=getWebsiteSetting("websiteName")?> | Administration</title>
	<?=Admin::getDependencies()?>
</head>
<body>
	<?=Admin::getNavbar()?>

	<!-- Contenu -->
	<div class="dashboardTopCard" leftSidebar="240" rightSidebar="0">
		<div class="d-flex">
			<div class="userLogo" style="background-image: url('<?=$_SESSION['userProfilePic']?>');"></div>
			<div class="ml-5">
				<h3>Bienvenue <?=$_SESSION["userName"]?>!</h3>
				<strong>Je tiens à préciser que cette partie du site a été réalisée à "l'arrache" de manière totalement déloyale. :)</strong></p>
			</div>
		</div>
	</div>
	<div class="page-content notTop" leftSidebar="240" rightSidebar="0">
		<h3>Tableau de bord</h3>
		<p>Bienvenu sur le paneau d’administration. Voici un bref résumé de l'activité de cette semaine.</p>
		<p>Cette page d'acceuil est décidément condamnée à rester vide. On a clairement pas le temps de la développer. 
		<br><code><pre><?php print_r($_SESSION); ?></pre></code></p>

		
		
	</div>
</body>
</html>