jQuery(document).ready(function(){



    var $last_clicked_element = null;
    jQuery(document).on('click', '.invite_user_list_item_remove_button', function(){
        var $remove_button = jQuery(this);
        $last_clicked_element = $remove_button;
        //Remove this user from list
        $remove_button.parent().remove();
    });

    jQuery(document).on('click','.invite_people_button', function(e){

        e.stopPropagation();
        var $invite_button = jQuery(this);

        $last_clicked_element = $invite_button;


        var $invite_holder = $invite_button.closest('.invite_holder');

        var $invite_input = $invite_holder.find('.invite_input');

        var input_string = $invite_input.val();





        var name = $invite_input.attr('data-name');
        var email = $invite_input.attr('data-email');
        var id = $invite_input.attr('data-id');


        if(id == '' || name == '' || email == ''){

            var $invite_popup = $invite_holder.find('#invite_popup');
            $invite_popup.removeClass('active');

            $invite_input.addClass('error');

        }


        var $invite_list = $invite_holder.find('#invite_list');

        if(!jQuery('.invite_user_list_item[data-id="' + id + '"]').length){
            var user_json = {};
            user_json['user_name'] = name;
            user_json['user_email'] = email;
            user_json['id'] = id;


            var source = jQuery('#user_template').html();
            var template = Handlebars.compile(source);
            var generated_html = template(user_json);

            $invite_list.append(jQuery(generated_html));



            $invite_input.attr('data-name','');
            $invite_input.attr('data-email','');
            $invite_input.attr('data-id','');


            $invite_input.val('');
        }





    });





    function show_user_invite(user_json){

        //Insert the users
        var source = jQuery('#invite_user_template').html();
        var template = Handlebars.compile(source);

        user_json['user_name'] = user_json['firstname'] + " " + user_json['lastname'];


        var generated_html = template(user_json);

        jQuery('#invite_popup').append(jQuery(generated_html));
    }


    jQuery(document).on('keyup','.invite_input',function(){
        var $invite_input = jQuery(this);


        $invite_input.attr('data-id','');
        $invite_input.attr('data-name','');
        $invite_input.attr('data-email','');


        var $invite_popup = $invite_input.closest('.invite_holder').find('#invite_popup');

        var input_string = $invite_input.val();


        if(input_string.length > 0){


            $.getJSON(base_url + '/api/searchUsers?input_string=' + input_string, function(json_data){

                if(json_data['users'].length > 0){
                    //Get the position of this input
                    var input_position = $invite_input.offset();

                    //Set the position of the time selector to underneath this time input
                    $invite_popup.css({'position': 'absolute'});
                    $invite_popup.css({'top': (input_position.top - $invite_input.height()).toString() + 'px'});
//                    $invite_popup.css({'left': input_position.left.toString() + 'px'});
                    $invite_popup.css({'z-index': '1000'});

                    jQuery('#invite_popup').empty();



                    $.each(json_data['users'],function(index, user_json){
                        user_json['id'] = user_json['user_id'];
                        show_user_invite(user_json);
                    });


                    //Set the time_selector to active
                    $invite_popup.addClass('active');
                }else{
                    //remove the active class
                    $invite_popup.removeClass('active');
                }
            });



        }else {
            //remove the active class
            $invite_popup.removeClass('active');
            //remove error from the input

            $invite_input.removeClass('error');
        }





    });


    jQuery(document).on('click', '.invite_user_holder', function(e){
        e.stopPropagation();

        var $invite_user_holder = jQuery(this);
        $last_clicked_element = $invite_user_holder;


        var user_id = $invite_user_holder.attr('data-id');
        var user_name = $invite_user_holder.attr('data-name');
        var user_email = $invite_user_holder.attr('data-email');

        var $invite_input = $invite_user_holder.closest('.invite_holder').find('.invite_input');

        //We know forsure that this is valid user data
        $invite_input.removeClass('error');

        //Set the data attributes for the invite_input
        $invite_input.attr('data-id', user_id);
        $invite_input.attr('data-name', user_name);
        $invite_input.attr('data-email', user_email);

        $invite_input.val(user_name + ' <' + user_email + '>');

        var $invite_popup = jQuery('#invite_popup');
        $invite_popup.removeClass('active');
        $invite_popup.empty();








    });

    jQuery(document).on('click',function(){
        verify_invite_input(jQuery(this));

    });

    jQuery(document).on('focusout','.invite_input', function(e){
        verify_invite_input(jQuery(this));
    });



    function verify_invite_input($invite_input){
        jQuery('#invite_popup').removeClass('active');

        var name = $invite_input.attr('data-name');
        var email = $invite_input.attr('data-email');
        var id = $invite_input.attr('data-id');



        if($invite_input.val() == ''){
            $invite_input.removeClass('error');
            return;
        }

        if(id == '' || name == '' || email == ''){
            $invite_input.addClass('error');
        }else{
            $invite_input.removeClass('error');
        }


    }

    jQuery(document).on('focusout','.invite_list', function(e){
        e.stopPropogation();
    });



//    jQuery(document).on('click','.invite_input', function(){
//        verify_invite_input(jQuery(this));
//    });



});