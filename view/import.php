<?php
/**
 * Short code call ex: [bgl360-di-import]
 */
add_shortcode('bgl360-di-import', 'bgl360_di_import');


function bgl360_di_import ($atts, $content=null) {

        bgl360_di_redirect_login();


        $fund      = new \App\Fund();
        $trustee   = new \App\Trustees1();


        //    echo "<br> fundMemberAddress = " . $fund->fundMemberAddress;
        //    echo "<br> fundMemberAddressRoad1 = " . $fund->fundMemberAddressRoad1;
        //    echo "<br> fundMemberAddressRoad2 = " . $fund->fundMemberAddressRoad2;
        //    echo "<br> fundMemberAddressRoad3 = " . $fund->fundMemberAddressRoad3;
        //    echo "<br> fundMemberAddressRoad4 = " . $fund->fundMemberAddressRoad4;
        //    echo "<br> fundMemberAddressState = " . $fund->fundMemberAddressState;

        //echo "This is the import page";

        //echo "<br> fund name " . $trustee->fundName;

        //echo "<br> fund address " . $trustee->fundAddress;

        //print_r($_SESSION['bgl360_di_uploaded_file_settings']);


        $html = '<div  class="container container-main">';

        $html .='<div class="container-sub-import" style="width: 80%" >';


        $html .= $_SESSION['response']['status'];

        $html .= $_SESSION['response']['message'];

        $html .= '<form method="POST" />';

        $html .='<div class="row">
                <div class="col-md-8">
                    <b><h3> Data To Be Imported </h3></b>
                    <ul class="list-group">
                        <li  class="list-group-item"> <b>Fund Name:</b><br> ' . $trustee->fundName . '</li>
                        <li  class="list-group-item"> <b>Trustee:</b> <br>';

                                $trustee->getTrusteeMembers(0);
                                $html .=  $trustee->trusteeFullName;

                        $html .= '
                        </li>
                        <li  class="list-group-item"> <b>Members:</b>';
                             for($i=0; $i<$fund->fundMemberTotal; $i++) {
                                  $fund->getFundMembers($i);
                                  $html .= '<br>';
                                  $html .= $fund->fundMemberFullName ;
                             }
                        $html .= '
                         </li>
                     </ul>
                 </div>
                <div class="col-md-4">  </div>
            </div>';
        $html .='<br><br>';
        $html .= '<div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">

                     <b><p style="float:left; display: inline-block" > Which member will take the pension? </p></b> &nbsp; &nbsp;

                    <select name="fundMemberSelected" id="fundMemberSelected" >';
                        $html .= '<option value="">- Select One-</option>';
                        for($i=0; $i<$fund->fundMemberTotal; $i++) {
                            $fund->getFundMembers($i);
                            $html .= '<option value="' . $fund->fundMemberFullName . '">' . $fund->fundMemberFullName . '</option>' ;
                        }
                    $html .= '
                    </select>
                </div>
            </div>';
        $html .= '<div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8" style="margin-top:20px;">
                    <b><p style="float:left; display: inline-block" > Where would you like to import? </p> </b>&nbsp; &nbsp;
                       <select name="import_at" id="import_at" >';
                        foreach($_SESSION['bgl360_di_forms']  as $key => $form) {
                                $html .= '<option value="'  . $form['form_id']. '">' . $form['form_name'] . ' </option> ';
                        }
                     $html .= '
                     </select>
                </div>
            </div>';

        $html .= '<div><input type="submit" value="Import" name="bgl360_di_import"  /></div>';

        $html .= '</div>';

    if( $_SESSION['response']['redirect'] == true) {
        wp_redirect( site_url() . '/saved/documents');
    } else if(empty($_SESSION['bgl360_di_uploaded_file_settings'])) {
        wp_redirect( site_url() . '/' . bgl360_di_page_name_upload);
    }

    return $content . $html;
}





