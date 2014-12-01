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
    $('.tabclubs').on('click', function () {
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

