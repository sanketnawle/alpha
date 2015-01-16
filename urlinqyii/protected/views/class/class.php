<html>


<head>
    <script>
        var globals = {};


        globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        globals.origin_type = '<?php echo 'class'; ?>';

        globals.origin_id = '<?php echo $class->class_id; ?>';

        globals.origin_name = '<?php echo $class->class_name; ?>';

        globals.is_admin = '<?php echo $is_admin ? 'true' : 'false'; ?>';

        globals.admin_file_panel_class = 'class';

    </script>
      

    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/timezone_conversion.js"> </script>

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_files.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_syllabus.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_settings.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_about.css">

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/profile/profile.js"></script>
    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/profile/profile.css' rel='stylesheet' type='text/css'>

    <!--BELOW ARE SCRIPTS AND LINKS FOR DROPDOWN MENU API -->
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropit.js'></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/libs/dropit.css" type="text/css" />
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js'></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/class/class_syllabus_tab.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_files.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropzone.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_members.js'></script>
    <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_settings.js'></script>
      
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/pdfloader/minimal.css" rel="stylesheet" media="screen" />
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/util.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/api.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/metadata.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/canvas.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/webgl.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/pattern_helper.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/font_loader.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/annotation_helper.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/text_layer_builder.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/ui_utils.js"></script>
      <script>PDFJS.workerSrc = '<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/worker_loader.js';</script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/pdf.js"></script>

      <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/chrono.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/application.js"></script>
      <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/pdfloader/uiscripts.js"></script>
     <script>


    </script>
