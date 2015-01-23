/// <reference path="event-target.js" />

var KeyControl = function () {
    EventTarget.call(this);
    
    var kc = this;    

    document.onkeyup = function (e) {
        e = e || Event;
        switch (e.keyCode) {
            case 37: kc.__fire({ type: "UcLeft", context: e }); break;
            case 39: kc.__fire({ type: "UcRight", context: e }); break;
        }
    };
};

KeyControl.prototype = Object.create(EventTarget.prototype);