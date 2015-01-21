$(document).ready(function(){
    $(document).delegate(".menu_hider.menu_shown", "click", function() {
        $(this).removeClass("menu_shown");
        $(this).addClass("menu_hidden");
         $("body").addClass("left_panel_hidden").delay(175).queue(function(next){
            $("body").addClass("left_panel_hidden_p2");
            next();
        });
    });

    $(document).delegate(".menu_hider.menu_hidden", "click", function() {
        $(this).removeClass("menu_hidden");
        $(this).addClass("menu_shown");
         $("body").removeClass("left_panel_hidden_p2").delay(100).queue(function(next){
            $("body").removeClass("left_panel_hidden");
            next();
        });
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
        var $search_bar = $(this);

        var search_input = $search_bar.val();

        if(search_input == ''){
            clear_search_results();
            hide_search_results();
        }else{
            $('.prelist').show();
        }
    });


    $(document).on('keydown', '#top_search_bar', function(event){
        event.stopPropagation();
        var key = event.which;
            switch(key) {
              case 37:
                  alert('LFET');
                  break;
              case 38:
                  alert('UP');
                  break;
              case 39:

                  alert('RIGHT');
                  // Key right.
                  break;
              case 40:

                  $('.search_result').first().hover();

                  alert('down');
                  // Key down.
                  break;
        }
  });


    $(document).on('keyup', '#top_search_bar', function(){
        var $search_bar = $(this);
        var search_input = $search_bar.val();

        if(search_input.length >= 1){
            //clear_search_results();
            update_search_results(search_input);
        }else{
            clear_search_results();
            hide_search_results();
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


    function update_search_results(search_input){

        $.getJSON(globals.base_url + '/search/quickSearch?q=' + search_input, function(json_data){
            clear_search_results();
            if(json_data['success']){
                if(json_data['results'].length == 0){
                    clear_search_results();
                    hide_search_results();
                }else{
                    $.each(json_data['results'], function(index, result_json){
                        console.log(result_json);
                        show_search_result(result_json);
                    });
                }
            }else{

            }
        });
    }

    function show_search_result(result_json){
        var source = $('#search_result_template').html();
        var template = Handlebars.compile(source);
        var generated_html = template(result_json);
        $('.prelist').append(generated_html).hide().fadeIn(100);
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
    });

});