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
                show_search_results(search_json_data);
            }else{
                alert('error getting data');
            }
        });
    }

    function show_search_results(search_json_data){
        //stick all JSON in appropriate JSON object (by type)
        var users_json = search_json_data['users'] != undefined ? search_json_data['users'] : [];
        var courses_json = search_json_data['courses'] != undefined ? search_json_data['courses'] : [];
        var clubs_json = search_json_data['clubs'] != undefined ? search_json_data['clubs'] : [];
        var departments_json = search_json_data['departments'] != undefined ? search_json_data['departments'] : [];
        var schools_json = search_json_data['schools'] != undefined ? search_json_data['schools'] : [];
        //show_result(schools_json); //test


        var deptname = "";

        //get each user attributes and generate HTML!
        $.each(users_json, function(index, user){
            //alert(JSON.stringify(users_json[index]));
            show_users(users_json[index]);
        });
        //Get each course attribute and generate HTML!
        $.each(courses_json, function(index, course){
            //alert(JSON.stringify(courses_json[index]));
            show_courses_head(courses_json[index]);
            show_courses(courses_json[index]);
        });
        //Get each clubs attribute and generate HTML!
        $.each(clubs_json, function(index, club){
            //alert(JSON.stringify(clubs_json[index]));
            show_clubs(clubs_json[index]);
        });
        //Get each department attribute and generate HTML!
        $.each(departments_json, function(index, dept){
            //alert(JSON.stringify(users_json[index]));
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
        if(users_json.length != 0) {
            $('#category1').parent().parent().show(); //all
            $('#category3').parent().parent().show(); //professors
            //alert("professors react");
        }
        if(users_json.length != 0) {
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
            department: result_json['department_id']
        }
       // var generated_html = template(JSON.stringify(result_json));
        var generated_html = template(context);
        $('.slide-inner').append(generated_html).hide().fadeIn();
    }

    function show_courses(result_json) {
        //alert('course_id: ' + JSON.stringify(result_json["course_id"]));
        var source   = $("#vertical_course_results").html();
        var template = Handlebars.compile(source);
        //var generated_html = template(result_json);
        var context =
        {
            description: result_json["course_desc"],
            admin_key: "School",
            department_key: "Department",
            members_key: "Members",
            admin_value: result_json["school_id"],
            department_value: result_json["dept_id"],
            members_value: "Be the first to join"
        }
        var generated_html = template(context);
        $('.results-main-sec').append(generated_html).hide().fadeIn();
        //alert(JSON.stringify($(".description")));
        //$('.description').append(JSON.stringify(result_json['description']));
    }
    function show_courses_head(result_json) {
        //alert('course_id: ' + JSON.stringify(result_json["course_id"]));
        var source   = $("#vertical_course_results_top").html();
        var template = Handlebars.compile(source);
        //var generated_html = template(result_json);
        var context =
        {
            rname: result_json['course_name']
        }
        var generated_html = template(context);
        $('.results-main-sec').append(generated_html).hide().fadeIn();
        //alert(JSON.stringify($(".description")));
        //$('.description').append(JSON.stringify(result_json['description']));
    }
    function show_clubs_image(result_json) {
        //alert('course_id: ' + JSON.stringify(result_json["course_id"]));
        var source   = $("#vertical_club_results_img").html();
        var template = Handlebars.compile(source);
        //var generated_html = template(result_json);
        var context =
        {
            //url: base_url + "/search/" + result_json['group_id']
        }
        var generated_html = template(context);
        $('.results-main-sec').append(generated_html).hide().fadeIn();
        alert("check me out, it works!");
        //alert(JSON.stringify($(".description")));
        //$('.description').append(JSON.stringify(result_json['description']));
    }
    function show_clubs(result_json) {
        //alert('course_id: ' + JSON.stringify(result_json["course_id"]));
        var source   = $("#vertical_club_results").html();
        var template = Handlebars.compile(source);
        //var generated_html = template(result_json);
        var context =
        {
            description: result_json["Name"],
            admin_key: "Name",
            department_key: "School",
            members_key: "Members",
            admin_value: result_json["group_name"],
            department_value: result_json["school_id"],
            members_value: "Be the first to join"
        }
        var generated_html = template(context);
        $('.results-main-sec').append(generated_html).hide().fadeIn();
        //alert(JSON.stringify($(".description")));
        //$('.description').append(JSON.stringify(result_json['description']));
    }
    function show_departments(result_json) {
        //alert('course_id: ' + JSON.stringify(result_json["course_id"]));
        var source   = $("#vertical_dept_results").html();
        var template = Handlebars.compile(source);
        //var generated_html = template(result_json);
        var context =
        {
            description: result_json["course_desc"],
            admin_key: "School",
            department_key: "Department",
            members_key: "Members",
            admin_value: result_json["school_id"],
            department_value: result_json["dept_id"],
            members_value: "Be the first to join"
        }
        var generated_html = template(context);
        $('.results-main-sec').append(generated_html).hide().fadeIn();
        //alert(JSON.stringify($(".description")));

        //$('.description').append(JSON.stringify(result_json['description']));

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
        alert("cat1");
        //get_search_results(q);
    });
    $('#courses').click(function(){
        alert("cat2");
        //get_search_results(q);
    });
    $('#professors').click(function(){
        alert("cat3");
        //get_search_results(q);
    });
    $('#students').click(function(){
        alert("cat4");
        //get_search_results(q);
    });
    $('#clubs').click(function(){
        alert("cat5");
        //get_search_results(q);
    });
    $('#departments').click(function(){
        alert("cat6");
        //get_search_results(q);
    });

//    $("#piys").click(function(){
//        $.getJSON( base_url + '/search/json', {f:piys},function( search_json_data )
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
//    $("#ciyd").click(function(){
//        $.getJSON( base_url + '/search/json', {f:ciyd},function( search_json_data )
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
//
////For the specific searches (from topbar.js)
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
