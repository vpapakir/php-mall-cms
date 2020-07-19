<?php
#cdreditor getinfo
include('modules/user/userdata/userdata_getinfo.php');
#bt
include('modules/user/userdata/bt/bt_subscriptionform_userdata.php');
#refresh captcha
include('modules/user/userdata/bt/bt_refresh_captcha.php');
?>
<form method="post"><table width="100%" cellpadding="0" cellspacing="0">           
<?php
    if(empty($_SESSION['msg_subscriptionform_emailsent']))
    {
        include('modules/user/userdata/data/userdata_main_info.php');
        include('modules/user/userdata/data/userdata_address.php');
        include('modules/user/userdata/data/userdata_phone.php');
        include('modules/user/userdata/data/userdata_connectioninfo.php');
        include('modules/user/userdata/data/userdata_captcha.php');
?>  
        <tr>
            <td align="center" colspan="2">
                <div class="font_main" style="text-align: center; font-size: 9px;"><?php give_translation('main.legal_78-17', $echo, $config_showtranslationcode); ?></div>
            </td>
        </tr>
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
                        <input type="submit" name="bt_subscriptionform_userdata" value="<?php give_translation('main.bt_subscribe', '', $config_showtranslationcode); ?>"/>
                    </td>
                </tr> 
            </table></td>
        </tr>
<?php
    }
    else
    {
?>  
        <tr>
            <td align="center">
                <a class="link_info1" href="<?php echo($config_customheader.$main_home_rewritingF); ?>"><div><?php echo($_SESSION['msg_subscriptionform_emailsent']); ?></div></a>
            </td>
        </tr>
        <tr>
            <td>
                <div style="height: 4px;"></div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <a style="text-decoration: none;" href="<?php echo($config_customheader.$main_home_rewritingF); ?>"><span class="link_input"><?php give_translation('main.bt_home', $echo, $config_showtranslationcode); ?></span></a>
            </td>
        </tr>
<?php        
    }
?>
        
</table></form>
