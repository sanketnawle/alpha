<script id="post_template" type="text/x-handlebars-template">
                        <div id='{{last_activity}}'>
                            <div class = 'post new_fd' id = '{{post_id}}' data-post_id='{{post_id}}' data-post_type='{{post_type}}' data-origin_type='{{origin_type}}'
                                {{#ifCond anon '==' 1}}
                                    {{#ifCond user_id '!=' origin_id}}
                                        data-origin_id="{{origin_id}}"
                                    {{/ifCond}}
                                {{else}}
                                     data-origin_id="{{origin_id}}"
                                {{/ifCond}}
                                 data-created_at='{{created_at}}' data-last_activity='{{last_activity}}'>
                                    <div class="post_main">
                                        <div class = "post_type_marker reg_post_type">
                                            <span class = "post_type_icon"></span>
                                        </div>
                                        <div class="post_head">
                                            <div class="post_title">
                                                <div class = 'image_container'>

                                                    {{#ifCond anon '==' 1}}
                                                    <div class = 'post_user_icon post_user_icon_anonymous' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                                                    </div>
                                                    {{else}}
                                                    <a>
                                                        <div class = 'post_user_icon profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                                                        </div>
                                                    </a>
                                                    {{/ifCond}}
                                                </div>


                                                {{#if user_id}}
                                                    {{#ifCond anon '==' 1}}
                                                                    <span class = 'post_owner anonymous_post_owner'>
                                                                        Anonymous
                                                                    </span>
                                                        {{#if pownership}}
                                                                    <span class="post_owner post_own_post anonymous_post_owner me_post_owner">
                                                                        (me)
                                                                    </span>
                                                        {{/if}}
                                                    {{else}}
                                                        <a>
                                                                    <span class = 'post_owner profile_link' data-user_id={{user_id}} >
                                                                        {{user_info.firstname}} {{user_info.lastname}}
                                                                    </span>
                                                        </a>
                                                    {{/ifCond}}
                                                {{else}}
                                                        <span class = 'post_owner'>
                                                            Invalid User
                                                        </span>
                                                {{/if}}



                                                    {{#ifCond origin_type '==' 'user'}}

                                                        {{#ifCond origin_id '!=' user_id}}
                                                            <span class = 'post_format'>
                                                                <em class = "posted_to"></em>
                                                                <span class = 'post_group'>
                                                                    <div class="profile_link" data-user_id="{{origin_id}}">{{origin.firstname}} {{origin.lastname}}</div>
                                                                </span>
                                                            </span>
                                                        {{/ifCond}}

                                                    {{else}}
                                                        {{#ifCond origin_type '!=' '<?php echo $origin_type; ?>'}}
                                                                <span class = 'post_format'>
                                                                    <em class = "posted_to"></em>
                                                                    <span class = 'post_group'>
                                                                        <a href='<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}'>{{origin.name}}</a>
                                                                    </span>
                                                                </span>
                                                        {{/ifCond}}
                                                    {{/ifCond}}






                                                </div>
                                                <div class = 'post_time'> <span class = "time_icon"></span>
                                                     <time class='timeago' datetime= '{{created_at}}'>
                                                        {{#if created_at}}
                                                        {{update_timestamp}}
                                                        {{else}}
                                                        a few seconds ago
                                                        {{/if}}
                                                     </time>
                                                </div>
                                                <div class = 'post_msg post_lr_link_msg'>
                                                    <span class='msg_span seemore_anchor post_message_text'>
                                                                {{{text}}}
                                                    </span>



                                                {{#each files}}
                                                    {{#ifCond file_extension '===' 'jpg'}}
                                                    <div class = "post_attached_image_container">
                                                        <a href="<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}" data-lightbox="{{original_name}}"  class = 'post_attached_image' title={{original_name}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"><div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div></a>
                                                        
                                                    </div>
                                                    {{else}}
                                                        {{#ifCond download_count '==' 0}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                                        {{else}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                                        {{/ifCond}}
                                                    {{/ifCond}}
                                                {{/each}}

                                                    {{#if embed_link}}

                                                        <!-- <p class='f_hidden_p'><a href='{{embed_link}}'>{{embed_link}}
                                                         </a></p>
                                                         <div class = 'link-wrapper'>
                                                                 <div class = 'link-container'>
                                                                     <a class = 'link-anchor-box'>
                                                                         <div class = 'link-pic-wrap'>
                                                                             <div class='playable_wrap'>
                                                                             <div class='play_btn'></div>
                                                                             <div class = 'link-img'></div>
                                                                             </div>
                                                                             <div class = 'link-text-data'>
                                                                                 <div class = 'link-text-title'>
                                                                                     <span class = 'link-text-website'>

                                                                                     </span>
                                                                                 </div>
                                                                                 <div class = 'link-text-about'>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                     </a>
                                                                 </div>
                                                         </div>-->
                                                    {{/if}}

                                                </div>


                                                <div class = 'post_edit'>
                                                    <textarea class = 'edit_area'></textarea>
                                                    <div class = 'edit_toolbar'>
                                                        <button class = 'edit_done'>Done</button>
                                                        <button class = 'edit_cancel'>Cancel</button>
                                                    </div>
                                                </div>
                                                <div class = 'post_tools'>

                                                    <div class = 'post_lc ' >
                                                        <div class = 'post_comment_btn'>
                                                            <span class = "reply_icon icon icon-comment-discussion"></span>
                                                            {{#ifCond reply_count '>=' 1}}
                                                            <div class = 'reply_number'>

                                                                {{reply_count}}

                                                            </div>
                                                            {{/ifCond}}
                                                        </div>

                                                        {{#ifCond like_status '==' true}}
                                                            <div class = 'post_liked post_like_btn'>
                                                                <i class = "press icon icon-plus"></i>
                                                                <span class = "press">liked</span>
                                                                {{#ifCond like_count '>=' 1}}
                                                                <div class = 'press like_number'>
                                                                    {{like_count}}
                                                                </div>
                                                                {{/ifCond}}                                                                
                                                        {{else}}
                                                            <div class = 'post_like post_like_btn'>
                                                                <i class = "icon icon-plus"></i>
                                                                <span>liked</span>
                                                                {{#ifCond like_count '>=' 1}}
                                                                <div class = 'like_number'>
                                                                    {{like_count}}
                                                                </div>
                                                                {{/ifCond}}                                                                
                                                        {{/ifCond}}



                                                            </div>

                                                        
                                                    </div>
                                            <div class = 'post_functions'>
                                                <div class = 'post_functions_showr shower'>
                                                </div>
                                                <div class = 'post_functions_box'>
                                                    {{#ifCond pownership '||' '<?php echo $is_admin;?>'}}
                                                        <hr class = 'post_options_hr'>
                                                        <div class = 'post_functions_option option_delete'>Delete</div>
                                                    {{else}}
                                                    <div class = 'post_functions_option option_hide'>
                                                        I don&#39;t want to see this
                                                    </div>
                                                        <hr class = 'post_options_hr'>
                                                        <div class = 'post_functions_option option_report'>
                                                            Report this Post
                                                        </div>
                                                    {{/ifCond}}
                                                </div>
                                            </div>
                                <div class='posttool-select'>
                                    <span class='field'>
                                        <img class='vstt_icon' src='http://www.urlinq.com/beta/img/privacy_icons/privacy_status/{{privacy}}_status.png'>
                                        <div class='vstt_wedgeDown'></div>
                                        <div class = 'card-tag'>
                                            <div class = 'tag-wedge'></div>
                                            <div class = 'tag-box'>
                                                <span>Visible to {{privacy}}</span>
                                            </div>
                                        </div>

                                    </span>
                                </div>
                            </div>
                            <div class = "post_tag">
                                <span>Discussion</span>
                            </div>
                    </div>

                    </div>



                    <div class="master_comments" id="{{post_id}}">
                    {{#if replies}}

                            {{#each replies}}
                            <div class = 'comments'>
                                <div class = 'comment_main' data-user_id="{{user_info.user_id}}" data-reply_id="{{reply_id}}">


                                    {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "cursor:default; background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                                        </div>
                                    {{else}}
                                        <div class = 'comment_owner_container profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                                        </div>
                                    {{/ifCond}}

                                    {{#if user_id}}
                                        {{#ifCond anon '==' 1}}
                                            <span class = 'comment_owner anonymous_post_owner'>
                                                        Anonymous
                                                    </span>
                                                    {{#if cownership}}
                                                        <span class="comment_owner comment_own_comment anonymous_post_owner">
                                                            (me)
                                                        </span>
                                                    {{/if}}
                                        {{else}}
                                            <span class = 'comment_owner profile_link' data-user_id={{user_id}} >
                                                {{user_info.user_name}}
                                            </span>
                                        {{/ifCond}}
                                    {{else}}
                                        <span class = 'comment_owner'>
                                            Invalid User
                                        </span>
                                    {{/if}}

                                     <div class = 'comment_time'>
                                        <div class='ct_ts'>
                                            {{update_timestamp}}
                                        </div>
                                    </div>
                                    <div class = 'comment_msg seemore_anchor' id = '{{reply_id}}'>
                                        {{{reply_msg}}}
                                    </div>

                                    {{#if file_id}}

                                        <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='{{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                    {{/if}}

                                    {{#ifCond user_info.user_id '==' '<?php echo $user_id; ?>'}}                                         <div class='reply_delete_button'></div>                                     {{/ifCond}}

                                </div>

                            </div>
                             {{/each}}
                             {{#if show_more}}
                                <div id='show_more' class='morecmt_bar'>
                                    Read more
                                </div>
                            {{/if}}

                    {{/if}}
                    </div>




                    <div class = 'postcomment'>
                        <div class = 'comment_owner_container' style='position: absolute; display: none; margin-left: -51px;'>
                            <div class = 'comment_user_icon' style='background:url(http://www.urlinq.com/beta/DefaultImages/anon.png)'></div>
                        </div>
                        <input class='post_anon_val' name='anon' type='hidden' value='0'>
                        <div class = 'reply_user_icon' style='background:url(http://www.urlinq.com/beta/DefaultImages/anon.png)'></div>
                        <div class = 'commentform'>


                            <form action='/post/reply' class='reply_form' method="POST" enctype="multipart/form-data" data-post_id='{{post_id}}'>

                                <div>
                                    <div class = "pre_expand_comment_fx"><span class = "small_icon_map"></span></div>
                                    <textarea class = 'reply_text_textarea form-control postval ' name='reply_text' placeholder = 'Write a reply...' required></textarea>
                                    <div class = 'dragdrop_functions'>
                                        <div class='dragdropbox'>Drag and drop files here or Click to upload files</div>
                                        <div class='fileinputbox'><input type='file' class='fileinput' multiple></div>
                                        <div class='filelistbox'></div>
                                    </div>
                                </div>
                                <div class = 'reply_functions'>
                                    <div class='check_wrap'>
                                        <input type='checkbox' id='flat_0' class='flat7c'/>
                                        <label for='flat7' class='flat7b'>
                                            <span class='move'></span>
                                        </label>
                                        <span class = 'comment_anon_text'>Post Anonymously</span>
                                    </div>
                                    <a class='reply_button'>
                                        Post Reply
                                    </a>
                                </div>
                            </div>
                            <div class = 'reply_functions'>
                                    <div class='check_wrap'>
                                        <input type='checkbox' id='flat_0' class='flat7c'/>
                                        <label for='flat7' class='flat7b'>
                                            <span class='move'></span>
                                        </label>
                                        <span class = 'comment_anon_text'>Post Anonymously</span>
                                    </div>
                                    <a class = 'reply_button'>
                                        Post Reply
                                    </a>
                            </form>
                        </div>
                    </div>
              </script>



            <script id="reply_template" type="text/x-handlebars-template">

                    {{#each replies}}
                                <div class = 'comments'>
                                    <div class = 'comment_main' data-user_id="{{user_info.user_id}}" data-reply_id="{{reply_id}}">


                                        {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "cursor:default; background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                                        </div>
                                        {{else}}
                                        <div class = 'comment_owner_container profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                                        </div>
                                        {{/ifCond}}
                                        {{#if user_id}}
                                            {{#ifCond anon '==' 1}}
                                                    <span class = 'comment_owner anonymous_post_owner'>
                                                        Anonymous
                                                    </span>
                                                    {{#if cownership}}
                                                        <span class="comment_owner comment_own_comment anonymous_post_owner">
                                                            (me)
                                                        </span>
                                                    {{/if}}
                                            {{else}}
                                                    <span class = 'comment_owner profile_link' data-user_id={{user_id}} >
                                                        {{user_info.user_name}}
                                                    </span>
                                            {{/ifCond}}
                                        {{else}}
                                            <span class = 'comment_owner'>
                                                Invalid User
                                            </span>
                                        {{/if}}
                                        <div class = 'comment_time'>
                                            <div class='ct_ts'>
                                                {{update_timestamp}}
                                            </div>
                                        </div>

                                        <div class = 'comment_msg seemore_anchor' id = '{{reply_id}}'>
                                            {{{reply_msg}}}
                                        </div>

                                        {{#if file_id}}

                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                        {{/if}}

                                        {{#ifCond user_info.user_id '==' '<?php echo $user_id; ?>'}}                                         <div class='reply_delete_button'></div>                                     {{/ifCond}}
                                    </div>

                                </div>

                     {{/each}}
                                <div id='show_less' class='lesscmt_bar'>
                                            Hide Discussion
                                </div>
            </script>


            <script id='one_reply_template' type="text/x-handlebars-template">
                <div class = 'comments'>
                    <div class = 'comment_main' data-user_id="{{user_info.user_id}}" data-reply_id="{{reply_id}}">

                        {{#ifCond anon '==' 1}}
                        <div class = 'comment_owner_container' style = "cursor:default; background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                        </div>
                        {{else}}
                        <div class = 'comment_owner_container profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                        </div>
                        {{/ifCond}}


                        {{#ifCond anon '==' 1}}
                            <span class = 'comment_owner anonymous_post_owner'>
                                Anonymous
                            </span>
                            {{#if cownership}}
                                <span class="comment_owner comment_own_comment anonymous_post_owner">
                                    (me)
                                </span>
                            {{/if}}
                        {{else}}
                            <span class = 'comment_owner profile_link' data-user_id={{user_id}} >
                                {{user_info.user_name}}
                            </span>
                       {{/ifCond}}

                        <div class = 'comment_time'>
                            <div class='ct_ts'>
                                {{update_timestamp}}
                            </div>
                        </div>
                        <div class = 'comment_msg seemore_anchor' id = '{{reply_id}}'>
                            {{{reply_msg}}}
                        </div>

                        {{#if file_id}}

                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                        {{/if}}

                        {{#ifCond user_info.user_id '==' '<?php echo $user_id; ?>'}}                                         <div class='reply_delete_button'></div>                                     {{/ifCond}}
                    </div>

                </div>
            </script>

            <script id="reply_more_template" type="text/x-handlebars-template">

                    {{#each replies}}
                                <div class = 'comments'>
                                    <div class = 'comment_main' data-user_id="{{user_info.user_id}}" data-reply_id="{{reply_id}}">

                                        {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "cursor:default; background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                                        </div>
                                        {{else}}
                                        <div class = 'comment_owner_container profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                                        </div>
                                        {{/ifCond}}
                                        {{#if user_id}}
                                            {{#ifCond anon '==' 1}}
                                                        <span class = 'comment_owner anonymous_post_owner'>
                                                            Anonymous
                                                        </span>
                                                {{#if cownership}}
                                                                <span class="comment_owner comment_own_comment anonymous_post_owner">
                                                                    (me)
                                                                </span>
                                                {{/if}}
                                            {{else}}
                                                        <span class = 'comment_owner profile_link' data-user_id={{user_id}} >
                                                            {{user_info.user_name}}
                                                        </span>
                                            {{/ifCond}}
                                        {{else}}
                                            <span class = 'comment_owner'>
                                                Invalid User
                                            </span>
                                        {{/if}}
                                        <div class = 'comment_time'>
                                            <div class='ct_ts'>
                                                {{update_timestamp}}
                                            </div>
                                        </div>
                                        <div class = 'comment_msg seemore_anchor' id = '{{reply_id}}'>
                                            {{{reply_msg}}}
                                        </div>

                                        {{#if file_id}}

                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                        {{/if}}


                                        {{#ifCond user_info.user_id '==' '<?php echo $user_id; ?>'}}
                                            <div class='reply_delete_button'></div>
                                        {{/ifCond}}
                                    </div>

                                </div>

                     {{/each}}
                                <div id='show_more' class='morecmt_bar'>
                                            Read all
                                </div>

            </script>

            <script id="post_question_template" type="text/x-handlebars-template">
                <div id='{{last_activity}}'>
                            <div class = 'post new_fd' id = '{{post_id}}' data-post_id='{{post_id}}' data-post_type='{{post_type}}' data-created_at='{{created_at}}' data-last_activity='{{last_activity}}'>
                                    <div class="post_main">
                                        <div class = "post_type_marker question_post_type">
                                            <span class = "post_type_icon"></span>
                                        </div>
                                        <div class="post_head">
                                            <div class="post_title">
                                                <div class = 'image_container'>

                                                    {{#ifCond anon '==' 1}}
                                                    <div class = 'post_user_icon post_user_icon_anonymous' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                                                    </div>
                                                    {{else}}
                                                    <a>
                                                        <div class = 'post_user_icon profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                                                        </div>
                                                    </a>
                                                    {{/ifCond}}
                                                </div>


                                                {{#if user_id}}
                                                    {{#ifCond anon '==' 1}}
                                                                    <span class = 'post_owner anonymous_post_owner'>
                                                                        Anonymous
                                                                    </span>
                                                        {{#if pownership}}
                                                            <span class="post_owner post_own_post anonymous_post_owner me_post_owner">
                                                                 (me)
                                                            </span>
                                                        {{/if}}
                                                    {{else}}
                                                        <a>
                                                                    <span class = 'post_owner profile_link' data-user_id={{user_id}} >
                                                                        {{user_info.firstname}} {{user_info.lastname}}
                                                                    </span>
                                                        </a>
                                                    {{/ifCond}}
                                                {{else}}
                                                        <span class = 'post_owner'>
                                                            Invalid User
                                                        </span>
                                                {{/if}}




                                                    {{#ifCond origin_type '!=' '<?php echo $origin_type; ?>'}}


                                                        {{#ifCond origin_type '!=' 'user'}}
                                                            <span class = 'post_format'>
                                                                <em class = "posted_to"></em>
                                                                <span class = 'post_group'>
                                                                    <a href='<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}'>{{origin.name}}</a>
                                                                </span>
                                                            </span>
                                                        {{/ifCond}}

                                                    {{/ifCond}}


                                                </div>
                                                <div class = 'post_time'><span class = "time_icon"></span>
                                                     <time class='timeago' datetime= '{{created_at}}'>
                                                         {{#if created_at}}
                                                         {{update_timestamp}}
                                                         {{else}}
                                                         a few seconds ago
                                                         {{/if}}
                                                     </time>
                                                </div>



                                                {{#if question.options}}
                                                    {{#each question.options}}
                                                    <span class = 'experts_icon'></span>
                                                        <a href='http://www.urlinq.com/beta/profile.php?user_id={{user_id}}'>
                                                    <span class = 'experts_name'>
                                                        {{user_info.firstname}} {{user_info.lastname}}
                                                    </span></a>
                                                    {{/each}}
                                                {{/if}}
                                                    <div class = 'post_msg post_lr_link_msg'>
                                                    <div class='question_title_span'>
                                                                {{{text}}}
                                                    </div>
                                                    <div class='question_subtext_span'>
                                                                {{sub_text}}
                                                    </div>


                                                {{#each files}}
                                                    {{#ifCond file_extension '===' 'jpg'}}
                                                    <div class = "post_attached_image_container">
                                                        <a href="<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}" data-lightbox="{{original_name}}"  class = 'post_attached_image' title={{original_name}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"><div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div></a>
                                                    </div>
                                                    {{else}}
                                                        {{#ifCond download_count '==' 0}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                                        {{else}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                                        {{/ifCond}}
                                                    {{/ifCond}}
                                                {{/each}}                                                    

                                                    {{#ifCond post_type '!=' 'question'}}

                                                        <div class="mc_question">


                                                            {{#if question.active}}
                                                            {{#each question.options}}
                                                            <div class="mc_question_one_choice" id="{{question.answer_index}}" data-option_id="{{option_id}}">

                                                                <input type="radio" id="option_{{../post_id}}_{{option_text}}" class="mc_question_radio_button" data-option_id="{{option_id}}" name="letter_{{../post_id}}" {{#if user_answered}}checked{{/if}}>
                                                                <label for="option_{{../post_id}}_{{option_text}}">{{option_text}}<span class = "closed_question_tip yours">Your answer</span><span class = "closed_question_tip correct">Correct answer<em></em></span><span class = "closed_question_tip wrong">Your answer <em></em></span><span class = "closed_question_tip yourcorrect">Your answer <em></em></span></label>

                                                            </div>

                                                            {{/each}}
                                                            <div class="question_functions">
                                                                <button class = "submit_answer">Submit Answer</button>
                                                                <button class = "clear_answer">Clear</button>
                                                                
                                                                {{#if pownership}}
                                                                    <div class = "close_question"></div>
                                                                    <div class = "help_div">
                                                                        <div class = "wedge">
                                                                        </div>
                                                                        <div class = "box">
                                                                        Close this question 
                                                                        </div>
                                                                    </div>
                                                                    <input id = "show_hide_stats_{{post_id}}" type="checkbox" class = "show_hide_stats" {{#ifCond question.public_stats '==' "1"}}checked{{/ifCond}}><label for = "show_hide_stats_{{post_id}}" class = "flat7b"><span class = "move"></span></label><span class = "show_hide_stats_text">Make answer stats public</span>

                                                                {{/if}}
                                                            </div>
                                                            <div class="submitted_answer" style="display:none;">
                                                                <span class="submitted_icon"></span>submitted
                                                            </div>
                                                            {{else}}
                                                                {{#each question.options}}
                                                                    <div class="mc_question_one_choice closed" id="{{question.answer_index}}" data-option_id="{{option_id}}">

                                                                        <input type="radio" id="option_{{../post_id}}_{{option_text}}" class="mc_question_radio_button
                                                                            {{#if correct_answer}}
                                                                                green
                                                                                {{#if user_answered}}
                                                                                blue
                                                                                {{/if}}
                                                                            {{else}}
                                                                                {{#if user_answered}}
                                                                                    {{#if any_correct_answer}}
                                                                                    red
                                                                                    {{else}}
                                                                                    blue
                                                                                    {{/if}}
                                                                                {{/if}}
                                                                            {{/if}}"
                                                                               data-option_id="{{option_id}}" name="letter_{{../post_id}}" disabled >
                                                                        <label for="option_{{../post_id}}_{{option_text}}">{{option_text}}<span class = "closed_question_tip yours">Your answer</span><span class = "closed_question_tip correct">Correct answer<em></em></span><span class = "closed_question_tip wrong">Your answer <em></em></span><span class = "closed_question_tip yourcorrect">Your answer <em></em></span></label>

                                                                    </div>

                                                                {{/each}}
                                                            <div class="question_functions">This question is closed.</div>
                                                            {{/if}}

                                                        </div>
                                                       <!-- {{#if question.active}}
                                                        <div class="closed_question" style="display:none;">
                                                            This question is closed.
                                                        </div>
                                                        {{else}}
                                                        <div class="closed_question">
                                                            This question is closed.
                                                        </div>
                                                        {{/if}} -->


                                                    {{/ifCond}}

                                                    {{#ifCond post_type '!=' "question"}}
                                                        {{#if question.show_stats}}

                                                            <div class='question_analytics_holder' data-answer_count="{{question.total_answers}}">
                                                        {{else}}
                                                            <div class='question_analytics_holder' style="display:none" data-answer_count="{{question.total_answers}}">
                                                        {{/if}}

                                                                {{#if question.any_answers}}
                                                                <div class="chart_overlay"  style="display:none">

                                                                    <div class="overlay_text">No Answers</div>
                                                                </div>
                                                                {{else}}
                                                                <div class="chart_overlay">

                                                                    <div class="overlay_text">No Answers Yet</div>
                                                                </div>
                                                                {{/if}}
                                                                <canvas class="pie_{{post_id}}" width="120" height="120"></canvas>
                                                                <div class='answer_labels_box'>
                                                                    {{#each question.options}}
                                                                    <div class='answer_cell'>
                                                                        <div class='answer_color_box' style="background-color:{{color}}"></div>

                                                                        <div class='answer_label'>{{option_text}}</div>
                                                                    </div>
                                                                    {{/each}}
                                                                </div>
                                                             </div>
                                                    {{/ifCond}}






                                                    {{#if file_id}}

                                                        <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                                    {{/if}}








                                                    {{#if embed_link}}

                                                       <!-- <p class='f_hidden_p'>
                                                            <a id="embed_link" href='{{embed_link}}'>
                                                                {{embed_link}}
                                                             </a>
                                                        </p>
                                                        <div class = 'link-wrapper'>
                                                                <div class = 'link-container'>
                                                                    <a class = 'link-anchor-box'>
                                                                        <div class = 'link-pic-wrap'>
                                                                            <div class='playable_wrap'>
                                                                            <div class='play_btn'></div>
                                                                            <div class = 'link-img'></div>
                                                                            </div>
                                                                            <div class = 'link-text-data'>
                                                                                <div class = 'link-text-title'> hi
                                                                                    <span class = 'link-text-website'>

                                                                                    </span>
                                                                                </div>
                                                                                <div class = 'link-text-about'>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                        </div>-->

                                                    {{/if}}

                                                    </div>


                                                <div class = 'post_edit'>
                                                    <textarea class = 'edit_area'></textarea>
                                                    <div class = 'edit_toolbar'>
                                                        <button class = 'edit_done'>Done</button>
                                                        <button class = 'edit_cancel'>Cancel</button>
                                                    </div>
                                                </div>
                                                <div class = 'post_tools'>
                                                    <div class = 'post_lc'>
                                                        <div class = 'post_comment_btn'>
                                                            <span class = "reply_icon icon icon-comment-discussion"></span>
                                                            {{#ifCond reply_count '>=' 1}}
                                                            <div class = 'reply_number'>

                                                                {{reply_count}}

                                                            </div>
                                                            {{/ifCond}}
                                                        </div>

                                                        {{#ifCond like_status '==' true}}
                                                            <div class = 'post_liked post_like_btn'>
                                                                <i class = "icon icon-plus press"></i>
                                                                <span class = 'press'>liked</span>
                                                                {{#ifCond like_count '>=' 1}}
                                                                <div class = 'like_number press'>

                                                                    {{like_count}}

                                                                </div>
                                                                {{/ifCond}}                                                                
                                                        {{else}}
                                                            <div class = 'post_like post_like_btn'>
                                                                <i class = "icon icon-plus"></i>
                                                                <span>liked</span>
                                                                {{#ifCond like_count '>=' 1}}
                                                                <div class = 'like_number'>

                                                                    {{like_count}}

                                                                </div>
                                                                {{/ifCond}}                                                                
                                                        {{/ifCond}}




                                                            </div>

                                                        

                                                        <div class = 'show_analytics_btn'>

                                                        </div>


                                                    </div>
                                        <div class = 'post_functions'>
                                                <div class = 'post_functions_showr shower'>
                                                </div>
                                                <div class = 'post_functions_box'>
                                                    {{#ifCond pownership '||' '<?php echo $is_admin;?>'}}
                                            <hr class = 'post_options_hr'>
                                            <div class = 'post_functions_option option_delete'>Delete</div>
                                                    {{else}}
                                                    <div class = 'post_functions_option option_hide'>
                                                        I don&#39;t want to see this
                                                    </div>
                                                        <hr class = 'post_options_hr'>
                                                        <div class = 'post_functions_option option_report'>
                                                            Report this Post
                                                        </div>
                                                    {{/ifCond}}
                                                </div>
                                            </div>
                                <div class='posttool-select'>
                                    <span class='field'>
                                        <img class='vstt_icon' src='http://www.urlinq.com/beta/img/privacy_icons/privacy_status/{{privacy}}_status.png'>
                                        <div class='vstt_wedgeDown'></div>
                                        <div class = 'card-tag'>
                                            <div class = 'tag-wedge'></div>
                                            <div class = 'tag-box'>
                                                <span>Visible to {{privacy}}</span>
                                            </div>
                                        </div>

                                    </span>
                                </div>
                            </div>
                            <div class = "post_tag">
                                <span>Question</span>
                            </div>
                    </div>

                    </div>



                    <div class="master_comments" id="{{post_id}}" data-post_id='{{post_id}}'>
                    {{#if replies}}

                            {{#each replies}}
                            <div class = 'comments'>
                                <div class = 'comment_main' data-user_id="{{user_info.user_id}}" data-reply_id="{{reply_id}}">


                                    {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "cursor:default; background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                                        </div>
                                    {{else}}
                                        <div class = 'comment_owner_container profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                                        </div>
                                    {{/ifCond}}

                                    {{#if user_id}}
                                        {{#ifCond anon '==' 1}}
                                                <span class = 'comment_owner anonymous_post_owner'>
                                                        Anonymous
                                                    </span>
                                                    {{#if cownership}}
                                                        <span class="comment_owner comment_own_comment anonymous_post_owner">
                                                            (me)
                                                        </span>
                                                    {{/if}}
                                        {{else}}
                                                <span class = 'comment_owner profile_link' data-user_id={{user_id}} >
                                                    {{user_info.user_name}}
                                                </span>
                                        {{/ifCond}}
                                    {{else}}
                                        <span class = 'comment_owner'>
                                            Invalid User
                                        </span>
                                    {{/if}}
                                     <div class = 'comment_time'>
                                        <div class='ct_ts'>
                                            {{update_timestamp}}
                                        </div>
                                    </div>
                                    <div class = 'comment_msg seemore_anchor' id = '{{reply_id}}'>
                                        {{{reply_msg}}}
                                    </div>

                                    {{#if file_id}}

                                        <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                    {{/if}}



                                    {{#ifCond user_info.user_id '==' '<?php echo $user_id; ?>'}}
                                      <div class='reply_delete_button'></div>
                                    {{/ifCond}}
                                </div>

                            </div>
                             {{/each}}
                             {{#if show_more}}
                                <div id='show_more' class='morecmt_bar'>
                                    Read all
                                </div>
                             {{/if}}

                    {{/if}}
                    </div>
                    <div class = 'postcomment'>
                        <div class = 'comment_owner_container profile_link' data-user_id={{user_id}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                        </div>
                        <input class='post_anon_val' name='anon' type='hidden' value='0'>
                        <div class = 'reply_user_icon' style='background:url(http://www.urlinq.com/beta/DefaultImages/anon.png)'></div>
                        <div class = 'commentform'>
                            <form action='/post/reply' class='reply_form' method="POST" enctype="multipart/form-data" data-post_id='{{post_id}}'>

                                <div>
                                    <div class = "pre_expand_comment_fx"><span class = "small_icon_map"></span></div>
                                    {{#ifCond post_type '==' 'question'}}
                                    <textarea class = 'reply_text_textarea form-control postval ' name='reply_text' placeholder = 'Respond to this question...' required></textarea>
                                    {{else}}
                                    <textarea class = 'reply_text_textarea form-control postval ' name='reply_text' placeholder = 'Discuss this question...' required></textarea>
                                    {{/ifCond}}
                                    <div class = 'dragdrop_functions'>
                                        <div class='dragdropbox'>Drag and drop files here or Click to upload files</div>
                                        <div class='fileinputbox'><input type='file' class='fileinput' multiple></div>
                                        <div class='filelistbox'></div>
                                    </div>
                                </div>
                                <div class = 'reply_functions'>
                                    <div class='check_wrap'>
                                        <input type='checkbox' id='flat_0' class='flat7c'/>
                                        <label for='flat7' class='flat7b'>
                                            <span class='move'></span>
                                        </label>
                                        <span class = 'comment_anon_text'>Post Anonymously</span>
                                    </div>
                                    <a class='reply_button'>
                                        Add Comment
                                    </a>
                                </div>
                        </div>
                        <div class = 'reply_functions'>
                            <div class='check_wrap'>
                                <input type='checkbox' id='flat_0' class='flat7c'/>
                                <label for='flat7' class='flat7b'>
                                    <span class='move'></span>
                                </label>
                                <span class = 'comment_anon_text'>Post Anonymously</span>
                            </div>
                            <a class = 'reply_button'>
                                Add Comment
                            </a>
                        </form>
                    </div>
            </script>



            <script id="post_event_template" type="text/x-handlebars-template">
                <div class = 'post new_fd' id = '{{post_id}}' data-post_id='{{post_id}}' data-event_id='{{event.event_id}}' data-post_type='{{post_type}}' data-origin_type='{{origin_type}}'
                {{#ifCond anon '==' 1}}
                    {{#ifCond user_id '!=' origin_id}}
                        data-origin_id="{{origin_id}}"
                    {{/ifCond}}
                {{else}}
                    data-origin_id="{{origin_id}}"
                {{/ifCond}}
                data-created_at='{{created_at}}' data-last_activity='{{last_activity}}'>
                    {{#if event.attending}}
                    <div class = 'post_attendees'>
                        <div class = "post_attendees_link_arrow">
                        </div>
                        <div class = "post_attendees_link_arrow_border">
                        </div>
                        <div class="post_last_user_joined">
                            <div class="post_last_user_image profile_link" data-user_id="{{event.last_joined.user_id}}" style='background-image:url("<?php echo Yii::app()->getBaseUrl(true);?>{{event.last_joined.pictureFile.file_url}}")'></div>
                            <div class="post_last_user_text"><a><span class="post_last_user_name profile_link" data-user_id="{{event.last_joined.user_id}}">{{event.last_joined.firstname}} {{event.last_joined.lastname}}</span></a> is attending</div>
                        </div>

                        {{#if event.other_attendees}}
                        <span class="post_divider"></span>
                        <div class="post_other_attendees_holder">
                            <div class = "post_other_attendees_link">
                            {{#each event.other_attendees}}
                                <div class="post_other_attendees">

                                    <div class="post_user_image profile_link" data-user_id="{{user_id}}" style='background-image:url(<?php echo Yii::app()->getBaseUrl(true);?>{{pictureFile.file_url}})'></div>
                                    <div class="post_user_popup help_div dark">
                                        <div class = "wedge"></div>
                                        <div class = "box">{{firstname}} {{lastname}}</div>
                                    </div>

                                </div>
                            {{/each}}
                            <div class="post_other_attendees_count">
                                {{#ifCond event.other_attendee_count '==' 1}}
                                    <span>1</span> more attendee
                                {{else}}
                                    <span>{{event.other_attendee_count}}</span> more attendees
                                {{/ifCond}}
                            </div>
                            </div>
                        </div>
                        {{/if}}
                    </div>
                    {{/if}}
                    <div class = 'post_main event_post'>
                        <div class = "post_type_marker event_post_type">
                            <span class = "post_type_icon"></span>
                        </div>

                        <div class = 'post_head'>
                            <div class = 'post_event_date_box' style = "background-color:{{event.color.hex}};">
                                <div class = "top_dark_area"></div>
                                <div class='post_event_month post_event_date_box_text'>{{event.month}}</div>
                                <div class='post_event_day post_event_date_box_text'>{{event.day_number}}</div>
                            </div>
                            <div class = "event_post_toparea">
                                {{#ifCond event.attend_status '!=' "none"}}
                                    {{#ifCond event.origin_type '!=' 'user'}}
                                        <span class = 'post_group'><a href='<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}'>{{origin.name}}</a></span>
                                        <em class = "posted_to"></em>
                                        <div class='post_event_title'><a class="event_link" data-event_start_date="{{event.start_date}}" data-event_id="{{event.event_id}}">{{event.title}}</a></div>
                                    {{else}}
                                        <div class='post_event_title'><a class="event_link" data-event_start_date="{{event.start_date}}" data-event_id="{{event.event_id}}">{{event.title}}</a></div>
                                    {{/ifCond}}
                                {{else}}
                                    {{#ifCond event.origin_type '!=' 'user'}}
                                        <span class = 'post_group'><a href='<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}'>{{origin.name}}</a></span>
                                        <em class = "posted_to"></em>
                                        <div class='post_event_title not_in_calendar'>{{event.title}}</div>
                                    {{else}}
                                        <div class='post_event_title not_in_calendar'>{{event.title}}</div>
                                    {{/ifCond}}
                                {{/ifCond}}
                                {{#if event.location}}
                                <div class = "post_event_location_holder">
                                    <div class = "post_event_location"><span class = "location_icon_dark"></span>{{event.location}}</div>
                                </div>
                                {{/if}}



                                {{#ifCond event.origin_type '!=' 'user'}}
                                    <div class = "event_context">
                                        <span class = "down_right_arrow_icon"></span>
                                        <div class='post_event_type_holder'>
                                            {{#if event.event_type}}
                                                <div class = "post_event_type">{{event.event_type}} &#xb7;</div>
                                            {{/if}}
                                        </div>
                                        <div class='post_event_time_holder'>
                                            <div class='post_event_start_time'>{{event.start_time_string}}</div> {{#if event.end_time_string}}to <div class='post_event_end_time'>{{event.end_time_string}}{{/if}}</div>
                                        </div>
                                    </div>
                                {{else}}
                                    {{#ifCond '<?php echo $user_id;?>' '!=' event.origin_id}}
                                        <div class = "event_context">
                                            <span class = "down_right_arrow_icon"></span>
                                            <div class='post_event_type_holder'>
                                                {{#if event.event_type}}
                                                    <div class = "post_event_type">{{event.event_type}} &#xb7;</div>
                                                {{/if}}
                                            </div>
                                            <div class='post_event_time_holder'>
                                                <div class='post_event_start_time'>{{event.start_time_string}}</div> {{#if event.end_time_string}}to <div class='post_event_end_time'>{{event.end_time_string}}{{/if}}</div>
                                            </div>                                        
                                        </div>
                                    {{/ifCond}}

                                {{/ifCond}}
                            </div>




                            <div class='post_event_content'>

                                {{#if event.description}}
                                    <div class = "event_description_holder">
                                        <p class = "post_message_text">{{{event.description}}}</p>
                                    </div>
                                {{/if}}
                                {{#each files}}
                                    {{#ifCond file_extension '===' 'jpg'}}
                                    <div class = "post_attached_image_container post_attached_image_container_flier">
                                        <div class = 'post_attached_image post_attached_image_flier' title={{original_name}} data-lightbox="{{original_name}}" style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"></div>
                                        <div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div>
                                    </div>
                                    {{else}}
                                        {{#ifCond download_count '==' 0}}
                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                        {{else}}
                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                        {{/ifCond}}
                                    {{/ifCond}}
                                {{/each}}

                                {{#ifCond event.attend_status '==' "none"}}
                                    <div class='post_event_calendar_button add_to_calendar_button' data-event_id='{{event.event_id}}'><span class = "add_to_cal_icon"></span>Add to Calendar</div>
                                    <div class="post_choose_attending" style="display: none;" data-event_id='{{event.event_id}}'>
                                {{else}}
                                    {{#if pownership}}
                                        <div class='post_event_calendar_button added event_owner' data-event_id='{{event.event_id}}'><span class = "add_to_cal_icon added"></span>My Event</div>
                                        <div class="post_choose_attending"  data-event_id='{{event.event_id}}'>
                                    {{else}}
                                        <div class='post_event_calendar_button added' data-event_id='{{event.event_id}}'><span class = "add_to_cal_icon added"></span>Added</div>
                                        <div class="post_choose_attending"  data-event_id='{{event.event_id}}'>

                                    {{/if}}

                                {{/ifCond}}

                                    <span class="post_attending_label">Are you attending?</span>
                                    <input type="radio" id="post_choose_yes_{{event.event_id}}" class="post_choose_attending_button event_attending_choose_yes_input" name="{{event.event_id}}" value="Yes"
                                        {{#ifCond event.attend_status '==' "Attending"}}checked{{/ifCond}}>
                                    <label class = "post_choose_yes_label" for="post_choose_yes_{{event.event_id}}">Yes</label>
                                    <input type="radio" id="post_choose_maybe_{{event.event_id}}" class="post_choose_attending_button event_attending_choose_maybe_input" name="{{event.event_id}}" value="Maybe"
                                        {{#ifCond event.attend_status '==' "Maybe Attending"}}checked{{/ifCond}}>
                                    <label class = "post_choose_maybe_label" for="post_choose_maybe_{{event.event_id}}">Maybe</label>
                                    <input type="radio" id="post_choose_no_{{event.event_id}}" class="post_choose_attending_button event_attending_choose_no_input" name="{{event.event_id}}" value="No"
                                        {{#ifCond event.attend_status '==' "Not Attending"}}checked{{/ifCond}}>
                                    <label class = "post_choose_no_label" for="post_choose_no_{{event.event_id}}">No</label>
                                    {{#if event.conflict}}
                                    <div class="post_conflict_indicator"><span class="post_conflict_icon red"></span></div>
                                    <div class="conflicting_event_popup">Time conflict with: <span class = "conflict_event_name">{{event.conflict.title}}</span></div>


                                    {{else}}
                                            {{#if event.just_ending}}
                                            <div class="post_conflict_indicator"><span class="post_conflict_icon orange"></span></div>
                                            <div class="conflicting_event_popup">Starts immediately after: <span class = "conflict_event_name">{{event.just_ending.title}}</span></div>


                                            {{else}}
                                                {{#if event.just_starting}}
                                                <div class="post_conflict_indicator"><span class="post_conflict_icon orange"></span></div>
                                                <div class="conflicting_event_popup">Ends immediately before: <span class = "conflict_event_name">{{event.just_starting.title}}</span></div>

                                                {{/if}}
                                            {{/if}}
                                    {{/if}}
                                </div>





                                <div class = 'post_functions event_functions'>
                                    <div class = 'post_functions_showr shower'>
                                    </div>
                                    <div class = 'post_functions_box'>
                                        {{#ifCond pownership '||' '<?php echo $is_admin;?>'}}
                                        <hr class = 'post_options_hr'>
                                        <div class = 'post_functions_option option_delete'>Delete</div>
                                        {{else}}
                                        <div class = 'post_functions_option option_hide'>
                                            I don&#39;t want to see this
                                        </div>
                                        <hr class = 'post_options_hr'>
                                        <div class = 'post_functions_option option_report'>
                                            Report this Post
                                        </div>
                                        {{/ifCond}}
                                    </div>
                                </div>



                            </div>



                        </div>
                    </div>
                </div>
            </script>

            <script id="post_opportunity_template" type="text/x-handlebars-template">
                <div class = 'post new_fd' id = '{{post_id}}' data-post_id='{{post_id}}' data-event_id='{{event.event_id}}' data-post_type='{{post_type}}' data-origin_type='{{origin_type}}'
                {{#ifCond anon '==' 1}}
                    {{#ifCond user_id '!=' origin_id}}
                        data-origin_id="{{origin_id}}"
                    {{/ifCond}}
                {{else}}
                    data-origin_id="{{origin_id}}"
                {{/ifCond}}
                data-created_at='{{created_at}}' data-last_activity='{{last_activity}}'>
                    <div class = 'post_main opportunity_post'>

                        <div class = 'post_head'>

                            <div class = "event_post_toparea">
                                <div class='post_event_title post_opportunity_title'>{{event.title}}</div>
                                <a class = 'opportunity_mail_icon' href="mailto:{{user_info.user_email}}"></a>
                                <div class ="help_div dark">
                                    <div class = "wedge">
                                    </div>
                                    <div class = "box">
                                        <div class = "mail_hint">Email {{user_info.user_email}}</div>
                                    </div>
                                </div>

                                {{#if user_id}}
                                    {{#ifCond anon '==' 1}}
                                        <span class = 'post_owner anonymous_post_owner'>
                                            Anonymous
                                        </span>
                                        {{#if pownership}}
                                                            <span class="post_owner post_own_post anonymous_post_owner me_post_owner">
                                                                (me)
                                                            </span>
                                        {{/if}}
                                    {{else}}
                                        <a>
                                        <span class = 'post_owner profile_link' data-user_id={{user_id}} >
                                            {{user_info.firstname}} {{user_info.lastname}}
                                        </span>
                                        </a>
                                    {{/ifCond}}
                                {{else}}
                                    <span class = 'post_owner'>
                                        Invalid User
                                    </span>
                                {{/if}}


                            </div>

                            <div class='post_event_content'>

                                {{#if event.description}}
                                    <div class = "event_description_holder">
                                        <p>{{{event.description}}}</p>
                                    </div>
                                {{/if}}
                                {{#each files}}
                                    {{#ifCond file_extension '===' 'jpg'}}
                                    <div class = "post_attached_image_container post_attached_image_container_flier">
                                        <div class = 'post_attached_image post_attached_image_flier' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"></div>
                                        <div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div>
                                    </div>
                                    {{else}}
                                        {{#ifCond download_count '==' 0}}
                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                        {{else}}
                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                        {{/ifCond}}
                                    {{/ifCond}}
                                {{/each}}


                                {{#ifCond user_attending '==' false}}
                                    <div class='post_event_calendar_button save_opportunity_btn add_to_calendar_button' data-event_id='{{event.event_id}}'><span class = "add_to_cal_icon"></span>Save Opportunity</div>
                                {{else}}
                                    <div class='post_event_calendar_button added save_opportunity_btn add_to_calendar_button' data-event_id='{{event.event_id}}'><span class = "add_to_cal_icon added"></span>Saved</div>
                                {{/ifCond}}

                                <div class = "apply_by_div">
                                    <span class = "apply_by_text">Deadline:</span>
                                    <span class='apply_by_text apply_by_text_month'>{{event.month}}</span>
                                    <span class='apply_by_text apply_by_text_day'>{{event.day_number}}</span>
                                    {{#if event.end_time_string}}
                                    <span class='apply_by_text apply_by_text_time'>at {{event.end_time_string}}</span>
                                    {{/if}}
                                </div>

                                <div class = 'post_functions event_functions'>
                                    <div class = 'post_functions_showr shower'>
                                    </div>
                                    <div class = 'post_functions_box'>
                                        {{#ifCond pownership '||' '<?php echo $is_admin;?>'}}
                                        <hr class = 'post_options_hr'>
                                        <div class = 'post_functions_option option_delete'>Delete</div>
                                        {{else}}
                                        <div class = 'post_functions_option option_hide'>
                                            I don&#39;t want to see this
                                        </div>
                                        <hr class = 'post_options_hr'>
                                        <div class = 'post_functions_option option_report'>
                                            Report this Post
                                        </div>
                                        {{/ifCond}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="master_comments" id="{{post_id}}">
                    {{#if replies}}

                            {{#each replies}}
                            <div class = 'comments'>
                                <div class = 'comment_main' data-user_id="{{user_info.user_id}}" data-reply_id="{{reply_id}}">




                                    {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "cursor:default; background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                                        </div>
                                    {{else}}
                                        <div class = 'comment_owner_container profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                                        </div>
                                    {{/ifCond}}

                                    {{#if user_id}}
                                        {{#ifCond anon '==' 1}}
                                               <span class = 'comment_owner anonymous_post_owner'>
                                                        Anonymous
                                                    </span>
                                                 {{#if cownership}}
                                                        <span class="comment_owner comment_own_comment anonymous_post_owner">
                                                            (me)
                                                        </span>
                                                 {{/if}}
                                        {{else}}
                                                <span class = 'comment_owner profile_link' data-user_id={{user_id}} >
                                                    {{user_info.user_name}}
                                                </span>
                                        {{/ifCond}}
                                    {{else}}
                                        <span class = 'comment_owner'>
                                            Invalid User
                                        </span>
                                    {{/if}}
                                     <div class = 'comment_time'>
                                        <div class='ct_ts'>
                                            {{update_timestamp}}
                                        </div>
                                    </div>
                                    <div class = 'comment_msg seemore_anchor' id = '{{reply_id}}'>
                                        {{{reply_msg}}}
                                    </div>

                                    {{#each files}}
                                        {{#ifCond file_extension '===' 'jpg'}}
                                        <div class = "post_attached_image_container">
                                            <div class = 'post_attached_image' title={{original_name}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"><div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div></div>
                                        </div>
                                        {{else}}
                                            {{#ifCond download_count '==' 0}}
                                                <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                            {{else}}
                                                <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                            {{/ifCond}}
                                        {{/ifCond}}
                                    {{/each}}

                                {{#ifCond user_info.user_id '==' '<?php echo $user_id; ?>'}}
                                  <div class='reply_delete_button'></div>
                                {{/ifCond}}
                                </div>

                            </div>
                             {{/each}}
                             {{#if show_more}}
                                <div id='show_more' class='morecmt_bar'>
                                    Read All
                                </div>
                            {{/if}}

                    {{/if}}
                    </div>



                    <div class = 'postcomment'>
                        <div class = 'comment_owner_container profile_link' data-user_id={{user_id}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                        </div>
                        <input class='post_anon_val' name='anon' type='hidden' value='0'>
                        <div class = 'reply_user_icon'></div>
                        <div class = 'commentform'>


                            <form action='/post/reply' class='reply_form' method="POST" enctype="multipart/form-data" data-post_id='{{post_id}}'>
                                <div>
                                    <div class = "pre_expand_comment_fx"><span class = "small_icon_map"></span></div>
                                    <textarea class = 'reply_text_textarea form-control postval' placeholder = 'Add a comment or question about this opportunity...' required></textarea>
                                    <div class = 'dragdrop_functions'>
                                        <div class='dragdropbox'>Drag and drop files here or Click to upload files</div>
                                        <div class='fileinputbox'><input type='file' class='fileinput' multiple></div>
                                        <div class='filelistbox'></div>
                                    </div>
                                </div>
                                <div class = 'reply_functions'>
                                    <div class='check_wrap'>
                                        <input type='checkbox' id='flat_0' class='flat7c'/>
                                        <label for='flat7' class='flat7b'>
                                            <span class='move'></span>
                                        </label>
                                        <span class = 'comment_anon_text'>Post Anonymously</span>
                                    </div>
                                    <a class = 'reply_button'>
                                        Post Reply
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class = 'reply_functions'>
                                <div class='check_wrap'>
                                    <input type='checkbox' id='flat_0' class='flat7c'/>
                                    <label for='flat7' class='flat7b'>
                                        <span class='move'></span>
                                    </label>
                                    <span class = 'comment_anon_text'>Post Anonymously</span>
                                </div>
                                <a class = 'reply_button'>
                                    Add Comment
                                </a>
                        </div>
                    </div>
                </div>
            </script>

            <script id="post_note_template" type="text/x-handlebars-template">
                <div id='{{last_activity}}'>
                            <div class = 'post new_fd' id = '{{post_id}}' data-post_id='{{post_id}}' data-created_at='{{created_at}}' data-last_activity='{{last_activity}}'>
                                    <div class="post_main">
                                        <div class = "post_type_marker notes_post_type">
                                            <span class = "post_type_icon"></span>
                                        </div>
                                        <div class="post_head">
                                            <div class="post_title">

                                                    <div class = 'image_container'>

                                                        {{#ifCond anon '==' 1}}
                                                        <div class = 'post_user_icon post_user_icon_anonymous' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                                                        </div>
                                                        {{else}}
                                                        <a>
                                                            <div class = 'post_user_icon profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                                                            </div>
                                                        </a>
                                                        {{/ifCond}}
                                                    </div>


                                                    {{#if user_id}}
                                                        {{#ifCond anon '==' 1}}
                                                                <span class = 'post_owner anonymous_post_owner'>
                                                                    Anonymous
                                                                </span>
                                                                {{#if pownership}}
                                                                    <span class="post_owner post_own_post anonymous_post_owner me_post_owner">
                                                                        (me)
                                                                    </span>
                                                                {{/if}}
                                                        {{else}}
                                                           <a>
                                                                <span class = 'post_owner profile_link' data-user_id={{user_id}} >
                                                                    {{user_info.firstname}} {{user_info.lastname}}
                                                                </span>
                                                           </a>
                                                        {{/ifCond}}
                                                    {{else}}
                                                        <span class = 'post_owner'>
                                                            Invalid User
                                                        </span>
                                                    {{/if}}




                                                    {{#ifCond origin_type '!=' '<?php echo $origin_type; ?>'}}


                                                        {{#ifCond origin_type '!=' 'user'}}
                                                            <span class = 'post_format'>
                                                                <em class = "posted_to"></em>
                                                                <span class = 'post_group'>
                                                                    <a href='<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}'>{{origin.name}}</a>
                                                                </span>
                                                            </span>
                                                        {{/ifCond}}

                                                    {{/ifCond}}


                                                </div>
                                                <div class = 'post_time'><span class = "time_icon"></span>
                                                     <time class='timeago' datetime= '{{created_at}}'>
                                                         {{#if created_at}}
                                                         {{update_timestamp}}
                                                         {{else}}
                                                         a few seconds ago
                                                         {{/if}}
                                                     </time>
                                                </div>

                                                <div class = 'post_msg post_file_msg'>
                                                    <span class='msg_span seemore_anchor post_message_text'>{{{text}}}</span>




                                                {{#each files}}
                                                    {{#ifCond file_extension '===' 'jpg'}}
                                                    <div class = "post_attached_image_container">
                                                        <div class = 'post_attached_image' title={{original_name}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"><div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div></div>
                                                    </div>
                                                    {{else}}
                                                        {{#ifCond download_count '==' 0}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                                        {{else}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                                        {{/ifCond}}
                                                    {{/ifCond}}
                                                {{/each}}

                                                </div>







                                                <div class = 'post_edit'>
                                                    <textarea class = 'edit_area'></textarea>
                                                    <div class = 'edit_toolbar'>
                                                        <button class = 'edit_done'>Done</button>
                                                        <button class = 'edit_cancel'>Cancel</button>
                                                    </div>
                                                </div>
                                                <div class = 'post_tools'>
                                                    <div class = 'post_lc'>
                                                        <div class = 'post_comment_btn'>
                                                            <span class = "reply_icon icon icon-comment-discussion"></span>
                                                            {{#ifCond reply_count '>=' 1}}
                                                            <div class = 'reply_number'>

                                                                {{reply_count}}

                                                            </div>
                                                            {{/ifCond}}
                                                        </div>
                                                        {{#ifCond like_status '==' true}}
                                                            <div class = 'post_liked post_like_btn'>
                                                                <i class = 'icon icon-plus press'></i>
                                                                <span class = 'press'>liked</span>
                                                                {{#ifCond like_count '>=' 1}}
                                                                <div class = 'like_number press'>

                                                                    {{like_count}}

                                                                </div>
                                                                {{/ifCond}}                                                               
                                                        {{else}} 
                                                            <div class = 'post_like post_like_btn'>
                                                                <i class = "icon icon-plus"></i>
                                                                <span>liked</span>
                                                                {{#ifCond like_count '>=' 1}}
                                                                <div class = 'like_number'>

                                                                    {{like_count}}

                                                                </div>
                                                                {{/ifCond}}                                                                
                                                        {{/ifCond}}




                                                            </div>

                                                        
                                                    </div>
                                                            <div class = 'post_functions'>
                                                <div class = 'post_functions_showr shower'>
                                                </div>
                                                <div class = 'post_functions_box'>
                                                    {{#ifCond pownership '||' '<?php echo $is_admin;?>'}}
                                            <hr class = 'post_options_hr'>
                                            <div class = 'post_functions_option option_delete'>Delete</div>
                                                    {{else}}
                                                    <div class = 'post_functions_option option_hide'>
                                                        I don&#39;t want to see this
                                                    </div>
                                                        <hr class = 'post_options_hr'>
                                                        <div class = 'post_functions_option option_report'>
                                                            Report this Post
                                                        </div>
                                                    {{/ifCond}}
                                                </div>
                                            </div>
                                <div class='posttool-select'>
                                    <span class='field'>
                                        <img class='vstt_icon' src='http://www.urlinq.com/beta/img/privacy_icons/privacy_status/{{privacy}}_status.png'>
                                        <div class='vstt_wedgeDown'></div>
                                        <div class = 'card-tag'>
                                            <div class = 'tag-wedge'></div>
                                            <div class = 'tag-box'>
                                                <span>Visible to {{privacy}}</span>
                                            </div>
                                        </div>

                                    </span>
                                </div>
                            </div>
                            <div class = "post_tag">
                                <span>Files</span>
                            </div>
                    </div>

                    </div>


                    <div class="master_comments" id="{{post_id}}">
                    {{#if replies}}

                            {{#each replies}}
                            <div class = 'comments'>
                                <div class = 'comment_main' data-user_id="{{user_info.user_id}}" data-reply_id="{{reply_id}}">




                                    {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "cursor:default; background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
                                        </div>
                                    {{else}}
                                        <div class = 'comment_owner_container profile_link' data-user_id='{{user_id}}' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                                        </div>
                                    {{/ifCond}}

                                    {{#if user_id}}
                                        {{#ifCond anon '==' 1}}
                                                <span class = 'comment_owner anonymous_post_owner'>
                                                        Anonymous
                                                    </span>
                                                {{#if cownership}}
                                                        <span class="comment_owner comment_own_comment anonymous_post_owner">
                                                            (me)
                                                        </span>
                                                {{/if}}
                                        {{else}}
                                                <span class = 'comment_owner profile_link' data-user_id={{user_id}} >
                                                    {{user_info.user_name}}
                                                </span>
                                        {{/ifCond}}
                                    {{else}}
                                        <span class = 'comment_owner'>
                                            Invalid User
                                        </span>
                                    {{/if}}
                                     <div class = 'comment_time'>
                                        <div class='ct_ts'>
                                            {{update_timestamp}}
                                        </div>
                                    </div>
                                    <div class = 'comment_msg seemore_anchor' id = '{{reply_id}}'>
                                        {{{reply_msg}}}
                                    </div>

                                    {{#each files}}
                                        {{#ifCond file_extension '===' 'jpg'}}
                                        <div class = "post_attached_image_container">
                                            <div class = 'post_attached_image' title={{original_name}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"><div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div></div>
                                            
                                        </div>
                                        {{else}}
                                            {{#ifCond download_count '==' 0}}
                                                <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span></div></a>
                                            {{else}}
                                                <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'><em class = "file_type_color_bar"></em><span class = "file_name">{{original_name}}</span><span class = "file_type">{{file_extension}}</span><span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                            {{/ifCond}}
                                        {{/ifCond}}
                                    {{/each}}

                                    {{#ifCond user_info.user_id '==' '<?php echo $user_id; ?>'}}
                                      <div class='reply_delete_button'></div>
                                    {{/ifCond}}
                                </div>

                            </div>
                             {{/each}}
                             {{#if show_more}}
                                <div id='show_more' class='morecmt_bar'>
                                    Read All
                                </div>
                            {{/if}}

                    {{/if}}
                    </div>



                    <div class = 'postcomment'>
                        <div class = 'comment_owner_container profile_link' data-user_id={{user_id}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{user_info.pictureFile.file_url}}')">
                        </div>
                        <input class='post_anon_val' name='anon' type='hidden' value='0'>
                        <div class = 'reply_user_icon'></div>
                        <div class = 'commentform'>


                            <form action='/post/reply' class='reply_form' method="POST" enctype="multipart/form-data" data-post_id='{{post_id}}'>
                                <div>
                                    <div class = "pre_expand_comment_fx"><span class = "small_icon_map"></span></div>
                                    <textarea class = 'reply_text_textarea form-control postval' placeholder = 'Write a reply...' required></textarea>
                                    <div class = 'dragdrop_functions'>
                                        <div class='dragdropbox'>Drag and drop files here or Click to upload files</div>
                                        <div class='fileinputbox'><input type='file' class='fileinput' multiple></div>
                                        <div class='filelistbox'></div>
                                    </div>
                                </div>
                                <div class = 'reply_functions'>
                                    <div class='check_wrap'>
                                        <input type='checkbox' id='flat_0' class='flat7c'/>
                                        <label for='flat7' class='flat7b'>
                                            <span class='move'></span>
                                        </label>
                                        <span class = 'comment_anon_text'>Post Anonymously</span>
                                    </div>
                                    <a class = 'reply_button'>
                                        Post Reply
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class = 'reply_functions'>
                                <div class='check_wrap'>
                                    <input type='checkbox' id='flat_0' class='flat7c'/>
                                    <label for='flat7' class='flat7b'>
                                        <span class='move'></span>
                                    </label>
                                    <span class = 'comment_anon_text'>Post Anonymously</span>
                                </div>
                                <a class = 'reply_button'>
                                    Add Comment
                                </a>
                        </div>
                    </div>
            </script>
<script id="embedly_link_template" type="text/x-handlebars-template">
    <div class = "embedly_box">
        <a href="{{url}}" target="_blank">
            {{#if thumbnail_url}}
            <div class = "embedly_image post_attached_image" style = "background-image:url({{thumbnail_url}}); background-size:cover;"></div>
            <div class = "embedly_fake_border"></div>
            {{/if}}
            <div class = "embedly_info">
                <div class = "embedly_title">{{title}}</div>
                <div class = "embedly_description">{{description}}</div>
            </div>
        </a>
    </div>
</script>
<script id="embedly_video_template" type="text/x-handlebars-template">
    <div id = "embedly_video_box" class = "embedly_box">
        <a href="{{url}}" target="_blank">
            <div class="embedly_video" >
                {{{html}}}
            </div>

            <div class = "embedly_info">
                <div class = "embedly_title">{{title}}</div>
                <div class = "embedly_description">{{description}}</div>
            </div>
        </a>
    </div>
</script>
<script id="embedly_photo_template" type="text/x-handlebars-template">
    <div class = "embedly_box">
        <a href="{{url}}" target="_blank">
            {{#if thumbnail_url}}
            <div class = "embedly_image post_attached_image" style = "background-image:url({{thumbnail_url}}); background-size:cover;"></div>
            <div class = "embedly_fake_border"></div>
            {{/if}}
            {{#if title}}
            <div class = "embedly_info">
                <div class = "embedly_title">{{title}}</div>
            </div>
            {{/if}}
        </a>
    </div>
</script>
