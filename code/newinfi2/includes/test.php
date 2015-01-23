<?php
/*** example usage ***/
$string='https://www.urlinq.com';
// echo makelink($string);
echo autolink($string);

/**
*
* Function to make URLs into links
*
* @param string The url string
*
* @return string
*
**/
function makeLink($string){

/*** make sure there is an http:// on all URLs ***/
$string = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2",$string);
/*** make all URLs links ***/
$string = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a target=\"_blank\" href=\"$1\">$1</A>",$string);
/*** make all emails hot links ***/
$string = preg_replace("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<A HREF=\"mailto:$1\">$1</A>",$string);

return $string;
}

function autolink($string){
  $content_array = explode(" ", $string);
  $output = '';

  foreach($content_array as $content){
    //starts with http://
    if(substr($content, 0, 7) == "http://")
      $content = '<a href="' . $content . '">' . $content . '</a>';

    //starts with www.
    if(substr($content, 0, 4) == "www.")
      $content = '<a href="http://' . $content . '">' . $content . '</a>';

    $output .= " " . $content;
  }

  $output = trim($output);
  return $output;
}

?>