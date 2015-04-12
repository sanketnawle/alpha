<?php
    //header("charset=utf-8");
    date_default_timezone_set ('America/New_York');
    require_once 'connect.php';
    if(isset($_GET['cid'])&&isset($_GET['uid'])&&isset($_GET['sid'])&&isset($_GET['type']))
    {
    $cid=$_GET['cid'];
    $uid=$_GET['uid'];
    $sid=$_GET['sid'];
    $type=$_GET['type'];
    }
    $size=10;//number of files to show
   // $type="s";
   // $cid=1;
   // $uid=1;
   // $sid=1;
    //echo $id;
    //Find professor name
    $ftable="file_".$cid."_".$uid;
    $Uq=$GLOBALS['pdo']->query("select * from $ftable");
    $add['time']=date("Y-m-d H:i:s");
    //$UqR=$Uq->fetch(PDO::FETCH_ASSOC);
    //$name=$UqR['fname'].$UqR['lname'];
    /*===============Find email===================*/
    if($type=="s")
    {
        $etable="student_".$uid;
        $search=$GLOBALS['pdo']->prepare("select * from $etable where `studentid`=$sid");
        $search->execute();
        if($search->rowCount()!=0)
        {
            $sresult = $search->fetch(PDO::FETCH_ASSOC);
            $email=$sresult['email'];
        }
    }
    else if(type=="p")
    {
        $etable="professor_".$uid;
        $search=$GLOBALS['pdo']->prepare("select * from $etable where `profid`=$sid");
        $search->execute();
        if($search->rowCount()!=0)
        {
            $sresult = $search->fetch(PDO::FETCH_ASSOC);
            $email=$sresult['email'];
        }
        
    }
    else echo '<script type="text/javascript">alert ("Error");</script>';
    /*===============Find email end==============*/
    /*=============Find Priority=================*/
    if($type=="s")
    {
        $sct="student_courses_".$uid;
        $scq=$GLOBALS['pdo']->prepare("select * from $sct where `student_id`=$sid and `course_id`=$cid");
        $scq->execute();
        if($scq->rowCount()!=0)
        {
        
            $scqresult=$scq->fetch(PDO::FETCH_ASSOC);
            if ($scqresult['priority']==0)
                $priority=1;//Have joined this course, general users
            else if($scqresult['priority']==1)
                $priority=2; //TA
        }
        else {
            $priority=0; //Not joined
        
        }
    }
    else if($type=="p")
    {
        $pct="course";
        $pcq=$GLOBALS['pdo']->prepare("select * from $pct where `cid`=$cid");
        $pcq->execute();
        $pcresult=$pcq->fetch(PDO::FETCH_ASSOC);
        if($pcresult['profid']==$sid)
        {
            $priority=2;//Professor
        }
        else
        {
            $priority=3; //Professor, but not the instructor for this course
        }
        
    }
    /*=============End Find Priority=============*/
    
    function mkdirs($dir)
    {
        if(!file_exists($dir))
        {
            echo $dir;
            mkdir($dir,0777);
            
        }
        return true;
    }
    if($_GET['action']=='add')
    {
        /*============check/create table===========*/
        $che=$GLOBALS['pdo']->prepare("select * from $ftable");
        $che->execute();
        if($che->rowCount()==0)
        {
           
            $createt=$GLOBALS['pdo']->prepare("create table $ftable(fid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,filename VARCHAR(100) NOT NULL,filepath VARCHAR(200) NOT NULL,timestamp DATETIME NOT NULL,uploderid INT(11) NOT NULL,uploadertype VARCHAR(8) NOT NULL)");
            $createt->execute();
        }
        
        /*===============check/create table end========*/
        $name=$_POST['userfilename'].$add['time'];
        $username=$_POST['userfilename'];
        echo '<script type="text/javascript">alert ($_FILES["filename"]["name"]);</script>';
        $picroot="file_".$cid."_".$uid;
        $roott=$picroot.'/'.$name;
        //  $tp = array("image/gif","image/pjpeg","image/png","image/jpeg","image/JPG","image/jpg");
        //echo $_FILES["filename"]["type"];
        /* if(!in_array($_FILES["filename"]["type"],$tp))
         {
         echo "Please upload the right format picture!";
         exit;
         }
         else
         {
         */
        // $name=$_FILES["filename"]["name"];
        $filedir="/Users/zhujing/Sites/testproject/file_".$cid."_".$uid;
        mkdirs($filedir);
        
        // echo "name=".$name;
        $root="/Users/zhujing/Sites/testproject/file_".$cid."_".$uid;
        // echo $_FILES["filename"]["type"];
        if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
        {
            
           
            if(move_uploaded_file($_FILES["filename"]["tmp_name"],$root."/".$name))
            {
                $query=$GLOBALS['pdo']->prepare("insert into $ftable(`filename`,`filepath`,`timestamp`,`uploderid`,`uploadertype`) values('{$username}','{$roott}','{$add['time']}',$sid,'{$type}')");
                $query->execute();
                //	   echo $query;
                $searchfid=$GLOBALS['pdo']->prepare("select * from $ftable where `filename`='{$username}' and `timestamp`='{$add['time']}' and `uploderid`=$sid and `uploadertype`='{$type}' ");
                $searchfid->execute();
                //	   echo $query;
                if($query->rowCount()!=0 && $searchfid->rowCount()!=0)
                {
                    // echo '<script type="text/javascript">alert ("Find file!");</script>';
                    $qresult=$searchfid->fetch(PDO::FETCH_ASSOC);
                    // $qresult=$query->fetch(PDO::FETCH_ASSOC);
                    $addtable="course_question_".$cid."_".$uid;
                    // $add['time']=date("Y-m-d H:i:s");
                    
                    $addquery=$GLOBALS['pdo']->prepare("Insert into $addtable(`email`,`ques_desc`,`timestamp`,`fid`) values('{$email}','','{$add['time']}','{$qresult['fid']}')");
                    $addquery->execute();
                if($addquery->rowCount()!=0)
                {
                    
                     echo '<script type="text/javascript">alert ("Your document has been uploaded!");</script>';
                   // echo '<script type="text/javascript">alert ("Your document has been updated!");</script>';
                 //   echo "<script>location.href='cp_fl.php?cid=$cid&pid=$pid&sid=$sid&type=$type';</script>";
                }
                
                else
                {
                    echo '<script type="text/javascript">alert ("Fail to upload! Please try again!");</script>';
                   // echo "<script>location.href='cp_fl.php?cid=$cid&uid=$uid&sid=$sid&type=$type';</script>";
                }
                
                }
            }
        }
        else
        {
            echo  '<script>alert("Fail to upload!Please try again!");</script>';
         //   echo "<script>location.href='cp_fl.php?cid=$cid&uid=$uid&sid=$sid&type=$type';</script>";
        }
    }
    if($_GET['action']=='search')
    {
      // echo  '<script>alert("In search!");</script>';
        $key=$_GET['content'];
        $qtable="file_".$cid."_".$uid;
        $query=$GLOBALS['pdo']->prepare("SELECT * FROM $qtable where `filename` like '%{$_POST['searchbar']}%'");
        $query->execute();
    }
    else{
    $qtable="file_".$cid."_".$uid;
    $query=$GLOBALS['pdo']->prepare("SELECT * FROM $qtable");
    $query->execute();
    }
    //}
    
    
    ?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="../css/fl.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<script type="text/javascript" src="js/ajaxtabs.js"></script>
