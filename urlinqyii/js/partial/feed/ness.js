//$(document).on("click", ".commentform", function(){
//    console.log("I AM WORKING");
//    alert('kajslkas');
//});
$(document).ready(function(e) {


    

      
//    var $ = jQuery;
   // $(document).on("click", ".commentform", function(){
     //   console.log("I AM WORKING");
      //  alert('kajslkas');
   // });

    //index 0 = A, 1 = B, 2 = C, 3 = D
    var old_width_vals = ["", "", "", ""];
    old_width_vals[0] = $("#Aexpanding").width();
    old_width_vals[1] = $("#Bexpanding").width();
    old_width_vals[2] = $("#Cexpanding").width();
    old_width_vals[3] = $("#Dexpanding").width();
    $('.mc_question_radio_button').on('click', function(){

        $('.mc_question_choice_letter').css("background-color", "grey");
        $(this).siblings('.mc_question_choice_letter').css("background-color", 'black');
        var new_width = $(this).siblings('.mc_question_choice_text').children('.choice_text').width();
        var percent = (new_width/425.4)*100;
        percent += 2;


        // new_width += 10;

        //console.log(new_width);
        $("#Aexpanding").css({
            "width" : old_width_vals[0],
            "transition" : '1s'
        });

        $("#Bexpanding").css({
            "width" : old_width_vals[1],
            "transition" : '1s'
        });
        $("#Cexpanding").css({
            "width" : old_width_vals[2],
            "transition" : '1s'
        });
        $("#Dexpanding").css({
            "width" : old_width_vals[2],
            "transition" : '1s'
        });

        $(this).siblings('.mc_question_choice_text').children('.choice_text').css({
            "width" : percent + "%",
            "transition" : '1s'});
    });

    $('.profile_thumbnail_no_pic').on('mouseover', function(){
        $(this).siblings('.list_of_people').css('visibility', 'visible');

    });
    $('.profile_thumbnail_no_pic').on('mouseout', function(){
        $('.list_of_people').css('visibility', 'hidden');
    });

    $(document).delegate(".post_functions_showr.shower", "mousedown", function () {
        var $post_functions_showr = $(this);
        $post_functions_showr.removeClass("shower");
        $post_functions_showr.addClass("hider");
        $post_functions_showr.closest(".post_functions").addClass("functions_active");
    });

    $(document).delegate(".post_functions_showr.hider", "mousedown", function () {
        var $post_functions_showr = $(this);
        $post_functions_showr.removeClass("hider");
        $post_functions_showr.addClass("shower");
        $post_functions_showr.closest(".post_functions").removeClass("functions_active");
    });


    var fileList = {};
    var fileCount = 0;

    $(document).on("focus", ".form-control", function () {
        var attr = $(this).attr("focused");
        if(typeof attr === undefined || attr === false || attr === undefined || !attr) {
            var ta = $(this);

            ta.attr("focused", "yes");
            $(".or_answer_div").hide();
            ta.css({"min-height": 65, "padding-bottom": 21, "padding-left": 0});
            ta.parents(".postcomment").find(".pre_expand_comment_fx").hide();
            ta.parents(".postcomment").find(".comment_owner_container").show();
            ta.closest(".postcomment").find(".reply_user_icon").hide();
            ta.closest(".commentform").find(".dragdrop_functions").show();
            ta.closest(".commentform").find(".reply_functions").show();
            ta.closest(".posts").find(".feed_upload_textprompt").show();
        }
    });

    $(document).on("click", 'span.answer_section_flash', function(){
        var $mc_question_answers = $(this).closest(".post").find(".mc_question_one_choice");
        $mc_question_answers.css({"border-color":"rgb(45, 171, 228)"});
        setTimeout(function(){$mc_question_answers.css({"border-color":"rgba(239, 239, 239, 0.72)"})}, 1500);
    });

    $(document).on("keyup",".form-control", function (e) {
        e = e || event;
        
        if(e.keyCode == 13 && !e.shiftKey) {
            $(this).closest(".commentform").find(".reply_button").click();
            e.preventDefault();
            return false;
        }
        var ta = $(this)[0];
        $(ta).css("height", 0);
        if(ta.scrollHeight > ta.offsetHeight) {
            $(ta).css({"height": ta.scrollHeight});
        }
    });

    function stopDoing(e) {
        e.stopPropagation();
        e.preventDefault();
    }

    function handleFiles(files, ele) {
        fileList[fileCount] = files[0];
        var status = new FileEntry(ele, fileCount);
        status.setFileNameSize(files[0].name, files[0].size);
        ++fileCount;
    }

    function FileEntry(ele, i) {
        this.statusbar = $("<div class='status center' data-id='" + i + "' />");
        this.filename = $("<span class='left' />").appendTo(this.statusbar);
        this.close = $("<span class='close'>x</span>").appendTo(this.statusbar);
        this.size = $("<span class='right' />").appendTo(this.statusbar);
        var sb = this.statusbar;
        this.close.click(function () {
            delete fileList[i];
            sb.remove();
            ele.siblings(".fileinputbox, .dragdropbox").show();
            var control = ele.siblings(".fileinputbox .fileinput");
            control.wrap('<form />').parent('form').trigger('reset');
            control.unwrap();
        });
        ele.append(this.statusbar);
        ele.siblings(".fileinputbox, .dragdropbox").hide();
        this.setFileNameSize = function (name, size) {
            var sizeKB = size / 1024;
            var sizeStr = parseInt(sizeKB) > 1024 ? (sizeKB / 1024).toFixed(2) + " MB" : sizeKB.toFixed(2) + " KB";
            this.filename.html(name);
            this.size.html(sizeStr);
        }
    }

    $(".fileinput").change(function () {
        handleFiles($(this).prop("files"), $(this).parent().siblings(".filelistbox"));
    });

    var dragOrigText = "Drag and drop a file here or Click to upload a file";
    var dragEnterText = "Drop your file here";
    var dragLeaveText = "Drag your file here";
    var dragOnTarget = 0;
    $(".dragdropbox")
        .on("dragenter", function (e) {
            dragOnTarget += 1;
            stopDoing(e);
            $(this).addClass("dragenter");
            $(this).html(dragEnterText);
        })
        .on("dragleave", function (e) {
            dragOnTarget -= 1;
            $(this).removeClass("dragenter");
            $(this).html(dragLeaveText);
        })
        .on("dragover", function (e) {
            stopDoing(e);
        })
        .on("drop", function (e) {
            $(this).removeClass("dragenter");
            stopDoing(e);
            $(".dragdropbox").html(dragOrigText);
            handleFiles(e.originalEvent.dataTransfer.files, $(this).siblings(".filelistbox"));
        })
        .click(function () {
            $(this).siblings(".fileinputbox").find(".fileinput").click();
        });

    var collection = $();


    $(document).on("dragenter", function(e) {
        stopDoing(e);
        if(collection. length === 0) $(".dragdropbox").html(dragLeaveText);
        collection = collection.add(e.target)
    }).on("dragleave drop", function(e) {
        stopDoing(e);
        collection = collection.not(e.target);
        if(collection.length === 0 && dragOnTarget === 0) $(".dragdropbox").html(dragOrigText);
    });

    $(document).click(function (e) {
        var container = $(".commentform");
        if(!container.is(e.target) && container.has(e.target).length === 0) {
            var ata = $(this).find(".form-control");
            ata.each(function(){ minimizeCommentForm($(this)); });
        }
    });

    function minimizeCommentForm(ta) {
        var fl = ta.closest(".postcomment").find(".filelistbox").find(".status");
        if(ta.val().trim() == "" && fl.length == 0) {
            ta.removeAttr("focused");
            $(".or_answer_div").show();
            ta.parents(".postcomment").find(".comment_owner_container").hide();
            ta.closest(".postcomment").find(".reply_user_icon").show();
            ta.parents(".postcomment").find(".pre_expand_comment_fx").show();
            ta.closest(".commentform").find(".dragdrop_functions").hide();
            ta.closest(".commentform").find(".reply_functions").hide();
            ta.closest(".posts").find(".feed_upload_textprompt").hide();

            ta.removeAttr("style");
        }
    }

    // $(document).delegate(".postcomment", "click", function(e) {
    //     var attr = $(this).find(".form-control").attr("focused");
    //     if(typeof attr !== undefined && attr !== false) {
    //         e.preventDefault();
    //         return false;
    //     }
    // });

    $(document).delegate(".flat7b", "click", function (event) {

        if (!$(this).hasClass("flat_checked")) {
            $(this).css({"border": "1px solid #333", "background-color": "#999"});
            $(this).closest(".check_wrap").find(".move").css({"margin-left": "19px"});
            $(this).addClass("flat_checked");
            $(this).closest(".check_wrap").find(".comment_anon_text").css("color", "rgba(33,33,33,.85)");
            $(this).closest(".posts").find(".post_anon_val").val("1");
        } else {
            $(this).css({"border": "1px solid #C9C9C9", "background-color": "#f5f5f5"});
            $(this).closest(".check_wrap").find(".move").css({"margin-left": "0px"});
            $(this).removeClass("flat_checked");
            $(this).closest(".check_wrap").find(".comment_anon_text").css("color", "rgba(153, 153, 153, 0.64)");
            $(this).closest(".posts").find(".post_anon_val").val("0");
        }
    });

    
    $(document).delegate(".post_comment_btn", "click", function () {
        var fa = $(this).closest(".post").find(".form-control");
        setTimeout(function () { fa.trigger("focus"); }, 1);

    });



    var load = 'yes';
    var feeds = $("#posts");
    var last_time = 0;
    var heightOffset = 550;
    var pg = 1;




//    $(window).scroll(function () {
//        ////alert($(window).scrollTop() + heightOffset >= $(document).height() - $(window).height());
//        if (load == 'yes') {
//
//            if ($(window).scrollTop() + heightOffset >= $(document).height() - $(window).height()) {
//                ////alert(heightOffset);
//                load = 'no';
//                pg = pg + 1;
//                last_time = $("#posts").children().last().attr('id');
//                var $ref = $("#posts");
//                var pullrequest = $.ajax({
//                    type: "POST",
//                    url: "oldfeed.php",
//                    cache: false,
//                    data: {last_time: last_time,
//                        pg: pg
//
//                    },
//                    datatype: "html"
//                });
//                pullrequest.done(function (html) {
//                    $ref.last().append(html);
//                    load = 'yes';
//
//                    $(".new_fd").each(function (index) {
//
//                        $(this).removeClass("new_fd");
//                        if ($(this).find(".f_hidden_p").text().trim() != "") {
//                            $(this).find('.play').embedly({
//                                query: {
//                                    maxwidth: 500,
//                                    autoplay: true
//                                },
//                                display: function (data, elem) {
//
////Adds the image to the a tag and then sets up the sizing.
//                                    $(elem).html('<img src="' + data.thumbnail_url + '"/>')
//                                        .width(data.thumbnail_width)
//                                        .height(data.thumbnail_height)
//                                        .find('span').css('top', data.thumbnail_height / 2 - 36)
//                                        .css('left', data.thumbnail_width / 2 - 36);
//////alert($(elem).html());
//                                    var $elhtml = $(elem).html();
//                                    $(elem).closest(".post_lr_link_msg").find(".link-img").html($elhtml);
//
//                                    var t_title = data.title;
//                                    var t_des = data.description;
//                                    var t_url = data.url;
//////alert(data.title+" , "+data.description+", "+data.url);
//                                    var ctt = t_title + "<span class='link-text-website'>" + t_url + "</span>";
//
//                                    $(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
//                                    $(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);
//
//                                    if (data.type === 'video') {
//
//                                    } else {
//                                        $(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
//                                    }
//
//                                }
//                            }).on('click', function () {
//// Handles the click event and replaces the link with the video.
//                                var data = $(this).data('embedly');
//
//                                if (data.type === 'video') {
//                                    $(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
//                                    return false;
//                                } else {
//                                    window.open(data.url, '_blank');
//                                }
//
//                            });
//
//                        }
//
//                    });
//
//
//                });
//            }
//        }
//    });



  

    setTimeout(function () {
        //latest_feed();
    }, 5000);

});