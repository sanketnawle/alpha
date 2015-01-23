
if (origin_type == "club"){
    $("ul[data-group='clubs'] a[data-group_id='" + origin_id + "']").addClass("current_group");
}

if (origin_type == "class"){
    $("ul[data-group='classes'] a[data-class_id='" + origin_id + "']").addClass("current_group");
}