<?php 

use Lablnet\Files;

require_once "../vendor/autoload.php";

$files = new Files();

//Write on file 
$files->open('test.txt','writeOnly')->write("I am test files");

// read the file
var_dump($files->open('test.txt','readOnly')->read('test.txt'));

//delete the file
$files->delete('test.txt');


//Make dir
$files->mkDir('name');

//Change premission
$files->permission('test.txt',0774);

//Delete files
$files->deleteFiles(['test.txt']);

//Copy files
$files->copyFiles('/name','dir/',['test.txt']);

//Move files
$files->moveFiles('/','dir/',['test.txt']);


//Delete dirs
$files->deleteDirs(['test.txt']);

//Copy dirs
$files->copyDirs('/','dir/',['test.txt']);

//Move dirs
$files->moveDirs('/','dir/',['test.txt']);

//File upload
$status = $files->fileUpload($_FILES['file'],'/','image');
var_dump($status);

//Multiple file upload
$status = $files->filesUpload($_FILES['file'],'/','image',count($_FILES['file']['name']));
var_dump($status);
