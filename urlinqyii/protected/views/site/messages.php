<!DOCTYPE html>

<html>

    <head>
        <script>


            var globals = {};


            globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            globals.origin_type = '<?php echo 'user'; ?>';
            globals.origin_id = '<?php echo $user->user_id; ?>';
            globals.user_id = '<?php echo $user->user_id; ?>';
            globals.url = '<?php echo $url; ?>';




        </script>

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-59124667-1', 'auto');
          ga('send', 'pageview');

        </script>        
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/datetime_helper.js"></script>
          <title>Urlinq</title>

<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui.custom.min.js"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery_cookie.js"></script>

        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js'></script>



        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/location_input/location_input.js"></script>

        <link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/site/main.css">
        <link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/messages/messages_adjustments.css">
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/font/avenir.css' rel='stylesheet' type='text/css'>
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/Ur_FavIcon.png" type="image/x-icon">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/top_bar/reminders.js"></script>




        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/animate.css' rel='stylesheet' type='text/css'>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>
        <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/reminders/reminders.css' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/group_info_bars.css">

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/time_selector/time_selector.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/time_selector/time_selector.css" type = "text/css" rel = "stylesheet">
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/date_selector/date_selector.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/lightbox.min.js" type="text/javascript"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/lightbox.css" type = "text/css" rel = "stylesheet">
 
    </head>


    <body id = "body_messages">

        <?php echo Yii::app()->runController('partial/topbar');     ?>

        <div id = "wrapper" class="<?php echo $user->status; ?>">
            <div id="page">



                <div id="messaging_content">
                    <div id="messaging_left_panel">

                        <?php if($url != ''){ ?>
                            <div id="messaging_back_button">
                                < Back to network
                            </div>
                        <?php } ?>

                        <?php echo $this->renderPartial('/partial/messaging_panel',array('user'=>$user,'origin_type'=>'messages','origin_id'=>'')); ?>
                    </div>


                    <div id="chat_panel" class="chat_box">
                        <div id="chat_panel_text" class="chat_box_text">
                            <div class="chat_panel_wrap chat_message_wrap">

                            </div>
                        </div>



                        <div id="chat_panel_input">
                             <textarea class="chat_input autogrow"></textarea>
                        </div>
                    </div>


                </div>






            </div>
        </div>
        <div class='pulse_container' style='left:50%;top:50%;position:absolute;'>
            <div class='pulse_tp_0'></div>
        </div> 
        <div class='black_canvas hidden'></div>
    </body>


    

 <!--<!-- INCLUDE THIS AND date_selector.js and add class name date_input to your date input fields to use this -->

    <div id = "calLayer" style="display: none;">
        <section id = "mounth" class="mounth">
            <header class="minical-header">
                <h1 class="minical-h1"></h1>

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




<!--Include this and js/time_selector/time_selector.js to use this.
Set the class name on your input to 'time_input' -->
<div id="time_selector">
    <div class='time_selector_div' data-time='00:00:00' value="00:00:00">12:00am</div>
    <div class='time_selector_div' data-time='00:30:00' value="00:30:00">12:30am</div>

    <div class='time_selector_div' data-time='01:00:00' value="01:00:00">1:00am</div>
    <div class='time_selector_div' data-time='01:30:00' value="01:30:00">1:30am</div>

    <div class='time_selector_div' data-time='02:00:00' value="02:00:00">2:00am</div>
    <div class='time_selector_div' data-time='02:30:00' value="02:30:00">2:30am</div>

    <div class='time_selector_div' data-time='03:00:00' value="03:00:00">3:00am</div>
    <div class='time_selector_div' data-time='03:30:00' value="03:30:00">3:30am</div>

    <div class='time_selector_div' data-time='04:00:00' value="04:00:00">4:00am</div>
    <div class='time_selector_div' data-time='04:30:00' value="04:30:00">4:30am</div>

    <div class='time_selector_div' data-time='05:00:00' value="05:00:00">5:00am</div>
    <div class='time_selector_div' data-time='05:30:00' value="05:30:00">5:30am</div>

    <div class='time_selector_div' data-time='06:00:00' value="06:00:00">6:00am</div>
    <div class='time_selector_div' data-time='06:30:00' value="06:30:00">6:30am</div>

    <div class='time_selector_div' data-time='07:00:00' value="06:00:00">7:00am</div>
    <div class='time_selector_div' data-time='07:30:00' value="06:30:00">7:30am</div>


    <div class='time_selector_div' data-time='08:00:00' value="08:00:00">8:00am</div>
    <div class='time_selector_div' data-time='08:30:00' value="08:30:00">8:30am</div>

    <div class='time_selector_div' data-time='09:00:00' value="09:00:00">9:00am</div>
    <div class='time_selector_div' data-time='09:30:00' value="09:30:00">9:30am</div>

    <div class='time_selector_div' data-time='10:00:00' value="10:00:00">10:00am</div>
    <div class='time_selector_div' data-time='10:30:00' value="10:30:00">10:30am</div>

    <div class='time_selector_div' data-time='11:00:00' value="11:00:00">11:00am</div>
    <div class='time_selector_div' data-time='11:30:00' value="11:30:00">11:30am</div>


    <!-- NOON -->
    <div class='time_selector_div' data-time='12:00:00' value="12:00:00">12:00pm</div>
    <div class='time_selector_div' data-time='12:30:00' value="12:30:00">12:30pm</div>



    <div class='time_selector_div' data-time='13:00:00' value="13:00:00">1:00pm</div>
    <div class='time_selector_div' data-time='13:30:00' value="13:30:00">1:30pm</div>

    <div class='time_selector_div' data-time='14:00:00' value="14:00:00">2:00pm</div>
    <div class='time_selector_div' data-time='14:30:00' value="14:30:00">2:30pm</div>

    <div class='time_selector_div' data-time='15:00:00' value="15:00:00">3:00pm</div>
    <div class='time_selector_div' data-time='15:30:00' value="15:30:00">3:30pm</div>

    <div class='time_selector_div' data-time='16:00:00' value="16:00:00">4:00pm</div>
    <div class='time_selector_div' data-time='16:30:00' value="16:30:00">4:30pm</div>

    <div class='time_selector_div' data-time='17:00:00' value="17:00:00">5:00pm</div>
    <div class='time_selector_div' data-time='17:30:00' value="17:30:00">5:30pm</div>

    <div class='time_selector_div' data-time='18:00:00' value="18:00:00">6:00pm</div>
    <div class='time_selector_div' data-time='18:30:00' value="18:30:00">6:30pm</div>

    <div class='time_selector_div' data-time='19:00:00' value="19:00:00">7:00pm</div>
    <div class='time_selector_div' data-time='19:30:00' value="19:30:00">7:30pm</div>


    <div class='time_selector_div' data-time='20:00:00' value="20:00:00">8:00pm</div>
    <div class='time_selector_div' data-time='20:30:00' value="20:30:00">8:30pm</div>

    <div class='time_selector_div' data-time='21:00:00' value="21:00:00">9:00pm</div>
    <div class='time_selector_div' data-time='21:30:00' value="21:30:00">9:30pm</div>

    <div class='time_selector_div' data-time='22:00:00' value="22:00:00">10:00pm</div>
    <div class='time_selector_div' data-time='22:30:00' value="22:30:00">10:30pm</div>

    <div class='time_selector_div' data-time='23:00:00' value="23:00:00">11:00pm</div>
    <div class='time_selector_div' data-time='23:30:00' value="23:30:00">11:30pm</div>

</html>

