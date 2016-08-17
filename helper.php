<?php

/**
 * @param $dbf_file
 */
function show_record_with_names($dbf_file){

    // Open the newly copied dbf file
    echo '<h1>'.$dbf_file.'</h1><hr/>';
    $db = dbase_open($dbf_file, 2);
    if ($db) {
        $record_numbers = dbase_numrecords($db);
        for($i=1; $i<=$record_numbers;$i++){
            $row = dbase_get_record_with_names($db, $i);
            printR($row,'Record No.: '.$i);
        }
    }
    return;
}

/**
 * Convert .dbf to array
 * @param $dbf_file
 * @return array
 */
function dbf_arr($dbf_file){

    $db = dbase_open($dbf_file, 2);

    $arr = array();

    if ($db) {

        $record_numbers = dbase_numrecords($db);

        for($i=1; $i<=$record_numbers;$i++){

            $row = dbase_get_record_with_names($db, $i);
            $arr[] = $row;

        }
    }

    return $arr;
}

/**
 * @param $array
 * @param string $title
 */
function printR($array,$title=''){

    if(is_array($array)){

        //echo $title."<br/>".  "||---------------------------------||<br/>".
           // "<pre>";
        //print_r($array);
        //echo "</pre>".  "END ".$title."<br/>". "||---------------------------------||<br/>";

    }else{
        //echo $title."<br/>"."<pre>".$array.'</pre>';
    }
}

/**
 * @param $needle
 * @param $haystack
 * @return bool|int|string
 */
function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}

/**  * @param $needle
 * @param $haystack
 * @param $key
 * @return bool|int|string
 */
function recursive_array_searchby_key($needle,$haystack,$key) {

    $n_array = array();
    foreach($haystack as $k => $v):

        if(is_array($v)){

            foreach($v as $vk => $vv):
                if($vk==$key){
                    $n_array[$k][$key] = $vv;
                }
            endforeach;

        }else{
            if($k==$key){
                $n_array[$k] = $v;
            }
        }
    endforeach;
    $return = recursive_array_search($needle,$n_array);
    return ($return);
}


/**
 * https://paulund.co.uk/php-delete-directory-and-files-in-directory
 * @param $dirname
 * @return bool
 * //delete folder
 * delete_directory(plugin_dir_path( __FILE__ ) . '/upload');
 */
function delete_directory($dirname) {
    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}


/**
 * SRC: http://wordpress.stackexchange.com/questions/141088/wp-handle-upload-how-to-upload-to-a-custom-subdirectory-within-uploads
 */

/**
 * Override the default upload path.
 *
 * @param   array   $dir
 * @return  array
 * add_filter( 'upload_dir', 'wpse_141088_upload_dir' );
 * remove_filter( 'upload_dir', 'wpse_141088_upload_dir' );
 */
function wpse_141088_upload_dir( $dir, $user_name ) {


    return array(
        'path'   => bgl360_di_upload_zip_file_dir,
        'url'    => bgl360_di_upload_zip_file_dir,
        'subdir' => bgl360_di_upload_zip_file_dir_sub,
    ) + $dir;
}

/**
 *
 * custom file name, change file name while uploading a file
 * @param $dir
 * @param $name
 * @param $ext
 * @return string
 */
function bgl360_di_my_cust_filename($dir, $name, $ext) {
    return $_SESSION['bgl360_di_custom_upload_name'] . $ext;
}

/**
 * get path to folder
 * @param $filePath
 * @return mixed
 */
function bgl360_di_get_uploaded_file_path_to_folder($filePath) {
    $uploadedPathToFolder = str_replace('.zip', '', $filePath);
    $uploadedPathToFolder = str_replace('.rar', '', $uploadedPathToFolder);
    return $uploadedPathToFolder;
}


/**
 * rename uploaded file
 * @param $pathToFile
 * @param $currentFileName
 * @param $newFileName
 * @return bool
 */
function bgl360_di_rename_uploaded_file($pathToFile, $currentFileName, $newFileName) {
    return rename( $pathToFile . '/' . $currentFileName,  $pathToFile . '/' .  $newFileName);
}

/**
 * get file name through file path
 * @param $filePath
 * @return string
 */