</head>

    <body>



    <?php echo Yii::app()->runController('partial/topbar'); ?>
        <div id="wrapper">
        <!--        --><?php //echo Yii::app()->runController('partial/leftmenu'); ?>




        <div id="page">


        <div id="main_panel" class = "group_responsiveness">


        <div id="content_holder">

        <div id="left_panel" class = "group_responsiveness">
            <!--                        <section class='leftbar_bag'>-->
            <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'class','origin_id'=>$class->class_id,'origin_name'=>$class->class_name)); ?>
            <!--                        </section>-->
        </div>




        <div id="content_panel" class = "group_responsiveness">
        <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'class','origin_id'=>$class->class_id,'origin'=>$class)); ?>
        <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $class->coverFile->file_url ?>');">
            <div class = "group_name">
                <div class = "center_admin"><div class = "professor_image"></div><div class = "professor_name">Professor Mehrer</div></div>
                <div class = "center_text"><p id = "group_name"><span id = "name_title"><?php echo $class->class_name; ?></span><span class = "class_title_info"><?php echo $class->component; ?><br><?php echo $class->section_id; ?></span></p></div>
            </div>
            <div class = "group_right_info group_info_boxes">
                <?php if($class->location) { ?>
                <div class = "group_info_block" id = "location">
                    <em class ="small_icon_map"></em>
                    <span><?php echo $class->location; ?></span>
                </div>
                <?php } else { }?>

                <div class = "group_info_block" id = "class_schedule">
                    <em class ="small_icon_map"></em>
                    <span>Mon 9:30 am - 11:00 am, Wed 10:00 am - 11:30 am, Fri 9:30 am - 11:00 am</span>
                </div>
            </div>


        </div>




        <div id="tab_bar">

            <div class="tab feed active" data-panel_id="1">
                <div class="tab_content">
                    <div class="tab_img"></div>
                    <div class="tab_text">Class Feed</div>
                </div>
                <div class="tab_wedge"></div>
            </div>

            <div class="tab syllabus" data-panel_id="2">
                <div class="tab_content">
                    <div class="tab_img"></div>
                    <div class="tab_text">Syllabus</div>
                </div>
                <div class="tab_wedge"></div>
            </div>

            <div class="tab materials" data-panel_id="3">
                <div class="tab_content">
                    <div class="tab_img"></div>
                    <div class="tab_text">Materials</div>
                    <div class = "tab_amount"><?php echo count($class->files);?></div>
                </div>
                <div class="tab_wedge"></div>
            </div>

            <div class="tab members" data-panel_id="4">
                <div class="tab_content">
                    <div class="tab_img"></div>
                    <div class="tab_text">Members</div>
                    <div class = "tab_amount"><?php echo count($class->users);?></div>
                </div>
                <div class="tab_wedge"></div>
            </div>




            <!-- #group_user_action_button performs either join/leave or follow/unfollow depending on context -->
            <?php if($is_member){ ?>
                <div id="group_user_action_button" class="member" data-action_url="/leave">
                    <div id="group_user_action_button_text">Member</div>
                </div>
            <?php }else{ ?>
                <div id="group_user_action_button" class="non_member" data-action_url="/join">
                    <div id="group_user_action_button_text">Join</div>
                </div>
            <?php } ?>

            <div id="tab_more_button">
                <div id="tab_more_button_image"></div>
                <?php echo $this->renderPartial('/partial/other_views_box',array('user'=>$user,'origin_type'=>'class','origin_id'=>$class->class_id)); ?>
            </div>

            

        </div>


        <div class="panel active panel_feed" id="panel_1">
            <div id = "planner_column" class = "planner_column_group">
                <div id = "right_column_specs">
                    <div id = "fixed_element" class = "planner_group">
                        <?php
                        echo $this->renderPartial('/partial/planner',array('user'=>$user,'origin_type'=>'class','origin_id'=>'<?php echo $class->class_id; ?>'));
                        ?>    
                    </div>
                </div>                           
            </div>
            <div id = "feed_column" class = "feed_column_group">
                <div id = "stream_holder" class = "stream_holder_home">
                    <div id = "fbar_wrapper" class = "fbar_home">
                        <?php echo $this->renderPartial('/partial/class_status_bar',array('user'=>$user,'origin_type'=>'class','origin_id'=>'','pg_src'=>'class.php','target_type'=>'class')); ?>
                    </div>

                    <div id = "feed_wrapper" class = "feed_wrapper_home">
                        <?php echo $this->renderPartial('/partial/feed',array('user'=>$user, 'feed_url'=>'/class/<?php echo $class->class_id; ?>/feed')); ?>
                    </div>


                </div>
            </div>
        </div>

        <div class="panel tab_syllabus" id="panel_2">
            <div class = "class_syllabus_tab">
                <div class = "syllabus_tab_holder">
                    <div class = "full_syllabus_box syllabus_tagger">

                        <div class = "title">
                            Class Syllabus <div class = "syllabus_like_btn"><span class = "post_like_icon"></span>Like</div><div class = "syllabus_download_btn"><span class = "download_icon"></span>Download</div>
                        </div>
                        <div id="pdfContainer">
                        </div>
                        <!-- <div class = "rendered_syllabus_page_holder" id = "page1">
                            <div class = "paper_shadowonblack">
                            </div>
                        </div>

                        <div class = "rendered_syllabus_page_holder" id = "page2">
                            <div class = "paper_shadowonblack">
                            </div>
                        </div>

                        <div class = "rendered_syllabus_page_holder" id = "page3">
                            <div class = "paper_shadowonblack">
                            </div>
                        </div>

                        <div class = "rendered_syllabus_page_holder" id = "page4">
                            <div class = "paper_shadowonblack">
                            </div>
                        </div>
 -->
                    </div>
                    <div class = "class_events_holder order_kind">
                        <div class = "black_action_box">
                            <button id="btn_add_syllabus" class = "scan_syllabus">
                                <em class = "syla_plus"></em>Add Syllabus
                            </button>
                            <input style="display:none;" type="file" accept=".pdf" id="syllabus_pdf_upload"/>
                            <div class = "black_explainer">
                                By importing your syllabus, our algorithm will generate a list of events within this class's calendar. 
                            </div>
                        </div>
                        <div class = "syllabus_events_wrapper">
                            <header class = "class_tasks">
                                <h5>Class Work</h5>
                                <label>Order:</label>
                                <ul class = "menu">
                                    <li>
                                        <a href = "#"><div class = "order_sort_dropdown"><span id = "selected_syllabus_event_order">Kind</span><em></em></div></a>
                                        <ul><div class = "order_dropdown_box"><li id = "syllabus_event_order_kind" class = "syllabus_event_order"><a href = "#">Kind</a></li><li id = "syllabus_event_order_date" class = "syllabus_event_order"><a href = "#">Date</a></li></div></ul>
                                    </li>
                                </ul>


                            </header>
                            <br>
                            <div id="events_list">
                                
                            </div>
                        </div>
