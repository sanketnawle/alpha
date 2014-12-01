$(document).ready(function(){


    $ = jQuery.noConflict();
    //Handlebars helpers

    init();
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
    function render_course(single_post){
        var source   = $("#course_template").html();
        var template = Handlebars.compile(source);
        $("#posts").append(template(single_post));
       
    }



});







