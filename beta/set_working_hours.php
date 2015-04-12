<html>
<head>

<style type="text/css">

.addOfficeHrs{
    cursor: pointer;    
}
div.blacksheet {
    display: none;
    width: 100%;
    height: 100%;
    margin-top: 0px;
    margin-left: 0px;
    position: absolute;
    background-color: rgba(3, 3, 3, 0.85);
    z-index: 8001;
}


a.office-hours-editor {
    border-radius: 4px;
    padding: 2px 8px;
    font-size: 10.5px;
    color: #029ACF;
    text-align: center;
    display: inline-block;
    font-weight: 500;
    cursor: pointer;
    width: auto;
    background-color: #E1E8ED;
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
    background-image: linear-gradient(#FFF, #E9ECEE);
    border: 1px solid #E1E8ED;
    position: absolute;
    margin-left: 231px;
    margin-top: 63px;
}

.edit_office_hours_wrap a.office-hours-editor {
    /* margin-left: 0px;
    margin-top: 0px;*/
}

a.office-hours-editor:hover {
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.18);
    background-color: #E0E4E7;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.18);
    background-image: linear-gradient(#F8F7F7,#E0E4E7);
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(enabled=false)";
    border-color: #D4DBE0;
    color: #50BCE0;
}

a.office-hours-editor:active {
    color: rgba(56, 161, 197, 0.65);
    border-color: #C9CBCC;
    box-shadow: inset 0 1px 4px rgba(0,0,0,0.2);
    background-image: linear-gradient(#F1F1F1,#E0E4E7);
}

a.office-hours-editor:focus {
    box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(28, 230, 156, 0.5);
}

.edit_office_hours_frame {
    background-color: #F3F3F3;
    border-radius: 4px;
    -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    /*    width: 442px;*/
    display: inline-block;
    height: auto;
    z-index: 10;
    padding-left: 5px;
    border: 1px solid rgba(0, 0, 0, 0.22);
    margin-left: 19%;
    margin-right: 19%;
}

    .edit_office_hours_frame .oh_day_select {
        display: inline-block;
        
        width: 85px;
        padding: 7px;
        border-right: 1px solid rgba(0, 0, 0, 0.22);
        text-align: center;
        color: rgba(77, 77, 77, 0.6);
        font-size: 12px;
        font-weight: 600;
    }

        .edit_office_hours_frame .oh_day_select:last-of-type {
            border-right: none;
        }

        .edit_office_hours_frame .oh_day_select input[type=checkbox].oh_checkbox {
            /*position: absolute;*/
            overflow: hidden;
            clip: rect(0 0 0 0);
            height: 15px;
            width: 15px;
            margin: -1px;
            padding: 0;
            border: 0;
            position: relative!important;
        }

input[type=checkbox].oh_checkbox + .oh_checkbox_label {
    height: 15px;
    display: none;
    line-height: 15px;
    background-repeat: no-repeat;
    background-position: 0 0;
    font-size: 15px;
    vertical-align: middle;
    cursor: pointer;
    color: rgba(77, 77, 77,.6);
    font-size: 11px;
    text-indent: 24px;
    background-size: cover;
    width: 15px;
    margin-left: 35px;
}


.edit_office_hours_frame .oh_day_select .oh_checkbox_label {
    background-image: url(../src/checkbox.png);
}

a.done-editing {
    -webkit-box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.15);
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.15);
    font-family: Helvetica,Arial,'lucida grande',tahoma,verdana,arial,sans-serif;
    background-color: #1CE69C;
    background: rgba(28,230,156,.8);
    color: white;
    border: none;
    font-size: 11.5px;
    line-height: 30px;
    position: relative;
    font-weight: 600;
    /*left: 457px;
        display: inline-block;*/
    margin-left: 0px;
    margin-top: 5px;
    height: 28px;
    width: 77px;
}

