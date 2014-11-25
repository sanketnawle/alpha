
$(document).ready(function() {
    if("<?php echo $timezone; ?>".length==0){
        var visitortime = new Date();
        var visitortimezone = "GMT " + -visitortime.getTimezoneOffset()/60;
        $.ajax({
            type: "GET",
            url: "http://domain.com/timezone.php",
            data: 'timezone='+ visitortimezone,
            success: function(){
                location.reload();
            }
        });
    }
});
