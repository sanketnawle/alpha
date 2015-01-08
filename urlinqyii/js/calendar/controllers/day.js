/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />
/// <reference path="../helpers/date.js" />
/// <reference path="../classes/day-grid.js" />

ulcal.controller("DayController", function ($scope, $routeParams, $compile, $timeout, UCEventData, UCAdData) {
    var date = new Date($routeParams.year, $routeParams.month - 1, $routeParams.date);

    $scope.setActiveDate(date.getDate());
    $scope.setActiveMonth(date.getMonth());
    $scope.setActiveYear(date.getFullYear());
    $scope.setActiveWeek(date.getWeek());
    $scope.setActiveSem(date.getSemester());

    LeftPanel.hidden = false;

    $scope.class = "day";
    $scope.title = "Day";

    $scope.setMiniMonth($scope.activeMonth, $scope.activeYear, "d");

    function addDate(i) {
        var d = new Date(date.getTime());
        d.setDate(date.getDate() + i);
        return d;
    }


    $scope.getTodaysDate = function(){
        return date;
    };

    $scope.getDate = function () {
        var date = new Date($scope.activeYear, $scope.activeMonth, $scope.activeDate);
        return $scope.getDayName(date.getDay()) + " " + $scope.getMonthName(date.getMonth()) + " " + date.getDate() + ",";
    };

    $scope.getNextLink = function () {
        var d = addDate(1);
        return "#/day/" + d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
    };

    $scope.getPrevLink = function () {
        var d = addDate(-1);
        return "#/day/" + d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
    };

    $scope.getTodayLink = function () {
        var d = new Date();
        return "#/day/" + d.getDate() + "/" + (d.getMonth() + 1) + "/" + d.getFullYear();
    };

    window.grid = DayGrid.createGrid(document.getElementById("day-grid"), $scope, $compile);
    window.adgrid = AdGrid.createGrid();


    UCEventData.getData({
        type: "d",
        date: $scope.activeYear + "-" + ($scope.activeMonth + 1) + "-" + $scope.activeDate
    }).success(function (events) {
//        events = events.events;
//        var c = 0;
//        for (e in events) {
//            var event = new UCEvent(events[e]);
//            grid.addEvent(event, c);
//            ++c;
//        }
    });


    UCAdData.getData().success(function (events) {
        events = events.events;
        for (e in events) {
            adgrid.addAd(new AdEvent(events[e]));
        }
        $timeout(function () {
            var g = $(".ad-grid");
            g.slimScroll({ wrapperClass: "ad-scroll-view" });
        }, 0);
    });


});