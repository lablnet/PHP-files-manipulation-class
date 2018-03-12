<?php
//check if form submit
if(isset($_POST['submit'])){
	
	//loading require files
	require_once 'core/init.php';

	//creating objects
	$files = new Files;
	
	//Go Back Link 
	$link = "<br /><div>&nbsp;</div><div>&nbsp;</div><div style='width:33.9%; margin-left:auto; margin-right:auto;'><a href='example.uploadfile.php'>Back  To Example's Page</a></div>";
	
	//File Upload
	if( isset( $_POST['usage'] ) && $_POST['usage']== 'upl' ){
		
		//passing $_FILES['value of name attribute']
		// target if you want upload in main data folder leave as / otherwise apply if folder not exists is create first
		//filetype type of file image,media,zip,docs supported for more info see line 224 of class file




		$status = $files->MultipleFileUpload(['file'=>$_FILES['file'],'target'=>'images','filetype'=>'image','count'=> count($_FILES['file']['name'])]);
		foreach ($status as $key => $value) {
			echo "File name ".$value . "<br />";
		}
	} 
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>PHP File Manipulation Class Examples</title>
	</head>
	<body>
		<fieldset>
			<legend>File Upload</legend>
				<form id="fileUp" name="fileUp" action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="usage" value="upl" />
						<input type="file" name="file[]" multiple/>
						<br>
						<input type="submit" name="submit">
				</form>
		</fieldset>
	</body>
</html>
