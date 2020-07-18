<?php
$message .= '<tr>        
             <td align="center">
             <table width="100%" border="0" cellpadding="0" cellspacing="0"> 
                <tr>
                    <td align="center">
                    <div>
                        <table align="center" style="width: 600px; font-size: 12px; font-family: \'Helvetica\', \'Arial\', \'Verdana\', \'Sans-Serif\'; color: black;" border="0">';

#title
include('modules/custom/immo/modules/email/script/product_email/script/title.php');

$message .= '<tr>
                <td><table class="block_main1" width="100%" border="0"">';

#intro
include('modules/custom/immo/modules/email/script/product_email/script/intro.php');
#image main
include('modules/custom/immo/modules/email/script/product_email/script/image_main.php');

$message .='    
    <tr>
    <td style="vertical-align: top;"><table width="100%" border="0" cellspacing="0" cellpadding="0">    
        <tr>
            <td style="vertical-align: top;"><table width="100%"  cellspacing="0" cellpadding="0">';


#include product specification
$id_page = $_SESSION['kform_prodemail_idpage'];
$template_page = 'custom_immo';
include('modules/custom/immo/modules/main_frame/insert_page_getinfo.php');

#comdetails
include('modules/custom/immo/modules/email/script/product_email/script/comdetails.php');
#map
include('modules/custom/immo/modules/email/script/product_email/script/map.php');
#image others
include('modules/custom/immo/modules/email/script/product_email/script/image_other.php');

$message .= '</table></td>

            <td><div style="width: 4px;"></div></td>

            <td width="100%" style="vertical-align: top;">
                <table style="margin: 0px 0px 0px 0px;" width="100%" cellpadding="0" cellspacing="0">';

#product details
include('modules/custom/immo/modules/email/script/product_email/script/product_details.php');
#desc
include('modules/custom/immo/modules/email/script/product_email/script/desc.php');
#dpe
include('modules/custom/immo/modules/email/script/product_email/script/dpe.php');
#ges
include('modules/custom/immo/modules/email/script/product_email/script/ges.php');


$message .= '</table></td>
             </tr>';
$message .= '</table></td>
             </tr>';
#close html main table
$message .= '</table>
             </div>
            </td>
           </tr>
          </table>
         </td>
        </tr>';
?>
