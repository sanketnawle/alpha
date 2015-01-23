$(document).ready(function() {
	 var d = new Date()
	 var user_tz_offset = d.getTimezoneOffset();
	 $.ajax({
	           	type: "POST",
     			url: "../kk/newinfi/includes/fbarops.php",
            	data: {user_tz_offset:user_tz_offset},
            	success: function(html){ 

			}
		});
});