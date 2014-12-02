//$(document).on("click", ".commentform", function(){
//    console.log("I AM WORKING");
//    alert('kajslkas');
//});
$(document).ready(function(e) {
//    var $ = jQuery;
    $(document).on("click", ".commentform", function(){
        console.log("I AM WORKING");
        alert('kajslkas');
    });

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

    $(document).delegate(".post_functions_showr", "click", function () {
        if ($(this).closest(".post_functions").hasClass("functions_active")) {
            $(this).closest(".post_functions").find(".post_functions_box").hide();
            $(this).closest(".post_functions").removeClass("functions_active");
        } else {
            $(this).closest(".post_functions").find(".post_functions_box").show();
            $(this).closest(".post_functions").addClass("functions_active");
        }
    });

    var fileList = {};
    var fileCount = 0;

    $(".form-control").on("focus", function FormControlFocus () {
        alert('laksjdaksjd');
        var attr = $(this).attr("focused");
        if(typeof attr === undefined || attr === false || attr === undefined || !attr) {
            var ta = $(this);

            ta.attr("focused", "yes");

            ta.css({"min-height": 65, "padding-bottom": 21, "padding-left": 0});

            ta.parents(".postcomment").find(".comment_owner_container").show();
            ta.closest(".postcomment").find(".reply_user_icon").hide();
            ta.closest(".commentform").find(".dragdrop_functions").show();
            ta.closest(".commentform").find(".reply_functions").show();
            ta.closest(".posts").find(".feed_upload_textprompt").show();
        }
    });

    $(".form-control").on("keyup", function (e) {
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

            ta.parents(".postcomment").find(".comment_owner_container").hide();
            ta.closest(".postcomment").find(".reply_user_icon").show();
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
            $(this).css({"border": "1px solid #00A076", "background-color": "#02e2a7"});
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
        var fa = $(this).closest(".posts").find(".form-control");
        setTimeout(function () { fa.trigger("focus"); }, 1);
    });

    var load = 'yes';
    var feeds = $("#posts");
    var last_time = 0;
    var heightOffset = 550;
    var pg = 1;


    $(document).delegate('.post_functions', "click", function () {
        $(this).find('.post_functions_box').show();
        $(this).addClass('functions_active');
    });

    $(document).delegate('.functions_active', "click", function () {

        //ajax add here

        //appearance change when click
        $(this).find('.post_functions_box').hide();
        $(this).removeClass('functions_active');
    });


    $(window).scroll(function () {
        ////alert($(window).scrollTop() + heightOffset >= $(document).height() - $(window).height());
        if (load == 'yes') {

            if ($(window).scrollTop() + heightOffset >= $(document).height() - $(window).height()) {
                ////alert(heightOffset);
                load = 'no';
                pg = pg + 1;
                last_time = $("#posts").children().last().attr('id');
                var $ref = $("#posts");
                var pullrequest = $.ajax({
                    type: "POST",
                    url: "oldfeed.php",
                    cache: false,
                    data: {last_time: last_time,
                        pg: pg

                    },
                    datatype: "html"
                });
                pullrequest.done(function (html) {
                    $ref.last().append(html);
                    load = 'yes';
            
                    $(".new_fd").each(function (index) {

                        $(this).removeClass("new_fd");
                        if ($(this).find(".f_hidden_p").text().trim() != "") {
                            $(this).find('.play').embedly({
                                query: {
                                    maxwidth: 500,
                                    autoplay: true
                                },
                                display: function (data, elem) {

//Adds the image to the a tag and then sets up the sizing.
                                    $(elem).html('<img src="' + data.thumbnail_url + '"/>')
                                        .width(data.thumbnail_width)
                                        .height(data.thumbnail_height)
                                        .find('span').css('top', data.thumbnail_height / 2 - 36)
                                        .css('left', data.thumbnail_width / 2 - 36);
////alert($(elem).html());
                                    var $elhtml = $(elem).html();
                                    $(elem).closest(".post_lr_link_msg").find(".link-img").html($elhtml);

                                    var t_title = data.title;
                                    var t_des = data.description;
                                    var t_url = data.url;
////alert(data.title+" , "+data.description+", "+data.url);
                                    var ctt = t_title + "<span class='link-text-website'>" + t_url + "</span>";

                                    $(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
                                    $(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

                                    if (data.type === 'video') {

                                    } else {
                                        $(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
                                    }

                                }
                            }).on('click', function () {
// Handles the click event and replaces the link with the video.
                                var data = $(this).data('embedly');

                                if (data.type === 'video') {
                                    $(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
                                    return false;
                                } else {
                                    window.open(data.url, '_blank');
                                }

                            });

                        }

                    });


                });
            }
        }
    });



    $.embedly.defaults.key = '110869001b274ee0a51767da08dafeef';

    $(".new_fd").each(function (index) {

        $(this).removeClass("new_fd");
        if ($(this).find(".f_hidden_p").text().trim() != "") {
            jQuery('.f_hidden_p a').embedly({
                query: {
                    maxwidth: 500,
                    autoplay: true
                },
                display:function(data, elem){
                    console.log(data);
                    if(data.type != 'video') $('.play_btn').hide();
                    $('.link-text-title').text(data.title);
                    if(data.thumbnail_url){
                        console.log('here');
                        if((data.thumbnail_width > 550) && (data.thumbnail_height> 270)) {
                            jQuery('.link-img').css({
                                'background' :  'url(' + data.thumbnail_url + ')',
                                'height' : 273,
                                'width' : 555,
                                'background-size' : 'cover'
                            });

                            jQuery('.link-text-data').css({
                                'position' : 'relative',
                                'top': 162,
                                'left' : 1,
                                'height' : 110,
                                'width' : 414

                            });
                            jQuery('.link-text-about').css({
                                'position' : 'relative',
                                'top': -260,
                                'left' :-140,
                                'width' : 545
                            });
                            jQuery('.link-text-title').css({
                                'position' : 'relative',
                                'top' : -265,
                                'left' : -140
                            })

                            //}
                        }
                        else {
                            jQuery('.link-img').css({
                                'background' :  'url(' + data.thumbnail_url + ')',
                                'height' : 139,
                                'width' :150,
                                'background-size' : 'cover'
                            });

                        }
                        var thumbnail_url = data.thumbnail_url;
                        $('.link-text-about').text(data.description + " " + data.original_url);
                        // jQuery('.post_msg .msg_span').append("<br> <a href=" + data.original_url + ">" + data.original_url + "</a>");


                    }
                    else {
                        //this or
                        jQuery('.link-img').css({
                            'background' :  'url(' + 'http://www.urlinq.com/beta/DefaultImages/anon.png' + ')',
                            'height' : 139,
                            'width' :150,
                            'background-size' : 'cover'
                        });

                        // jQuery('.link-img').removeClass();
                        if(data.description){
                            jQuery('.link-text-about').text(data.description + " " +data.original_url);
                        }
                        else {
                            jQuery('.link-text-about').text(data.original_url);
                        }

                    }

                    $('.link-wrapper').on('click', function () {
// Handles the click event and replaces the link with the video.


                        if (data.type === 'video') {
                            $(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
                            return false;
                        } else {

                            window.open(data.url, '_blank');
                        }

                    });


                    /*.on('click', function(){
                     console.log('clicked');
                     if(data.type == 'video'){
                     //var htmlString = "<iframe src=" + data.original_url + "></iframe>";
                     $('.link-wrapper').load(data.original_url);
                     }
                     });*/

                }
            });

            /*$(this).find('.play').embedly({
             query: {
             maxwidth: 500,
             autoplay: true
             },
             display: function (data, elem) {
             console.log(data);

             //Adds the image to the a tag and then sets up the sizing.
             $(elem).html('<img src="' + data.thumbnail_url + '"/>')
             .width(data.thumbnail_width)
             .height(data.thumbnail_height)
             .find('span').css('top', data.thumbnail_height / 2 - 36)
             .css('left', data.thumbnail_width / 2 - 36);
             ////alert($(elem).html());
             var $elhtml = $(elem).html();
             $(elem).closest(".post_lr_link_msg").find(".link-img").html($elhtml);

             var t_title = data.title;
             var t_des = data.description;
             var t_url = data.url;
             ////alert(data.title+" , "+data.description+", "+data.url);
             var ctt = t_title + "<span class='link-text-website'>" + t_url + "</span>";

             $(elem).closest(".post_lr_link_msg").find(".link-text-title").html(ctt);
             $(elem).closest(".post_lr_link_msg").find(".link-text-about").html(t_des);

             if (data.type === 'video') {

             } else {
             $(elem).closest(".post_lr_link_msg").find(".play_btn").hide();
             }

             }
             }).on('click', function () {
             // Handles the click event and replaces the link with the video.
             var data = $(this).data('embedly');

             if (data.type === 'video') {
             $(this).closest(".post_lr_link_msg").find(".link-wrapper").replaceWith(data.html);
             return false;
             } else {
             window.open(data.url, '_blank');
             }

             });*/

        }

    });


    $(document).delegate('.playable_wrap', "click", function () {
        $(this).closest(".post_lr_link_msg").find(".play").click();
    });


    setTimeout(function () {
        //latest_feed();
    }, 5000);

});
