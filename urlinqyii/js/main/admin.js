$(document).ready(function(){



    var $last_clicked_dropdown_input = null;




    $('#create_class_school_input').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        //Check if univ id has been set
        var university_id = $("#create_class_university_input").attr('data-id');

        if(!university_id){
            alert('Please select a university');
            return;
        }

        position_dropdown($(this));
        clear_dropdown();


        $.getJSON(globals.base_url + '/university/getSchools', { university_id: university_id }, function(json_data){
            //Create a dropdown for this

            $.each(json_data['schools'], function(index, school){
                school['id'] = school['school_id'];
                school['name'] = school['school_name'];
                add_dropdown_item(school);
            });

        });


        $last_clicked_dropdown_input = $(this);

    });



    $('#create_class_department_input').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        //Check if univ id has been set
        var school_id = $("#create_class_school_input").attr('data-id');

        if(!school_id){
            alert('Please select a school');
            return;
        }

        position_dropdown($(this));
        clear_dropdown();


        $.getJSON(globals.base_url + '/school/getDepartments', { school_id: school_id }, function(json_data){
            //Create a dropdown for this

            $.each(json_data['departments'], function(index, department){
                department['id'] = department['department_id'];
                department['name'] = department['department_name'];
                add_dropdown_item(department);
            });

        });


        $last_clicked_dropdown_input = $(this);

    });



    $('#create_class_course_input').click(function(e){
        e.preventDefault();
        e.stopPropagation();
        //Check if univ id has been set
        var department_id = $("#create_class_department_input").attr('data-id');

        if(!department_id){
            alert('Please select a department');
            return;
        }

        position_dropdown($(this));
        clear_dropdown();


        $.getJSON(globals.base_url + '/department/getCourses', { department_id: department_id }, function(json_data){
            //Create a dropdown for this

            $.each(json_data['courses'], function(index, course){
                course['id'] = course['course_id'];
                course['name'] = course['course_name'];
                add_dropdown_item(course);
            });

        });


        $last_clicked_dropdown_input = $(this);

    });



    $('#create_class_professor_input').click(function(e){


    });


    $('#create_class_professor_input').keydown(function(e){
        e.stopPropagation();


        var query = $('#create_class_professor_input').val();

        clear_dropdown();


        if(query.length >= 2){
            position_dropdown($(this));



            $.getJSON(globals.base_url + '/search/users', { q: query }, function(json_data){
                //Create a dropdown for this

                $.each(json_data['users'], function(index, user){
                    user['id'] = user['user_id'];
                    user['name'] = user['firstname'] + ' ' + user['lastname'];
                    add_dropdown_item(user);
                });
            });


            $last_clicked_dropdown_input = $(this);
        }
    });







    $(document).on('click', '.dropdown_item', function(){
        $('#input_dropdown').hide();

        var $this_dropdown_item = $(this);

        $last_clicked_dropdown_input.attr('data-id', $this_dropdown_item.attr('data-id'));
        $last_clicked_dropdown_input.val($this_dropdown_item.attr('data-name'));

    });


    //pass in the $input that was clicked
    //and position the dropdown underneath it
    function position_dropdown($input){

        //Get the position of this time input
        var input_position = $input.offset();



        var $dropdown = $('#input_dropdown');

        //Set the position of the $dropdown to underneath this input
        $dropdown.css({'position': 'fixed'});
        $dropdown.css({'top': (input_position.top + 5 + $input.height()).toString() + 'px'});
        $dropdown.css({'left': input_position.left.toString() + 'px'});
        $dropdown.css({'z-index': '9999'});


        //Set the dropdown to active
        $dropdown.show();
    }



    function clear_dropdown(){
        $("#input_dropdown").empty();
    }





    //Pass in json structure with id and name
    function add_dropdown_item(json_object){
        var source   = $("#dropdown_item_template").html();
        var template = Handlebars.compile(source);
        $("#input_dropdown").append($(template(json_object)));
    }








    $(document).on('submit', '#create_class_form', function(e){
        e.preventDefault();

        var university_id = $('#create_class_university_input').attr('data-id') ? $('#create_class_university_input').attr('data-id') : '';
        var school_id = $('#create_class_school_input').attr('data-id') ? $('#create_class_school_input').attr('data-id') : '';
        var department_id = $('#create_class_department_input').attr('data-id') ? $('#create_class_department_input').attr('data-id') : '';
        var course_id = $('#create_class_course_input').attr('data-id') ? $('#create_class_course_input').attr('data-id') : '';



        var class_name = $('#create_class_name_input').val();
        var class_section = $('#create_class_section_input').val();
        var class_location = $('#create_class_location_input').val();

        var class_datetime = $('#create_class_datetime_input').val();


        var professor_id = $('#create_class_professor_input').attr('data-id') ? $('#create_class_professor_input').attr('data-id') : '';



        if(university_id == '' || university_id == '0'){
            alert('Input university');
            return;
        }

        if(school_id == '' || school_id == '0'){
            alert('Input school');
            return;
        }

        if(department_id == '' || department_id == '0'){
            alert('Input department');
            return;
        }

        if(course_id == '' || course_id == '0'){
            alert('Input course');
            return;
        }


        if(class_name == ''){
            alert('input class name');
            return;
        }



        var post_url = globals.base_url + '/class/create';


        var post_data = {
            university_id: university_id,
            school_id: school_id,
            department_id: department_id,
            course_id: course_id,
            class_name: class_name,
            section: class_section,
            location: class_location,
            datetime: class_datetime,
            professor_id: professor_id
        };

        $.post(
            post_url,
            post_data,
            function(response){
                alert(JSON.stringify(response));


                if(response['success']){

                }else{

                }

            },'json'
        );





    });














    $(document).on('click', function(){
        $('#input_dropdown').hide();
    });



});