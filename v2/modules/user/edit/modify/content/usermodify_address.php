<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_address1', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <input type="text" name="txtUserdataAddress1" value="<?php if(!empty($_SESSION['userdata_txtUserdataAddress1'])){ echo($_SESSION['userdata_txtUserdataAddress1']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataAddress1']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataAddress1']); ?></div>
<?php
                }
?>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_address2', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataAddress2" value="<?php if(!empty($_SESSION['userdata_txtUserdataAddress2'])){ echo($_SESSION['userdata_txtUserdataAddress2']); } ?>"/>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_zip', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataZip" value="<?php if(!empty($_SESSION['userdata_txtUserdataZip'])){ echo($_SESSION['userdata_txtUserdataZip']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataZip']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataZip']); ?></div>
<?php
                }
?>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_city', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataCity" value="<?php if(!empty($_SESSION['userdata_txtUserdataCity'])){ echo($_SESSION['userdata_txtUserdataCity']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataCity']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataCity']); ?></div>
<?php
                }
?>           
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_country', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
<?php                       
                     cdrgeo('dropdown', $userdata_name_country, $userdata_code_country, $userdata_statusobject_country, $userdata_id_country, $_SESSION['userdata_cdrgeo_country_situation'], false);                                      
                    if(!empty($_SESSION['msg_userdata_cdrgeo_country_situation']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_userdata_cdrgeo_country_situation']); ?></div>
<?php
                    }
?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table></td>
</tr>
