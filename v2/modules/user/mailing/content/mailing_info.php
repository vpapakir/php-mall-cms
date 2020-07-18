<tr>
    <td align="left"><table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('user_mailing.subtitle_sender_name', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input type="text" name="txtNameUserMailing" style="width: 200px;" value="<?php if(empty($_SESSION['usermailing_txtNameUserMailing'])){ echo($config_email_sendername); }else{ echo($_SESSION['usermailing_txtNameUserMailing']); } ?>"
<?php
                    if(!empty($_SESSION['msg_usermailing_txtNameUserMailing']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_usermailing_txtNameUserMailing']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('user_mailing.subtitle_sender_email', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input type="text" name="txtEmailUserMailing" style="width: 200px;" value="<?php if(empty($_SESSION['usermailing_txtEmailUserMailing'])){ echo($config_email_senderemail); }else{ echo($_SESSION['usermailing_txtEmailUserMailing']); } ?>"
<?php
                    if(!empty($_SESSION['msg_usermailing_txtEmailUserMailing']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_usermailing_txtEmailUserMailing']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('user_mailing.subtitle_subject_title', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input type="text" name="txtTitleSubjectUserMailing" style="width: 200px;" value="<?php if(empty($_SESSION['usermailing_txtTitleSubjectUserMailing'])){ echo('['.$config_email_sendername.']'); }else{ echo($_SESSION['usermailing_txtTitleSubjectUserMailing']); } ?>"
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('user_mailing.subtitle_subject_content', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input type="text" name="txtDescSubjectUserMailing" style="width: 99%;" value="<?php if(!empty($_SESSION['usermailing_txtDescSubjectUserMailing'])){ echo($_SESSION['usermailing_txtDescSubjectUserMailing']); } ?>"
<?php
                    if(!empty($_SESSION['msg_usermailing_txtDescSubjectUserMailing']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_usermailing_txtDescSubjectUserMailing']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" style="vertical-align: top;">
                    <span class="font_subtitle">
                        <?php give_translation('user_mailing.subtitle_receiver_email', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <textarea type="text" name="areaReceiverUserMailing" style="width: 99%;" rows="4"><?php if(!empty($_SESSION['usermailing_areaReceiverUserMailing'])){ echo($_SESSION['usermailing_areaReceiverUserMailing']); } ?></textarea>
                </td>
            </tr>
    </table></td>
</tr>
