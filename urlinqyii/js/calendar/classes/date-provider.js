var DateProvider = function () {
    var day = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var month = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];

    var getFullDate = function (month, year, last) {
        if (month === undefined) month = new Date().getMonth();
        if (year === undefined) year = new Date().getFullYear();
        return new Date(year, month + (last ? 1 : 0), (last ? 0 : 1));
    }

    this.getMonthName = function (index, short, limit) {
        if (short === undefined) short = true;
        if (limit === undefined) limit = 3;
        return short ? month[index].substr(0, limit) : month[index];
    }

    this.getDayName = function (index, short, limit) {
        if (short === undefined) short = true;
        if (limit === undefined) limit = 3;
        return short ? day[index].substr(0, limit) : day[index];
    }

    this.getDate = function (month, year, last) { return getFullDate(month, year, last); }

    this.getDateOfWeek = function (week, year) {
        var simple = new Date(year, 0, 1 + (week) * 7);
        var dow = simple.getDay();
        var date = simple;
        if (dow <= 4)
            date.setDate(simple.getDate() - simple.getDay());
        else
            date.setDate(simple.getDate() + 7 - simple.getDay());
        return date;
    }

    this.getCurrentWeek = function () {
        var d = new Date();
        d.setDate(d.getDate() - d.getDay());
        return d.getWeek();
    }

    this.getCurrentYear = function () { return new Date().getFullYear(); }
    this.getCurrentMonth = function () { return new Date().getMonth(); }
    this.getCurrentDate = function () { return new Date().getDate(); }

    this.diffTime = function (start, end) {
        var st = start.split(":"), et = end.split(":");
        var std = new Date(2014, 11, 11, st[0], st[1]), etd = new Date(2014, 11, 11, et[0], et[1]);
        return (etd - std) / 1000;
    }

    this.to12Hrs = function (time) {
        var st = time.split(":");
        var ap = "am";
        if (st[0] > 11) ap = "pm";
        st[0] = st[0] == 12 ? 12 : st[0] % 12;
        st = st[0] + ":" + st[1] + " " + ap;
        return st;
    }

    this.toInputWeekFormat = function (fd, date) {
        if (!(date instanceof Date)) {
            date = date.split("-");
            date = new Date(date[0], date[1] - 1, date[2]);
        }
        var val = $.datepicker.regional[""].dayNamesShort[date.getDay()];
        val += ", " + $.datepicker.regional[""].monthNamesShort[date.getMonth()];
        val += " " + date.getDate() + ", " + date.getFullYear();        
        return val;        
    }
}