<script>
$(document).ready(function() {
        $(document).delegate(".docmain","mouseover",function(){
   $(this).find(".docicon").css({"opacity":"0.6"});
   $(this).find(".ifdiv").stop().fadeTo( 'fast', 0.85);
   });
$(document).delegate(".docmain","mouseout",function(){
   $(this).find(".docicon").css({"opacity":"1"});
   $(this).find(".ifdiv").stop().fadeTo( 'fast', 0);
   });

                  $(document).delegate(".rest_pst","click",function(){
                                       $(".here_pst").addClass("rest_pst");
                                       $(".here_pst").removeClass("here_pst");
                                       $(this).addClass("here_pst");
                                       $(this).removeClass("rest_pst");
                                       
                                       var wt= $("#wedge").offset().top;
                                       var ot= $("#outerwedge").offset().top;
                                       var l= $(".here_pst").offset().left-35;
                                       
                                       
                                       $("#wedge").offset({ top: wt, left: l });
                                       $("#outerwedge").offset({ top: ot, left: l });
                                       });
                  
                  $(document).delegate(".mimicbutton","mouseover",function(){
                                       $(this).css("background-color","#ddddda");
                                       });           
                  $(document).delegate(".mimicbutton","mouseout",function(){
                                       $(this).css("background-color","#e5e5e4");
                                       });  
                  
                  $(document).delegate(".pastclasslink","mouseover",function(){
                                       $("#pcwedge").css("opacity","0.7");
                                       });           
                  $(document).delegate(".pastclasslink","mouseout",function(){
                                   $("#pcwedge").css("opacity","1");
                                       }); 
                  
                  $(".evts").mouseover(function(){
                                       var tid= $(this).attr("id");
                                       var arr= tid.split("-");
                                       var nid= "w-"+arr[2]+"-"+arr[3];
                                       
                                       $("#"+nid).stop().fadeTo(250,1);
                                       
                                       }).mouseout(function() {
                                                   var tid= $(this).attr("id");
                                                   var arr= tid.split("-");
                                                   var nid= "w-"+arr[2]+"-"+arr[3];
                                                   
                                                   
                                                   if($("#"+nid).hasClass("checked")){
                                                   $("#"+nid).css("opacity",0.8);
                                                   }else{
                                                   
                                                   $("#"+nid).stop().fadeTo(200,0.6);
                                                    
                                                   }
                                                    });
                  
                  
                  $('.button-block button').on('click', function(){
                                               var $this = $(this).parent();
                                               var $a= $(this).parents(".wrapper");
                                               if($a.hasClass("checked")){
                                               $a.removeClass('checked');
                                               }else{
                                               $a.addClass('checked');
                                               }
                                               
                                               $this.toggleClass('canceled');
                                               return false;
                                               });   
              
                  $('.like').on('click', function(){
                                if($(this).hasClass("liked"))
                                {
                                $(this).removeClass("liked");
                                $(this).attr("src","src/like.png");
                                
                                return false;
                                }else{
                                $(this).toggleClass('liked');
                                $(this).attr("src","src/liked-button.png");
                                return false;
                                }
                                               }); 
                  
                  $('.download').on('click', function(){
                                if($(this).hasClass("downloaded"))
                                {
                                
                                return false;
                                }else{
                                $(this).toggleClass('downloaded');
                                $(this).attr("src","src/downloaded-button.png");
                                return false;
                                }
                                }); 
                  
                  var st= $("#sidebar").offset().left+$("#sidebar").outerWidth();
                  $("#main").offset({ left: st });
                  
                  $(window).on('resize', function(){
                               var st= $("#sidebar").offset().left+$("#sidebar").outerWidth();
                               $("#main").offset({ left: st });
                               
                               var st2= $("#panel-pi").offset().left;
                               
                               });
                  
                  $(document).delegate(".maintab","click",function(){
                                       $(".maintab").css({"border-bottom":"0","padding-top":"0px"});
                                       $(".maintab").removeClass("greyhref");
                                       $(".maintab").addClass("greyhref2");
                                       $(this).removeClass("greyhref2");
                                       $(this).addClass("greyhref");
                                       
                                       $(this).css({"border-bottom":"3px solid #70AC00","padding-top":"3px"});
                                       });                
});
</script>
</head>
<script type="text/javascript">
function displayfile(size,num){
    for (i=size+1;i<=num;i++)
    {
        var id="doc"+i;
        var target=document.getElementById(id);
        var targett=document.getElementById("loadmore");
        if (target.style.display=="none"){
            target.style.display="block";
            targett.value="View Less Files";
        } else {
            target.style.display="none";
            targett.value="View More Files";
        }
    }
}
var cid='<?php echo $cid; ?>';
var uid='<?php echo $uid; ?>';

