<html>
<head>

<style type="text/css">
.blackcanvas30 {
    position: fixed;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.39);
    z-index: 9999;
    top: 0px;
    left: 0px;
    font-family: "Open Sans";
    display: none;
}


div.add-event-box {
    padding: 20px 20px 60px;
    background-color: #f5f5f5;
    box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.15);
    width: 500px;
    border-radius: 4px;
    border: 1px solid rgba(0, 0, 0, 0.07);
    -webkit-box-shadow: 0 7px 20px rgba(0,0,0,0.25);
    -moz-box-shadow: 0 7px 20px rgba(0,0,0,0.25);
    box-shadow: 0 7px 20px rgba(0,0,0,0.25);
    margin-left: auto;
    margin-right: auto;
    margin-top: 7%;
}

div.add-event-box-edit-header {
    border-bottom: 1px solid #CCC;
margin-bottom: 10px;
font-weight: bold;
color: #404040;
font-size: 16px;
}

.add-event-box .add-event-header .add-event-pic {
        display: inline-block;
        width: 180px;
        float: left;
        margin-right: 10px;
        overflow: hidden;
        white-space: nowrap;
        height: 125px;
    }

/*

.theme_pic {
    width: auto;
    max-width: 180px;
    max-height: 125px;
    height: 125px;
}







.add-event-box .add-event-header .add-event-pic .add-event-pic-fx {
}



.add-event-pic-fx .add-event-pic-upload {
    color: white;
    border: 1px solid transparent;
    background-color: #000;
    opacity: 0.6;
    display: inline-block;
    padding: 6px 18px;
    border-radius: 2px;
    font-size: 15px;
    margin-right: 45%;
    margin-top: 45%;
    font-weight: 600;
}



    .add-event-pic-fx .add-event-pic-upload:hover {
        border: 1px solid white;
        cursor: pointer;
    }

    .add-event-pic-fx .add-event-pic-upload:active {
        border: 1px solid rgba(255,255,255,.7);
    }





.add-event-pic-toggler {
    border-radius: 2px;
    height: 10px;
    margin-top: 75px;
    margin-left: 55px;
    position: absolute;
}



.add-event-pic-actual {
    white-space: nowrap;
    min-height: 125px;
}



.add-event-pic-toggler div {
    background-color: #000;
    height: 32px;
    width: 32px;
    display: inline-block;
    float: left;
    margin-right: 2px;
    border-radius: 2px;
    opacity: 0.65;
}



    .add-event-pic-toggler div .toggle-icon {
        position: relative;
        margin: auto;
        top: 7.5px;
        width: 10px;
        height: 15px;
        background-repeat: no-repeat;
    }





.add-event-pic-toggler .add-event-right .toggle-icon {
    background-image: url(img/toggle-arrows-right.png);
    left: 13px;
    top: 9px;
}



.add-event-pic-toggler .add-event-left .toggle-icon {
    background-image: url(img/toggle-arrows-left.png);
    left: 11px;
    top: 9px;
}



.add-event-pic:hover > div div {
    opacity: 1;
}

.add-event-left, .add-event-right {
    border: 1px solid transparent;
}



    .add-event-left:hover, .add-event-right:hover {
        border: 1px solid white;
        cursor: pointer;
    }



    .add-event-left:active, .add-event-right:active {
        border: 1px solid rgba(255,255,255,.7);
    }

*/
input.inp-thr {
    border: 1px solid #d9d9d9;
    border-top: 1px solid #c0c0c0;
    height: 29px;    
    border-radius: 3px;
    color: #222;
    width: 387px;
    margin-bottom: 10px;
    font-size: 14px;
    margin-top: 4px;
    font-weight: 500;
}

input.inp-twof {
    border: 1px solid #d9d9d9;
    border-top: 1px solid #c0c0c0;
    height: 29px;    
    border-radius: 3px;
    color: #222;
    width: 175px;
    font-size: 14px;
    font-weight: 500;
}

input.inp-icon-left {
    text-indent: 27px;
}



input.event-date {
    border-radius: 3px 0px 0px 3px;
    display: inline-block;
    float: left;
    background: #FFF url('img/cal_icon_major.png') no-repeat 0% 50%;
    padding-left: 10px;
    background-size: 25px;
    background-position: 2%;
    margin-right: 12px;
    margin-left: 0px;
    width: 130px;
}



span.event-date-icon {
    background-image: url('img/cal_icon_major.png');
    background-size: cover;
    width: 24px;
    height: 24px;
    background-repeat: no-repeat;
    margin-top: 3px;
    position: relative;
    left: 103px;
}



input.inp-foc:focus {
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);
}



input.inp-foc:hover {
    border-color: #66afe9;
}

.event_name_error{
    border-color: rgb(255, 74, 74) !important;
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(233, 118, 102, 0.6) !important;
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6) !important;
}

.event_name_error:focus{
    border-color: rgb(255, 74, 74) !important;
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(233, 118, 102, 0.6) !important;
    -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6) !important;
}

div.header-inp-wrap div.event-repeat {
    display: inline-block;
    float: left;
    border-radius: 0px 3px 3px 0;
    width: 19.7%;
}

.status-event-repeat {
    float: right;
    border-radius: 3px;
    width: 19.7%;
    display: inline-block;
    margin-top: 10px;
}

