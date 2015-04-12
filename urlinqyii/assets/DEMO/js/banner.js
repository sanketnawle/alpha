$(document).ready(function() {

var d = new Date();
var t= d.getDate();              
var nm= "'images/calendar-icons/normal/"+t+".png'";
var hv= "'images/calendar-icons/hover/"+t+".png'";
var ac= "'images/calendar-icons/active/"+t+".png'";

$(".cnm").attr("src","images/calendar-icons/normal/"+t+".png");
$(".cac").attr("src","images/calendar-icons/active/"+t+".png");
$(".cac2").attr("src","images/calendar-icons/active/"+t+".png");

$(".chv").attr("src","images/calendar-icons/hover/"+t+".png");

var isDown = false;
$(document).delegate(".ic","mouseover",function(){
if(!isDown){
if(!$("#calendar-menu").is(":visible")){
$(".cnm").hide();
$(".cac").hide();
$(".chv").show();
}
}
});



$(document).delegate(".ic","mouseout",function(){
if(!isDown){
if(!$("#calendar-menu").is(":visible")){
$(".cnm").show();
$(".cac").hide();
$(".chv").hide();

}
}
});

$(document).delegate(".ic","mousedown",function(){
isDown=true;
$(".cnm").hide();
$(".cac").show();
$(".chv").hide();
$(".calendar").css("opacity","1");
});

$(document).delegate(".ic","mouseup",function(){
isDown=false;
if(!isDown){
if(!$("#calendar-menu").is(":visible")){
$(".cnm").hide();
$(".cac").hide();
$(".chv").show();
}
}
});    





$("#university-menu").hide();
                  
$(document).delegate(".university","mousedown",function(){
$(".menus").hide();
$("#university-menu").show();
                     $(".cnm").show();
                     $(".cac").hide();
                     $(".chv").hide();
                     
                     
$(".university").css({"background-position":"50% 100%","background-size":"32.5px","opacity":"1"});
university_id=document.getElementById('hide_university_id').value;
student_id=document.getElementById('hide_student_id').value;
professor_id=document.getElementById('hide_professor_id').value;
	$.ajax({
			type: "POST",
			url: "notification_checked.php",
			data: { professor_id: professor_id,student_id: student_id,univid: university_id}
			})
			.done(function( msg ) {
			if(msg==1)
			{
				$("#u-notification").hide();
			}
			});                     
});

$(".university").mouseover(function(){
                           
$(".university").css({"background-position":"50% 50%","background-size":"32.5px","opacity":"1"}); 
                           
                           
});


$(".university").mouseout(function(){
if(!$("#university-menu").is(":visible")){
$(".university").css({"background-position":"top","background-size":"32.5px","opacity":"1"}); 
}
});            

$("#calendar-menu").hide();

$(document).delegate(".ic","mousedown",function(){
$(".menus").hide();
 $("#university-menu").hide();
 $(".university").css({"background-position":"top","background-size":"32.5px","opacity":"1"});
                     
           
$("#calendar-menu").show();
////////// Call ajax to hide red mark of calender notification///////////////////////
var calender='calender';
university_id=document.getElementById('hide_university_id').value;
student_id=document.getElementById('hide_student_id').value;
professor_id=document.getElementById('hide_professor_id').value;
var deptids='';
var courseids='';
$(".notification_msg").each(function() {
	mes_id=$(this).closest("div").attr("id");
	if(mes_id)
	{
		var result=mes_id.split("_");
		if(result[0]=='dept'){deptids=deptids+","+result[1];}
		if(result[0]=='course'){courseids=courseids+","+result[1];}
	}
});
$.ajax({
	type: "POST",
	url: "notification_checked.php",
	data: { professor_id: professor_id,student_id: student_id,univid: university_id,calender:calender,courseids:courseids,deptids:deptids}
	}).done(function( msg ) {
	if(msg==1)
	{
		$("#c-notification").hide();
	}
	});                     
});

                  
$(document).click(function(e)
                  {                
                 
                  //$(".menus").hide();
                  
                  if(($(e.target).parents(".menus").length<=0)&&(!$(e.target).hasClass("clickable"))){
                  $(".menus").hide();
                  $(".cnm").show();
                  $(".cac").hide();
                  $(".chv").hide();
                  //$(".calendar").css("opacity","0.7");
                  
                  $("#university-menu").hide();
                  $(".university").css({"background-position":"top","background-size":"32.5px","opacity":"1"});
                  }
                
                  
                  });


$("#profile-menu").hide();
$("#profile-icon").mouseover(function(){
$("#profile-menu").show();
});
$("#profile-menu").mouseover(function(){
$("#profile-menu").show();
});
$("#profile-menu").mouseout(function(){
$("#profile-menu").hide();
});
$("#profile-icon").mouseout(function(){
$("#profile-menu").hide();
});

});