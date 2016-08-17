<?php
error_reporting(0);
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//define('WP_USE_THEMES', false);
//define('STYLESHEETPATH', '');
//define('TEMPLATEPATH', '');
//include(ABSPATH . "wp-includes/query.php");
//require "D:\\inetpub\\devapp\\wwwroot\\wp-blog-header.php";

if(!function_exists('wp_get_current_user')) {include(ABSPATH . "wp-includes/pluggable.php");}

$paths = [ 'config' ];

foreach($paths as $key => $path):

    $files = glob(plugin_dir_path(__FILE__) . $path .'/*.php');

    foreach ($files as $file) {
        require($file);
    }
endforeach;

require_once('helper.php');

$path = plugin_dir_path(__FILE__);
require_once($path . '/model/People.php');
require_once($path . '/model/Office.php');
require_once($path . '/model/Firm.php');
require_once($path . '/model/Chart.php');
require_once($path . '/model/FundDeffs.php');
require_once($path . '/model/Fund.php');
require_once($path . '/model/Trustees.php');

new \App\FundDeffs();
new \App\People();
new \App\Office();
new \App\Firm();
new \App\Chart();


$paths = [ 'controller', 'controller/Post', 'view' ];

foreach($paths as $key => $path):

    $files = glob(plugin_dir_path(__FILE__) . $path .'/*.php');

    foreach ($files as $file) {
        require($file);
    }
endforeach;










