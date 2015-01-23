<?php
    session_start();
    $_SESSION['id']="5";
    $_SESSION['type']="s";
    require_once 'connect.php';
    $csize=3;
    $uid=1;
    $sid=5;
    $type="s";
    $clubsize=2;
    if($_GET['uid']!=null&$_GET['type']!=null&$_GET['sid']!=null)
    {
        $uid=$_GET['uid'];
        $sid=$_GET['sid'];
        $type=$_GET['type'];
    }
    
    //================For edit profile pic===============================
    
   /* else
    {
        $sid=0;
        $uid=0;
        $type="s";
    }*/
    //Find professor/student name
    if($type=="s")
    {
        $ptable="student_".$uid;
        $Uq=$GLOBALS['pdo']->query("select * from $ptable where `studentid`= $sid ");
    }
    else if($type=="p")
    {
        $ptable="professor_".$uid;
        $Uq=$GLOBALS['pdo']->query("select * from $ptable where `profid`= $sid ");
    }
    
    $UqR=$Uq->fetch(PDO::FETCH_ASSOC);
    $name=$UqR['name'];
    function mkdirs($dir)
    {
        if(!file_exists($dir))
        {
            echo $dir;
            mkdir($dir,0777);
        }
        return true;
    }
    if(isset($_GET['action'])&&$_GET['action']=='edit')
    {
        
        
       // echo '<script type="text/javascript">alert ("in edit function");</script>';
        $picroot="picture";
        $roott=$name;
        mkdirs("/www/urlinq/phpcp_0410/cp_cc/studentProfile/picture");
        $root="/picture";

if(is_uploaded_file($_FILES["upload_photo"]["tmp_name"]))
{
    
    echo '<script type="text/javascript">alert ("Your picture has been uploadedtofile!");</script>';
    if(move_uploaded_file($_FILES["upload_photo"]["tmp_name"],$root."/".$name))
    {
	echo '<script type="text/javascript">alert ("Your picture has been moved!”);</script>';
        if($UqR['profilepic']===$roott)
        {
            echo '<script type="text/javascript">alert ("Your picture has been updated to same name!");</script>';
            //  echo "<script>location.href='editprofpic.php?uid=$uid&sid=$sid&type=$type';</script>";
        }
        else
        {
            if($type=="p")
            {
                $query=$GLOBALS['pdo']->prepare("UPDATE $ptable set `location`='{$picroot}',`profilepic`= '{$roott}' where `profid`= $sid");
            }
            else if($type=="s")
            {
             //   echo '<script type="text/javascript">alert ("Your picture has been ready to updatedto server!");</script>';
                $query=$GLOBALS['pdo']->prepare("UPDATE $ptable set `location`='{$picroot}',`profilepic`= '{$roott}' where `studentid`= $sid");
            }
            $query->execute();
            //	   echo $query;
            if($query->rowCount()!=0)
            {
                
              //  echo '<script type="text/javascript">alert ("Your picture has been server updated!");</script>';
                
            }
            
            else
            {
              //  echo '<script type="text/javascript">alert ("Fail to update database! Please try again!");</script>';
            }
        }
        
    }
}
else
{
  //  echo  '<script>alert("Fail to update!Please try again!");</script>';
}
}


//}


