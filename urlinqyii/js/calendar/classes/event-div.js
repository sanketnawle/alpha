function CalendarEvent(object) {
    if (typeof object != "object") throw "Expected Javascript Object, given " + typeof object;

    this.id = object.event_id;
    this.title = object.title;
    this.desc = object.description || "";
    this.startDate = object.start_date;
    this.endDate = object.end_date;
    this.startTime = object.start_time;
    this.endTime = object.end_time;
    this.loc = object.location;
    this.origin_type = object.origin_type;
    this.origin_id = object.origin_id;
}

function UCEvent(object) {
    CalendarEvent.call(this, object);

    if (object.repeat_type != null) {
        this.repeat = {};
        this.repeat.type = object.repeat_type;
        this.repeat.factor = object.repeat_factor;
        this.repeat.endDate = object.repeat_end_date;
    }
    this.editable = object.editable == null ? true : object.editable;
    this.allday = object.allday;
}

UCEvent.assert = function (object) {
    if (!(object instanceof UCEvent)) throw "Expected UCEvent, given " + object.constructor.name;
};

function AdEvent(object) {
    CalendarEvent.call(this, object);
}

AdEvent.assert = function (object) {
    if (!(object instanceof AdEvent)) throw "Expected AdEvent, given " + object.constructor.name;
};

function Div(cls, html) {
    var div = document.createElement("div");
    div.className = cls;
    if (html) div.innerHTML = html;
    return div;
}