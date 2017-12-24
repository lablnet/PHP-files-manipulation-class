# PHP-files-manipulation-class
## Features
 1. Create directory 
 2. Generate random string
 3. Change file permission
 4. Copy Files or folders
 5. Move files and folders
 6. Delete files and folders
 7. Upload files with validation
 8. read/write files
 9. Setting default directory and sub directory
 10. And set directory out side of root of web server as well.
## Configuraiton
Open core/init.php you see following

        <?php
    //setting up data directory 
    $Malik['MalikDataDir'] = 'E:/Malik/Server/';
    //setting up sub folder it create automatically
    $Malik['subfolder'] = 'Malik';
    //load class
    require_once 'classess/MalikFiles.php';

Provide your main directory path

    $Malik['MalikDataDir'] = 'E:/Malik/Server/';

Provide sub dir path

    $Malik['subfolder'] = 'Malik';
