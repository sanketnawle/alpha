<?php
/**
 * Created by PhpStorm.
 * User: Kushal
 * Date: 8/31/14
 * Time: 6:34 PM
 */
$host = "localhost";
$user = "campusla_UrlinqU";
$password = "mArCh3!!1992X";
$database = "campusla_urlinq_prod";
$con = mysqli_connect($host, $user, $password, $database);
//Checking connection
if (mysqli_connect_errno()) {
//    echo "Failed to connect";
}

if(!function_exists("upload"))
{
	function upload($con,$file)
	{
		/*     * * check if a file was uploaded ** */
		if ($file['error'] == "UPLOAD_ERR_OK" //checks for errors
		    && is_uploaded_file($file['tmp_name'])) {
			$blockedExts = array(
				# HTML may contain cookie-stealing JavaScript and web bugs
				'html', 'htm', 'js', 'jsb', 'mhtml', 'mht', 'xhtml', 'xht',
				# PHP scripts may execute arbitrary code on the server
				'php', 'phtml', 'php3', 'php4', 'php5', 'phps',
				# Other types that may be interpreted by some servers
				'shtml', 'jhtml', 'pl', 'py', 'cgi',
				# May contain harmful executables for Windows victims
				'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl');

			/*         assign our variables  */
			$img_size = $file['size'];
			$img_type = $file['type'];
			// $file_tmpname = $file['tmp_name'];
			$img_name = $file['name'];
			$img_name = str_replace(" ", "_", $img_name);
			$extension = mime_content_type($file['tmp_name']);
			$maxsize = 16777215; //4294967295

			if ((($file['type'] == "image/gif")
			     || ($file['type'] == "image/jpeg")
			     || ($file['type'] == "image/jpg")
			     || ($file['type'] == "image/pjpeg")
			     || ($file['type'] == "image/x-png")
			     || ($file['type'] == "image/png"))
			    // && ($file['size'] < 20000)
			    && (!in_array($extension, $blockedExts))
			) {
				if (substr($img_type, 0, 5) === "image") {
					$im = new Imagick($file['tmp_name']);
					// $im->setImageCompression($compression_type);
					$im->setImageCompressionQuality(40);
					$im->stripImage();
					$im->writeImage($file['tmp_name']);
				}

				// $img1_content = file_get_contents($file['tmp_name']);

				/*         * *  check the file is less than the maximum file size ** */
				if ($img_size < $maxsize) {

					$img_ins = $con->prepare("INSERT INTO display_picture (img_name, img_content, img_type) VALUES (? ,?, ?)");
					if ($img_ins) {
						$null = NULL;
						$img_ins->bind_param('sbs', $img_name, $null, $img_type);
						$fp = fopen($file['tmp_name'], 'r');
						while (!feof($fp)) {
							$img_ins->send_long_data(1, fread($fp, 16776192));
						}
						if ($img_ins->execute()) {
							// echo "success";
							return $up_id = $con->insert_id;
							// $up_id = "success";
						} else {
							// die('execute() failed: ('.$con->errno.')' . htmlspecialchars($img1_ins->error));
							return $error = "Mazaak: Something is definitely wrong here!!"; //failed to execute
						}
					} else return $error = "Mazaak: This shouldn't happen... Hmm.. (Please report and try again)"; // failed to prepare

				} else {
					/*             * * throw an exception is file is not of type ** */
					return $error = "Mazaak: You exceeded the maximum size limit, seriously? 15.9999990463 MB is not enough for you?";
				}
			} else return $error = "Mazaak: Sorry, we only support these image formats for now (jpeg, gif, pjpeg, x-png, png)";

		} else {
			// if the file is not less than the maximum allowed, print an error
			throw new Exception("Unsupported file Format!");
		}
	}
}
if(isset($_POST['school']) && (!isset($_POST['department'])||$_POST['department']=="")
   && ((isset($_FILES['img']["size"]) &&
        ($_FILES['img']["size"] > 0))))
{
	echo $_POST['school'];
	$up_id = upload($con,$_FILES['img']);
	echo "Check upload ".$up_id;
	if(isset($up_id)&&is_numeric($up_id))
	{
		$con->query("UPDATE university SET dp_blob_id = ".$up_id." WHERE univ_id = ".$_POST['school']);
		echo $con->error;
	}
	else
	{
		echo($error);
		echo("Not uploaded");
	}
}
if(isset($_POST['school']) && (!isset($_POST['department'])||$_POST['department']=="")
   && ((isset($_FILES["img1"]["size"]) &&
        ($_FILES["img1"]["size"] > 0))))
{
	$up_id1 = upload($con,$_FILES['img1']);
	if(isset($up_id1)&&is_numeric($up_id1))
	{
		$con->query("UPDATE university SET cover_blob_id = ".$up_id1." WHERE univ_id = ".$_POST['school']);
	}
}

if(isset($_POST['school']) && isset($_POST['department']) && $_POST['department']!=""
&& isset($_FILES['img']))
{
	$up_id = upload($con,$_FILES['img']);
	if(isset($up_id)&&is_numeric($up_id))
	{
		$con->query("UPDATE department SET dp_blob_id = ".$up_id." WHERE dept_id = ".$_POST['department']);
	}
	else
	{
		echo($error);
		echo("Not uploaded");
	}
}

if(isset($_POST['school']) && isset($_POST['department']) && $_POST['department']!=""
   && isset($_FILES['img1']))
{
	$up_id1 = upload($con,$_FILES['img1']);
	if(isset($up_id1)&&is_numeric($up_id1))
	{
		$con->query("UPDATE department SET cover_blob_id = ".$up_id1." WHERE dept_id = ".$_POST['department']);
	}
}
?>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<title>Utilities</title>
	<script type="text/javascript">
		function someFunction(){
			//alert(this.val());
		}

	</script>
</head>
<body>
	<form enctype="multipart/form-data" action="utility_dept.php" method="post">
		<select name="school" value="<?php if(isset($_POST['school'])) echo $_POST['school'];?>">
		<?php
			$result = $con->query("SELECT univ_id, univ_name from university");
			while($row = $result->fetch_array(MYSQL_ASSOC))
			{
				echo "<option value='".$row['univ_id']."'>".$row['univ_name']."</option>";
			}
		?>
		</select>
		<select name="department" onchange="someFunction()">
		<?php
			if(isset($_POST['school']))
			{
				echo "<option value=''></option>";
				$result = $con->query("SELECT dept_id, dept_name from department where univ_id = "
				                      .$_POST['school']);
				while($row = $result->fetch_array(MYSQL_ASSOC))
				{
					echo "<option value='".$row['dept_id']."'>".$row['dept_name']."</option>";
				}
			}
		?>
		</select>

		Display Picture: <input type="file" name="img">
		Cover Picture: <input type="file" name="img1">
		<input type="submit" value="submit">
	</form>
</body>
</html>