<?php /* Template Name: BGL360 Import */  //get_header();

error_reporting('-1');
error_reporting(E_ALL);
ini_set("display_errors", 1);
//require_once( $_SERVER['DOCUMENT_ROOT']."\wp-blog-header.php");
//if($current_user->ID < 1) { header("location: https://app.thesmsfacademy.com.au/wp-login.php"); }
global $wpdb;

$dbf_file = 'dbf/chart.dbf';
$db = dbase_open($dbf_file, 2);

$chart = array();

if ($db) {

    $record_numbers = dbase_numrecords($db);

    for($i=1; $i<=$record_numbers;$i++){
        $row = dbase_get_record_with_names($db, $i);

        if(substr($row['ACODE1'],0,1) == 5 && trim($row['PCODE']) <> '') {

            if(!array_key_exists($row['PCODE'],$chart)){

                $chart[] = $row;
            }

        }
    }

    //printR($chart,'Filtered from Chart.dbf');
}

$people = dbf_arr('dbf/people.dbf');
$funddefs = dbf_arr('dbf/funddefs.dbf');
$office = dbf_arr('dbf/office.dbf');
$firm = dbf_arr('dbf/firm.dbf');
$chart = dbf_arr('dbf/chart.dbf');

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

function printR($array,$title=''){

    if(is_array($array)){

        echo $title."<br/>".
            "||---------------------------------||<br/>".
            "<pre>";
        print_r($array);
        echo "</pre>".
            "END ".$title."<br/>".
            "||---------------------------------||<br/>";

    }else{
        echo $title."<br/>"."<pre>".$array.'</pre>';
    }
}

function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}

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


echo "<pre>";

echo "<h3> FIRM </h3>";
print_r($firm);

echo "<h3> PEOPLE </h3>";
print_r($people);

echo "<h3> OFFICE </h3>";
print_r($office);

echo "<h3> CHART </h3>";
print_r($chart);

