<script type="text/javascript">
			var images = new Array()
			function preload() {
				for (i = 0; i < preload.arguments.length; i++) {
					images[i] = new Image();
					images[i].src = preload.arguments[i];
				}
			}
			preload(
				"img/waiting_animation_beadtype.gif",
				"img/waiting_animation_circletype.GIF"
			)
</script>