function bgl360_di_get_file_name($filePath) {
    // $path = "/home/httpd/html/index.php";
    $file = basename($filePath);         // $file is set to "index.php"
    $file = basename($filePath, ".php"); // $file is set to "index"
    return $file;
}

/**
 * get path of the uploaded file through file uploaded
 * @param $filePath
 * @return string
 */
function bgl360_di_get_file_path_through_file_name($filePath) {

    $filePathArray  = explode('/', $filePath);
    echo "<br> file path 1 " . $filePathArray[count($filePathArray)];
    echo "<br> file path 2 " . $filePathArray[count($filePathArray)-1];
    $filePathArray[count($filePathArray)-1] = '';
    $filePath = implode('/', $filePathArray);

    echo "<br> new file path " . $filePath;

    return $filePath;
}

/**
 * Delete folder
 * @param $dirPath
 * @return bool
 */
function bgl360_di_deleteFolder($dirPath) {

    /*
     $filePath = 'E:\xampp\htdocs\Tim\app.thesmsfacademy.com.au\developer\wordpress/wp-content/uploads/bgl_upload/appsmsfacedemy/BGL Desktop Integration';
     $fileName = 'BGL Desktop Integration';
     // Path relative to where the php file is or absolute server path
     chdir($FilePath); // Comment this out if you are on the same folder
     chown($FileName,465); //Insert an Invalid UserId to set to Nobody Owner; for instance 465
     $do = unlink($filePath);

     if($do=="1"){
         echo "The file was deleted successfully.";
     } else { echo "There was an error trying to delete the file."; }
    */


     if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            bgl360_di_deleteFolder($file);
        } else {
            unlink($file);
        }
    }
    return rmdir($dirPath);
}

/**
 * get all content of the specific folder
 * @param $filePath
 * @return string
 */
function bgl360_di_getContentFileOfTheFolder($filePath) {


    $file = '';
    $files = glob($filePath . '*', GLOB_MARK);

    //print_r($files);

    //foreach($paths as $key => $path):

        $files = glob($filePath .'/*');
        ksort($files);
        foreach ($files as $file) {
            if (is_dir($file)) {
                return  $file;
            }
        }

        //    $dir = "../mydir/";
        //    chdir($dir);
        //    array_multisort(array_map('filemtime', ($files = glob("*.*"))), SORT_DESC, $files);
        //    foreach($files as $filename)
        //    {
        //        echo "<li>".substr($filename, 0, -4)."</li>";
        //    }

            //endforeach;

        //    $files = array();
        //    if ($handle = opendir('.')) {
        //        while (false !== ($file = readdir($handle))) {
        //            if ($file != "." && $file != "..") {
        //                $files[filemtime($file)] = $file;
        //            }
        //        }
        //        closedir($handle);
        //
        //        // sort
        //        ksort($files);
        //        // find the last modification
        //        $reallyLastModified = end($files);
        //
        //        foreach($files as $file) {
        //            $lastModified = date('F d Y, H:i:s',filemtime($file));
        //            if(strlen($file)-strpos($file,".swf")== 4){
        //                if ($file == $reallyLastModified) {
        //                    // do stuff for the real last modified file
        //                }
        //                echo "<tr><td><input type=\"checkbox\" name=\"box[]\"></td><td><a href=\"$file\" target=\"_blank\">$file</a></td><td>$lastModified</td></tr>";
        //            }
        //        }
        //    }
        //
        //    foreach ($files as $file) {
        //        if (is_dir($file)) {
        //            return  $file;
        //        }
        //    }
}

/**
 * Get latest folder was uploaded to the server
 * @param $parentFolderPath
 * @return string
 */
