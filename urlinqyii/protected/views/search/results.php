<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link rel = 'stylesheet' type = 'text/css' href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/backgroundSearch.css'/>
    <link rel = 'stylesheet' type = 'text/css' href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/feed.css'/>
    <link rel = 'stylesheet' type = 'text/css' href = '<?php echo Yii::app()->getBaseUrl(true); ?>/css/search.css'/>
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/search.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <script>
        // Just call this to initialise the plugin
        $(function()
        {
            // Usage:
            var mySlider = new range_slider(
                {
                    selector : '.scrubber_slider',
                    unit    : ' credits',
                    min     : 0,
                    max : 4,
                    left_scrubber_pos : 2,
                    right_scrubber_pos : 7,
                    round_by : 1,
                    rounded : true,
                    // Event during initialization
                    release : function(e)
                    {
                        // custom function for this event
                        console.log("Event happened, this object contains: \n\n { \n min : "+ e.min + ",\nmax : " + e.max + "\n");
                    }
                });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        //For more general functions, refer to /alpha/beta/search_beta.php
        $(function()
        {
            $(document).delegate(".subjects-results-dept","click", function(){
                $("#subject_query").val($(this).find(".subject-match").text());
            });
            $("#search_query").val(search_string);
            callFilter(search_type,search_string,univ_id,filter,page);
            $(document).delegate("#search","click",function(){
                page = 1;
                search_type= $(".activeType").data("value");
                search_string = $("#search_query").val();
                if(search_string != $("#search_query").data("oldValue"))
                {
                    show_cat = true;
                    search_type = "All";
                }
                callFilter(search_type,search_string,univ_id,filter,page);
            });
            $(document).delegate(".search_category","click",function(){
                page = 1;
                show_cat = false;
                search_type= $(".activeType").data("value");
                search_string = $("#search_query").val();
                callFilter(search_type,search_string,univ_id,filter,page);
            });
            function callFilter(type, string, univ,filter, page)
            {
                //Required for Search Functionality. Only shows Categories that are populated.
                $("#search_query").data("oldValue", string);
                $.ajax({
                    type: "POST",
                    url: "php/search_filter.php",
                    data:{search_type:type, search_string:string, univid:univ, filter:filter, page:page, nocalc:show_cat},
                    success: function(responseText){
                        if(responseText.trim() == "false")
                            return;
                        if(show_cat)
                        {
                            var all_rows = getNumbers("<all_rows>",responseText);
                            var professor_rows = getNumbers("<professor_rows>",responseText);
                            var course_rows = getNumbers("<course_rows>",responseText);
                            var group_rows = getNumbers("<group_rows>",responseText);
                            var student_rows = getNumbers("<student_rows>",responseText);
                            var post_rows = getNumbers("<post_rows>",responseText);
                            var credits = getNumbers("<credits>",responseText);
                            responseText = responseText.slice(0,responseText.search("<all_rows>"));
                            $("#category1").text(all_rows);
                            $("#category2").text(course_rows);
                            $("#category3").text(professor_rows);
                            $("#category4").text(student_rows);
                            $("#category5").text(group_rows);
                            $("#category6").text(post_rows);
                            if(course_rows > 0){
                                $("#category2").parent().parent().show();
                            }
                            else
                            {
                                $("#category2").parent().parent().hide();
                            }
                            if(professor_rows > 0){
                                $("#category3").parent().parent().show();
                            }
                            else{
                                $("#category3").parent().parent().hide();
                            }
                            if(student_rows > 0){
                                $("#category4").parent().parent().show();
                            }
                            else{
                                $("#category4").parent().parent().hide();
                            }
                            if(group_rows > 0){
                                $("#category5").parent().parent().show();
                            }
                            else{
                                $("#category5").parent().parent().hide();
                            }
                            if(post_rows > 0){
                                $("#category6").parent().parent().show();
                            }
                            else{
                                $("#category6").parent().parent().hide();
                            }
                            // should change the credits only if the search consists of some new query.
//							mySlider.updateMax(credits);
                        }
                        $("#result").html(responseText);
                        $.event.trigger("content_loaded");
// 						alert(page);
                    }
                });
            }
        });
        function callBookmarks(class_id)
        {
            if(class_id == null)
            {
                $.ajax({
                    type: "POST",
                    url: "bookmark.php",
                    success: function(responseText){
                        $("#bookmarks").html(responseText);
                    }
                });
            }
            else
            {
                $.ajax({
                    type: "POST",
                    url: "bookmark.php",
                    data: {'class':class_id},
                    success: function(responseText){
                        $("#bookmarks").html(responseText);
                    }
                });
            }
        }
        function getNumbers(tag, data)
        {
            var start_tag = tag;
            var end_tag = tag.replace("<","</");
            var start = data.search(start_tag) + start_tag.length;
            var end = data.search(end_tag);
            if(start == -1 || end == -1)
                return "";
            var all_rows = data.slice(start,end);
            return all_rows;
        }
    </script>
</head>
<body>


<!--
Feel free to stick this in the appropriate CSS file
Comment out the .sub_filter style to edit its UI
-->
<style>
    ul{list-style-type:none;}
    .search_category + .sub_filter { display: none; }
    .search_category.active + .sub_filter { display: block; }
</style>


<!--
Filter in LeftSide Starts here
JQuery adjusted in search.js to accomodate for new functionality.
 -->
<div class = "root">
    <div class = "search-top-bar-wrap">
        <?php echo Yii::app()->runController('partial/topbar'); ?>
    </div>
    <div class = "main">
        <div class = "leftsec">
            <div class = "visible-lg">
                <div class = "searchType">
                    <?php echo $query ?>
                    <!-- All searchTypes have sub_filters, which are Advanced Searches   -->
                    <span class = "wedgeRight"></span>
                    <div>
                        <div class = "search_category active">
                            <a class = "type" data-value="All"><span id="category1" class = "resultNum pull-right"></span>All Results</a>
                        </div>
                    </div>

                    <!--  Courses can be filtered by School, department, and professor -->
                    <div>
                        <div class = "search_category">
                            <a class = "type" data-value="Courses"><span id="category2" class = "resultNum pull-right"></span>Courses</a>
                        </div>
                        <div class = "sub_filter">
                            <ul class = "SearchFilterList">
                                <li>
                                    <span class = "FilterLabel DropdownLabel">School:</span>
                                    <div class = "dropOpenBtn">
                                        NYU School of Engineering
                                        <i class = "dwnArrow"></i>
                                    </div>
                                    <div class = "dropOpenList" id = "dropOpenList">
                                        <ul>
                                            <li class = "dropListItem"><span>NYU School of Engineering</span></li>
                                            <li class = "dropListItem"><span>NYU College of Arts and Sciences</span></li>
                                            <li class = "dropListItem"><span>Stern School of Business</span></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <span class = "FilterLabel DropdownLabel">Department:</span>
                                    <div class = "dropOpenBtn">Computer Science <i class = "dwnArrow"></i></div>
                                    <div class = "dropOpenList" id = "dropOpenList">
                                        <ul>
                                            <li class = "dropListItem"><span>NYU School of Engineering</span></li>
                                            <li class = "dropListItem"><span>NYU College of Arts and Sciences</span></li>
                                            <li class = "dropListItem"><span>Stern School of Business</span></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <span class = "FilterLabel">Professor:</span> <input class = "filterTextinput" type="text" name="prof">
                                </li>
                                <li class = "scrubberLi">
                                    <span class = "FilterLabel">Credits:</span>
                                    <div class="scrubber_slider">

                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <!--  Professors can be filtered by School and Department -->
                    <div>
                        <div class = "search_category">
                            <a class = "type" data-value="Professor"><span id="category3" class = "resultNum pull-right"></span>Professors</a>
                        </div>
                        <div class = "sub_filter">
                            <ul class = "SearchFilterList">
                                <li>
                                    <span class = "FilterLabel DropdownLabel">School:</span>
                                    <div class = "dropOpenBtn">NYU School of Engineering <i class = "dwnArrow"></i></div>
                                    <div class = "dropOpenList" id = "dropOpenList">
                                        <ul>
                                            <li class = "dropListItem"><span>NYU School of Engineering</span></li>
                                            <li class = "dropListItem"><span>NYU College of Arts and Sciences</span></li>
                                            <li class = "dropListItem"><span>Stern School of Business</span></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <span class = "FilterLabel DropdownLabel">Department:</span>
                                    <div class = "dropOpenBtn">Computer Science <i class = "dwnArrow"></i></div>
                                    <div class = "dropOpenList" id = "dropOpenList">
                                        <ul>
                                            <li class = "dropListItem"><span>NYU School of Engineering</span></li>
                                            <li class = "dropListItem"><span>NYU College of Arts and Sciences</span></li>
                                            <li class = "dropListItem"><span>Stern School of Business</span></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!--  Students can be filtered by School and Major -->
                    <div>
                        <div class = "search_category">
                            <a class = "type" data-value="Student"><span id="category4" class = "resultNum pull-right"></span>Students</a>
                        </div>
                        <div class = "sub_filter">
                            <ul class = "SearchFilterList">
                                <li>
                                    <span class = "FilterLabel DropdownLabel">School:</span>
                                    <div class = "dropOpenBtn">NYU School of Engineering <i class = "dwnArrow"></i></div>
                                    <div class = "dropOpenList" id = "dropOpenList">
                                        <ul>
                                            <li class = "dropListItem"><span>NYU School of Engineering</span></li>
                                            <li class = "dropListItem"><span>NYU College of Arts and Sciences</span></li>
                                            <li class = "dropListItem"><span>Stern School of Business</span></li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <span class = "FilterLabel DropdownLabel">Major:</span>
                                    <div class = "dropOpenBtn">Computer Science <i class = "dwnArrow"></i></div>
                                    <div class = "dropOpenList" id = "dropOpenList">
                                        <ul>
                                            <li class = "dropListItem"><span>NYU School of Engineering</span></li>
                                            <li class = "dropListItem"><span>NYU College of Arts and Sciences</span></li>
                                            <li class = "dropListItem"><span>Stern School of Business</span></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!--  Clubs can be filtered by School -->
                    <div>
                        <div class = "search_category">
                            <a class = "type" data-value="Clubs"><span id="category5" class = "resultNum pull-right"></span>Clubs</a>
                        </div>
                        <div class = "sub_filter">
                            <ul class = "SearchFilterList">
                                <li>
                                    <span class = "FilterLabel DropdownLabel">School:</span>
                                    <div class = "dropOpenBtn">NYU School of Engineering <i class = "dwnArrow"></i></div>
                                    <div class = "dropOpenList" id = "dropOpenList">
                                        <ul>
                                            <li class = "dropListItem"><span>NYU School of Engineering</span></li>
                                            <li class = "dropListItem"><span>NYU College of Arts and Sciences</span></li>
                                            <li class = "dropListItem"><span>Stern School of Business</span></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!--  Departments can be filtered by School -->
                    <div>
                        <div class = "search_category">
                            <a class = "type" data-value="Departments"><span id="category6" class = "resultNum pull-right"></span>Departments</a>
                        </div>
                        <div class = "sub_filter">
                            <ul class = "SearchFilterList">
                                <li>
                                    <span class = "FilterLabel DropdownLabel">School:</span>
                                    <div class = "dropOpenBtn">NYU School of Engineering <i class = "dwnArrow"></i></div>
                                    <div class = "dropOpenList" id = "dropOpenList">
                                        <ul>
                                            <li class = "dropListItem"><span>NYU School of Engineering</span></li>
                                            <li class = "dropListItem"><span>NYU College of Arts and Sciences</span></li>
                                            <li class = "dropListItem"><span>Stern School of Business</span></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr class = "hr-divider">



                <button class = "search-btn" name = "commit" id ="search" >Search</button>
            </div>
        </div>
        <div id = "result" class = "midsec loadani_parent">

        </div>
    </div>
</div>
</body>
</html>
























