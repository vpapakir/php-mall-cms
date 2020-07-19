<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_birthday', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
<?php
                birthday('cboUserdataBirthDay', 'cboUserdataBirthMonth', 'cboUserdataBirthYear', $_SESSION['subscriptionform_cboUserdataBirthDay'], $_SESSION['subscriptionform_cboUserdataBirthMonth'], $_SESSION['subscriptionform_cboUserdataBirthYear'], 1920, $config_birthday_maxyear, $language);
                if(!empty($_SESSION['msg_subscriptionform_birthday']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_subscriptionform_birthday']); ?></div>
<?php
                }
?>
            </td>
        </tr>    
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_website', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataWebsite" value="<?php if(!empty($_SESSION['subscriptionform_txtUserdataWebsite'])){ echo($_SESSION['subscriptionform_txtUserdataWebsite']); } ?>"/>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_landline', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <input type="text" name="txtUserdataLandline" value="<?php if(!empty($_SESSION['subscriptionform_txtUserdataLandline'])){ echo($_SESSION['subscriptionform_txtUserdataLandline']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_subscriptionform_phone']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_subscriptionform_phone']); ?></div>
<?php
                }
?>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_mobile', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataMobile" value="<?php if(!empty($_SESSION['subscriptionform_txtUserdataMobile'])){ echo($_SESSION['subscriptionform_txtUserdataMobile']); } ?>"/>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_fax', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataFax" value="<?php if(!empty($_SESSION['subscriptionform_txtUserdataFax'])){ echo($_SESSION['subscriptionform_txtUserdataFax']); } ?>"/>
            </td>
        </tr>        
    </table></td>
</tr>
