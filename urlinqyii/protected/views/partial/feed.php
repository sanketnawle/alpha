<html>
<head>
    <title> Feed </title>
    <script>
        base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
        feed_url = '<?php echo $feed_url; ?>';
    </script>
    <script src="https://cdn.embed.ly/jquery.embedly-3.1.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/ness.js"> </script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/feed/feed.js"> </script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>
    

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/feed/feed.css"> </link>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link
        href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300'
        rel='stylesheet' type='text/css'>


</head>


<body>

<div class='feed-tab-content'>
<div class='group_feed_wrap'>
<div id="posts">

<script id="post_template" type="text/x-handlebars-template">
    <div id='{{last_activity}}'>
    <div class = 'posts new_fd' id = '{{post_id}}'>
    <div class="post_main">
        <div class="post_head">
            <div class="post_title">
                {{#if anon}}
                <a href ='profile/{{user_id}}'> Link
                    {{else}}
                    <a>
                        {{/if}}
                        <div class = 'image_container'>

                            {{#if anon}}
                            <div class = 'post_user_icon' style='background:url("http://www.urlinq.com/beta/DefaultImages/anon.png")'>
                            </div>
                            {{else}}
                            <div class = 'post_user_icon' style='background:url("http://www.urlinq.com/beta/includes/get_blob.php?img_id=1")'>
                            </div>
                            {{/if}}
                        </div>

                                                        <span class = 'post_owner'>
                                                            {{#if user_id}}
                                                                {{#if anon}}
                                                                    Anonymous
                                                                {{else}}
                                                                    {{user_name}}
                                                                {{/if}}
                                                            {{else}}
                                                                Invalid User
                                                            {{/if}}
                                                        </span>
                    </a>
                    {{#if target_id}}
                    {{#if target_type}}
                                                                <span class = 'post_format'> posted to <span class = 'post_group'>
                                                                    {{target_name}}
                                                                </span>
                                                            {{/if}}
                                                        {{/if}}
            </div>
            <div class = 'post_time'> Posted
                <time class='timeago' datetime= '{{created_time}}'>
                    {{created_time}}
                </time>
            </div>
            <div class = 'post_msg post_lr_link_msg'>
                                                        <span class='msg_span seemore_anchor'>
                                                                    {{text}}
                                                        </span>
                {{#if file_id}}
                
                <div class='post_attachment_review'><img {{theFileType file_share_type file_id}} </div>

                {{/if}}
                {{#if embed_link}}
                <div class="new_fd">
                    <p class='f_hidden_p'><a class="embed_link" href='{{embed_link}}'>{{embed_link}}
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
                    </div>
                </div>
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
                    <div class = 'post_like'>
                        <img class = 'post_like_icon' src='http://www.urlinq.com/beta/src/like-button.png'>
                        <div class = 'like_number'>
                            {{#if like_count}}
                            {{like_count}}
                            {{/if}}
                        </div>
                    </div>

                    <div class = 'post_comment_btn'>
                        Reply
                    </div>
                </div>
                <div class = 'post_functions'>
                    <div class = 'post_functions_showr'>
                    </div>
                    <div class = 'post_functions_box'>
                        {{#if pownership}}
                        <div class = 'post_functions_option option_edit'>Edit this Post</div>
                        <hr class = 'post_options_hr'>
                        <div class = 'post_functions_option option_delete'>Delete this Post</div>
                        {{else}}
                        <div class = 'post_functions_option option_hide'>
                            Hide this Post
                        </div>
                        <hr class = 'post_options_hr'>
                        <div class = 'post_functions_option option_report'>
                            Report this Post
                        </div>
                        {{/if}}
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
        </div>

    </div>

    {{#if replies}}
    <div class="master_comments" id="{{post_id}}">
        {{#each replies}}
        <div class = 'comments'>
            <div class = 'comment_main'>
                <div class = 'comment_owner_container' style='background:url("http://www.urlinq.com/beta/includes/get_blob.php?img_id=1"); background-size:cover'>
                    <div class = 'comment_user_icon'></div>
                </div>
                                            <span class = 'comment_owner'>
                                                {{#if anon}}
                                                    Anonymous
                                                {{else}}
                                                    {{user_name}}
                                                {{/if}}
                                            </span>
                <div class = 'comment_time'>
                    <div class='ct_ts'>
                        {{update_timestamp}}
                    </div>
                </div>
                <div class = 'comment_msg seemore_anchor' id = '{{replies.reply_id}}'>
                    {{reply_msg}}
                </div>

                {{#if file_id}}
                <div class='cmt_f_attach' title=''>
                    <img src='http://www.urlinq.com/beta/src/comment_attach.png'>
                    <a href=''>sdafsdaffg</a>
                </div>
                {{/if}}
            </div>

        </div>
        {{/each}}
        {{#if show_more}}
        <button id='show_more' class='morecmt_bar'>
            Show Full Discussion
        </button>
        {{/if}}
    </div>
    {{/if}}

    <div class = 'postcomment'>
        <div class = 'comment_owner_container' style='position: absolute; display: none; margin-left: -51px;'>
            <div class = 'comment_user_icon' style='background:url(http://www.urlinq.com/beta/DefaultImages/anon.png)'></div>
        </div>
        <input class='post_anon_val' name='anon' type='hidden' value='0'>
        <div class = 'reply_user_icon' style='background:url(http://www.urlinq.com/beta/DefaultImages/anon.png)'></div>
        <div class = 'commentform'>
            <div>
                <textarea class = 'form-control postval' placeholder = 'Add a reply or upload a file' required></textarea>
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
                    Add this reply
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
                Add this reply
            </a>
        </div>
    </div>
</script>



<script id="reply_template" type="text/x-handlebars-template">

    {{#each replies}}
    <div class = 'comments'>
        <div class = 'comment_main'>
            <div class = 'comment_owner_container' style='background:url("http://www.urlinq.com/beta/includes/get_blob.php?img_id=1"); background-size:cover'>
                <div class = 'comment_user_icon'></div>
            </div>
				                            <span class = 'comment_owner'>
				                                {{#if anon}}
				                                    Anonymous
				                                {{else}}
				                                    {{user_name}}
				                                {{/if}}
				                            </span>
            <div class = 'comment_time'>
                <div class='ct_ts'>
                    {{update_timestamp}}
                </div>
            </div>
            <div class = 'comment_msg seemore_anchor' id = '{{replies.reply_id}}'>
                {{reply_msg}}
            </div>

            {{#if file_id}}
            <div class='cmt_f_attach' title=''>
                <img src='http://www.urlinq.com/beta/src/comment_attach.png'>
                <a href=''>sdafsdaffg</a>
            </div>
            {{/if}}
        </div> 

    </div>

    {{/each}}
    <button id='show_less' class='lesscmt_bar'>
        Do not show Full Discussion
    </button>
</script>

<script id="reply_more_template" type="text/x-handlebars-template">

    {{#each replies}}
    <div class = 'comments'>
        <div class = 'comment_main'>
            <div class = 'comment_owner_container' style='background:url("http://www.urlinq.com/beta/includes/get_blob.php?img_id=1"); background-size:cover'>
                <div class = 'comment_user_icon'></div>
            </div>
				                            <span class = 'comment_owner'>
				                                {{#if anon}}
				                                    Anonymous
				                                {{else}}
				                                    {{user_name}}
				                                {{/if}}
				                            </span>
            <div class = 'comment_time'>
                <div class='ct_ts'>
                    {{update_timestamp}}
                </div>
            </div>
            <div class = 'comment_msg seemore_anchor' id = '{{replies.reply_id}}'>
                {{reply_msg}}
            </div>

            {{#if file_id}}
            <div class='cmt_f_attach' title=''>
                <img src='http://www.urlinq.com/beta/src/comment_attach.png'>
                <a href=''>sdafsdaffg</a>
            </div>
            {{/if}}
        </div>

    </div>

    {{/each}}
    <button id='show_more' class='morecmt_bar'>
        Show Full Discussion
    </button>

</script>

<script id="post_question_template" type="text/x-handlebars-template">
<div id='{{last_activity}}'>
<div class = 'posts new_fd' id = '{{post_id}}'>
<div class="post_main">
<div class="post_head">
<div class="post_title">
    {{#if anon}}
    <a href ='profile.php?user_id={{user_id}}'> Link
        {{else}}
        <a>
            {{/if}}
            <div class = 'image_container'>

                {{#if anon}}
                <div class = 'post_user_icon' style='background:url("http://www.urlinq.com/beta/DefaultImages/anon.png")'>
                </div>
                {{else}}
                <div class = 'post_user_icon' style='background:url("http://www.urlinq.com/beta/includes/get_blob.php?img_id=1")'>
                </div>
                {{/if}}
            </div>

													<span class = 'post_owner'>
														{{#if user_id}}
															{{#if anon}}
																{{#if pownership}}
																	Anonymous (ME)
																{{else}}
																	Anonymous
																{{/if}}
															{{else}}
														  		{{user_name}}
														  	{{/if}}
														{{else}}
															Invalid User 
														{{/if}}
													</span>
        </a>
        {{#if target_id}}
        {{#if target_type}}
															<span class = 'post_format'> posted to <span class = 'post_group'> 
																{{target_name}}
															</span>
														{{/if}}
													{{/if}}
</div>
<div class = 'post_time'> Question Asked
    <time class='timeago' datetime= '{{created_time}}'>
        {{update_timestamp}}
    </time>
</div>
{{#if que_list}}
{{#each que_list}}
<span class = 'experts_icon'></span>
<a href='http://www.urlinq.com/beta/profile.php?user_id={{user_id}}'>
													<span class = 'experts_name'>
														{{username}}
													</span></a>
{{/each}}
{{/if}}
<div class = 'post_msg post_lr_link_msg'>
    <div class='question_title_span'>
        {{text}}
    </div>

    {{#if multiple_choice}}

    <div class="mc_question">
        {{#each choices}}
        <div class="mc_question_one_choice" id="{{the_choice_letter}}">

            <input type="radio" class="mc_question_radio_button" name="letter" >

            </input>
            <div class="mc_question_choice_letter" >
																			<span class="choice_letter" id="{{the_choice_letter}}"> 
																				{{the_choice_letter}}
																			</span>
            </div>

            <div class="mc_question_choice_text">
                {{#if anon}}
                <span class="choice_text"> {{the_choice_text}} </span>
                {{else}}
                <span class="choice_text" style="background-color: #E0E0E0; width : {{percent_selected}}%" id="{{the_choice_letter}}expanding"> {{the_choice_text}} </span>

                {{/if}}
            </div>
            {{#if anon}}
            <div class='profile_thumbnail'
                 style="background:url('http://www.urlinq.com/beta/DefaultImages/anon.png'); width: 20px; height: 20px;">

            </div>

            {{else}}
            <div class='profile_thumbnail' style="background:url('http://www.urlinq.com/beta/DefaultImages/anon.png'">

            </div>
            <div class='profile_thumbnail_no_pic'>
                +{{people_who_answered_len}}
            </div>
            <div class="border_wedge"></div>
            <div class="list_of_people">

                <ul class="people" style="text-decoration:none">
                    {{#each people_who_answered}}
                    <li class="person"> {{name}} </li>
                    {{/each}}
                </ul>
            </div>


            {{/if}}
        </div>

        {{/each}}
    </div>


    {{/if}}
    {{#if file_id}}

    <div class='post_attachment_review'><img {{theFileType file_share_type file_id}} </div>

    {{/if}}
    {{#if embed_link}}

    <p class='f_hidden_p'><a href='{{embed_link}}'>{{embed_link}}
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
    </div>

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

        <div class = 'post_like'>
            <img class = 'post_like_icon' src='http://www.urlinq.com/beta/src/like-button.png'>
            <div class = 'like_number'>
                {{#if like_count}}
                {{like_count}}
                {{/if}}
            </div>
        </div>

        <div class = 'post_comment_btn'>
            Reply
        </div>

        <div class = 'show_analytics_btn'>

        </div>


    </div>
    <div class = 'post_functions'>
        <div class = 'post_functions_showr'>
        </div>
        <div class = 'post_functions_box'>
            {{#if pownership}}
            <div class = 'post_functions_option option_edit'>Edit this Post</div>
            <hr class = 'post_options_hr'>
            <div class = 'post_functions_option option_delete'>Delete this Post</div>
            {{else}}
            <div class = 'post_functions_option option_hide'>
                Hide this Post
            </div>
            <hr class = 'post_options_hr'>
            <div class = 'post_functions_option option_report'>
                Report this Post
            </div>
            {{/if}}
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
</div>

</div>

{{#if replies}}
<div class="master_comments" id="{{post_id}}">
    {{#each replies}}
    <div class = 'comments'>
        <div class = 'comment_main'>
            <div class = 'comment_owner_container' style='background:url("http://www.urlinq.com/beta/includes/get_blob.php?img_id=1"); background-size:cover'>
                <div class = 'comment_user_icon'></div>
            </div>
			                            <span class = 'comment_owner'>
			                                {{#if anon}}
			                                    Anonymous
			                                {{else}}
			                                    {{user_name}}
			                                {{/if}}
			                            </span>
            <div class = 'comment_time'>
                <div class='ct_ts'>
                    {{update_timestamp}}
                </div>
            </div>
            <div class = 'comment_msg seemore_anchor' id = '{{replies.reply_id}}'>
                {{reply_msg}}
            </div>

            {{#if file_id}}
            <div class='cmt_f_attach' title=''>
                <img src='http://www.urlinq.com/beta/src/comment_attach.png'>
                <a href=''>sdafsdaffg</a>
            </div>
            {{/if}}
        </div>

    </div>
    {{/each}}
    {{#if show_more}}
    <button id='show_more' class='morecmt_bar'>
        Show Full Discussion
    </button>
    {{/if}}
</div>
{{/if}}

<div class = 'postcomment'>
    <div class = 'comment_owner_container' style='position: absolute; display: none; margin-left: -51px;'>
        <div class = 'comment_user_icon' style='background:url(http://www.urlinq.com/beta/DefaultImages/anon.png)'></div>
    </div>
    <input class='post_anon_val' name='anon' type='hidden' value='0'>
    <div class = 'reply_user_icon' style='background:url(http://www.urlinq.com/beta/DefaultImages/anon.png)'></div>
    <div class = 'commentform'>
        <div>
            <textarea class = 'form-control postval' placeholder = 'Add a reply or upload a file' required></textarea>
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
                Add this reply
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
            Add this reply
        </a>
    </div>
</div>
</script>

<script id="post_note_template" type="text/x-handlebars-template">
<div id='{{last_activity}}'>
<div class = 'posts new_fd' id = '{{post_id}}'>
<div class="post_main">
    <div class="post_head">
        <div class="post_title">
            {{#if anon}}
            <a href ='profile.php?user_id={{user_id}}'> Link
                {{else}}
                <a>
                    {{/if}}
                    <div class = 'image_container'>

                        {{#if anon}}
                        <div class = 'post_user_icon' style='background:url("http://www.urlinq.com/beta/DefaultImages/anon.png")'>
                        </div>
                        {{else}}
                        <div class = 'post_user_icon' style='background:url("http://www.urlinq.com/beta/includes/get_blob.php?img_id=1")'>
                        </div>
                        {{/if}}
                    </div>

													<span class = 'post_owner'>
														{{#if user_id}}
															{{#if anon}}
																{{#if pownership}}
																	Anonymous (ME)
																{{else}}
																	Anonymous
																{{/if}}
															{{else}}
														  		{{user_name}}
														  	{{/if}}
														{{else}}
															Invalid User 
														{{/if}}
													</span>
                </a>
                {{#if target_id}}
                {{#if target_type}}
															<span class = 'post_format'> posted to <span class = 'post_group'> 
																{{target_name}}
															</span>
														{{/if}}
													{{/if}}
        </div>
        <div class = 'post_time'> File Added
            <time class='timeago' datetime= '{{created_time}}'>
                {{update_timestamp}}
            </time>
        </div>
        <div class = 'post_msg post_file_msg'>
							<span class='msg_span seemore_anchor'>
									<div class = 'file-wrapper'>
                                        <div class = 'file-container'>
                                            <div class = 'file-pic-wrap'>
                                                <div class = 'file-img file-img-type-doc'>
                                                    <div class='file-thumb-cover'>
                                                        <div class='file-download2'>
                                                            Download
                                                        </div>
                                                    </div>
                                                    <div>
                                                    </div>


                                                    <a class = 'file-download' href='javascript:download({{file_id}})'>

                                                    </a>


                                                    {{#if gdrive}}
                                                    <a class = 'file-download' target='_blank' href='javascript:download({{file_id}})'>
                                                        Go To Drive
                                                    </a>
                                                    {{/if}}


                                                </div>



                                                <div class = 'file-text-data'>
                                                    <div class = 'file-text-title'>
                                                        THE NOTE NAME
                                                    </div>

                                                    {{#if gdrive}}
                                                    <span class='google_drive_icon'></span>
                                                    {{/if}}
                                                    <div class = 'file-text-type'>
                                                        {{file_share_type}}
                                                    </div>
                                                    <div class = 'file-text-about'>
                                                        {{text_msg}}

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

        </div>
        </span>






        <div class = 'post_edit'>
            <textarea class = 'edit_area'></textarea>
            <div class = 'edit_toolbar'>
                <button class = 'edit_done'>Done</button>
                <button class = 'edit_cancel'>Cancel</button>
            </div>
        </div>
        <div class = 'post_tools'>
            <div class = 'post_lc'>
                <div class = 'post_like'>
                    <img class = 'post_like_icon' src='http://www.urlinq.com/beta/src/like-button.png'>
                    <div class = 'like_number'>
                        {{#if like_count}}
                        {{like_count}}
                        {{/if}}
                    </div>
                </div>

                <div class = 'post_comment_btn'>
                    Reply
                </div>
            </div>
            <div class = 'post_functions'>
                <div class = 'post_functions_showr'>
                </div>
                <div class = 'post_functions_box'>
                    {{#if pownership}}
                    <div class = 'post_functions_option option_edit'>Edit this Post</div>
                    <hr class = 'post_options_hr'>
                    <div class = 'post_functions_option option_delete'>Delete this Post</div>
                    {{else}}
                    <div class = 'post_functions_option option_hide'>
                        Hide this Post
                    </div>
                    <hr class = 'post_options_hr'>
                    <div class = 'post_functions_option option_report'>
                        Report this Post
                    </div>
                    {{/if}}
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
    </div>

</div>

{{#if replies}}
<div class="master_comments" id="{{post_id}}">
    {{#each replies}}
    <div class = 'comments'>
        <div class = 'comment_main'>
            <div class = 'comment_owner_container' style='background:url("http://www.urlinq.com/beta/includes/get_blob.php?img_id=1"); background-size:cover'>
                <div class = 'comment_user_icon'></div>
            </div>
			                            <span class = 'comment_owner'>
			                                {{#if anon}}
			                                    Anonymous
			                                {{else}}
			                                    {{user_name}}
			                                {{/if}}
			                            </span>
            <div class = 'comment_time'>
                <div class='ct_ts'>
                    {{update_timestamp}}
                </div>
            </div>
            <div class = 'comment_msg seemore_anchor' id = '{{replies.reply_id}}'>
                {{reply_msg}}
            </div>

            {{#if file_id}}
            <div class='cmt_f_attach' title=''>
                <img src='http://www.urlinq.com/beta/src/comment_attach.png'>
                <a href=''>sdafsdaffg</a>
            </div>
            {{/if}}
        </div>

    </div>
    {{/each}}
    {{#if show_more}}
    <button id='show_more' class='morecmt_bar'>
        Show Full Discussion
    </button>
    {{/if}}
</div>
{{/if}}

<div class = 'postcomment'>
    <div class = 'comment_owner_container' style='position: absolute; display: none; margin-left: -51px;'>
        <div class = 'comment_user_icon' style='background:url(http://www.urlinq.com/beta/DefaultImages/anon.png)'></div>
    </div>
    <input class='post_anon_val' name='anon' type='hidden' value='0'>
    <div class = 'reply_user_icon' style='background:url(http://www.urlinq.com/beta/DefaultImages/anon.png)'></div>
    <div class = 'commentform'>
        <div>
            <textarea class = 'form-control postval' placeholder = 'Add a reply or upload a file' required></textarea>
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
                Add this reply
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
            Add this reply
        </a>
    </div>
</div>
</script>




</div>

</div>
</div>
</body>
</html>