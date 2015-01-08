/// <reference path="event-div.js" />

var AdGrid = (function (Panel) {
    var Grid = function (__element) {
        this.ele = __element;
        Object.defineProperties(this, {
            addAd: {
                value: function (adevent) {
                    AdEvent.assert(adevent);

                    var div = new Div("ad");

                    var img = new Image(50, 50);
                    var title = new Div("title", adevent.title);

                    var description = new Div("description");

                    description.innerHTML = adevent.desc;

                    var button = document.createElement("button");

                    button.innerHTML = "Add to Calendar";
                    button.className = "follow";

                    img.src = "http://lorempixel.com/34/34";
                    img.className = "icon";

                    div.appendChild(img);
                    div.appendChild(title);
                    div.appendChild(description);
                    div.appendChild(button);

                    this.ele.querySelector(".ads").appendChild(div);
                }
            }
        });
    };
    Panel.createGrid = function () {
        var __element = document.getElementsByClassName("ad-grid")[0];
        if (!__element) return null;

        return new Grid(__element);
    };

    return Panel;
}(AdGrid || {}));