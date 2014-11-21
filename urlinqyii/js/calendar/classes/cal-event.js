/// <reference path="event-target.js" />
/// <reference path="date-provider.js" />
/// <reference path="../lib/jquery.js /">

var CalendarEvent = (function (CalendarEvent) {
    var _displayMode = "block";
    var dp = new DateProvider();

    var Tag = {
        createTags: function (nodes) {
            var items = [];
            [].forEach.call(nodes, function (ele, i, array) {
                var obj = {};
                Object.defineProperties(obj, {
                    ele: { value: ele },
                    text: {
                        get: function () { return this.ele.innerHTML; },
                        set: function (el) { this.ele.innerHTML = el; }
                    }
                });
                items.push(obj);
            });
            items.toStringArray = function () {
                for (var str = [], i = 0; i < items.length; str.push(items[i].text), ++i);
                return str;
            }
            return items;
        },
        createNewTag: function (ctx, text) {
            var tags = ctx.ele.querySelector(".row4 .tags");
            var tag = document.createElement("span");
            tag.className = "tag";
            tag.innerHTML = text;
            tag.onclick = function () { tags.removeChild(tag); }
            tags.appendChild(tag);
        },
        removeTag: function (ctx, index) {
            var tags = ctx.ele.querySelectorAll(".row4 .tags .tag");
            if (index >= tags.length) return;
            tags[index].remove();
        }
    }

    var Dialog = function (ele) {
        if (ele == null) return;

        EventTarget.call(this);

        this.ele = ele;
        var _parent = ele.parentNode;
        var _opened = null;

        Object.defineProperties(this, {
            opened: {
                get: function () { return _opened; },
                set: function (value) {
                    if (_opened == value) return;
                    _opened = value;
                    if (value) {
                        _parent.appendChild(this.ele);
                        this.__fire({ type: "open", opened: value });
                    } else {
                        if (this.ele.parentNode != null) {
                            _parent.removeChild(this.ele);
                            this.__fire({ type: "close", opened: value });
                        }
                    }
                    this.ele.removeAttribute("style");
                }
            },
            show: { value: function () { this.ele.style.display = _displayMode; } },
            hide: { value: function () { this.ele.style.display = "none"; } },
            init: {
                value: function () {
                    var dlg = this, dialog = this.ele;
                    dlg.opened = false;

                    this.wrapper = dialog.querySelector(".wrapper");
                    this.wrapper.onclick = function (e) {
                        if (e.target === this) {
                            dlg.opened = false;
                            dlg.__fire("cancel");
                        }
                    }

                    this.closeBtn = dialog.querySelector(".dtitle .close");
                    this.closeBtn.onclick = function () { dlg.opened = false; dlg.__fire("cancel"); }

                    this.submitBtn = dialog.querySelector(".row5 .submit");
                    this.submitBtn.onclick = function () { dlg.opened = false; dlg.__fire("submit"); }

                    this.desBtn = dialog.querySelector(".row5 .des-btn");
                    this.desBtn.onclick = function () {
                        var cls = "active";
                        if (this.classList.contains(cls))
                            this.classList.remove(cls);
                        else
                            this.classList.add(cls);
                    }

                    this.tagInput = dialog.querySelector(".row4 .tag-in .txt");
                    this.tagInput.onkeyup = function (e) {
                        e = e || event;
                        if (e.keyCode == 188 || e.keyCode == 13) {
                            dlg.addTag(this.value.split(",", 1)[0]);
                            this.value = "";
                        }
                    }

                    if ($(".row2 .date", dlg.ele).datepicker)
                        $(".row2 .date", dlg.ele).datepicker({ dateFormat: "D, M dd, yy" });

                    var fdate = new Date();
                    this.fromTime = fdate.toTimeInputValue();
                    this.fromDate = fdate.toDateInputValue();

                    var tdate = new Date(fdate.getTime());
                    tdate.setHours(fdate.getHours() + 1);
                    this.toDate = tdate.toDateInputValue();
                    this.toTime = tdate.toTimeInputValue();

                    $(".row1 .cats li", dlg.ele).click(function () {
                        $(" > .cat", $(this).parents(".ecat"))[0].className = $(".cat", this)[0].className;
                    });

                    this.__fire("load");
                }
            },
            tags: { get: function () { return Tag.createTags(this.ele.querySelectorAll(".tags .tag")); } },
            addTag: { value: function (text) { Tag.createNewTag(this, text); } },
            removeTag: { value: function (index) { Tag.removeTag(this, index); } },
            fromDate: {
                get: function () { return this.ele.querySelector(".from-ts .date").getAttribute("orig"); },
                set: function (date) {
                    var fd = this.ele.querySelector(".from-ts .date");
                    fd.value = dp.toInputWeekFormat(fd, date);
                }
            },
            toDate: {
                get: function () { return this.ele.querySelector(".to-ts .date").getAttribute("orig"); },
                set: function (date) {
                    var td = this.ele.querySelector(".to-ts .date");
                    td.value = dp.toInputWeekFormat(td, date);
                }
            },
            fromTime: {
                get: function () { return this.ele.querySelector(".from-ts .time").value; },
                set: function (time) { return this.ele.querySelector(".from-ts .time").value = time; }
            },
            toTime: {
                get: function () { return this.ele.querySelector(".to-ts .time").value; },
                set: function (time) { return this.ele.querySelector(".to-ts .time").value = time; }
            },
            allDay: {
                get: function () { return this.allDayCheck.classList.contains("checked"); },
                set: function (check) {
                    if (check) this.allDayCheck.classList.add("checked");
                    else this.allDayCheck.classList.remove("checked");
                }
            }
        });
    }

    // inherit events
    Dialog.prototype = Object.create(EventTarget.prototype);

    CalendarEvent.createDialog = function (ele, callback) {
        var dlg = new Dialog(ele);
        dlg.addListener("load", callback);
        dlg.init();
        return dlg;
    }

    CalendarEvent.Dialog = Dialog;

    return CalendarEvent;
}(CalendarEvent || {}));