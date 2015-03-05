jQuery(document).ready(function(){

    init();

    function init(){
        get_user_groups();
    }

    var provider_height;
    function get_user_groups(){
        jQuery.getJSON(base_url + '/user/getGroupData', function(json_data){
            var $classes_div = $('.providers.class');
            var $clubs_div = $('.providers.clubs');
            var $depts_div = $('.providers.depts');

            jQuery.each(json_data['classes'],function(index, class_json){
                class_json['name'] = class_json['class_name'];
                class_json['type'] = 'class';
                class_json['id'] = class_json['class_id'];
                show_user_group(class_json, '.providers.class');
            });
            if(json_data['classes'].length==0){
                $classes_div.append('<p>No classes</p>');
            }


            jQuery.each(json_data['clubs'],function(index, club_json){
                club_json['name'] = club_json['group_name'];
                club_json['type'] = 'club';
                club_json['id'] = club_json['group_id'];
                show_user_group(club_json, '.providers.clubs');
            });
            if(json_data['clubs'].length==0){
                $clubs_div.append('<p>No clubs</p>');
            }

            jQuery.each(json_data['departments'],function(index, dept_json){
                dept_json['name'] = dept_json['department_name'];
                dept_json['type'] = 'department';
                dept_json['id'] = dept_json['department_id'];
                show_user_group(dept_json, '.providers.depts');
            });
            if(json_data['departments'].length==0){
                $depts_div.append('<p>No departments followed</p>');
            }

        });
    }


    colors = ['a','b','c','d','e','f'];
    color_index = 0;
    function show_user_group(group_json, group_div_selector){

        //Normally source would be jQuery("#group_template").html(); but for whatever reason
        //angular doesnt let jquery select the handlebars template if it is in the html
        var source = $('#provider_template').html();
        var template = Handlebars.compile(source);
        var generated_html = template(group_json);
        $(group_div_selector).append(generated_html);

        update_color_index();
        provider_height = $('.leftbar').height() - 267;
        $('.providers_scrollable').slimScroll({
            height: provider_height,
            railVisible: true, 
            touchScrollStep: "20",
            size:"10px",
            allowPageScroll: true,
            distance: "3px"            
        });
    }
    
    $(window).on('resize',function(){
        provider_height = $('.leftbar').height() - 267;
        $('.providers_scrollable').slimScroll({
            height: provider_height,
            railVisible: true, 
            touchScrollStep: "20",
            size:"10px",
            allowPageScroll: true,
            distance: "3px"            
        });
    })

    function update_color_index(){
        color_index++;
        if(color_index == colors.length){
            color_index = 0;
        }
    }



    jQuery(document).on('click','.check.ng-scope',function(){
        var $check = $(this);
        var origin_type = $check.closest('.provider').attr('data-origin_type');
        var origin_id = $check.closest('.provider').attr('data-origin_id');
        console.log(origin_type);
        console.log(origin_id);

        if($check.attr('checked')){
            $check.removeAttr('checked');
            $check.removeClass('checked');
            $('.event_holder[data-origin_type="' + origin_type + '"][data-origin_id="' + origin_id + '"]').each(function(){
                var $event_holder = $(this);
                $event_holder.hide();
            });
            if($check.closest('.providers').hasClass('personal')){
                $('.event_holder[data-hex="#27e53f"]').each(function(){
                    var $event_holder = $(this);
                    $event_holder.hide();
                });
            }
        }else{
            $check.attr('checked','');
            $check.addClass('checked');
            $('.event_holder[data-origin_type="' + origin_type + '"][data-origin_id="' + origin_id + '"]').each(function(){
                var $event_holder = $(this);
                $event_holder.show();
            });
            if($check.closest('.providers').hasClass('personal')){
                $('.event_holder[data-hex="#27e53f"]').each(function(){
                    var $event_holder = $(this);
                    $event_holder.show();
                });
            }
        }
    });

});