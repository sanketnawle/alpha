/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />
/// <reference path="../classes/month-grid.js" />

ulcal.controller("MonthController", function ($scope, $routeParams) {
    $scope.setActiveDate($routeParams.month - 1, $routeParams.year);

    $scope.getNextMonthLink = function () {
        var month = (parseInt($scope.activeMonth) + 1) % 12, year = parseInt($scope.activeYear);
        if (month == 0) year += 1;
        return "#/month/" + (month + 1) + "/" + year;
    }

    $scope.getPrevMonthLink = function () {
        var month = (parseInt($scope.activeMonth) - 1) % 12, year = parseInt($scope.activeYear);
        if (month == -1) { month = 11, year -= 1; }
        return "#/month/" + (month + 1) + "/" + year;
    }

    $scope.getTodayLink = function () {
        var date = new Date();
        return "#/month/" + (date.getMonth() + 1) + "/" + date.getFullYear();
    }

    MonthGrid.createGrid("month-grid", $scope.activeMonth, $scope.activeYear);
});