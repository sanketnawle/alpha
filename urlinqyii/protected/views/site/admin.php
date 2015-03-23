<!DOCTYPE html>
<html>
<head>
    <title>Urlinq Admin Panel</title>


    <link href='<?php echo Yii::app()->getBaseUrl(true); ?>/css/site/admin.css' rel='stylesheet' type='text/css'>


    <script>

        var globals = {};

        globals.base_url = "<?php echo Yii::app()->getBaseUrl(true); ?>";




    </script>



    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/jquery.min.js"></script>

    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/handlebars.js" > </script>

    <script src="<?php echo Yii::app()->getBaseUrl(true); ?>/js/main/admin.js"></script>
</head>
    <body>




    <div id="create_class">
        <h1>Create Class</h1>
        <form id="create_class_form">
            <label for="create_class_university_input">University</label>
            <br>
            <input type="text" name="" id="create_class_university_input" placeholder="NYU" value="NYU" data-id="1">

            <br>

            <label for="create_class_school_input">School</label>
            <br>

            <input type="text" class="school_input" id="create_class_school_input" placeholder="school" data-id="0">

            <br>


            <label for="create_class_department_input">Department</label>
            <br>

            <input type="text" class="department_input" id="create_class_department_input" placeholder="department" data-id="0">

            <br>


            <label for="create_class_course_input">Course</label>
            <br>

            <input type="text" id="create_class_course_input" placeholder="course" data-id="0">

            <br>

<!--            <input type="text" id="create_class_course_tag_input" placeholder="course tag (MA-UY 1121)">-->

            <br>


            <input type="text" id="create_class_name_input" placeholder="class name">

            <input type="text" id="create_class_section_input" placeholder="section">

            <input type="text" id="create_class_location_input" placeholder="location">

            <input type="text" id="create_class_component_input" placeholder="component (Lecture, Lab, etc)">

            <input type="text" id="create_class_datetime_input" placeholder="datetime (Wed 2.00 PM - 4.50 PM)">

            <input type="text" id="create_class_professor_input" placeholder="professor" data-id="0">
            <br>

            <button type="submit">Create Class</button>

        </form>


    </div>
    
    
    
    
    
    <div id="create_course">
        <h1>Create course</h1>
        <form id="create_course_form">
            <label for="create_course_university_input">University</label>
            <br>
            <input type="text" name="" id="create_course_university_input" placeholder="NYU" value="NYU" data-id="1">

            <br>

            <label for="create_course_school_input">School</label>
            <br>

            <input type="text" class="school_input" id="create_course_school_input" placeholder="school" data-id="0">

            <br>


            <label for="create_course_department_input">Department</label>
            <br>

            <input class='department_input' type="text" id="create_course_department_input" placeholder="department" data-id="0">

            <br>


<!--            <input type="text" id="create_course_course_tag_input" placeholder="course tag (MA-UY 1121)">-->

            <br>


            <input type="text" id="create_course_name_input" placeholder="course name">

            <input type="text" id="create_course_tag_input" placeholder="tag (eg MA-UY 5001">

            <input type="text" id="create_course_description_input" placeholder="description">

            <input type="text" id="create_course_credits_input" placeholder="credits">

            <button type="submit">Create course</button>

        </form>


    </div>

    <div id="add_video">
        <h1>Add Video</h1>
        <form id="create_video_form">
            <label for="create_video_url_input">URL</label>
            <br>
            <input type="text" name="url_input" id="create_video_url_input">

            <br>

            <label for="create_video_title_input">Title</label>
            <br>

            <input class='title_input' type="text" id="create_video_title_input" placeholder="title">
            <br>

            <label for="create_video_description_input">Description</label>
            <br>

            <textarea class='description_input' type="text" id="create_video_description_input" placeholder="description"></textarea>
            <br>

            <label for="create_video_school_input">School</label>
            <br>

            <input type="text" class="school_input" id="create_video_school_input" placeholder="school" data-id="0">

            <br>

            <label for="create_video_department_input">Department</label>
            <br>

            <input type="text" class="department_input" id="create_video_department_input" placeholder="department" data-id="0">

            <br>


            <label for="create_video_topic_input">Topic</label>
            <br>

            <input class='topic_input' type="text" id="create_video_topic_input" placeholder="topic">

            <br>



            <!--            <input type="text" id="create_course_course_tag_input" placeholder="course tag (MA-UY 1121)">-->

            <button type="submit">Add Video</button>

        </form>
        <br>
        <br><br><br><br><br><br><br>

    </div>



    
    <h1>Upload file</h1>
    <form id='file_upload_form' action="<?php echo Yii::app()->getBaseUrl(true); ?>/fileUpload" method="post" enctype="multipart/form-data">
        <input id="path_input" type="text" name="path" value="profile/">
        Please choose a file: <input type="file" name="file"><br>
        <input type="submit" value="Upload File">
    </form>



    
    
    
    
    
    
    
    
    <div id="input_dropdown">


    </div>


    <script id="dropdown_item_template" type="text/x-handlebars-template">
        <div class="dropdown_item" data-id='{{id}}' data-name='{{name}}'>{{name}}</div>
    </script>



    </body>
</html>