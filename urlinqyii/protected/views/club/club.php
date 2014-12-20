<html>


    <head>
        <script>
            base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
            origin_type = '<?php echo 'club'; ?>';
            origin_id = '<?php echo $club->group_id; ?>';

        </script>


        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js'></script>
        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery-ui-1.11.0/jquery-ui.min.js'></script>
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/main.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/tab_files.css">

        <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
        <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />


        <script src='<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/main.js'></script>
    </head>

    <body>

    <?php echo Yii::app()->runController('partial/topbar'); ?>
    <div id="wrapper">
<!--        --><?php //echo Yii::app()->runController('partial/leftmenu'); ?>




        <div id="page">


            <div id="main_panel">


                <div id="content_holder">

                    <div id="left_panel">
<!--                        <section class='leftbar_bag'>-->
                            <?php echo Yii::app()->runController('partial/leftmenu',array('user'=>$user)); ?>
<!--                        </section>-->
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

                            <div class="tab syllabus" data-panel_id="2">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Files/Photos</div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab materials" data-panel_id="3">
                                <div class="tab_content">
                                    <div class="tab_img"></div>
                                    <div class="tab_text">Members</div>
                                </div>
                                <div class="tab_wedge"></div>
                            </div>

                            <div class="tab members" data-panel_id="4">
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
                        </div>


                        <div class="panel active" id="panel_1">
                            CLASS FEED GOES HERE
                        </div>

                        <div class="panel tab_files" id="panel_2">
                            <div id = "tab_content_holder">
                                <div id = "tab_header">
                                    <div id = "tabnav">
                                        <div class = "tabnav_right float_Right">
                                        </div>
                                        <ul class = "tabnav-tabs">
                                        </ul>
                                    </div>
                                    <div id = "tab_global_actions_bar">
                                        <div class = "float_Right tab_floater_bar_half">
                                        </div>                                        
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
                                            <span>Kind</span>
                                            <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                                        </div>
                                        <div id = "date_sorter" data-sort = "files_by_date" data-ascending = "false" class = "sortable_column_header">
                                            <span>Date</span>
                                            <em id = "files_tab_sprites" class = "sort_gray_arrow up"></em>
                                        </div>
                                        <div id = "views_sorter" data-sort = "files_by_views" data-ascending = "false" class = "sortable_column_header">
                                            <span>Views</span>
                                            <em id = "files_tab_sprites sprites" class = "sort_gray_arrow up"></em>
                                        </div>
                                    </div>
                                    <div id = "files_header_bottom_line">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel" id="panel_3">
                            PANEL 3
                        </div>

                        <div class="panel" id="panel_4">
                            PANEL 4
                        </div>

                    </div>

                </div>
            </div>

            <div id="right_panel">

                RIGHT PANEL GOES HERE
            </div>

    <!--            <div id="div1" style="height: 500px;position:relative;">-->
    <!--                <div id="div2" style="max-height:100%;overflow:auto;border:1px solid red;">-->
    <!--                    <div id="div3" style="height:1500px;border:5px solid yellow;">hello</div>-->
    <!--                </div>-->
    <!--            </div>-->

        </div>

<!--            --><?php //echo Yii::app()->runController('partial/rightmenu'); ?>
    </div>
<!--        <div id="right_menu_panel">-->
<!---->
<!--        </div>-->

    </body>




</html>