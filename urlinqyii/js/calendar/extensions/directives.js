/// <reference path="../../lib/ng.js" />
/// <reference path="../../lib/jquery.js" />
/// <reference path="../ulCalendar.js" />

ulcal.directive("ngUcRepeatRendered", function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            $timeout(function () {
                scope.$emit('ucRepeatFinishedOne', element.context, attr.month)
            });
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ucRepeatFinishedAll', element.context)
                });
            }
        }
    }
})

ulcal.directive("ngUcCheck", function () {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            var ele = element.context;
            var t = function (c) { var m = document.createElement("i"); m.className = c; return m; }
            var x = t("x"), xx = t("xx");
            ele.appendChild(x);
            ele.appendChild(xx);
            element.bind("click", function () {
                this.classList.toggle("checked");
            });
        }
    }
});

ulcal.directive("ngUcDialog", function ($timeout) {
    return {
        restrict: 'A',
        templateUrl: views_url + '/newevent.html',
        link: function (s, e, a) {
            $timeout(function () {
                s.$emit("ucDialogLoaded", e.context);
            })
        }
    }
});

ulcal.directive("ngUcDayEvent", function ($timeout) {
    return {
        restrict: 'A',
        templateUrl: views_url + '/dayevent.html',
        link: function (s, e, a) {
            $timeout(function () {
                s.$emit("ucDayEventLoaded", e.context);
            });
        }
    }
});

ulcal.directive("ngUcDayEventTitle", function () {
    return {
        restrict: 'A',
        link: function (s, e, a) {
            e.bind("click", function () {
                var event = this.parentElement;
                event.classList.toggle("open");
                var day = event.parentElement;
                var grid = day.parentElement;
                if (event.classList.contains("open")) {
                    grid.scrollTop = day.offsetTop;
                }
            })
        }
    }
});