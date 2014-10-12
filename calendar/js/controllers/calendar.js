/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />
/// <reference path="../js/date.js" />

ulcal.controller("CalController", function ($scope, $location, $routeParams, DateService) {
    $scope.menu = { items: ['day', 'week', 'month', 'semester'], active: 0 };

    var date = new Date()
    $scope.activeMonth = date.getMonth();
    $scope.activeYear = date.getFullYear();

    $scope.getMonthName = DateService.getMonthName
    $scope.getDayName = DateService.getDayName

    $scope.getLink = function (index) {
        switch (index) {
            case 0:
                return (new Date().getDate()) + "/" + ($scope.activeMonth + 1) + "/" + $scope.activeYear;
            case 1:
                return $scope.menu.items[index];
            case 2:
                return ($scope.activeMonth + 1) + "/" + $scope.activeYear;
            case 3:
                return $scope.menu.items[index];
        }
    };

    $scope.setActiveDate = function (month, year) {
        $scope.activeMonth = month;
        $scope.activeYear = year;
    }

    $scope.$on("$routeChangeSuccess", function () {
        var url = $location.$$url.replace(/^\//, "").split("/", 1);
        $scope.menu.active = $scope.menu.items.indexOf(url[0]);        
    });
})