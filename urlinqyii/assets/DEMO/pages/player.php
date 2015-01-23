<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
    <param name="movie" value="http://www.youtube.com/watch?v=K305Vu7hFg0&enablejsapi=1"></param> 
    <param name="allowscriptaccess" value="always"></param> 
    <script id="video" src="http://www.youtube.com/watch?v=K305Vu7hFg0&enablejsapi=1" type="application/x-shockwave-flash" allowscriptaccess="always" width="425" height="344"> 
    </embed> 
	</object>

<script type="text/javascript"> 
    function PlayerState() { 
        var sStatus = document.getElementById("video").getPlayerState(); 
        if (sStatus == -1) alert ("Video has not started."); 
        else if (sStatus == 0) alert ("Video has ended."); 
        else if (sStatus == 1) alert ("Video is playing."); 
        else if (sStatus == 2) alert ("Video is paused."); 
        else if (sStatus == 3) alert ("Video is buffering."); 
        else if (sStatus == 5) alert ("Video is cued."); 
    } 
</script> 

<input type="button" value="Get Player State" onclick="javascript:PlayerState();">  
</body>
</html>
