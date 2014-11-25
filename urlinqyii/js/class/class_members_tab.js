
$(document).ready(function () {
    $.urlParam = function (sParam) {

        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++) {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam) {
                return sParameterName[1];
            }
        }

    }
    var class_id = $.urlParam('class_id');


    $(document).delegate(".searchMembers", "keyup", function (e) {

    var curstring = $(this).val().toLowerCase().trim();
    if (curstring.length >= 2) {
    $(".member").each(function () {
    var tagstring_obj = $(this).find(".search_unit");
    var tagstring = tagstring_obj.text().toLowerCase().trim();

    if (tagstring.indexOf(curstring) >= 0) {
    $(this).removeClass("hidden_result");
    } else {
    $(this).addClass("hidden_result");
    }


    /*control the text prompt of the div*/
    $(".members-list-wrap").each(function (index) {
    var l = $(this).find(".member").not('.hidden_result').length;
    if (l == 0) {
    $(this).prev(".blockwrapper").addClass("hidden_result");
    } else {
    $(this).prev(".blockwrapper").removeClass("hidden_result");
    }
    });
    /*control the text prompt of the div end*/

    });

    } else {
    $(".hidden_result").removeClass("hidden_result");
    }

    });


    $(document).delegate(".upgrade-student", "click", function () {

    var ta_user_id = $(this).closest(".member").attr("id");

    $.ajax({
    type: "POST",
    url: "php/add_class_ta.php",
    data: {ta_user_id: ta_user_id, class_id: class_id},
    success: function (html) {
    alert(html);
    alert(class_id);
    },
    error: function (html) {
    alert(html);
    }
    });

    if ($(this).hasClass("ta_already")) {
    $(this).removeClass("ta_already");
    var clone = $(this).closest(".member").clone();
    $(this).closest(".member").remove();
    $(".student-member-list").append(clone);

    //$(".members-admin").find("span").text();
    } else {
    $(this).addClass("ta_already");
    var clone = $(this).closest(".member").clone();
    $(this).closest(".member").remove();
    $(".prof-member-list").append(clone);
    }


    });

});
