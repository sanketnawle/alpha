
<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/leftpanel/leftpanel.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/partial/leftpanel/leftpanel2.css" rel="stylesheet" type="text/css">
</head>
<body>

<div id = "LeftPanel_Holder">
	<div class = "LeftPanel_Content">
		<div class = "LeftPanel_Section LeftPanel_Profile">
			<div class = "LeftPanel_SectionHeader">
				<div class = "SectionHeader_holder">
					<div class = "float_Left">
						<em class = "SectionHeader_ribbon LeftPanel_icons">
						</em>
						<h4>PROFILE</h4>
					</div>
					<div class = "float_Right">
						<div class = "LeftPanel_menuicon LeftPanel_icons"></div>
					</div>

				</div>
			</div>
			<div class = "LeftPanel_SectionContent">
				<div class = "LeftPanel_MyBox">
					<div class = "clearfix MyBox">
						<a class = "MyBox_PictureLink">
							<img class = "MyBox_Picture" src="<?php echo Yii::app()->getBaseUrl(true); ?>/assets/LazDisplayPic.png">
						</a>
						<div class = "MyBox_text">
							<div class = "MyBox_textcontent">
								<div class = "MyBox_NameSO">
									<a class = "MyBox_ProfileLink">
										Jacob Lazarus
									</a>
									<a class = "MyBox_SO">
										Sign out
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class = "LeftPanel_DeptSchoolHolder">
					<div class = "LeftPanel_DSContentBox">
						<div class = "LeftPanel_DSContentBoxHeader">
							<b>Department</b>
						</div>
						<a class = "LeftPanel_DSContentBoxName">
							<h5>Neuroscience</h5>
						</a>						
					</div>
					<div class = "LeftPanel_DSContentBox">
						<div class = "LeftPanel_DSContentBoxHeader">
							<b>School</b>
						</div>
						<a class = "LeftPanel_DSContentBoxName">
							<h5>NYU School of Engineering</h5>
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
						<h4>CLASSES</h4>	
					</div>
					<div class = "float_Right">
						<a class = "textBtn">Join classes</a>
					</div>				
				</div>				
			</div>
			<div class = "LeftPanel_SectionContent">
				<ul class = "LeftPanel_GroupsList">
					<li>
						<a>Theories of the French Republic and Beorafa Part 2</a>
					</li>
					<li>
						<a>Systems and Motor Neuroscience</a>
					</li>
					<li>
						<a>Technical Entrepreneurship</a>
					</li>		
					<li>
						<a>Web Programming</a>
					</li>
					<li>
						<a>Principles of Economics</a>
					</li>			
				</ul>
			</div>						
		</div>
		<div class = "LeftPanelSection LeftPanel_Clubs">
			<div class = "LeftPanel_SectionHeader">
				<div class = "SectionHeader_holder">
					<div class = "float_Left">
						<em class = "SectionHeader_ribbon LeftPanel_icons">
						</em>
						<h4>CLUBS</h4>
					</div>
					<div class = "float_Right">
						<a class = "textBtn">Join clubs</a>
					</div>					
				</div>				
			</div>	
			<div class = "LeftPanel_SectionContent">
				<ul class = "LeftPanel_GroupsList">
					<li>
						<a>NYU Cheese Club</a>
					</li>
					<li>
						<a>Gallatin Business Club</a>
					</li>
					<li>
						<a>NYU Poly Hackathons</a>
					</li>		
					<li>
						<a>Tech@NYU</a>
					</li>		
				</ul>				
			</div>					
		</div>
	</div>
</div>

<script>
    (function($){
        $(function () {
            $(".leftpanel .scrollable .title").click(function () {
                var title = $(this);
                var clubs = $(".leftpanel .scrollable.club");
                var classes = $(".leftpanel .scrollable.class");
                (title.parents(".scrollable")[0] == classes[0] ? function () {
                    //classes.toggleClass("min");
                    // case 1: 50 50
                    if (!(classes.hasClass("full") || classes.hasClass("min"))) {
                        classes.addClass("min");
                        clubs.addClass("full");
                    } else if (classes.hasClass("min")) {
                        if (clubs.hasClass("min")) {
                            classes.removeClass("min").addClass("full");
                        } else {
                            classes.removeClass("min");
                            clubs.removeClass("full");
                        }
                    } else if (classes.hasClass("full")) {
                        classes.removeClass("full").addClass("min");
                    }
                } : function () {
                    if (!(clubs.hasClass("full") || clubs.hasClass("min"))) {
                        clubs.addClass("min");
                        classes.addClass("full");
                    } else if (clubs.hasClass("min")) {
                        if (classes.hasClass("min")) {
                            clubs.removeClass("min").addClass("full");
                        } else {
                            clubs.removeClass("min");
                            classes.removeClass("full");
                        }
                    } else if (clubs.hasClass("full")) {
                        clubs.removeClass("full").addClass("min");
                    }
                })();
            });

        })
    })(jQuery);
</script>
</body>
</html>