div.header-inp-wrap div.add-event-box-dd, .status-add-event-box-dd {
    -webkit-box-shadow: 0 1px 0 rgba(0,0,0,.05);
    box-shadow: 0 1px 0 rgba(0,0,0,.05);
    background-color: #fff;
    background-image: -webkit-linear-gradient(top,transparent,transparent);
    height: 30px;
    background-image: linear-gradient(top,transparent,transparent);
    color: #404040;
    border: 1px solid #d9d9d9;
    cursor: pointer;
    border: 1px solid rgba(0,0,0,.15);
}

.status-add-event-box-dd {
    line-height: 2;
    padding-left: 5px;
}

    div.header-inp-wrap div.add-event-box-dd:hover, .status-add-event-box-dd:hover {
        -webkit-box-shadow: 0 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 0 rgba(0,0,0,.1);
        background-color: #fff;
        background-image: -webkit-linear-gradient(top,transparent,transparent);
        background-image: linear-gradient(top,transparent,transparent);
        border-color: #66afe9;
        color: #222;
    }

    div.header-inp-wrap div.add-event-box-dd:active, .status-add-event-box-dd:active {
        background: #e5e5e5;
        -webkit-box-shadow: inset 0 2px 0 #ddd, inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);
        box-shadow: inset 0 2px 0 #ddd, inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);
        border: 1px solid #66afe9;
    }

div.header-inp-wrap div.add-event-box-dd span.dd-title, .status-ddtitle {
    font-size: 11px;
    font-weight: 600;
    padding-left: 2px;
    color: rgba(64, 64, 64, 0.83);
    position: relative;
    top: 6px;
    float: left;
}

input.inp-foc:hover ~ span.down-arrow, input.inp-foc:focus ~ span.down-arrow, div.add-event-box-dd:hover > span.down-arrow {
    background-image: url(img/down_arrow_foc_hov.png);
    transition: background-image .1s ease;
}

span.down-arrow {
    background: center center no-repeat url(img/down_arrow.png);
    background-size: cover;
    display: inline-block;
    width: 9px;
    height: 9px;
    cursor: pointer;
    position: relative;
    top: 12px;
    float: right;
    right: 6px;
}



.pos-abs {
    position: absolute;
}

.status-repeatoptiont-1 {
    cursor: pointer;
    text-align: left;
    width: 100%;
    float: left;
    font-family: "Open Sans",sans-serif;
    margin-top: 3px;
    padding: 3px 11px;
    border-top: 1px solid transparent;
    border-bottom: 1px solid transparent;
}

    .status-repeatoptiont-1:hover {
        color: white;
        background-color: #CCC;
    }

.dd-box, .status-dd-box {
        box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.3);
    background-color: #FFF;
    z-index: 500;
    border-style: solid;
    -moz-border-top-colors: none;
    -moz-border-right-colors: none;
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    border-image: none;
    border-width: 1px 1px 2px;
    border-color: #333 #333 #293E6A;
    font-size: 12.5px;
    font-weight: bold;
    color: #5B5E64;
    margin-top: 30px;
    position: absolute;
    margin-left: 179px;
    border-radius: 0px;
    width: 97px;
    overflow: hidden;
}

.status-dd-box {
    margin-left: 78%;
    margin-top: 12px;
    width: 130px;
}


.dd-box-show {
    display: block;
    opacity: 1;
}



span.down-arrow-down {
    background: center center no-repeat url(img/down_arrow.png);
    background-size: cover;
    display: inline-block;
    width: 9px;
    height: 9px;
    cursor: pointer;
    position: relative;
    z-index: 100;
    float: left;
    display: inline;
    left: 136px;
    pointer-events: none;
    top: 23px;
}



input.inp-half {
    border: 1px solid #d9d9d9;
    border-top: 1px solid #c0c0c0;
    height: 29px;
    padding-left: 5px;
    border-radius: 3px;
    color: #222;    
    width: 92px;
    z-index: 300;
    font-size: 14px;
    font-weight: 500;
}

a.add-endtime {
    font-size: 14px;
    margin-left: 10px;
    color: #029acf;
    font-weight: 400;
    float: right;
    margin-top: 7px;
}



    a.add-endtime:hover {
        color: #016283;
        cursor: pointer;
        text-decoration: underline;
    }



input.event-start-time {
}



input.event-end-time {
    display: none;
    margin-left: 3px;
    transition: .2s opacity ease;
    opacity: 0;
}



span.down-arrow-2 {
    display: none;
    position: absolute;
    left: 504px;
    top: 123px;
}



div.left-wedge-solid {
    font-size: 0px;
    line-height: 0%;
    width: 0px;
    z-index: 2;
    position: absolute;
    left: 228px;
    top: 173px;
    border-top: 12px solid rgba(255, 255, 255, 0);
    border-right: 15px solid #f5f5f5;
    border-bottom: 12px solid rgba(246, 246, 246, 0);
}



.st-time-dd, .end-time-dd {
    height: 250px;
    width: 150px;
    border-radius: 0px 0px 3px 3px;
    border: 1px solid #66afe9;
    border-top: none;
    position: absolute;
    z-index: 30;
    display: none;
    opacity: 0;
    background-color: white;
    top: 136px;
}



.st-time-dd {
    left: 210px;
}

input.event-start-time:focus ~ .st-time-dd, input.event-end-time:focus ~ .end-time-dd {
    display: block;
    opacity: 1;
}

