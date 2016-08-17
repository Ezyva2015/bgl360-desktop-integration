<?php






/**
 * Short code call ex: [bgl360-di-upload]
 */
add_shortcode('bgl360-di-upload', 'bgl360_di_upload');

function bgl360_di_upload ($atts, $content=null) {

    bgl360_di_redirect_login();

    $current_user = wp_get_current_user();

    $upload_dir   = wp_upload_dir();

    $user_dirname = $upload_dir['basedir'].'/'.$current_user->user_login;

    //echo "upload dir " . $user_dirname;







    $html = '<div  class="container container-main">';

    $html .='<div class="container-sub" >';

    $html .= ''.  $_SESSION['response']['message'] .'';

    $html .= '<form method="POST" method="post" enctype="multipart/form-data" id="bgl360_di_upload_file" name="bgl360_di_upload_file">';

    $html .='
            <div class="row">

                <div class="col-md-2">
                </div>

                <div class="col-md-8 bgl360-di-fileupload-container" id="bgl360-di-fileupload-container" >
                        <div class="bgl360-di-fileupload-message" id="bgl360-di-fileupload-message" >
                            Drag Zip File Here to Upload
                        </div>

                         <div class="bgl360-di-fileupload-icon" >
                            <img onclick="bgl360_di_click_image_upload()" src="' .  plugins_url( '/assets/img/cloud-upload-icon.png', dirname(__FILE__) ) . '">
                         </div>
                         
                        <div class="bgl360-di-fileupload-file">
                            <input id="bgl360-di-fileupload-file-input" type="file" name="file" ondragleave="bgl360_di_ondragleave()"  ondragover="bgl360_di_ondragging()" ondrop="bgl360_di_add_file(event)" onChange="bgl360_di_changeFile(this)"  />

                            <div  class="bgl360-di-fileupload-loading"  id="bgl360-di-fileupload-loading"  >
                                  <img onclick="bgl360_di_click_image_upload()" src="' .  plugins_url( '/assets/img/loader.gif', dirname(__FILE__) ) . '">
                            </div>
                        </div>

                        <div>
                            <input type="submit" name="bgl360_dt_upload" id="bgl360_dt_upload" value="bgl360_di_upload_file" style="display:none" />
                        </div>


                </div>

                <div class="col-md-2">

                </div>

            </div>';
    $html .= '</div>';

    $html .= '</form>';

    $html .= '</div>';

    return $content . $html;
}





