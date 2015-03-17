<?php

$department_front_end_name = 'department';
if($user->school->university_id == 4){
    $department_front_end_name = 'program';
}
?>



<link href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
<script>
    origin_type = '<?php echo $origin_type; ?>';
    origin_id = '<?php echo $origin_id; ?>';


</script>
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/partial/left_panel/left_panel.js"></script>
<link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/leftpanel/leftpanel.css" rel="stylesheet" type="text/css">


<div id = "LeftPanel_Holder">
	<div class = "LeftPanel_Content">
		<div class = "LeftPanel_Section LeftPanel_Profile">
			<div class = "LeftPanel_SectionHeader">

			</div>
			<div class = "LeftPanel_SectionContent">
				<div class = "LeftPanel_MyBox">
					<div class = "clearfix MyBox">
						<a class = "MyBox_PictureLink";>
							<div class = "MyBox_Picture profile_link" data-user_id="<?php echo $user->user_id?>" style="background-image:url('<?php echo Yii::app()->getBaseUrl(true) . $user->pictureFile->file_url; ?>')"></div>
                            <button type="button" id="left_panel_change_picture_button"></button>
                            <div style="height: 0px;width:0px; overflow:hidden;">
                                <input id="left_panel_picture_upfile" type="file" value="upload"/>
                            </div>
                        </a>
						<div class = "MyBox_text">
							<div class = "MyBox_textcontent">
								<div class = "MyBox_NameSO">
									<a class = "MyBox_ProfileLink profile_link" data-user_id="<?php echo $user->user_id?>">
										<?php echo $user->firstname . " " . $user->lastname?>
									</a>
									<a class = "MyBox_SO edit_profile profile_link" data-user_id="<?php echo $user->user_id?>">Edit profile</a>
									<p class = "middot_leftpanel">&#xb7;</p>
									<a class = "MyBox_SO" href="<?php echo Yii::app()->getBaseUrl(true); ?>/logout">Sign out</a>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "LeftPanel_DeptSchoolHolder">
					<div class = "LeftPanel_DSContentBox">
						<div class = "LeftPanel_DSContentBoxHeader">
							<b><?php echo ucfirst($department_front_end_name); ?></b>
						</div>
						<a class = "LeftPanel_DSContentBoxName" href="<?php echo Yii::app()->getBaseUrl(true) . '/' . $department_front_end_name; ?>/<?php echo $user->department->department_id; ?>">
							<h5><?php echo $user->department->department_name; ?></h5>
						</a>						
					</div>
					<div class = "LeftPanel_DSContentBox">
						<div class = "LeftPanel_DSContentBoxHeader">
							<b>School</b>
						</div>
						<a class = "LeftPanel_DSContentBoxName" href="<?php echo Yii::app()->getBaseUrl(true); ?>/school/<?php echo $user->school->school_id; ?>">
							<h5><?php echo $user->school->school_name; ?></h5>
						</a>						
					</div>					
				</div>
			</div>
		</div>
		<div class = "LeftPanelSection LeftPanel_Classes">
			<div class = "LeftPanel_SectionHeader">
				<div class = "SectionHeader_holder">
					<div class = "float_Left">
						<em class = "SectionHeader_ribbon LeftPanel_icons">
						</em>
						<h4>Classes</h4>	
					</div>
					<div class = "float_Right">
						<a class = "textBtn" href="<?php echo Yii::app()->getBaseUrl(true) . '/search'; ?>"><span class = "search_text">Search</span></a>
						<div class = "right_flank">
						</div>
					</div>				
				</div>				
			</div>
			<div class = "LeftPanel_SectionContent">
				<ul data-group = "classes" id='class_list' class = "LeftPanel_GroupsList">
                    <?php foreach($user->classes as $class){?>
                        <li>
                            <a data-class_id = "<?php echo $class->class_id; ?>" href="<?php echo Yii::app()->getBaseUrl(true) . '/class/' . $class->class_id; ?>"><?php echo $class->class_name; ?></a>
                        </li>
                    <?php } ?>

                    <?php
                    if($user->user_type == 'p'){
                        foreach($user->teachingClasses as $class){?>
                        <li>
                            <a data-class_id = "<?php echo $class->class_id; ?>" href="<?php echo Yii::app()->getBaseUrl(true) . '/class/' . $class->class_id; ?>"><?php echo $class->class_name; ?></a>
                        </li>
                    <?php
                        }
                    }?>
				</ul>
			</div>						
		</div>
		<div class = "LeftPanelSection LeftPanel_Clubs">
			<div class = "LeftPanel_SectionHeader">
				<div class = "SectionHeader_holder">
					<div class = "float_Left">
						<em class = "SectionHeader_ribbon LeftPanel_icons">
						</em>
						<h4>Groups</h4>
					</div>
					<div class = "float_Right">
						<a class = "textBtn" href="<?php echo Yii::app()->getBaseUrl(true) . '/search'; ?>">Search</a>
						<div class = "right_flank">
						</div>
					</div>					
				</div>				
			</div>	
			<div class = "LeftPanel_SectionContent">
				<ul data-group = "clubs" class = "LeftPanel_GroupsList" id='club_list'>
                    <?php foreach($user->clubs as $club){ ?>
                        <li>
                            <a data-club_id = "<?php echo $club->group_id; ?>" href="<?php echo Yii::app()->getBaseUrl(true) . '/club/' . $club->group_id; ?>"><?php echo $club->group_name; ?></a>
                        </li>
                    <?php } ?>
				</ul>				
			</div>					
		</div>


