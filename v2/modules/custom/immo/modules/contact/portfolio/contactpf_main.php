<?php
include('modules/custom/immo/modules/contact/portfolio/contactpf_getinfo.php');
include('modules/custom/immo/modules/contact/portfolio/bt/bt_send_request_portfolio.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_form_visit_done']))
{
    $_SESSION['unset_afterrefresh_form_visit']++;
?>
    <tr>
        <td align="left" colspan="2">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_form_visit_done']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_form_visit'] >= 2)
    {
        unset($_SESSION['msg_form_visit_done']);
        unset($_SESSION['unset_afterrefresh_form_visit']);
    }
}

    if(!empty($_SESSION['msg_form_visit_chkrequestpf']))
    {
?>
        <tr>
            <td></td>
            <td align="left">
                <div class="font_error1"><?php echo($_SESSION['msg_form_visit_chkrequestpf']); ?></div>
            </td>
        </tr>
        
<?php
    }


   include('modules/custom/immo/modules/contact/portfolio/listing/contactpf_listing.php');
   include('modules/custom/immo/modules/contact/portfolio/content/contactpf_info.php');
   include('modules/custom/immo/modules/contact/portfolio/content/contactpf_msg.php');   
?>
   <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
    </tr>
    <tr>
        <td colspan="2"><table width="100%" style="">
            <tr>        
                <td align="center">
                    <input type="submit" name="bt_send_request_portfolio" value="<?php give_translation('main.bt_submit', '', $config_showtranslationcode); ?>"/>
                </td>
            </tr> 
        </table></td>
    </tr>     
        
</table></form>
