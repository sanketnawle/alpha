/// <reference path="../lib/ng.js" />
/// <reference path="../lib/jquery.js" />
/// <reference path="../lib/ng-route.js" />

var ulcal = angular.module("ulCalendar", ["ngRoute"]);

ulcal.config(function ($routeProvider) {
    var date = new Date();
    $routeProvider.when("/day/:date/:month/:year", {
        templateUrl: "views/day.html",
        controller: "DayController"
    }).when("/week/:wno?", {
        templateUrl: "views/week.html",
        controller: "WeekController"
    }).when("/month/:month/:year", {
        templateUrl: "views/month.html",
        controller: "MonthController"
    }).when("/semester/:name?", {
        templateUrl: "views/semester.html",
        controller: "SemesterController"
    }).otherwise({
        redirectTo: "/day/" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear()
    });
});