<!--                         <div class = "syllabus_events_wrapper">
                            <header class = "class_tasks">
                                <h5>Class Work</h5>
                                <label>Order:</label>
                                <ul class = "menu">
                                    <li>
                                        <a href = "#"><div class = "order_sort_dropdown"><span id = "selected_syllabus_event_order">Kind</span><em></em></div></a>
                                        <ul><div class = "order_dropdown_box"><li id = "syllabus_event_order_kind" class = "syllabus_event_order"><a href = "#">Kind</a></li><li id = "syllabus_event_order_date" class = "syllabus_event_order"><a href = "#">Date</a></li></div></ul>
                                    </li>
                                </ul>


                            </header>
                            <div class = "events_by_kind events_ordered_list">
                                <div class = "kind_section">
                                    <h5>Assignments</h5>
                                    <div class = "syllabus_event">
                                        <div class = "day_month_box day_box_color">
                                            <div class = "calendar_top_border"></div>
                                            <div class = "calendar_bottom_section">
                                                <span class = "day">10</span>
                                                <span class = "month">Nov</span>
                                            </div>
                                        </div>
                                        <div class = "event_name_buttons">
                                            <span class ="event_name_text">
                                                Midterm 1
                                            </span>
                                            <input class = "syla_tab_event_editor" type = "text" name = "event_name" placeholder = "Enter a title...">
                                            <div class ="complete_incomplete_button syllabus_event_button incomplete active">
                                                <span class = "todo_checkbox">
                                                </span>
                                                <div class="help-div">
                                                    <div class="help-wedge">
                                                    
                                                    </div>
                                                    <div class="help-box">Mark as Complete</div>
                                                </div>
                                            </div>


                                        </div>
                                    
                                    </div>
                                    <div class = "syllabus_event editable">
                                        <div class = "day_month_box day_box_color">
                                            <div class = "calendar_top_border"></div>
                                            <div class = "calendar_bottom_section">
                                                <span class = "day">10</span>
                                                <span class = "month">Nov</span>
                                            </div>
                                        </div>
                                        <div class = "event_name_buttons">
                                            <span class ="event_name_text">
                                                Midterm 1
                                            </span>
                                            <input class = "syla_tab_event_editor" type = "text" name = "event_name" placeholder = "Enter a title...">
                                            <div class ="complete_incomplete_button syllabus_event_button incomplete active">
                                                <span class = "todo_checkbox">
                                                </span>
                                                <div class="help-div">
                                                    <div class="help-wedge">
                                                    
                                                    </div>
                                                    <div class="help-box">Mark as Complete</div>
                                                </div>
                                            </div>
                                            <div class = "done_editing_button">
                                                Done
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "kind_section">
                                    <h5>Exams</h5>

                                    <div class = "syllabus_event">
                                        <div class = "day_month_box day_box_color">
                                            <div class = "calendar_top_border"></div>
                                            <div class = "calendar_bottom_section">
                                                <span class = "day">10</span>
                                                <span class = "month">Nov</span>
                                            </div>
                                        </div>
                                        <div class = "event_name_buttons">
                                            <span class ="event_name_text">
                                                Midterm 1
                                            </span>
                                            <div class ="complete_incomplete_button incomplete">
                                                <span></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class = "kind_section">
                                    <h5>Projects</h5>
                                    <div class = "syllabus_event">
                                    </div>
                                    <div class = "syllabus_event">
                                    </div>
                                </div>
                                <div class = "kind_section">
                                    <h5>Papers</h5>
                                    <div class = "syllabus_event">
                                    </div>
                                    <div class = "syllabus_event">
                                    </div>
                                </div>
                                <div class = "kind_section">
                                    <h5>Lecture</h5>
                                    <div class = "syllabus_event">
                                    </div>
                                    <div class = "syllabus_event">
                                    </div>
                                </div>
                                <div class = "kind_section">
                                    <h5>Labs</h5>
                                    <div class = "syllabus_event">
                                    </div>
                                    <div class = "syllabus_event">
                                    </div>
                                </div>
                            </div>
                            <div class = "events_by_date events_ordered_list">
                                <div class = "week_section">
                                    <h5>Week 1</h5>
                                    <div class = "syllabus_event">
                                    </div>
                                    <div class = "syllabus_event">
                                    </div>
                                    <div class = "syllabus_event">
                                    </div>
                                </div>
                                <div class = "week_section">
                                    <h5>Week 2</h5>
                                    <div class = "syllabus_event">
                                    </div>
                                    <div class = "syllabus_event">
                                    </div>
                                </div>
                                <div class = "week_section">
                                    <h5>Week 3</h5>
                                    <div class = "syllabus_event">
                                    </div>
                                    <div class = "syllabus_event">
                                    </div>
                                </div>
                                <div class = "week_section">
                                    <h5>Week 4</h5>
                                    <div class = "syllabus_event">
                                    </div>
                                </div>
                                <div class = "week_section">
                                    <h5>Week 5</h5>
                                    <div class = "syllabus_event">
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="panel tab_files" id="panel_3">
        <!--<form action="/file-upload" class="dropzone" id="my-awesome-dropzone">-->
        <div class="tab_content_holder">
        <div class="tab_header">
            <div id = "tabnav">
                <div class = "tabnav_right float_Right">
                    <div class = "small_search fade_input_small">
                        <em id = "files_tab_sprites" class = "left_search_icon search_icon">
                        </em>
                        <input type = "text" name = "files_search_input" placeholder = "Search files" class = "small_search_input file_search_input">
                    </div>
                </div>
                <ul class = "tabnav_tabs">
                    <li class = "files_subtab class_files active" data-panel_id = "1" data-file_list_type="class">
                        <div class = "tabnav_tab">
                            <span>Class Files</span>
                        </div>
                    </li>
                    <li class = "files_subtab student_files" data-panel_id = "2" data-file_list_type="student">
                        <div class = "tabnav_tab">
                            <span>Student Files</span>
                        </div>
                    </li>
                </ul>
                <div class = "tab_floater_bar_half">
                    <div class = "action">
                        <a id = "upload_text_button">
                            <em id = "files_tab_sprites" class = "upload_icon">
                            </em>
                            <span>Upload</span>
                        </a>
                        <span class = "drag_hint"><i> or </i>drag &#38; drop to add files</span>
                    </div>
                    <div class = "action">
                        <a id = "new_folder_button">
                            <em id = "files_tab_sprites" class = "new_folder_icon">
                            </em>
                            <span>New Folder</span>
                        </a>
                    </div>
                </div>
            </div>



            <div class = "files_sort">
                <div id = "name_sorter" data-sort = "files_by_name" data-ascending = "true" class = "active sortable_column_header">
                    <span>Name</span>
                    <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                </div>
                <div id = "kind_sorter" data-sort = "files_by_kind" data-ascending = "false" class = "sortable_column_header">
                    <span>Type</span>
                    <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                </div>
                <div id = "date_sorter" data-sort = "files_by_date" data-ascending = "false" class = "sortable_column_header">
                    <span>Date</span>
                    <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                </div>
                <div id = "views_sorter" data-sort = "files_by_views" data-ascending = "false" class = "sortable_column_header">
                    <span>Downloads</span>
                    <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                </div>
            </div>
            <div id = "files_header_bottom_line">
            </div>
        </div>
        <div class = "files_sub_panel active class_files" id ="files_sub_panel_1" data-file_list_type="class">
            <ol class = "files_list class" data-file_list_type="class">



                <script id="file_template" type="text/x-handlebars-template">
                    <li class = "file" data-file_id="{{file_id}}" data-name="{{original_name}}" data-file_type="{{file_type}}" data-date="{{created_timestamp}}" data-download_count="{{download_count}}">
                        <div class = "filename_col">
                            <div class = "files_tab_sprites upload_sprite {{file_type}}"></div>
                            <a class = "filename" data-file_type="{{file_type}}" href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'>{{original_name}}</a>
                        </div>
                        <div class = "kind">
                            <span class = "category">{{file_type}}</span>
                        </div>
                        <div class = "date">
                            <span class = "relevant_date">{{created_timestamp}}</span>
                            <div id = "hidden_datepicker" class = "files_tab_datepicker"></div>
                        </div>
                        <div class = "views">
                            <span class = "viewcount">
                            {{download_count}}
                            </span>
                        </div>


                        <?php if($is_admin){ ?>
                            <div class='remove_file_div'>remove</div>
                        <?php } ?>

                    </li>
                </script>





