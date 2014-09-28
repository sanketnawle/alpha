<html>
	<head>
		<title> Test - Upload </title>
	</head>
	<body>
		<form enctype = 'multipart/form-data' method='POST' action='update_profile.php'>
			<input type='file' name='img' id='img'>
			<input type='hidden' name='update_profile' value='1'>
			<input type='submit'>
		</form>
	</body>
</html>