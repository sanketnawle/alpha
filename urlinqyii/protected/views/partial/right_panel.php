<html>
	<head>

		<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/rightpanel/rightpanel.css">
		<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/right_panel/right_panel.js"></script>

		<script>
		    base_url = '<?php echo Yii::app()->getBaseUrl(true); ?>';
		    origin = '<?php echo $origin_type; ?>';
		    origin_id = '<?php echo $origin_id; ?>';
		</script>
	</head>
	<body>
		<div id='right_panel'>
			<div id = "right_panel_content_holder">
				<div id = 'panel_header'>
					<div>
						
						<span>                        
				             Suggested
				         </span>
				         <span class = "activity_icon right_panel_assets">
				        </span>
				         
			         </div>
				</div>
				<div id = "groups_to_join" class = "right_panel_suggestions_section">
					<div class = "suggestions_header">
						<h5>Groups to Join</h5><span class = "middot">&#xb7;</span><a id="groups_refresh" class = "refresh">Refresh</a><!--<span class = "middot">&#xb7;</span><a class = "suggest_specific suggest_classes">Classes</a><span class = "middot">&#xb7;</span><a class = "suggest_specific suggest_clubs">Clubs</a>-->
					</div>

					<!--GROUP SUGGESTION -->
					<div class = "suggestion_unit_container">

					</div>

				</div> 

				<!--USER FOLLOW SUGGESTION -->

				<div id = "who_to_follow" class = "right_panel_suggestions_section">
					<div class = "suggestions_header">
						<h5>Who to Follow</h5><span class = "middot">&#xb7;</span><a id="users_refresh" class = "refresh">Refresh</a>
					</div>
					<div class = "suggestion_unit_container">

					</div>
				</div> 
				<div id = "right_panel_bottom_section">
					<h6>Suggestions From:</h6>
					<div class = "suggestion_type university" data-suggestion_type = "university_wide_suggestions">
						<span class = "suggestions_type_icon"></span><span class = "suggestions_type_text">Your University</span>
					</div>
					<div class = "suggestion_type school active" data-suggestion_type = "user_school_specific_suggestions">
						<span class = "suggestions_type_icon"></span><span class = "suggestions_type_text">Your School</span>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script id="suggestion_template" type="text/x-handlebars-template">
    <div class = "suggestion_block {{type}}" data-suggestion_id={{id}}>
        <a {{link}} class = "suggestion_pic_wrapper float_Left{{profile_link}}" {{profile_user_id}}>
            <div class = "suggestion_pic" style="background-image: url({{picture}});">
            </div>
        </a>
        <div class = "suggestion_block_right">
            <div class = "suggestion_title{{profile_link}}" title = "{{title}}" {{profile_user_id}}>
                <a {{link}}>
                    <div>
                        <span>{{title}}</span>
                    </div>
                </a>
            </div>
            <!--only show member count if there is a member count -->
            {{#if is_group}}
                <div class = "suggestion_btn_wrapper">
                    <a role = "button" class = "group_join_button">
                        <span src = "" class = "gray_add_icon"></span>Join
                    </a>
                </div>
                {{#if has_members}}
                    <div class = "member_count">
                        <!--<span class = "member_art"></span>-->
                        <span class = "count">{{member_count}} members</span>
                    </div>
                {{/if}}
            {{else}}
                <div class = "suggestion_btn_wrapper">
                    <a role = "button" class = "suggested_user_follow_button">
                        <span class = "follow_icon"></span>Follow
                    </a>
                </div>
            {{/if}}


        </div>
    </div>
</script>
