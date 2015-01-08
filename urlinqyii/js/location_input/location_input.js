       //var location_data_strings = JSON.stringify(json_data);

$(document).ready(function(){

    $(document).on('keyup','.location_input',function() { 
        var $location_input = $(this);
        var location_matches = [];
        var location_input_string = $location_input.val().toLowerCase();
        if(location_input_string.length >= 2){
            
            $.getJSON(base_url + "/js/partial/status_bar/NYU_locations.json", function(data){


                $.each(data['buildings'],function(key, building_data){
                    // console.log(building_data);
                    if(building_data['-jcr:title'].toLowerCase().indexOf(location_input_string) > -1){
                        location_matches.push(building_data['-jcr:title']);
                    }


                });


                //alert(JSON.stringify(location_matches));

            });        
        }
    });
});