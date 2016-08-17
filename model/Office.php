<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 7/7/2016
 * Time: 5:20 PM
 */

namespace App;




class Office
{
    private static $office_dbf_array,$counter=0;

    /**
     * Office constructor.
     * @param string $office_dbf
     */
    function __construct($office_dbf=bgl360_di_office_dbf) {
        self::$office_dbf_array =  dbf_arr($office_dbf);
    }

    /**
     * @param $roCode
     * @return int
     */
    public static function getTrusteesAddressByRoCode($roCode) {
        //        echo "<br> \n rocode now in function " . $roCode;
        foreach (self::$office_dbf_array as $key => $officeArray) {
            if( in_array($roCode,  $officeArray)) {
                return $officeArray;
            }
        }
        return 0;
    }

    /**
     * @param $roCode
     * @return int
     */
    public static function getOfficeAddressByRoCode($roCode) {
        return self::getTrusteesAddressByRoCode($roCode);
    }
}