a.cancel-edit-officehrs {
    cursor: pointer;
    padding: 6px 16px;
    font-size: 14.5px;
    color: #4D4D4D;
    text-align: center;
    border-radius: 5px;
    background-color: #E1E8ED;
    box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
    background-image: linear-gradient(#FFF, #A7B0B6);
    border: 1px solid #555;
    margin-left: 45%;
    font-size: 11.5px;
    line-height: 22px;
    height: 20px;
    margin-top: 0px;
    position: relative;
}

a.done-editing:hover {
    background-color: #1ce69c;
    background-image: linear-gradient(top,#22C791,#1AAC7C);
    background-image: linear-gradient(rgba(0,0,0,0),rgba(0, 0, 0, 0.03));
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#00000000, endColorstr=#26000000)";
    border-top: none;
    color: white;
    font-size: 11.5px;
    border: none;
}

a.done-editing:active {
    background-image: linear-gradient(rgba(0,0,0,0.15),rgba(0,0,0,0.15));
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#26000000, endColorstr=#26000000)";
    border-color: transparent;
    box-shadow: inset 0 1px 4px rgba(0,0,0,0.3);
    border: none;
    font-size: 11.5px;
    color: #fff;
}

.edit_office_hours_wrap {
    position: relative;
    margin-top: 38px;
}

/* timere styles */
    .set_time {
    width: 75px;
    border-radius: 2px;
    border: 1px solid #AAB2C4;
    font-size: 12px;
    color: rgb(36, 36, 36);
    text-transform: lowercase;
    height: 25px;
    background-color: white;
    border: 1px solid #dddddd;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    -o-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
}

    .set_time:-ms-input-placeholder {
        text-transform: none !important;
    }

    .set_time::-webkit-input-placeholder {
        text-transform: none !important;
    }

    .set_time:-moz-placeholder {
        text-transform: none !important;
    }

    /* firefox 19+ */
    .set_time::-moz-placeholder {
        text-transform: none !important;
    }



.ui-widget-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.ui-autocomplete {
    position: absolute;
    top: 0;
    left: 0;
    cursor: default;
    z-index: 9999;
}

.ui-front {
    z-index: 9999 !important;
}

.ui-menu {
    list-style: none;
    padding: 1px;
    margin: 0;
    display: block;
    outline: none;
}

    .ui-menu .ui-menu-item a {
        text-decoration: none;
        display: block;
        padding: 1.5px .5em;
        line-height: 2;
        border-radius: 0px;
        min-height: 0; /* support: IE7 */
        font-weight: normal;
        text-transform: lowercase;
        text-align: left;
        padding-left: 10px;
        font-size: 14px;
    }

.ui-widget-content {
    -webkit-box-shadow: 0 0 3px rgba(0,0,0,.3);
    box-shadow: 0 0 3px rgba(0,0,0,.3);
    background-color: #fff;
    z-index: 500;
    border: solid;
    border-width: 1px 1px 2px;
    border-color: #333 #333 #293e6a;
    font-size: 12.5px;
    font-weight: bold;
    color: #5B5E64;
    left: 0px;
    position: fixed;
    text-transform: lowercase;
    border-radius: 0px;
}

    .ui-state-hover,
    .ui-widget-content .ui-state-hover,
    .ui-widget-header .ui-state-hover,
    .ui-state-focus,
    .ui-widget-content .ui-state-focus,
    .ui-widget-header .ui-state-focus {
        border: 1px solid #DDD;
        background: #F0F2F2 url(images/ui-bg_glass_100_fdf5ce_1x400.png) 50% 50% repeat-x;
        color: #0A0A0A;
        cursor: pointer;
    }

.ui-helper-hidden-accessible {
    display: none;
}

.ui-menu .ui-menu-item a.ui-state-focus,
.ui-menu .ui-menu-item a.ui-state-active {
    font-weight: normal;
    margin: -1px;
}   

/* timer styles end */
</style>
</head>
<body>
<button onclick="loadtimerselect();" style="display:none;" class="dtp_canvas_trigger"> </button>
<div class = 'blacksheet' style="display:none;">

                        <div class = 'edit_office_hours_wrap' style="display:none;">
                            <div class = 'edit_office_hours_frame'>
                                <div style="border-bottom: 1px solid rgba(0, 0, 0, 0.22); height: 30px;">
                                    <div class = 'oh_day_select'>
                                        <label tabindex='2' for='oh_check_mon'>Monday</label>                                   
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <label tabindex='2' for='oh_check_tue' >Tuesday</label>                                 
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <label tabindex='2' for='oh_check_wed'>Wednesday</label>                                    
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <label tabindex='2' for='oh_check_thu'>Thursday</label>                                 
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <label tabindex='2' for='oh_check_fri'>Friday</label>                                   
                                    </div>

                                    <div class = 'oh_day_select'>                                   
                                        <label tabindex='2' for='oh_check_fri' >Start Time</label>
                                    </div>
                                    <div class = 'oh_day_select'>                                   
                                        <label tabindex='2' for='oh_check_fri' >End Time</label>
                                    </div>
                                    <div class = 'oh_day_select'>                                   
                                        <label tabindex='2' for='oh_check_fri' ></label>
                                    </div>
                                </div>  
                                    <div>
                                        <script src="js/jquery.min.js"></script>
                                        <script src="js/jquery-ui-1.10.2.custom.min.js"></script>
                                        <script src="js/jquery.timeAutocomplete.min.js" type="text/javascript"></script>
                                        <script src="js/ampm.js" type="text/javascript"></script>
                                    </div>
                                <div class='officeHrsContainer'>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_mon' id='oh_check_mon' type='checkbox'>  
                                        <label tabindex='2' for='oh_check_mon' class='oh_checkbox_label'></label>                                                                                               
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_tue' id='oh_check_tue' type='checkbox'>  
                                        <label tabindex='2' for='oh_check_tue' class='oh_checkbox_label'></label>                                                                                               
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_wed' id='oh_check_wed' type='checkbox'>      
                                        <label tabindex='2' for='oh_check_wed' class='oh_checkbox_label'></label>                           
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_thu' id='oh_check_thu' type='checkbox'>  
                                        <label tabindex='2' for='oh_check_thu' class='oh_checkbox_label'></label>                                       
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_fri' id='oh_check_fri' type='checkbox'>  
                                        <label tabindex='2' for='oh_check_fri' class='oh_checkbox_label'></label>                               
                                    </div>                                                              
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time startDate' name = 'event_time' placeholder = 'Start Time' type='text'>                                 
                                    </div>
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time endDate' name = 'event_time' placeholder = 'End Time' type='text'>
                                    </div>                              
                                    <div class = 'oh_day_select'>
                                        <img src="img/liked-button.png" class="addOfficeHrs" width="20" height="20"/>
                                    </div>  
                                </div>  
                                <div class='officeHrsContainer' style='display:none;'>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_mon' id='oh_check_mon1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_mon1' class='oh_checkbox_label'></label>                                                                                              
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_tue' id='oh_check_tue1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_tue1' class='oh_checkbox_label'></label>                                                                                              
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_wed' id='oh_check_wed1' type='checkbox'>     
                                        <label tabindex='2' for='oh_check_wed1' class='oh_checkbox_label'></label>                          
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_thu' id='oh_check_thu1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_thu1' class='oh_checkbox_label'></label>                                      
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_fri' id='oh_check_fri1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_fri1' class='oh_checkbox_label'></label>                              
                                    </div>                                                              
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time startDate' name = 'event_time' placeholder = 'Start Time' type='text'>                                 
                                    </div>
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time endDate' name = 'event_time' placeholder = 'End Time' type='text'>
                                    </div>                              
                                    <div class = 'oh_day_select'>
                                        <img src="img/liked-button.png" class="addOfficeHrs" width="20" height="20"/>
                                    </div>  
                                </div>      
                                <div class='officeHrsContainer' style='display:none;'>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_mon' id='oh_check_mon1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_mon1' class='oh_checkbox_label'></label>                                                                                              
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_tue' id='oh_check_tue1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_tue1' class='oh_checkbox_label'></label>                                                                                              
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_wed' id='oh_check_wed1' type='checkbox'>     
                                        <label tabindex='2' for='oh_check_wed1' class='oh_checkbox_label'></label>                          
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_thu' id='oh_check_thu1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_thu1' class='oh_checkbox_label'></label>                                      
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_fri' id='oh_check_fri1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_fri1' class='oh_checkbox_label'></label>                              
                                    </div>                                                              
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time startDate' name = 'event_time' placeholder = 'Start Time' type='text'>                                 
                                    </div>
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time endDate' name = 'event_time' placeholder = 'End Time' type='text'>
                                    </div>                              
                                    <div class = 'oh_day_select'>
                                        <img src="img/liked-button.png" class="addOfficeHrs" width="20" height="20"/>
                                    </div>  
                                </div>  
                                <div class='officeHrsContainer' style='display:none;'>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_mon' id='oh_check_mon1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_mon1' class='oh_checkbox_label'></label>                                                                                              
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_tue' id='oh_check_tue1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_tue1' class='oh_checkbox_label'></label>                                                                                              
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_wed' id='oh_check_wed1' type='checkbox'>     
                                        <label tabindex='2' for='oh_check_wed1' class='oh_checkbox_label'></label>                          
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_thu' id='oh_check_thu1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_thu1' class='oh_checkbox_label'></label>                                      
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_fri' id='oh_check_fri1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_fri1' class='oh_checkbox_label'></label>                              
                                    </div>                                                              
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time startDate' name = 'event_time' placeholder = 'Start Time' type='text'>                                 
                                    </div>
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time endDate' name = 'event_time' placeholder = 'End Time' type='text'>
                                    </div>                              
                                    <div class = 'oh_day_select'>
                                        <img src="img/liked-button.png" class="addOfficeHrs" width="20" height="20"/>
                                    </div>  
                                </div>  
                                <div class='officeHrsContainer' style='display:none;'>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_mon' id='oh_check_mon1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_mon1' class='oh_checkbox_label'></label>                                                                                              
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_tue' id='oh_check_tue1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_tue1' class='oh_checkbox_label'></label>                                                                                              
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_wed' id='oh_check_wed1' type='checkbox'>     
                                        <label tabindex='2' for='oh_check_wed1' class='oh_checkbox_label'></label>                          
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_thu' id='oh_check_thu1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_thu1' class='oh_checkbox_label'></label>                                      
                                    </div>
                                    <div class = 'oh_day_select'>
                                        <input class='oh_checkbox oh_check_fri' id='oh_check_fri1' type='checkbox'> 
                                        <label tabindex='2' for='oh_check_fri1' class='oh_checkbox_label'></label>                              
                                    </div>                                                              
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time startDate' name = 'event_time' placeholder = 'Start Time' type='text'>                                 
                                    </div>
                                    <div class = 'oh_day_select'>                                   
                                        <input class = 'set_time endDate' name = 'event_time' placeholder = 'End Time' type='text'>
                                    </div>                              
                                    <div class = 'oh_day_select'>
                                        <img src="img/liked-button.png" class="addOfficeHrs" width="20" height="20"/>
                                    </div>  
                                </div> 
                                <script type="text/javascript">       
                                    $(".set_time").timeAutocomplete({
                                        increment: 15,
                                        formatter: "ampm",
                                        value: '',                                      
                                        auto_value: false                                                       
                                    });
                                </script>

    
                            </div>
                            <a class="office-hours-editor cancel-edit-officehrs">
                                Cancel
                            </a>
                            <a class = 'office-hours-editor done-editing' onclick="DoneEditingWorkHours();">
                                Done Editing
                            </a>
                        </div>

                    </div>                    
</body>
</html>


<script type="text/javascript">
    function loadtimerselect(){
        $('.blacksheet').show();
        $('.edit_office_hours_wrap').show();
    }    
    var class_id = "";

    $(document).ready(function (){
        
        var qs = (function (a) {
            if (a == "") return {};
            var b = {};
            for (var i = 0; i < a.length; ++i) {
                var p = a[i].split('=');
                if (p.length != 2) continue;
                b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
            }
            return b;
        })(window.location.search.substr(1).split('&')); 
        
        class_id = qs['class_id'];

        $(document).delegate('.cancel-edit-officehrs','click', function(){
            $('.blacksheet').hide();
            $('.edit_office_hours_wrap').hide();
            $('.oh_check_mon').prop('checked', false);
            $('.oh_check_tue').prop('checked', false);
            $('.oh_check_wed').prop('checked', false);
            $('.oh_check_thu').prop('checked', false);
            $('.oh_check_fri').prop('checked', false);

            $('.oh_check_mon').removeAttr("disabled");
            $('.oh_check_tue').removeAttr("disabled");
            $('.oh_check_wed').removeAttr("disabled");
            $('.oh_check_thu').removeAttr("disabled");
            $('.oh_check_fri').removeAttr("disabled");
        });

        $(document).delegate('.addOfficeHrs', 'click', function () {
            $(this).hide();
            $(this).parents('.officeHrsContainer').next('.officeHrsContainer').show();
        });

        $(document).delegate('.oh_checkbox', 'click', function(){
            if ($(this).prop('checked'))
            {
                if ($(this).hasClass('oh_check_mon'))
                {
                    $('.oh_check_mon').prop("disabled", true);
                    $(this).removeAttr("disabled");
                }
                else if ($(this).hasClass('oh_check_tue'))
                {
                    $('.oh_check_tue').prop("disabled", true);
                    $(this).removeAttr("disabled");
                }
                else if ($(this).hasClass('oh_check_wed'))
                {
                    $('.oh_check_wed').prop("disabled", true);
                    $(this).removeAttr("disabled");
                }
                else if ($(this).hasClass('oh_check_thu'))
                {
                    $('.oh_check_thu').prop("disabled", true);
                    $(this).removeAttr("disabled");
                }
                else if ($(this).hasClass('oh_check_fri'))
                {
                    $('.oh_check_fri').prop("disabled", true);
                    $(this).removeAttr("disabled");
                }
            }
            else
            {
                if ($(this).hasClass('oh_check_mon'))
                {
                    $('.oh_check_mon').removeAttr("disabled");
                }
                else if ($(this).hasClass('oh_check_tue'))
                {
                    $('.oh_check_tue').removeAttr("disabled");
                }
                else if ($(this).hasClass('oh_check_wed'))
                {
                    $('.oh_check_wed').removeAttr("disabled");
                }
                else if ($(this).hasClass('oh_check_thu'))
                {
                    $('.oh_check_thu').removeAttr("disabled");
                }
                else if ($(this).hasClass('oh_check_fri'))
                {
                    $('.oh_check_fri').removeAttr("disabled");
                }
            }
        });

    });

// To format the office hours and update the time boxes
        function OfficeHours(officeHrs) {
            if ((officeHrs != null) && (officeHrs != "")){

                var everyDayTime = officeHrs.split(',');
                var row = new Array();
                for (var i = 0; i < 20; i++) {
                    row[i] = new Array(2);
                }
                var k = 0;
                for (var i = 0; i < everyDayTime.length; i++) {
                    var day = everyDayTime[i].split('(')[0].trim();
                    var time = everyDayTime[i].split('(')[1].split(')')[0].trim();
                    var individualTimes = time.split('&');

                    for (var j = 0; j < individualTimes.length; j++) {
                        var stTime = individualTimes[j].split('-')[0].trim();
                        var endTime = individualTimes[j].split('-')[1].trim();

                        row[k][1] = individualTimes[j];
                        row[k][0] = day;
                        k++;
                    }
                }

                $('.officeHrsContainer').each(function (index) {
                    for (var index = 0; index < row.length; index++) {
                        if ((row[index][0] != null) && (row[index][1] != null)) {
                            if (row[index][1].trim() != ($(this).find('.startDate').val() + "-" + $(this).find('.endDate').val())) {
                                if (!($(this).find('.oh_check_mon').prop('checked'))
                                        && !($(this).find('.oh_check_tue').prop('checked'))
                                        && !($(this).find('.oh_check_wed').prop('checked'))
                                        && !($(this).find('.oh_check_thu').prop('checked'))
                                        && !($(this).find('.oh_check_fri').prop('checked'))) {

                                    if (row[index][0].toLowerCase() == "m") {
                                        $(this).find('.oh_check_mon').trigger('click');
                                        $(this).find('.oh_check_mon').prop('checked', true);
                                        $(this).find('.oh_check_mon').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                        $(this).find('.oh_check_mon').next('.oh_checkbox_label').css('color', '#373737');
                                        //CheckOfficeHrs("Mon", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                    }
                                    if (row[index][0].toLowerCase() == "t") {
                                        $(this).find('.oh_check_tue').trigger('click');
                                        $(this).find('.oh_check_tue').prop('checked', true);
                                        $(this).find('.oh_check_tue').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                        $(this).find('.oh_check_tue').next('.oh_checkbox_label').css('color', '#373737');
                                        //CheckOfficeHrs("Tue", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                    }
                                    if (row[index][0].toLowerCase() == "w") {
                                        $(this).find('.oh_check_wed').trigger('click');
                                        $(this).find('.oh_check_wed').prop('checked', true);
                                        $(this).find('.oh_check_wed').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                        $(this).find('.oh_check_wed').next('.oh_checkbox_label').css('color', '#373737');
                                        //CheckOfficeHrs("Wed", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                    }
                                    if (row[index][0].toLowerCase() == "th") {
                                        $(this).find('.oh_check_thu').trigger('click');
                                        $(this).find('.oh_check_thu').prop('checked', true);
                                        $(this).find('.oh_check_thu').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                        $(this).find('.oh_check_thu').next('.oh_checkbox_label').css('color', '#373737');
                                        //CheckOfficeHrs("Thu", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                    }
                                    if (row[index][0].toLowerCase() == "f") {
                                        $(this).find('.oh_check_fri').trigger('click');
                                        $(this).find('.oh_check_fri').prop('checked', true);
                                        $(this).find('.oh_check_fri').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                        $(this).find('.oh_check_fri').next('.oh_checkbox_label').css('color', '#373737');
                                        //CheckOfficeHrs("Fri", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                    }

                                    $(this).find('.startDate').val(row[index][1].trim().split('-')[0]);
                                    $(this).find('.endDate').val(row[index][1].trim().split('-')[1]);
                                    row[index][0] = null;
                                    row[index][1] = null;
                                    ($(this).find('.addOfficeHrs')).trigger("click");
                                }
                            }
                            else {
                                if (row[index][0].toLowerCase() == "m") {
                                    $(this).find('.oh_check_mon').prop('checked', true);
                                    $(this).find('.oh_check_mon').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                    $(this).find('.oh_check_mon').next('.oh_checkbox_label').css('color', '#373737');
                                    //CheckOfficeHrs("Mon", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                }
                                if (row[index][0].toLowerCase() == "t") {
                                    $(this).find('.oh_check_tue').prop('checked', true);
                                    $(this).find('.oh_check_tue').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                    $(this).find('.oh_check_tue').next('.oh_checkbox_label').css('color', '#373737');
                                    //CheckOfficeHrs("Tue", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                }
                                if (row[index][0].toLowerCase() == "w") {
                                    $(this).find('.oh_check_wed').prop('checked', true);
                                    $(this).find('.oh_check_wed').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                    $(this).find('.oh_check_wed').next('.oh_checkbox_label').css('color', '#373737');
                                    //CheckOfficeHrs("Wed", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                }
                                if (row[index][0].toLowerCase() == "th") {
                                    $(this).find('.oh_check_thu').prop('checked', true);
                                    $(this).find('.oh_check_thu').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                    $(this).find('.oh_check_thu').next('.oh_checkbox_label').css('color', '#373737');
                                    //CheckOfficeHrs("Thu", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                }
                                if (row[index][0].toLowerCase() == "f") {
                                    $(this).find('.oh_check_fri').prop('checked', true);
                                    $(this).find('.oh_check_fri').next('.oh_checkbox_label').css('background-position', '0px -15px');
                                    $(this).find('.oh_check_fri').next('.oh_checkbox_label').css('color', '#373737');
                                    //CheckOfficeHrs("Fri", row[index][1].trim().split('-')[0], row[index][1].trim().split('-')[1]);
                                }

                                // $(this).find('.startDate').val(row[index][1].trim().split('-')[0]);
                                // $(this).find('.endDate').val(row[index][1].trim().split('-')[1]);
                                row[index][0] = null;
                                row[index][1] = null;
                                ($(this).find('.addOfficeHrs')).trigger("click");
                            }
                        }
                    }
                });
            }
        }

        // Get the work hours 
        function DoneEditingWorkHours() {
            var officeHrs = "";
            var mon = "";
            var tue = "";
            var wed = "";
            var thu = "";
            var fri = "";
            $('.officeHrsContainer').each(function (index) {
                if ($(this).find('.oh_check_mon').prop('checked')) {
                    mon += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                }
                if ($(this).find('.oh_check_tue').prop('checked')) {
                    tue += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                }
                if ($(this).find('.oh_check_wed').prop('checked')) {
                    wed += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                }
                if ($(this).find('.oh_check_thu').prop('checked')) {
                    thu += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                }
                if ($(this).find('.oh_check_fri').prop('checked')) {
                    fri += "&" + $(this).find('.startDate').val() + "-" + $(this).find('.endDate').val();
                }
            });

            if (mon != "") {
                mon = ", M (" + mon.substr(1, mon.length) + ")";
                officeHrs += mon;
            }
            if (tue != "") {
                tue = ", T (" + tue.substr(1, tue.length) + ")";
                officeHrs += tue;
            }
            if (wed != "") {
                wed = ", W (" + wed.substr(1, wed.length) + ")";
                officeHrs += wed;
            }
            if (thu != "") {
                thu = ", Th (" + thu.substr(1, thu.length) + ")";
                officeHrs += thu;
            }
            if (fri != "") {
                fri = ", F (" + fri.substr(1, fri.length) + ")";
                officeHrs += fri;
            }

            if (officeHrs != "")
            {
                officeHrs = officeHrs.substr(1, officeHrs.length).trim();            
            
                $.ajax({
                        url: "php/edit_class_details.php",
                        data: {course_timings: officeHrs, class_id: class_id },
                        type: "POST",
                        dataType: "text",
                        success: function (responseText) {                        
                            $('.ghr-head-time').text(responseText);
                        },
                        error: function (responseText) {
                            $('.ghr-head-time').text(responseText);
                        }
                    });

                $('.cancel-edit-officehrs').trigger('click');
            }
        }

</script>