?>
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="p0.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="masonry-docs/masonry.pkgd.min.js"></script>
    <script src="banner.js"></script>
    <link rel="stylesheet" type="text/css" href="banner.css">
    <script>
        $(document).ready(function () {

            var color_scheme = ["#C0BAA1", "#C0BAA1"];
            var color_at = 0;
            $(".present-interests").each(function () {
                $(this).css("background-color", color_scheme[color_at]);
                color_at++;
            })


            $(document).delegate("#profile-picture", "mouseover", function () {
                $(".camera-icon").show();
            });

            $(document).delegate("#profile-picture", "mouseout", function () {
                $(".camera-icon").hide();
            });


            $(document).delegate(".camera-icon", "mouseover", function () {
                $(".camera-icon").show();
            });

            $(document).delegate(".camera-icon", "mouseout", function () {
                $(".camera-icon").hide();
            });




            $(".class-name").each(function (index) {
                if ($(this).text().length > 23) {
                    //alert($(this).attr("id"));
                    $(this).text($(this).text().substr(0, 20) + "...");
                }
            });
            $(".club-name").each(function (index) {
                if ($(this).text().length > 23) {
                    //alert($(this).attr("id"));
                    $(this).text($(this).text().substr(0, 20) + "...");
                }
            });







            $(document).delegate(".x-icon", "mouseover", function () {
                $(this).closest(".class-buttons").find(".xdescription").show();
            });
            $(document).delegate(".x-icon", "mouseout", function () {
                $(this).closest(".class-buttons").find(".xdescription").hide();
            });


            $(document).delegate(".edit-classes", "mousedown", function () {
                $(".edit-classes").hide();
                $("#done-edit-classes").show();
                $(".class-buttons").show();
            });

            $(document).delegate("#done-edit-classes", "mousedown", function () {
                //editinfo();
                $(this).hide();
                $(".edit-classes").show();
                $(".class-buttons").hide();
            });



            $(document).delegate(".x-icon", "click", function () {
                var pid = "kw=" + $(this).closest(".class-one").attr("id");
                $("#blackcanvas").show();
                $(".dropconfirm").attr("id", pid);

            });


            $(document).delegate("#blackcanvas", "click", function (e) {

                if (($(e.target).is(".dropconfirm > *")) || ($(e.target).is(".dropconfirm"))) {
                    return false;

                }

                $(this).hide();

            });

            $(document).delegate(".dbuttons", "click", function () {
                var v = $(this).val();
                $("#blackcanvas").hide();
                if (v == 1) {
                    var tid = $(".dropconfirm").attr("id").split("=");
                    $("#" + tid[1]).hide();
                }
                $("#blackcanvas").hide();

            });


            $(document).delegate("#dexit", "mouseover", function () {

                $(this).css("opacity", "1");
            });

            $(document).delegate("#dexit", "mouseout", function () {

                $(this).css("opacity", "0.7");
            });


            $(document).delegate("#dexit", "click", function () {

                $("#blackcanvas").hide();
            });
            $(document).delegate(".edit-clubs", "mousedown", function () {
                $(".edit-clubs").hide();
                $("#done-edit-clubs").show();
                $(".club-buttons").show();
            });

            $(document).delegate("#done-edit-clubs", "mousedown", function () {
                $(this).hide();
                $(".edit-clubs").show();
                $(".club-buttons").hide();
            });

            $('.camera-icon').click(function () {
                $('input[type=file]').click();
                return false;
            });

            var mit = $("#minor-title").text().trim();
            var eml = $("#user-email").text().trim();
            var btx = $("#bio-contents").text().trim();
            var nme = $("#user-profile-header").text().trim();
            var yr = "20" + $("#year-data").text().trim().substr(1);

            $(document).delegate(".edit-profile", "click", function () {
                $(this).addClass("pediting");
                $(this).text("Done");//("Click to complete");

                //$("#user-profile-info").hide();
                //$("#editcolumn-u").val(ut);
                //$("#editcolumn-s").val(st);
                //$("#editcolumn-a").val(mat);
                //$("#editcolumn-i").val(mit);
                //$(".editprofile").show();

                $(".peditable").hide();
                $(".emailtext").val(eml);
                $(".biotext").val(btx);
                $(".editingbio").show();

                $("#blackcanvas-inside").show();
                $("#blackcanvas-banner").show();
                $("#user-profile-bio").css("z-index", 150);
            });


            $(document).delegate(".real-edit-profile", "click", function () {

                $("#user-profile-info").hide();

                $("#editcolumn-i").val(mit);
                $("#editcolumn-n").val(nme);
                $("#editcolumn-c").val(yr);
                $(".editprofile").show();

                //$(".peditable").hide();
                //$(".emailtext").val(eml);
                //$(".biotext").val(btx);
                //$(".editingbio").show();
                $(".existedinterests").remove();

                $(".present-interests").each(function () {
                    var t = $(this).find(".i-name").text().trim();
                    $(".interestsfield").prepend("<div class='aninterest existedinterests'><input type='text' class='editcolumn individual-interests' placeholder='Interests' value='" + t + "'></input><span class='modinterests mod-individual-interests'>-</span></div>");
                });

                $("#blackcanvas-inside").show();
                $("#blackcanvas-banner").show();
                $(".editprofile").css("z-index", 150);
            });


            $(document).delegate("#bio-contents", "click", function () {
                $(".edit-profile").addClass("pediting");
                $(".edit-profile").text("Done");

                //$("#user-profile-info").hide();

                $("#editcolumn-i").val(mit);
                //$(".editprofile").show();

                //$(".peditable").hide();
                $(".emailtext").val(eml);
                $(".biotext").val(btx);
                $(this).hide();
                $("#studdesc").show();

                $("#blackcanvas-inside").show();
                $("#blackcanvas-banner").show();
                $("#user-profile-bio").css("z-index", 150);
            });


            $(document).delegate(".pediting", "click", function () {
                //editinfo();
                $(this).removeClass("pediting");
                $(this).text("Edit Bio");
                $(".editprofile").css("z-index", 0);
                $(".editprofile").hide();
                //$("#university-title").text(ut);
                //$("#school-title").text(st);
                //$("#study-title").text(mat);
                //$("#minor-title").text(mit);
                //$("#user-profile-info").show();

                $(".editingbio").hide();
                $("#user-email").text(eml);
                $("#bio-contents").text(btx);
                $(".peditable").show();
                tett(btx, eml);
                /*Ajax goes here*/
                $("#blackcanvas-inside").hide();
                $("#blackcanvas-banner").hide();
                $("#user-profile-bio").css("z-index", 0);
            });


            $(document).delegate(".addinterests", "click", function () {
                $(".interestsfield").append("<div class='aninterest'><input type='text' class='editcolumn individual-interests' placeholder='Interests'></input><span class='modinterests mod-individual-interests'>-</span></div>");
            });

            $(document).delegate(".mod-individual-interests", "click", function () {
                $(this).closest(".aninterest").remove();
            });

            $(document).delegate(".canceledit", "click", function () {

                $(".editprofile").hide();
                $("#user-profile-info").show();

                $("#blackcanvas-inside").hide();
                $("#blackcanvas-banner").hide();
                $("#user-profile-bio").css("z-index", 0);
            });


            $(document).delegate(".done-pedit", "click", function () {


                var arr = "";
                var i = 0;

                $("#present-minor").find("#minor-title").text($("#editcolumn-i").val());

                $(".present-interests").remove();
                var icards = new Array();
                $(".individual-interests").each(function (index) {
                    if ($(this).val().trim() != "") {
                        icards.push($(this).val().trim());
                        arr = arr + $(this).val().trim() + ";";
                    }
                });

                var tri = 0;

                while (icards.length > 0) {

                    $(".present-interestsfield").append("<div class = 'present-interests' style='background-color:" + color_scheme[color_at] + "'><div class = 'tile-top'></div><div class='i-name'>" + icards[0] + "</div></div>");
                    color_at = color_at + 1;
                    if (color_at == 2) {
                        color_at = 0;
                    }
                    icards.shift();

                }
                $(".real-edit-profile").remove();
                $(".present-interestsfield").append("<div class='real-edit-profile'><img class='edit-profile-button' src='src/edit-icon.png'></div>");

                $(".aninterest").each(function (index) {
                    if (!$(this).hasClass("existedinterests")) {
                        $(this).remove();
                    }
                });
                $(".interestsfield").append("<div class='aninterest'><input type='text' class='editcolumn individual-interests' placeholder='Interests'></input><span class='modinterests mod-individual-interests'>-</span></div>");


                $("#user-profile-header").text($("#editcolumn-n").val().trim());
                $("#year-data").text("'" + $("#editcolumn-c").val().trim().substr(-2));

                $(".editprofile").hide();
                $("#user-profile-info").show();

                $("#blackcanvas-inside").hide();
                $("#blackcanvas-banner").hide();
                $("#user-profile-bio").css("z-index", 0);
                editinfo($("#editcolumn-c").val().trim(), $("#editcolumn-i").val(), $("#editcolumn-n").val().trim(), arr);
            });

            $(document).delegate(".editcolumn", "keyup", function () {

                if ($(this).attr("id") == "editcolumn-i") {
                    mit = $(this).val();
                }
            });

            $(document).delegate(".editingbio", "keyup", function () {
                if ($(this).hasClass("emailtext")) {
                    eml = $(this).val();
                }
                if ($(this).hasClass("biotext")) {
                    btx = $(this).val();
                }

            });


            $("#upload_photo_button").click(function () {
                $("#upload_photo").click();
            });

            $('#upload_photo').change(function () {
                // alert("sdahfgs");
                $('#photo_form').submit();
            });
        });

      </script>

