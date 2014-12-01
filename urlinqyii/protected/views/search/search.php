<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/backgroundSearch.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/feed.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/search.css' />
    <link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

    <script>
        base_url = "<?php echo Yii::app()->getBaseUrl(true); ?>";
        q = "<?php echo $q ?>";
    </script>

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/search.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js"> </script>
    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/protected/js/search.js"> </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>
        //For more general functions, refer to /alpha/beta/search_beta.php
        $(function () {
            //For the credits slider under the courses category.
            var mySlider = new range_slider(
                {
                    selector: '.scrubber_slider',
                    unit: ' credits',
                    min: 0,
                    max: 4,
                    left_scrubber_pos: 2,
                    right_scrubber_pos: 7,
                    round_by: 1,
                    rounded: true,
                    // Event during initialization
                    release: function (e) {
                        // custom function for this event
                        console.log("Event happened, this object contains: \n\n { \n min : " + e.min + ",\nmax : " + e.max + "\n");
                    }
                });
        });
    </script>
</head>
<body>


    <!--
    Feel free to stick this in the appropriate CSS file
    Comment out the .sub_filter style to edit its UI
    -->
    <style>
        ul {
            list-style-type: none;
        }

        .search_category + .sub_filter {
            display: none;
        }

        .search_category.active + .sub_filter {
            display: block;
        }
    </style>

    <div class="root">
        <div class="search-top-bar-wrap">
            <?php echo Yii::app()->runController('partial/topbar'); ?>
        </div>
        <div class="main">
        <!--
        ================================================================================================================================
                                            Left Section / Advanced Search
        ================================================================================================================================
        -->
            <div class="leftsec">
                <div class="visible-lg">
                    <div class="searchType">
                        <!-- All searchTypes have sub_filters, which are Advanced Searches   -->

                        <span class="wedgeRight"></span>
                        <div id = "allResults">
                            <div class="search_category active">
                                <a class="type" data-value="All"><span id="category1" class="resultNum pull-right"></span>All Results</a>
                            </div>
                        </div>


                        <!--  Courses can be filtered by School, department, and professor -->
                        <div id = "courses">
                            <div class="search_category">
                                <a class="type" data-value="Courses"><span id="category2" class="resultNum pull-right"></span>Courses</a>
                            </div>
                            <div class="sub_filter">
                                <ul class="SearchFilterList">
                                    <!--ideally, we want to make these dropLists dynamic via JSON magic-->
                                    <li>
                                        <span class="FilterLabel DropdownLabel">School:</span>
                                        <div class="dropOpenBtn"><i class="dwnArrow"></i></div>
                                        <div class="dropOpenList" id="dropOpenList">
                                            <ul id="courseschool"></ul>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="FilterLabel DropdownLabel">Department:</span>
                                        <div class="dropOpenBtn"><i class="dwnArrow"></i></div>
                                        <div class="dropOpenList" id="dropOpenList">
                                            <ul id = "coursedepartment"></ul>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="FilterLabel">Professor:</span> <input class="filterTextinput" type="text" name="prof">
                                    </li>
                                    <li class="scrubberLi">
                                        <span class="FilterLabel">Credits:</span>
                                        <div class="scrubber_slider">

                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <!--  Professors can be filtered by School and Department -->
                        <div id ="professors">
                            <div class="search_category">
                                <a class="type" data-value="Professor"><span id="category3" class="resultNum pull-right"></span>Professors</a>
                            </div>
                            <div class="sub_filter">
                                <ul class="SearchFilterList">
                                    <li>
                                        <span class="FilterLabel DropdownLabel">School:</span>
                                        <div class="dropOpenBtn"><i class="dwnArrow"></i></div>
                                        <div class="dropOpenList" id="dropOpenList">
                                            <ul id = "professorschool"></ul>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="FilterLabel DropdownLabel">Department:</span>
                                        <div class="dropOpenBtn"><i class="dwnArrow"></i></div>
                                        <div class="dropOpenList" id="dropOpenList">
                                            <ul id = "professordepartment"></ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--  Students can be filtered by School and Major -->
                        <div id = "students">
                            <div class="search_category">
                                <a class="type" data-value="Student"><span id="category4" class="resultNum pull-right"></span>Students</a>
                            </div>
                            <div class="sub_filter">
                                <ul class="SearchFilterList">
                                    <li>
                                        <span class="FilterLabel DropdownLabel">School:</span>
                                        <div class="dropOpenBtn"><i class="dwnArrow"></i></div>
                                        <div class="dropOpenList" id="dropOpenList">
                                            <ul id = "studentschool"></ul>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="FilterLabel DropdownLabel">Major:</span>
                                        <div class="dropOpenBtn"><i class="dwnArrow"></i></div>
                                        <div class="dropOpenList" id="dropOpenList">
                                            <ul id = "studentmajor"></ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--  Clubs can be filtered by School -->
                        <div id = "clubs">
                            <div class="search_category">
                                <a class="type" data-value="Clubs"><span id="category5" class="resultNum pull-right"></span>Clubs</a>
                            </div>
                            <div class="sub_filter">
                                <ul class="SearchFilterList">
                                    <li>
                                        <span class="FilterLabel DropdownLabel">School:</span>
                                        <div class="dropOpenBtn"><i class="dwnArrow"></i></div>
                                        <div class="dropOpenList" id="dropOpenList">
                                            <ul id = "clubschool"></ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--  Departments can be filtered by School -->
                        <div id = "departments">
                            <div class="search_category">
                                <a class="type" data-value="Departments"><span id="category6" class="resultNum pull-right"></span>Departments</a>
                            </div>
                            <div class="sub_filter">
                                <ul class="SearchFilterList">
                                    <li>
                                        <span class="FilterLabel DropdownLabel">School:</span>
                                        <div class="dropOpenBtn"><i class="dwnArrow"></i></div>
                                        <div class="dropOpenList" id="dropOpenList">
                                            <ul id = "departmentschool"></ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-divider">


                    <button class="search-btn" name="commit" id="search">Search</button>

                </div>
            </div>
            <!--
            ================================================================================================================================
                                        Main Section/ Handlebar Templates
            ================================================================================================================================
            -->

            <div class="mainsec">
                <div id="result" class="midsec loadani_parent" style="zoom:1;">
                    <div class="all_results_active" style="opacity:1;">

                        <!--The template for users (be it student or professor) who match up with the search query-->
                        <div class="horiz-area">
                            <div class="horiz-wrapper">
                                <div class="horiz-mask">
                                    <div class="content-area">
                                        <div class="ContentSlider">
                                            <script id="user_search_results" type="text/x-handlebars-template">
                                                <div class="slide" style="transform: matrix(1,0,0,1,0,0); -webkit-transform: matrix(1,0,0,1,0,0)">
                                                    <div class="slide-inner">
                                                        <div class="result-photo">
                                                            <img src= "{{url}}">
                                                            <h3><a href="profile/{{id}}">{{fullname}}</a></h3>
                                                            <p>{{department}}</p>
                                                        </div>
                                                        <div class="person-bottom-functions"><div class="link-button"><a class="link link-up" data-value="{{id}}">Follow</a></div></div>
                                                    </div>
                                                </div>
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="arrow-disabled arrow-container arrow-prev">
                                    <a class="ar-disabled ar-left"></a>
                                </div>
                            </div>
                            <div class="arrow-container arrow-next">
                                <a id="ar-right" class="ar-right"></a></div>
                        </div>

                    </div>

                    <!--The template for courses who match up with the search query-->

                    <div class="vert-area">
                        <!--Course Search Results-->
                        <script id="vertical_course_results" type="text/x-handlebars-template">
                            <div class="course vert-results-wrapper">

                                <div class=results-top-sec>
                                    <div class="result-header">
                                        <a href = {{url}}>{{name}}</a>
                                    </div>
                                    <div class="result-header-right"></div>
                                    <div class="results-main-sec">
                                        <p class="description">
                                            {{description}}
                                        </p>
                                        <div class="lower-info-keys">
                                            <div class="info-key admin">
                                                {{admin_key}}
                                            </div>
                                            <div class="info-key subject">
                                                {{department_key}}
                                            </div>
                                            <div class="info-key members">
                                                {{members_key}}
                                            </div>
                                        </div>
                                        <div class="lower-info">
                                            <div class="info-piece admin">
                                                {{admin_value}}
                                            </div>
                                            <div class="info-piece subject">
                                                <a href = "{{department_url}}">{{department_value}}</a>
                                            </div>
                                            <div class="info-piece members">
                                                {{members_value}}
                                            </div>
                                            <div class="result-bottom">
                                                <div class="course-schedule"></div>
                                                <div class="course-bottom-functions"><div class="join-button">
                                                    <!--<a class="followCourse sign-up" data-value="BMS3314"></a>-->
                                                    </div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </script>

                        <!--Club Search Results-->
                        <script id="vertical_club_results" type="text/x-handlebars-template">
                            <div class="person vert-results-wrapper">
                                <a class="person-result-image" href="clubs.php?group_id=17">
                                    <div style="background-image: url({{imgurl}});" class="img"></div>
                                </a>
                                <div class="person-main">
                                    <div class="person-header">
                                        <div class="result-header">
                                            <a href="{{cluburl}}"><h2>{{name}}</h2></a>
                                            <a href="department.php?dept_id="><p></p></a>
                                        </div>
                                        <div class="result-header-right">
                                            <div class="result-functions-wrapper">
                                                <div class="prof-tooltip tooltip">
                                                    <div class="tool-wedge"></div>
                                                    <div class="prof-tool-box tool-box">
                                                        <span>Add This Professor To My Bookmarks</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="person-result-main">
                                        <a href="school.php?univ_id="><div class="person-info">
                                                <div style="background-image: url(DefaultImages/school.png);" class="title-limit"></div>
                                                <h4></h4>
                                            </div>
                                        </a>
                                        <div class="person-info">
                                            <div class="title-limit mail"></div>
                                        <a href="mailto:idmclub@polyidm.com"><h4>idmclub@polyidm.com</h4></a>
                                        </div></div>
                                    <div class="person-bottom-functions"><div class="link-button"><a class="link link-up" data-value="17">Follow</a></div></div>
                                </div>
                            </div>
                        </script>

                        <!--Department Search Results-->
                        <script id="vertical_dept_results" type="text/x-handlebars-template">
                            <div class="person vert-results-wrapper">
                                <a class="person-result-image" href="clubs.php?group_id=17">
                                    <div style="background-image: url({{imgurl}});" class="img"></div>
                                </a>
                                <div class="person-main">
                                    <div class="person-header">
                                        <div class="result-header">
                                            <a href="{{cluburl}}"><h2>{{name}}</h2></a>
                                            <a href="department.php?dept_id="><p></p></a>
                                        </div>
                                        <div class="result-header-right">
                                            <div class="result-functions-wrapper">
                                                <div class="prof-tooltip tooltip">
                                                    <div class="tool-wedge"></div>
                                                    <div class="prof-tool-box tool-box">
                                                        <span>Add This Professor To My Bookmarks</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="person-result-main">
                                        <a href="school.php?univ_id="><div class="person-info">
                                                <div style="background-image: url(DefaultImages/school.png);" class="title-limit"></div>
                                                <h4></h4>
                                            </div>
                                        </a>
                                        <div class="person-info">
                                            <div class="title-limit mail"></div>
                                        </div></div>
                                    <div class="person-bottom-functions"><div class="link-button"><a class="link link-up" data-value="17">Follow</a></div></div>
                                </div>
                            </div>
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="fb-root" class="fb_reset">
        <div style="position: absolute; top: -100000px; height: 0px; width: 0px;"><div></div></div>
        <div style="position: absolute; top: -100000px; height:0px; width:0px;"></div>
    </div>
