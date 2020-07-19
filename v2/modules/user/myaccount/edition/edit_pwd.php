<?php
#bt
include('modules/user/myaccount/edition/bt/bt_backto_myaccount.php');
include('modules/user/myaccount/edition/edit_pwd/bt/bt_save_newpwd.php');
?>
<form method="post"><table width="100%">
<?php
if(!empty($_SESSION['msg_done_editpwd']))
{
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_done_editpwd']); ?></span>
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
                    <?php give_translation('myaccount_pwd_edit.subtitle_oldpwd', $echo, $config_showtranslationcode); ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 250px;" type="password" name="txtOldpwdUserdataEditPwd" value="<?php if(!empty($_SESSION['myaccount_editpwd_txtOldpwdUserdataEditPwd'])){ echo($_SESSION['myaccount_editpwd_txtOldpwdUserdataEditPwd']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_error_editpwd_txtOldpwdUserdataEditPwd']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_error_editpwd_txtOldpwdUserdataEditPwd']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('myaccount_pwd_edit.subtitle_newpwd', $echo, $config_showtranslationcode); ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 250px;" type="password" name="txtNewpwdUserdataEditPwd" value="<?php if(!empty($_SESSION['myaccount_editpwd_txtNewpwdUserdataEditPwd'])){ echo($_SESSION['myaccount_editpwd_txtNewpwdUserdataEditPwd']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_error_editpwd_txtNewpwdUserdataEditPwd']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_error_editpwd_txtNewpwdUserdataEditPwd']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    <?php give_translation('myaccount_pwd_edit.subtitle_confirmnewpwd', $echo, $config_showtranslationcode); ?>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 250px;" type="password" name="txtConfirmnewpwdUserdataEditPwd"/>
<?php
                    if(!empty($_SESSION['msg_error_editpwd_txtConfirmnewpwdUserdataEditPwd']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_error_editpwd_txtConfirmnewpwdUserdataEditPwd']); ?></div>
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
                            <input type="submit" name="bt_save_newpwd" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>
        </table></td>
    </tr>
</table></form>