.end-time-dd {
    left: 369px;
    z-index: 200;
    width: 149px;
}


/* timer styles */

.set_time1 {
    width: 94px;
    border-radius: 2px;
    border: 1px solid #AAB2C4;
    font-size: 12px;
    color: rgb(36, 36, 36);
    text-transform: lowercase;
    float: right;
    background-color: white;
    border: 1px solid #dddddd;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    -o-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
}

    .set_time1:-ms-input-placeholder {
        text-transform: none !important;
    }

    .set_time1::-webkit-input-placeholder {
        text-transform: none !important;
    }

    .set_time1:-moz-placeholder {
        text-transform: none !important;
    }

    /* firefox 19+ */
    .set_time1::-moz-placeholder {
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
    z-index: 9999;
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

span.event-loc-icon {
    background-image: url(img/event-loc-icon.png);
    background-size: cover;
    width: 20px;
    pointer-events: none;    
    display: block;
    position: relative;
    height: 22px;
    background-repeat: no-repeat;
    top: 48px;

}

.event-loc
{
background-image: url(img/event-loc-icon.png);
background-size: 25px;
background-repeat: no-repeat;
background-position: 0%;
}

div.add-event-box-main-row input.inp-one, div.add-event-box-main-row textarea.inp-one {
    border: 1px solid #d9d9d9;
    border-top: 1px solid #c0c0c0;
    height: 29px;
    padding-left: 8px;
    border-radius: 3px;
    color: #222;
    width: 98%;
    margin-bottom: 10px;
    font-size: 14px;
    margin-top: 10px;
    text-indent: 21px;
    font-weight: 500;
}

    div.add-event-box-main-row input.inp-one:hover, div.add-event-box-main-row textarea.inp-one:hover {
        border-color: #66afe9;
    }

    div.add-event-box-main-row input.inp-one:focus, div.add-event-box-main-row textarea.inp-one:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);
    }



div.add-event-box-main-row input.event-details, div.add-event-box-main-row textarea.event-details {
    margin-top: 0px;
    text-indent: 0;
}


.repeatc-1 {
    border-top: 1px solid #E9EAED;
    margin-top: 40px;
    width: 98%;
    height: 40px;
    font-size: 13px;
    margin-left: 10px;
}

.repeathead-1 {
    float: left;
    width: auto;
    height: 40px;
    text-align: center;
    line-height: 40px;
    color: #A8ABAF;
    font-weight: 600;
}

.repeatstate-1 {
    float: left;
    width: auto;
    padding-left: 6px;
    padding-right: 6px;
    margin-left: 5px;
    line-height: 40px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: underline;
    opacity: 0.7;
}

.repeatoption-1 {
    position: absolute;
    width: 150px;
    font-weight: 600;
    color: rgba(0,0,0,0.7);
    height: 125px;
    margin-top: 39px;
    margin-left: 55px;
    display: none;
    margin-bottom: 5px;
    -webkit-background-clip: padding-box;
    background-color: #fff;
    border: 1px solid #E9EAED;
    -webkit-border-radius: 3px;
    -webkit-box-shadow: 0 3px 8px rgba(0, 0, 0, .3);
    width: 125px;
    cursor: default;
    padding-bottom: 3px;
    z-index: 100;
}

.repeatoptiont-1 {
    cursor: pointer;
    text-align: left;
    width: 100%;
    float: left;
    border-bottom: 1px solid #ccc;
    font-family: 'Open Sans', sans-serif;
    margin-top: 3px;
    padding: 3px 11px;
    border-top: 1px solid transparent;
    border-bottom: 1px solid transparent;
}

    .repeatoptiont-1:hover {
        color: white;        
        background-color: #CCC;/*#01e2a7;
        border-top: 1px solid #42B67E;
        border-bottom: 1px solid #3AC979;*/
    }


img.reply_attach {
    position: relative;
    cursor: pointer;
    display: block;
    opacity: 1;
    margin-top: 12px;
    margin-left: 10.5px;
    right: -95%;
    top: -10px;
}

.feed_upload_textprompt {
    display: none;
    font-size: 12px;
    color: #989898;
    float: left;
    position: relative;
    top: -27px;
    right: -375px;
}

.upload_feed_hack {
    display: none;
}


