$(document).ready(function() {
	 var d = new Date()
	 var user_tz_offset = d.getTimezoneOffset()*(-1);
	 
	 $.ajax({
	           	type: "POST",
     			url: "includes/time.php",
            	data: {user_tz_offset:user_tz_offset},
            	success: function(html){ 
            		//alert(html);
			}
		});
});