<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(1);

$answer = system("cmd /c cmd  /c  local_blg_bat_execute.bat");
echo("Test");
if($answer == true) {
    echo "Executed <br>";
} else {
    echo "Not Executed<br>";
}