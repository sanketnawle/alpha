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

/* To get week number */
Date.prototype.getWeek = function () {
    var d = new Date(+this);
    d.setHours(0, 0, 0);
    d.setDate(d.getDate() + 4 - (d.getDay() || 7));
    return Math.ceil((((d - new Date(d.getFullYear(), 0, 1)) / 8.64e7) + 1) / 7);
}