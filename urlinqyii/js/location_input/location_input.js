       //var location_data_strings = JSON.stringify(json_data);

$(document).ready(function(){
    $(document).on('keyup','.location_input',function() {
        var $location_input = $(this);
        $location_input.removeClass("valid_location_entered");
        var $locations_list = $(".location_matches_list");
        var location_matches = [];
        var location_input_string = $location_input.val().toLowerCase();
        if(location_input_string.length >= 2){
            $location_input.removeClass('gray_bg');
            $location_input.addClass("dropdown_box_active");
            $locations_list.addClass('active');
            $.getJSON(base_url + "/js/partial/status_bar/NYU_locations.json", function(data){

                $.each(data['buildings'],function(key, building_data){
                    // console.log(building_data);
                    if(building_data['-jcr:title'].toLowerCase().indexOf(location_input_string) > -1){
                        location_matches.push(building_data['-jcr:title']);
                    }


                });


            
                if(!location_matches.length){
                    $locations_list.empty();
                    $locations_list.removeClass('active');
                    $location_input.removeClass("dropdown_box_active");
                    return;

                }
                
                $locations_list.empty();
                for(i = 0; i < location_matches.length; i++){
                    var html_object = $('<div class="location_match_list_item">' + location_matches[i] + '</div>');
                    $locations_list.append(html_object);
                    
                }


            }); 


        }else{
            $locations_list.removeClass('active');
            $location_input.removeClass("dropdown_box_active");
        }
    });


    $(document).on('click','.location_match_list_item',function(){
        var $location_input = $(".location_input");
        var $locations_list = $(".location_matches_list");
        var selected_location_text = $(this).text();
        $location_input.val(selected_location_text);
        $locations_list.removeClass('active');
        $location_input.removeClass("dropdown_box_active");
        $location_input.addClass("valid_location_entered");
    });



    jQuery(document).on("click", function() {
        var $location_input = $(".location_input");
        var $locations_list = $(".location_matches_list");
        $locations_list.removeClass('active');
        $location_input.removeClass("dropdown_box_active");
    });



});