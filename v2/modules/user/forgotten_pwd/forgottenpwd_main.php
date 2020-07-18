<?php
#bt
include('modules/user/forgotten_pwd/bt/bt_backto_home.php');
include('modules/user/forgotten_pwd/bt/bt_send_pwd.php');
?>

<form method="post">
    <table width="100%">
<?php
        if(!empty($_SESSION['msg_done_forgottenpwd']))
        {
            $_SESSION['unset_afterrefresh_forgottenpwd']++;
?>
            <tr>
                <td align="left">
                    <table width="100%" class="block_msg1">
                        <tr>
                            <td align="center">
                                <span><?php echo($_SESSION['msg_done_forgottenpwd']); ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
<?php
            if($_SESSION['unset_afterrefresh_forgottenpwd'] >= 2)
            {
                unset($_SESSION['msg_done_forgottenpwd']);
                unset($_SESSION['unset_afterrefresh_forgottenpwd']);
            }
        }
?>
        <tr>
            <td align="left"><table class="block_main2" width="100%">
                    <tr>
                        <td align="left">
                            <span class="font_subtitle">
                                <?php give_translation('forgotten_pwd.subtitle_email', $echo, $config_showtranslationcode); ?>
                            </span>
                        </td>
                        <td align="left" width="<?php echo($right_column_width); ?>">
                            <input style="width: 99%;" type="text" name="txtEmailForgottenpwd" value="<?php if(!empty($_SESSION['forgottenpwd_txtEmailForgottenpwd'])){ echo($_SESSION['forgottenpwd_txtEmailForgottenpwd']); } ?>"/>
<?php
                            if(!empty($_SESSION['msg_forgottenpwd_txtEmailForgottenpwd']))
                            {
?>
                                <br clear="left"/>
                                <div class="font_error1"><?php echo($_SESSION['msg_forgottenpwd_txtEmailForgottenpwd']); ?></div>
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
                                    <input type="submit" name="bt_backto_home" value="<?php give_translation('main.bt_home', '', $config_showtranslationcode); ?>"/>
                                    <input type="submit" name="bt_send_pwd" value="<?php give_translation('main.bt_submit', '', $config_showtranslationcode); ?>"/>
                                </td>
                            </tr> 
                        </table></td>
                    </tr>
            </table></td>
        </tr>
    </table>
</form>