function searchfile(sid,type)
{
    //alert("in!");
    var content=document.getElementById('searchbar').value;
    if(content=='')
    {
        alert("Please enter the search content");
        document.getElementById('searchbar').focus();
        return false;
    }
    location.href='cp_fl.php?action=search&content='+content+'&sid='+sid+'&type='+type+'&uid='+uid+'&cid='+cid;
    
}

function likefile(fid,qid,sid,type)
{
    var likeid=document.getElementById('hreplylike'+fid);
    // alert('likenum='+likeid.value);
    var addlike=likeid.value;
    addlike++;
    $(".fileliken"+fid).text(addlike);
    likeid.value=addlike;
   
    $.ajax({
           type: "POST",
           url: "savelikeposts.php",
           data: { qid: qid,cid:cid,uid:uid}
           })
    .done(function() {
          location.href='cp_fl.php?sid='+sid+'&type='+type+'&uid='+uid+'&cid='+cid;
          });
}
function test()
{
    alert("in test");
}
function deletefile(did,qid,sid,type)
{
   /* alert("in deletefile");
    alert("qid="+qid);
    alert("sid="+sid);
    alert("type="+type);*/
    var reply=document.getElementById('doc'+did);
    reply.style.display="none";
    
    $.ajax({
           type: "POST",
           url: "deletepost.php",
           data: { qid:qid,sid:sid,cid:cid,uid:uid,type:type}
           })
    
}
</script>
<div id="midsec">

    <div id="documents">
        <?php
        $scpt = "course_posts_" . $uid;
        $scpq = $GLOBALS['pdo']->prepare("select * from $scpt where `cid`=$cid");
        $scpq->execute();
        $showcount = 0;
//        echo'      href="download_file('.$filename.','.$fileytpe.')"';
        if ($scpq->rowCount() != 0 and $showcount < 50) {
            while ($scpqresult = $scpq->fetch(PDO::FETCH_ASSOC)) {                
                if ($scpqresult['filelocation'] != "") {
                    $filename = "Demo/uploaded/postfiles/".$scpqresult['filelocation'];
                    $fileytpe = "doc";
//                    $filetype = $scpqresult['file_ext'];                    
                    echo '<div class="docmain">            
                            <div class="iconframe">
                                <div class="ifdiv">
                                    <a href="'.$filename.'" onclick="test()" class="external-link" target="_blank">
                                        <img src="images/download-button.png" class="like filelike downloadfile">
                                    </a>
                                    <a href="Javascript:void(0)" >
                                        <img class="likepic" id="leclike-1" src="images/like-button.png">
                                    </a>
                                    <span class="likenum">10</span>
                                </div>
                                <a href="Javascript:void(0);" onclick="test()">
                                    <div class="docicon">
                                        <div class="circ">
                                            <img src="images/file_icons/docx_icon.jpg">
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="docdes">
                                '.$scpqresult['file_description'].'
                                <span class="f_date">04/07/2014</span> 
                            </div>
                          </div>';
                }
            }
        } 
//        href="download.php?filename='.$filename.'&filetype='.$fileytpe.')"
        ?>    
    <div id="docend"></div>
</div>

<div id="docend"></div>
</div>

</html>