(function ($) {
    var leftPanelOpen = true;
    openNotify = null;
    var actionTitle = "";

    var weekDays = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    $(function () {
        $(".topbar .center form")
            .click(function () { $(".text", $(this)).focus(); })
            .submit(function (e) {
                if ($(".text", $(this)).val().trim() == "") {
                    e.preventDefault();
                    return false;
                }
            });
        $(".topbar .center form .text").on("focus", function () {
            var text = $(this);
            if (text.val().trim() == "") text.closest(".center").find(".prelist").show();
            else text.closest(".center").find(".postlist").show();
        }).on("blur", function () {
            $(this).closest(".center").find(".prelist").hide();
            $(this).closest(".center").find(".postlist").hide();
        }).on("keyup", function (e) {
            e = e || event;
            var text = $(this);
            var postlist = text.closest(".center").find(".postlist");
            if (e.keyCode == 27) {
                text.val("");
                text.trigger("blur");
            } else if (text.val().trim() == "") {
                postlist.hide();
                text.closest(".center").find(".prelist").show();
            } else {
                var query = text.val().trim();
                $.ajax({
                    url: "lptopbar_search.php",
                    data: {
                        q: query,
                        ajax: true
                    },
                    success: function (result) {                        
                        result = eval(result);
                        postlist.html("");
                        result.forEach(function (e) {
                            var link = $("<a />");
                            var href = "../"; // change to ./ once you are in root
                            var cls = "src";
                            switch (e.type) {
                                case "pro":
                                case "stu":
                                    href += "profile.php?user_id=";
                                    cls = "pro";
                                    break;
                                case "cls":
                                    href += "courses.php?user_id=";
                                    cls = "cls";
                                    break;
                                case "dpt":
                                    href += "department.php?user_id=";
                                    cls = "dpt";
                                    break;
                                case "clb":
                                    href += "clubs.php?user_id=";
                                    cls = "clb";
                                    break;
                            }                            
                            link.attr("href", href + e.id);

                            var disp = e.name.replace(new RegExp("(" + query + ")", "ig"), "<b>$1</b>");

                            link.append($("<div class='icon " + cls + "'><div>")).append("<span>" + disp + "</span>");
                            postlist.append($("<li />").append(link));
                        });
                        postlist.append("<li><a href='search_beta.php?query=" + query + "'>" +
                            "Seee all results for \"" + query + "\"</a></li>");
                    }
                })
                text.closest(".center").find(".postlist").show();
                text.closest(".center").find(".prelist").hide();
            }
        });
        $(".leftpanel .scrollable .title").click(function () {
            var title = $(this);
            var clubs = $(".leftpanel .scrollable.club");
            var classes = $(".leftpanel .scrollable.class");
            (title.parents(".scrollable")[0] == classes[0] ? function () {
                //classes.toggleClass("min");
                // case 1: 50 50
                if (!(classes.hasClass("full") || classes.hasClass("min"))) {
                    classes.addClass("min");
                    clubs.addClass("full");
                } else if (classes.hasClass("min")) {
                    if (clubs.hasClass("min")) {
                        classes.removeClass("min").addClass("full");
                    } else {
                        classes.removeClass("min");
                        clubs.removeClass("full");
                    }
                } else if (classes.hasClass("full")) {
                    classes.removeClass("full").addClass("min");
                }
            } : function () {
                if (!(clubs.hasClass("full") || clubs.hasClass("min"))) {
                    clubs.addClass("min");
                    classes.addClass("full");
                } else if (clubs.hasClass("min")) {
                    if (classes.hasClass("min")) {
                        clubs.removeClass("min").addClass("full");
                    } else {
                        clubs.removeClass("min");
                        classes.removeClass("full");
                    }
                } else if (clubs.hasClass("full")) {
                    clubs.removeClass("full").addClass("min");
                }
            })();
        });
        $(".notify-window .column ul .check").click(function () {
            $(this).toggleClass("done")
            $(".event-check", $(this))[0].checked = $(this).hasClass("done");
        })
        $(".leftpanel .scrollable ul, .notify-window .column ul").mCustomScrollbar({
            theme: "minimal-dark",
            scrollInertia: 100
        })
        $(".leftpanel .profile .title").click(function () {
            var menu = $(".menu", $(this));
            var profilemenu = $(".profile-menu", $(this).parents(".profile"));
            menu.hasClass("open") ? (function () {
                menu.removeClass("open")
                    .css({ "background-image": "url(img/menu-x-bar.gif?p" + new Date().getTime().toString() + ")" });
                profilemenu.removeClass("open");
            }()) : (function () {
                menu.addClass("open")
                    .css({ "background-image": "url(img/menu-bar-x.gif?p" + new Date().getTime().toString() + ")" });
                profilemenu.addClass("open");
            }());
        });
        function toggleMenu(active) {
            var menu = $(".topbar .left a.menu");
            var leftpanel = $(".leftpanel");

            if (active) menu.addClass("active");
            else menu.removeClass("active");

            menu.hasClass("active") ? (function () {
                leftpanel.show();
            }()) : (function () {
                leftpanel.hide();
            }());
        }
        $(".topbar .left a.menu").click(function () {
            leftPanelOpen = $(this).toggleClass("active").hasClass("active")
            toggleMenu(leftPanelOpen);
        });
        $(".topbar .right .day").html(weekDays[new Date().getDay()]);
        $(".topbar .right .date").html(new Date().getDate());
        $(window).resize(function () {
            if ($(window).width() < 1250) toggleMenu(false);
            else if (leftPanelOpen) toggleMenu(true);
        })
        $(".notify-window .column ul li .action").hover(function () {
            var action = $(this);
            actionTitle = action.attr("title");
            action.removeAttr("title");
            var nottooltip = $("<div class='nottooltip' />").html(
                '<div class="tooltip">' +
                    '<div class="ttwedge"></div>' +
                    '<div class="ttcontent">' + actionTitle + '</div>' +
                '</div>');
            var icon = $(this);
            nottooltip.css({ "top": icon.offset().top, "left": icon.offset().left + icon.outerWidth() });
            $("body").append(nottooltip);
        }, function () {
            $(this).attr("title", actionTitle);
            $("div.nottooltip").remove();
        });
        $(".topbar .notify").mouseenter(function (e) {
            var notify = $(this);//.parents(".notify");
            if (openNotify !== notify[0]) {
                var window = null;
                $(".topbar .notify").removeClass("active");
                $(".topbar .notify-window").hide();
                notify.addClass("active");
                if (notify.hasClass("calendar")) window = $(".topbar .notify-window.calendar");
                else if (notify.hasClass("board")) window = $(".topbar .notify-window.board");

                if (openNotify === null) window.slideDown(150);
                else window.show();

                openNotify = notify[0];
            }
        })
        $(".topbar .right").mouseleave(function () {
            $(".topbar .notify").removeClass("active");
            $(".topbar .notify-window").slideUp(150);
            openNotify = null;
        })

        $(".notify-window .toolbar li").click(function () {
            $(".notify-window .toolbar li").removeClass("active");
            $(this).addClass("active");
            var col = $(this).data("column");
            if (col) {
                var window = $(this).parents(".notify-window");
                $(".column", window).hide();
                $(".column." + col, window).show();
            }
        })
        $(window).resize();
    });
})(jQuery);