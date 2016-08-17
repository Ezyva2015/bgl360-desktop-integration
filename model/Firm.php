<?php
namespace App;


use App\People;
use App\Office;

class Firm {

    public $fundAddress,$fundName,$trusteeType,$trusteeTypeValue;

    public $trusteeAddress,$memberAddress, $FundMemberTotal;

    public $trusteeGender,$trusteeFirstName,$trusteeFamilyName,$trusteeTitle,$trusteeFullName,$trusteeMemberTotal;

    public $fundAddressRoadD1, $fundAddressRoadD2, $fundAddressRoadD3, $fundAddressState, $fundAddressRoadD4;

    public $trusteesTotal;

    public $memberTotalTrustee;

    public $pCode;

    private $firm_dbf_array,$counter=0;

    /**
     * Firm constructor.
     * @param string $firm_dbf
     * @param int $counter
     */
    function __construct($firm_dbf=bgl360_di_firm_dbf,$counter=0) {
        $this->firm_dbf_array =  dbf_arr($firm_dbf);
        $this->counter = $counter;
        $this->setData();
    }

    /**
     *
     */
    public function setData() {
        // echo "<H3> Chart </H3>";
        // rint_r( $this->firm_dbf_array[$this->counter]);
        $pcode = $this->firm_dbf_array[$this->counter]['TRUSTEE'];
        $fundName = $this->firm_dbf_array[$this->counter]['ENTITYNAME'];
        $this->FundMemberTotal = $this->firm_dbf_array[$this->counter]['MEMBERS'];

        $this->pCode = $pcode;

        //get fund name
        $this->fundName = $fundName;

        //get trustees address
        // echo "<br>get trustees address pcode = " . $pcode;
        $peopleDetail  = People::getPeopleByPCode($pcode);

        $this->trusteeMemberTotal = count($peopleDetail);

        //echo "<br> people array ";
        // echo "<pre>";
        // print_r($peopleDetail);
        // echo "</pre>";

        $roCode = $peopleDetail[0]['ROCODE'];

        // echo "<br> office address rocode = " . $roCode;
        $officeDetail = Office::getTrusteesAddressByRoCode($roCode);
        // print_r($officeDetail);

        $this->fundAddressRoadD1 = trim($officeDetail['ROADD1']);
        $this->fundAddressRoadD2 = trim($officeDetail['ROADD2']);
        $this->fundAddressRoadD3 = trim($officeDetail['ROADD3']);
        $this->fundAddressState  = bbl360_di_stateNumberToStateAbbreviation(trim($officeDetail['STATE']));
        $this->fundAddressRoadD4 = trim($officeDetail['ROADD4']);
        $this->fundAddress       = $this->fundAddressRoadD1 . ', ' . $this->fundAddressRoadD2 . ', ' .  $this->fundAddressRoadD3 . ', ' .  $this->fundAddressState . ', ' . $this->fundAddressRoadD4;

        // $this->fundAddress = trim($officeDetail['ROADD1']) .', '. trim($officeDetail['ROADD2']) .', '. trim($officeDetail['ROADD3']);
        // $this->fundAddress = preg_replace('/\s+/', ' ', $this->fundAddress);

        $this->memberTotalTrustee = People::getMemberTotal($pcode);

        //get trustee type

        $this->trusteeTypeValue = strtolower($peopleDetail[0]['PTYPE']);
        /*
        if( strtolower($peopleDetail[0]['PTYPE']) == 'j'){
            $this->trusteeType = 'Individuals';
        } else {
            $this->trusteeType = 'Company - Already Registered';
        }
        */

        $this->getTrusteeMembers(0);
        // echo "<br> trustee Full Name " . $this->trusteeFullName;
        if(!bgl360_di_isTrusteeTypeCompany($this->trusteeFullName)){
            $this->trusteeType = 'Individuals';
        } else {
            $this->trusteeType = 'Company - Already Registered';
        }
    }

    /**
     * Query to be change if found out status is different
     * @param $index
     */
    public function getTrusteeMembers($index) {

        $pcode = $this->firm_dbf_array[0]['TRUSTEE'];
        $peopleDetail  = People::getPeopleByPCode($pcode);
        $this->trusteeGender     = $peopleDetail[$index]['SEX'];
        $this->trusteeFirstName  = $peopleDetail[$index]['PFIRSTNAME'];
        $this->trusteeFamilyName = $peopleDetail[$index]['PSURNAME'];
        $this->trusteeTitle      = $peopleDetail[$index]['TITLE'];
        $this->trusteeFullName   = trim($peopleDetail[$index]['PFIRSTNAME'] . ' ' . $peopleDetail[$index]['PSURNAME']);
    }

    /**
     * @return array
     */
    public function getMemberTrustees() {
        return People::getTrusteesMemberByFirmPCode($this->pCode);
    }
}

