var LeftPanel = (function (Panel) {
    Panel.init = function () {
        var __hidden = false;
        var __element = document.getElementsByClassName("leftbar")[0];
        Object.defineProperties(Panel, {
            ele: {
                value: __element
            },
            hidden: {
                get: function () {
                    return __hidden;
                },
                set: function (value) {
                    __hidden = value;
                    if (value) this.ele.style.display = "none";
                    else this.ele.style.display = "block";
                }
            }
        });

        return Panel;
    }

    return Panel;
}(LeftPanel || {}));