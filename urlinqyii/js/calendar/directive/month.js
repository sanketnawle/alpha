app.directive("monthDirective", function()
{
    return {
        link: function(scope, element, attrs) {
            element.bind("click", function () {
                // Click event here
            });
        }
    }
});