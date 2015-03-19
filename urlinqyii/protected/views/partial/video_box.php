<!DOCTYPE html>

<html>

<head>
    <title></title>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/video_box.js"></script>
    <link rel = "stylesheet" type = "text/css" href = "<?php echo Yii::app()->request->baseUrl; ?>/css/site/video_box.css">
</head>
<body>

<div class = 'post video_box_post'>
<div class="post_main">
    <div class="video_header">
        Video lessons to help you learn<span class="info_icon"></span>
    </div>
    <div class="video_box_wrapper">
        <div class="video_boxes"></div>
    </div>
    <div class = 'post_tools'>

        <div class = 'post_lc ' >
            <div class = 'post_comment_btn'>
                <span class = "reply_icon icon icon-comment-discussion"></span>
          <!--      {{#ifCond reply_count '>=' 1}} -->
                <div class = 'reply_number'>

                <!--    {{reply_count}}-->

                </div>
              <!--  {{/ifCond}}-->
            </div>

            <div class = 'post_like post_like_btn'>
                <i class = "icon icon-plus"></i>
                <span>liked</span>

                <div class = 'like_number'>
                   3
                </div>

            </div>


        </div>
</div>
</div>

<div class="master_comments" id="{{post_id}}">
    <!--    {{#if replies}}

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

            <a href="<?php //echo Yii::app()->getBaseUrl(true);?>{{file.file_url}}" download='{{original_name}}'><div class='{{file.file_type}} post_attachment_review'>{{original_name}}<span class = "download_icon"></span></div></a>
            {{/if}}

            {{#ifCond user_info.user_id '==' '<?php// echo $user_id; ?>'}}                                         <div class='reply_delete_button'></div>                                     {{/ifCond}}

        </div>

    </div>
    {{/each}}
    {{#if show_more}}
    <div id='show_more' class='morecmt_bar'>
        Read more
    </div>
    {{/if}}

    {{/if}}-->
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
</div>

<script id="video_box_template" type="text/x-handlebars-template">
    <div class="video_box {{position}}">
        <div class="embedly_video_wrapper" >
            <div class="video_thumbnail" style="background-image: url('{{thumbnail_url}}')"></div>
            <div class="video" style = "display: none;">
                {{{html}}}
                <div class="skip_video">skip</div>
            </div>
        </div>
        <div class="video_left_column">
            <div class="video_info">
                <div class="video_title">
                    {{title}}
                </div>
                <div class="video_description">
                    {{description}}
                </div>
                <div class="video_categories">
                    <div class="video_topic">
                        {{topic}}
                    </div>
                    -
                    <div class="video_subtopic">
                        {{subtopic}}
                    </div>
                </div>
            </div>
            <div class="video_box_functions">
                <div class="watch_video">Watch</div>
                <div class="skip_video">skip</div>
            </div>
        </div>


    </div>
</script>


</body>
</html>
