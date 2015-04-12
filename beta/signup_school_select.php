<!DOCTYPE html> 
<?php
/*
This php is for if the user signs up with facebook 
Eventually this php should be removed from this page and moved to afteremail_register
Checking FBSignup email and validating it
also checking password here if the user wants to connect his fb to the already general registered account

*/ 
include_once("includes/common_functions.php");
include_once("php/dbconnection.php");
include_once("php/signup_functions.php"); 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//header("location:lp_beta.php");
include "php/dbconnection.php";
if(isset($_GET['professor'])){
  if(isset($_SESSION['professor'])){

  }else{
    header("location:lp_beta.php");
  }
}
if(isset($_POST['email'])){
       $_SESSION['email']=$_POST['email'];
       $value=$_POST['email'];
       if(strpos($value,'nyu.edu')==false){
             if(strpos($value,'poly.edu')){
                   $problem="please enter corresponding nyu.edu email";
                   header("location: FBSignup.php?problem=$problem");
                   die();
                   break 1; 
             }else if(strpos($value,'.edu')){
                    $problem="comming soon to your university";
                    header("location: lp_beta.php?problem=$problem");
                    die();
                    break 1; 
             }else{
                $problem="please enter  nyu email";
                   header("location: FBSignup.php?problem=$problem");
                   die();
                   break 1;
             }     
      }
         $query=$con->query("SELECT user_id,status,user_type,univ_id,dept_id FROM user WHERE user_email='$value'");
            if($query->num_rows==0){
              $_SESSION['refresh']=1;
            }
                if($query->num_rows>0){
                          while($row=$query->fetch_array(MYSQLI_ASSOC)){
                              $user_id=$row['user_id'];
                              $status=$row['status'];
                              $user_type=$row['user_type'];
                              $_SESSION['status']=$status;
                              $_SESSION['user_id']=$user_id;
                              $univ_id=$row['univ_id'];
                              $dept_id=$row['dept_id'];
                              $_SESSION['refresh']=1;
                          }
                }           
                if($status==='invited'){
                    
                }else if($status==='temp' && $user_type=='s'){ 
                    header("location:lp_beta.php?problem=9");
                }else if($status==='active' && $user_type=='s'){
                    header("location:FBSignup.php?pass=1");
                }else if($status=='temp' && $user_type=="p"){
                  session_destroy();    
                }
}else if($_POST['password']){
   $_SESSION['refresh']=1;
   $user_id=$_SESSION['user_id'];     
   $password=input_sanitize($_POST['password'],$con);
   $query=$con->query("SELECT * FROM user_login WHERE user_id='$user_id'");
                     if(!$query){
                     }else if($query->num_rows===0){
                           session_destroy();
                             header("location:signin_error.php");
                     }else{
                            while($row=$query->fetch_array()){
                                  $dbpassword=$row['password'];
                                  $salt=$row['salt']; 
                            }
                            
                            $hash=password($password,$salt);
                            if($hash==$dbpassword){
                                $fbid=$_SESSION['id'];
                                $fbemail=$_SESSION['fbemail'];
                              $query=$con->query("INSERT INTO user_auth_provider(user_id,auth_key,auth_provider,fb_email) 
                                      values($user_id,'$fbid','facebook','$fbemail')");
                              $time=time();
                                setcookie('user_id',$user_id,$time+100000,'/');
                                $url="location:php/setsession.php";
                                header($url);
                            }else{
                              session_destroy();
                              session_start();
                                $_SESSION['forgot']='yes';
                               header("location:signin_error.php");
                            }
                    }   


}
if(isset($_SESSION['refresh'])){

}else{
  header("location:lp_beta.php?session=1");
}
?>
<html>
<head>  
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<?php
if(isset($_SESSION['refresh'])){

}else{
  //echo '<META http-equiv="refresh" content="0;URL=https://www.urlinq.com/beta/lp_beta.php?session=1">';
}
$_SESSION['refresh'] = false;
unset($_SESSION['refresh']);
?>

<link rel = "stylesheet" type = "text/css" href = "signupOnboarding.css"> 
<link rel = "stylesheet" type = "text/css" href = "commonStyles.css"> 
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic' rel='stylesheet' type='text/css'>

<link rel = "stylesheet" type = "text/css" href = "leftmenu.css"><link rel="stylesheet" type="text/css" href="planner.css">

<link rel="stylesheet" type="text/css" href="datepicker.css">

<link rel="stylesheet" type="text/css" href="css/waiting_animation.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>
<link href='https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,800,700,600,300' rel='stylesheet' type='text/css'>

  <script src="signupOnboarding.js"></script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>


<script>
$(document).ready(function() {

var university_id = "";
$(".signupFormNext").append("<div class = 'loadingAnimationWrapper'><img class = 'modal_animation' src = 'src/signUpLoadingAnimation.gif'></img></div>");

  //window.onbeforeunload = function() {
        //return "You will loose progress if you reload or close the page";
    //}

  var professor=0;
  
  professor=<?php if(isset($_GET['professor'])) echo $_GET['professor']; else echo 0; ?>;
        if(professor==0){               
			  loadSchoolList(1000);
         }else if(professor==1){
               $.ajax({  
                      type: "POST", 
                      url: "signup_typepart_select_pro.php",
                      success: function(html) {
                         $(".signupFormNext").html(html);  
                         $(".signupFormNext").addclass('signupFormNextStep2');   
                      }
              });

         }      

  /*var anim=$('.loadingAnimationWrapper').clone();
   var school=$('.schoolsSignUpList').clone();*/
   
  function loadSchoolList(delay){ 
  $('.ui-progress').find('li.1').removeClass("canNavigate"); //css("cursor","default");
	$('.ui-progress').find('li.2').removeClass("canNavigate");
	$('.ui-progress').find('li.3').removeClass("canNavigate");
	$('.nextBtn').text("Finish");
	$('.nextBtn').addClass("disabled");
    $("signupFormNext").css("overflow-y", "auto");
	$.ajax({  
                      type: "POST", 
                      url: "signup_schoolpart_select.php",
                      success: function(html) {
                         $(".signupFormNext").append(html);	
						 $(".schoolsSignUpList").css("opacity",0);
						 
						 var imagesLoaded = 0;
						 var totalimages = $('.SignUpItem .loadtest').length;
					     var treshhold = 4;
					     if( totalimages < treshhold){
							treshhold = totalimages;
					     }		
						 $('.SignUpItem .loadtest').each(function(i){
							$(this).on("load",function(){
								var imgId = $(this).attr("id");
								if( totalimages >= 4 ){
									if( imgId == "schImgLoadTest0"  ||
										imgId == "schImgLoadTest1"  ||
										imgId == "schImgLoadTest2"  ||
										imgId == "schImgLoadTest3" ){
											imagesLoaded++;
									}
								}else{
									imagesLoaded++;
								}
								if(imagesLoaded == treshhold)
								{	
																	
									//
									setTimeout(function(){
									$(".loadingAnimationWrapper").hide("slow");	
									$(".schoolsSignUpList").css("opacity",1);
									$('.SignUpItem').each(function(i) {
											var $li = $(this);
											setTimeout(function() {
												$li.addClass('displayed');
											},i*220); // delay 250 ms
									});
									
									},delay);
									
									imagesLoaded = -1;
								}
							});
						 });			
										
                         //alert(hi);
                        
                      }
              });
  };

  $(document).click(function(event){

      var $target= $(event.target);
      var $container= $(".signup_anchor");
      if(!$container.is($target)&&($container.has($target).length===0)){
        $(".signup_past_dropdown").hide();
      }

  });

  $(document).delegate(".proceed-to-confirm","click",function(){
  if($(this).hasClass("disabled")){
	return;
  }
    var $ref = $(this);
        var formData = new FormData($ref.closest(".signUpMain_1").find(".user_upload_photo_box").find("form")[0]);
    $(".signUpMain_fader").fadeOut(600);
    $.ajax({
            type: "POST",
            url: "php/afterselect.php",
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Check if upload property exists
                    myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },

            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (html) {
                //alert("s");

            },
            error: function (html) {
                //alert(html);
            }
        });



    setTimeout(
    function(){   
    $(".signUpMain_emailconfirm").show();
    },
    600)
		
    setTimeout(
    function(){   
    $(".signUpMain_emailconfirm").addClass("displayed");
    },
    700)

  });

  $(document).delegate(".signup_anchor","click",function(event){
      //$(".signup_past_dropdown").hide();
      //$(this).find(".signup_past_dropdown").show();			  
			  $(".signupFormNext").css("opacity",1);
              $(".search-signup-lists").val("");
              if($(this).hasClass('SignUpPart2SchoolChosen')){
				$(".signupFormNext").removeClass("signupFormNextStep2");
                $('#SignupStepHeader').html("Welcome to Urlinq's academic network at <span>NYU</span>");
                $('#SignupStepSubHeader').html("First, click on the school or college you attend below.");
				$(".SignUpProgressTracker").hide();
				$(".loadingAnimationWrapper").show();
				$(".signupFormNext").empty();
                $(".signupFormNext").append("<div class = 'loadingAnimationWrapper'><img class = 'modal_animation' src = 'src/signUpLoadingAnimation.gif'></img></div>");
                 
                    /*$.ajax({  
                                    type: "POST",  
                                    url: "signup_schoolpart_select.php",
                                    success: function(html) {
                                       $(".signupFormNext").html(html);  
                                       $(".signupFormNext").show();
                                            setTimeout(
                                                  function(){
                                                      $(".loadingAnimationWrapper").fadeOut(500);
                                                },
                                                250);                                       
                                       
              setTimeout(
                function(){
                    $('.SignUpItem2').each(function(i) {
                      var $li = $(this);
                      setTimeout(function() {
                        $li.addClass('displayed');
                      }, i*220); // delay 250 ms
                    });
                    $(".search-signup-container").fadeIn(600);
					
					


     
              },
              250);
                                  
                                }
                    })*/
                    $(".nextBtn").text("Finish");
                    $('.ui-progress').find('li.1').removeClass('active');
                    $('.ui-progress').find('li.2').removeClass('active');
                    $('.ui-progress').find('li.3').removeClass('active');
                    $('.ui-progress').find('li.1').removeClass('inactive').addClass('active');
					$('.search-signup-container').show();					
                    $('.search-signup-lists').attr("placeholder","Search for your school");
					loadSchoolList(1000);
                      }else if($(this).hasClass('SignUpPart3DepartmentChosen')){
					  $(".search-signup-lists").val("");
					  $(".SignUpProgressTracker").animate({opacity : 0},400);
					  loadDptList(university_id);
					  
					  
					  /*$(".SignUpProgressTracker").show();
              $('#SignupStepHeader').html("There are many subjects to study at your School");
                $('#SignupStepSubHeader').html("Below, click the department of your major or grad program.");
              var univ_id=$('.signup_choosen_item_inner_univ').attr('id');
                                  $.ajax({  
                        type: "POST", 
                        data:{univ_id:univ_id}, 
                        url: "signup_departmentpart_select.php",
                        success: function(html) {
                           $(".signupFormNextStep2").html(html);  
                           $(".signupFormNextStep2").show();
                                            setTimeout(
                                                  function(){
                                                      $(".loadingAnimationWrapper").fadeOut(500);
                                                },
                                                250);                           

      
      setTimeout(
        function(){
            $('.SignUpItem2').each(function(i) {
              var $li = $(this);
              setTimeout(function() {
                $li.addClass('displayed');
              }, i*220); // delay 250 ms
            });
            $(".search-signup-container").fadeIn(600);


      },
      250);
                          
                        }
            });

      $.ajax({
                             type:"post",
                             url:"get_count_dept_signup.php",
                             data:{univ_id:univ_id},
                             datatype:"json",
                             success: function(data){
                                     var dept_count=data[0].dept_count;
                                      var dept_message="There are "+dept_count+" departments";
                                      $('.SignupPart2Message').html(dept_message);
                                            setTimeout(
                                                  function(){
                                                      $(".loadingAnimationWrapper").fadeOut(500);
                                                },
                                                250);

                             },
                             error:function(data){
                              //alert("error");
                             } 
                     });  
            $(".nextBtn").text("Next");*/
            $('.ui-progress').find('li.1').removeClass('active');
            $('.ui-progress').find('li.2').removeClass('active');
            $('.ui-progress').find('li.3').removeClass('active');
            $('.ui-progress').find('li.2').removeClass('inactive').addClass('active');
            $('.search-signup-lists').attr("placeholder","Search for your department");
            }

            

        
  });

    $(document).delegate(".resend","click",function(){
      //alert("your email has been resend");
      $.ajax({
            type:"post",
            url:"php/afterselect.php",
            data:{resend:"yes"},
              success: function(response) {
              },
              error:function(response){
              }
      });
    });
  $(document).delegate(".signup_change_item","click",function(){
    if(!$(this).hasClass("signup_change_chosen_item")&& $(this).hasClass("signup_change_item_univ")){
    var univ_id=$(this).find('.signup_unchoosen_item_inner_univ').attr('id');
    var selected_univ_id=$('.signup_choosen_item_inner_univ').attr('id');
    $('.signup_choosen_item_inner_univ').attr('id',univ_id);
    $(this).find('.signup_unchoosen_item_inner_univ').attr('id',selected_univ_id);
    $.ajax({
                           type:"post",
                           url:"php/signup_functions.php",
                           data:{univ_id:univ_id},
                           success: function(data){
                                   $("#schoolimage").attr("src",data);
                           },
                           error:function(data){
                            console.log("error");
                           } 
                   });
    if ($('.SignUpStep3Wrapper').is(':visible')) {
    } else {
      $.ajax({  
                      type: "POST", 
                      data:{univ_id:univ_id}, 
                      url: "signup_departmentpart_select.php",
                      success: function(html) {
                         $(".signupFormNextStep2").html(html);  
                         $(".signupFormNextStep2").show();

    /*show up animation*/
    setTimeout(
      function(){
          $('.SignUpItem2').each(function(i) {
            var $li = $(this);
            setTimeout(function() {
              $li.addClass('displayed');
            }, i*220); // delay 250 ms
          });
          $(".search-signup-container").fadeIn(600);


    },
    250);
                        
                      }
          });

    }
    
     $.ajax({
                           type:"post",
                           url:"get_count_dept_signup.php",
                           data:{univ_id:univ_id},
                           datatype:"json",
                           success: function(data){
                                   var dept_count=data[0].dept_count;
                                    var dept_message="There are "+dept_count+" departments";
                                    $('.SignupPart2Message').html(dept_message);

                           },
                           error:function(data){
//alert("error");
                           } 
                   });
      $.ajax({
                           type:"post",
                           url:"get_dept_list_signup.php",
                           data:{univ_id:univ_id},
                           datatype:"json",
                           success: function(data){
                            
                            
                         
                               $('.signup_change_chosen_wrap_dept').empty();
                              
                              for(var obj in data){
                                     if(obj==0){
                                                 $('.signup_change_chosen_wrap_dept').html('<div class = "signup_change_chosen_item signup_change_chosen_item_dept signup_change_item"><em></em><div class="signup_dept_choosen_item_inner"></div>');
                                       $('.signup_dept_choosen_item_inner').html(data[obj].dept_name);
                                       $('.signup_dept_choosen_item_inner').attr('id',data[obj].dept_id);
                                    }else{
                                        $('.signup_change_chosen_wrap_dept').append('<div class = "signup_change_item signup_change_item_dept"><div class="signup_dept_unchoosen_item_inner" id="'+data[obj].dept_id+'">'+data[obj].dept_name+'</div></div>');
                                    }
                         } 

                                   
                           },
                           error:function(data){
                            //alert("error");
                           } 
                   });

      
    var txt=$(this).find("div").text().trim();
    var txt2=$(this).closest(".signup_past_dropdown").find(".signup_change_chosen_item").find("div").text().trim();
    $(this).find("div").text(txt2);
    $(this).closest(".signup_past_dropdown").find(".signup_change_chosen_item").find("div").text(txt);


    }else if(!$(this).hasClass("signup_change_chosen_item") && $(this).hasClass("signup_change_item_dept")){
      var dept_id=$(this).find('.signup_dept_unchoosen_item_inner').attr('id');
        //alert(dept_id+ "unchoosen dept_id");  
        var selected_dept_id=$('.signup_dept_choosen_item_inner').attr('id');
       // alert(selected_dept_id+"present shit");
        $('.signup_dept_choosen_item_inner').attr('id',dept_id);
        $(this).find('.signup_dept_unchoosen_item_inner').attr('id',selected_dept_id);
        $.ajax({
                           type:"post",
                           url:"php/signup_functions.php",
                           data:{dept_id:dept_id},
                           success: function(data){
                                   $("#deptimage").attr("src",data);
                           },
                           error:function(data){
                            console.log("error");
                           } 
                   });
        $.ajax({

                           type:"post",
                           url:"get_count_members_signup.php",
                           data:{dept_id:dept_id},
                           datatype:"json",
                           success: function(data){
                                  if(data.length==1){
                                     var prof_count=data[0].member_count;
                                      var member_message="Your department has "+prof_count+" faculty";
                                  }else if(data.length==2){
                                    var prof_count=data[0].member_count;
                                   var student_count=data[1].member_count;
                                   var member_message="Your department has "+prof_count+" faculty and "+student_count+" students"; 
                                  }else{
                                     var member_message="You are the first student to sign up from your department";
                                  } 
                                  $('.SignupPart2Message').text(member_message);

                           },
                           error:function(data){
                            //alert("error");
                           } 
                   });
            var txt=$(this).find("div").text().trim();
        var txt2=$(this).closest(".signup_past_dropdown").find(".signup_change_chosen_item").find("div").text().trim();
        $(this).find("div").text(txt2);
        $(this).closest(".signup_past_dropdown").find(".signup_change_chosen_item").find("div").text(txt);
    }

  });

  $(document).delegate("#classyear-select","change",function(){
    var yval=$(this).val();
    //alert(yval);
    if(yval!="-1"){
      $(".nextBtn").removeClass("disabled");
      $(".nextBtn").addClass("proceed-to-confirm");
      $(".SignUpStep3-sec-last").css("pointer-events","all");
      $(".SignUpStep3-sec-last").addClass("displayed");
    }
    else{
      $(".nextBtn").addClass("disabled");
    }
    $.ajax({
      type:"post",
      url:"getdegree.php",
      data:{year:yval}

    });
  
    
  });
  

    $(document).delegate(".upload_photo_box","click",function(){
        //$(this).addClass("upload_photo_box_uploaded");
        //$(this).find(".photo_upload_text").text("Photo Uploaded");
        $(this).closest(".SignUpStep3-sec-last").find(".user_upload_photo_box_input").click();
    });

    $(document).delegate(".user_upload_photo_box_input","change",function(){

      //append animation
      $(this).closest(".user_upload_photo_box").css({"background-image":"none"});
      $(this).closest(".user_upload_photo_box").append("<img class='waiting_animation_circletype waiting_animation_circletype_sz55' src='img/waiting_animation_circletype.GIF'>");
      //append animation end
      var $ref = $(this);
      var formData = new FormData($ref.closest("form")[0]);
          var editing= "show";
          formData.append("editing", editing);

          //$ref.closest(".SignUpStep3-sec-last").find(".user_upload_photo_box")
        $.ajax({
            type: "POST",
            url: "php/edit_class_pictures.php",
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Check if upload property exists
                    myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },

            data: formData,
            contentType: false,
            processData: false,
            success: function (html) {

            $ref.closest(".user_upload_photo_box").find(".waiting_animation_circletype").remove();
            $ref.closest(".SignUpStep3-sec-last").find(".user_upload_photo_box").css({"background-image": "url(" + html + ")"});


            },
            error: function (html) {
                //alert(html);
            }
        });

    });

    /*progress function for ajax*/
    function progressHandlingFunction(e) {
        if (e.lengthComputable) {
            $('progress').attr({value: e.loaded, max: e.total});
        }
    }

  $(document).delegate(".account-type","click",function(){
    if($(this).hasClass("undergraduate")){
      //alert("hi");
      $(".graduate").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#undergrad").prop("checked", true);
      $("#grad").prop("checked", false);
      var type =$(this).find('.typecheck').attr('id');
    }
    if($(this).hasClass("graduate")){
      $(".undergraduate").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#grad").prop("checked", true);
      $("#undergrad").prop("checked", false);
      var type =$(this).find('.typecheck').attr('id');        
    }
    if($(this).hasClass("male")){
      $(".female").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#male").prop("checked", true);
      $("#female").prop("checked", false);
      var gender ='M';
    }
    if($(this).hasClass("female")){
      $(".male").removeClass("account-type-chosen");
      $(this).addClass("account-type-chosen");
      $("#female").prop("checked", true);
      $("#male").prop("checked", false);
      var gender ='F';        
    }
    if(gender=='M'||gender=='F'){
      //alert("ajax call to gender");
        $.ajax({
          type:"post",
          url:"getdegree.php",
          data:{gender:gender}

        });
        }else{
          $.ajax({
          type:"post",
          url:"getdegree.php",
          data:{type:type}

        });
        }
    
  });

    $(document).delegate('input[name="gender"]','click',function(){ 
        var gender=$(this).val();
        $.ajax({
      type:"post",
      url:"getdegree.php",
      data:{gender:gender}

    });
    });
  $(document).delegate(".deptJoin","click",function(){
  
	$(".signupFormNextStep2").css("overflow-y","hidden");
    $(".search-signup-lists").val("");
    var dept_id=$(this).attr('id').replace(/[^\d.]/g, '');
    $(".loadingAnimationWrapper").fadeIn(); 
    var univ_id=$(this).find('.joinBtn').attr('id').replace(/[^\d.]/g, '');
    $(".search-signup-container").fadeOut(600);
    $(this).css("pointer-events","none");
    $(".nextBtn").text("Finish");
    $(".SignUpProgressTracker").animate({opacity:0},200);
    $(this).find(".joinBtn").text("Joined");

    $('#SignupStepHeader').fadeOut(600, function() {
            $('#SignupStepHeader').text("Connect with the right people in your department").fadeIn(600);
        });
    $('#SignupStepSubHeader').fadeOut(600, function() {
            $('#SignupStepSubHeader').text('Lastly, fill in your class year and academic standing').fadeIn(600);
        });
     $.ajax({
                           type:"post",
                           url:"php/signup_functions.php",
                           data:{dept_id:dept_id},
                           success: function(data){
                                   $("#deptimage").attr("src",data);
                           },
                           error:function(data){
                            console.log("error");
                           } 
                   });
             $.ajax({
                           type:"post",
                           url:"get_count_members_signup.php",
                           data:{univ_id:univ_id,dept_id:dept_id},
                           datatype:"json",
                           success: function(data){
                                   if(data.length==1){
                                     var prof_count=data[0].member_count;
                                      var member_message="Your department has "+prof_count+" faculty";
                                  }else if(data.length==2){
                                    var prof_count=data[0].member_count;
                                   var student_count=data[1].member_count;
                                   var member_message="Your department has "+prof_count+" faculty and "+student_count+" students"; 
                                  }else{
                                     var member_message="You are the first student to sign up from your department";
                                  } 
                                  $('.SignupPart2Message').text(member_message);

                           },
                           error:function(data){
                            //alert("error");
                           } 
                   });
           $.ajax({
                           type:"post",
                           url:"get_dept_list_signup.php",
                           data:{univ_id:univ_id},
                           datatype:"json",
                           success: function(data){
                              for(var obj in data){
                                     if(dept_id== data[obj].dept_id){
                                       $('.signup_dept_choosen_item_inner').html(data[obj].dept_name);
                                       $('.signup_dept_choosen_item_inner').attr('id',data[obj].dept_id);
                                    }else{
                                        $('.signup_change_chosen_wrap_dept').append('<div class = "signup_change_item signup_change_item_dept"><div class="signup_dept_unchoosen_item_inner" id="'+data[obj].dept_id+'">'+data[obj].dept_name+'</div></div>');
                                    }
                         }            
                                   
                           },
                           error:function(data){
                            //alert("error");
                           } 
                   });
          

    
    setTimeout(
    function(){
    $(SignUpDeptItemChosen).addClass("slideUpChosen");
    },
    450)

    var SignUpDeptItemChosen = $(this);
    $(this).removeClass("unchosen2");
    setTimeout(
    function(){
      $(".SignUpProgressTracker").css("bottom","6px");
      $(".SignUpProgressTracker").addClass("SignUpProgressTrackerPart3");
      $(".SignUpPart2SchoolChosen").addClass("SignUpPart2SchoolChosenSmall");
      $(".SignUpPart3DepartmentChosen").css("display","inline-block");
      

      
        
        $(".ui-progress").find("li.2").removeClass("active");
        $(".ui-progress").find("li.3").removeClass("inactive").addClass("active");
        

    },
    500)



    setTimeout(
    function(){
    $(".loadingAnimationWrapper").fadeOut();
    },
    1750)

    setTimeout(
    function(){
      //need flag
      $(".departmentSignUpList").hide();
      $(".deptJoin").hide();
       $.ajax({  
                  type: "POST", 
                  data:{univ_id:univ_id,dept_id:dept_id}, 
                  url: "signup_typepart_select.php",
                  success: function(html) {

                     $(".signupFormNextStep2").append(html);
                     //alert(html);
                     //alert($(".signupFormNextStep2").html());
                  }
            });
      $(".SignUpStep3Wrapper").show();

    },
    1550)



    setTimeout(
      function(){
          $(".SignUpProgressTracker").animate({opacity:1},400);
          $('.SignUpStep3-sec').each(function(i) {
            var $li = $(this);
            setTimeout(function() {
              $li.addClass('displayed');
            }, i*220); // delay 250 ms
          });



    },
    2150)
     

    setTimeout(
      function(){

      $(".unchosen2").addClass("slideLeft");
    },
    100)


  });

  
  $(document).delegate(".schoolJoin","click",function(){
    $(".search-signup-lists").val("");
    $(this).find(".joinBtn").text("Joined");
    $(this).css("pointer-events","none");
    var SignUpItemChosen = $(this);
    $(this).removeClass("unchosen");
    $(this).addClass("flag"); 
	$(".unchosen").addClass("slideLeft");
	$(SignUpItemChosen).addClass("slideUpChosen");
	university_id = $(this).attr("id");
	
	
        
	loadDptList(university_id); 


   /* setTimeout(
      function(){
    $(".SignUpProgressTracker").show();
    $(".SignUpProgressTracker").animate({opacity:1},500);
        },
        1500)*/
    /*setTimeout(
    function(){
    $(".loadingAnimationWrapper").fadeOut();
    },
    1000)*/
    /*setTimeout(
      function(){
          $('.SignUpItem2').each(function(i) {
            var $li = $(this);
            setTimeout(function() {
              $li.addClass('displayed');
            }, i*220); // delay 250 ms
          });
          $(".search-signup-container").fadeIn(600);


    },
    1500)*/


    /*setTimeout(
      function(){
        $(".schoolJoin").hide();
        $(".schoolsSignUpList").hide();
      },
      1450)*/
  });

  /**
  
  $(".niceScroller").scroll(function(){
    if(($('.topListItem').offset().top) <= 148){
      $(".signUp_header").addClass("ScrollDownShadow");
    }
    else{
      $(".signUp_header").removeClass("ScrollDownShadow");
    }

  });

  **/

function loadDptList(univ_id_raw, delay){
$('.nextBtn').text("Finish");
$('.nextBtn').addClass("disabled");
$("signupFormNext").css("overflow-y", "auto");
univ_id = univ_id_raw.replace(/[^\d.]/g, "");
$.ajax({
                           type:"post",
                           url:"php/signup_functions.php",
                           data:{univ_id:univ_id},
                           success: function(data){
                                   $("#schoolimage").attr("src",data);
                           },
                           error:function(data){
                            console.log("error");
                           } 
                   });
          
                 <?php 
                    $university_array=array();
                    $result = $con->query("SELECT univ_name,univ_id
                                           FROM university 
                                           WHERE parent_univ_id=1");
                   while ($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                                  if(univ_id== <?php echo $row['univ_id']; ?>){
                                    <?php $univ_id_selected=$row['univ_id']; ?>
                                    var univ_name="<?php echo $row['univ_name']; ?>";
                                    $('.signup_choosen_item_inner_univ').html(univ_name);
                                    $('.signup_choosen_item_inner_univ').attr('id',univ_id);
                                  }else{
                                    var univ_name="<?php echo $row['univ_name']; ?>";
                                    var univ_id_other=<?php echo $row['univ_id']; ?>;
                                    $('.signup_change_chosen_wrap_univ').append('<div class = "signup_change_item signup_change_item_univ"><div class="signup_unchoosen_item_inner_univ" id="'+univ_id_other+'">'+univ_name+'</div></div>');
                                  }
                                  
                       <?php }    
                   ?> 
                   
                   $.ajax({
                           type:"post",
                           url:"get_count_dept_signup.php",
                           data:{univ_id:univ_id},
                           datatype:"json",
                           success: function(data){
                                   var dept_count=data[0].dept_count;
                                    var dept_message="There are "+dept_count+" departments";
                                    $('.SignupPart2Message').html(dept_message);

                           },
                           error:function(data){
                            //alert("error");
                           } 
                   });
                    
                    



    var sh='There are many subjects to study at your School';
    var ssh='Below, click the department of your major or grad program.';       

    if(univ_id_raw == 'university1'){
      sh="Connect with the right people in your department";
      ssh='Lastly, fill in your class year and academic standing';
    }
	
	$('#SignupStepHeader').fadeOut(500, function() {
            $(this).text(sh).fadeIn(500);
    });
    $('#SignupStepSubHeader').fadeOut(500, function() {
            $(this).text(ssh).fadeIn(500);
    }); 
        
    $('.search-signup-lists').delay(500).attr("placeholder","Search for your department");
    
	
	
	
	
	
	
	setTimeout(function(){
	$(".signUp_header").addClass("signUp_headerStep2");
	$(".SignUpProgressTracker").css("opacity",0);
	$('.SignUpProgressTracker .SignUpPart3DepartmentChosen').css("display","none");
	$(".SignUpProgressTracker").show(400);
	$(".signupFormNext").empty();
	$(".signupFormNext").append("<div class = 'loadingAnimationWrapper'><img class = 'modal_animation' src = 'src/signUpLoadingAnimation.gif'></img></div>");	
	},600);
    
    if(univ_id_raw == 'university11'){
	$(".ui-progress").find("li.1").removeClass("active");
    $(".ui-progress").find("li.2").removeClass("inactive").addClass("active");
	$('.ui-progress').find('li.1').addClass("canNavigate");
	$('.ui-progress').find('li.2').addClass("canNavigate");;
	$('.ui-progress').find('li.3').removeClass("canNavigate");//("cursor","default");
    setTimeout(
      function(){
        
                $.ajax({  
                    type: "POST", 
                    data:{univ_id:univ_id}, 
                    url: "signup_departmentpart_select.php",
                    success: function(html) {
					   setTimeout(function(){
						$(".SignUpProgressTracker").animate({opacity:1},850);
						$(".signupFormNext").addClass("signupFormNextStep2");
						$(".signupFormNextStep2").append(html);
						$(".departmentSignUpList").css("opacity",0); 
					   
					   var imagesLoaded = 0;
					   var totalimages = $('.SignUpItem2 .loadtest').length;
					   var treshhold = 3;
					   if( totalimages < treshhold){
							treshhold = totalimages;
					   }			   
					   
					   $('.SignUpItem2 .loadtest').each(function(i){
							$(this).load(function(){
								var imgId = $(this).attr("id");
								if( totalimages >= 3 ){
									if( imgId == "imgLoadTest1"  ||
										imgId == "imgLoadTest2"  ||
										imgId == "imgLoadTest3" ){
											imagesLoaded++;
									}
								}else{
									imagesLoaded++;
								}
								if(imagesLoaded == treshhold)
								{	
									setTimeout(function(){
									$(".loadingAnimationWrapper").hide("slow");
									$(".departmentSignUpList").css("opacity",1);
									$('.SignUpItem2').each(function(i) {
										var $li = $(this);
										setTimeout(function() {
											$li.addClass('displayed');
										},i*220); // delay 250 ms
									});
									},0);
									imagesLoaded = -1;
								}
							});
					   });
					   
					   $(".search-signup-container").fadeIn(600);
					   
                    
				 },600);
				}
               });
      },
	0);}
	else{
      //alert(univ_id)
	  $(".ui-progress").find("li.1").removeClass("active");
	  $(".ui-progress").find("li.2").addClass("inactive");
	  $('.ui-progress').find('li.1').addClass("canNavigate");
	  $('.ui-progress').find('li.2').removeClass("canNavigate");;
	  $('.ui-progress').find('li.3').removeClass("canNavigate");//("cursor","default");
      $(".signupFormNext").addClass("signupFormNextStep2");



       $(".loadingAnimationWrapper").fadeOut();


        $(".schoolJoin").hide();
        $(".schoolsSignUpList").hide();


      $(".dummy_sack").find(".joinBtn").attr("id","department"+univ_id);
      //alert("sad");
      $(".dummy_sack").find(".deptJoin").click();
  }
};


  $(".blackBackground").delay(600).fadeIn(500);
  
    setTimeout(
    function(){          
          
          setTimeout(
            function(){
          
        },
        0)
      },
      0);

    setTimeout(
    function(){
      $(".niceScroller").css("overflow-y","scroll");
      $(".info").css("cursor","pointer");
      },
      1850)   

  $(document).delegate(".ui-progress.round li","click",function(event){
	if($(this).hasClass('1') && !$(this).hasClass('active')){
		$( ".signup_anchor.SignUpPart2SchoolChosen" ).trigger( "click" );
	}
	
	if($(this).hasClass('2') && 
	   !$(this).hasClass('inactive') && 
	   !$(this).hasClass('active') && 
	   !$('.ui-progress .1').hasClass("active") &&
	   university_id == "university11"
	   ){
		$( ".signup_anchor.SignUpPart3DepartmentChosen" ).trigger( "click" );
	}
  });

});