function bgl360_di_getLatestFolderAdded($parentFolderPath) {

    // echo "<br><br> getting the latest file added here ";
    // echo '<br> file path '. $parentFolderPath . '<br>';
    $dir    = $parentFolderPath;
    $files1 = scandir($dir);

    // $files2 = scandir($dir, 1);
    // print_r($files1);

    //print_r($files2);
    $fileLatestAdded = array();

    //get recent file added by date
    foreach($files1 as $key => $file) {
        if($file != '.' and $file != '..') {
            $filename = $dir .'/' . $file;
            if (file_exists($filename)) {
                //$difference_in_seconds = $date1->format('U');
                // echo "\n $filename was last modified: " . date ("Y-m-d H:i:s", filemtime($filename));

                if(empty($fileLatestAdded['dateTime'])){

                    $fileLatestAdded['dateTime'] = date ("Y-m-d H:i:s", filemtime($filename));
                    $fileLatestAdded['file'] = $file;

                } else {

                    // echo  '\n\n date time = ' . $fileLatestAdded['dateTime'];

                    $date1 = new DateTime($fileLatestAdded['dateTime']);
                    // echo "\n\n date time = " . $date1->format('U');

                    $date2 = new DateTime(date ("Y-m-d H:i:s", filemtime($filename)));

                    if($date1->format('U') <  $date2->format('U')) {
                        $fileLatestAdded['dateTime'] = date ("Y-m-d H:i:s", filemtime($filename));
                        $fileLatestAdded['file'] = $file;
                    }

                    // echo "\n\n nice = " . $fileLatestAdded['dateTime'];
                    // $date1 = new DateTime("2016-14-07 06:07:13")
                    // echo "\n\n str to time = " . strtotime('2016-14-07 06:07:13');
                    // echo "\n\n total seconds = " . $date1->format('U');
                    //  $date2 = new DateTime(date ("Y-d-m H:i:s", filemtime($filename)));
                    //  if($date1->format('U') > $date2->format('U')) {
                    // $fileLatestAdded['dateTime'] = date ("Y-d-m H:i:s", filemtime($filename));
                    // $fileLatestAdded['file'] = $file;
                    //  }
                }
            }
        }
    }
//    echo " \n\n\n\n\nbelow is the latest added folder inside fildates folder";
//    print_r($fileLatestAdded);
//    echo "\n\n";
    return $parentFolderPath . '\\' . $fileLatestAdded['file'];
}

/**
 * check if extention that was been uploaded is valid
 * @param $file
 * @param $accepted_extension
 * @return bool
 */
