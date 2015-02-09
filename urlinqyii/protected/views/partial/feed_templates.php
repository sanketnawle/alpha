<script id="post_template" type="text/x-handlebars-template">
                        <div id='{{last_activity}}'>
                            <div class = 'post new_fd' id = '{{post_id}}' data-post_id='{{post_id}}' data-post_type='{{post_type}}' data-origin_type='{{origin_type}}' data-origin_id="{{origin_id}}"  data-created_at='{{created_at}}' data-last_activity='{{last_activity}}'>
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
                                                                    <span class="post_owner post_own_post anonymous_post_owner">
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
                                                     <time class='timeago' datetime= '{{created_time}}'>
                                                        {{update_timestamp}}
                                                     </time>
                                                </div>
                                                <div class = 'post_msg post_lr_link_msg'>
                                                    <span class='msg_span seemore_anchor'>
                                                                {{{text}}}
                                                    </span>


                                                        
                                                {{#each files}}
                                                    {{#ifCond file_extension '===' 'jpg'}}
                                                    <div class = "post_attached_image_container">
                                                        <div class = 'post_attached_image' title={{original_name}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"></div>
                                                        <div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div>
                                                    </div>
                                                    {{else}}
                                                        {{#ifCond download_count '==' 0}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                                        {{else}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
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

                                                        {{#ifCond like_status '==' true}}
                                                            <div class = 'post_liked'>
                                                                <span class = 'post_like_icon'></span>
                                                                <p class = 'post_like_link'></p>
                                                        {{else}}
                                                            <div class = 'post_like'>
                                                                <span class = 'post_like_icon'></span>
                                                                <p class = 'post_like_link'>Like</p>
                                                        {{/ifCond}}

                                                                {{#ifCond like_count '>=' 1}}
                                                                <div class = 'like_number'>

                                                                    {{like_count}}

                                                                </div>
                                                                {{/ifCond}}

                                                            </div>

                                                        <div class = 'post_comment_btn'>
                                                            <span class = "reply_icon"></span>
                                                            {{#ifCond reply_count '>=' 1}}
                                                            <div class = 'reply_number'>

                                                                {{reply_count}}

                                                            </div>
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
                                <div class = 'comment_main'>


                                    {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
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

                                        <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='{{file.file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                    {{/if}}                              

                                </div>

                            </div>
                             {{/each}}
                             {{#if show_more}}
                                <div id='show_more' class='morecmt_bar'>
                                    Show All
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
                                    <a class='reply_button fresh_green_button'>
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
                                    <a class = 'reply_button fresh_green_button'>
                                        Post Reply
                                    </a>
                            </form>
                        </div>
                    </div>
              </script>



            <script id="reply_template" type="text/x-handlebars-template">

                    {{#each replies}}
                                <div class = 'comments'>
                                    <div class = 'comment_main'>


                                        {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
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

                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='{{file.file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                        {{/if}}

                                    </div>

                                </div>

                     {{/each}}
                                <div id='show_less' class='lesscmt_bar'>
                                            Hide Discussion
                                </div>
            </script>


            <script id='one_reply_template' type="text/x-handlebars-template">
                <div class = 'comments'>
                    <div class = 'comment_main'>

                        {{#ifCond anon '==' 1}}
                        <div class = 'comment_owner_container' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
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

                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='{{file.file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                        {{/if}}
                    </div>

                </div>
            </script>

            <script id="reply_more_template" type="text/x-handlebars-template">

                    {{#each replies}}
                                <div class = 'comments'>
                                    <div class = 'comment_main'>

                                        {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
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

                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='{{file.file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                        {{/if}}
                                    </div>

                                </div>

                     {{/each}}
                                <div id='show_more' class='morecmt_bar'>
                                            Show All
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
                                                            <span class="post_owner post_own_post anonymous_post_owner">
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
                                                     <time class='timeago' datetime= '{{created_time}}'>
                                                        {{update_timestamp}}
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

                                                    {{#ifCond post_type '==' 'true_false'}}
                                                         <div class="mc_question">
                                                            {{#each question.options}}
                                                                <div class="mc_question_one_choice" id="{{question.answer_index}}" data-option_id="{{option_id}}">

                                                                    <input type="radio" class="mc_question_radio_button" name="letter" >

                                                                    </input>
                                                                    <div class="mc_question_choice_letter" >
                                                                            <span class="choice_letter" id="{{question.answer_index}}">
                                                                                {{question.answer_index}}
                                                                            </span>
                                                                    </div>

                                                                    <div class="mc_question_choice_text">
                                                                        {{#ifCond anon '==' 1}}
                                                                            <span class="choice_text"> {{option_text}} </span>
                                                                        {{else}}
                                                                            <span class="choice_text" style="background-color: #E0E0E0; width : {{percent_selected}}%" id="{{the_choice_letter}}expanding"> {{option_text}} </span>

                                                                        {{/ifCond}}
                                                                    </div>

                                                                </div>

                                                            {{/each}}
                                                        </div>

                                                    {{/ifCond}}


                                                    {{#ifCond post_type '==' 'multiple_choice'}}
                                                        <div class="mc_question">
                                                            {{#each question.options}}
                                                                <div class="mc_question_one_choice" id="{{question.answer_index}}" data-option_id="{{option_id}}">

                                                                    <input type="radio" class="mc_question_radio_button" name="letter" >

                                                                    </input>
                                                                    <div class="mc_question_choice_letter" >
                                                                            <span class="choice_letter" id="{{question.answer_index}}">
                                                                                {{question.answer_index}}
                                                                            </span>
                                                                    </div>

                                                                    <div class="mc_question_choice_text">
                                                                        {{#ifCond anon '==' 1}}
                                                                            <span class="choice_text"> {{option_text}} </span>
                                                                        {{else}}
                                                                            <span class="choice_text" style="background-color: #E0E0E0; width : {{percent_selected}}%" id="{{the_choice_letter}}expanding"> {{option_text}} </span>

                                                                        {{/ifCond}}
                                                                    </div>

                                                                </div>

                                                            {{/each}}
                                                        </div>


                                                    {{/ifCond}}



                                                    {{#if file_id}}

                                                        <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='{{file.file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
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

                                                        {{#ifCond like_status '==' true}}
                                                            <div class = 'post_liked'>
                                                                <span class = 'post_like_icon'></span>
                                                                <p class = 'post_like_link'></p>
                                                        {{else}}
                                                            <div class = 'post_like'>
                                                                <span class = 'post_like_icon'></span>
                                                                <p class = 'post_like_link'>Like</p>
                                                        {{/ifCond}}

                                                                {{#ifCond like_count '>=' 1}}
                                                                <div class = 'like_number'>

                                                                    {{like_count}}

                                                                </div>
                                                                {{/ifCond}}


                                                            </div>

                                                        <div class = 'post_comment_btn'>
                                                            <span class = "reply_icon"></span>
                                                            {{#ifCond reply_count '>=' 1}}
                                                            <div class = 'reply_number'>

                                                                {{reply_count}}

                                                            </div>
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
                                <div class = 'comment_main'>


                                    {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
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

                                        <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='{{file.file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                    {{/if}}
                                </div>

                            </div>
                             {{/each}}
                             {{#if show_more}}
                                <div id='show_more' class='morecmt_bar'>
                                    Show All
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
                                    <textarea class = 'reply_text_textarea form-control postval ' name='reply_text' placeholder = 'Respond to this question...' required></textarea>
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
                                    <a class='reply_button fresh_green_button'>
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
                            <a class = 'reply_button fresh_green_button'>
                                Add Comment
                            </a>
                        </form>
                    </div>
            </script>



            <script id="post_event_template" type="text/x-handlebars-template">
                <div class = 'post new_fd' id = '{{post_id}}' data-post_id='{{post_id}}' data-event_id='{{event.event_id}}' data-post_type='{{post_type}}' data-origin_type='{{origin_type}}' data-origin_id="{{origin_id}}" data-created_at='{{created_at}}' data-last_activity='{{last_activity}}'>
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
                                <div class='post_event_title'>{{event.title}}</div>
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
                                                <div class = "post_event_type">{{event.event_type}} in </div>
                                            {{/if}}
                                        </div>
                                        <div class = "post_event_origin_holder">
                                            <div class = "post_event_origin"><a href='<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}'>{{origin.name}}</a></div>
                                        </div>
                                    </div>
                                {{else}}
                                    {{#ifCond '<?php echo $user_id;?>' '!=' event.origin_id}}
                                        <div class = "event_context">
                                            <span class = "down_right_arrow_icon"></span>
                                            <div class='post_event_type_holder'>
                                                {{#if event.event_type}}
                                                    <div class = "post_event_type">{{event.event_type}} in </div>
                                                {{/if}}
                                            </div>
                                            <div class = "post_event_origin_holder">
                                                <div class = "post_event_origin"><a href='<?php echo Yii::app()->getBaseUrl(true);?>/{{origin_type}}/{{origin_id}}'>{{origin.name}}</a></div>
                                            </div>
                                        </div>
                                    {{/ifCond}}

                                {{/ifCond}}
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
                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                        {{else}}
                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                        {{/ifCond}}
                                    {{/ifCond}}
                                {{/each}}


                                {{#ifCond user_attending '==' false}}
                                    <div class='post_event_calendar_button'><span class = "add_to_cal_icon"></span>Add to Calendar</div>
                                {{else}}
                                    <div class='post_event_calendar_button added'><span class = "add_to_cal_icon added"></span>Attending</div>
                                {{/ifCond}}



                                <div class='post_event_time_holder'>
                                    <div class='post_event_start_time'>{{event.start_time_string}}</div> to <div class='post_event_end_time'>{{event.end_time_string}}</div>
                                </div>


                                
                            </div>



                        </div>
                    </div>
                </div>
            </script>

            <script id="post_opportunity_template" type="text/x-handlebars-template">
                <div class = 'post new_fd' id = '{{post_id}}' data-post_id='{{post_id}}' data-event_id='{{event.event_id}}' data-post_type='{{post_type}}' data-origin_type='{{origin_type}}' data-origin_id="{{origin_id}}" data-created_at='{{created_at}}' data-last_activity='{{last_activity}}'>
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
                                                            <span class="post_owner post_own_post anonymous_post_owner">
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
                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                        {{else}}
                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                        {{/ifCond}}
                                    {{/ifCond}}
                                {{/each}}


                                {{#ifCond user_attending '==' false}}
                                    <div class='post_event_calendar_button save_opportunity_btn'><span class = "add_to_cal_icon"></span>Save Opportunity</div>
                                {{else}}
                                    <div class='post_event_calendar_button added save_opportunity_btn'><span class = "add_to_cal_icon added"></span>Saved</div>
                                {{/ifCond}}

                                <div class = "apply_by_div">
                                    <span class = "apply_by_text">Deadline:</span> 
                                    <span class='apply_by_text apply_by_text_month'>{{event.month}}</span>
                                    <span class='apply_by_text apply_by_text_day'>{{event.day_number}}</span>
                                    {{#if event.end_time_string}}
                                    <span class='apply_by_text apply_by_text_time'>at {{event.end_time_string}}</span>
                                    {{/if}}
                                </div>

                                
                            </div>
                        </div>
                    </div>

                    <div class="master_comments" id="{{post_id}}">
                    {{#if replies}}

                            {{#each replies}}
                            <div class = 'comments'>
                                <div class = 'comment_main'>




                                    {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
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
                                            <div class = 'post_attached_image' title={{original_name}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"></div>
                                            <div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div>
                                        </div>
                                        {{else}}
                                            {{#ifCond download_count '==' 0}}
                                                <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                            {{else}}
                                                <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                            {{/ifCond}}
                                        {{/ifCond}}
                                    {{/each}}
                                </div>

                            </div>
                             {{/each}}
                             {{#if show_more}}
                                <div id='show_more' class='morecmt_bar'>
                                    Show All
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
                                    <a class = 'reply_button fresh_green_button'>
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
                                <a class = 'reply_button fresh_green_button'>
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
                                                                    <span class="post_owner post_own_post anonymous_post_owner">
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
                                                     <time class='timeago' datetime= '{{created_time}}'>
                                                        {{update_timestamp}}
                                                     </time>
                                                </div>

                                                <div class = 'post_msg post_file_msg'>
                                                    <span class='msg_span seemore_anchor'>{{{text}}}</span>




                                                {{#each files}}
                                                    {{#ifCond file_extension '===' 'jpg'}}
                                                    <div class = "post_attached_image_container">
                                                        <div class = 'post_attached_image' title={{original_name}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"></div>
                                                        <div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div>
                                                    </div>
                                                    {{else}}
                                                        {{#ifCond download_count '==' 0}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                                        {{else}}
                                                            <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
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
                                                        {{#ifCond like_status '==' true}}
                                                            <div class = 'post_liked'>
                                                                <span class = 'post_like_icon'></span>
                                                                <p class = 'post_like_link'></p>
                                                        {{else}}
                                                            <div class = 'post_like'>
                                                                <span class = 'post_like_icon'></span>
                                                                <p class = 'post_like_link'>Like</p>
                                                        {{/ifCond}}

                                                                {{#ifCond like_count '>=' 1}}
                                                                <div class = 'like_number'>

                                                                    {{like_count}}

                                                                </div>
                                                                {{/ifCond}}


                                                            </div>

                                                        <div class = 'post_comment_btn'>
                                                            <span class = "reply_icon"></span>
                                                            {{#ifCond reply_count '>=' 1}}
                                                            <div class = 'reply_number'>

                                                                {{reply_count}}

                                                            </div>
                                                            {{/ifCond}}
                                                        </div>
                                                    </div>
                                                            <div class = 'post_functions'>
                                                <div class = 'post_functions_showr'>
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
                                <div class = 'comment_main'>




                                    {{#ifCond anon '==' 1}}
                                        <div class = 'comment_owner_container' style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true)."/assets/avatars/".(rand(1,10)).".png"; ?>')">
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
                                            <div class = 'post_attached_image' title={{original_name}} style = "background-image:url('<?php echo Yii::app()->getBaseUrl(true); ?>{{file_url}}')"></div>
                                            <div class = "post_attached_image_caption"><p>{{original_name}}</p><span class = "link_image_add_icon"></span></div>
                                        </div>
                                        {{else}}
                                            {{#ifCond download_count '==' 0}}
                                                <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
                                            {{else}}
                                                <a href="<?php echo Yii::app()->getBaseUrl(true);?>{{file_url}}" download='{{original_name}}'><div class='png {{file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span><span class = "download_count_circle">download_count</span></div></a>
                                            {{/ifCond}}
                                        {{/ifCond}}
                                    {{/each}}
                                </div>

                            </div>
                             {{/each}}
                             {{#if show_more}}
                                <div id='show_more' class='morecmt_bar'>
                                    Show All
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
                                    <a class = 'reply_button fresh_green_button'>
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
                                <a class = 'reply_button fresh_green_button'>
                                    Add Comment
                                </a>
                        </div>
                    </div>
            </script>
<script id="embedly_link_template" type="text/x-handlebars-template">
    <div class = "embedly_box">
        <a href="{{url}}" target="_blank">
            {{#if thumbnail_url}}
            <img class = "embedly_image post_attached_image" src = "{{thumbnail_url}}">
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
            <img class = "embedly_image post_attached_image" src = "{{url}}">
            {{/if}}
            {{#if title}}
            <div class = "embedly_info">
                <div class = "embedly_title">{{title}}</div>
            </div>
            {{/if}}
        </a>
    </div>
</script>
