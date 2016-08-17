<?php

require_once('config/confuguration.php');


$fund      = new \App\Fund();
$trustee   = new \App\Trustees1();


echo "<pre>";
//
///**
// * Fund name = 2
// * State law to govern the fund (state)= 9
// *
// */
//
////echo "</pre>";
//echo "<br>\n fund name = " . $trustee->fundName;
//echo "<br>\n trustees address = " . $trustee->trusteeAddress;
//echo "<br>\n trustees type = " . $trustee->trusteeType;
//echo "<br>\n total trustee = " . $fund->fundMemberTotal;
//echo "<br>\n fund code = " . $fund->fundCode;


//$counter=0;
//for($i=0; $i< $fund->fundMemberTotal; $i++) {
//    $counter++;
//    echo "<br> \n -----------------------------------------------------";
//    $fund->getFundMembers($i);
//    echo "<br>\n fund member number " . $counter;
//    echo "<br>\n fundMemberTitle: " . $fund->fundMemberTitle;
//    echo "<br>\n fundMemberFirstName: " . $fund->fundMemberFirstName;
//    echo "<br>\n fundMemberSureName: " . $fund->fundMemberSureName;
//    echo "<br>\n fundMemberGender: " . $fund->fundMemberGender;
//    echo "<br>\n fundMemberFullName: " . $fund->fundMemberFullName;
//    echo "<br>\n fundMemberTFN: " . $fund->fundMemberTFN;
//    echo "<br>\n fundMemberDOB: " . $fund->fundMemberDOB . "\n\n\n";
//    echo "<br>\n fund member address = " . $fund->fundMemberAddress;
//}

    //*************************
    // start mapping the to gf.
    //*************************

    // set form id
    $formId = 6;

    // set current user logged in
    $user_id 	          = 1; //$current_user->ID;

    // entry init
    $entry                = array();

    $entry['form_id']     = $formId;
    $entry['created_by']  = $user_id;
    $entry['orderStatus'] = 'incomplete';


    $entry['137']   = 'BGL SF Desktop Import';
    $entry['139']   = 'Other Address';
    $entry['337']   = 'Other Address';
    $entry['357']   = 'Manual Address Input';
    $entry['358']   = 'Manual Address Input';

    $entry['2']     = $trustee->fundName;
    $entry['338']   = $trustee->trusteeAddress;
    $entry['111']   = $trustee->trusteeType;

    $entry['12']    = $fund->fundMemberTotal;


    $member_counter = 1;
    for($i=0; $i< $fund->fundMemberTotal; $i++) {

        $fund->getFundMembers($i);

        if($member_counter == 1) {
            $entry['71']    = $fund->fundMemberTitle;
            $entry['14']    = $fund->fundMemberFirstName;
            $entry['72']    = $fund->fundMemberSureName;
            $entry['417']   = $fund->fundMemberGender;
            $entry['323']   = $fund->fundMemberFullName;
            $entry['81']    = $fund->fundMemberTFN;
            $entry['15']    = $fund->fundMemberDOB;
            $entry['17']    = "Other Address";
            $entry['359.1'] = "Manual Address Input";
            $entry['316']   = $fund->fundMemberAddress;
        } else if ($member_counter == 2) {
            $entry['73']     = $fund->fundMemberTitle;
            $entry['25']     = $fund->fundMemberFirstName;
            $entry['74']     = $fund->fundMemberSureName;
            $entry['418']    = $fund->fundMemberGender;
            $entry['324']    = $fund->fundMemberFullName;
            $entry['82']     = $fund->fundMemberTFN;
            $entry['24']     = $fund->fundMemberDOB;
            $entry['169']    = "Other Address";
            $entry['360.1']  = "Manual Address Input";
            $entry['317']    = $fund->fundMemberAddress;
        } else if ($member_counter == 3) {
           // code here
        } else {
           // code here
        }

        $member_counter++;
    }

    // Fund Address
    $entry['416']     = $trustee->trusteeAddress;

    // Care Of
    $entry['265']   = 'undefined yet';

    print_r($entry);




















