/*NOTE:post_type, privacy_flag and anon change based on what the user selects  - 
the code to change them is added to the rest of the jquery of status_bar.html -> it basically changes the value of the
var on('click')*/
$(document).ready(function() {
    //*starts* Code to make the post request for a post 
    var post_type = 'status';
    var privacy = 'campus';
    var anon = 0;
    //these two vals are hardcoded for now - based on our phonecall 
    var origin_type = 'class';
    var origin_id = 25;
    //Posting a Form
    $(document).on('click', '.post-btn', function() {
        var jsonData = {
                'origin_type': origin_type,
                'origin_id': origin_id,
                'post_type': post_type,
                'anon': anon,
                'privacy': privacy
            }
            //Checks if all the bases types are satisfied 
        if (origin_type && origin_id && post_type && (anon === 0 || anon === 1) && privacy) {
            //Checks for the type of status
            if (post_type === "status") {

                var text_msg = $('.postTxtarea').val();
                if (text_msg) {
                    jsonData.text = text_msg;
                    console.log(jsonData);
                    //Makes the ajaxcall to postcontroller.php
                    postStatusAjax(jsonData);
                } else {
                    //If there is no text lets user know there isn't any
                    $('.postTxtarea').text("Add text before posting");
                }
            } else if (post_type == 'question') {
                //Adds all expert tags into the array experts
                var experts  = $(".midfbar-exp .tag-name").map(function() {
                    return $(this).text();
                }).get();
                //adds experts to jsonData
                if (experts.length > 0) jsonData.ask_experts = experts;
                //Gets the top text
                var text_msg = $('.topfbar').val();
                //Gets the sub_text
                var sub_text_msg = $('.askTxtArea').val();
                //Adds it to Json if there is any
                if (sub_text_msg) jsonData.sub_text = sub_text_msg;
                if (text_msg) {
                    jsonData['text'] = text_msg;
                    //Makes the Ajax Call to postcontroller.php
                    postStatusAjax(jsonData);
                } else {
                    console.log('ese');
                    $('.askTxtArea').text("Add text before posting");
                }
            } 
        } else {
            alert("Can't make a post yet");
        }

    });

    function postStatusAjax(jsonData) {
        //makes the ajax request to postcontroller.php
        $.ajax({
            url: "http:www.urlinq.com/beta/PostController.php",
            type: "POST",
            data: jsonData,
            dataType: 'json',
            success: function(html) {
                //code to add this post to the feed
                var source = $("#post_template").html();
                var template = Handlebars.compile(source);
                $("#posts").append(template(html));

            },

            error: function() {
                $("#posts").append("Error Adding the post");
            }
        });

    }
});