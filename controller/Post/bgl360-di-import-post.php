<?php
error_reporting(1);

if ( !defined('ABSPATH') ) {
    define('ABSPATH', dirname(__FILE__) . '/');

}


//require_once (ABSPATH . 'wp-content/plugins/campusimport/class-gf_db_campus_order_data_importer.php');

//include "E:/xampp/htdocs/Tim/app.thesmsfacademy.com.au/developer/wordpress/wp-content/plugins/campusimport/class-gf_db_campus_order_data_importer.php";
// echo " ABSPATH = " . ABSPATH . 'wp-content/plugins/campusimport/class-gf_db_campus_order_data_importer.php' ;



if(isset($_POST['bgl360_di_import'])) {



    $enable_manual_mapping = false;

    if (empty($_POST['fundMemberSelected']) || empty($_POST['import_at']))
    {
        $_SESSION['response']['message'] = '<br> <div  class="alert alert-danger bgl360_di_error"  role="alert" > <b> You should select a member and document to import. </b></div>';
    }
    else
    {



        //    [form_id] => 6
        //    [formId] => 6
        //    [created_by] => 1
        //    [user_id] => 1
        //    [orderStatus] => incomplete
        //    [137] => BGL SF Desktop Import 17-08-2016 06



        $current_user = wp_get_current_user();
        $fund = new \App\Fund();
        $trustee = new \App\Trustees1();


        $formId = intval($_POST['import_at']);
        $fundMemberSelected = $_POST['fundMemberSelected'];
        $entry = array();

        $entry['form_id'] = $formId;
        $entry['formId'] = $formId;
        $entry['created_by'] = $current_user->ID;
        $member_counter = 1;

        switch ($formId) {
            //NEW SMSF
            case '6':

                $mappingData          = json_decode(bgl360_di_importerMapping(6, 'BGL Simple Fund Desktop')[0]->data, true);
                $entry                = getMappingValueBasedOnDbfField($mappingData, $_POST['fundMemberSelected']);
                $user_id              = $current_user->ID;
                $entry['user_id']     = $current_user->ID;
                $entry['orderStatus'] = 'incomplete';
                $entry['137']         = 'BGL SF Desktop Import ' . date('d-m-Y h');

                if($enable_manual_mapping == true) {
                    $fund_member_selected = $_POST['fundMemberSelected'];
                    $entry['2'] = $trustee->fundName;
                    $entry['9'] = $trustee->fundAddressState;

                    $entry['139'] = $trustee->fundAddress;
                    $entry['366'] = $trustee->fundAddressRoadD1;
                    $entry['367'] = $trustee->fundAddressRoadD2;
                    $entry['368'] = $trustee->fundAddressRoadD3;
                    $entry['369'] = $trustee->fundAddressState;
                    $entry['370'] = $trustee->fundAddressRoadD4;

                    $entry['111'] = $trustee->trusteeType;

                    $entry['12'] = $fund->fundMemberTotal;

                    for ($i = 0; $i < $fund->fundMemberTotal; $i++) {
                        $fund->getFundMembers($i);

                        print  "<br> fund member selected = " . str_replace(' ', '', strtolower($fundMemberSelected)) . "==" . str_replace(' ', '', strtolower($fund->fundMemberFullName));
                        $name1 = str_replace(' ', '', strtolower($fundMemberSelected));
                        $name2 = str_replace(' ', '', strtolower($fund->fundMemberFullName));


                        if ($trustee->trusteeType == 'Individual') {
                            if ($name1 == $name2) {

                                //print "<br> import individual";
                                $entry['188'] = $fund->fundMemberTitle;
                                $entry['199'] = $fund->fundMemberFirstName;
                                $entry['120'] = $fund->fundMemberSureName;
                                $entry['421'] = $fund->fundMemberGender;

                                // echo "<br> equal ";
                                //                         = 'given name '
                                //                         = 'family name'
                                //                         = 'gender'
                                //                         = 'Other Address'
                                //                         = 'address field'
                                //                        'hidden'
                                //                        'hidden'
                                //                        'hidden'
                                //                        'hidden''

                            } else {
                                echo "<br> not equal";
                            }


                        } else {
                            echo "<br> its a company";
                        }

                        if ($member_counter == 1) {
                            $entry['71'] = $fund->fundMemberTitle;
                            $entry['14'] = $fund->fundMemberFirstName;
                            $entry['72'] = $fund->fundMemberSureName;
                            $entry['417'] = $fund->fundMemberGender;
                            $entry['81'] = $fund->fundMemberTFN;

                            if (!empty($fund->fundMemberAddress)) {

                                $entry['17'] = "Other Address";
                                $entry['246'] = $fund->fundMemberAddress;
                                $entry['376'] = $fund->fundMemberAddressRoad1;
                                $entry['380'] = $fund->fundMemberAddressRoad2;
                                $entry['379'] = $fund->fundMemberAddressRoad3;
                                $entry['378'] = $fund->fundMemberAddressState;
                                $entry['377'] = $fund->fundMemberAddressRoad4;
                            }

                            //Trustee Meeting Address*
                            $entry['337'] = 'Other Address';
                            $entry['330'] = $trustee->fundAddress;;
                            $entry['371'] = $fund->fundMemberAddressRoad1;
                            $entry['372'] = $fund->fundMemberAddressRoad2;
                            $entry['373'] = $fund->fundMemberAddressRoad3;
                            $entry['374'] = $fund->fundMemberAddressState;
                            $entry['375'] = $fund->fundMemberAddressRoad4;

                        } else if ($member_counter == 2) {

                            $entry['73'] = $fund->fundMemberTitle;
                            $entry['25'] = $fund->fundMemberFirstName;
                            $entry['74'] = $fund->fundMemberSureName;
                            $entry['418'] = $fund->fundMemberGender;
                            $entry['82'] = $fund->fundMemberTFN;

                            if (!empty($fund->fundMemberAddress)) {
                                $entry['169'] = "Other Address";
                                $entry['247'] = $fund->fundMemberAddress;
                                $entry['381'] = $fund->fundMemberAddressRoad1;
                                $entry['382'] = $fund->fundMemberAddressRoad2;
                                $entry['383'] = $fund->fundMemberAddressRoad3;
                                $entry['384'] = $fund->fundMemberAddressState;
                                $entry['385'] = $fund->fundMemberAddressRoad4;
                            }

                        } else if ($member_counter == 3) {

                            $entry['75'] = $fund->fundMemberTitle;
                            $entry['33'] = $fund->fundMemberFirstName;
                            $entry['76'] = $fund->fundMemberSureName;
                            $entry['419'] = $fund->fundMemberGender;
                            $entry['83'] = $fund->fundMemberTFN;
                            if (!empty($fund->fundMemberAddress)) {
                                $entry['170'] = "Other Address";
                                $entry['248'] = $fund->fundMemberAddress;
                                $entry['386'] = $fund->fundMemberAddressRoad1;
                                $entry['387'] = $fund->fundMemberAddressRoad2;
                                $entry['388'] = $fund->fundMemberAddressRoad3;
                                $entry['389'] = $fund->fundMemberAddressState;
                                $entry['390'] = $fund->fundMemberAddressRoad4;
                            }
                        } else if ($member_counter == 4) {
                            $entry['77'] = $fund->fundMemberTitle;
                            $entry['42'] = $fund->fundMemberFirstName;
                            $entry['78'] = $fund->fundMemberSureName;
                            $entry['420'] = $fund->fundMemberGender;
                            $entry['84'] = $fund->fundMemberTFN;
                            if (!empty($fund->fundMemberAddress)) {
                                $entry['184'] = "Other Address";
                                $entry['249'] = $fund->fundMemberAddress;
                                $entry['391'] = $fund->fundMemberAddressRoad1;
                                $entry['392'] = $fund->fundMemberAddressRoad2;
                                $entry['393'] = $fund->fundMemberAddressRoad3;
                                $entry['394'] = $fund->fundMemberAddressState;
                                $entry['395'] = $fund->fundMemberAddressRoad4;
                            }
                        }


                        $member_counter++;


                    }
                    // Fund Address
                    // $entry['416'] = $trustee->trusteeAddress;
                    // Care Of
                    //$entry['265'] = 'undefined yet';
                }

                break;
            case '56':
                break;
            case '15':
                break;
            case '53':
                break;
            case '65':
                break;
        }

         echo "<pre>";
         print_r($entry);
         echo "</pre>";

        $newEntry = GFAPI::add_entry($entry);
        //$newEntry = GFAPI::add_entry($entry);


        //echo " <br> new entry response <br> ";
        //print_r( $newEntry );
        $importResult = $formId . $newEntry;

        if (is_string($newEntry)) {
            $importResult = $formId . $newEntry;
            $_SESSION['response']['status'] = '<span style="color:red" >Failed to GF entry id </span>' . $importResult;
            $_SESSION['response']['redirect'] = false;
            // echo print_r($newEntry,true);
        } else if ($newEntry) {
            unset($_SESSION['bgl360_di_uploaded_file_settings']);
            //is error
            $_SESSION['response']['status'] = '<span style="color:green" >Successfully Added to GF entry id = </span>'  . $importResult;
            $_SESSION['response']['redirect'] = true;
        }

        //echo $importResult;

        //if (!$importResult) {
         //   echo "<br> failled to save";
            //unset path so that we can redirect to upload if already imported the data
        //} else {
         //   echo "<br> success to save";
        //}

        if ($_POST['import_at'] > 0) {
            // echo "<pre>";
            // print_r($_SESSION);
            // echo "</pre>";
            //  unlink($_SESSION['bgl360_di_uploaded_file_path_to_folder']);
            // unlink($_SESSION['bgl360_di_uploaded_file_settings']['file']);
        }
        $_SESSION['response']['message'] = '<span> Redirecting to saved documents</span>';


        print   "<br> response = " . $_SESSION['response']['status'];
        print   "<br> new entry = " . $newEntry;
        print   "<br> form id  = " . $formId;
        print   "<br> user id  = "  . $user_id;
    }

}




