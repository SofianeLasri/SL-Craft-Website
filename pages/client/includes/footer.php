<!-- Footer -->
<footer class="container-fluid">
    <div class="container">

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
</script>