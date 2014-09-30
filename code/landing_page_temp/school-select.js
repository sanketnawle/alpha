$(document).ready(function() {
	$(document).delegate('.school',"click", function(){
		$(this).find(".option-checkwrap").css({"background-image":"url(src/checked-invite.png)","opacity":"1"});
	});
});