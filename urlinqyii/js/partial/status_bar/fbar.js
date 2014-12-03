/*NOTE:post_type, privacy_flag and anon change based on what the user selects  - 
the code to change them is added to the rest of the jquery of status_bar.html -> it basically changes the value of the
var on('click')*/
var post_type = 'discussion';
var privacy = 'campus';
var anon = 0;
var origin_type = 'class';
var question_type = "regular_type";
//these value hardcoded for now - based on our phonecall 
var origin_id = 25;


$(document).ready(function() {
    //*starts* Code to make the post request for a post 
    

    //Posting a Form
    $(document).on('click', '.post-btn', function() {
        var jsonData = {
                'origin_type': origin_type,
                'origin_id': origin_id,
                'post_type': post_type,
                'anon': anon,
                'privacy': privacy
            };
            console.log(post_type);
            //Checks if all the bases types are satisfied 
        if (origin_type && origin_id && post_type && (anon === 0 || anon === 1) && privacy) {
            //Checks for the type of status
            if (post_type === "discussion") {
                var text = $('.postTxtarea').val();
                if (text) {
                    jsonData.text = text;
                   // console.log(jsonData);
                    //Makes the ajaxcall to postcontroller.php
                    postStatusAjax(jsonData);
                } else {
                    //If there is no text lets user know there isn't any
                    $('.postTxtarea').text("Add text before posting");
                }
            } else if(post_type === "event"){
                var event_name = $('#event_name').val();
                var event_location = $("#event_location").val();
                var description = $("#event_description").val();
                if(event_name === '' || event_description === '' || event_location === ''){

                }
                else {

                    jsonData.event_name = event_name;
                    jsonData.location = event_location;
                    jsonData.description = description;
                    jsonData.title = event_name;
                    //Event Type hardcoded for now
                    jsonData.event_type = "exam";
                    start_date = $('add_event_date').val();

                    //Hard coded doris needs to fix front end 
                    end_date = start_date;
                    if(start_date === '') alert("Add Date please");
                    else{
                        jsonData.end_date = end_date;
                        jsonData.start_date = start_date; 
                    }
                    start_time = $('set_time_24hr').val();
                    //Hard coded Doris needs to fix front end
                    end_time = start_time;
                    if(start_time === '') alert("Add time please");
                    else{
                        jsonData.end_time = end_time;
                        jsonData.start_time = start_time; 

                        if(end_time != "" && end_date != ""){
                            var updatedJsonData = {
                                event : jsonData
                            }
                            //Send's it in the even't format Alex requested for events ONLY
                            postStatusAjax(updatedJsonData);
                        }
                    }


                }
            } else if(post_type === 'notes'){
                console.log("Ine nore");
                var fileSelect = $('._uplI').files;
                console.log(fileSelect);
                if(fileSelect){
                    var formData = new FormData();
                    $.each(fileSelect, function(key, value)
                        {
                            formData.append(key, value);
                        });
                    jsonData.files = formData;
                    postStatusAjax(jsonData);
                } else {
                    $('.uplName').css("color", "red");
                }

            } else if (post_type === 'question') {
                jsonData.question_type = question_type;
                var text = $('.topfbar').val();
                console.log(question_type);
                if(question_type === "regular_type"){
                     var sub_text = $('.askTxtArea').val();
                     if(text === '') $('.topfbar').css("border-bottom", "solid 3px red");
                     else {
                        //if there is sub text set jsonData.sub_text = it
                        if(sub_text != '') jsonData.sub_text = sub_text;
                        //get the text
                        jsonData.text = text;
                        //make the AJAX Call
                        postStatusAjax(jsonData);

                     }
                } else if(question_type === "multiple_type"){
                    if(text === '') $('.topfbar').css("border-bottom", "solid 3px red");
                    else {
                        
                        var choice_a = $('#choice_a').val();
                        var choice_b = $('#choice_b').val();
                        console.log(choice_a);
                        console.log(choice_b);
                        if((choice_a != "") && (choice_b != "")){
                            question = {
                                'text' : question, 
                                'choice_a' : choice_a, 
                                'choice_b' : choice_b
                            }
                            var choice_c = $('#choice_c').val();
                            var choice_d = $('#choice_d').val()
                            if(choice_c != '') question.choice_c = choice_c;
                            if(choice_d != '') question.choice_d = choice_d;
                            correct_answer = 'a';
                            question.answer = correct_answer;
                            jsonData.question = question;
                            postStatusAjax(jsonData);


                        } else{
                            if(choice_a === ''){
                              $('#choice_a').css('border-bottom', 'solid 2px red');
                            } else if(choice_b === ''){
                              $('#choice_b').css('border-bottom', 'solid 2px red');
                            } else{
                              $('#choice_a').css('border-bottom', 'solid 2px red');
                              $('#choice_b').css('border-bottom', 'solid 2px red');
                            }

                        }
                    }

                } else if(question_type === "truth_type"){
                    if(text === '') $('.topfbar').css("border-bottom", "solid 3px red");
                    else {
                         correct_answer = 'ture';
                         question = {
                                'text' : question, 
                                'answer' : correct_answer
                         };
                         jsonData.question = question;
                         postStatusAjax(jsonData);


                    }

                } else {
                    alert("Something is wrong");
                }
                //Adds all expert tags into the array experts
               /* var experts  = $(".midfbar-exp .tag-name").map(function() {
                    return $(this).text();
                }).get();
                //adds experts to jsonData
                if (experts.length > 0) jsonData.ask_experts = experts;*/
                //Gets the top text

           
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