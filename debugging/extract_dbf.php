<?php

define('bgl360_di_fund_deffs', '../resources/dbf/funddefs.dbf');
define('bgl360_di_people_dbf', '../resources/dbf/people.dbf');
define('bgl360_di_firm_dbf',   '../resources/dbf/firm.dbf');
define('bgl360_di_office_dbf', '../resources/dbf/office.dbf');
define('bgl360_di_chart_dbf',  '../resources/dbf/chart.dbf');

//echo "<pre>";
/**
 * Remember
 * PCODE is a unique id for a person in the person.dbf
 * REGADD is a unique id for an address (“registered address = regadd”) in the office.dbf
 * I wrote 1,2,3 so that you could see what fields join the files together. If you look at the Google Sheet i shared with you, it should make sense
 *
 * PCODE in chart.dbf are the Fund Members
 * PCODE in firm.dbf is the Trustee(s)
 * so you would look at the PCODE in both files, and then query people.dbf to get the details
 *
 * Issue: its counting 2 trustees member in firm but code actually found 1 member trustees, so default calculation of array is not correct to the actual calculation of the code
 */

require_once('../helper.php');
require_once('../model/People.php');
require_once('../model/Office.php');
require_once('../model/Firm.php');
require_once('../model/Chart.php');
require_once('../model/FundDeffs.php');
require_once('../model/Fund.php');
require_once('../model/Trustees.php');

new \App\FundDeffs();
new \App\People();
new \App\Office();
new \App\Firm();
new \App\Chart();

$fund      = new \App\Fund();
$trustee   = new \App\Trustees1();




//
///**
// * Fund name = 2
// * State law to govern the fund (state)= 9
// *
// */
//
////echo "</pre>";

echo "<br>\n fund name = " . $trustee->fundName;
echo "<br>\n trustees address = " . $trustee->fundAddress;
echo "<br>\n trustee type value = " . $trustee->trusteeTypeValue;
echo "<br>\n trustees type = " . $trustee->trusteeType;
echo "<br>\n total fund member total = " . $fund->fundMemberTotal;
echo "<br>\n fund code = " .  $fund->fundCode;
echo "<br>\n total member trustee  = " . $trustee->trusteeMemberTotal;


$trustee->getTrusteeMembers(0);
echo "<br> \n trustee name = " .  $trustee->trusteeFullName;



$counter=0;
for($i=0; $i< $fund->fundMemberTotal; $i++) {
    $counter++;
    echo "<br> \n -----------------------------------------------------";
    $fund->getFundMembers($i);
    echo "<br>\n fund member number " . $counter;
    echo "<br>\n fundMemberTitle: " . $fund->fundMemberTitle;
    echo "<br>\n fundMemberFirstName: " . $fund->fundMemberFirstName;
    echo "<br>\n fundMemberSureName: " . $fund->fundMemberSureName;
    echo "<br>\n fundMemberGender: " . $fund->fundMemberGender;
    echo "<br>\n fundMemberFullName: " . $fund->fundMemberFullName;
    echo "<br>\n fundMemberTFN: " . $fund->fundMemberTFN;
    echo "<br>\n fundMemberDOB: " . $fund->fundMemberDOB;
    echo "<br>\n fund member address = " . $fund->fundMemberAddress;
}

//echo "\n \n \n \n <br><br><br><br> get trustees member <pre> ";
//
//print_r($trustee->getMemberTrustees());
//





