$(function() {
	$("input.email").keyup(function() {
		var input = document.getElementById("email").value;
		if (input.indexOf('colum') > -1) {
			$(".columbia-bgd").fadeIn(50);
		} else if (input.indexOf('nyu') > -1) {
			if (input.indexOf('ste') > -1) {
				$(".stern-bgd").fadeIn(50);
			} else {
				$(".nyu-bgd").fadeIn(50);
			}
		} else if (input.indexOf('rochest') > -1) {
			$(".rochester-bgd").fadeIn(50);
		} else if (input.indexOf('tour') > -1) {
			$(".touro-bgd").fadeIn(50);
		} else {
			$(".columbia-bgd").fadeOut(50);
			$(".nyu-bgd").fadeOut(50);
			$(".stern-bgd").fadeOut(50);
			$(".rochester-bgd").fadeOut(50);
			$(".touro-bgd").fadeOut(50);
		}
	});



    $(window).scroll(function() {
        var y=$(this).scrollTop()*0.002;
        var opacityShift = y*1;
        $("div.mobile_wrap_primary").css({"opacity":1-opacityShift});
    });

	$("input#beta_testing_email").focus(function() {
		$(this).addClass("beta_email_focused");
		$(this).closest("#beta_testing_signup").find(".beta_signup_submit").addClass("beta_email_focused");
	});	
});