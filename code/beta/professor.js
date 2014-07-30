$(document).ready(function() {
	$(document).delegate(".showcase-container","mouseover",function(){
		$(this).find(".showcase-link").stop().animate({opacity: "1",marginTop:"35px"},0);
	});
	$(document).delegate(".showcase-container","mouseout",function(){
		$(this).find(".showcase-link").stop().animate({opacity: "0",marginTop:"95px"},0);
	});

	$(document).on("pageload",function(){
		$(".no-showcase").hide();
		$(".no-showcase").fadeIn(900);
	});

	$(document).delegate(".link","click",function(){
		
			$(this).text("Following")
			$(this).removeClass("link");
			$(this).addClass("pre-linked");
		
	});

	var cl_cache=["rgba(165, 21, 221, 0.5)","rgba(14, 207, 161, 0.98)","rgba(253, 112, 45, 0.74)","rgba(28, 109, 230, 0.8)"];
	$(document).delegate(".tab-inactive","click",function(){
			$(".tab-active").addClass("tab-inactive");
			$(".tab-active").removeClass("tab-active");
			//alert("aa");
			$(this).removeClass("tab-inactive");
			$(this).addClass("tab-active");

			var activeTab = $(this);
			var activeTabposition = activeTab.position();
			var activeTabLeft = activeTabposition.left;
			var activeTabNew = activeTabLeft -27;
			//var activeColor = activeTab.
			$(".tab-indicator").css("margin-left",activeTabNew);

			//var cl=$(".tab-active").css("color");
			//alert(cl);
			var index=0;
			if($(this).hasClass("tab-1")){index=0;}
			if($(this).hasClass("tab-2")){index=1;}
			if($(this).hasClass("tab-3")){index=2;}
			if($(this).hasClass("tab-4")){index=3;}
			//$(".tab-indicator").css("background-color",cl_cache[index]);
			$(".caret-transform").css("border-bottom-color",cl_cache[index]);
			//alert(cl);
			//$(".caret-transform").css("border-bo",activeTabNew);
	});	

		$(document).delegate(".professor-tab","mouseover",function(){
			if($(this).hasClass("tab-1")){index=0;}
			if($(this).hasClass("tab-2")){index=1;}
			if($(this).hasClass("tab-3")){index=2;}
			if($(this).hasClass("tab-4")){index=3;}
			$(this).css("color",cl_cache[index]);
		});

		$(document).delegate(".professor-tab","mouseout",function(){
			
			$(this).css("color","rgba(127, 127, 127, 0.4)");
			$(this).find("tab-count").css("color","rgba(127, 127, 127, 0.4)");
		});

	$(document).delegate(".pre-linked","mouseout",function(){
			$(this).text("Following");
			$(this).removeClass("pre-linked");
			$(this).addClass("linked");		
	});

	$(document).delegate(".linked","mouseover",function(){
			$(this).text("Unfollow");
	});

	$(document).delegate(".linked","mouseout",function(){
			$(this).text("Following");
	});

	$(document).delegate(".linked","click",function(){
			$(this).text("Follow")
			$(this).removeClass("linked");
			$(this).addClass("link");
	});		

	$(document).delegate(".professor-tab","click",function(){
		if($(this).hasClass("tab-2")){
			$(".user-tab-following-content").hide();
			$(".user-tab-followers-content").hide();
			$(".user-tab-followers-content").animate({opacity:"0"},200);
			$(".user-tab-following-content").animate({opacity:"0"},200);
			$(".user-tab-dicussions-content").animate({opacity:"0"},200);
			$(".user-tab-discussions-content").hide();
			$(".user-tab-groups-content").show();
			$(".user-tab-groups-content").animate({opacity:"1"},200);
		}
		if($(this).hasClass("tab-1")){
			$(".user-tab-following-content").hide();
			$(".user-tab-followers-content").hide();
			$(".user-tab-followers-content").animate({opacity:"0"},200);
			$(".user-tab-following-content").animate({opacity:"0"},200);
			$(".user-tab-groups-content").hide();
			$(".user-tab-groups-content").animate({opacity:"0"},200);
			$(".user-tab-discussions-content").show();
			$(".user-tab-dicussions-content").animate({opacity:"1"},200);
		}
		if($(this).hasClass("tab-3")){
			$(".user-tab-groups-content").hide();
			$(".user-tab-followers-content").hide();
			$(".user-tab-followers-content").animate({opacity:"0"},200);
			$(".user-tab-groups-content").animate({opacity:"0"},200);
			$(".user-tab-discussions-content").hide();
			$(".user-tab-dicussions-content").animate({opacity:"0"},200);
			$(".user-tab-following-content").show();
			$(".user-tab-following-content").animate({opacity:"1"},200);			
		}
		if($(this).hasClass("tab-4")){
			$(".user-tab-groups-content").hide();
			$(".user-tab-groups-content").animate({opacity:"0"},200);
			$(".user-tab-discussions-content").hide();
			$(".user-tab-dicussions-content").animate({opacity:"0"},200);
			$(".user-tab-following-content").hide();
			$(".user-tab-following-content").animate({opacity:"0"},200);	
			$(".user-tab-followers-content").show();
			$(".user-tab-followers-content").animate({opacity:"1"},200);		
		}					
	});
	$(document).delegate(".oh-editor-fx","click",function(){
		$(this).hide();
		$(".blacksheet").fadeIn(200);
		$(".blacksheet-main").fadeIn(200);
		$(".office-hours").hide();
	});


	var daymap=["M", "Tue", "W", "Thu", "F"];

	$(document).delegate(".done-editing","click",function(){

		var oharr = ['','','','',''];

		$(".oh_day_select").each(function( index ) {
			if ( $(this).find(".oh_checkbox").prop( "checked" ))
			{
				var stt=$(this).find("#off_hr_start_time_24hr").val().trim();
				var edt=$(this).find("#off_hr_end_time_24hr").val().trim();
				//alert(stt);
				if(stt==''||edt==''){

				}else{
					var str= daymap[index]+" "+stt+"- "+edt;
					oharr[index]=str;
					//alert(oharr[index]);
				}
			}
		});

		var str='';
		$.each(oharr, function(index) {
			if(oharr[index]!=''){
				str=str+oharr[index]+", "
			}
		});
		//alert(str);
		$(".office-hours").find("b").text(str);

		$(".blacksheet").hide();
		$(".oh-editor-fx").fadeIn(200);
		$(".blacksheet-main").fadeOut(200);
		$(".office-hours").show();
	});


	

	$(document).delegate(".edit-profile","click",function(){
		var web= $(".website-title").text().trim();
		var about= $(".profile-bio-container").text().trim();
		var school= $(".info_field_0").text().trim();
		var dept= $(".info_field_1").text().trim();
		var email= $(".info_field_2").text().trim();
		var loc= $(".info_field_3").text().trim();
		var name= $(".info_username").text().trim().split(" ");
		var ints= $(".profile-ints-container").text().trim();
		var fname= name[0];
		var lname= name[1];

		//alert(ints);
		$("#user_website").val(web);
		$("#user_fname").val(fname);
		$("#user_lname").val(lname);
		$("#user_about").val(about);
		$("#user_interest").val(ints);
		$("#user_school").val(school);
		$("#user_dept").val(dept);
		$("#user_email").val(email);
		$("#user_loc").val(loc);



		$(this).hide();
		$(".profpic-container-real").hide();
		$(".user-info-wrapper").css("opacity","0");
		$(".blacksheet-main").fadeIn(400);
		$(".main-2").show();
		$(".ns-hide").hide();
		$(".user-website").hide();

	});


	$(document).delegate(".cancel-edit-profile","click",function(){
		$(".blacksheet-main").fadeOut(400);
		$(".main-2").hide();
		$(".edit-profile").show();
		$(".profpic-container-real").show();
		$(".add_book_list").show()
		$(".user-info-wrapper").css("opacity","1");	
		$(".ns-hide").show();	
		$(".user-website").show();
	});

	$(document).delegate(".save-edit-profile","click",function(){

		var web= $("#user_website").val(); 
		var about= $("#user_about").val(); 
		var ints= $("#user_interest").val(); 
		var school= $("#user_school").val(); 
		var dept= $("#user_dept").val(); 
		var email= $("#user_email").val(); 
		var loc= $("#user_loc").val(); 
		var name= $("#user_fname").val()+" "+$("#user_lname").val();
		
		$(".website-title").text(web);
		$(".profile-bio-container").text(about);
		$(".profile-ints-container").text(ints);
		$(".info_field_0").text(school);
		$(".info_field_1").text(dept);
		$(".info_field_2").text(email);
		$(".info_field_3").text(loc);
		$(".info_username").text(name);


		$(".blacksheet-main").fadeOut(400);
		$(".main-2").hide();
		$(".edit-profile").show();
		$(".profpic-container-real").show();
		$(".add_book_list").show()
		$(".user-info-wrapper").css("opacity","1");	
		$(".ns-hide").show();	
		$(".user-website").show();
	});
	

	$(document).delegate(".add_book_list","click",function(){
		$(this).fadeOut(200);
	});
	$(document).delegate(".oh_checkbox","click",function(){
		$(".time_select_fx").hide();
		$(this).closest(".oh_day_select").find(".oh_checkbox_label").css({"background-position":"0 -15px","color":"rgba(55, 55, 55,1)"});
		$(this).addClass("oh_checkbox_checked");
		$(this).closest(".oh_day_select").find(".time_select_fx").show();
	});
	$(document).delegate(".oh_checkbox_checked","click",function(){
		$(this).closest(".oh_day_select").find(".oh_checkbox_label").css({"background-position":"0px 0px","color":"rgba(77, 77, 77,.6)"});
		$(this).removeClass("oh_checkbox_checked");
		$(this).closest(".oh_day_select").find(".time_select_fx").hide();
	});	

	 // to fade in on page load


	 $(document).delegate(".ns-btn","click",function(){

	 	$(this).closest(".no-showcase").hide();
	 	$(this).closest(".resource-wrapper").find(".showcase_step2").show();
	 	
	 });

	 var sc_click_flag=0;
	 $(document).delegate(".showcase_left_box","click",function(){
	 	if(sc_click_flag==0){
	 	sc_click_flag=1;
	 	$(".showcase_right_box > *").hide();
	 	$(".showcase_left_box > *").hide();
	 	$(".showcase_right_box").animate({opacity:0,width:0});
	 	$(".showcase_left_box").animate({width:450},function(){
	 		$(this).closest(".showcase_step2").removeClass("clickable_showcase_step2");
	 		$(this).closest(".showcase_step2").find(".step2_content_anchor").append("<textarea class='uploaddes_sc dotline_txtbox' placeholder='Title for the Showcase'></textarea><div class='uploadafile'><div class='up_txt'>From Your Computer</div><a class='cf_bt cf_bt_normal'>Choose File</a><div class='cf_prompt'>No file chosen</div></div>     <div class='driveafile'><div class='dv_txt'>From Your Drive</div><a class='cf_bt'>Choose File</a><div class='cf_prompt'>No file chosen</div></div>   <div class='sc_footer'> <div class='sc_cancel'>Cancel</div> <div class='sc_btn'>Showcase</div></div>");
	 	});
	 	}
	 });

	 $(document).delegate(".showcase_right_box","click",function(){
	 	if(sc_click_flag==0){
	 	sc_click_flag=1;
	 	$(".showcase_left_box > *").hide();
	 	$(".showcase_right_box > *").hide();
	 	$(".showcase_left_box").animate({opacity:0,width:0});
	 	$(".showcase_right_box").animate({width:450},function(){
			$(this).closest(".showcase_step2").removeClass("clickable_showcase_step2");
			$(this).closest(".showcase_step2").find(".step2_content_anchor").append("<textarea class='uploaddes_sc dotline_txtbox' placeholder='Title for the Showcase'></textarea><textarea class='linkbox_sc dotline_txtbox' placeholder='Link for the Showcase'></textarea>  <div class='sc_footer sc_link_ft'> <div class='sc_cancel'>Cancel</div> <div class='sc_btn'>Showcase</div></div>");
	 	});

	 	}
	 });

	 $(document).delegate(".sc_cancel","click",function(){
	 	$(this).closest(".showcase_step2").addClass("clickable_showcase_step2");
	 	$(this).closest(".step2_content_anchor").empty();
	 	$(".showcase_right_box").css({"width":"225px","opacity":"1"});
	 	$(".showcase_left_box").css({"width":"225px","opacity":"1"});
	 	$(".showcase_left_box > *").show();
	 	$(".showcase_right_box > *").show();
	 	sc_click_flag=0;

	 });

	 $(document).delegate(".sc_btn","click",function(){
	 	$(this).closest(".showcase_step2").addClass("clickable_showcase_step2");
	 	$(this).closest(".step2_content_anchor").empty();
	 	$(".showcase_right_box").css({"width":"225px","opacity":"1"});
	 	$(".showcase_left_box").css({"width":"225px","opacity":"1"});
	 	$(".showcase_left_box > *").show();
	 	$(".showcase_right_box > *").show();
	 	sc_click_flag=0;

	 });

	 $(document).delegate(".cf_bt_normal","click",function(){
        $(this).closest(".showcase_step2").find('.step2_file').click();
        return false;
     });

	 $(document).delegate(".step2_file","change",function(){
		var $hack=$(this).closest(".showcase_step2").find('.step2_file');

        var filename= $hack.val();

        if(filename.length>=18){
            filename= filename.substring(0,15)+"...";
            }
            //alert(filename);

        $(".cf_bt_normal").next(".cf_prompt").text(filename);
        $(".cf_bt_normal").next(".cf_prompt").attr("title",$hack.val());
      }); 

	 $(document).delegate(".profpic-container-edit","click",function(){
	 	alert("a");
	 });



});