</head>
<script type="text/javascript">
    var deletecid;
    var deleteaction;
    var divc;
    function display(csize, num) {
        // alert("indisplay");
        var classmore = document.getElementById("classmore");
        for (i = csize; i < num; i++) {
            var id = "courseid_" + i;
            var target = document.getElementById(id);
            if (target.style.display == "none") {
                target.style.display = "block";
                classmore.textContent = "see less";
            } else {
                target.style.display = "none";
                classmore.textContent = "see more";
            }
        }

    }
    function clubdisplay(clubsize, num) {
        var clubmore = document.getElementById("clubmore");
        for (i = clubsize; i < num; i++) {
            var id = "clubid_" + i;
            var target = document.getElementById(id);
            if (target.style.display == "none") {
                target.style.display = "block";
                clubmore.textContent = "see less";
            } else {
                target.style.display = "none";
                clubmore.textContent = "see more";
            }
        }


    }
    function clubpagedisplay(sid, gid, uid, type) {
        // alert ("in!");
        location.href = '../club.php?sid=' + sid + '&type=' + type + '&uid=' + uid + '&gid=' + gid;
    }
    function coursepagedisplay(sid, cid, uid, type) {
        //  alert ("in!");
        location.href = '../studentindex.php?sid=' + sid + '&type=' + type + '&uid=' + uid + '&cid=' + cid;
    }
    function dropcoursepara(cid, action, c) {
        // alert("in!");
        deletecid = cid;
        deleteaction = "course";
        divc = "courseid_" + c;
        //  alert("deletecid="+deletecid);
        //   alert("deleteaction="+deleteaction);
        //   alert("divx="+divc);

    }
    function dropclubpara(gid, action, g) {
        // alert("in!");
        deletecid = gid;
        deleteaction = "club";
        divc = "clubid_" + g;
        //  alert("deletecid="+deletecid);
        //   alert("deleteaction="+deleteaction);
        //   alert("divx="+divc);

    }
    function dropcourse(sid, uid, type) {
        //alert("in!!!!");
        var course = document.getElementById(divc);
        course.parentNode.removeChild(course);
        $.ajax({
            type: "POST",
            url: "delete.php",
            data: { sid: sid, cid: deletecid, uid: uid, type: type, action: deleteaction }
        })
        var black = document.getElementById('blackcanvas');
        black.style.display = "none";

    }

    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }


    var sid = "";
    var type = "";

    var unum = -1;
    function changeuniv(olduid) {
        if (unum != -1) { olduid = unum; }
        var utarget = document.getElementById("editcolumn-u");
        var id = "editcolumn-a" + utarget.value;
        var idd = "editcolumn-a" + olduid;
        var dtarget = document.getElementById(id);
        var ddtarget = document.getElementById(idd);
        //alert(dtarget.value);
        alert(utarget.value);
        //  alert(olduid);
        ddtarget.style.display = "none";
        dtarget.style.display = "block";
        unum = utarget.value;
    }
    function test() {
        window.open("editprofpic.php?sid=<?php echo $sid;?>&uid=<?php echo $uid;?>&type=<?php echo $type?>", "newwindow", "height=100,width=400,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");

    }
    function tett(btx, eml) {
        $.ajax({
            type: "POST",
            url: "editbio.php",
            data: { sid: sid, uid: uuid, type: type, email: eml, studdesc: btx }
        });

    }
    var uuid = "";

    function connect(toid, fromid, totype, fromtype) {
        /*  alert("toid="+toid);
          alert("fromid="+fromid);
          alert("uid="+uuid);
          alert("totype="+totype);
          alert("fromtype="+fromtype);*/
        $.ajax({
            type: "POST",
            url: "studentconnect.php",
            data: { toid: toid, uid: uuid, totype: totype, fromid: fromid, fromtype: fromtype }
        });
        /*
        .done(function() {
              alert("connected sucessfully!!");
              location.href='studentprofile.php?sid='+sid+'&type='+type;
              });*/
    }
    function disconnect(toid, fromid, totype, fromtype) {
        // alert("disconnect")
        /*  alert("toid="+toid);
         alert("fromid="+fromid);
         alert("uid="+uuid);
         alert("totype="+totype);
         alert("fromtype="+fromtype);*/

        $.ajax({
            type: "POST",
            url: "studentdisconnect.php",
            data: { toid: toid, uid: uuid, totype: totype, fromid: fromid, fromtype: fromtype }
        });
        /*
         .done(function() {
         alert("connected sucessfully!!");
         location.href='studentprofile.php?sid='+sid+'&type='+type;
         });*/
    }

    function editinfo(y, m, n, i) {
        //alert("in editinfo function");
        //  var majordiv=document.getElementById("editcolumn-i");
        // var major=majordiv.value;
        //var utarget=document.getElementById("editcolumn-u");
        //var nuid=utarget.value;
        // alert(utarget.value);
        //var id="editcolumn-a"+utarget.value;
        //var dtarget=document.getElementById(id);
        //var deptid=dtarget.value;
        //  var desctext=document.getElementById("studdesc");
        // var desc=desctext.value.trim();
        $.ajax({
            type: "POST",
            url: "editinfo.php",
            data: { sid: sid, uid: uuid, type: type, year: y, major: m, name: n, interest: i }
        });
    }
