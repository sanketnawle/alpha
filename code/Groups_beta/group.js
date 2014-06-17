$(document).ready(function() {
	alert();
	$(document).delegate(".joined","mouseover",function(){
			$(this).text("Leave Class");
			alert();
	});

	$(document).delegate(".joined","mouseout",function(){
			$(this).text("Enrolled");
	});
});