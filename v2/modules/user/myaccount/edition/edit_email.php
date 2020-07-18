<?php
#getinfo
include('modules/user/myaccount/edition/edit_email/editemail_getinfo.php');
#bt
include('modules/user/myaccount/edition/bt/bt_backto_myaccount.php');
include('modules/user/myaccount/edition/edit_email/bt/bt_save_newemail.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_done_editemail']))
{
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_done_editemail']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
}
?>        
    <tr>
        <td><table class="block_main2" width="100%">   
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('myaccount_email_edit.subtitle_oldemail', $echo, $config_showtranslationcode); ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 250px;" type="text" name="txtOldemailUserdataEditEmail" value="<?php if(empty($_SESSION['myaccount_editemail_txtOldemailUserdataEditEmail'])){ echo($myaccount_editemail_oldemail); }else{ echo($_SESSION['myaccount_editemail_txtOldemailUserdataEditEmail']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_error_editemail_txtOldemailUserdataEditEmail']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_error_editemail_txtOldemailUserdataEditEmail']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('myaccount_email_edit.subtitle_newemail', $echo, $config_showtranslationcode); ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 250px;" type="text" name="txtNewemailUserdataEditEmail" value="<?php if(!empty($_SESSION['myaccount_editemail_txtNewemailUserdataEditEmail'])){ echo($_SESSION['myaccount_editemail_txtNewemailUserdataEditEmail']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_error_editemail_txtNewemailUserdataEditEmail']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_error_editemail_txtNewemailUserdataEditEmail']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('myaccount_email_edit.subtitle_confirmnewemail', $echo, $config_showtranslationcode); ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 250px;" type="text" name="txtConfirmnewemailUserdataEditEmail"/>
<?php
                    if(!empty($_SESSION['msg_error_editemail_txtConfirmnewemailUserdataEditEmail']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_error_editemail_txtConfirmnewemailUserdataEditEmail']); ?></div>
<?php
                    }
?>
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
                            <input type="submit" name="bt_backto_myaccount" value="<?php give_translation('main.bt_backto_myaccount', '', $config_showtranslationcode); ?>"/>
                            <input type="submit" name="bt_save_newemail" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>
        </table></td>
    </tr>
</table></form>