<!--        --><?php //echo $this->renderPartial('/partial/messaging_panel',array('user'=>$user,'origin_type'=>'club','origin_id'=>$club->group_id,'origin_name'=>$club->group_name)); ?>






        <!--<div class = "LeftPanelSection LeftPanel_Clubs">
			<div class = "LeftPanel_SectionHeader">
				<div class = "SectionHeader_holder">
					<div class = "float_Left">
						<em class = "SectionHeader_ribbon LeftPanel_icons">
						</em>
						<h4>My Groups</h4>
					</div>
					<div class = "float_Right">
						<a class = "textBtn">Search</a>
					</div>
				</div>
			</div>
			<div class = "LeftPanel_SectionContent">
				<ul data-group = "clubs" class = "LeftPanel_GroupsList" id='club_list'>
                    <?php foreach($user->groups as $club){ ?>
                        <li>
                            <a data-club_id = "<?php echo $club->group_id; ?>" href="<?php echo Yii::app()->getBaseUrl(true) . '/club/' . $club->group_id; ?>"><?php echo $club->group_name; ?></a>
                        </li>
                    <?php } ?>
				</ul>
			</div>
		</div>-->


<!--        <div class = "LeftPanelSection LeftPanel_Clubs">-->
<!--			<div class = "LeftPanel_SectionHeader">-->
<!--				<div class = "SectionHeader_holder">-->
<!--					<div class = "float_Left">-->
<!--						<em class = "SectionHeader_ribbon LeftPanel_icons">-->
<!--						</em>-->
<!--						<h4>My Groups</h4>-->
<!--					</div>-->
<!--					<div class = "float_Right">-->
<!--						<a class = "textBtn">Search</a>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class = "LeftPanel_SectionContent">-->
<!--				<ul data-group = "clubs" class = "LeftPanel_GroupsList" id='club_list'>-->
<!--                    --><?php //foreach($user->groups as $club){ ?>
<!--                        <li>-->
<!--                            <a data-club_id = "--><?php //echo $club->group_id; ?><!--" href="--><?php //echo Yii::app()->getBaseUrl(true) . '/club/' . $club->group_id; ?><!--">--><?php //echo $club->group_name; ?><!--</a>-->
<!--                        </li>-->
<!--                    --><?php //} ?>
<!--				</ul>-->
<!--			</div>-->
<!--		</div>-->



	</div>
</div>
