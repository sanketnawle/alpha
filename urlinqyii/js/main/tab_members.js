$(document).ready(function(){



    $('.people_search_input').keyup(function(){

        var $people_search_input = $(this);
        var search_string = $people_search_input.val();



        search_string = search_string.toLowerCase();



        if(search_string !== ''){
            $people_search_input.closest(".tab_content_holder").find(".members_tab_content").children('div').each(function () {
                var $item = $(this);
                $item.show();
                if($item.data('user_name').toLowerCase().indexOf(search_string) == -1){
                    $item.hide();
                }
            });
        }else{
            $people_search_input.closest(".tab_content_holder").find(".members_tab_content").children('div').each(function () {
                var $item = $(this);
                $item.show();
            });
        }

    });




});
