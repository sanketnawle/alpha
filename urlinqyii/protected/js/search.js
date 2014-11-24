$(document).ready(function(){

    init();
    function init(){
        if(q != ""){
            get_search_results(q); //
        }
    }



    function dynamic_dropLists()
    {
        //this is for leftsec, to make droplists dynamic...
        //if($(".dropListItem").parent() == $("#schools")) {}


    }
    //acquire JSON from searchController after sending query via get request
    function get_search_results(local_q){
        $.getJSON( base_url + '/search/json', {q:local_q},function( search_json_data )
        {
            alert(JSON.stringify(search_json_data)); //test, returns JSON object

            if(search_json_data['success']){
                alert(JSON.stringify(search_json_data)); //test, returns JSON object
                show_search_results(search_json_data);
            }else{
                alert('error getting data');
            }
        });
    }

    function show_search_results(search_json_data){
        //stick all JSON in appropriate JSON object (by type)
        var users_json = search_json_data['users'];
        var courses_json = search_json_data['courses'];
        var clubs_json = search_json_data['clubs'];
        var departments_json = search_json_data['departments'];
        var schools_json = search_json_data['schools'];
        //show_result(schools_json); //test


        //get each user attributes and generate HTML!
        $.each(users_json, function(index, user){
            //alert(JSON.stringify(users_json[index]));
            show_users(users_json[index]);
        });
        //Get each course attribute and generate HTML!
        $.each(courses_json, function(index, course){
            //alert(JSON.stringify(courses_json[index]));
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
        var generated_html = template(JSON.stringify(result_json));
        $('.slide-inner').append(generated_html).hide().fadeIn();
    }
    function show_courses(result_json) {
        //alert('course_id: ' + JSON.stringify(result_json["course_id"]));
        var source   = $("#vertical_search_results").html();
        var template = Handlebars.compile(source);
        var generated_html = template(JSON.stringify(result_json));
        $('.results-main-sec').append(generated_html).hide().fadeIn();
        //alert(generated_html);
    }
    function show_clubs(result_json){
        //alert('group_id: ' + JSON.stringify(result_json["group_id"]));
        var source   = $("#vertical_search_results").html();
        var template = Handlebars.compile(source);
        var generated_html = template(JSON.stringify(result_json));
        $('#clubbox').append(generated_html).hide().fadeIn();
    }
    function show_departments(result_json){
        //alert('department_id: ' + JSON.stringify(result_json["department_id"]));
        var source   = $("#vertical_search_results").html();
        var template = Handlebars.compile(source);
        var generated_html = template(JSON.stringify(result_json));
        $('#deptbox').append(generated_html).hide().fadeIn();
    }
});

//For the specific searches (from topbar.js)
$("#piyd").click(function(){
    $.getJSON( base_url + '/search/json', {f:piyd},function( search_json_data )
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
//For the specific searches (from topbar.js)
$("#ciys").click(function(){
    alert("ciys");
    $.getJSON( base_url + '/search/json', {f:ciys},function( search_json_data )
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
$("#giys").click(function(){
    alert("giys");
    $.getJSON( base_url + '/search/json', {f:giys},function( search_json_data )
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
$("#sys").click(function(){
    alert("sys");
    $.getJSON( base_url + '/search/json', {f:sys},function( search_json_data )
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

