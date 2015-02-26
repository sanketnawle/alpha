<!DOCTYPE HTML>
<html style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;"><head style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
    <!-- If you delete this tag, the sky will fall on your head -->
    <meta content="width=device-width" name="viewport" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
    <?php
        include_once 'module/datetime_helper.php';
    ?>
    <title style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">Club Event</title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
    <link href="email.css" rel="stylesheet" type="text/css" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300" rel="stylesheet" type="text/css" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
    <style style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
    /* ------------------------------------- 
        GLOBAL 
------------------------------------- */
* { 
    margin:0;
    padding:0;
}
* { font-family: 'Open Sans', sans-serif; }

img { 
    max-width: 100%; 
}
.collapse {
    margin:0;
    padding:0;
}
body {
    -webkit-font-smoothing:antialiased; 
    -webkit-text-size-adjust:none; 
    width: 100%!important; 
    height: 100%;
}


/* ------------------------------------- 
        ELEMENTS 
------------------------------------- */
a { color: #2BA6CB;}

a.btn.accept_btn{
    background: #1EC783;
    
    margin: 0 auto;
    display: block;
    margin-top: 18px;
    max-width: 400px;
    width: 80%;
    padding: 14px 0;
    font-size: 21px;
    border-bottom: 2px solid rgba(0, 0, 0, 0.21);
    font-weight: 600;
    border-radius: 5px;
}

.btn {
    text-decoration:none;
    color: #FFF;
    background-color: #666;
    padding:10px 16px;
    font-weight:bold;
    margin-right:10px;
    text-align:center;
    cursor:pointer;
    display: inline-block;
}

td.urlinq_tri_color{
    width: 33%;
    right:10px;
    height: 5px;
    top: 35px;
    position: relative;
}

div.thought_leader_frame{
    width: 100px;

    height: 100px;
    margin: 0 auto;
    background: #FFF;
    position: relative;
    margin-top: -90px;
    border-radius: 5px;
    padding: 3px;
}

div.thought_leader_frame_group{
    width: 110px;
    height: 110px;
    margin: 0 auto;
    background: #FFF;
    position: relative;
    margin-top: -90px;
    border-radius: 5px;
    padding: 3px;
    
    /* float:left; */
    margin-left:40px;
}

div.thought_leader_picture{
    width: 110px;
    height: 110px;
    border-radius: 4px;
}

.thought_leader_picture_group{
    width: 110px;
    height: 110px;
    border-radius: 4px;
}

div.tricolor_line{
    width: 32%;

    float: right;
    height: 7px;
    position: relative;
    display: inline-block;
}

div.tricolor_line.red{
    background: #ed4f68;

}
div.tricolor_line.green{
    background: #2cc185;
    
}
div.tricolor_line.blue{
    background: #1da7d2;
    
}

p.target_copy{
    font-size: 17px;
    color: #777;
    text-align: center;
    margin: 0 auto;
    max-width: 480px;
    width: 80%;
    margin-top: 20px;
}

p.post_target_copy{
    font-size: 16px;
    
    color: #575757;
    
    text-align: left;
    margin: 0 auto;
    
    max-width: 700px;
    width: 80%;
    
    margin-top: 7px;
}

p.callout {
    padding: 0px;
    background-color: #FFF;
    margin-bottom: 15px;
    text-align: center;
    font-size: 18px;
    font-weight: 400;
}

p.post_callout{
    padding: 0px;
    background-color: #FFF;
    margin-bottom: 15px;
    text-align: left;
    font-size: 18px;
    border-bottom: 1px solid #777;
    margin-left:40px;
    font-weight: 400;   
    padding-bottom: 6px;
    margin-right:40px;
}

td.intro{
color:#FFF;
font-size:20px;
padding-left:10px;
}

p.footer_text{
    color: #2cc185;

    font-size: 15.5px;
}

p.footer_text a{
    color: #FFF;
    
    text-decoration: none;
}

.callout a {
    font-weight: 400;
    color: #777;
    text-decoration: none;
}

.thought_leader_name{
    margin: 0 auto;
    text-align: center;
    padding: 7px 0;
    font-size: 25px;
    font-weight: 600;
    padding-bottom: 0;
}

.post_thought_leader_name{
    margin: 0 auto;
    text-align: left;
    padding: 7px 0;
    font-size: 21px;
    font-weight: 600;
    padding-bottom: 0;
    margin-left: 40px;
}

p.event_title{
    margin: 0 auto;
    text-align: left;
    padding: 7px 0;
    font-size: 21px;
    font-weight: 600;
    padding-bottom: 0;
    margin-left: 40px;
}

.post_thought_leader_name > a{
    color: #222;
    
    text-decoration: none;
}

p.target_copy_title{
    font-size: 21px; color: #222; text-align: left; margin: 0 auto; 
    max-width: 700px; width: 80%; margin-top: 16px;

}

a.group_link_btn{
    background: #029acf; margin: 0 auto; display: block; margin-top: 18px; 
    max-width: 250px; 
    display: inline-block;
    width: 80%; 
    border-radius: 4px;
    padding: 10px 0; 
    margin-left: 2px;
    font-size: 18px; border-bottom: 2px solid rgba(0, 0, 0, 0.21);

    margin-bottom: 6px;
    margin-left: 40px;
}

p.reply_text{
    display: inline;

    color: #777;
    font-weight: 200;
    display: block;
    margin-left: 2px;
    margin-bottom: 24px;
    margin-left: 40px;
}

span.post_details{
    color: #575757;

}

span.post_details > a.section_course_name{
    color: #029acf;
    text-decoration: none;
}


.thought_leader_name a{
    color: #222;
    
    text-decoration: none;
}

table.social {
/*  padding:15px; */
    
background-color: #09091a;
    
color: #FFF;
}
.social .soc-btn {
    padding: 3px 7px;
    font-size:12px;
    margin-bottom:10px;
    text-decoration:none;
    color: #FFF;font-weight:bold;
    display:block;
    text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn { 
    display:block;
    width:100%;
}

/* ------------------------------------- 
        HEADER 
------------------------------------- */
table.head-wrap { width: 100%;}

img.logo { 
padding: 15px;
width: 114px;
left: 7px;
position: relative;
height: 26px;
}

img.logo.tricolor_float_logo{
right: 0px;
height: 26px;
position: absolute;
width: 114px;
top: -50px;
left: 50%;
margin-lefT: -57px;
}

.header.container table td.label { padding: 15px; padding-left:0px;}


/* ------------------------------------- 
        BODY 
------------------------------------- */
table.body-wrap { width: 100%;}


/* ------------------------------------- 
        FOOTER 
------------------------------------- */
table.footer-wrap { width: 100%;    clear:both!important;
 background: #1d1f20; height: 110px; color: #FFF;}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
    font-size:10px;
    font-weight: bold;
    
}


/* ------------------------------------- 
        TYPOGRAPHY 
------------------------------------- */
h1,h2,h3,h4,h5,h6 {
 font-family: 'Open Sans', sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
}
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-weight:200; font-size: 44px;}
h2 { font-weight:200; font-size: 37px;}
h3 { font-weight:500; font-size: 27px;}
h4 { font-weight:500; font-size: 23px;}
h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

.collapse { margin:0!important;}

p, ul { 
    margin-bottom: 10px; 
    font-weight: normal; 
    font-size:14px; 
    line-height:1.6;
}
p.lead { font-size:17px; }
p.last { margin-bottom:0px;}

ul li {
    margin-left:5px;
    list-style-position: inside;
}

/* ------------------------------------- 
        SIDEBAR 
------------------------------------- */
ul.sidebar {
    background:#ebebeb;
    display:block;
    list-style-type: none;
}
ul.sidebar li { display: block; margin:0;}
ul.sidebar li a {
    text-decoration:none;
    color: #666;
    padding:10px 16px;
/*  font-weight:bold; */
    margin-right:10px;
/*  text-align:center; */
    cursor:pointer;
    border-bottom: 1px solid #777777;
    border-top: 1px solid #FFFFFF;
    display:block;
    margin:0;
}
ul.sidebar li a.last { border-bottom-width:0px;}
ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}



