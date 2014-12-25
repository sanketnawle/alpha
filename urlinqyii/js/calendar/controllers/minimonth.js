/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />
/// <reference path="../classes/month-grid.js" />

ulcal.controller("MiniMonthController", function ($scope) {
    $scope.getNextLink = function () {
        var month = (parseInt($scope.activeMonth) + 1) % 12, year = parseInt($scope.activeYear);
        if (month == 0) year += 1;
        return "#/month/" + (month + 1) + "/" + year;
    }

    $scope.goPrevMonth = function () {
        var m = parseInt($scope.miniActiveMonth), y = parseInt($scope.miniActiveYear);
        m = m == 0 ? function () { y -= 1; return 11; }() : m - 1;
        $scope.setMiniMonth(m, y, $scope.activeType);
    }

    $scope.goNextMonth = function () {
        var m = parseInt($scope.miniActiveMonth), y = parseInt($scope.miniActiveYear);
        m = m == 11 ? function () { y += 1; return 0; }() : m + 1;
        $scope.setMiniMonth(m, y, $scope.activeType);        
    }
});