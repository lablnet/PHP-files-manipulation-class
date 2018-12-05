<?php
use Lablnet\Files;

require_once '../vendor/autoload.php';
$files = new Files();

if (isset($_POST['submit'])) {
    //File Upload
    $status = $files->filesUpload($_FILES['file'], '/', 'image', count($_FILES['file']['name']));
    foreach ($status as $key => $value) {
        var_dump($value);
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
