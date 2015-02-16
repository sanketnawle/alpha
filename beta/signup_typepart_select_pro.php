<script>
$(document).ready(function() {

		$(document).delegate(".account-type-pro","click",function(){
			
			$(".nextBtn").removeClass("disabled");
			$(".nextBtn").addClass("proceed-to-confirm");
			var $ref=$(this);

		if($(this).hasClass("professor")){
			$(".adjunct").removeClass("account-type-chosen");
			$(".researcher").removeClass("account-type-chosen");
			$(".admin").removeClass("account-type-chosen");

			$(this).addClass("account-type-chosen");
			$("#professor").prop("checked", true);

			$("#adjunct").prop("checked", false);
			$("#researcher").prop("checked", false);
			$("#admin").prop("checked", false);

			var type_pro =$(this).find('.typecheck').attr('id');
			//alert(type_pro);			
		}
		if($(this).hasClass("admin")){
			$(".adjunct").removeClass("account-type-chosen");
			$(".researcher").removeClass("account-type-chosen");
			$(".professor").removeClass("account-type-chosen");

			$(this).addClass("account-type-chosen");
			$("#admin").prop("checked", true);

			$("#adjunct").prop("checked", false);
			$("#researcher").prop("checked", false);
			$("#professor").prop("checked", false);

			var type_pro =$(this).find('.typecheck').attr('id');
			//alert(type_pro);			
		}

		if($(this).hasClass("researcher")){
			$(".adjunct").removeClass("account-type-chosen");
			$(".professor").removeClass("account-type-chosen");
			$(".admin").removeClass("account-type-chosen");

			$(this).addClass("account-type-chosen");
			$("#researcher").prop("checked", true);

			$("#adjunct").prop("checked", false);
			$("#professor").prop("checked", false);
			$("#admin").prop("checked", false);

			var type_pro =$(this).find('.typecheck').attr('id');
			//alert(type_pro);			
		}

		if($(this).hasClass("adjunct")){
			$(".professor").removeClass("account-type-chosen");
			$(".researcher").removeClass("account-type-chosen");
			$(".admin").removeClass("account-type-chosen");

			$ref.addClass("account-type-chosen");
			$("#adjunct").prop("checked", true);

			$("#professor").prop("checked", false);
			$("#researcher").prop("checked", false);
			$("#admin").prop("checked", false);

			var type_pro =$(this).find('.typecheck').attr('id');
			//alert(type_pro);			
		}

		$.ajax({
			type:"post",
			url:"getdegree.php",
			data:{type_pro:type_pro},
			success:function(response){
				//console.log(response);
			}

		});

		});

		$(document).delegate(".upload_photo_box","click",function(){
				//$(this).addClass("upload_photo_box_uploaded");
				//$(this).find(".photo_upload_text").text("Photo Uploaded");
				$(this).closest(".SignUpStep3-sec-last-pro").find(".user_upload_photo_box_input").click();
		});

		

		$(document).delegate(".user_upload_photo_box_input","change",function(){

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
                
            $ref.closest(".SignUpStep3-sec-last-pro").find(".user_upload_photo_box").css({"background-image": "url(" + html + ")"});


            },
            error: function (html) {
                alert(html);
            }
        });


		

		});

    /*progress function for ajax*/
    function progressHandlingFunction(e) {
        if (e.lengthComputable) {
            $('progress').attr({value: e.loaded, max: e.total});
        }
    }
});
</script>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if($_POST['dept_id']){
	$_SESSION['dept_id']=$_POST['dept_id'];
}
echo '<div class = "SignUpStep3Wrapper" style="display:block">
<div class = "SignUpStep3-sec SignUpStep3-sec-first">
	                        <div class = "registration-sec-header pro_reg_header">
	                          Position
	                        </div>
	                        <div class = "SignUpStep3-typechoice pro_reg_choice">
		                        <ul class = "account-types">
		                          <li class = "account-type account-type-pro professor">
		                            <input name = "account-types"  type = "radio" id = "professor" class = "typecheck">
		                            <div id = "account-type-label">Professor</div>
		                          </li>
		                          <li class = "account-type account-type-pro admin" >
		                            <input name = "account-types"  type = "radio" id = "admin" class = "typecheck">
		                            <div id = "account-type-label">Administrator</div>
		                          </li>
		                          <li class = "account-type account-type-pro researcher" >
		                            <input name = "account-types"  type = "radio" id = "researcher" class = "typecheck">
		                            <div id = "account-type-label">Researcher</div>
		                          </li>
		                          <li class = "account-type account-type-pro adjunct" >
		                            <input name = "account-types"  type = "radio" id = "adjunct" class = "typecheck">
		                            <div id = "account-type-label">Adjunct Professor</div>
		                          </li>
		                        </ul>
		                    </div>
	                    </div>
	                    <!--
	                    <div class = "SignUpStep3-sec SignUpStep3-sec-tall">
	                    	
	                    	

	                    	<div class="gender_select">
	                    		<form>
									<input type="radio" class="gender_ctr gender_ctr_f" name="gender" value="female">Female<br>
									<input type="radio" class="gender_ctr gender_ctr_m" name="gender" value="male">Male
								</form>
	                    	</div>
	
	                    </div>
	                    -->
	                    <div class = "SignUpStep3-sec-last-pro">
	                    	<div class = "text-left">
	                    		<div class = "h4-text">
	                    			Profile Picture 
	                    		</div>
	                    	</div>
	                    	<div class = "upload_photo_box">
	                    		<em class = "camera_icon">
	                    		</em>
	                    		<div class=  "photo_upload_text">
	                    			Upload Photo
	                    		</div>
	                    	</div>
	                    	<div class="user_upload_photo_box">
	                    		<form>
	                    			<input type="file" name="img" class="user_upload_photo_box_input" style="display:none;">
	                    		</form>
	                    	</div>
	                    </div>
	                  </div>';