$(document).ready(function(){
	$('#syllabus_event_order_date').click(function(){
		$(this).closest(".class_events_holder").removeClass("order_kind");
		$(this).closest(".class_events_holder").addClass("order_date");
	});

	$('#syllabus_event_order_kind').click(function(){
		$(this).closest(".class_events_holder").removeClass("order_date");
		$(this).closest(".class_events_holder").addClass("order_kind");

	});


});