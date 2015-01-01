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

                    //get_user_group_data();

                    this.wrapper = dialog.querySelector(".wrapper");
                    this.wrapper.onclick = function (e) {
                        if (e.target === this) {
                            dlg.opened = false;
                            dlg.__fire("cancel");
                        }
                    };

                    get_user_group_data();


                    function get_user_group_data(){
                        $.getJSON( base_url + '/user/getGroupData', function( json_data ) {
                            if(json_data['success']){
                                show_groups(json_data);
                            }else{
                                alert(JSON.stringify(json_data));
                            }
                        });
                    }



                    function show_groups(json_data){
                        $.each(json_data['classes'],function(index, class_json){
                            class_json['group_type'] = 'class';
                            //Reassigning name and id so we can use same template for
                            //classes, clubs, and groups
                            class_json['name'] = class_json['class_name'];
                            class_json['id'] = class_json['class_id'];
                            show_group(class_json);
                        });

                        $.each(json_data['clubs'],function(index, club_json){
                            club_json['group_type'] = 'club';
                            //Reassigning name so we can use same template for
                            //clubes, clubs, and groups
                            club_json['name'] = club_json['group_name'];
                            club_json['id'] = club_json['group_id'];
                            show_group(club_json);
                        });
                    }



                    function show_group(group_json){
                        //Normally source would be $("#group_template").html(); but for whatever reason
                        //angular doesnt let jquery select the handlebars template if it is in the html
                        var source = '<div class="group" data-group_type="{{group_type}}" data-id="{{id}}"><div class="group_name">{{name}}</div></div>';
                        var template = Handlebars.compile(source);
                        var generated_html = template(group_json);

                        dialog.querySelector('#create_event_group_holder').innerHTML += generated_html;

                    }






//                    function show_group(group_json){
//                        //Normally source would be $("#group_template").html(); but for whatever reason
//                        //angular doesnt let jquery select the handlebars template if it is in the html
//                        var source = '<div class="group" data-group_type="{{group_type}}" data-id="{{id}}"><div class="group_name">{{name}}</div></div>';
//                        var template = Handlebars.compile(source);
//                        var generated_html = template(group_json);
//
//                        dialog.querySelector('#create_event_group_holder').innerHTML += generated_html;
//                        //$('#create_event_group_holder').append(generated_html).hide().fadeIn();
//                    }


//                    this.closeBtn = dialog.querySelector(".dtitle .close");
//                    this.closeBtn.onclick = function () { dlg.opened = false; dlg.__fire("cancel"); }

//                    this.group_div = dialog.querySelectorAll(".group");
//                    this.group_div.onclick = function () {
//                        alert('lol');
//                    };

//                    this.desBtn = dialog.querySelector(".row5 .des-btn");
//                    this.desBtn.onclick = function () {
//                        var cls = "active";
//                        if (this.classList.contains(cls))
//                            this.classList.remove(cls);
//                        else
//                            this.classList.add(cls);
//                    }

//                    this.tagInput = dialog.querySelector(".row4 .tag-in .txt");
//                    this.tagInput.onkeyup = function (e) {
//                        e = e || event;
//                        if (e.keyCode == 188 || e.keyCode == 13) {
//                            dlg.addTag(this.value.split(",", 1)[0]);
//                            this.value = "";
//                        }
//                    }

//                    if ($(".row2 .date", dlg.ele).datepicker)
//                        $(".row2 .date", dlg.ele).datepicker({ dateFormat: "D, M dd, yy" });
//
//                    var fdate = new Date();
//                    this.fromTime = fdate.toTimeInputValue();
//                    this.fromDate = fdate.toDateInputValue();
//
//                    var tdate = new Date(fdate.getTime());
//                    tdate.setHours(fdate.getHours() + 1);
//                    this.toDate = tdate.toDateInputValue();
//                    this.toTime = tdate.toTimeInputValue();
//
//                    $(".row1 .cats li", dlg.ele).click(function () {
//                        $(" > .cat", $(this).parents(".ecat"))[0].className = $(".cat", this)[0].className;
//                    });

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


        $(document).on('click','.category',function(){
            var $this_category_div = $(this);
            //If there is a currently selected group, remove the class
            $('div.category.selected').removeClass('selected');
            $this_category_div.addClass('selected');
        });



        $(document).on('click','.group',function(){
            var $this_group_div = $(this);
            var group_type = $this_group_div.attr('data-group_type');

            //Remove the active class from the previous category
            $('div.category_list.active').removeClass('active');
            //Show the category list for this group type
            $("div.category_list[data-group_type='" + group_type + "']").addClass('active');

            //If there is a currently selected group, remove the class
            $('div.group.selected').removeClass('selected');
            $this_group_div.addClass('selected');
        });



        $(document).on('submit','#create_event_form',function(event){
            var $form = $(this);
            event.preventDefault();

            var post_url = base_url + $form.attr('action');

            var event_name = $('#create_event_name_input').val();
            
            var event_start_date = '2015-01-01';
            var event_start_time  = '00:00:00';

            var event_end_date = '2015-01-01';
            var event_end_time  = '00:05:00';

            var $selected_group = $('div.group.selected');

            var event_origin_type = $selected_group.attr('data-group_type');
            var event_origin_id = $selected_group.attr('data-id');

            var event_category = $('div.category.selected').attr('data-category');

            var event_location = $('#event_location_input').val();
            var event_description = $('#event_description_input').val();



        var post_data = {
        event:{
                event_name: event_name,
                origin_type: event_origin_type,
                origin_id: event_origin_id,
                event_type: event_category,
                title: event_name,
                description: event_description,
                start_time: event_start_time,
                end_time: event_end_time,
                start_date: event_start_date,
                end_date: event_end_date,
                location: event_location
            }
        };

//            var post_data = {
//                event_name: event_name,
//                event_start_date: event_start_date,
//                event_start_time: event_start_time,
//                event_end_date: event_end_date,
//                event_end_time: event_end_time,
//                event_origin_type: event_origin_type,
//                event_category: event_category,
//                event_location: event_location,
//                event_description: event_description
//            };
            //alert(JSON.stringify(post_data));
            $.post(
                post_url,
                post_data,
                function(response) {
                    if(response['success']){
                        alert(JSON.stringify(response));
                    }else{
                        alert(JSON.stringify(response));
                    }
                }, 'json'
            );

        });




    };

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