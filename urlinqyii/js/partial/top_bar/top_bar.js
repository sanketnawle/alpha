$(document).ready(function(){






    $(document).on('click', '.notify.board', function(){
        var $notification_button = $(this);

        var $notify = $('#notifications');



        if($notify.is(":visible")){
            $notify.hide();
        }else{
            $notify.show();
        }

    });














});