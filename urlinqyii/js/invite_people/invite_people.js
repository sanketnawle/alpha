jQuery(document).ready(function(){



    var $last_clicked_element = null;
    jQuery(document).on('click', '.invite_user_list_item_remove_button', function(e){
        e.stopPropagation();

        var $remove_button = jQuery(this);
        $last_clicked_element = $remove_button;
        //Remove this user from list
        $remove_button.parent().remove();
    });




    var invite_from_list = true;

    if(globals.origin_type){
        if(globals.origin_type == 'club' || globals.origin_type == 'group' || globals.origin_type == 'class'){
            invite_from_list = false;
        }
    }



    jQuery(document).on('click','.invite_people_button', function(e){



        e.stopPropagation();
        var $invite_button = jQuery(this);

        $last_clicked_element = $invite_button;


        var $invite_holder = $invite_button.closest('.invite_holder');

        var $invite_input = $invite_holder.find('.invite_input');

        var input_string = $invite_input.val();





        var name = $invite_input.attr('data-name') ? $invite_input.attr('data-name') : '';
        var email = $invite_input.attr('data-email') ? $invite_input.attr('data-email') : '';
        var id = $invite_input.attr('data-id') ? $invite_input.attr('data-id') : '';
        var file_url = $invite_input.attr('data-file_url') ? $invite_input.attr('data-file_url') : '';



        if(id == '' || name == '' || email == ''){

            var $invite_popup = $invite_holder.find('#invite_popup');
            $invite_popup.removeClass('active');

            //Check if this email is valid email
            if(input_string.indexOf('@nyu.edu') > -1){

                //alert('SENDING EMAIL INVITE TO THIS FOOL');

                var post_url = globals.base_url + '/sendUrlinqInviteEmail';


                var post_data = {email: input_string, origin_type: globals.origin_type, origin_id: globals.origin_id};


                $.post(
                    post_url,
                    post_data,
                    function(response){
                        if(response['success']){

                            alert('Urlinq invite sent!');

                            //Clear the text input field
                            $invite_input.val('');
                            $invite_input.removeClass('error');
                        }else{
                            alert(JSON.stringify(response));
                            $invite_input.addClass('error');
                        }
                    },'json'
                );

                return;
            }else{
                alert('invalid input');
                $invite_input.addClass('error');
                return;
            }

        }



        if(invite_from_list){
            var $invite_list = $invite_holder.find('#invite_list');

            if(!jQuery('.invite_user_list_item[data-id="' + id + '"]').length){
                var user_json = {};
                user_json['user_name'] = name;
                user_json['user_email'] = email;
                user_json['id'] = id;
                user_json['file_url'] = file_url;


                var source = jQuery('#user_template').html();
                var template = Handlebars.compile(source);
                var generated_html = template(user_json);

                $invite_list.append(jQuery(generated_html));



                $invite_input.attr('data-name','');
                $invite_input.attr('data-email','');
                $invite_input.attr('data-id','');
                $invite_input.attr('data-file_url','');


                $invite_input.val('');
            }
        }else{

            //Just invite this one user
            //We know the user_id is set since we checked for it earlier





            var post_url = globals.base_url + '/api/groupInvite';
            var post_data = {to_user_id: id, origin_type: globals.origin_type, origin_id: globals.origin_id};

            $.post(
                post_url,
                post_data,
                function(response){

                    var $invite_popup = $invite_holder.find('#invite_popup');
                    $invite_popup.removeClass('active');

                     //Clear the text input field
                    $invite_input.val('');
                    $invite_input.removeClass('error');
                    $(".successful_invite_icon").fadeIn(100).delay(850).queue(function(next){
                        $(".successful_invite_icon").fadeOut(150);
                        next();
                    });
                },'json'
            );





        }






    });





    function show_user_invite(user_json){
        //Insert the users
        var source = jQuery('#invite_user_template').html();
        var template = Handlebars.compile(source);

        user_json['base_url'] = base_url;
        user_json['user_name'] = user_json['firstname'] + " " + user_json['lastname'];

        var generated_html = template(user_json);

        jQuery('#invite_popup').append(jQuery(generated_html));
    }





    var last_input = '';

    jQuery(document).on('keyup','.invite_input',function(event){

        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            //Check if the dropdown has any users listed
            //If so, set the field to the values of the first user
            var $first_invite_holder = $("#invite_popup").children().first();
            if($first_invite_holder.length){
                $first_invite_holder.click();
            }


            $('.invite_people_button').click();
            return;
        }



        var $invite_input = jQuery(this);


        $invite_input.attr('data-id','');
        $invite_input.attr('data-name','');
        $invite_input.attr('data-email','');
        $invite_input.attr('data-file_url','');


        var $invite_popup = $invite_input.closest('.invite_holder').find('#invite_popup');

        var input_string = $invite_input.val();


        if(input_string.length > 0){


            last_input = input_string;

            setTimeout(search_users, 600);



            function search_users(){
                //Check if the input string has changed
                //between the time of function call and now
                if(input_string == last_input){
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
                }
            }





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

        update_invite_input_data($invite_user_holder);



    });

    jQuery(document).on('click', '.add_people_button.invite', function(e){
        $(this).hide();
        $(".help_div.dark").hide();
        $("#invite_holder").show();
        $("#remove_button").hide();
        $("#invite_holder .invite_input").focus();
    });
    jQuery(document).on('click', '#done_inviting_button', function(e){
        $(".help_div.dark").hide();
        $("#invite_holder").hide();
        $("#remove_button").show();
        $(".add_people_button.invite").show();
    });




    //Takes in a $invite_user_holder object
    //and sets that data to the invite input
    function update_invite_input_data($invite_user_holder){
        var user_id = $invite_user_holder.attr('data-id');
        var user_name = $invite_user_holder.attr('data-name');
        var user_email = $invite_user_holder.attr('data-email');
        var user_file_url = $invite_user_holder.attr('data-file_url');

        var $invite_input = $invite_user_holder.closest('.invite_holder').find('.invite_input');

        //We know forsure that this is valid user data
        $invite_input.removeClass('error');

        //Set the data attributes for the invite_input
        $invite_input.attr('data-id', user_id);
        $invite_input.attr('data-name', user_name);
        $invite_input.attr('data-email', user_email);
        $invite_input.attr('data-file_url', user_file_url);

        $invite_input.val(user_name + ' <' + user_email + '>');

        var $invite_popup = jQuery('#invite_popup');
        $invite_popup.removeClass('active');
        $invite_popup.empty();
    }




    jQuery(document).on('focusout','.invite_input', function(e){

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


    jQuery(document).on('click', function(){

        verify_invite_input($('.invite_holder').find('.invite_input'));
    });



});