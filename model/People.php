<?php

namespace App;

class People {

    private static $people_dbf_array = array();

    function __construct($people_dbf=bgl360_di_people_dbf) {
        self::$people_dbf_array = dbf_arr($people_dbf);
    }

    /**
     * This will only get 1 people because when pcode matched then it will return directly the people that matched.
     * @param $pCode
     * @return mixed
     */
    public static function getPeopleByPCode($pCode) {
        $peopleArray1 = array();
        foreach(self::$people_dbf_array as $key => $peopleArray) {
            if($peopleArray['PCODE'] == $pCode) {
                $peopleArray1[] = $peopleArray;
            }
        }
        return $peopleArray1;
    }

    /**
     * @param $pCode
     * @return int
     */
    public static function getMemberTotal($pCode) {
        $counter=0;
        foreach(self::$people_dbf_array as $key => $peopleArray) {
            if($peopleArray['PCODE'] == $pCode) {
                $counter++;
            }
        }
        return $counter;
    }

    /**
     * @param $pCode
     * @return array
     */
    public static function getTrusteesMemberByFirmPCode($pCode) {
        $peopleArray1 = array();
        foreach(self::$people_dbf_array as $key => $peopleArray) {
            if($peopleArray['PCODE'] == $pCode) {
                $peopleArray1[] = $peopleArray;
            }
        }
        return $peopleArray1;
    }

    /**
     * @param $pCode
     * @return mixed
     */
    public static function getPeopleRoCodeByPCode($pCode) {
        return self::getTrusteesMemberByFirmPCode($pCode)[0]['ROCODE'];
    }
}