<?php

namespace App;

use App\People;

class Chart {

    public
        $totalMember,
        $fundMemberTitle,
        $fundMemberFirstName,
        $fundMemberSureName,
        $fundMemberGender,
        $fundMemberFullName,
        $fundMemberTFN,
        $fundMemberDOB,
        $fundMemberAddress;
    public
        $memberAddress;

    public
        $fundMemberAddressRoad1,
        $fundMemberAddressRoad2,
        $fundMemberAddressRoad3,
        $fundMemberAddressRoad4,
        $fundMemberAddressState;

    private static $chart_dbf_file;

    /**
     * Chart constructor.
     * @param string $chart_dbf
     */
    function __construct($chart_dbf=bgl360_di_chart_dbf) {
        self::$chart_dbf_file = dbf_arr($chart_dbf);
    }

    /**
     * get people code
     * @param $pCode
     * @return int
     */
    public static function getPeople($pCode) {
        foreach(self::$chart_dbf_file as $key => $value) {
            if($value['PCODE'] == $pCode) {
                return $value;
            }
        }
        return 0;
    }

    /**
     * get fund
     * @param $index
     */
    public function getFundMembers($index) {

        $fundMember                = self::getChartWithPCode()[$index];
        $pCode                     = $fundMember['PCODE'];
        $peopleDetail              = People::getPeopleByPCode($pCode)[0];
        $this->fundMemberTitle     = strtolower($peopleDetail['TITLE']);
        $this->fundMemberTitle     = ucfirst($this->fundMemberTitle);
        $this->fundMemberSureName  = $peopleDetail['PSURNAME'];
        $this->fundMemberFirstName = $peopleDetail['PFIRSTNAME'];
        $this->fundMemberGender    = ($peopleDetail['SEX'] == 'M' ) ? "Male" : "Female";
        $this->fundMemberTFN       = $peopleDetail['PTFN'];
        $this->fundMemberDOB       = $peopleDetail['PDOB'];
        $this->fundMemberFullName  = $peopleDetail['PFIRSTNAME'] .' ' . $peopleDetail['PSURNAME'];
        //echo "<br>\n  pcode " .  $pCode;
        $roCode                    =  People::getPeopleRoCodeByPCode($pCode);
        //echo "<br>\n rocode " .  $roCode;
        $Address                   = Office::getOfficeAddressByRoCode($roCode);
        // echo "<br> \n print address";
        // print_r($Address);
        $this->fundMemberAddressRoad1 = trim($Address['ROADD1']);
        $this->fundMemberAddressRoad2 = trim($Address['ROADD2']);
        $this->fundMemberAddressRoad3 = trim($Address['ROADD3']);
        $this->fundMemberAddressState = bbl360_di_stateNumberToStateAbbreviation(trim($Address['STATE']));
        $this->fundMemberAddressRoad4 = trim($Address['ROADD4']);
        $this->fundMemberAddress = $this->fundMemberAddressRoad1 . ', ' . $this->fundMemberAddressRoad2 . ', ' .  $this->fundMemberAddressRoad3 . ', ' . $this->fundMemberAddressState  . ', ' . $this->fundMemberAddressRoad4;
        $this->fundMemberAddress = preg_replace('/\s+/', ' ', $this->fundMemberAddress);
        // echo "pcode " . $fundMember['PCODE'];
        return;
    }

    /**
     * @return array
     */
    public static function getChartWithPCode() {
         $dataArray = array();
        foreach(self::$chart_dbf_file as $key => $valueArray) {
            $pCode = str_replace(' ', '',$valueArray['PCODE']);
            if(!empty($pCode)) {
                if(!self::isExist($dataArray, $valueArray['PCODE'])) {
                    $dataArray[] = $valueArray;
                }
            }
        }
        return $dataArray;
    }

    /**
     * @param $dataArray
     * @param $pCode
     * @return bool
     */
    private static function isExist($dataArray,$pCode) {
        //  echo "<br>-----------------------------------";
        // print_r($dataArray);
        foreach($dataArray as $key => $val) {
            // echo "<br> pcode " . $pCode;
            // if(in_array($pCode, $val)) {
            if($val['PCODE'] == $pCode) {
                // echo "<br><span style='color:green'>in array PCODE = $pCode</span>";
                return true;
            } else {
                // echo "<br><span style='color:red'>not in array</span>";
            }
        }
        return false;
        //flat array
        //check if exist
        //if exist then return false
        //else return true
    }
}