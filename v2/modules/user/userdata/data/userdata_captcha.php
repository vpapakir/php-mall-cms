<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_captcha', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left">
<?php
                            include('modules/captcha/dinx/captcha.php');                           
?>                            
                        </td>
                        <td align="right" width="100%">
                            <input style="width: 70px;" type="text" name="txtUserdataCaptcha"/>
                            <input style="display: none;" hidden="hidden" type="text" name="txtUserdataHiddenK" value="<?php echo($_SESSION['current_captcha_code']); ?>"/>
                            &nbsp;
<?php
                            if(!empty($_SESSION['msg_subscriptionform_txtUserdataCaptcha']))
                            {
?>
                                <br clear="left"/>
                                <div class="font_error1" style="text-align: center;"><?php echo($_SESSION['msg_subscriptionform_txtUserdataCaptcha']); ?></div>
<?php
                            }
?>                            
                        </td>
                        <td align="right">
                            <input id="bt_refresh_captcha" type="image" src="<?php echo($config_customheader.'graphics/icons/refresh/refresh.gif'); ?>" alt="refresh" name="bt_refresh_captcha" onmouseover="langimage('bt_refresh_captcha', '<?php echo($config_customheader.'graphics/icons/refresh/refresh-hover.gif'); ?>')" onmouseout="langimage('bt_refresh_captcha', '<?php echo($config_customheader.'graphics/icons/refresh/refresh.gif'); ?>')"/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table></td>
</tr>