<!---->
<!--                <li class = "file">-->
<!--                    <div class = "filename_col">-->
<!--                        <div id = "files_tab_sprites" class = "upload_sprite img">-->
<!--                        </div>-->
<!--                        <a class = "filename">Interesting Image</a>-->
<!--                    </div>-->
<!--                    <div class = "kind">-->
<!--                        <span class = "category">Image</span>-->
<!--                    </div>-->
<!--                    <div class = "date">-->
<!--                        <span class = "relevant_date">10/5/2014</span>-->
<!--                        <div id = "hidden_datepicker" class = "files_tab_datepicker">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class = "views">-->
<!--                        <span class = "viewcount">48</span>-->
<!--                        <a class = "download_button extra_padding">-->
<!--                            Download-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class = "file">-->
<!--                    <div class = "filename_col">-->
<!--                        <div id = "files_tab_sprites" class = "upload_sprite excel">-->
<!--                        </div>-->
<!--                        <a class = "filename">Serial Spreadsheet</a>-->
<!--                    </div>-->
<!--                    <div class = "kind">-->
<!--                        <span class = "category">Spreadsheet</span>-->
<!--                    </div>-->
<!--                    <div class = "date">-->
<!--                        <span class = "relevant_date">10/24/2014</span>-->
<!--                        <div id = "hidden_datepicker" class = "files_tab_datepicker">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class = "views">-->
<!--                        <span class = "viewcount">120</span>-->
<!--                        <a class = "download_button extra_padding">Download</a>-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class = "file">-->
<!--                    <div class = "filename_col">-->
<!--                        <div id = "files_tab_sprites" class = "upload_sprite ppt">-->
<!--                        </div>-->
<!--                        <a class = "filename">-->
<!---->
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class = "kind">-->
<!--                        <span class = "category">Powerpoint</span>-->
<!--                    </div>-->
<!--                    <div class = "date">-->
<!--                        <span class = "relevant_date">10/5/2014</span>-->
<!--                        <div id = "hidden_datepicker" class = "files_tab_datepicker">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class = "views">-->
<!--                        <span class = "viewcount">1340</span>-->
<!--                        <a class = "download_button extra_padding">Download</a>-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class = "file">-->
<!--                    <div class = "filename_col">-->
<!--                        <div id = "files_tab_sprites" class = "upload_sprite pdf">-->
<!---->
<!--                        </div>-->
<!--                        <a class = "filename">Poignant PDF</a>-->
<!--                    </div>-->
<!--                    <div class = "kind">-->
<!--                        <span class = "category">Document</span>-->
<!--                    </div>-->
<!--                    <div class = "date">-->
<!--                        <span class = "relevant_date">10/14/2014</span>-->
<!--                        <div id = "hidden_datepicker" class = "files_tab_datepicker">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class = "views">-->
<!--                        <span class = "viewcount">23</span>-->
<!--                        <a class = "download_button extra_padding">Download</a>-->
<!--                    </div>-->
<!--                </li>-->
<!--                <li class = "file">-->
<!--                    <div class = "filename_col">-->
<!--                        <div id = "files_tab_sprites" class = "upload_sprite zip">-->
<!--                        </div>-->
<!--                        <a class = "filename">Unit 1 Course Materials</a>-->
<!--                    </div>-->
<!--                    <div class = "kind">-->
<!--                        <span class = "category">Folder</span>-->
<!--                    </div>-->
<!--                    <div class = "date">-->
<!--                        <span class = "relevant_date">10/24/2014</span>-->
<!--                        <div id = "hidden_datepicker" class = "files_tab_datepicker">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class = "views">-->
<!--                        <span class = "viewcount">--</span>-->
<!--                        <a class = "download_button extra_padding">Download</a>-->
<!--                    </div>-->
<!--                </li>-->
            </ol>
        </div>
        <div class = "files_sub_panel student_files" id ="files_sub_panel_2" data-file_list_type="student">
            <ol class = "files_list student" data-file_list_type="student">


            </ol>
        </div>




        <form action="<?php echo Yii::app()->getBaseUrl(true);?>/class/fileUpload" class="dropzone dz-clickable files_upload_bigbox" id="demo-upload">
            <div class="bigbox_bigmessage">
            </div>
            <input type="hidden" name="id" value="<?php echo $class->class_id; ?>">


            <input class="upload_files_submit" type="submit" name="submitIT" value="Upload these Files">
        </form>





        </div>
        <!--</form>-->
        </div>

        <div class="panel tab_members" id="panel_4">
            <div class="tab_content_holder">
                <div class="tab_header">
                    <div class = "float_Right">
                        
                        <div class = "admin_member_controls">
                            <div class = "add_people_button remove" id = "remove_button">
                                Remove People
                            </div>
                        </div> 
                        <div class = "remove_state_controls">
                            <span class ="removed_count"></span>
                            <div class = "remove" id = "done_removing_button">
                                <em></em>
                                <span>Done</span>
                            </div>
                        </div>   
                        <div class = "add_people_button">
                            Add Members
                        </div>                   
                        <div class="fade_input_small small_search">
                            <em class = "left_search_icon">
                            </em>
                            <input type = "text" name = "people_search_input" placeholder = "Search members" class = "name_search_input small_search_input">
                        </div>
                    </div>
                    <div class = "header_sentence">
                        Class Members
                    </div>
                </div>
                <!-- class_members_tab should be an id because it is a unique identifier -->
                <div id="class_members_tab" class= "members_tab_content tab_content">

                    <?php
                        $professor = $class->professor();
                        if($professor){
                    ?>
                        <div class = "members_card_wrapper class_admin" data-user_id='<?php echo $professor->user_id; ?>' data-name="<?php echo $professor->full_name(); ?>">
                            <div class = "members_card normal_size admin_size" data-user_id='1'>
                                <div class = "members_card_img" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $professor->pictureFile->file_url; ?>');">

                                </div>
                                <span class = "title">Professor</span>
                                <div class = "user_main_info">
                                    <a class = "name profile_link"><?php echo $professor->full_name(); ?></a>
                                    <span class = "office_hours in_office">
                                        <em></em>
                                        <span>In office</span>
                                    </span>
                                </div>
                                <div class = "user_more_info">
                                    <span class = "label">Department <br> </span><a href="<?php echo Yii::app()->getBaseUrl(true) . '/department/' . $professor->department->department_id; ?>" class = "data department_link"><?php echo $professor->department->department_name; ?></a>
                                </div>
                                <div class = "user_more_info">
                                    <span class = "label">Office location <br> </span><span class = "data location"><?php echo $professor->professorAttribute->office_location; ?></span>
                                </div>
                                <div class = "user_more_info">
                                    <span class = "label">Email address <br> </span><span class = "data email"><?php echo $professor->user_email; ?></span>
                                </div>
                                <div class = "user_card_button_holder">
                                    <div class = "follow_button_wrapper following_wrapper">
                                        <div class = "user_follow_button following">Following</div>
                                        <div class = "user_message_button message_active">
                                            <em class = "white_message_icon">
                                            </em>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    <?php foreach($class->students as $member){ ?>
                        <div class = "members_card_wrapper regular_member" data-user_id='<?php echo $member->user_id; ?>' data-name="<?php echo $member->full_name(); ?>">
                            <div class = "members_card admin normal_size">
                                <div class = "members_card_img profile_link" user_id='<?php echo $member->user_id; ?>' style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $member->pictureFile->file_url; ?>');">

                                    <?php if($member->user_type == 'p'){ ?>
                                        <span class = "title">Professor</span>
                                    <?php }elseif($member->user_type == 'a'){ ?>
                                        <span class = "title">Admin</span>
                                    <?php }else{ ?>
                                        <span class = "title">Student</span>
                                    <?php } ?>

                                    <span class = "class_year">Senior</span>
                                </div>
                                <div class = "user_main_info">
                                    <a class = "name profile_link" user_id='<?php echo $member->user_id; ?>'><?php echo $member->firstname . ' ' . $member->lastname; ?></a>
                                </div>
                                <div class = "user_more_info">
                                    <a class = "department_link"><?php echo $member->department->department_name; ?></a>
                                </div>
                                <div class = "user_card_button_holder">

                                    <?php if($user->is_following($member->user_id)){ ?>
                                    <div class = "follow_button_wrapper following_wrapper">
                                        <div class = "user_follow_button following">Following</div>
                                        <?php }else{ ?>
                                        <div class = "follow_button_wrapper following_wrapper">
                                            <div class = "user_follow_button">Follow</div>
                                            <?php } ?>
                                            <div class = "user_message_button message_active">
                                                <em class = "white_message_icon">
                                                </em>
                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>

                    <?php } ?>


                </div>
            </div>
        </div>
        
        <!-- INSERTING NEW PANELS HERE STARTING WITH ID = panel_5  -->
        <div class="panel tab_settings" id="panel_5">
        	<div class="tab_content_holder">
        		<div class="tab_header">
        			<img class="tab_settings_icon" src="../assets/settings_imgs/gear.png">
	        		<div class="header_sentence">Class Settings</div>
        		</div>
        		<div class="settings_tab_content">
        			<div class="admin_settings_wrapper">
        				<div class="admin_settings">
        					<div class="header">
        						<p>Administrative Settings</p>
        					</div>
        					<div class="row">
        						<div class="text">
        							<p>Is this class open to the public?</p>
        						</div>
        						<div class="status">
        							<p class="status_text">Inner html</p>
        							<form class="status_form" id="status_form_open">
        								<label><input id="status_check" type="radio" name="openStatus" value="Public"checked>Public</label><br>
        								<label><input id="status_check" type="radio" name="openStatus" value="Private">Private</label>
        							</form>
        						</div>
        						<div class="edit">
        							<img class="edit_img" src="../assets/settings_imgs/bluePen.png">
        							Edit
        						</div>
        					</div>
        					<div class="row">
        						<div class="text">
        							<p>Who can see the members of this class?</p>
        						</div>
        						<div class="status">
        							<p class="status_text">Inner html</p>
        							<form class="status_form" id="status_form_privacy">
        								<label><input id="status_check" type="radio" name="privacyStatus" value="Public" checked>Public</label><br>
        								<label><input id="status_check" type="radio" name="privacyStatus" value="Members Only">Members Only</label>
        							</form>
        						</div>
        						<div class="edit">
        							<img class="edit_img" src="../assets/settings_imgs/bluePen.png">
        							Edit
        						</div>
        					</div>
						</div>
        			</div>
           			<div class="personal_notification_settings_wrapper">
	        			<div class="personal_notification_settings">
	        				<div class="header">
	        					<p>Personal Notification Settings</p>
	        				</div>
	        				<div class="row_no_click">
	        					<p id="left_text">Notifications are OFF for this class</p>
	        					<div id="right_slider">
		        					<div class="switch">
										<input id="cmn-toggle" class="cmn-toggle cmn-toggle-round" type="checkbox">
										<label for="cmn-toggle"></label>
									</div>
	        					</div>
	        				</div>
	        			</div>
        			</div>
        			<div class="admins_wrapper">
        				<div class="admins">
        					<div class="header">
        						<p>Class TAs and Admins</p>
        					</div>
        					<div class="row">
        						<img class="admins_image" src="../assets/dummy-pic.jpg">
        						<p class="admins_name">Professor Larry Herman</p>
        						<img class="admins_delete" src="../assets/settings_imgs/delete.png">
        					</div>
        					<div class="row">
        						<img class="admins_image" src="../assets/farring.png">
        						<p class="admins_name">Jeffery Bigham</p>
        						<img class="admins_delete" src="../assets/settings_imgs/delete.png">
        					</div>
        					<form>
        						<input class="add_admin" type="text" placeholder="Add a new admin to this class">
        						<img id="add_admin_img" src="../assets/settings_imgs/add-icon.png">
        					</form>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
        
        <!-- About Tab -->
        <div class="panel tab_about" id="panel_6">
        	<div class="tab_content_holder">
        	
        		<div class="tab_header">
        			<img class="tab_about_icon" src="../assets/about_icon.png">
	        		<div class="header_sentence">About this Class - Guided Studies in Biomedical Engineering</div>
        		</div>
        		
        		<div class="about_tab_content">
        		
        			<div class="description_wrapper">
        				<div class="description">
        					<div class="description_header">
        						<p>Class Description</p>
        					</div>
        					<div class="description_blurb">
        						<p>This course is a must-take class in Biomedical Engineering. It enables the user to have a strong foundation and take future advanced courses.</p>
        					</div>
        					<div class="description_info_row">
        						<img class="description_time_img" src="../assets/settings_imgs/clock.png">
        						<p class="description_time_p">Monday 08:00 am - 09:20 am, Wednesday 08:00 am - 09:20 am</p>
							</div>
							<div class="description_info_row">
        						<img class="description_location_img" src="../assets/settings_imgs/location.png">
        						<p class="description_location_p">Class Location</p>
							</div>
							<div class="description_info_row">
        						<img class="description_department_img" src="../assets/settings_imgs/department.png">
        						<p class="description_department_p">Department of Biomedical Engineering</p>
							</div>
						</div>
        			</div>
        			
           			<div class="prof_description_wrapper">
	        			<div class="prof_description">
	        				<div class="header">
	        					<img class="prof_description_pic" src="../assets/dummy-pic.jpg">
	        					<div class="prof_description_info">
	        						<p class="prof_name">Professor Larry Herman</p>
	        						<p class="prof_description_text">OFFICE HOURS:</p>
	        						<p class="prof_hours">Monday 08:00pm - 09:00pm</p>
	        						<p class="prof_description_text">OFFICE LOCATION:</p>
	        						<p class="prof_location">Gavett 207</p>
	        					</div>
	        				</div>
	        				<div class="prof_blurb">
	        					<p id="classes_taught">Other classes taught</p><hr><br>
	        					<div class="prof_row">
		        					<img class="prof_class_img" src="../assets/syllabus_icon_active.png">
		        					<p class="class_taught">MS Thesis in Biomedical Engineering</p>
	        					</div>
	        					<div class="prof_row">
		        					<img class="prof_class_img" src="../assets/syllabus_icon_active.png">
		        					<p class="class_taught">PhD Thesis in Biomedical Engineering</p>

	        					</div>
	        					<div class="prof_row">
		        					<img class="prof_class_img" src="../assets/syllabus_icon_active.png">
		        					<p class="class_taught">Biostatistics</p>

	        					</div>
	        					<div class="prof_row">
		        					<img class="prof_class_img" src="../assets/syllabus_icon_active.png">
		        					<p class="class_taught">Guided Studies in Biomedical...</p>
	        					</div>
	        				</div>
	        			</div>
        			</div>
        			
        			<div class="people_you_know_wrapper">
        				<div class="people_you_know">
        					<div class="header">
        						<p>Friends who have taken this class</p>
        					</div>	
        					<div class="slider_wrapper">
        						<ul class="slider">
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>    
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>
        							<li class="slider_pic">
	        							<img src="../assets/dummy-pic.jpg">
        							</li>    						
        						</ul>
        					</div>	
        					<img class="slider_button_left" src="../assets/syllabus_icon_active.png">
        					<img class="slider_button_right" src="../assets/syllabus_icon_active.png">	            
        				</div>
        			</div>
        			
        		</div>
        	</div>
        </div>
        
        <div class="panel tab_calendar" id="panel_7">
        	This will be a calendar
        </div>
        
        


        </div>

        </div>
        </div>

        <div id="right_panel" class = "group_responsiveness">
            <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'class','origin_id'=>'')); ?>
        </div>


        </div>
        

        </div>


    </body>





</html>