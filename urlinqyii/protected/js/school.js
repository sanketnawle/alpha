$(document).ready(function () {

    $('.tabFeed').on('click', function () {
        $('.departments-tab-content').hide();
        $('.members-tab-content').hide();
        $('.span_1_of_3').show();
        $('.span_2_of_3').show();
        $('.span_3_of_3').show();
        $('.clubs-tab-content').hide();
    });
    $('.tabDepartments').on('click', function () {
        $('.span_1_of_3').hide();
        $('.span_2_of_3').hide();
        $('.span_3_of_3').hide();
        $('.members-tab-content').hide();
        $('.departments-tab-content').show();
        $('.clubs-tab-content').hide();

    });
    $('.clubs-tab').on('click', function () {
        $('.span_1_of_3').hide();
        $('.span_2_of_3').hide();
        $('.span_3_of_3').hide();
        $('.members-tab-content').hide();
        $('.departments-tab-content').hide();
        $('.clubs-tab-content').show();

    });
    $('.members-tab').on('click', function () {
        $('.span_1_of_3').hide();
        $('.span_2_of_3').hide();
        $('.span_3_of_3').hide();
        $('.departments-tab-content').hide();
        $('.members-tab-content').show();
        $('.clubs-tab-content').hide();
    });

    $('.club_member').on('mouseenter', function(){
        $(this).parent('.group_join_wrap').children('.club_member').text("Leave Class");
    });

    $('.group_join_wrap' ).on( 'click', '.club_member',  function(){
        $(this).attr("class", "club_not_member");
        $(this).text("Join Class");
    });

    $('.group_join_wrap' ).on( 'click', '.club_not_member', function () { 
        $(this).attr("class", "club_member");
        $(this).text("Leave Class");
      });
    $('.club_member').on('mouseleave', function(){
        $(this).parent('.group_join_wrap').children('.club_member').text("Member");
    });

    $('.tabclubs').on('mouseover', function(){
        $('#club_icon').css({
            "transition" : 0,
            "background-image": 'url(../css/school/school_alpha/src/club_icon.png)',
           "background-position": "0px -19px",
           "top": 1
        });
    });
     $('.tabclubs').on('mouseleave', function(){
        $('#club_icon').css({
            "transition" : 0,
            "background-image": 'url(../css/school/school_alpha/src/club_icon.png)',
           "background-position": "0px 0px",
           "top": 1
        });
    });
    //////
    $('.member_tab_member').on('mouseenter', function(){
        $(this).parent('.member_following_wrap').children('.member_tab_member').text("Unfollow");
    });

    $('.member_following_wrap' ).on( 'click', '.member_tab_member',  function(){
        $(this).attr("class", "member_tab_not_member");
        $(this).text("Follow");
    });
    
    $('.member_following_wrap' ).on( 'click', '.member_tab_not_member', function () { 
        $(this).attr("class", "member_tab_member");
        $(this).text("Unfollow");
      });

    $('.member_tab_member').on('mouseleave', function(){
        $(this).parent('.member_following_wrap').children('.member_tab_member').text("Followed");
    });
 

    $(function () {
//        $(".btn_follow").click(function () {
//
//
//            if ($(this).hasClass("followed")) {
//                $(this).removeClass("followed");
//                $(this).html("Follow");
//            } else {
//                $(this).addClass("followed");
//                $(this).html("Unfollow");
//            }
//        });
        $(".dept_following").change(function(){
            var department_id = $(this).attr('data-department_id');
            var option = $(this).find('option:selected');
            var selected_val = $(option).text();
            // var dept_id = mydiv.getAttribute("data-deptid");
            alert(selected_val + ' ' +  department_id);
            ////  alert (selected_val);
            $.ajax({
                type: "POST",
                url: base_url + '/school/followDept',
                data: {selected: selected_val, department_id: department_id},
                success: function(data) {
                    alert (data)
                },
                error: function(data) {
                    alert ("error")
                }
            });
        });


        $(".member_following").change(function(){
            var member_id = $(this).attr('data-member_id');
            var option = $(this).find('option:selected');
            var selected_val = $(option).text();
            // var dept_id = mydiv.getAttribute("data-deptid");
            alert(selected_val + ' ' +  member_id);
            ////  alert (selected_val);
            $.ajax({
                type: "POST",
                url: base_url + '/school/followMember',
                data: {selected: selected_val, member_id: member_id},
                success: function(data) {
                    alert (data)
                },
                error: function(data) {
                    alert ("error")
                }
            });
        });

        $(".group_join").change(function(){
            var group_id = $(this).attr('data-group_id');
            var option = $(this).find('option:selected');
            var selected_val = $(option).text();
            // var dept_id = mydiv.getAttribute("data-deptid");
            alert(selected_val + ' ' +  group_id);
            ////  alert (selected_val);
            $.ajax({
                type: "POST",
                url: base_url + '/school/joinGroup',
                data: {selected: selected_val, group_id: group_id},
                success: function(data) {
                    alert (data)
                },
                error: function(data) {
                    alert ("error")
                }
            });
        });
    })

});

