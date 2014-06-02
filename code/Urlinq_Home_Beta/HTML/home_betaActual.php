<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="../CSS/fbar.css">
    <link rel="stylesheet" type="text/css" href="../CSS/background.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link href='http://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../CSS/planner.css">
    <link rel="stylesheet" type="text/css" href="../CSS/datepicker.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>
    <script src='../JS/md5.js'></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>    
    <script src="../JS/fbar.js"></script>       
    <script src="../JS/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="../JS/jquery.timeAutocomplete.js"></script>
    <script src="../JS/ampm.js"></script>
    <script src="../JS/planner.js"></script> 
</head>
<body>
    <div class="root">
        <div class="top-bar">
            <div class="top-bar-wrapper">
                <img class="logo-h" src="../src/logo.png" />
            </div>
        </div>
        <div class="main">
            <div class="wrapper">
                <div class="mainContainer">
                    <div class="leftsec">
                    </div>
                    <div class="content-wrap">

                        <div class="midsec">
                            <div id="fbar" class="fb">
                                <div>
                                    <div class="post fani">
                                        <div class="fbtn fbtn-post">
                                            Post Status 
									
                                        </div>
                                    </div>
                                    <div class="share fani">
                                        <div class="fbtn fbtn-upload">
                                            Share Notes									
                                        </div>
                                    </div>
                                    <div class="find fani">
                                        <div class="fbtn fbtn-ask">
                                            Ask Question
									
                                        </div>
                                    </div>
                                </div>

                                <div class="post-sec">
                                    <div class="wedge1a">
                                    </div>

                                    <div class="wedge2a">
                                    </div>

                                    <div class="wedge3a">
                                    </div>

                                    <div class="post_state">
                                        <div class="textwrap">
                                            <textarea name="message" class="postTxtarea" placeholder="What have you read lately?"></textarea>
                                        </div>
                                        <div class="btmfbar">
                                            <div class="lfloat-mods">
                                                <div class="lfloat-attach">
                                                    <a class="attach-mod" href="#" title="Attach a file to your post">
                                                        <span class="attach-icon"></span>
                                                    </a>
                                                </div>
                                                <div class="lfloat-anon">
                                                    <input class="anon-checker" title="Post anonymously" type="checkbox">
                                                    <p class="anon-setting">Posted by Jacob Lazarus</p>
                                                </div>
                                            </div>
                                            <div class="search-select">
                                                <span title="Who can see this post?" class="field">
                                                    <label class="seltext" for="open">Only Students</label><i class="icon user"></i>
                                                </span>
                                                <input id="open" type="checkbox" />
                                                <ul class="select">
                                                    <li class="icon arrow selitem"></li>
                                                    <li class="selitem">Only Faculty<i class="icon list"></i>
                                                    </li>

                                                    <li class="selitem">Only Students<i class="icon user"></i></li>

                                                    <li class="selitem"><span class="spanCampus">Campus</span><i class="icon stat"></i></li>
                                                    <li class="selitem">Only Me<i class="icon accs"></i></li>

                                                </ul>
                                            </div>
                                            <div class="post-btn">
                                                Post
										
                                            </div>
                                        </div>
                                    </div>
                                    <div class="upload_state">
                                        <div class="textwrap">
                                            <textarea name="file_desc" class="uploadTxtarea" placeholder="Say something about this file..."></textarea>
                                        </div>
                                        <div class="uploadMode">
                                            <div class="localUpload">
                                                <div class="upl_wrap">
                                                    <div class="upl_head">
                                                        From Your Computer												
                                                    </div>
                                                    <div class="upl_btn">
                                                        <a class="upl_anc">
                                                            <span class="uplbtnText">Choose File</span>
                                                            <div class="_upl">
                                                                <input type="file" class="_uplI" title="Choose a file to upload" name="file1">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="uplName">
                                                        No file chosen
												
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="driveUpload">
                                                <div class="upl_wrap">
                                                    <span class="iconText">
                                                        <img class="icon" src="../src/drive_icon.png" width="16" height="16">
                                                        <div class="upl_head">
                                                            From Your Drive
													
                                                        </div>
                                                        <div class="upl_btn2">
                                                            <a class="upl_anc">
                                                                <span class="uplbtnText">Choose File</span>
                                                                <div class="_upl">
                                                                    <input type="file" class="_uplI" title="Choose a file to upload" name="file1">
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="uplName">
                                                            No file chosen													
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btmfbar2">
                                            <div class="search-select">
                                                <span title="Who can see this post?" class="field">
                                                    <label class="seltext" for="open">Only Students</label><i class="icon user"></i>
                                                </span>
                                                <input id="open" type="checkbox" />
                                                <ul class="select">
                                                    <li class="icon arrow selitem"></li>
                                                    <li class="selitem">Only Faculty<i class="icon list"></i>
                                                    </li>

                                                    <li class="selitem">Only Students<i class="icon user"></i></li>

                                                    <li class="selitem"><span class="spanCampus">Campus</span><i class="icon stat"></i></li>
                                                    <li class="selitem">Only Me<i class="icon accs"></i></li>

                                                </ul>
                                            </div>
                                            <div class="post-btn">
                                                Post 										
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ask_state">
                                        <div class="topfbar-wrap">
                                            <div class="quest-wrap">
                                                <div class="quest-dyn">
                                                    <div class="quest-icon"></div>
                                                </div>
                                                <input placeholder="What's your question? Be specific" class="topfbar questtxt"/>
                                            </div>
                                        </div>
                                        <div class="midfbar-wrap">
                                            <div class="midfbar-wrap2">
                                                <div class="who-wrap">
                                                    <div class="who-dyn">
                                                        <div class="who-icon"></div>
                                                    </div>
                                                    <div class="midfbar-exp">
                                                        <div class="who-default">
                                                            Campus													
                                                        </div>
                                                        <input placeholder="+ Ask experts" class="add_who"/>
                                                    </div>
                                                    <div class="who-explain">
                                                        <div class="who-explain-box">
                                                            <div class="who-wedge">
                                                            </div>
                                                            <b>Ask an Expert</b>
                                                            <p>Choose who will see your question by typing a subject area, or the name of someone at your school</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btmfbar3">
                                            <div class="lfloat-mods">
                                                <div class="lfloat-attach">
                                                    <a class="attach-mod" href="#" title="Attach a file to your post">
                                                        <span class="attach-icon"></span>
                                                    </a>
                                                </div>
                                                <div class="lfloat-anon">
                                                    <input class="anon-checker" title="Post anonymously" type="checkbox">
                                                    <p class="anon-setting">Posted by Anonymous</p>
                                                </div>
                                            </div>
                                            <div class="post-btn">
                                                Post 										
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rightsec">
    <div class="n_pf_5" id="divPlanner">              
	<? php include('Planner/planner.php'); ?>
    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
