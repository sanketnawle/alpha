<?php

echo $string = "<h2>hello</h2>";
// echo mysqli_escape_string($string);
echo htmlspecialchars($string,ENT_HTML5);

?>