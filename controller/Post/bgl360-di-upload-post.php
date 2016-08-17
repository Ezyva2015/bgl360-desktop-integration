<?php

if(isset($_POST['bgl360_dt_upload'])) {

    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    $uploadedfile = $_FILES['file'];

    if(bgl360_di_isValidUploadFileExtension($_FILES["file"], $_SESSION['bgl360_di_accepted_upload'])) {

        // Register our path override.
        add_filter( 'upload_dir', 'wpse_141088_upload_dir' );

        $upload_overrides = array( 'test_form' => false );

        // Do our thing. WordPress will move the file to 'uploads/mycustomdir'.
        $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

        if ( $movefile && ! isset( $movefile['error'] ) ) {
            echo "File is valid, and was successfully uploaded.\n";
            var_dump( $movefile );
            $_SESSION['bgl360_di_uploaded_file_settings'] = $movefile;
            $_SESSION['bgl360_di_uploaded_file_path_to_folder'] = bgl360_di_get_uploaded_file_path_to_folder($movefile['file']);
        } else {

            echo $movefile['error'];
        }

        $current_user = wp_get_current_user();
        $currentFileName =  str_replace('.zip', '', bgl360_di_get_file_name($movefile['file']));
        $newFileName = $current_user->user_login;

        remove_filter( 'upload_dir', 'wpse_141088_upload_dir' );

        //get file path only
        $filePath = bgl360_di_get_file_path_through_file_name($movefile['file']);
        $_SESSION['bgl360_di_upload_zip_file_dir'] = $filePath;


        //////////////////////////////////////////////////////////////////////////////////////////
        //////////Extract .zip file///////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////
        $zip = new ZipArchive;
        if ($zip->open($movefile['file']) === TRUE) {
            $zip->extractTo( $filePath . 'dbf' );
            $zip->close();

            $fileBatFilePath                  = '';
            $decrypt_folderDir                = bgl360_di_get_one_folder_dir($filePath);
            $decrypt_folderDir                = str_replace('/', '\\', $decrypt_folderDir);
            $decrypt_copyThisFilePathBat      = bgl360_di_plugin_dir . '\public\blg_bat_file\local_blg_bat_execute.bat';
            $decrypt_newCopiedThisFilePathBat = $filePath . '\local_blg_bat_execute.bat';
            $decrypt_newCopiedThisFilePathBat = str_replace('/', '\\', $decrypt_newCopiedThisFilePathBat);
            $decrypt_filePathToRemPass        = bgl360_di_plugin_dir . '\public\blg_bat_file\RemPass.exe';;
            $decrypt_filePathToDbfFolder      = $decrypt_folderDir;

            //////////////////////////////////////////////////////////////////////////////////////////
            //////////move .dbf file if not under dbf/.dbf folder to dbf/.dbf/////////////////////////
            //////////////////////////////////////////////////////////////////////////////////////////
            $dbfFileCurrentPath = bgl360_di_getDbfFileSubFolderPathCleaned($decrypt_folderDir);
            if(str_replace("\\", "",  $decrypt_folderDir) != str_replace("\\", "",$dbfFileCurrentPath)) {
                bgl360_di_copyUploadedDbfFilesToRootDbfFolder($dbfFileCurrentPath, $decrypt_folderDir);
            } else {
                print "\n No need to copy because .dbf file is in desired folder.";
            }

            /////////////////////////////////////////////////////////////////////////////////////////
            //////////Decode the incoded .dbf extracted  files///////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////
            if(bgl360_di_copy_and_save_file($decrypt_copyThisFilePathBat, $decrypt_newCopiedThisFilePathBat)) {
                echo "<br> Successfully copied";
            }
            if(bgl360_di_find_and_replace_file_content(['path rempass.exe'=>$decrypt_filePathToRemPass, 'path .dbf folder'=>$decrypt_filePathToDbfFolder ], $decrypt_newCopiedThisFilePathBat)) {
                echo "<br> Successfully replace file content";
            }
            $answer = system("cmd /c cmd  /c  $decrypt_newCopiedThisFilePathBat");
            if($answer == true) {
                echo "<br> Successfully executed";
            } else {
                echo "<br> Failed to execute";
            }

        } else {
            echo 'failed';
        }

        unlink($movefile['file']);
        $_SESSION['bgl360_di_dbf_uploaded_file_path']  = bgl360_di_getLatestFolderAdded( bgl360_di_upload_zip_file_dir );
        wp_redirect( site_url() .  '/' . bgl360_di_page_name_import ); exit;

    } else {
        /////////////////////////////////////////////////////////////
        ////////////////Generate error//////////////////////////////
        ////////////////////////////////////////////////////////////
        $str = '';
        foreach($_SESSION['bgl360_di_accepted_upload'] as $key => $ex)
        {
            $str .= $ex;
        }
        $_SESSION['response']['message'] =  "<br> <div class='bgl360_di_error'> Please upload only " . $str . ' file format. </div>';
    }
}




