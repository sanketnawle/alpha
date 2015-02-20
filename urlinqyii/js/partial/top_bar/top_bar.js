$ = jQuery;
$(document).ready(function(){
    $(document).delegate(".menu_hider.menu_shown", "click", function(e) {

        e.stopPropagation();
        $(this).removeClass("menu_shown");
        $(this).addClass("menu_hidden");
         $("body").addClass("left_panel_hidden").delay(100).queue(function(next){
            $("body").addClass("left_panel_hidden_p2");
            next();
        });
        var group_name_left = $("p#group_name").position().left;
        $("div.center_admin").css({"left":group_name_left});
        $("div.nav_section div.nav_text").css({"max-width":"258px"});
    });

    $(document).delegate(".menu_hider.menu_hidden", "click", function(e) {

        e.stopPropagation();
        $(this).removeClass("menu_hidden");
        $(this).addClass("menu_shown");
         $("body").removeClass("left_panel_hidden_p2").delay(50).queue(function(next){
            $("body").removeClass("left_panel_hidden");
            next();
        });  
        var group_name_left = $("p#group_name").position().left;
        $("div.center_admin").css({"left":group_name_left});

        $("div.nav_section div.nav_text").css({"max-width":"208px"});
    });

    $("#page").scroll(function() {
	        var y=$(this).scrollTop()*0.0045;
	        var opacityShift = y*1;
	        //alert(y);
	        $("div.menu_hider").css({"opacity":1-opacityShift});
	        if($(this).scrollTop() >= 290){
	        	$("div.menu_hider").css({"pointer-events":"none"});
	        }
	        else{
	        	$("div.menu_hider").css({"pointer-events":"auto"});
	        }
    }); 

    $(document).on('focus', '#top_search_bar', function(){
        $(".top_search_bar_form").css({"background-color":"#fff"});
        $(this).css({"color":"#222"});
        var $search_bar = $(this);

        var search_input = $search_bar.val();

        if(search_input == ''){
            clear_search_results();
            hide_search_results();
        }else{
            $('.prelist').show();
            $(".topbar .center form").css({"border-radius":"4px 4px 0px 0px"});
        }
    });


    $(document).on('keydown', '#top_search_bar', function(event){
        event.stopPropagation();
        var key = event.which;
            switch(key) {
              case 37:
                  break;
              case 38:
                  break;
              case 39:

                  // Key right.
                  break;
              case 40:

                  $('.search_result').first().hover();

                  // Key down.
                  break;
        }
  });

    var last_input = '';
    var previous_results = [];

    $(document).on('keyup', '#top_search_bar', function(){
        var $search_bar = $(this);
        var search_input = $search_bar.val();

        if(search_input.length >= 1){
            //clear_search_results();

            last_input = search_input;



            setTimeout(update_search_results, 600);

            function update_search_results(){

                if(last_input == search_input){
                    last_input = '';
                    $.getJSON(globals.base_url + '/search/quickSearch?q=' + search_input, function(json_data){
                        //clear_search_results();
                        if(json_data['success']){
                            if(json_data['results'].length == 0){
                                clear_search_results();
                                hide_search_results();
                                $(".topbar .center form").css({"border-radius":"4px"});
                            }else{
                                show_search_results();
//                                var different_results = json_data['results'];
//
//                                for(var i = 0; i < json_data.length; i++){
//
//                                }


                                //GO thru the current list and replace items that are the same
                                $('.search_result').each(function(index){
                                    var $search_result = $(this);

                                    var remove = true;


                                    $.each(json_data['results'], function(index, result_json){

                                        try{

                                            if($search_result.attr('data-origin_type') == result_json['origin_type'] && $search_result.attr('data-origin_id') == result_json['origin_id']){
                                                //alert("ALRDY THERE. " + JSON.stringiy(result_json));
                                                remove = false;
                                                console.log(JSON.stringify(json_data[index]) + ' already exists in the seach results. Removing from json_data["results"]');
                                                console.log('list b4 slice');
                                                console.log(JSON.stringify(json_data['results']));
                                                json_data['results'].splice(index, 1);

                                                console.log('list after slice');
                                                console.log(JSON.stringify(json_data['results']));
                                                return false;
                                            }

                                        }catch(err){
                                            console.log(err);
                                            //alert('ERROR ' + JSON.stringify(result_json));
                                        }

                                    });

                                    if(remove){
                                        $search_result.remove();
                                        console.log('REmoving search result that is not in new json_data');
                                    }
                                });


                                //Go thru the rest of the nonspliced array
                                $.each(json_data['results'], function(index, result_json){
                                    show_search_result(result_json);
                                });




//
//                                //Delete the old ones
//                                //Delete the old search result with this index
//                                $(".search_result.old").each(function(index){
//                                    var $old_search_result = $(this);
//                                    //$old_search_result.remove();
//
//
//                                    var remove = true;
//
//
//                                    $.each(json_data['results'], function(index, result_json){
//
//                                        //REmove this search result if its different from the previous one
//                                        if($old_search_result.attr('data-origin_type') == result_json['origin_type'] || $old_search_result.attr('data-origin_id') != result_json['origin_id']){
//                                            $old_search_result.remove();
//                                        }
//
//                                    });
//
//
//                                    if(remove){
//                                        $old_search_result.remove();
//                                    }
//                                });



                                $(".topbar .center form").css({"border-radius":"4px 4px 0px 0px"});
                            }

                            previous_results = json_data['results'];
                        }else{

                        }
                    });
                }
            }

        }else{
            clear_search_results();
            hide_search_results();
            $(".topbar .center form").css({"border-radius":"4px"});
        }



    });


    function clear_search_results(){
        var $list = $('.prelist');
        $list.empty();
    }

    function hide_search_results(){
        var $list = $('.prelist');
        $list.hide();
    }


    function show_search_results(){
        var $list = $('.prelist');
        $list.show();
    }




    function show_search_result(result_json){
        var source = $('#search_result_template').html();
        var template = Handlebars.compile(source);
        var generated_html = template(result_json);
        $('.prelist').append($(generated_html).hide().fadeIn(50));
        
        var $search_result_element = $(".search_result");
        $(".topbar .center form").css({"border-radius":"4px 4px 0px 0px"});
        $search_result_element.each(function () {
            var search_result_element_type = $(this).attr("data-origin_type");
            var $search_result_icon = $(this).find(".search_result_icon.non_profile_icon");
            var search_result_element_type = $(this).attr("data-origin_type");
            if(search_result_element_type == 'class'){
                $search_result_icon.addClass('class');
            }
            if(search_result_element_type == 'course'){
                $search_result_icon.addClass('course');
            }            
            if(search_result_element_type == 'school'){
                $search_result_icon.addClass('school');

            }
            if(search_result_element_type == 'department'){
                $search_result_icon.addClass('department');

            }
            if(search_result_element_type == 'club'){
                $search_result_icon.addClass('club');

            }
        });
    }


    $(document).on('click', '#top_search_bar', function(e){
        e.stopPropagation();

    });


//    $(document).on('click', '.search_result', function(e){
//        e.stopPropagation();
//
//    });






    $(document).on('click', '.search_result', function(e){
//        e.stopPropagation();
//        e.preventDefault();
//        alert('click happened');



    });


    $(document).on('click', function(){
        $('.prelist').hide();
        $("#top_search_bar").css({"color":"#999"});
        $(".topbar .center form").css({"border-radius":"4px"});
        $(".top_search_bar_form").css({"background-color":"rgba(0, 0, 0, 0.15)"});
    });

});