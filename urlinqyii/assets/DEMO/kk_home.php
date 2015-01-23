<?php

session_start();

echo "hello";
echo $_SESSION['usertype']='Student';
echo $_SESSION['student_id']=1;

////////check if user login or not //////////
if(!isset($_SESSION['usertype'])){
    header("Location:index.php?pg=login");
    exit;
}
if(isset($_GET['univid']) && $_GET['univid']!='' ){
    $university_id=$_GET['univid'];
}
else{
    $university_id=0;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


    <head>
        <!-- <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Kaushik">
        <link rel="shortcut icon" href="../images/experiments.ico">

        <meta property="og:image" content="http://urlinq" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="urlinq - Home" />
        <meta property="og:url" content="http://experiments.sourcenxt.in/hangman/" />
        <meta property="og:site_name" content="Experiments_at_SourceNXT" /> -->


        <title>urlinq</title>

        <!-- Bootstrap -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="starter-template.css" rel="stylesheet">

        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>

    </head>
    
    <body>



                
<!-- Class info -->
                    <div class="col-md-3"><a href='choice.php'><h3>Home</h3></a></div>
                    <div class="col-md-6"><center><h3>User Type: <?php echo $usertype = $_SESSION['usertype']; ?></h3></div>
                    <div class="col-md-3"><h4 class='text-muted pull-right'>Student ID : <?php echo $student_id = $_SESSION['student_id']; ?></h4>
                    </div>
                <!-- <div class="page-header"><center><a href="include_kk/logout.php" style="align:right;">LogOut</a></center></div> -->

<!-- Class info close -->

        <div id="que" class="col-xs-12 col-sm-6 col-md-7">

        </div>

        <div class="row col-md-offset-1">
        <div class="col-xs-6 col-md-4">
            <form role="form" name="post_que">
                <textarea placeholder="Post Your Question Here" name="post_content" class="form-control" rows="3"></textarea>

                <button class="btn btn-primary btn-block" type="submit" name="submit">Post Question</button>
            </form>
        </div>

        <div id="" class="col-xs-6 col-md-4">
            <center><h3>Attendees Here</h3></center>
        </div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">

$(function() {
    
    //populating que the first time
    refresh_que();
    // recurring refresh every 15 seconds
    setInterval("refresh_que()", 15000);

    $("#submit").click(function() {
        // getting the values that user typed
        // var name    = $("#name").val();
        var post_content = $("#post_content").val();
        // forming the queryString
        var data = 'post_content='+ post_content;
        alert("test");

        // ajax call
        $.ajax({
            type: "POST",
            url: "include_kk/kk_homepost.php",
            data: data,
            success: function(html){ // this happen after we get result
                $("#que").slideToggle(500, function(){
                    $(this).html(html).slideToggle(500);
                    $("#post_content").val("");
                });
          }
          
        });    
        return false;
    });
});

function refresh_que() {
    var data = 'refresh=1';
    
    $.ajax({
            type: "POST",
            url: "include_kk/kk_homepost.php",
            data: data,
            success: function(html){ // this happen after we get result
                $("#que").html(html);
            }

        });
}

function refresh_reply() {
    var data = 'refresh=1';
    
    $.ajax({
            type: "POST",
            url: "include_kk/kk_homepost.php",
            data: data,
            success: function(html){ // this happen after we get result
                $("#que").html(html);
            }

        });
}


</script>

                <?php } else{

                    header('Location: index.php');

                }
            }       
            
            else{ ?>
            
                <p> Something's wrong!!! </p>
            
            <?php }
            ?>

            <?php else : ?>
                <script>
                    window.alert("You are not authorized to access this page.\n\n\t\t\tPlease LogIn");
                    window.location.href='index.php';
                </script>
            <?php endif; ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>