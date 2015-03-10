$(function() {
	$("input.email").keyup(function() {
		var input = document.getElementById("email").value;
		if (input.indexOf('columbia') > -1) {
			$(".columbia-bgd").fadeIn(1000);
		} else if (input.indexOf('nyu') > -1) {
			if (input.indexOf('stern') > -1) {
				$(".stern-bgd").fadeIn(1000);
			} else {
				$(".nyu-bgd").fadeIn(1000);
			}
		} else if (input.indexOf('rochester') > -1) {
			$(".rochester-bgd").fadeIn(1000);
		} else {
			$(".columbia-bgd").fadeOut(1000);
			$(".nyu-bgd").fadeOut(1000);
			$(".stern-bgd").fadeOut(1000);
			$(".rochester-bgd").fadeOut(1000);
		}
	});
});