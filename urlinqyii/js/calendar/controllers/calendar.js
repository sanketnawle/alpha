/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />
/// <reference path="../helpers/date.js" />
/// <reference path="../classes/date-provider.js" />
/// <reference path="../classes/cal-event.js" />
/// <reference path="../classes/left-panel.js" />
/// <reference path="../classes/ad-grid.js" />

ulcal.controller("CalController", function (
    $scope, $location, $routeParams, $timeout, $compile,
    DateService, KeyControlService, PrinterService) {
    $scope.menu = { items: ['day', 'week', 'month'], active: 0, old: 0 };

    var date = new Date()
    $scope.activeDate = date.getDate();
    $scope.activeWeek = date.getWeek();
    $scope.activeMonth = date.getMonth();
    $scope.activeSem = date.getSemester();
    $scope.activeYear = date.getFullYear();
    $scope.activeType = "d";

    // Mini Calendar
    $scope.miniActiveMonth = $scope.activeMonth;
    $scope.miniActiveYear = $scope.activeYear;

    // Getters
    $scope.getMonthName = DateService.getMonthName
    $scope.getDayName = DateService.getDayName

    $scope.getLink = function (index) {
        switch (index) {
            case 0: // day
                return $scope.activeDate + "/" + ($scope.activeMonth + 1) + "/" + $scope.activeYear;
            case 1: // week
                return $scope.activeWeek + "/" + $scope.activeYear;
            case 2: // month                
                return ($scope.activeMonth + 1) + "/" + $scope.activeYear;
            case 3: // semester
                return $scope.activeSem + "/" + $scope.activeYear;
        }
    };

    $scope.getHeaderUrl = function () { return views_url + "/header.html"; }
    $scope.getAssetsUrl = function () { return base_url + "/assets/calendar"; }

    // Print
    $scope.printGrid = function () { PrinterService.print(document.querySelector(".body")); }

    // Setters
    $scope.setActiveDate = function (date) { $scope.activeDate = date; }
    $scope.setActiveWeek = function (week) { $scope.activeWeek = week; }
    $scope.setActiveMonth = function (month) { $scope.activeMonth = month; }
    $scope.setActiveYear = function (year) { $scope.activeYear = year; }
    $scope.setActiveSem = function (sem) { $scope.activeSem = sem; }
    $scope.setActiveType = function (type) { $scope.activeType = type; }

    $scope.setMiniDate = function (month, year) {
        $scope.miniActiveMonth = month;
        $scope.miniActiveYear = year;
    }

    $scope.setMiniMonth = function (month, year, type) {
        var param = {
            type: type,
            month: month,
            year: year
        };
        MiniMonthGrid.createGrid($(".leftbar .mini-calendar .mini-cal-grid")[0], month, year, param);
        $scope.setMiniDate(month, year);
        $scope.setActiveType(type);
    }

    // Events
    $scope.$on("$routeChangeSuccess", function () {
        var url = $location.$$url.replace(/^\//, "").split("/", 1);
        $scope.menu.active = $scope.menu.items.indexOf(url[0]);
        $scope.setActiveType($scope.menu.items[$scope.menu.active][0]);

        $timeout(function () {
            var g = $(".toscroll");            
            g.slimScroll({ wrapperClass: "scroll-view" });
        }, 0);
    });

    $scope.$on("ucDialogLoaded", function () {
        window.dlg = CalendarEvent.createDialog(document.getElementById("dialog"), function (e) {
            $scope.openNewEvent = function () {
                e.target.opened = true;
            }
        });
    });

    LeftPanel.init($scope, $compile);

    KeyControlService.addListener("UcLeft", function () { $(".body .header.row1 .arrow.left").trigger("click"); });
    KeyControlService.addListener("UcRight", function () { $(".body .header.row1 .arrow.right").trigger("click"); });
})