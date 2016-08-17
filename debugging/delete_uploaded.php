<?php
session_start();



$fileFolder = 'E:\xampp\htdocs\Tim\app.thesmsfacademy.com.au\developer\wordpress/wp-content/uploads/bgl_upload/wariors ertfhujkl';
echo "session path to delete = " . $fileFolder;

echo "<br> This is the folder will delete";

$files1 = scandir($fileFolder);
foreach($files1 as $key => $file) {
    unlink($fileFolder . '/' . $file);
}


// Path relative to where the php file is or absolute server path
chdir($fileFolder); // Comment this out if you are on the same folder
chown($fileFolder,0777); //Insert an Invalid UserId to set to Nobody Owner; for instance 465
chmod($fileFolder, 0775);
$do = unlink($fileFolder);
if($do=="1"){
    echo "The file was deleted successfully.";
} else { echo "There was an error trying to delete the file."; }

$fileName = $fileFolder;


$Path = $fileFolder;

chown($Path, 666);

if ( unlink($Path) )
    echo "success";
else
    echo "fail";


chown($Path,666); //Insert an Invalid UserId to set to Nobody Owern; 666 is my standard for "Nobody"
unlink($Path.$FileName);




//
//// define if we under Windows
//$tmp = dirname(__FILE__);
//if (strpos($tmp, '/', 0)!==false) {
//    define('WINDOWS_SERVER', false);
//} else {
//    define('WINDOWS_SERVER', true);
//}
//$deleteError = 0;
//if (!WINDOWS_SERVER) {
//    if (!unlink($fileName)) {
//        $deleteError = 1;
//    }
//} else {
//    $lines = array();
//    exec("DEL /F/Q \"$fileName\"", $lines, $deleteError);
//}
//if ($deleteError) {
//    echo 'file delete error';
//}
//
//
//
//
//
//
//print_r($files1);









