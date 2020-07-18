<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_typeuser', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <input id="radUserdataType1" type="radio" name="radUserdataType" value="private" <?php if(empty($_SESSION['userdata_radUserdataType']) || $_SESSION['userdata_radUserdataType'] == 'private'){ echo('checked="checked"'); } ?> onclick="userdatatype('radUserdataType1', 'UserdataCompanyinfo');"/>
                            <label for="radUserdataType1" style="cursor: pointer">
                                <?php give_translation('subscription.typeuser_private', $echo, $config_showtranslationcode) ?>
                            </label>
                            &nbsp;
                            <input id="radUserdataType9" type="radio" name="radUserdataType" value="professional" <?php if(!empty($_SESSION['userdata_radUserdataType']) && $_SESSION['userdata_radUserdataType'] == 'professional'){ echo('checked="checked"'); } ?> onclick="userdatatype('radUserdataType9', 'UserdataCompanyinfo');"/>
                            <label for="radUserdataType9" style="cursor: pointer">
                                <?php give_translation('subscription.typeuser_professional', $echo, $config_showtranslationcode) ?>
                            </label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_title', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
<?php                       
                    cdreditor('dropdown', $userdata_nameS_title, $userdata_code_title, $userdata_statusobject_title, $userdata_id_title, $_SESSION['userdata_cdreditor_title_userdata'], false, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');                                      

                        if(!empty($_SESSION['msg_userdata_cdreditor_title_userdata']))
                        {
?>
                            <br clear="left"/>
                            <div class="font_error1"><?php echo($_SESSION['msg_userdata_cdreditor_title_userdata']); ?></div>
<?php
                        }
?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_firstname', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataFirstname" value="<?php if(!empty($_SESSION['userdata_txtUserdataFirstname'])){ echo($_SESSION['userdata_txtUserdataFirstname']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataFirstname']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataFirstname']); ?></div>
<?php
                }
?>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_lastname', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataLastname" value="<?php if(!empty($_SESSION['userdata_txtUserdataLastname'])){ echo($_SESSION['userdata_txtUserdataLastname']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataLastname']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataLastname']); ?></div>
<?php
                }
?>
            </td>
        </tr>
         
    </table></td>
</tr>
<tr id="UserdataCompanyinfo" style="<?php if(empty($_SESSION['userdata_radUserdataType']) || $_SESSION['userdata_radUserdataType'] != 'professional'){ echo('display: none;'); } ?>">
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_namecompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <input type="text" name="txtUserdataNamecompany" value="<?php if(!empty($_SESSION['userdata_txtUserdataNamecompany'])){ echo($_SESSION['userdata_txtUserdataNamecompany']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataNamecompany']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataNamecompany']); ?></div>
<?php
                }
?>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_typecompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
<?php                       
                    cdreditor('dropdown', $userdata_nameS_typecompany, $userdata_code_typecompany, $userdata_statusobject_typecompany, $userdata_id_typecompany, $_SESSION['userdata_cdreditor_typecompany_userdata'], false, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');                                                         
?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_activitycompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
<?php                       
                    cdreditor('dropdown', $userdata_nameS_activitycompany, $userdata_code_activitycompany, $userdata_statusobject_activitycompany, $userdata_id_activitycompany, $_SESSION['userdata_cdreditor_activitycompany_userdata'], false, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');                                      
?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_functioncompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
<?php                       
                    cdreditor('dropdown', $userdata_nameS_functioncompany, $userdata_code_functioncompany, $userdata_statusobject_functioncompany, $userdata_id_functioncompany, $_SESSION['userdata_cdreditor_functioncompany_userdata'], false, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');                                      
?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_siretcompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataSiretcompany" value="<?php if(!empty($_SESSION['userdata_txtUserdataSiretcompany'])){ echo($_SESSION['userdata_txtUserdataSiretcompany']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataSiretcompany']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataSiretcompany']); ?></div>
<?php
                }
?>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_vatintracompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserdataVatintracompany" value="<?php if(!empty($_SESSION['userdata_txtUserdataVatintracompany'])){ echo($_SESSION['userdata_txtUserdataVatintracompany']); } ?>"/>
            </td>
        </tr>
    </table></td>
</tr>
