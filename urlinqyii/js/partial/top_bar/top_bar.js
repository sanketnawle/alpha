$(document).ready(function(){



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
                $.each(json_data['results'], function(index, result_json){
                    console.log(result_json);
                    show_search_result(result_json);
                });
            }else{

            }
        });
    }

    function show_search_result(result_json){
        var source = $('#search_result_template').html();
        var template = Handlebars.compile(source);
        var generated_html = template(result_json);
        $('.prelist').append(generated_html).hide().fadeIn();
    }


    $(document).on('click', '#top_search_bar', function(e){
        e.stopPropagation();

    });


    $(document).on('click', '.search_result', function(e){
        e.stopPropagation();

    });






    $(document).on('click', '.search_result', function(e){
        e.stopPropagation();
        e.preventDefault();
        alert('click happened');



    });


    $(document).on('click', function(){
        $('.prelist').hide();
    });

});