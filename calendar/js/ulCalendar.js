/// <reference path="../lib/ng.js" />
/// <reference path="../lib/jquery.js" />
/// <reference path="../lib/ng-route.js" />
/// <reference path="classes/key-control.js" />

window.ApplicationName = "ulCalendar";

var ulcal = angular.module(ApplicationName, ["ngRoute"]);

ulcal.config(function ($routeProvider) {
    var date = new Date();
    $routeProvider.when("/day/:date/:month/:year", {
        templateUrl: "views/day.html",
        controller: "DayController"
    }).when("/week/:week/:year", {
        templateUrl: "views/week.html",
        controller: "WeekController"
    }).when("/month/:month/:year", {
        templateUrl: "views/month.html",
        controller: "MonthController"
    }).when("/semester/:sem/:year", {
        templateUrl: "views/semester.html",
        controller: "SemesterController"
    }).otherwise({
        redirectTo: "/day/" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear()
    });
});

// jquery dependent;
ulcal.factory("UCEventData", function ($http) {

    return {
        getData: function (params) {
            return $http({
                url: "model.php",                
                params: params
            });
        }
    }
});

ulcal.service("KeyControlService", KeyControl);