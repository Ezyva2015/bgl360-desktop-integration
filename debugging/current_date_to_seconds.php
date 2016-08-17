<?php


//generate unique folder of the upload
$date1 = new DateTime(date("Y-m-d H:i:s"));
echo "\n\n date time = " . $date1->format('U');

//get it and append it to username/generatednumber/
//after upload add it to a session


