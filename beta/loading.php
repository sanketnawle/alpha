<!DOCTYPE html>
<html>
<head>
<link rel = "stylesheet" type = "text/css" href = "css/loading.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="js/jblockUI.js"></script>
</head>
<body>
<div class="loading_container"><div class="loading_spinner_cover">
<div class="loading-spinner"></div></div><div class="loading_text_cover">
<div class="loading_text">LOADING <?php echo $text; ?></div></div>
</div>
</body>
<script>
var jq = jQuery;
$(document).ready(function(){	jq('.loadani_parent').block({message : null, overlayCSS:  { backgroundColor: '#FFFFFF',opacity:0.0,cursor: 'default'}});	$(document).on("content_loaded",function(){			jq('.loadani_parent').unblock();		setTimeout(function(){			$(".loading_animation").hide();			$(".loadani_parent").addClass("make_opaque");			setTimeout(function(){				$(".loadani_parent > *").css("opacity",1);				$(".loadani_parent").removeClass("make_opaque");								$(".loading_animation").parent().removeClass("loadani_parent");				$('link[rel=stylesheet][href~="css/loading.css"]').remove();			},300);		}, 200);	});
});
</script>
</html>