function ItemSlide(index, interval) {
    var buttons = $('.SignUpItem'),
        buttons_length = buttons.length;
    var button = buttons.eq(index % buttons_length);
    button.addClass('displayed');
    setTimeout(function() {
        ItemSlide(++index, interval);
    }, interval)
}
</script>
</head>
<body>
  <div class = "blackBackground">
    <div class = "logo_wrapper">
      <img class = "logo" src = "src/logo.png">
    </div>


    <!--this div is the place for way around 2step for schools other than poly-->
    <div class='dummy_sack' style='display:none;'>
              <div class = "department unchosen2 listItem deptJoin SignUpItem2" id="department0">
                  <!-- Displays schools cover photo in background css, not img tag -->
                  <div class = "choiceInner" >
                    <div class = "info">
                      <div class = "choiceJoin">
                        <div class = "schoolsmallImage">
                          <!--<img src = "">-->
                        </div>
                        <div class = "name">
                          <h3 class="search_unit"></h3>
                          <p></p>
                        </div>
                        <div class = "button">
                          <div class ="join">
                            <button type = "button" class = "joinDepartmentBtn joinBtn" id="department??">
                              <i class = "joinIcon">
                              </i>
                              <span>Join</span>
                              <i class = "leaveIcon">
                              </i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
    </div>

    <div class = "signUpMain_1">
      <div class = "signUpMain_emailconfirm">
        <h1 id ="SignupStepHeader-confirm">Check your email</h1>
        <p id ="SignupStepSubHeader-confirm">
          We sent you a confirmation email with a link to get you started on Urlinq.  
        </p>
        <img src = "src/EmailConfirmIcon.png" class = "center-img">
        <div>
          <a class="resend">Resend</a>
          <!--<a href="lp_beta.php">Sign in</a>-->
        </div>
      </div>
      <div class = "signUpMain_fader">
        <div class = "signUp_header">
          <div class = "animateMiddle">
            <h1 id ="SignupStepHeader">Welcome to Urlinq's academic network at <span>NYU</span></h1>
            <p id ="SignupStepSubHeader">
              <?php if(isset($_GET['professor'])){}
              else{
                  echo 'First, click on the school or college you attend below.';
              } ?>  
            </p>

            <!--This SignUpProgressTracker div fades in only after the user has selected a school from part 1 and allows the user to adjust the school they chose with a simple option select tag -->
                     
            <div class = "SignUpProgressTracker">
              <div class = "SignUpPart2SchoolChosen signup_anchor">
                
                <div class = "chosenImg">
                  <img id="schoolimage" src = "<?php echo get_dp($con,$_SESSION['univ_id'],'school') ?>">
                </div>
                <div class = "wedge_wrapper">
                  <div class = "wedge_outer">
                  </div>
                  <div class="wedge_solid">
                  </div>
                </div>
                <div class = "signup_past_dropdown">
                  <h4></h4>
                  <div class = "signup_change_chosen_wrap signup_change_chosen_wrap_univ scrollable_dropdown">
                    <div class = "signup_change_chosen_item signup_change_chosen_item_univ signup_change_item">
                      <em>
                      </em>

                      <div class="signup_choosen_item_inner_univ">Chosen School Name</div>
                    </div>
                    
                  </div>
                </div>                
              </div>
              <div class = "SignUpPart3DepartmentChosen signup_anchor">
                
                <div class = "chosenImg">
                  <img id="deptimage" src = "<?php echo get_dp($con,$_SESSION['dept_id'],'dept') ?>">
                </div>
                <div class = "wedge_wrapper">
                  <div class = "wedge_outer">
                  </div>
                  <div class="wedge_solid">
                  </div>
                </div>
                <div class = "signup_past_dropdown" id="signup_past_dropdown_dept">
                  <h4>Change your Department</h4>
                  <div class = "signup_change_chosen_wrap signup_change_chosen_wrap_dept scrollable_dropdown">
                    <div class = "signup_change_chosen_item signup_change_chosen_item_dept signup_change_item">
                      <em>
                      </em>
                      <div class="signup_dept_choosen_item_inner">Chosen Department Name</div>
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class = "SignupPart2Message">
                
              </div>
            </div>
          </div>
        </div>
        <div class = "signupFormNext scrollable">
        </div>
        <div class = "signUp_footer">
          <div class = "shadowUpside">
          </div>
          <div class = "progress">
                  <ul max = "3" class = "ui-progress round" value = "1">
                    <?php
                      if(isset($_GET['professor'])){
                            echo '<li class = "1 inactive">
                                      </li>
                                      <li class = "2 inactive">
                                      </li>
                                      <li class = "3 active">
                                      </li>';

                      }else{
                         echo '<li class = "1 active">
                                      </li>
                                      <li class = "2 inactive">
                                      </li>
                                      <li class = "3 inactive">
                                      </li>';

                      }
                    ?>
                        

                    </ul>
                </div>
                 <?php
                      if(isset($_GET['professor'])){
                          echo '
                <div class = "btn-wrapper">
                  <button class = "nextBtn disabled">
                    Finish 
                    <em>
                    </em>
                  </button>
                </div>';
                      }else{
                        echo '<div class = "search-wrapper">
                  <div class = "search-signup-container">
                    <input type="stringSearch" name="signup_search" placeholder = "Search for your school" class = "search-signup-lists">
                    </input>

                  </div>
                </div>
                <div class = "btn-wrapper">
                  <button class = "nextBtn disabled">
                    Next 
                    <em>
                    </em>
                  </button>
                </div>';
                      }
                ?>
        </div>
      </div>
    </div>
  </div> 
</body>
</html>