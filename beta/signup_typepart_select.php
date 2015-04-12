<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if($_POST['dept_id']){
	$_SESSION['dept_id']=$_POST['dept_id'];
}
echo '<div class = "SignUpStep3Wrapper" style="display:block">
<div class = "SignUpStep3-sec SignUpStep3-sec-first">
	                        <div class = "registration-sec-header">
	                          Academic Standing
	                        </div>
	                        <div class = "SignUpStep3-typechoice">
		                        <ul class = "account-types">
		                          <li class = "account-type undergraduate">
		                            <input name = "account-types"  type = "radio" id = "undergrad" class = "typecheck">
		                            <div id = "account-type-label">Undergraduate</div>
		                          </li>
		                          <li class = "account-type graduate" >
		                            <input name = "account-types"  type = "radio" id = "grad" class = "typecheck">
		                            <div id = "account-type-label">Graduate</div>
		                          </li>
		                        </ul>
		                    </div>
	                    </div>
	                    <div class = "SignUpStep3-sec SignUpStep3-sec-tall">
	                    	<div class = "text-left">
	                    		<div class = "h4-text">
	                    			Class Year
	                    		</div>
	                    	</div>
	                    	<div class = "options-box">
	                    		<div class = "box-condensed">
	                    			<div class = "box-col">
	                    				<div class = "panelClassyear">
	                    					<div class = "panel-body-light">
	                    						<div class = "row-ClassYear">
	                    							<div class = "col-text">
	                    								<div class = "select select-large" id="select_year">
	                    									<em class = "group_icon"> 
	                    									</em>
	                    									<span class="css-select-moz">
	                    									<select id = "classyear-select" value="0">
	                    										<option value = "-1">Year</option>
	                    										<option value = "2014" class = "classyears">2014</option>
	                    										<option value = "2015" class = "classyears">2015</option>
	                    										<option value = "2016" class = "classyears">2016</option>
	                    										<option value="2017" class = "classyears">2017</option>
	                    										<option value="2018" class = "classyears">2018</option>
	                    										<option value="2019" class = "classyears">2019</option>
	                    										<option value="2020" class = "classyears">2020</option>
	                    										<option value="2021" class = "classyears">2021</option>
	                    									</select>
	                    									</span>
	                    									<em></em>
	                    								</div>
	                    							</div>
	                    						</div>
	                    					</div>
	                    				</div>
	                    			</div>
	                    		</div>
	                    	</div>

	                    	<div style = "left:329px!important;width:165px!important;" class = "SignUpStep3-typechoice">
		                        <ul class = "account-types">
		                          <li style = "width:80px!important;border-radius:4px 0px 0px 4px!important;" class = "account-type male">
		                            <input name = "account-types"  type = "radio" id = "male" class = "typecheck">
		                            <div id = "account-type-label">Male</div>
		                          </li>
		                          <li style = "width:80px!important;border-radius:0px 4px 4px 0px!important; margin-left:-1px!important;" class = "account-type female" >
		                            <input name = "account-types"  type = "radio" id = "female" class = "typecheck">
		                            <div id = "account-type-label">Female</div>
		                          </li>
		                        </ul>
		                    </div>
	
	                    </div>
	                    <div class = "SignUpStep3-sec-last">
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