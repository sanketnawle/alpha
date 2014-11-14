﻿/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />
/// <reference path="../classes/month-grid.js" />

ulcal.controller("MonthController", function ($scope, $routeParams) {
    LeftPanel.hidden = false;

    $scope.class = "month";
    $scope.title = "Month";

    $scope.setActiveMonth($routeParams.month - 1);
    $scope.setActiveYear($routeParams.year);

    var givdate = new Date($scope.activeYear, $scope.activeMonth, 1), curdate = new Date();
    $scope.setActiveSem(givdate.getSemester());
    $scope.setActiveWeek((curdate.getMonth() == givdate.getMonth() ? curdate : givdate).getWeek());

    $scope.getNextLink = function () {
        var month = (parseInt($scope.activeMonth) + 1) % 12, year = parseInt($scope.activeYear);
        if (month == 0) year += 1;
        return "#/month/" + (month + 1) + "/" + year;
    }

    $scope.getPrevLink = function () {
        var month = (parseInt($scope.activeMonth) - 1) % 12, year = parseInt($scope.activeYear);
        if (month == -1) { month = 11, year -= 1; }
        return "#/month/" + (month + 1) + "/" + year;
    }

    $scope.getTodayLink = function () {
        var date = new Date();
        return "#/month/" + (date.getMonth() + 1) + "/" + date.getFullYear();
    }

    //window.grid = // for debugging
    MonthGrid.createGrid("month-grid", $scope.activeMonth, $scope.activeYear);

    $scope.setMiniMonth($scope.activeMonth, $scope.activeYear, "m");
});