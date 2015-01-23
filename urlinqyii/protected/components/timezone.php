
<script type="application/javascript">


    var session_timezone = '<?php echo Yii::app()->session['timezone']; ?>';
    console.log(session_timezone);
    if(session_timezone.length == 0){
        var visitortime = new Date();
        var visitortimezone = "GMT " + -visitortime.getTimezoneOffset()/60;
        console.log(visitortimezone);
        $.ajax({
            type: "GET",
            url: base_url + "/timezone",
            data: 'timezone='+ visitortimezone,
            success: function(){
                location.reload();
                timezone = visitortimezone;
                console.log(timezone);
            }
        });
    }
    timezone = '<?php echo Yii::app()->session['timezone']; ?>';

    console.log('TIMEZONE');
    console.log(timezone);
</script>
