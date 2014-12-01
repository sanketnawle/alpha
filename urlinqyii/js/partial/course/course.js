$(document).ready(function(){


    $ = jQuery.noConflict();
    //Handlebars helpers

    //var id = 3;
    init();
    function init() {
        //alert("init");
        get_course_data(id);
        //get_course_data();
    }

    /*
    function init(){
        var course_json_data = get_course_data();
        if(feed_json_data['success']){
            render_course(feed_json_data);
        }else{
            alert('failed to get data');
        }

    }

    function get_course_data(){
        $.getJSON( "localhost/alpha/urlinqyii/course/3", function( data ) {
            alert(JSON.stringify(data));
            return data;
    });
    */
    function get_course_data(id){
        $.getJSON( base_url + '/course/' + id + '/feed',function( course_data )
        {
            //alert("in get_course_data");
            if(course_data['id']){
                //alert(JSON.stringify(search_json_data)); //test, returns JSON object
                alert(JSON.stringify(course_data));
                render_course(course_data);
            }else{
                alert('error getting data');
            }
        });
    }
    function render_course(course_json){
        //alert("in render_course");
        var source   = $("#course_template").html();
        var template = Handlebars.compile(source);
        var context = {

        }
        var generated_html = template(context);
        $('#posts').append(generated_html).hide().fadeIn();
    }

    /*
    function render_course(single_post){
        var source   = $("#course_template").html();
        var template = Handlebars.compile(source);
        $("#posts").append(template(single_post));
       
    }*/



});







