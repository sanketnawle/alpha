$(".topbar .notify").hover(function () {
    var notify = $(this);//.parents(".notify");
    if (openNotify !== notify[0]) {
        console.log("I am in", openNotify, notify);
        notify.toggleClass("active");

        if (notify.hasClass("calendar")) {
            $(".notify-window.calendar").stop().slideToggle(150);
        } else if (notify.hasClass("board")) {
            $(".notify-window.board").stop().slideToggle(150);
        }
        openNotify = notify[0];
    } else {
        openNotify = null;
    }
}, function () {
    $(".topbar .notify").removeClass("active");
    $(".notify-window").slideUp(150);
    openNotify = null;
});