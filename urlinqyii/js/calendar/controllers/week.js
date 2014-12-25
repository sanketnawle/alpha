/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />
/// <reference path="../helpers/date.js" />
/// <reference path="../classes/week-grid.js" />
/// <reference path="../classes/key-control.js" />

ulcal.controller("WeekController", function ($scope, $routeParams, DateService, UCEventData) {
    LeftPanel.hidden = false;

    $scope.class = "week";
    $scope.title = "Week";

    var dateOfWeek = DateService.getDateOfWeek($routeParams.week, $routeParams.year);

    addDate(6).getDate() < 7 ? function () {
        $scope.setActiveMonth((dateOfWeek.getMonth() + 1) % 12);
        var year = dateOfWeek.getWeekYear();
        if ($scope.activeMonth == 0) year += 1;
        $scope.setActiveYear(year);
    }() : function () {
        $scope.setActiveMonth(dateOfWeek.getMonth());
        $scope.setActiveYear(dateOfWeek.getFullYear());
    }();

    $scope.setActiveWeek($routeParams.week);
    $scope.setActiveSem(new Date($scope.activeYear, $scope.activeMonth, 1).getSemester());

    function addDate(i) {
        var d = new Date(dateOfWeek.getTime());
        d.setDate(dateOfWeek.getDate() + i);
        return d;
    }

    $scope.getDate = function (i) { return addDate(i).getDate(); }

    $scope.getNextLink = function () {
        var next = addDate(9);
        return "#/week/" + next.getWeek() + "/" + next.getWeekYear();
    }

    $scope.getPrevLink = function () {
        var prev = addDate(-3);
        return "#/week/" + prev.getWeek() + "/" + prev.getWeekYear();
    }

    $scope.getTodayLink = function () {
        var date = new Date();
        return "#/week/" + date.getWeek() + "/" + date.getWeekYear();
    }

    window.grid = WeekGrid.createGrid("week-grid", dateOfWeek);

    (function LoadEvents(i) {
        if (i == 7) return;
        (function (i) {
            UCEventData.getData({ date: addDate(i).toDateInputValue() }).success(function (events) {
                events = events.events;
                for (e in events) {
                    grid.addEvent(new UCEvent(events[e]), i);
                }
                LoadEvents(++i);
            });
        }(i));
        setTimeout(function () {
            $(".grid-event").hover(function () {
                $(".grid-event").addClass("fade");
                $(this).removeClass("fade");
            }, function () {
                $(".grid-event").removeClass("fade");
            })
        }, 1000)
    }(0));

    $scope.setMiniMonth(dateOfWeek.getMonth(), dateOfWeek.getWeekYear(), "w");
})