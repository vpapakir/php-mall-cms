<tr>
    <td align="left"><table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('user_mailing.subtitle_sender_testemail', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input type="text" name="txtTestemailUserMailing" style="width: 200px;" value="<?php if(empty($_SESSION['usermailing_txtTestemailUserMailing'])){ echo($config_email_senderemail); }else{ echo($_SESSION['usermailing_txtTestemailUserMailing']); } ?>"
<?php
                    if(!empty($_SESSION['msg_usermailing_txtTestemailUserMailing']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_usermailing_txtTestemailUserMailing']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
    </table></td>
</tr>