.add-event-box-main-row .add-event-box-btns-wrap button.add-event-box-cancel {
        cursor: pointer;
        border: 1px solid #e1e8ed;
        padding: 8px 16px;
        font-size: 14.5px;
        color: #4D4D4D;
        text-align: center;
        font-weight: 600;
        padding-top: 9.5px;
        padding-bottom: 9.5px;
        margin-right: 0px;
        float: right;
        border-radius: 4px;
        margin-left: 8px;
        outline: none;
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        background-color: #e1e8ed;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        background-image: linear-gradient(#fff,#E9ECEE);
        -ms-filter: "progid:DXImageTransform.Microsoft.gradient(enabled=false)";
        border-color: #e1e8ed;
    }



        .add-event-box-main-row .add-event-box-btns-wrap button.add-event-box-cancel:hover {
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.18);
            background-color: #E0E4E7;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.18);
            background-image: linear-gradient(#F8F7F7,#E0E4E7);
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(enabled=false)";
            border-color: #D4DBE0;
            color: #222;
        }

        .add-event-box-main-row .add-event-box-btns-wrap button.add-event-box-cancel:active {
            color: #222;
            border-color: #C9CBCC;
            box-shadow: inset 0 1px 4px rgba(0,0,0,0.2);
            background-image: linear-gradient(#F1F1F1,#E0E4E7);
        }

    .add-event-box-main-row .add-event-box-btns-wrap button.add-event-box-create {
        font-weight: bold;
        font-size: 15px;
        margin-right: 5px;
        margin-top: 1px;
        padding: 9.5px 16px;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        color: #FFF;
        border-style: solid;
        text-align: center;
        float: right;
        cursor: pointer;
        border-top: none;
        text-decoration: none;
        text-shadow: 0 1px 1px rgba(49, 117, 85, 0.56);
        border-color: transparent;
        transition: all 0.15s ease;
        -moz-transition: all 0.15s ease;
        border-width: 1px;
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.15);
        background-color: #1CE69C;
        outline: none;
        background: rgba(28,230,156,.8);
    }

        .add-event-box-main-row .add-event-box-btns-wrap button.add-event-box-create:hover {
            cursor: pointer;
            -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            background-color: #1ce69c;
            background-image: linear-gradient(top,#22C791,#1AAC7C);
            background-image: linear-gradient(rgba(0,0,0,0),rgba(0,0,0,0.15));
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#00000000, endColorstr=#26000000)";
            border-top: none;
        }

        .add-event-box-main-row .add-event-box-btns-wrap button.add-event-box-create:active {
            background-image: linear-gradient(rgba(0,0,0,0.15),rgba(0,0,0,0.15));
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#26000000, endColorstr=#26000000)";
            border-color: transparent;
            background-color: #1CE69C;
            background: rgba(28,230,156,.8);
            -webkit-box-shadow: inset 0 1px 4px rgba(0,0,0,0.3);
            box-shadow: inset 0 1px 4px rgba(0,0,0,0.3);
            color: #fff;
        }



    .add-event-box-main-row .add-event-box-btns-wrap button.add-event-box-delete {
        font-weight: bold;
        font-size: 15px;
        margin-top: 1px;
        padding: 9.5px 16px;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        color: #FFF;
        border-style: solid;
        text-align: center;
        float: left;
        cursor: pointer;
        border-top: none;
        text-decoration: none;
        text-shadow: 0 1px 1px rgba(49, 117, 85, 0.56);
        border-color: transparent;
        transition: all 0.15s ease;
        -moz-transition: all 0.15s ease;
        border-width: 1px;
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.15);
        background-color: #1CE69C;
        outline: none;
        background: rgba(255, 53, 53, 0.8);
        display: none;
    }

        .add-event-box-main-row .add-event-box-btns-wrap button.add-event-box-delete:hover {
            cursor: pointer;
            -moz-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            background-color: rgba(230, 34, 34, 1);
            background-image: linear-gradient(top,#22C791,#1AAC7C);
            background-image: linear-gradient(rgba(0,0,0,0),rgba(0,0,0,0.15));
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#00000000, endColorstr=#26000000)";
            border-top: none;
        }

        .add-event-box-main-row .add-event-box-btns-wrap button.add-event-box-delete:active {
            background-image: linear-gradient(rgba(0,0,0,0.15),rgba(0,0,0,0.15));
            -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#26000000, endColorstr=#26000000)";
            border-color: transparent;
            background-color: rgba(230, 34, 34, 1);
            background: rgba(230, 34, 34, 1);
            -webkit-box-shadow: inset 0 1px 4px rgba(0,0,0,0.3);
            box-shadow: inset 0 1px 4px rgba(0,0,0,0.3);
            color: #fff;
        }

</style>
    <link rel="stylesheet" type="text/css" href="css/datepicker.css" />
    <script src='js/jquery-ui.custom.min.js'></script>
    <script type="text/javascript" src="js/jquery.datepick.js"></script>
    <script src='js/jquery.min.js'></script>
    <script src="js/jquery-ui-1.10.2.custom.min.js"></script>    
    <script src="js/calendar_selector.js" type="text/javascript"></script>
    <script src="js/jquery.timeAutocomplete.min.js" type="text/javascript"></script>
    <script src="js/ampm.js" type="text/javascript"></script>    
</head>
<body>
<button onclick="loadAddEventSchedule();" id="btn_add_event_schedule" style="display:none;"> </button>
<div class="blackcanvas30">
    <div class = "add-event-box">
        <!--<div class="add-event-box-edit-header">
            Add Schedule                  
        </div>-->
        <div class = "add-event-header">
           <!-- <div class = "add-event-pic">
                <div class = "add-event-pic-actual">
                    
                </div>                
            </div>
            <div class = "add-event-pic-toggler">
                <div class = "add-event-left">
                    <div class = "toggle-icon">
                    </div>
                </div>

                <div class = "add-event-right">
                    <div class = "toggle-icon">
                    </div>
                </div>
            </div>-->
            <div class = "header-inp-wrap">
                <input id = "nevt-title-1" type = "text" class = "inp-foc inp-thr event-title" label = "Event title" placeholder = "Schedule title">
            </div>
            <div class = "header-inp-wrap" id="class_schedule_type_dropdown">
                <div class="event-repeat add-event-box-dd dept-dropdown" style="float: right; margin-top: -43px; border-radius: 3px;">
                    <span class="dd-title schedule-type-title">Lecture</span><span class="down-arrow" ></span>
                    <span class='selected-value-to-send' id='scheduleType' style='display:none;'>Lecture</span>
                </div>
                <div class="click-out dd-box" id='schedule_type' style='display:none;margin-left:400px; margin-top:-10px; width: 110px;'>
                    <div class='repeatoptiont-1' id='Essay'>Essay</div>                    
                    <div class='repeatoptiont-1' id='Project'>Project</div>                        
                    <div class='repeatoptiont-1' id='Assignment'>Assignment</div>                        
                    <div class='repeatoptiont-1' id='Guest Lecture'>Guest Lecture</div>    
                    <div class='repeatoptiont-1' id='Exam'>Exam</div>                        
                    <div class='repeatoptiont-1' id='Lecture'>Lecture</div>                        
                    <div class='repeatoptiont-1' id='Presentation'>Presentation</div>               
                    <div class='repeatoptiont-1' id='Recitation'>Recitation</div>  
                </div>
            </div>
            <div class = "header-inp-wrap calendar">
                <input type="text" readonly name="event_date" id="event_date" class = "set_date inp-foc inp-twof event-date inp-icon-left" label = "Event date"> 
                <!--<span class = "event-date-icon"></span>-->                
                <div class="calLayer">
                                                            <section id="mounth" class="mounth" style="margin-left:0px; margin-top: 30px;">
                                                                <header class="minical-header">
                                                                    <h1 class="minical-h1">JANUARY 2013</h1>
                                                                    <nav role="padigation">
                                                                        <span class="m-prev"></span>
                                                                        <span class="m-next"></span>
                                                                    </nav>
                                                                </header>
                                                                <article>
                                                                    <div class="days">
                                                                        <b>SU</b>
                                                                        <b>MO</b>
                                                                        <b>TU</b>
                                                                        <b>WE</b>
                                                                        <b>TH</b>
                                                                        <b>FR</b>
                                                                        <b>SA</b>
                                                                    </div>
                                                                    <div class="dates">
                                                                        <span id="calcell_su_0" class="calcell disable cl_0"></span>
                                                                        <span id="calcell_mo_1" class="calcell disable cl_1"></span>
                                                                        <span id="calcell_tu_2" class="calcell disable cl_2"></span>
                                                                        <span id="calcell_we_3" class="calcell disable cl_3"></span>
                                                                        <span id="calcell_th_4" class="calcell disable cl_4"></span>
                                                                        <span id="calcell_fr_5" class="calcell disable cl_5"></span>
                                                                        <span id="calcell_sa_6" class="calcell disable cl_6"></span>
                                                                        <span id="calcell_su_7" class="calcell disable cl_7"></span>
                                                                        <span id="calcell_mo_8" class="calcell disable cl_8"></span>
                                                                        <span id="calcell_tu_9" class="calcell disable cl_9"></span>
                                                                        <span id="calcell_we_10" class="calcell disable cl_10"></span>
                                                                        <span id="calcell_th_11" class="calcell disable cl_11"></span>
                                                                        <span id="calcell_fr_12" class="calcell disable cl_12"></span>
                                                                        <span id="calcell_sa_13" class="calcell disable cl_13"></span>
                                                                        <span id="calcell_su_14" class="calcell disable cl_14"></span>
                                                                        <span id="calcell_mo_15" class="calcell disable cl_15"></span>
                                                                        <span id="calcell_tu_16" class="calcell disable cl_16"></span>
                                                                        <span id="calcell_we_17" class="calcell disable cl_17"></span>
                                                                        <span id="calcell_th_18" class="calcell disable cl_18"></span>
                                                                        <span id="calcell_fr_19" class="calcell disable cl_19"></span>
                                                                        <span id="calcell_sa_20" class="calcell disable cl_20"></span>
                                                                        <span id="calcell_su_21" class="calcell disable cl_21"></span>
                                                                        <span id="calcell_mo_22" class="calcell disable cl_22"></span>
                                                                        <span id="calcell_tu_23" class="calcell disable cl_23"></span>
                                                                        <span id="calcell_we_24" class="calcell disable cl_24"></span>
                                                                        <span id="calcell_th_25" class="calcell disable cl_25"></span>
                                                                        <span id="calcell_fr_26" class="calcell disable cl_26"></span>
                                                                        <span id="calcell_sa_27" class="calcell disable cl_27"></span>
                                                                        <span id="calcell_su_28" class="calcell disable cl_28"></span>
                                                                        <span id="calcell_mo_29" class="calcell disable cl_29"></span>
                                                                        <span id="calcell_tu_30" class="calcell disable cl_30"></span>
                                                                        <span id="calcell_we_31" class="calcell disable cl_31"></span>
                                                                        <span id="calcell_th_32" class="calcell disable cl_32"></span>
                                                                        <span id="calcell_fr_33" class="disable calcell cl_33"></span>
                                                                        <span id="calcell_sa_34" class="disable calcell cl_34"></span>
                                                                        <span id="calcell_su_35" class="disable calcell cl_35"></span>
                                                                        <span id="calcell_mo_36" class="disable calcell cl_36"></span>
                                                                        <span id="calcell_tu_37" class="disable calcell cl_37"></span>
                                                                        <span id="calcell_we_38" class="disable calcell cl_38"></span>
                                                                        <span id="calcell_th_39" class="disable calcell cl_39"></span>
                                                                        <span id="calcell_fr_40" class="disable calcell cl_40"></span>
                                                                        <span id="calcell_sa_41" class="disable calcell cl_41"></span>
                                                                    </div>
                                                                </article>
                                                            </section>
                                                        </div>
                <div class = "event-repeat add-event-box-dd calendar">
                    <span class = "dd-title repeat-type-title">Repeat</span>
                    <span class = "down-arrow"></span>
                    <span class='selected-value-to-send' id='repeatType' style='display:none;'></span>
                    <!--<span class = "event-date-icon" id="repeat_date_icon" style="display:none;"></span>-->
                    <input class="set_date" name="event_date" id="repeat_end_date" style="display:none;" />
                                                        <!--<div class="calLayer">
                                                            <section id="Section2" class="mounth" style="margin-left: 0px;margin-top: 7px;">
                                                                <header class="minical-header">
                                                                    <h1 class="minical-h1">JANUARY 2013</h1>
                                                                    <nav role="padigation">
                                                                        <span class="m-prev"></span>
                                                                        <span class="m-next"></span>
                                                                    </nav>
                                                                </header>
                                                                <article>
                                                                    <div class="days">
                                                                        <b>SU</b>
                                                                        <b>MO</b>
                                                                        <b>TU</b>
                                                                        <b>WE</b>
                                                                        <b>TH</b>
                                                                        <b>FR</b>
                                                                        <b>SA</b>
                                                                    </div>
                                                                    <div class="dates">
                                                                        <span id="calcell_su_0" class="calcell disable cl_0"></span>
                                                                        <span id="calcell_mo_1" class="calcell disable cl_1"></span>
                                                                        <span id="calcell_tu_2" class="calcell disable cl_2"></span>
                                                                        <span id="calcell_we_3" class="calcell disable cl_3"></span>
                                                                        <span id="calcell_th_4" class="calcell disable cl_4"></span>
                                                                        <span id="calcell_fr_5" class="calcell disable cl_5"></span>
                                                                        <span id="calcell_sa_6" class="calcell disable cl_6"></span>
                                                                        <span id="calcell_su_7" class="calcell disable cl_7"></span>
                                                                        <span id="calcell_mo_8" class="calcell disable cl_8"></span>
                                                                        <span id="calcell_tu_9" class="calcell disable cl_9"></span>
                                                                        <span id="calcell_we_10" class="calcell disable cl_10"></span>
                                                                        <span id="calcell_th_11" class="calcell disable cl_11"></span>
                                                                        <span id="calcell_fr_12" class="calcell disable cl_12"></span>
                                                                        <span id="calcell_sa_13" class="calcell disable cl_13"></span>
                                                                        <span id="calcell_su_14" class="calcell disable cl_14"></span>
                                                                        <span id="calcell_mo_15" class="calcell disable cl_15"></span>
                                                                        <span id="calcell_tu_16" class="calcell disable cl_16"></span>
                                                                        <span id="calcell_we_17" class="calcell disable cl_17"></span>
                                                                        <span id="calcell_th_18" class="calcell disable cl_18"></span>
                                                                        <span id="calcell_fr_19" class="calcell disable cl_19"></span>
                                                                        <span id="calcell_sa_20" class="calcell disable cl_20"></span>
                                                                        <span id="calcell_su_21" class="calcell disable cl_21"></span>
                                                                        <span id="calcell_mo_22" class="calcell disable cl_22"></span>
                                                                        <span id="calcell_tu_23" class="calcell disable cl_23"></span>
                                                                        <span id="calcell_we_24" class="calcell disable cl_24"></span>
                                                                        <span id="calcell_th_25" class="calcell disable cl_25"></span>
                                                                        <span id="calcell_fr_26" class="calcell disable cl_26"></span>
                                                                        <span id="calcell_sa_27" class="calcell disable cl_27"></span>
                                                                        <span id="calcell_su_28" class="calcell disable cl_28"></span>
                                                                        <span id="calcell_mo_29" class="calcell disable cl_29"></span>
                                                                        <span id="calcell_tu_30" class="calcell disable cl_30"></span>
                                                                        <span id="calcell_we_31" class="calcell disable cl_31"></span>
                                                                        <span id="calcell_th_32" class="calcell disable cl_32"></span>
                                                                        <span id="calcell_fr_33" class="disable calcell cl_33"></span>
                                                                        <span id="calcell_sa_34" class="disable calcell cl_34"></span>
                                                                        <span id="calcell_su_35" class="disable calcell cl_35"></span>
                                                                        <span id="calcell_mo_36" class="disable calcell cl_36"></span>
                                                                        <span id="calcell_tu_37" class="disable calcell cl_37"></span>
                                                                        <span id="calcell_we_38" class="disable calcell cl_38"></span>
                                                                        <span id="calcell_th_39" class="disable calcell cl_39"></span>
                                                                        <span id="calcell_fr_40" class="disable calcell cl_40"></span>
                                                                        <span id="calcell_sa_41" class="disable calcell cl_41"></span>
                                                                    </div>
                                                                </article>
                                                            </section>
                                                        </div>-->
               </div>
               <div class = "click-out dd-box" style='display:none;margin-left:210px;' id='event_repeat'>                                                        
                        <div class='repeatoptiont-1' id='None'>None</div>                    
                        <div class='repeatoptiont-1' id='Daily'>Daily</div>                        
                        <div class='repeatoptiont-1' id='Weekly'>Weekly</div>                        
                        <div class='repeatoptiont-1' id='Monthly'>Monthly</div>                    
               </div>
            </div>
            <div class = "header-inp-wrap">
                <span class = "">
                    <input type = "text" id="set_from_time_24hr" style="float:left; margin-left:10px;"
                     class = "set_time1 inp-foc inp-half event-start-time" label = "Event time">
                    <!--<span class = "down-arrow down-arrow-down"></span>
                    <div class = "st-time-dd">
                    </div>-->
                </span>
                <span class="">
                    <a class = "add-endtime">
                    Add end time
                    </a>
                    <input id="set_to_time_24hr" type = "text" class = "set_time1 inp-foc inp-half event-end-time" label = "Event end time" >
                    <!--<span class = "down-arrow down-arrow-2 down-arrow-down"></span>
                    <span class = "revert-end-time">
                    </span>
                     <div class = "end-time-dd">
                    </div>-->
                </span>                        
            </div>
             <script type="text/javascript">       
                $(".set_time1").timeAutocomplete({
                    increment: 15,
                    formatter: "ampm",
                    value: '',                                      
                    auto_value: false                                                       
                });
            </script>
        </div>
        <div class = "add-event-box-main">
            <div class = "add-event-box-main-row">
                <!--<span class = "event-loc-icon"></span>-->
                <input id="nevt-location-1" type = "text" class = "inp-foc inp-one event-loc inp-icon-left" label = "Event location" placeholder = "Location (optional)">                
            </div>
            <div class = "add-event-box-main-row">
                <textarea id="nevt-desc-1" type = "text" class = "inp-foc inp-one event-details" rows="4" 
                    label = "Event details" placeholder = "Details (optional)" style="resize:none;height:29px;padding-top:6px;"></textarea>
            </div>
            <!--<div id="fileAttach" class = "add-event-box-main-row">
                <img class="reply_attach" src="img/comment_attach.png"  title="attach a file"></img>
                <form enctype="multipart/form-data">
                    <input class="upload_feed_hack" id="upload_feed_hack" type="file" name="file"></input>
                </form>
                <div class="feed_upload_textprompt" style="display: block;" title="No file attached"></div>
            </div>-->
            <div class = "add-event-box-main-row">
                <div class = "add-event-box-btns-wrap">
                    <button class = "add-event-box-btns add-event-box-cancel" id="divCancel">
                        Cancel
                    </button>
                     <button class = "add-event-box-btns add-event-box-create"  id="btnAddThisEvent">
                        Add Schedule
                    </button>
                    <button id="btnDeleteEvent" class = "add-event-box-btns add-event-box-delete"  id="btnAddThisEvent">
                        Delete 
                    </button>
                </div>
            </div>
        </div>    
                                </div>

                            </div>                  
</body>
</html>

<script type="text/javascript">
    function loadAddEventSchedule(){
        $('.blackcanvas30').show();
        $('.add-event-box').show();
    }    

</script>

<script type="text/javascript">
        $(document).ready(function () {

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

            if ((qs['class_id'] != null) && (qs['class_id'] != ""))
            {
                $('#class_schedule_type_dropdown').show();                
            }
            else
            {
                $('#class_schedule_type_dropdown').hide();    
                $('#nevt-title-1').css('width', '98%');
            }

            $(document).on("click", function (e) {
                var elem = $(e.target);
                if (elem.hasClass("set_date") || elem.hasClass("padigation") || elem.hasClass("mounth")
                    || elem.hasClass("minical-h1") || elem.hasClass("m-prev") || elem.hasClass("m-next") || elem.hasClass('event-date-icon')) {
                    
                    elem.closest('.calendar').find('.calLayer').show();
                }
                else {
                    $('.calLayer').hide();
                }

                 if (elem.hasClass("repeatoptiont-1") || elem.hasClass("click-out") || elem.hasClass("event-repeat") 
                    || elem.hasClass("dd-title") || elem.hasClass("down-arrow")) {
                    $(this).parents('.user-info-editable').children('#schedule_type').show();
                    $(this).parents('.website-inp-wrap').children('#event_repeat').show();
                }
                else {
                    $('#schedule_type').hide();
                    $('#event_repeat').hide();
                }
            });

            // $(document).delegate(".dd-title", "click", function () {
            //    $(".click-out").toggle();
            // });

            $(document).delegate('.add-endtime',"click", function(){
                $(this).hide();
                $(".revert-end-time").show();
                $(".event-end-time").show();
                $(".event-end-time").focus();
                $(".down-arrow-2").show();
                $(".event-end-time").css("opacity","1");
            });
            
            // $(document).delegate(".down-arrow", "click", function () {
            //     $(".click-out").toggle();
            // });

            $(document).delegate(".event-repeat", "click", function () {
                $(this).next('.click-out').toggle();
            });

            $(document).delegate(".down-arrow", "click", function () {
                $(this).parent('.event-repeat').next('.click-out').toggle();
            });

            $(document).delegate(".repeatoptiont-1", "click", function () {
                $(this).parents('.header-inp-wrap').find(".dd-title").text($(this).text());
                $(this).parent(".click-out").hide();
                if (($(this).text().trim() == "Daily") || ($(this).text().trim() == "Weekly") || ($(this).text().trim() == "Monthly")) {
                    //$('.repeat_date').show();
                    //$('#repeat_date_icon').css("display", "block");
                    //$('#event_date').css("width", "160px");
                    //$('#set_from_time_24hr').css("margin-left", "32px");
                }
                else {
                    //$('.repeat_date').hide();
                    //$('#repeat_date_icon').css("display", "none");
                    //$('#event_date').css("width", "175px");
                    //$('#set_from_time_24hr').css("margin-left", "10px");
                }

                var id = $(this).prop('id');
                $(this).parent('.click-out').prev(".event-repeat").children('.selected-value-to-send').text(id);     
            });

            $('#nevt-title-1').on('keyup', function () {

                $('#nevt-title-1').removeClass("event_name_error");
                $('#nevt-title-1').attr("placeholder", "Event title");
            });

            $('#btnAddThisEvent').click(function () {

                var start = new Date($('#event_date').val());
                var end = new Date($('#repeat_end_date').val());
                if (start >= end) {
                    end = start;
                }
                var repeat = $('#repeatType').text().toString().toLowerCase();
                if ((repeat == "none") || (repeat == "repeat") || (repeat == "")) {
                    repeat = "none";
                    end = start;
                }
                start = start.getFullYear() + '-' + ('0' + (start.getMonth() + 1)).substr(-2, 2) + '-' + ('0' + start.getDate()).substr(-2, 2);
                end = end.getFullYear() + '-' + ('0' + (end.getMonth() + 1)).substr(-2, 2) + '-' + ('0' + end.getDate()).substr(-2, 2);
                var locn = $('#nevt-location-1').val().toString();
                var title = $('#nevt-title-1').val().toString();
                if ((title == null) || (title.trim() == "")) {             
                    $('#nevt-title-1').addClass("event_name_error");
                    $('#nevt-title-1').attr("placeholder", "Please enter an event title...");
                    $('#nevt-title-1').focus();
                    return;
                }
                var desc = $('#nevt-desc-1').val().toString();
                var fromtime = $('#set_from_time_24hr').val().toString();
                var totime = $('#set_to_time_24hr').val().toString();
                var scheduleType = $('#scheduleType').text(); 
                var phpFilePath = "";
                var phpFetchFilePath = "";
                var classID = qs['class_id'];
                var groupID = qs['group_id'];                

                phpFilePath = "php/edit_class_details.php";

                if ((classID != null) && (classID != ""))
                {
                    phpFetchFilePath = "class_syllabus_tab.php";
                }
                else if ((groupID != null) && (groupID != ""))
                {                
                    phpFetchFilePath = "php/club_events_tab.php";
                }
                $.ajax({
                    url: phpFilePath,
                    data: 
                        phpFetchFilePath == "class_syllabus_tab.php" ?
                        {
                            title: title, location: locn, details: desc, start_date: start, end_date: end, start_time: fromtime
                            , end_time: totime, repeat: repeat, event_class: scheduleType, create_schedule: true, class_id: classID
                        } :
                        {
                            title: title, location: locn, details: desc, start_date: start, end_date: end, start_time: fromtime
                            , end_time: totime, repeat: repeat, event_class: scheduleType, create_group_schedule: true, club_id: groupID
                        },
                    type: "POST",
                    dataType: "text",
                    success: function (responseText) {               

                       $.ajax({
                            type: "POST",
                            url: phpFetchFilePath,
                            data: {
                                class_id: classID, club_id: groupID
                            },
                            success: function(html){
                                if (phpFetchFilePath == "class_syllabus_tab.php")
                                {
                                    $(".midsec").html(html);   
                                }
                                else
                                {
                                    $(".syllabus-tab-content").html(html);
                                }
                                $(".syllabus-tab-content").show();
                                $(".syllabus-tab-content").animate({ opacity: "1"},300);
                            }
                        });

                        $('.blackcanvas30').hide();
                        $('.add-event-box').hide();

                        clearInsertFields();
                    },
                    error: function (responseText) {
                        alert("failure" + responseText.responseText);
                        clearInsertFields();
                    }
                });        
            });

            $(document).delegate("#divCancel", "click", function (e) {

                $('.blackcanvas30').hide();
                $('.add-event-box').hide();

                clearInsertFields();
            });

            function clearInsertFields(){
                var param1 = new Date();
                var param2 = (param1.getMonth() + 1) + '/' + param1.getDate() + '/' + param1.getFullYear();
                $("#event_date").attr("value", param2);

                $('#nevt-location-1').val("");
                $('#nevt-title-1').val("");
                $('#nevt-desc-1').val("");

                $(".set_time1").timeAutocomplete({
                    increment: 15,
                    formatter: "ampm",
                    value: '',                                      
                    auto_value: false                                                       
                });                                

                $('.repeat-type-title').text("None");
                $('#repeatType').text("");
                $('.schedule-type-title').text("Lecture");
                $('#scheduleType').text("Lecture");
                $('#nevt-title-1').removeClass("event_name_error");
                $('#nevt-title-1').attr("placeholder", "Event title");

                $('.blackcanvas30').hide();
                $('.add-event-box').hide();
            }
        });
    </script>