function bgl360_di_isValidUploadFileExtension($file, $accepted_extension) {

    $path_parts = pathinfo($file["name"]);
    $extension = $path_parts['extension'];

//    echo "THis is extracted extension " .  $extension;
    if(in_array( '.' . $extension, $accepted_extension)) {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 * @param $stateNumber
 * @return mixed
 */
function bbl360_di_stateNumberToStateAbbreviation($stateNumber) {
    $arrayState = [2 => 'NSW', 3 => 'VIC', 4 => 'Qld'];
    if(!empty($arrayState[$stateNumber])){
        return $arrayState[$stateNumber];
    } else {
        return $stateNumber;
    }
}

/**
 * This will return true if trustee type is a company else return false if not
 * @param $trusteeFullName
 * @return bool
 */
function bgl360_di_isTrusteeTypeCompany($trusteeFullName) {
    $companyAbrArr = [
        'PTY. LTD.',
        'PTY. LTD',
        'PTY. LIMITED',
        'PTY LTD',
        'PTY LTD.',
        'PTY LIMITED',
        'PROPRIETARY LTD.',
        'PROPRIETARY LTD',
        'PROPRIETARY LIMITED'
    ];
    $trusteeFullNameLower = strtolower(str_replace(' ', '', $trusteeFullName));
    $isCompany = false;
    foreach ( $companyAbrArr as $key => $companyAbr) {
        $companyAbrLower =  strtolower(str_replace(' ', '', $companyAbr));
       // echo "\n <br>  $trusteeFullName => " . $trusteeFullNameLower .  " =  $companyAbr => " . $companyAbrLower;

        $pos = strpos($trusteeFullNameLower, $companyAbrLower);

        if ($pos !== false) {
            $isCompany = true;
        }
    }
    return $isCompany;
}

/**
 * Allow redirect to login if visited upload or import and if not yet logged in
 */
function bgl360_di_redirect_login() {

    if( bgl360_di_is_local() )
    {
        $path_param =  'wp-login.php';
    }
    else
    {
        // $path_param =  'restricted-content';
        $path_param =  'wp-login.php';
    }


    if( !is_user_logged_in() ) {

        $_SESSION['bgl360_di_is_visited_upload_or_import_page'] = true;

         bgl360_di_redirect( site_url() . '/' . $path_param); exit;
    }
}

/**
 * Redirect page using js
 * @param $location
 */
function bgl360_di_redirect($location) {
    ?> <script>document.location = '<?php echo $location ?>'; </script><?php
}

/**
 * Detect if visited a local or online
 * @return bool
 */
function bgl360_di_is_local() {
    if($_SERVER['HTTP_HOST'] == 'localhost'
        || substr($_SERVER['HTTP_HOST'],0,3) == '10.'
        || substr($_SERVER['HTTP_HOST'],0,7) == '192.168') return true;
    return false;
}




function bgl360_di_get_one_folder_dir($filePath) {
    $files = glob($filePath .'/*');
    foreach ($files as $folderPath) {
        if(is_dir($folderPath)) {
            // echo "<br> file name " . $file . '<br><br>';
            return $folderPath;
        }
    }

    return 0;
}


/**
 * @param $arrayFindReplace
 * @param $filePath
 * @return bool|int
 * $arrayFindReplace = array('add here rempass path' => 'update 1', 'add here encoded dbf file folder'=> 'update 2');
 * $filePath = 'E:\xampp\htdocs\Tim\app.thesmsfacademy.com.au\developer/bat/local_blg_bat_execute_copied.bat';
 */
function bgl360_di_find_and_replace_file_content($arrayFindReplace, $filePath) {

    $bool = false;

    foreach($arrayFindReplace as $find => $replace) {
        $bool = file_put_contents($filePath, str_replace($find, $replace, file_get_contents($filePath)));
    }

    return $bool;
}

/**
 * @param $copyThisFile
 * @param $newCopiedFile
 * @return bool
 * $copyThisFilePath = 'E:\xampp\htdocs\Tim\app.thesmsfacademy.com.au\developer/bat/local_blg_bat_execute.bat';
 * $newCopiedFilePath = 'E:\xampp\htdocs\Tim\app.thesmsfacademy.com.au\developer/bat/local_blg_bat_execute_copied.bat';
 */
function bgl360_di_copy_and_save_file($copyThisFilePath, $newCopiedFilePath) {

    if (!copy($copyThisFilePath, $newCopiedFilePath)) {
        return false;
    } else {
        return true;
    }
}

/**
 * @param $fromTime
 * @param $toTime
 * @return array
 */
function bgl360_di_getPassedTimeAgo($fromTime, $toTime) {

    $timeAgo = array();

    $to_time = $toTime;
    $from_time = $fromTime;
    //echo round(abs($to_time - $from_time) / 60,2). " minute";

    $start_date = new DateTime( $from_time );
    $since_start = $start_date->diff(new DateTime( $to_time ));
    //    echo $since_start->days.' days total<br>';
    //    echo $since_start->y.' years<br>';
    //    echo $since_start->m.' months<br>';
    //    echo $since_start->d.' days<br>';
    //    echo $since_start->h.' hours<br>';
    //    echo $since_start->i.' minutes<br>';
    //    echo $since_start->s.' seconds<br>';

    $timeAgo['daysTotal'] = $since_start->days;
    $timeAgo['years']     = $since_start->y;
    $timeAgo['months']    = $since_start->m;
    $timeAgo['days']      = $since_start->d;
    $timeAgo['hours']     = $since_start->h;
    $timeAgo['minutes']   = $since_start->i;
    $timeAgo['seconds']   = $since_start->s;

    return $timeAgo;
}

/**
 * @param $pathToSpecificUserBglUploaded
 */
function bgl360_di_delete_uploaded_bgl_under_specific_user($pathToSpecificUserBglUploaded) {

    echo "\n\n full path of the users folder " . $pathToSpecificUserBglUploaded . "\n\n";

    $latest_folder_path =  bgl360_di_getLatestFolderAdded($pathToSpecificUserBglUploaded);

    $timeAgo = bgl360_di_getPassedTimeAgo(date ("Y-m-d H:i:s", filemtime($latest_folder_path)), date ("Y-m-d H:i:s"));

    print_r( $timeAgo );

    print "\n\n current server date time " . date ("Y-m-d H:i:s");

    print "\n\n latest folder added = " . date ("Y-m-d H:i:s", filemtime($latest_folder_path));

    echo "\n Latest folder path " .  $latest_folder_path;
    echo "\n base name  " . basename($latest_folder_path);
    $pathDirArray  = scandir($pathToSpecificUserBglUploaded);
    //print_r($pathDirArray);
    $latest_folder_path_base = basename($latest_folder_path);
    foreach($pathDirArray as $key => $folder) {
        if(($folder != '..') and ($folder != '.')) {

            //less than or equal 2hrs the latest uploaded bgl will not be deleted
            if($timeAgo['hours'] <= 2) {

                echo "\n\n latest uploaded less than 2hrs ";
                if($folder != $latest_folder_path_base) {
                    echo "\n\n Delete this folder  " .$pathToSpecificUserBglUploaded . '\\' . $folder . " \n " ;
                    //   if(bgl360_di_deleteFolder($pathToSpecificUserBglUploaded . '\\' . $folder)){
                    //       echo "\n folder successfully deleted";
                    //   } else {
                    //      echo "\n folder failed to delete";
                    //  }
                }

            }
            // else the greater than 2hrs the latest bgl uploaded then
            // delete it as well.
            else {
                echo "\n\n latest uploaded greater than 2hrs ";
                echo "\n\n Delete this folder  " .$pathToSpecificUserBglUploaded . '\\' . $folder . " \n " ;
                // if(bgl360_di_deleteFolder($pathToSpecificUserBglUploaded . '\\' . $folder)){
                //    echo "\n folder successfully deleted";
                // } else {
                //     echo "\n folder failed to delete";
                // }
            }


        }
    }
}


/**
 * @param $pathRootFilesToCopy
 * @param $pathDbfRootFolder
 */
function bgl360_di_copyUploadedDbfFilesToRootDbfFolder($pathRootFilesToCopy, $pathDbfRootFolder) {

    $files = glob($pathRootFilesToCopy .'/*');
    //print_r($files );
    foreach($files as $key => $copyFilePath) {
        bgl360_di_copy_and_save_file($copyFilePath, $pathDbfRootFolder . '\\' . basename($copyFilePath));
    }
}


/**
 * @param $dbfFolder
 * @return mixed
 */
function bgl360_di_getDbfFileSubFolderPathCleaned($dbfFolder) {
    $_SESSION['blg360_di_dbfFileCurrentPath'] = '';
    bgl360_di_getDbfFileSubFolderPath($dbfFolder);
    $dbfFileCurrentPath = str_replace("/", "\\", $_SESSION['blg360_di_dbfFileCurrentPath'] );
    $dbfFileCurrentPath = str_replace("\\\\", "\\", $dbfFileCurrentPath );
    $dbfFileCurrentPath = str_replace("chart.dbf", "", $dbfFileCurrentPath);
    return  $dbfFileCurrentPath;
}

/**
 * @param $dirPath
 */
function bgl360_di_getDbfFileSubFolderPath($dirPath) {

    $path = '';

    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            bgl360_di_getDbfFileSubFolderPath($file);
        } else {
            if(basename($file) == 'chart.dbf') {
                $path = $file;

            }
        }
    }
    if(!empty($path)) {
        $_SESSION['blg360_di_dbfFileCurrentPath'] = $path;
    }
}

