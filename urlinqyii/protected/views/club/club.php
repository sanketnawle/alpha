<html>
    <head>
        <script>
            var globals = {};
            globals.base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            globals.origin_type = '<?php echo 'club'; ?>';
            globals.origin_id = '<?php echo $club->group_id; ?>';
            globals.origin_name = '<?php echo $club->group_name; ?>';
        </script>


        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/module/timezone_conversion.js"> </script>

        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js'></script>

        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_files.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_members.css">

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />




        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_files.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/libs/dropzone.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/tab_members.js'></script>

    </head>

    <body>

    <?php echo Yii::app()->runController('partial/topbar'); ?>
    <div id="wrapper">



        <div id="page">


            <div id="main_panel">


                <div id="content_holder">

                    <div id="left_panel">

                        <?php echo $this->renderPartial('/partial/leftpanel',array('user'=>$user,'origin_type'=>'club','origin_id'=>$club->group_id,'origin_name'=>$club->group_name)); ?>

                    </div>




                    <div id="content_panel">
                        <?php echo $this->renderPartial('/partial/nav_bar',array('origin_type'=>'club','origin_id'=>$club->group_id,'origin'=>$club)); ?>
                        <div id="cover_photo" class="section header banner_image" style="background-size:cover; background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $club->coverFile->file_url ?>');"></div>




                        <div id="tab_bar">

                            <div class="tab feed active" data-panel_id="1">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Club Feed</div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab materials" data-panel_id="2">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Files/Photos</div>
                                    <div class = "tab_amount"><?php echo count($club->files);?></div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab members" data-panel_id="3">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Members</div>
                                    <div class = "tab_amount"><?php echo count($club->members); ?></div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab analytics" data-panel_id="4">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Analytics</div>
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
                            </div>

                            <?php echo $this->renderPartial('/partial/other_views_box',array('user'=>$user,'origin_type'=>'club','origin_id'=>$club->group_id)); ?>

                        </div>


                        <div class="panel active" id="panel_1">
                            CLASS FEED GOES HERE
                        </div>


                        <div class="panel tab_files" id="panel_2">
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
                                    <li class = "files_subtab class_files active" data-panel_id = "1" data-file_list_type="club">
                                        <div class = "tabnav_tab">
                                            <span>Club Files</span>
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
                        <div class = "files_sub_panel active class_files" id ="files_sub_panel_1" data-file_list_type="club">
                            <ol class = "files_list club" data-file_list_type="club">



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


                            </ol>
                        </div>





                        <form action="<?php echo Yii::app()->getBaseUrl(true);?>/class/fileUpload" class="dropzone dz-clickable files_upload_bigbox" id="demo-upload">
                            <div class="bigbox_bigmessage">
                            </div>
                            <input type="hidden" name="id" value="<?php echo $club->group_id; ?>">


                            <input class="upload_files_submit" type="submit" name="submitIT" value="Submit data and files!">
                        </form>





                        </div>
                            <!--</form>-->
                        </div>

                        <div class="panel tab_members" id="panel_3">
                            <div class="tab_content_holder">
                                <div class="tab_header"> 
                                    <div class = "float_Right">
                                        <div class = "add_people_button">
                                            Add People
                                        </div>
                                        <div class = "small_search fade_input_small">
                                            <em id = "left_search_icon">
                                            </em>
                                            <input type = "text" name = "people_search_input" placeholder = "Search people" class = "name_search_input small_search_input">
                                        </div>                                        
                                    </div>
                                    <div class = "header_sentence">
                                        Club Members
                                    </div>
                                </div>
                                <div class = "members_tab_content tab_content">

                                    <?php foreach($club->members as $member){ ?>
                                        <div class = "members_card_wrapper" data-user_id='<?php echo $member->user_id; ?>' data-name="<?php echo $member->firstname . ' ' . $member->lastname; ?>">
                                            <div class = "members_card admin normal_size">
                                                <div class = "members_card_img" style="background-image: url('<?php echo Yii::app()->getBaseUrl(true) . $member->pictureFile->file_url; ?>');">

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
                                                    <a class = "name profile_link"><?php echo $member->full_name(); ?></a>
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


<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Club Admin</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div> -->
<!--                                   <div class = "members_card_wrapper">-->
<!--                                        <div class = "members_card non_admin normal_size" data-user_id='1'>-->
<!--                                            <div class = "members_card_img">-->
<!--                                                <span class = "title">Professor</span>-->
<!--                                                <span class = "class_year">Senior</span>-->
<!--                                            </div>-->
<!--                                            <div class = "user_main_info">-->
<!--                                                <a class = "name profile_link">Jacob Lazarus</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_more_info">-->
<!--                                                <a class = "department_link">Neuroscience</a>-->
<!--                                            </div>-->
<!--                                            <div class = "user_card_button_holder">-->
<!--                                                <div class = "follow_button_wrapper following_wrapper">-->
<!--                                                    <div class = "user_follow_button following">Following</div>-->
<!--                                                    <div class = "user_message_button message_active">-->
<!--                                                        <em class = "white_message_icon">-->
<!--                                                        </em>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                   </div>-->


                                </div>
                            </div>                      
                        </div>

                        <div class="panel" id="panel_4">
                            PANEL 4
                        </div>

                    </div>

                </div>
            </div>

            <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'club','origin_id'=>'')); ?>   


    <!--            <div id="div1" style="height: 500px;position:relative;">-->
    <!--                <div id="div2" style="max-height:100%;overflow:auto;border:1px solid red;">-->
    <!--                    <div id="div3" style="height:1500px;border:5px solid yellow;">hello</div>-->
    <!--                </div>-->
    <!--            </div>-->

        </div>
        <?php echo $this->renderPartial('/partial/right_panel',array('user'=>$user,'origin_type'=>'club','origin_id'=>'')); ?>

    </div>
<!--        <div id="right_menu_panel">-->
<!---->
<!--        </div>-->

    </body>




</html>