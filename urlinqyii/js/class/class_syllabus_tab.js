$(document).ready(function(){
	$('#syllabus_event_order_date').click(function(){
		$(this).closest(".class_events_holder").removeClass("order_kind");
		$(this).closest(".class_events_holder").addClass("order_date");
	});

	$('#syllabus_event_order_kind').click(function(){
		$(this).closest(".class_events_holder").removeClass("order_date");
		$(this).closest(".class_events_holder").addClass("order_kind");

	});

    $('.menu').dropit();
    


    $("#page").scroll(function() {
        console.log($("#page").scrollTop());
    });

    $('div.complete_incomplete_button.active').click(function(){
        var $checkbox = $(this);
        var $tooltip = $(this).find(".help-box");
        if($checkbox.hasClass("incomplete")){
            $checkbox.removeClass("incomplete");
            $tooltip.text("Mark as Incomplete");

        }
        else{
            $checkbox.addClass("incomplete");
            $tooltip.text("Mark as Complete");
        }
    });


    $('.syllabus_event_order').click(function(){
        var $selected_order = $(this);
        var selected_order_text = $selected_order.find("a").text();
        $("#selected_syllabus_event_order").text(selected_order_text);
    });

    $('.day_box_color').each(function(){
        var colors = ["#f6932b","#60dd29","#3ab9f7","#fcc827","#f0405b","#ab7f4c","#83B233","#9612D7","#2F52BE","2FBE72","#F76700","#F7EA00","#EA2B4F","#383737","#5BA2DD","#13D298"];            
        var color = colors[Math.floor(colors.length * Math.random())];
        if(color != lastColor){
            $(this).css({"background-color":color});
        }
        var lastColor = color;
    });
});