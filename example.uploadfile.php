<?php
//loading require files
require_once 'core/init.php';
//creating objects
$files = new Files;
//check if form submit
if(isset($_POST['submit'])){
	//passing $_FILES['value of name attribute']
	// target if you want upload in main data folder leave as / otherwise apply if folder not exists is create first
	//filetype type of file image,media,zip,docs supported for more info see line 224 of class file
	$fileName = $files->MalikFileUpload(['file'=>$_FILES['file'],'target'=>'images','filetype'=>'image']);
	echo $fileName;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP File upload</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
		<input type="file" name="file">
		<br>
		<input type="submit" name="submit">
	</form>
</body>
</html>