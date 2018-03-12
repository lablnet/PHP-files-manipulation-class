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
		$fileName = $files->FileUpload(['file'=>$_FILES['file'],'target'=>'images','filetype'=>'image']);
		echo $files->fullDirPath.$fileName;
		echo $link;
		
	//Make A Directory	
	} elseif( isset( $_POST['usage'] ) && $_POST['usage'] == 'mkd' ){
		
		if( $files->MkDirs( $_POST['mydir'] ) ){
			
			echo $files->fullDirPath.$_POST['mydir'].'/ [has been created]';
			echo $link;
			
		}
		
	//Generate Random Strings/Salts	
	} elseif( isset( $_POST['usage'] ) && $_POST['usage'] == 'grss' ){
		
		echo $files->GenerateSalts( $_POST['countup'] );
		echo $link;
		
	}
	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>PHP File Manipulation Class Examples</title>
	</head>
	
	<body>
		<!-- File Upload -->
		<fieldset>
			<legend>File Upload</legend>
				<form id="fileUp" name="fileUp" action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="usage" value="upl">
						<input type="file" name="file" />
						<br>
						<input type="submit" name="submit">
				</form>
		</fieldset><br /><br />

		<!-- Create a Directory -->
		<fieldset>
			<legend>Create A Directory</legend>
				<form id="crd" name="crd" action="" method="post">
						<input type="hidden" name="usage" value="mkd">
						<input type="text" name="mydir" value="" size="35" />
						<br>
						<input type="submit" name="submit">
				</form>
		</fieldset><br /><br />

		<!-- Generate A Random String/Salt -->
		<fieldset>
			<legend>Generate A Random String/Salt</legend>
				<form id="genss" name="genss" action="" method="post">
						<input type="hidden" name="usage" value="grss">
						<input type="number" name="countup" value="" min="1" max="64" />
						<br>
						<input type="submit" name="submit">
				</form>
		</fieldset><br /><br />

	</body>
</html>
