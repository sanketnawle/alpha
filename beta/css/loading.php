<!DOCTYPE html>
<html>
<head>
<link rel = "stylesheet" type = "text/css" href = "css/loading.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/jblockUI.js"></script>
</head>
<body>
<div class="loading_container">
<div class="loading-spinner"></div>
<div class="loading_text">LOADING <?php echo $text; ?></div>
</div>
</body>
<script>
var jq = jQuery;
jq.blockUI({message : null, overlayCSS:  { backgroundColor: '#FFFFFF',opacity:0.0,cursor: 'default'}});
$(document).ready(function(){	$(".loading_animation").parent().addClass("loadani_parent");	$(document).on("content_loaded",function(){			jq.unblockUI();		setTimeout(function(){			$(".loading_animation").hide();			$(".loadani_parent").addClass("make_opaque");			setTimeout(function(){				$(".loadani_parent").removeClass("make_opaque");				$('link[rel=stylesheet][href~="css/loading.css"]').remove();			},300);		}, 200);	});
});
</script>
</html>

