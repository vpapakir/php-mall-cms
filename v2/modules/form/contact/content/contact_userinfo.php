<tr>
<td align="left"><table class="block_main2" width="100%">
    <tr>
        <td align="left">
            <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
            <span class="font_subtitle">
                <?php give_translation('form_contactmain.subtitle_email', $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="left" width="<?php echo($right_column_width); ?>">
            <input style="width: 99%;" type="text" name="txtEmailFormContactMain" value="<?php if(!empty($_SESSION['form_contactmain_txtEmailFormContactMain'])){ echo($_SESSION['form_contactmain_txtEmailFormContactMain']); }else{ if(!empty($fcontactmain_userinfo_email)){ echo($fcontactmain_userinfo_email); } } ?>"/>
<?php
            if(!empty($_SESSION['msg_form_contactmain_txtEmailFormContactMain']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_form_contactmain_txtEmailFormContactMain']); ?></div>
<?php
            }
?>       
        </td>
    </tr>
    <tr>
        <td align="left">
            <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
            <span class="font_subtitle">
                <?php give_translation('form_contactmain.subtitle_name', $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="left" width="<?php echo($right_column_width); ?>">
            <input style="width: 200px;" type="text" name="txtNameFormContactMain" value="<?php if(!empty($_SESSION['form_contactmain_txtNameFormContactMain'])){ echo($_SESSION['form_contactmain_txtNameFormContactMain']); }else{ if(!empty($fcontactmain_userinfo_name)){ echo($fcontactmain_userinfo_name); } } ?>"/>
<?php
            if(!empty($_SESSION['msg_form_contactmain_txtNameFormContactMain']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_form_contactmain_txtNameFormContactMain']); ?></div>
<?php
            }
?>
        </td>
    </tr>
    <tr>
        <td align="left">
            <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
            <span class="font_subtitle">
                <?php give_translation('form_contactmain.subtitle_phone', $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="left" width="<?php echo($right_column_width); ?>">
            <input style="width: 150px;" type="text" name="txtPhoneFormContactMain" value="<?php if(!empty($_SESSION['form_contactmain_txtPhoneFormContactMain'])){ echo($_SESSION['form_contactmain_txtPhoneFormContactMain']); }else{ if(!empty($fcontactmain_userinfo_phone)){ echo($fcontactmain_userinfo_phone); } } ?>"/>
<?php
            if(!empty($_SESSION['msg_form_contactmain_txtPhoneFormContactMain']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_form_contactmain_txtPhoneFormContactMain']); ?></div>
<?php
            }
?>
        </td>
    </tr>
    <tr>
        <td align="left">
            <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
            <span class="font_subtitle">
                <?php give_translation('form_contactmain.subtitle_subject', $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="left" width="<?php echo($right_column_width); ?>">
<?php
            #cdreditor($fcontactmain_type_subject, $fcontactmain_nameS_subject, $fcontactmain_code_subject, $fcontactmain_statusobject_subject, $fcontactmain_id_subject, $_SESSION['form_contactmain_cdreditor_formcontact_subject'], false);
            if(!empty($_SESSION['msg_form_contactmain_cdreditor_formcontact_subject']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_form_contactmain_cdreditor_formcontact_subject']); ?></div>
<?php
            }
?>
        </td>
    </tr>
    <tr>
        <td align="left" style="vertical-align: top;">
            <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
            <span class="font_subtitle">
                <?php give_translation('form_contactmain.subtitle_msg', $echo, $config_showtranslationcode); ?>
            </span>
        </td>
        <td align="left" width="<?php echo($right_column_width); ?>">
            <textarea style="width: 99%;" rows="5" name="areaMsgFormContactMain"><?php if(!empty($_SESSION['form_contactmain_areaMsgFormContactMain'])){ echo($_SESSION['form_contactmain_areaMsgFormContactMain']); }  ?></textarea>
        </td>
    </tr>
</table></td>
</tr>