</body>
</html>

<!--
<div class="vert-area">
                        <div class="person vert-results-wrapper">
                            <div class=results-top-sec>
                                <script id="vertical_club_results_img" type="text/x-handlebars-template">
                                    <a class="person-result-images" href= }>
                                        <div style="background-image: url('http://img1.wikia.nocookie.net/__cb20120412051836/suburgatory/images/5/52/Happy_face.jpg');" class="img"></div>
                                    </a>
                                    <div class="result-header-right"></div>
                                </script>
                                <div class="results-main-sec">
                                    <script id="vertical_club_results" type="text/x-handlebars-template">
                                        <p class="description">
                                            {{description}}
                                        </p>
                                        <div class="lower-info-keys">
                                            <div class="info-key admin">
                                                {{admin_key}}
                                            </div>
                                            <div class="info-key subject">
                                                {{department_key}}
                                            </div>
                                            <div class="info-key members">
                                                {{members_key}}
                                            </div>
                                        </div>
                                        <div class="lower-info">
                                            <div class="info-piece admin">
                                                {{admin_value}}
                                            </div>
                                            <div class="info-piece subject">
                                                {{department_value}}
                                            </div>
                                            <div class="info-piece members">
                                                {{members_value}}
                                            </div>
                                        </div>
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
<div class="vert-area">
    <div class="course vert-results-wrapper">
        <div class=results-top-sec>
            <script id="vertical_dept_results_top" type="text/x-handlebars-template">
                <div class="result-header">
                    {{rname}}
                </div>
                <div class="result-header-right"></div>
            </script>
            <div class="results-main-sec">
                <script id="vertical_dept_results" type="text/x-handlebars-template">
                    <p class="description">
                        {{description}}
                    </p>
                    <div class="lower-info-keys">
                        <div class="info-key admin">
                            {{admin_key}}
                        </div>
                        <div class="info-key subject">
                            {{department_key}}
                        </div>
                        <div class="info-key members">
                            {{members_key}}
                        </div>
                    </div>
                    <div class="lower-info">
                        <div class="info-piece admin">
                            {{admin_value}}
                        </div>
                        <div class="info-piece subject">
                            {{department_value}}
                        </div>
                        <div class="info-piece members">
                            {{members_value}}
                        </div>
                    </div>
                </script>
            </div>
        </div>
    </div>
</div>

-->