</script>

<body>
    <section id="banner">
        <section id="blackcanvas-banner"></section>
        <img src="src/logo.png" id="logo">
        <a class="university clickable">
            <span id="u-notification" class="notifications">1
            </span>
        </a>
        <a class="calendar clickable">
            <span id="c-notification" class="notifications">4
            </span>
            <img class="chv ic">
            <img class="cnm ic">
            <img class="cac ic">
        </a>
        <a id="profile-icon" href="javascript:void(0)" onclick="">
            <div style="display: inline-block;" id="border">
                <img id="profile-pic" src="src/prof-pic.png">
            </div>
        </a>

        <div id="search-container">
            <input id="search-bar" name="search" type="text" placeholder="Find groups and faculty..." />
        </div>

        <a class="settings"></a>
        </div>
       
        <div id="university-menu" class="menus">
            <div class="caret">
            </div>
            <div id="u-menu-content">
                <div id="menu-content-header">
                    <div id="rfloat">
                        <a href="#" role="button" id="u-link">Go to University Page</a>
                        <span id="separator">·</span>
                        <a href="#" role="button" id="settings-link">Settings</a>
                    </div>
                    <a id="notifications-header">Campus Feed
              </a>
                    </h3>
           
                </div>
            </div>

        </div>

        <div id="profile-menu">
            <div class="caret-3">
            </div>
            <div id="p-menu-content">
                <div id="menu-content-header">

                    <a id="profile-header">Visit My Profile
                        </a>
                    </h3>
                           
                </div>
                <div id="profile-edit">
                    Edit Profile
                   
                </div>

                <div id="signout">
                    Sign Out
                   
                </div>
            </div>

        </div>

        <div id="calendar-menu" class="menus">
            <div class="caret-2">
            </div>
            <div id="c-menu-content">
                <div id="menu-content-header">
                    <div id="rfloat">

                        <a href="#" role="button" id="settings-link">New Event +</a>
                    </div>
                    <a id="notifications-header">Upcoming (10)
              </a>

                    <a id="incomplete-header">Incomplete (4)
              </a>
                </div>
            </div>
        </div>
    </section>


    <section id="user-profile">
        <section id='blackcanvas-inside'>
        </section>

        <header id="profile-header-area">
            <div>
                <div id="profile-intro">
                    <img id="profile-picture" alt="user image" border="0" src="<?php
