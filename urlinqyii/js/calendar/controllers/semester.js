/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />
/// <reference path="../classes/left-panel.js" />
/// <reference path="../classes/month-grid.js" />

ulcal.controller("SemesterController", function ($scope, $routeParams, $timeout, DateService) {
    LeftPanel.hidden = true;

    $scope.sem = $routeParams.sem;
    $scope.semMonths = [[0], [0, 1, 2, 3, 4], [4, 5, 6, 7], [8, 9, 10, 11]];
    $scope.semName = ["Winter", "Spring", "Summer", "Fall"];

    $scope.setActiveSem($scope.sem);
    $scope.setActiveMonth($scope.semMonths[$scope.sem][0]);
    $scope.setActiveYear($routeParams.year);
    $scope.setActiveWeek(new Date($scope.activeYear, $scope.activeMonth, 1).getWeek());

    $scope.getMonthName = DateService.getMonthName;

    $scope.getNextLink = function () {
        var year = $routeParams.year;
        var sem = parseInt($scope.sem) + 1;
        if (sem == 4) { sem = 0; ++year; }
        return "#/semester/" + sem + "/" + year;
    }

    $scope.getPrevLink = function () {
        var year = $routeParams.year;
        var sem = parseInt($scope.sem) - 1;
        if (sem == -1) { sem = 3; --year; }
        return "#/semester/" + sem + "/" + year;
    };

    $scope.class = "semester";
    $scope.title = "Semester";

    $scope.$on("ucRepeatFinishedAll", function (eve, ele) {
        //window.grid = // for debugging
        MonthGrid.createGrid("month-grid", $scope.semMonths[$scope.sem][0], $scope.activeYear, true);
    });

    window.adgrid = AdGrid.createGrid();

    adgrid.addAd("someone", "http://lorempixel.com/50/50?10");
    adgrid.addAd("someone", "http://lorempixel.com/50/50?10");

    var viewing = 0;
    $(".all-wrapper .arrow .arrow img").click(function () {
        var wrapper = $(this).closest(".all-wrapper").find(".sem-wrapper");
        var arrow = $(this).parents(".arrow");
        var sem = $(".sem", wrapper);

        var winw = wrapper.outerWidth();
        var semw = sem.outerWidth(true);

        var diff = semw * sem.length - winw;
        var max = Math.ceil(diff / semw);

        if (arrow.hasClass("right-arrow")) {
            if (++viewing == max + 1) viewing = max;
            else {
                wrapper.animate({ scrollLeft: semw * viewing });
            }
        } else if (arrow.hasClass("left-arrow")) {
            if (--viewing == -1) viewing = 0;
            else {
                wrapper.animate({ scrollLeft: semw * viewing });
            }
        }
    });
})