/* --------------------------------------------------- 
        RESPONSIVENESS
        Nuke it from orbit. It's the only way to be sure. 
------------------------------------------------------ */

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
    display:block!important;
    max-width: 800px!important;
    margin:0 auto!important; /* makes it centered */
    clear:both!important;
}

.container.header{
    height:72px;
}

/* This should also be a block element, so that it will fill 100% of the .container */
.content {
    padding: 0;
    max-width: 800px;
    margin:0 auto;
    display:block; 
    padding-top: 0;
}

/* Let's make sure tables in the content area are 100% wide */
.content table { width: 100%; border-spacing:0; }


/* Odds and ends */
.column {
    width: 300px;
    float:left;
}
.column tr td { padding: 15px; }
.column-wrap { 
    padding:0!important; 
    margin:0 auto; 
    max-width:600px!important;
}
.column table { width:100%;}
.social .column {
    width: 280px;
    min-width: 279px;
    float:left;
}

/* Be sure to place a .clear element after each set of columns, just to be safe */
.clear { display: block; clear: both; }


/* ------------------------------------------- 
        PHONE
        For clients that support media queries.
        Nothing fancy. 
-------------------------------------------- */
@media only screen and (max-width: 600px) {

    .date_month_box{
        display: none!important;
    }
    
    .event_details{
        margin-left:40px!important;
        width:100%!important;
    }

    .event_description{
        width:100%!important;
        max-width:300px!important;
        margin-left:0px!important;
    }

    a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

    div[class="column"] { width: auto!important; float:none!important;}
    
    table.social div[class="column"] {
        width:auto!important;
    }

}
</style>
</head>

