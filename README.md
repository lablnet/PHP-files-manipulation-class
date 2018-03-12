# PHP-files-manipulation-class
## This package can manipulate files and directories in several ways.

It can perform several types of operations. Currently it can:
 1. Create directory 
 2. Generate random string
 3. Change file permission
 4. Copy Files or folders
 5. Move files and folders
 6. Delete files and folders
 7. Upload files with validation
 8. Multiple file upload with validation
 9. read/write files
 10. Setting default directory and sub directory
 11. And set directory out side of root of web server as well.
 
## Configuraiton
Open core/init.php you see following

    <?php
	//setting up data directory 
	define("DATA_DIR", "E:/Malik/Server/");
	//setting up sub folder it create automatically
	define("SUB_FOLDER", "PHPFILES");
	//load class
	require_once 'classess/Files.php';