if ($type=="s")
{
    $stutable="student_".$uid;
    $mquery=$GLOBALS['pdo']->prepare("SELECT * FROM $stutable WHERE `studentid` = $sid");
    $mquery->execute();
    $mresult = $mquery->fetch(PDO::FETCH_ASSOC);
    $pic="/DEMO".$mresult['location']."/".$mresult['profilepic'];
    echo $pic;
}
else if ($type=="p")
{
    $ptable="professor_".$uid;
    $pquery=$GLOBALS['pdo']->prepare("SELECT * FROM $ptable WHERE `profid` = $sid");
    $pquery->execute();
    $presult = $pquery->fetch(PDO::FETCH_ASSOC);
    $pic="/DEMO".$presult['location']."/".$presult['profilepic'];
    echo $pic;
    
}
?>" />
<?php if($_SESSION['id']==$sid){?>
                    <a id="avatar" href="" onclick="javascript:void(0)">
                        <span id="edit-picture">
                            <img class="camera-icon" src="src/camera-icon.png">
                            <form id="photo_form" method="post" action="studentprofile.php?sid=<?php echo $sid;?>&uid=<?php echo $uid;?>&type=<?php echo $type;?>&action=edit" enctype="multipart/form-data">
                                <input type="file" id="upload_photo" name="upload_photo" />
                                <button id="upload_photo_button">Upload</button>
                            </form>
                        </span>
                    </a>
					<?php }?>
                    <h1 id="user-profile-header"><?php
    if ($type=="s")
    {
        $stutable="student_".$uid;
        $mquery=$GLOBALS['pdo']->prepare("SELECT * FROM $stutable WHERE `studentid` = $sid");
        $mquery->execute();
        $mresult = $mquery->fetch(PDO::FETCH_ASSOC);
        echo $mresult['name'];
    }
    else if ($type=="p")
    {
        $ptable="professor_".$uid;
        $pquery=$GLOBALS['pdo']->prepare("SELECT * FROM $ptable WHERE `profid` = $sid");
        $pquery->execute();
        $presult = $pquery->fetch(PDO::FETCH_ASSOC);
        echo $presult['name'];
        
    }
    ?></h1>
	<?php
    $vid=$_SESSION['id'];
    //==================Connect Part (NEED FRONT END POLISH)===============
    if($_SESSION['type']=="s")
    {
        
        $contable="student_student_".$uid;
        $sconnect=$GLOBALS['pdo']->prepare("select * from $contable where `from_studid`=$vid and `to_studid`=$sid");
        $sconnect->execute();
    }
    else if($_SESSION['type']=="p")
    {
        $contable="professor_student_".$uid;
        $sconnect=$GLOBALS['pdo']->prepare("select * from $contable where `from_profid`=$vid and `to_studid`=$sid");
        $sconnect->execute();
    }
    
    if(($_SESSION['id']!=$sid)&&($sconnect->rowCount()==0)) {?>
                    <a class="connect-button" onclick="connect('<?php echo $sid?>','<?php echo $_SESSION['id']?>','<?php echo $type?>','<?php echo $_SESSION['type']?>')">
                        <img src="src/link-icon.png" class="connect-icon"><p class="connect-text">Connect</p>
                    </a>
					<?php }else {?>
					<?php //========FRONT END FOR CONNECTED HERE~~~~
?>
                    <a class="connect-button" onclick="disconnect('<?php echo $sid?>','<?php echo $_SESSION['id']?>','<?php echo $type?>','<?php echo $_SESSION['type']?>')">
                        <p class="disconnect-text">Disconnect</p>
                    </a>
<?php }?>
                    <div id="user-class-year">
                        <p id="year-header">
                            Class
                            <br>
                            Of             
                        </p>
                        <h5 id="year-data"><?php
    //echo $mresult['year'];
    echo "'".substr($mresult['year'],2);?>
	</h5>
                    </div>
                </div>

                <div id="user-profile-main">
                    <div id="present-classes">
                        <div id="classes-top">
                            <p id="classes-header">Classes</p>
							<?php if($_SESSION['id']==$sid) {?>   
                            <a class="edit-classes">
                                <img width="14px" id="edit-icon-pic" src="src/edit-icon.png"><p id="btn-p-style">Edit</p>
                            </a>
                            <a id="done-edit-classes">Done Editing</a>
                            <a id="join-classes">
                                <p id="browse-classes">Add Classes</p>
                            </a>
							<?php }?>
                        </div>
                        <div style="float: left; background-color: red; width: 2px; height: 200px; margin-left: 5px;margin-top:10px;">
                            <p></p>
                        </div>

						<?php
    if($type=="s")
    {
        $sc="student_courses_".$uid;
        $cstatement="SELECT * FROM $sc WHERE `student_id` = $sid order by enrolltime desc";
        $c=0;
        foreach($GLOBALS['pdo']->query($cstatement) as $CT)
        {
            
            if ($c< $csize)
            {
                
                ?>

                        <!--courseid is a unique id in any format, just similar to the tagid in calendar page, but should not have "=" symbol -->
						<?php echo $CT['enrolltime']?>
                        <div class="class-one" id="courseid_<?php echo $c?>">
                            <a class="class-link1" href="javascript:void(0)" onclick="coursepagedisplay('<?php echo $sid?>','<?php echo $CT['course_id']?>','<?php echo $uid?>','<?php echo $type?>')">
                                <div style="display: inline-block;" id="class-pic-container">
                                    <img id="class-pic" src="src/class-pic.png" alt="Class Picture">
                                </div>
                                <h3 class="class-name"><?php
    $coursetable="course_".$uid;
    $cquery=$GLOBALS['pdo']->prepare("SELECT * FROM $coursetable WHERE `cid` = '{$CT['course_id']}' and `universityid`='{$CT['universityid']}'");
    $cquery->execute();
    $cresult = $cquery->fetch(PDO::FETCH_ASSOC);
    echo $cresult['name'];
    ?>
	</h3>

                            </a>
                            <div class="professor">
							<?php
                    $pt="professor_".$uid;
                    $pquery=$GLOBALS['pdo']->prepare("SELECT * FROM $pt WHERE `profid` = '{$cresult['profid']}'");
                    $pquery->execute();
                    $presult = $pquery->fetch(PDO::FETCH_ASSOC);
                    
                    ?>
                                <a id="professor-link1">
                                    <img id="professor-pic1" src="<?php $pic="/DEMO".$presult['location'].'/'.$presult['profilepic']; echo $pic?>"><p id="professor-name1"><?php
                        echo $presult['name'];
                        ?></p>
                                </a>
                            </div>

                            <div class="class-buttons">
                                <a class="drop-course" href="javascript:void(0)" onclick="dropcoursepara('<?php echo $CT['course_id'];?>','<?php echo 'course'?>','<?php echo $c?>')">
                                    <img class="x-icon" src="src/x-icon.png"></a>

                                <div class="xdescription">
                                    <div class="xwedge"></div>
                                    <div class="xtext">Drop Class</div>
                                </div>
                            </div>
                        </div>
						<?php }
    else { ?>
                        <div class="class-one" id="courseid_<?php echo $c?>" style="display: none;">
                            <a class="class-link1" href="javascript:void(0)" onclick="coursepagedisplay('<?php echo $sid?>','<?php echo $CT['cid']?>','<?php echo $uid?>','<?php echo $type?>')">
                                <div style="display: inline-block;" id="Div2">
                                    <img id="class-pic" src="src/class-pic.png" alt="Class Picture">
                                </div>
                                <h3 class="class-name"><?php
                            $coursetable="course_".$uid;
                            $cquery=$GLOBALS['pdo']->prepare("SELECT * FROM $coursetable WHERE `cid` = '{$CT['course_id']}' and `universityid`='{$CT['universityid']}'");
                            $cquery->execute();
                            $cresult = $cquery->fetch(PDO::FETCH_ASSOC);
                            echo $cresult['name'];
                            ?></h3>

                            </a>
                            <div class="professor">
							<?php
                        $pt="professor_".$uid;
                        $pquery=$GLOBALS['pdo']->prepare("SELECT * FROM $pt WHERE `profid` = '{$cresult['profid']}'");
                        $pquery->execute();
                        $presult = $pquery->fetch(PDO::FETCH_ASSOC);

                        ?>
                                <a id="professor-link1">
                                    <img id="professor-pic1" src="<?php $pic="/DEMO".$presult['location'].'/'.$presult['profilepic']; echo $pic?>"><p id="professor-name1"><?php
                                echo $presult['name'];
                        ?></p>
                                </a>
                            </div>

                            <div class="class-buttons">
                                <a class="drop-course" href="javascript:void(0)" onclick="dropcoursepara('<?php echo $CT['course_id'];?>','<?php echo 'course'?>','<?php echo $c?>')">
                                    <img class="x-icon" src="src/x-icon.png"></a>
                                <div class="xdescription">
                                    <div class="xwedge"></div>
                                    <div class="xtext">Drop Class</div>
                                </div>
                            </div>
                        </div>

						<?php }
    $c++;
    }?>
	<?php if($c>$csize){?>
                        <div id="cc-end"><a id="classmore" onclick="display('<?php echo $csize?>','<?php echo $c?>')" class="pastclasslink bluehref">see more</a></div>

						<?php }?>
                    </div>
					<?php }?>

                    <div id = "present-clubs">
                  <div id = "clubs-top">
                      <p id = "clubs-header">Clubs</p>
                      <?php if($_SESSION['id']==$sid) {?>
                      <a class = "edit-clubs" >
                          <img width=  "14px" id = "edit-icon-pic" src = "src/edit-icon.png"><p id = "btn-p-style">Edit</p>
                              </a>
                      
                      <a id = "done-edit-clubs" >
                          Done Editing
                      </a>
                      
                      <a id = "join-clubs">
                          <p id = "browse-clubs">Add Clubs</p>       
                      </a>
<?php }?>
                  </div>
                        <!--courseid is a unique id in any format, just similar to the tagid in calendar page, but should not have "=" symbol -->

						<?php
    if($type=="s")
    {
        // echo '<script type="text/javascript">alert ("In club S!!");</script>';
        $gtable="groups_student_".$uid;
        $gquery=$GLOBALS['pdo']->prepare("select * from $gtable where `studid`=$sid");
        $gquery->execute();
        if($gquery->rowCount()!=0)
        {
            $gtable="groups_student_".$uid;
            $gstatement="select * from $gtable where `studid`=$sid";
            $g=0;
            foreach($GLOBALS['pdo']->query($gstatement) as $GT)
            {
                
                ?>

                        <div class = "club-one" style="display:<?php if($g<$clubsize){echo 'block';} else {echo 'none';}?>" id="clubid_<?php echo $g?>">
                      <a class = "club-link1" herf="javescript:void()" onclick="clubpagedisplay('<?php echo $sid?>','<?php echo $GT['groupid']?>','<?php echo $uid;?>','<?php echo $type;?>')">
                          <div style = "display: inline-block;" id = "club-pic-container">
                              <img id = "club-pic"  src = "src/class-pic.png" alt = "Club Picture">
                          </div>
<h3 class = "club-name"><?php
    $gntable="groups_".$uid;
    $gnquery=$GLOBALS['pdo']->prepare("select * from $gntable where `groupid`='{$GT['groupid']}'");
    $gnquery->execute();
    $gresult=$gnquery->fetch(PDO::FETCH_ASSOC);
    echo $gresult['groupname'];?></h3>

                      </a>

                      
                      <div class = "club-buttons x-buttons">
                          <a class = "drop-course" href="javascript:void(0)" onclick="dropclubpara('<?php echo $GT['groupid'];?>','<?php echo 'club'?>','<?php echo $g?>')"><img class = "x-icon club-xicon" src = "src/x-icon.png"></a>
                          
                          <div class="xdescription"><div class="xwedge"></div><div class="xtext">Drop Club</div>
                          </div>
                      </div>
                  </div>
<?php
    $g++;}
    }?>
<?php if($g>$clubsize){?>

                        <div id="cc-end"><a id="clubmore" onclick="clubdisplay('<?php echo $clubsize?>','<?php echo $g?>')" class="pastclasslink bluehref">see more</a></div>
</div>
<?php }
    }
    ?>
                    <div class="drop-check">
                        <div id="drop-check-header">
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <div id="user-profile-bio">
            <div id="bio-header">
                <h3 id="bio-head-txt">Bio</h3>
                <h5 id="bio-email">Email:</h5>
                <p id="user-email" class="peditable"><?php if($type=="s") echo $mresult['email'];?></p>
                <input class="emailtext editingbio" placeholder="email address" />
                <!--<button class="edit-profile">Edit Bio</button>-->
            </div>
            <div class="peditable" id="bio-contents">
                <?php echo $mresult['studdesc'];?>
            </div>
            <div id="biotext">
                <textarea class="biotext editingbio" rows="1" id="studdesc"></textarea>
				<!-- <textarea id="studdesc1"><?php echo $mresult['studdesc'];?>
