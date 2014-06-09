(document).ready(function() {
    setInterval("check_event_in_hour()", 1000);
    setInterval("check_group_event()", 1000);
});

function event_notification() {
    $.ajax({
        type: "POST",
        url: "event_notification_first_login.php",
        success: function(response) {
            var data = jQuery.parseJSON(response);
            show_day_notification(data);
        }
    });
}

function check_group_event() {
    $.ajax({
        type: "POST",
        url: "check_event_in_hour.php",
        success: function(response) {
            var data = jQuery.parseJSON(response);
            show_event(data);
        }
    });
}

function check_event_in_hour() {
    $.ajax({
        type: "POST",
        url: "check_event_in_hour.php",
        success: function(response) {
            var data = jQuery.parseJSON(response);
            show_event(data);
        }
    });
}

function show_event(data) {
    var event_array = data['event_array'];

    for (var value in event_array) {

    }
}

function show_day_notification(data) {
    var today_event = data['today_event'];
    var week_event = data['week_event'];
    var exam_event = data['exam_event'];

    var count = today_event.length + week_event.length + exam_event.length;

    for (var value in today_event) {

    }

    for (var value in week_event) {

    }

    for (var value in exam_event) {

    }
}
