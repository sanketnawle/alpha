<!DOCTYPE html>
<html>
<head>
    <!-- If you delete this tag, the sky will fall on your head -->
    <meta content="width=device-width" name="viewport">

    <title>Club Event</title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <link href="email.css" rel="stylesheet" type="text/css">
    <link href=
    "http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300"
    rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF">
    <!-- HEADER -->

    <table class="head-wrap" style="background-color: #1D1F20">
        <tbody>
            <tr>
                <td class="header container">
                    <div class="content">
                        <table style="top: 22px;position: relative;">
                            <tbody>
                                <tr>
                                    <td align="left" class="intro">Hi
                                    <span class=
                                    "user_first_name"><?php echo $user->firstname; ?>,</span></td>

                                    <td align="right" class="urlinq_tri_color">
                                        <img class="logo tricolor_float_logo"
                                        src=
                                        "http://beta.urlinq.com/assets/email_logo.png"
                                        style=
                                        "background-repeat:no-repeat;background-size:contain;">

                                        <div class="tricolor_line red"></div>

                                        <div class="tricolor_line blue"></div>

                                        <div class="tricolor_line green"></div>
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

    <table class="body-wrap" style="border-spacing:0; margin-top: 0px;">
        <tbody>
            <tr>
                <td></td>

                <td class="container" style="background-color: #FFFFFF">
                    <div class="content">
                        <table>
                            <tbody>
                                <tr>
                                    <td>
                                        <!-- A Real Hero (and a real human being) -->

                                        <p><img src=
                                        "http://beta.urlinq.com/assets/Club_Event_Email_hero.jpg"></p><a href="http://www.urlinq.com">
                                        <div class=
                                        "thought_leader_frame_group">
                                        <img class="thought_leader_picture_group"
                                        src=
                                        "https://urlinq.com/team/photo_urlinq/kevin_0.jpg"
                                        style=
                                        "height: 100px; margin-top:0px;border-radius: 3px;"></div></a>
                                        <!-- Callout Panel -->

                                        <p class="event_intro" style=
                                        "margin-left: 40px;font-size: 21px;font-weight: 200;margin-right: 40px;border-bottom: 1px solid #777;margin-bottom: 20px;">
                                        <a href="http://www.urlinq.com" style=
                                        "font-weight:600;color: #222;text-decoration: none;">
                                        <?php echo $actor_name; ?></a> created an event in <?php echo $event->origin_type . ' ' . $origin_name; ?></p>

                                        <div class="date_month_box" style=
                                        "width: 82px; display: inline-block; height: 82px; border-radius: 5px; background: rgb(77, 77, 77); vertical-align: top; margin-left: 40px; border: 1px solid rgba(0, 0, 0, 0.08); border-bottom-width: 3px;margin-right:12px">
                                        <p style=
                                        " background: rgba(0, 0, 0, 0.15); width: 100%; margin: 0; border-radius: 4px 4px 0 0; height: 16px;">
                                            </p>

                                            <p class="month" style=
                                            "color: #FFF; text-align: center; font-size: 13.5px; width: auto; padding-bottom: 0px; font-weight: bold; font-weight: 600; padding-top: 7px; margin-bottom: 0px; text-shadow: rgba(0, 0, 0, 0.32) 1px 1px 0px;">
                                            December</p>

                                            <p class="day" style=
                                            " color: #FFF; text-align: center; font-size: 21px; padding: 21px; width: auto; font-weight: bold; padding-top: 0px; margin-top: -2px; text-shadow: rgba(0, 0, 0, 0.32) 1px 1px 0px;">
                                            14</p>
                                        </div>

                                        <div class="event_details" style=
                                        " display: inline-block; width: 75%; max-width: 600px; margin-top: 3px;">
                                        <p class="target_copy_title" style=
                                        " display: inline-block; margin-top: -13px; font-size: 26px;">
                                            <span class="event_name" style=
                                            " color: #121314;"><?php echo $event->title; ?></span> <span class=
                                            "event_category" style=
                                            " color: #999; font-size: 15px; text-transform: uppercase;">
                                            <?php echo $event->origin_type; ?> event</span></p>

                                            <p class="event_when_where" style=
                                            " display: inline-block;font-size: 17px; color: #222; margin-top: 2px;">
                                            <span class="event_when"><?php echo $event->start_date; ?></span>
                                            <span class="vertical_bar">|</span>
                                            <span class="event_where" style=
                                            " color: #009933;"><?php echo $event->location; ?></span></p>

                                            <p class=
                                            "post_target_copy event_description"
                                            style=
                                            " width: 88%;margin-top: 0px; border-top: 1px solid #d8d8d8; border-bottom: 1px solid #d8d8d8; padding: 12px 8px; margin-left: 0px;">
                                            <?php echo $event->description; ?>
                                            </p>
                                        </div><a href="<?php echo Yii::app()->getBaseUrl(true) . '/' . $event->origin_type . '/' . $event->origin_id; ?>" class="btn group_link_btn"
                                        style=
                                        " display: block; margin-bottom: 26px; margin-top: 20px;">See
                                        what's next <img src=
                                        "http://beta.urlinq.com/assets/small_cal_icon.png"
                                        style=
                                        "height:18px;position:relative;top:3px;left:8px;">
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>

                <td></td>
            </tr>
        </tbody>
    </table><!-- /BODY -->
    <!-- FOOTER -->

    <table class="footer-wrap">
        <tbody>
            <tr>
                <td></td>

                <td class="container">
                    <!-- content -->

                    <div class="content">
                        <table>
                            <tbody>
                                <tr>
                                    <td align="center">
                                        <p class="footer_Text"><a href=
                                        "http://www.urlinq.com" style=
                                        " color: #fff; text-decoration: none;">Urlinq,
                                        Inc 2015</a> | <a href=
                                        "http://www.urlinq.com" style=
                                        " color: #fff; text-decoration: none;">New
                                        York City</a> | Unsubscribe <a href=
                                        "http://www.urlinq.com" style=
                                        " color: #fff; text-decoration: none;"></a></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /content -->
                </td>

                <td></td>
            </tr>
        </tbody>
    </table><!-- /FOOTER -->
</body>
</html>