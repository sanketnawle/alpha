function UCEvent(object) {
    /// <summary>Creates an Event that can be added any where in the calendar using grid.addEvent</summary>
    /// <param name='object'>
    /// Javascript object, with following expected fields:<br />
    /// object.eventId<br />
    /// object.title: string<br />
    /// [object.desc]: string, null<br />
    /// object.startDate: yyyy-mm-dd, string<br />
    /// object.endDate: yyyy-mm-dd, string<br />
    /// object.startTime: hh-mm, string<br />
    /// object.endTime: hh-mm, string<br />
    /// [object.repeat]: [none|daily|weekly|monthly]<br />
    /// [object.checked]: boolean, false<br />
    /// [object.editable]: boolean, true<br />
    /// </param>
    /// <returns>UCEvent Object</returns>

    if (typeof object != "object") throw "Expected Javascript Object, given " + typeof object;

    this.id = object.event_id;
    this.title = object.title;
    this.desc = object.description || "";
    this.startDate = object.start_date;
    this.endDate = object.end_date;
    this.startTime = object.start_time;
    this.endTime = object.end_time;
    this.loc = object.location;
    if(object.repeat_type != null) {
        this.repeat = {};
        this.repeat.type = object.repeat_type;
        this.repeat.factor = object.repeat_factor;
        this.repeat.endDate = object.repeat_end_date;
    }
    this.checked = object.is_checked == null ? false : object.is_checked;
    this.editable = object.editable == null ? true : object.editable;
    this.allday = object.allday;
}

UCEvent.assert = function (object) {
    if (!(object instanceof UCEvent)) throw "Expected UCEvent, given " + object.constructor.name;
}

function Div(cls, html) {
    var div = document.createElement("div");
    div.className = cls;
    if (html) div.innerHTML = html;
    return div;
}