</textarea> -->
            </div>
            <div class="profile-bio-edit">
			<?php if($_SESSION['id']==$sid) {?>
                <!--<div class='real-edit-profile'>
                    <img class='edit-profile-button' src='src/edit-icon.png'>
                </div>-->
				<button class="edit-profile">Edit Bio</button><?php }?>
                <div id="linqs-section">
                    <p id="linq-term">links</p>
                    <h3 id="linq-number"><?php
                    //find how many people this student connect to
                    $sstable="student_student_1";
                    $ssquery=$GLOBALS['pdo']->prepare("select * from $sstable where `from_studid` = $sid");
                    $ssquery->execute();
                    $sptable="student_professor_1";
                    $spquery=$GLOBALS['pdo']->prepare("select * from $sptable where `from_studid`=$sid");
                    $spquery->execute();
                    echo $ssquery->rowCount()+$spquery->rowCount();
                    ?></h3>
                </div>
            </div>
        </div>

        <div id="user-profile-info">
            <div id="present-university">
                <div class="tile-top">
                    <p id="univ-header">School</p>
                </div>
                <div id="university-title">
                    <?php if($type=="s")
    {
        $unisearch=$GLOBALS['pdo']->prepare("select * from university where `uid`='{$mresult['univid']}'");
        $unisearch->execute();
        $uniresult = $unisearch->fetch(PDO::FETCH_ASSOC);
        echo $uniresult['uname'];
    }?>
                </div>
            </div>

            <div id="present-minor">
                <div class="tile-top">
                    <p id="tile-header">Major</p>
                </div>
                <div id="minor-title">
                    <?php if($type=="s")
    {
        echo $mresult['major'];
    }?>
                </div>
            </div>

            <div class="present-interestsfield">
			<?php $arr=explode(';',$mresult['interest']);
            $c=count($arr)-1;
            $ic=0;
            while($ic<$c)
            {
            ?>
                <div class="present-interests" style="background-color: #C0BAA1">
                    <div class="tile-top"></div>
                    <div class="i-name"><?php echo $arr[$ic]; ?></div>
                </div>
				<?php $ic++;}?>
            </div>

			<?php if($_SESSION['id']==$sid) {?>
            <div class='real-edit-profile'>
                <img class='edit-profile-button' src='src/edit-icon.png'/>
            </div>
			<?php }?>
        </div>
        <div class="editprofile">

            <div class="ed-head">
                <div>Your <span class="edtkeyword">Major</span></div>
            </div>

            <input type="text" class="editcolumn" id="editcolumn-i" placeholder="Major"></input>

            <div class="ed-head sub-ed-head">
                <div>Your <span class="edtkeyword">Interests</span></div>
                <span class="modinterests addinterests">+</span>
            </div>

            <div class="interestsfield">
                <div class='aninterest'>
                    <input type='text' class='editcolumn individual-interests' placeholder='Interests'></input><span class='modinterests mod-individual-interests'>-</span>
                </div>
            </div>

            <!--basic info edit, may move to other pages later-->
            <div class="ed-head sub-ed-head">
                <div><span class="edtkeyword">Basic Info</span></div>
            </div>
            <input type="text" class="editcolumn" id="editcolumn-n" placeholder="Name"></input>
            <input type="text" class="editcolumn" id="editcolumn-c" placeholder="Class Year"></input>


            <button type="button" class="pbuttons done-pedit" id="submitinfo">Done</button>
            <button class="pbuttons canceledit">Cancel</button>
        </div>

    </section>
    <section id="blackcanvas">
      <div class="dropconfirm"><img src="src/exit-btn.png" id="dexit"><div id="dtext">Are you sure you want to drop Computational Biology?</div><button id="confirm-d" class="dbuttons-can" onclick="dropcourse('<?php echo $sid?>','<?php echo $uid?>','<?php echo $type?>')">Drop</button><button id="confirm-c" class="dbuttons" value="0">Cancel</button>
      </div>
      </section>
</body>
</html>
