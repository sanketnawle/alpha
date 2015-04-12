    <script>

        // $(document).ready(function(){
        // 	 jQuery.timeago.settings.allowFuture = true;
        //               jQuery("time.timeago").timeago();
        // });
        navigator.sayswho = (function () {
            var ua = navigator.userAgent, tem,
                M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
            if (/trident/i.test(M[1])) {
                tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
                return 'IE ' + (tem[1] || '');
            }
            if (M[1] === 'Chrome') {
                tem = ua.match(/\bOPR\/(\d+)/)
                if (tem != null) return 'Opera ' + tem[1];
            }
            M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
            if ((tem = ua.match(/version\/(\d+)/i)) != null) M.splice(1, 1, tem[1]);
            return M.join(' ');
        })();


        $(document).ready(function(){

        	var ver=navigator.sayswho.split(" ")[0].toLowerCase();

        	if(ver=='safari'){
        		$(".feed-tab-rightsec").css({"margin-left":"692px"});
        	}


        	/*above is safari right sec position*/
            /*below is planner margin top*/

            var sp=$(".feed-tab-rightsec").height();
            $(".rightsec").css({"margin-top":19});

        });
    </script>
<?php
if(isset($_GET['university'])){
                $university=$_GET['university'];
             }else{
             $university=$_SESSION['univ_id'];}
             $user_id=$_SESSION['user_id']; 
echo '<div class = "feed-tab-content">
<div class="group_fbar_wrap">';
	include_once('status_bar.php');
echo '</div>

<div class="group_feed_wrap">';
  include "feeds.php";

						
							echo '</div>
							<div class = "feed-tab-rightsec">
								<div class = "group-about">
									
									<div class = "box-header">
										<span class = "bh-t1">
											ABOUT
										</span>
										
									</div>
									<div class = "box-content content-about">Urlinq should strive for an "intimate" connection with customers\' feelings. "We will truly understand their needs better than any other company," Lazarus wrote.</div>
									<div class = "box-header">
										<a class = "bh-t2">
											Invite email list
										</a>
									</div>
									<div class = "box-content content-invite">
										<form rel = "" method = "post">
											<input type = "hidden" autocomplete = "off"/>
											<i class = "plusIcon"></i>
											<div class = "invite-input-wrap">
												<div class = "innerWrap">
													<input type = "text" class = "inputText inviteInput" name = "Invite form" placeholder = "Invite people to join this school"/>
													<div class = "search-icon" title = "Search people">
													</div>
												</div>
											</div> 
										</form>
									</div>
								</div>';

								echo "<div class='feed_planner_bag'>";
									include_once('planner_beta.php');
								echo "</div>";
								
							echo'</div>
						</div>';
						?>