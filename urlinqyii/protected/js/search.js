$(document).ready(function(){

    Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

        switch (operator) {
            case '==':
                return (v1 == v2) ? options.fn(this) : options.inverse(this);
            case '===':
                return (v1 === v2) ? options.fn(this) : options.inverse(this);
            case '<':
                return (v1 < v2) ? options.fn(this) : options.inverse(this);
            case '<=':
                return (v1 <= v2) ? options.fn(this) : options.inverse(this);
            case '>':
                return (v1 > v2) ? options.fn(this) : options.inverse(this);
            case '>=':
                return (v1 >= v2) ? options.fn(this) : options.inverse(this);
            case '&&':
                return (v1 && v2) ? options.fn(this) : options.inverse(this);
            case '||':
                return (v1 || v2) ? options.fn(this) : options.inverse(this);
            case '!=':
                return (v1 != v2) ? options.fn(this) : options.inverse(this);
            default:
                return options.inverse(this);
        }
    });



    init();
    function init(){
        get_search_results(q);
        /*if(q != ""){
            get_search_results(q);
        }
        else
        {
            get_search_results(q);
        }*/
    }

    forceLeftMenuClose = true;


    function dynamic_dropLists()
    {
        //this is for leftsec, to make droplists dynamic...
        //if($(".dropListItem").parent() == $("#schools")) {}


    }
    //acquire JSON from searchController after sending query via get request
    function get_search_results(local_q){
        $.getJSON( base_url + '/search/json', {q:local_q},function( search_json_data )
        {
            //alert(JSON.stringify(search_json_data)); //test, returns JSON object

            if(search_json_data['success']){

                //Set the text for the query
                $('.search_results_header_sentence').find('.query').text("'" + local_q + "'");
                $('.search_results_header_sentence').find('.query').text("'" + local_q + "'");
                document.title = local_q + " - Urlinq Search";
                $('#top_search_bar').val(local_q);
                //alert(JSON.stringify(search_json_data)); //test, returns JSON object
                //alert(JSON.stringify(search_json_data));
                show_search_results(search_json_data);
            }else{
                alert('error getting data');
            }
        });
    }

    function show_search_results(search_json_data){
        //stick all JSON in appropriate JSON object (by type)
        var users_json = search_json_data['users'] != undefined ? search_json_data['users'] : [];

        if(users_json.length == 0){
            $('.horizontal_scroll_holder').hide();
        }else{
            $('.horizontal_scroll_holder').show();
        }

        if(users_json.length < 6){
            $('.arrow_container.arrow_next').hide();
        }


        var students_json = search_json_data['students'] != undefined ? search_json_data['students'] : [];
        var professors_json = search_json_data['professors'] != undefined ? search_json_data['professors'] : [];
        var courses_json = search_json_data['courses'] != undefined ? search_json_data['courses'] : [];
        var clubs_json = search_json_data['clubs'] != undefined ? search_json_data['clubs'] : [];
        var departments_json = search_json_data['departments'] != undefined ? search_json_data['departments'] : [];
        var schools_json = search_json_data['schools'] != undefined ? search_json_data['schools'] : [];
        var majors_json = search_json_data['majors'] != undefined ? search_json_data['majors'] : [];
        var alldepts_json = search_json_data['allDepartments'] != undefined ? search_json_data['allDepartments'] : [];
        var events_json = search_json_data['events'] != undefined ? search_json_data['events'] : [];





       // $('.filter_section[data-filter="schools"]').find('.search_filter_count').text(schools_json.length);
        //for the left sidebar
        $.each(schools_json, function(index, course){
            //alert(JSON.stringify(schools_json[index]['school_name']));
            $('#courseschool').append('<li>'+schools_json[index]['school_name']+'</li>');
            $('#professorschool').append('<li>'+schools_json[index]['school_name']+'</li>');
            $('#studentschool').append('<li>'+schools_json[index]['school_name']+'</li>');
            $('#clubschool').append('<li>'+schools_json[index]['school_name']+'</li>');
            $('#departmentschool').append('<li>'+schools_json[index]['school_name']+'</li>');
        });
        $.each(majors_json, function(index, major){
            //alert(JSON.stringify(majors_json[index]['name']));
            $('#studentmajor').append('<li>'+majors_json[index]['name']+'</li>');
        });
        $.each(alldepts_json, function(index, dept){
            //alert(JSON.stringify(alldepts_json[index]['department_name']));
            $('#coursedepartment').append('<li>'+alldepts_json[index]['department_name']+'</li>');
            $('#professordepartment').append('<li>'+alldepts_json[index]['department_name']+'</li>');
        });

        //get each user attributes and generate HTML!
        $.each(users_json, function(index, user){
            show_users(users_json[index]);
        });





        $('.filter_section[data-filter="courses"]').find('.search_filter_count').text(courses_json.length);

        //Get each course attribute and generate HTML!
        $.each(courses_json, function(index, course){
            //alert("Show Courses!");
            //show_courses_head(courses_json[index]);
            show_courses(courses_json[index]);
        });




        $('.filter_section[data-filter="clubs"]').find('.search_filter_count').text(clubs_json.length);

        //Get each clubs attribute and generate HTML!
        $.each(clubs_json, function(index, club){
            //alert("Show Clubs!");
            //show_clubs_image((clubs_json[index]));
            show_clubs(clubs_json[index]);
        });


        $('.filter_section[data-filter="departments"]').find('.search_filter_count').text(departments_json.length);


        //Get each department attribute and generate HTML!
        $.each(departments_json, function(index, dept){
            //alert("Show Departments!");
            show_departments(departments_json[index]);
        });


        $('.filter_section[data-filter="faculty"]').find('.search_filter_count').text(professors_json.length);

        //get each user attributes and generate HTML!
        $.each(professors_json, function(index, user){
            show_faculty(professors_json[index]);
        });



        $('.filter_section[data-filter="students"]').find('.search_filter_count').text(students_json.length);

        //get each user attributes and generate HTML!
        $.each(students_json, function(index, user){
            show_student(students_json[index]);
        });



        $('.filter_section[data-filter="events"]').find('.search_filter_count').text(events_json.length);


        //get each user attributes and generate HTML!
        $.each(events_json, function(index, user){
            show_event(events_json[index]);
        });

        //alert("length: " + users_json.length);

//        //Appropriate filters rendered as results come in
//        $('#category1').parent().parent().hide(); //all
//        $('#category2').parent().parent().hide(); //courses
//        $('#category3').parent().parent().hide(); //professors
//        $('#category4').parent().parent().hide(); //students
//        $('#category5').parent().parent().hide(); //clubs
//        $('#category6').parent().parent().hide(); //departments
//
//        if (courses_json.length != 0) {
//            $('#category1').parent().parent().show(); //all
//            $('#category2').parent().parent().show(); //courses
//            //alert("courses react");
//        }
//        if(professors_json.length != 0) {
//            $('#category1').parent().parent().show(); //all
//            $('#category3').parent().parent().show(); //professors
//            //alert("professors react");
//        }
//        if(students_json.length != 0) {
//            $('#category1').parent().parent().show(); //all
//            $('#category4').parent().parent().show(); //students
//            //alert("students react");
//        }
//        if(clubs_json.length != 0) {
//            $('#category1').parent().parent().show(); //all
//            $('#category5').parent().parent().show(); //clubs
//            //alert("clubs react");
//        }
//        if (departments_json.length != 0) {
//            $('#category1').parent().parent().show(); //all
//            $('#category6').parent().parent().show(); //departments
//            //alert("departments react");
//        }
    }






    $(document).on('click', '.filter_section', function(){
        var $filter_section = $(this);



        var filter = $filter_section.attr('data-filter');


        if(filter == 'all'){
            $('.search_result_panel').each(function(){
                $(this).show();
            });
        }else{
            //Hide all sections except the one clicked
            $('.search_result_panel').each(function(){
                if($(this).attr('id') == filter){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
        }


    });




    //Handlebars HTML Generation
    function show_users(result_json){
        //We present users and professors in the same place, but label them by type (s or p)
        //alert('user_id: ' + JSON.stringify(result_json["user_id"]));

        var source   = $("#user_template").html();
        var template = Handlebars.compile(source);



        result_json['fullname'] = result_json['firstname'] + " " + result_json['lastname'];
        result_json['url'] = base_url + "/assets/default/user.png";

        var generated_html = template(result_json);
        $('.ContentSlider').append(generated_html).hide().fadeIn();
    }



    //Handlebars HTML Generation
    function show_faculty(result_json){
        //We present users and professors in the same place, but label them by type (s or p)
        //alert('user_id: ' + JSON.stringify(result_json["user_id"]));

        var source   = $("#user_template").html();
        var template = Handlebars.compile(source);



        result_json['fullname'] = result_json['firstname'] + " " + result_json['lastname'];
        result_json['url'] = base_url + "/assets/default/user.png";

        var generated_html = template(result_json);
        $('#faculty').append(generated_html).hide().fadeIn();
    }

    //Handlebars HTML Generation
    function show_student(result_json){
        //We present users and professors in the same place, but label them by type (s or p)
        //alert('user_id: ' + JSON.stringify(result_json["user_id"]));

        var source   = $("#user_template").html();
        var template = Handlebars.compile(source);



        result_json['fullname'] = result_json['firstname'] + " " + result_json['lastname'];
        result_json['url'] = base_url + "/assets/default/user.png";

        var generated_html = template(result_json);
        $('#students').append(generated_html).hide().fadeIn();
    }


    //Handlebars HTML Generation
    function show_event(result_json){
        //We present users and professors in the same place, but label them by type (s or p)
        //alert('user_id: ' + JSON.stringify(result_json["user_id"]));

        var source   = $("#event_template").html();
        var template = Handlebars.compile(source);

        var generated_html = template(result_json);
        $('#students').append(generated_html).hide().fadeIn();
    }


    function show_courses(result_json) {
        var source   = $("#course_template").html();
        var template = Handlebars.compile(source);
//        var context =
//        {
//            description: result_json["course_desc"],
//            admin_key: "School",
//            department_key: "Department",
//            members_key: "Members",
//            admin_value: result_json["school_name"],
//            department_value: result_json["department_name"],
//            department_url: base_url + '/department/' + result_json['department_id'],
//            members_value: "Be the first to join",
//            name: result_json['course_name'],
//            url: base_url + "/course/" + result_json['course_id']
//        };
        var generated_html = template(result_json);
        $('#courses').append(generated_html).hide().fadeIn();
    }

    function show_clubs(result_json) {
        var source   = $("#club_template").html();
        var template = Handlebars.compile(source);
//        var context =
//        {
//            imgurl: base_url + "/assets/default/user.png",
//            cluburl: base_url + "/club/" + result_json['group_id'],
//            name: result_json['group_name']
//        }
        var generated_html = template(result_json);
        $('#clubs').append(generated_html).hide().fadeIn();
    }

    function show_departments(result_json) {
        var source   = $("#department_template").html();
        var template = Handlebars.compile(source);


        var generated_html = template(result_json);
        $('#departments').append(generated_html).hide().fadeIn();
    }


    //For the specific searches (from topbar.js)
    $(".topbar_graph_search").click(function(e){
        e.stopPropagation();
        $.ajax({url:base_url + '/search/json?f='+e.currentTarget.id,
            type : 'json',
            success:function(search_json_data){
                search_json_data = JSON.parse(search_json_data);
                if(search_json_data['success']){
                    //alert(JSON.stringify(search_json_data)); //test, returns JSON object

                    show_search_results(search_json_data);
                    //$('.leftsec').hide();

                }else{
                    alert('error getting data');
                }
            }
        });
    });

    //search filter on the left
    $('#allResults').click(function(){
        get_search_results(q);
    });
    $('#courses').click(function(){});
    $('#professors').click(function(){});
    $('#students').click(function(){});
    $('#clubs').click(function(){});
    $('#departments').click(function(){});



    ////For the specific searches (from topbar.js)////
    $("#piys").click(function(){
        $.getJSON( base_url + '/search/json', {f:piys},function( search_json_data )
        {
            if(search_json_data['success']){
                //alert(JSON.stringify(search_json_data)); //test, returns JSON object
                show_search_results(search_json_data);
                //$.('.leftsec').hide();
            }else{
                alert('error getting data');
            }
        });
    });
    $("#ciyd").click(function(){
        $.getJSON( base_url + '/search/json', {f:ciyd},function( search_json_data )
        {
            if(search_json_data['success']){
                //alert(JSON.stringify(search_json_data)); //test, returns JSON object
                show_search_results(search_json_data);
                //$.('.leftsec').hide();
            }else{
                alert('error getting data');
            }
        });
    });

//    $("#ciys").click(function(){
//        //alert("ciys");
//        $.getJSON( base_url + '/search/json', {f:ciys},function( search_json_data )
//        {
//            if(search_json_data['success']){
//                //alert(JSON.stringify(search_json_data)); //test, returns JSON object
//                show_search_results(search_json_data);
//                //$.('.leftsec').hide();
//            }else{
//                alert('error getting data');
//            }
//        });
//    });
//    $("#giys").click(function(){
//        //alert("giys");
//        $.getJSON( base_url + '/search/json', {f:giys},function( search_json_data )
//        {
//            if(search_json_data['success']){
//                //alert(JSON.stringify(search_json_data)); //test, returns JSON object
//                show_search_results(search_json_data);
//                //$.('.leftsec').hide();
//            }else{
//                alert('error getting data');
//            }
//        });
//    });
//    $("#sys").click(function(){
//        //alert("sys");
//        $.getJSON( base_url + '/search/json', {f:sys},function( search_json_data )
//        {
//            if(search_json_data['success']){
//                //alert(JSON.stringify(search_json_data)); //test, returns JSON object
//                show_search_results(search_json_data);
//                //$.('.leftsec').hide();
//            }else{
//                alert('error getting data');
//            }
//        });
//    });


});
