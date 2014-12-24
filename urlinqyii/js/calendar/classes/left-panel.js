/// <reference path="event-div.js" />

var LeftPanel = (function (Panel) {
    Panel.init = function (scope, compiler) {
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
            },
            addProvider: {
                value: function (type, provider, iconsrc, color) {
                    var div = new Div("provider");

                    var img = new Image(25, 25);
                    var title = new Div("title", provider);
                    var check = compiler("<div ng-uc-check class='check' checked />")(scope)[0];

                    img.src = iconsrc;
                    img.className = "icon";
                    check.classList.add(color);

                    div.appendChild(img);
                    div.appendChild(check);
                    div.appendChild(title);

                    title.onclick = function () {
                        check.click();
                    }

                    title.onmouseover = function () {
                        console.log(this.offsetWidth);
                        if (this.offsetWidth > 150) {
                            this.style.boxShadow = "3px 0 8px -3px #aaa";
                        }
                    }

                    this.ele.querySelector(".providers." + type).appendChild(div);
                }
            }
        });

        return Panel;
    }

    return Panel;
}(LeftPanel || {}));