<body bgcolor="#FFFFFF" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;height: 100%;width: 100%!important;">
    <!-- HEADER -->

    <table class="head-wrap" style="background-color: #1D1F20;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;">
        <tbody style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
            <tr style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                <td class="header container" style="margin: 0 auto!important;padding: 0;font-family: 'Open Sans', sans-serif;height: 72px;display: block!important;max-width: 800px!important;clear: both!important;">
                    <div class="content" style="margin: 0 auto;padding: 0;font-family: 'Open Sans', sans-serif;max-width: 800px;display: block;padding-top: 0;">
                        <table style="top: 22px;position: relative;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;border-spacing: 0;">
                            <tbody style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                                <tr style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                                    <td align="left" class="intro" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;color: #FFF;font-size: 20px;padding-left: 10px;">Hi
                                    <span class="user_first_name" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;"><?php echo $to_user->firstname; ?>,</span></td>

                                    <td align="right" class="urlinq_tri_color" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 33%;right: 10px;height: 5px;padding-top:7px;position: relative;">
                                        <img class="logo tricolor_float_logo" src="http://beta.urlinq.com/assets/email_logo.png" style="background-repeat: no-repeat;background-size: contain;margin: 0;padding: 15px;font-family: 'Open Sans', sans-serif;width: 114px;left: 50%;position: absolute;height: 26px;right: 0px;top: -50px;>

                                        <div class="tricolor_line red" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 32%;float: right;height: 7px;position: relative;display: inline-block;background: #ed4f68;"></div>

                                        <div class="tricolor_line blue" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 32%;float: right;height: 7px;position: relative;display: inline-block;background: #1da7d2;"></div>

                                        <div class="tricolor_line green" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 32%;float: right;height: 7px;position: relative;display: inline-block;background: #2cc185;"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table><!-- /HEADER -->
    <!-- BODY -->

    <table class="body-wrap" style="border-spacing: 0;margin-top: 0px;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;">
        <tbody style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
            <tr style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                <td style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;"></td>

                <td class="container" style="background-color: #FFFFFF;margin: 0 auto!important;padding: 0;font-family: 'Open Sans', sans-serif;display: block!important;max-width: 800px!important;clear: both!important;">
                    <div class="content" style="margin: 0 auto;padding: 0;font-family: 'Open Sans', sans-serif;max-width: 800px;display: block;padding-top: 0;">
                        <table style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;border-spacing: 0;">
                            <tbody style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                                <tr style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                                    <td style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                                        
                                        <div class="thought_leader_frame_group" style="margin: 0 auto;padding: 3px;font-family: 'Open Sans', sans-serif;width: 110px;height: 110px;background: #FFF;position: relative;margin-top: -90px;border-radius: 5px;margin-left: 40px;">
                                        <img class="thought_leader_picture_group" src="<?php echo Yii::app()->getBaseUrl(true) . $user->pictureFile->file_url; ?>" style="height: 100px;margin-top: 0px;border-radius: 3px;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 110px;"></div></a>
                                        <!-- Callout Panel -->

                                        <p class="event_intro" style="font-size: 21px;font-weight: 200;margin-right: 40px;border-bottom: 1px solid #777;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;line-height: 1.6;margin-left: 40px;margin-bottom: 20px;">
                                        <a href="http://www.urlinq.com" style="font-weight: 600;color: #222;text-decoration: none;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                                        <?php echo $user->firstname; ?> </a> created an event.</p>

                                        <div class="date_month_box" width = "82px" height = "82px" style="width: 82px;display: inline-block;height: 82px;border-radius: 5px;background: rgb(77, 77, 77);vertical-align: top;border: 1px solid rgba(0, 0, 0, 0.08);border-bottom-width: 3px;margin-right: 12px;margin: 0;margin-left: 40px;padding: 0;font-family: 'Open Sans', sans-serif;">
                                        <p style="background: rgba(0, 0, 0, 0.15);width: 100%;margin: 0;border-radius: 4px 4px 0 0;height: 16px;padding: 0;font-family: 'Open Sans', sans-serif;margin-bottom: 8px;font-weight: normal;font-size: 14px;line-height: 1.6;">
                                            </p>

                                            <p class="month" style="color: #FFF;text-align: center;font-size: 13.5px;width: auto;padding-bottom: 0px;font-weight: 600;padding-top: 7px;margin-bottom: 0px;text-shadow: rgba(0, 0, 0, 0.32) 1px 1px 0px;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;line-height: 1.6;">
                                            <?php echo date_string_to_month_name($event->start_date); ?></p>

                                            <p class="day" style="color: #FFF;text-align: center;font-size: 20px;padding: 21px;width: auto;font-weight: bold;padding-top: 0px;margin-top: -2px;text-shadow: rgba(0, 0, 0, 0.32) 1px 1px 0px;margin: 0;font-family: 'Open Sans', sans-serif;margin-bottom: 10px;line-height: 1.6;">
                                            <?php echo date_string_to_day_string($event->start_date); ?></p>
                                        </div>

                                        <div class="event_details" style="display: inline-block;width: 75%;max-width: 600px;margin-top: 3px;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;margin-left: 16px;">
                                        <p class="target_copy_title" style="display: inline-block;margin-top: -13px;font-size: 26px;margin: 0 auto;padding: 0;font-family: 'Open Sans', sans-serif;margin-bottom: 10px;font-weight: normal;line-height: 1.6;color: #222;text-align: left;max-width: 700px;width: 80%;">
                                            <span class="event_name" style="color: #121314;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;"><?php echo $event->title; ?></span> <span class="event_category" style="color: #999;font-size: 15px;text-transform: uppercase;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                                            <?php echo $event->origin_type; ?> meeting</span></p>

                                            <p class="event_when_where" style="display: inline-block;font-size: 17px;color: #222;margin-top: 2px;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;margin-bottom: 10px;font-weight: normal;line-height: 1.6;">
                                            <span class="event_when" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;"><?php echo date_time_string_to_pretty_timestamp($event->start_date . ' ' . $event->start_time); ?></span>
                                            <?php if($event->location != ''){ ?>
                                                <span class="vertical_bar" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">|</span>
                                                <span class="event_where" style="color: #009933;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;"><?php echo $event->location; ?></span></p>
                                            <?php } ?>
                                            <p class="post_target_copy event_description" style="width: 88%;margin-top: 0px;border-top: 1px solid #d8d8d8;border-bottom: 1px solid #d8d8d8;padding: 12px 8px;margin: 0 auto;font-family: 'Open Sans', sans-serif;margin-bottom: 18px;font-weight: normal;font-size: 16px;line-height: 1.6;color: #575757;text-align: left;max-width: 700px;margin-left: 0px;">
                                            <?php echo $event->description; ?></p>
                                        </div><a href="<?php echo Yii::app()->getBaseUrl(true) . '/' . $event->origin_type . '/' . $event->origin_id; ?>" class="btn group_link_btn" style="display: block;margin: 0 auto;padding: 10px 0;font-family: 'Open Sans', sans-serif;color: #FFF;text-decoration: none;background-color: #666;font-weight: bold;margin-right: 10px;text-align: center;cursor: pointer;background: #029acf;max-width: 250px;width: 80%;border-radius: 4px;margin-left: 40px;font-size: 18px;border-bottom: 2px solid rgba(0, 0, 0, 0.21);margin-bottom: 26px;">See
                                        what's next 
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>

                <td style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;"></td>
            </tr>
        </tbody>
    </table><!-- /BODY -->
    <!-- FOOTER -->

    <table class="footer-wrap" style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;background: #1d1f20;height: 110px;color: #FFF;clear: both!important;">
        <tbody style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
            <tr style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                <td style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;"></td>

                <td class="container" style="margin: 0 auto!important;padding: 0;font-family: 'Open Sans', sans-serif;display: block!important;max-width: 800px!important;clear: both!important;">
                    <!-- content -->

                    <div class="content" style="margin: 0 auto;padding: 0;font-family: 'Open Sans', sans-serif;max-width: 800px;display: block;padding-top: 0;">
                        <table style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;width: 100%;border-spacing: 0;">
                            <tbody style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                                <tr style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">
                                    <td align="center" style="margin: 0;padding: 44px;font-family: 'Open Sans', sans-serif;">
                                        <p class="footer_Text" style="color:#2cc185;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;margin-bottom: 10px;font-weight: normal;font-size: 14px;line-height: 1.6;">
                                            <a href="http://www.urlinq.com" style="text-decoration:none;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;color: #fff;">Urlinq, Inc 2015</a> |
                                            <a href="http://www.urlinq.com" style="text-decoration:none;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;color: #fff;">New York City</a> |
                                            <a href="http://www.urlinq.com" style="text-decoration:none;margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;color: #fff;"><unsubscribe style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;">Unsubscribe</unsubscribe></a>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /content -->
                </td>

                <td style="margin: 0;padding: 0;font-family: 'Open Sans', sans-serif;"></td>
            </tr>
        </tbody>
    </table><!-- /FOOTER -->

</body></html>