function bgl360_di_importerMapping($form_id, $source_platform) {
    global $wpdb;
    $results = $wpdb->get_results(
        $wpdb->prepare("Select * from wp_rg_campus_order_data_importer where form_id = $form_id and source_platform = '$source_platform'"  , ARRAY_A)
    );
    return $results;
}


function bgl360_di_getDbfFields($fundMemberSelected = null) {

    $fund      = new \App\Fund();

    $trustee   = new \App\Trustees1();

    $dbfFieldWithValue = array(
        'Reference' => '',
        'Fund Name' => $trustee->fundName,
        'State Law To Govern The Fund' => $trustee->fundAddressState,
        'Fund Address' => $trustee->fundAddress,
        'Fund Address 1 Hidden' => $trustee->fundAddressRoadD1,
        'Fund Address 2 Hidden' => $trustee->fundAddressRoadD2,
        'Fund Address 3 Hidden' => $trustee->fundAddressRoadD3,
        'Fund Address 4 Hidden' => $trustee->fundAddressState,
        'Fund Address 5 Hidden' => $trustee->fundAddressRoadD4,
        'Trustee Meeting Address Select' =>'',
        'Trustee Meeting Address Text' =>'',
        'Trustee Metting Address 1 Hidden'=>'',
        'Trustee Metting Address 2 Hidden'=>'',
        'Trustee Metting Address 3 Hidden' =>'',
        'Trustee Metting Address 4 Hidden' =>'',
        'Trustee Metting Address 5 Hidden' =>'',
        // Trustee members
        'How many Members will the Fund have' => $fund->fundMemberTotal,
        // Member 1
        'Title 1' =>'',
        'Given Names 1' => '',
        'Family Name 1' => '',
        'Gender 1' => '',
        'Date of Birth 1' => '',
        'TFN 1' => '',
        'Member 1 Residential Address' => '',
        'Member 1 Address Search' => '',
        'Member 1 Address 1 Hidden' => '',
        'Member 1 Address 2 Hidden' => '',
        'Member 1 Address 3 Hidden' => '',
        'Member 1 Address 4 Hidden' => '',
        'Member 1 Address 5 Hidden' => '',
        // Member 2
        'Title 2'=>'',
        'Given Names 2'=>'',
        'Family Name 2'=>'',
        'Gender 2'=>'',
        'Date of Birth 2'=>'',
        'TFN 2'=>'',
        'Member 2 Residential Address'=>'',
        'Member 2 Address Search'=>'',
        'Member 2 Address 1 Hidden'=>'',
        'Member 2 Address 2 Hidden'=>'',
        'Member 2 Address 3 Hidden'=>'',
        'Member 2 Address 4 Hidden'=>'',
        'Member 2 Address 5 Hidden'=>'',
        // Member 3
        'Title 3'=>'',
        'Given Names 3'=>'',
        'Family Name 3'=>'',
        'Gender 3'=>'',
        'Date of Birth 3'=>'',
        'TFN 3'=>'',
        'Member 3 Residential Address'=>'',
        'Member 3 Address Search'=>'',
        'Member 3 Address 1 Hidden'=>'',
        'Member 3 Address 2 Hidden'=>'',
        'Member 3 Address 3 Hidden'=>'',
        'Member 3 Address 4 Hidden'=>'',
        'Member 3 Address 5 Hidden'=>'',
        // Member 4
        'Title 4'=>'',
        'Given Names 4'=>'',
        'Family Name 4'=>'',
        'Gender 4'=>'',
        'Date of Birth 4'=>'',
        'TFN 4'=>'',
        'Member 4 Residential Address'=>'',
        'Member 4 Address Search'=>'',
        'Member 4 Address 1 Hidden'=>'',
        'Member 4 Address 2 Hidden'=>'',
        'Member 4 Address 3 Hidden'=>'',
        'Member 4 Address 4 Hidden'=>'',
        'Member 4 Address 5 Hidden'=>'',
        // TRUSTEE TYPE DATA
        'Trustee Type' => $trustee->trusteeType,
        // Non-Member Trustee Individual
        'Individual Title'=>'',
        'Individual Trustee 2 - Given Names'=>'',
        'Individual Trustee 2 - Family Name'=>'',
        'Individual Gender'=>'',

        // Corporate Trustee
        'Corporate Trustee Name'=>'',
        'Corporate Trustee ACN'=>'',
        'Corporate Date of Incorporation'=>'',
        'Corporate Trustee Registered Address'=>'',
        //Directors
        'Does the Company have an additional Director who is not a Member of the Fund?'=>''
    );


    // add member information
    $member_counter = 1;
    for ($i = 0; $i < $fund->fundMemberTotal; $i++) {
        $fund->getFundMembers($i);

        if($i==0) {
            $dbfFieldWithValue['Trustee Meeting Address Select'] = "Other Address";
            $dbfFieldWithValue['Trustee Meeting Address Text'] = $fund->fundMemberAddress;
            $dbfFieldWithValue['Trustee Metting Address 1 Hidden'] = $fund->fundMemberAddressRoad1;
            $dbfFieldWithValue['Trustee Metting Address 2 Hidden'] = $fund->fundMemberAddressRoad2;
            $dbfFieldWithValue['Trustee Metting Address 3 Hidden'] = $fund->fundMemberAddressRoad3;
            $dbfFieldWithValue['Trustee Metting Address 4 Hidden'] = $fund->fundMemberAddressState;
            $dbfFieldWithValue['Trustee Metting Address 5 Hidden'] = $fund->fundMemberAddressRoad4;
        }


        // member info
        $dbfFieldWithValue['Title ' . $member_counter]        = $fund->fundMemberTitle;
        $dbfFieldWithValue['Given Names ' . $member_counter]  = $fund->fundMemberFirstName;
        $dbfFieldWithValue['Family Name ' . $member_counter]  = $fund->fundMemberSureName;
        $dbfFieldWithValue['Gender ' . $member_counter]       = $fund->fundMemberGender;
        $dbfFieldWithValue['TFN ' . $member_counter]          = $fund->fundMemberTFN;

        // member address
        $dbfFieldWithValue['Member ' . $member_counter . ' Residential Address']  = "Other Address";
        $dbfFieldWithValue['Member ' . $member_counter . ' Address Search']       = $fund->fundMemberAddress;
        $dbfFieldWithValue['Member ' . $member_counter . ' Address 1 Hidden']     = $fund->fundMemberAddressRoad1;
        $dbfFieldWithValue['Member ' . $member_counter . ' Address 2 Hidden']     = $fund->fundMemberAddressRoad2;
        $dbfFieldWithValue['Member ' . $member_counter . ' Address 3 Hidden']     = $fund->fundMemberAddressRoad3;
        $dbfFieldWithValue['Member ' . $member_counter . ' Address 4 Hidden']     = $fund->fundMemberAddressState;
        $dbfFieldWithValue['Member ' . $member_counter . ' Address 5 Hidden']     = $fund->fundMemberAddressRoad4;

        // selected member
        print ' trustee type = ' . $trustee->trusteeType . "  and  fund member selected = " .  str_replace(' ', '',  strtolower($fundMemberSelected)) . "==" .  str_replace(' ', '',  strtolower($fund->fundMemberFullName));
        $name1 = str_replace(' ', '',  strtolower($fundMemberSelected)) ;
        $name2 = str_replace(' ', '',  strtolower($fund->fundMemberFullName));



        if($trustee->trusteeType == 'Individuals'  || $trustee->trusteeType == 'Individual') {
            if($name1 == $name2) {

                $dbfFieldWithValue['Individual Title'] = $fund->fundMemberTitle;
                $dbfFieldWithValue['Individual Trustee 2 - Given Names'] = $fund->fundMemberFirstName;
                $dbfFieldWithValue['Individual Trustee 2 - Family Name'] = $fund->fundMemberSureName;
                $dbfFieldWithValue['Individual Gender'] = $fund->fundMemberGender;

                echo "<br> equal ";

            } else {
                echo "<br> not equal";
            }
        } else {
            echo "<br> its a company";
        }
        $member_counter++;
    }
    return $dbfFieldWithValue;
}

function getMappingValueBasedOnDbfField($dbfFieldFromDb, $selectedMember) {
    $dbfFieldsWithData = bgl360_di_getDbfFields($selectedMember);
    // print "<pre>";
    // print "<h3> from dbf field values </h3>";
    // print_r($dbfFieldsWithData);
    // print "<h3> From database field mapping importer </h3>";
    // print_r($dbfFieldFromDb);
    $entry = [];
    foreach($dbfFieldsWithData as $key1 => $value1 ) {
        $key1_1 = strtolower(str_replace('_', ' ', $key1));
        foreach($dbfFieldFromDb as $key2 => $value2 ) {
            $key2_2 = strtolower(str_replace('_', ' ', $key2));
            if ($key1_1 == $key2_2) {
                if(!empty($value1)) {
                    $entry[$value2] = $value1;
                }
                break;
            }
        }
    }
    //    print "<h3>Mapped entry</h3>";
    //    print_r($entry);
    //    print "</pre>";
    return $entry;
    //exit;
}