/// <reference path="../lib/ng.js" />
/// <reference path="../lib/jquery.js" />
/// <reference path="../lib/ng-route.js" />
/// <reference path="classes/key-control.js" />

window.ApplicationName = "ulCalendar";

var ulcal = angular.module(ApplicationName, ["ngRoute"]);








ulcal.config(function ($routeProvider) {
    var date = new Date();
    $routeProvider.when("/day/:date/:month/:year", {
        templateUrl: views_url + "/day.html",
        controller: "DayController"
    }).when("/week/:week/:year", {
        templateUrl: views_url + "/week.html",
        controller: "WeekController"
    }).when("/month/:month/:year", {
        templateUrl: views_url + "/month.html",
        controller: "MonthController"
    }).otherwise({
        redirectTo: "/day/" + date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear()
    });
});

// jquery dependent;
ulcal.factory("UCEventData", function ($http) {
    return {
        getData: function (params) {
            return $http({
                url: base_url + "/event/getEvents?tz_offset="+(new Date().getTimezoneOffset()),
                params: params
            });
        }
    }
});

ulcal.factory("UCAdData", function ($http) {
    return {
        getData: function (params) {
            return $http({
                url: base_url + "/event/getSuggestedEvents",
                params: params
            });
        }
    }
});

ulcal.service("KeyControlService", KeyControl);