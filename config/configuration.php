<?php
$current_user = wp_get_current_user();

//create subfolder for username
//define('bgl360_di_upload_zip_file_dir', plugin_dir_path(__DIR__) . 'upload/' . $current_user->user_login);
//define('bgl360_di_upload_zip_file_dir_sub', $current_user->user_login);

//define('bgl360_di_zip_upload_path', );
$_SESSION['bgl360_di_upload_zip_file_dir'] = (!empty($_SESSION['bgl360_di_upload_zip_file_dir'])) ? $_SESSION['bgl360_di_upload_zip_file_dir'] : null;

//echo "<br> bgl360_di_upload_zip_file_dir = " . $_SESSION['bgl360_di_upload_zip_file_dir'];
//echo "path   " . $_SESSION['bgl360_di_upload_zip_file_dir'];
//set username when user uploaded the .zip files
//define('bgl360_di_upload_zip_file_dir', $_SESSION['bgl360_di_upload_zip_file_dir']);

$current_date       = new DateTime(date("Y-m-d H:i:s"));
$dateTimeToSeconds  = $current_date->format('U');

$current_user = wp_get_current_user();
$upload_dir   = wp_upload_dir();
$user_dirname = $upload_dir['basedir'].'/bgl_upload/'.$current_user->user_login. '/' . $dateTimeToSeconds;

define('bgl360_di_upload_zip_file_dir', $user_dirname);
define('bgl360_di_upload_zip_file_dir_sub', $current_user->user_login .'/'. $dateTimeToSeconds);

//echo "dir $dir ";
define('bgl360_di_plugin_dir', substr(plugin_dir_path(__DIR__) , 0,strlen(plugin_dir_path(__DIR__))-1));

//Path to the uploaded .zip file need to change
//define('bgl360_di_dbf_uploaded_file_path' , bgl360_di_upload_zip_file_dir . '/BGL Desktop Integration/temp_dbf/new/');

$_SESSION['bgl360_di_dbf_uploaded_file_path'] = (!empty($_SESSION['bgl360_di_dbf_uploaded_file_path'])) ? $_SESSION['bgl360_di_dbf_uploaded_file_path'] : null;
$_SESSION['bgl360_di_dbf_uploaded_file_path'] = str_replace('/local_blg_bat_execute.bat', '', $_SESSION['bgl360_di_dbf_uploaded_file_path']);

//echo "<br>upload folder name " . $_SESSION['bgl360_di_dbf_uploaded_file_path'] ;

$batFileExt = '/Fixed';
define('bgl360_di_fund_deffs', $_SESSION['bgl360_di_dbf_uploaded_file_path'] . $batFileExt . '/funddefs.dbf');
define('bgl360_di_people_dbf', $_SESSION['bgl360_di_dbf_uploaded_file_path'] . $batFileExt . '/people.dbf');
define('bgl360_di_firm_dbf',   $_SESSION['bgl360_di_dbf_uploaded_file_path'] . $batFileExt . '/firm.dbf');
define('bgl360_di_office_dbf', $_SESSION['bgl360_di_dbf_uploaded_file_path'] . $batFileExt . '/office.dbf');
define('bgl360_di_chart_dbf',  $_SESSION['bgl360_di_dbf_uploaded_file_path'] . $batFileExt . '/chart.dbf');

//echo 'path = ' . bgl360_di_chart_dbf;


/*
define('bgl360_di_page_name_parent', 'bgl360');
define('bgl360_di_page_name_upload', 'upload');
define('bgl360_di_page_name_import', 'import');
*/

define('bgl360_di_page_name_upload', 'bgl-desktop-upload');
define('bgl360_di_page_name_import', 'bgl-desktop-import');

//define('bgl360_di_zip_upload_path', );
$_SESSION['bgl360_di_uploaded_file_settings'] = (!empty($_SESSION['bgl360_di_uploaded_file_settings'])) ? $_SESSION['bgl360_di_uploaded_file_settings'] : null;

$_SESSION['bgl360_di_uploaded_file_path_to_folder'] = (!empty($_SESSION['bgl360_di_uploaded_file_path_to_folder'])) ? $_SESSION['bgl360_di_uploaded_file_path_to_folder'] : null;

$_SESSION['bgl360_di_forms'] = [
    ['form_id'=>0, 'form_name'=>'- Select One -'],
    ['form_id'=>6, 'form_name'=>'SMSF Establishment'],
    ['form_id'=>15, 'form_name'=>'SMSF Pension'],
    ['form_id'=>56, 'form_name'=>'SMSF Borrowing'],
    ['form_id'=>53, 'form_name'=>'SMSF Deed Upgrade'],
    ['form_id'=>65, 'form_name'=>'SMSF Change of Trustee']
];

$_SESSION['response'] = '';

$_SESSION['bgl360_di_accepted_upload'] = ['.zip', '.ZIP'];
//$_SESSION['bgl360_di_custom_upload_name']  = '';

$_SESSION['bgl360_di_is_visited_upload_or_import_page'] = (!empty($_SESSION['bgl360_di_is_visited_upload_or_import_page'])? $_SESSION['bgl360_di_is_visited_upload_or_import_page']: null);
