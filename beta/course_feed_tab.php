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
/**
 * Created by PhpStorm.
 * User: aditya841
 * Date: 8/5/14
 * Time: 2:58 PM
 */
echo "
<div class='feed-tab-content'>";

echo "<div class='group_fbar_wrap'>";
include_once('status_bar.php');
echo "</div>";

echo "<div class='group_feed_wrap'>";
include_once('feeds.php');
echo "</div>";

echo "<div class='feed-tab-rightsec'>";
include_once('course_feed_right_about.php');


	
echo "</div>";

echo "
    </div>
";

?>