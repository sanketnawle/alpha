$(document).ready(function(){

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
        var students_json = search_json_data['students'] != undefined ? search_json_data['students'] : [];
        var professors_json = search_json_data['professors'] != undefined ? search_json_data['professors'] : [];
        var courses_json = search_json_data['courses'] != undefined ? search_json_data['courses'] : [];
        var clubs_json = search_json_data['clubs'] != undefined ? search_json_data['clubs'] : [];
        var departments_json = search_json_data['departments'] != undefined ? search_json_data['departments'] : [];
        var schools_json = search_json_data['schools'] != undefined ? search_json_data['schools'] : [];
        var majors_json = search_json_data['majors'] != undefined ? search_json_data['majors'] : [];
        var alldepts_json = search_json_data['allDepartments'] != undefined ? search_json_data['allDepartments'] : [];

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
            //alert(JSON.stringify(users_json[index]));
            show_users(users_json[index]);
        });
        //Get each course attribute and generate HTML!
        $.each(courses_json, function(index, course){
            //alert("Show Courses!");
            //show_courses_head(courses_json[index]);
            show_courses(courses_json[index]);
        });

        //Get each clubs attribute and generate HTML!
        $.each(clubs_json, function(index, club){
            //alert("Show Clubs!");
            //show_clubs_image((clubs_json[index]));
            show_clubs(clubs_json[index]);
        });

        //Get each department attribute and generate HTML!
        $.each(departments_json, function(index, dept){
            //alert("Show Departments!");
            show_departments(departments_json[index]);
        });

        //alert("length: " + users_json.length);

        //Appropriate filters rendered as results come in
        $('#category1').parent().parent().hide(); //all
        $('#category2').parent().parent().hide(); //courses
        $('#category3').parent().parent().hide(); //professors
        $('#category4').parent().parent().hide(); //students
        $('#category5').parent().parent().hide(); //clubs
        $('#category6').parent().parent().hide(); //departments

        if (courses_json.length != 0) {
            $('#category1').parent().parent().show(); //all
            $('#category2').parent().parent().show(); //courses
            //alert("courses react");
        }
        if(professors_json.length != 0) {
            $('#category1').parent().parent().show(); //all
            $('#category3').parent().parent().show(); //professors
            //alert("professors react");
        }
        if(students_json.length != 0) {
            $('#category1').parent().parent().show(); //all
            $('#category4').parent().parent().show(); //students
            //alert("students react");
        }
        if(clubs_json.length != 0) {
            $('#category1').parent().parent().show(); //all
            $('#category5').parent().parent().show(); //clubs
            //alert("clubs react");
        }
        if (departments_json.length != 0) {
            $('#category1').parent().parent().show(); //all
            $('#category6').parent().parent().show(); //departments
            //alert("departments react");
        }
    }

    //Handlebars HTML Generation
    function show_users(result_json){
        //We present users and professors in the same place, but label them by type (s or p)
        //alert('user_id: ' + JSON.stringify(result_json["user_id"]));

        var source   = $("#user_search_results").html();
        var template = Handlebars.compile(source);
        var context = {
            fullname: result_json['firstname'] + " " + result_json['lastname'],
            department: result_json['department_name'],
            url: base_url + "/assets/default/user.png",
            id: result_json["user_id"]
        }
        var generated_html = template(context);
        $('.ContentSlider').append(generated_html).hide().fadeIn();
    }


    function show_courses(result_json) {
        var source   = $("#vertical_course_results").html();
        var template = Handlebars.compile(source);
        var context =
        {
            description: result_json["course_desc"],
            admin_key: "School",
            department_key: "Department",
            members_key: "Members",
            admin_value: result_json["school_name"],
            department_value: result_json["department_name"],
            department_url: base_url + '/department/' + result_json['department_id'],
            members_value: "Be the first to join",
            name: result_json['course_name'],
            url: base_url + "/course/" + result_json['course_id']
        }
        var generated_html = template(context);
        $('.vert-area').append(generated_html).hide().fadeIn();
    }

    function show_clubs(result_json) {
        var source   = $("#vertical_club_results").html();
        var template = Handlebars.compile(source);
        var context =
        {
            imgurl: base_url + "/assets/default/user.png",
            cluburl: base_url + "/club/" + result_json['group_id'],
            name: result_json['group_name']
        }
        var generated_html = template(context);
        $('.vert-area').append(generated_html).hide().fadeIn();
    }

    function show_departments(result_json) {
        var source   = $("#vertical_dept_results").html();
        var template = Handlebars.compile(source);
        var context =
        {
            imgurl: base_url + "/assets/default/dept_dp.png",
            cluburl: base_url + "/department/" + result_json['department_id'],
            name: result_json['department_name'],
            description: result_json['description_name']
        }

        var generated_html = template(context);
        $('.results-main-sec').append(generated_html).hide().fadeIn();
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
