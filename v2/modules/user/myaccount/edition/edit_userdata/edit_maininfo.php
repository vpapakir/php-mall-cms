<tr>
    <td align="left"><table class="block_main2" width="100%">
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_typeuser', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <input id="radUserEditionType1" type="radio" name="radUserEditionType" value="private" <?php if(empty($_SESSION['myaccount_useredition_radUserEditionType']) || $_SESSION['myaccount_useredition_radUserEditionType'] == 'private'){ echo('checked="checked"'); } ?> onclick="userdatatype('radUserEditionType1', 'UserEditionCompanyinfo');"/>
                            <label for="radUserEditionType1" style="cursor: pointer">
                                <?php give_translation('subscription.typeuser_private', $echo, $config_showtranslationcode) ?>
                            </label>
                            &nbsp;
                            <input id="radUserEditionType9" type="radio" name="radUserEditionType" value="professional" <?php if(!empty($_SESSION['myaccount_useredition_radUserEditionType']) && $_SESSION['myaccount_useredition_radUserEditionType'] == 'professional'){ echo('checked="checked"'); } ?> onclick="userdatatype('radUserEditionType9', 'UserEditionCompanyinfo');"/>
                            <label for="radUserEditionType9" style="cursor: pointer">
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
                    //if(empty($_SESSION['myaccount_useredition_cdreditor_title_UserEdition'])){ $myaccount_useredition_session_title = $tempmyaccount_useredition_session_title; }else{ $myaccount_useredition_session_title = $_SESSION['myaccount_useredition_cdreditor_title_UserEdition']; }
                    cdreditor('dropdown', $myaccountedit_nameS_title, $myaccountedit_code_title, $myaccountedit_statusobject_title, $myaccountedit_id_title, $_SESSION['myaccount_useredition_cdreditor_title_UserEdition'], false, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');                                      

                        if(!empty($_SESSION['msg_myaccount_useredition_cdreditor_title_UserEdition']))
                        {
?>
                            <br clear="left"/>
                            <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_cdreditor_title_UserEdition']); ?></div>
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
                <input type="text" name="txtUserEditionFirstname" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionFirstname'])){ echo($_SESSION['myaccount_useredition_txtUserEditionFirstname']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_myaccount_useredition_txtUserEditionFirstname']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_txtUserEditionFirstname']); ?></div>
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
                <input type="text" name="txtUserEditionLastname" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionLastname'])){ echo($_SESSION['myaccount_useredition_txtUserEditionLastname']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_myaccount_useredition_txtUserEditionLastname']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_txtUserEditionLastname']); ?></div>
<?php
                }
?>
            </td>
        </tr>
         
    </table></td>
</tr>
<tr id="UserEditionCompanyinfo" style="<?php if(empty($_SESSION['myaccount_useredition_radUserEditionType']) || $_SESSION['myaccount_useredition_radUserEditionType'] != 'professional'){ echo('display: none;'); } ?>">
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_namecompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <input type="text" name="txtUserEditionNamecompany" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionNamecompany'])){ echo($_SESSION['myaccount_useredition_txtUserEditionNamecompany']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_myaccount_useredition_txtUserEditionNamecompany']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_txtUserEditionNamecompany']); ?></div>
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
                    cdreditor('dropdown', $myaccountedit_nameS_typecompany, $myaccountedit_code_typecompany, $myaccountedit_statusobject_typecompany, $myaccountedit_id_typecompany, $_SESSION['myaccount_useredition_cdreditor_typecompany_UserEdition'], false, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');                                                         
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
                    cdreditor('dropdown', $myaccountedit_nameS_activitycompany, $myaccountedit_code_activitycompany, $myaccountedit_statusobject_activitycompany, $myaccountedit_id_activitycompany, $_SESSION['myaccount_useredition_cdreditor_activitycompany_UserEdition'], false, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');                                      
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
                    cdreditor('dropdown', $myaccountedit_nameS_functioncompany, $myaccountedit_code_functioncompany, $myaccountedit_statusobject_functioncompany, $myaccountedit_id_functioncompany, $_SESSION['myaccount_useredition_cdreditor_functioncompany_UserEdition'], false, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');                                      
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
                <input type="text" name="txtUserEditionSiretcompany" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionSiretcompany'])){ echo($_SESSION['myaccount_useredition_txtUserEditionSiretcompany']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_myaccount_useredition_txtUserEditionSiretcompany']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_txtUserEditionSiretcompany']); ?></div>
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
                <input type="text" name="txtUserEditionVatintracompany" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionVatintracompany'])){ echo($_SESSION['myaccount_useredition_txtUserEditionVatintracompany']); } ?>"/>
            </td>
        </tr> 
    </table></td>
</tr>
<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_address1', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <input type="text" name="txtUserEditionAddress1" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionAddress1'])){ echo($_SESSION['myaccount_useredition_txtUserEditionAddress1']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_myaccount_useredition_txtUserEditionAddress1']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_txtUserEditionAddress1']); ?></div>
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
                <input type="text" name="txtUserEditionAddress2" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionAddress2'])){ echo($_SESSION['myaccount_useredition_txtUserEditionAddress2']); } ?>"/>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_zip', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserEditionZip" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionZip'])){ echo($_SESSION['myaccount_useredition_txtUserEditionZip']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_myaccount_useredition_txtUserEditionZip']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_txtUserEditionZip']); ?></div>
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
                <input type="text" name="txtUserEditionCity" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionCity'])){ echo($_SESSION['myaccount_useredition_txtUserEditionCity']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_myaccount_useredition_txtUserEditionCity']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_txtUserEditionCity']); ?></div>
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
                     cdrgeo('dropdown', $myaccountedit_name_country, $myaccountedit_code_country, $myaccountedit_statusobject_country, $myaccountedit_id_country, $_SESSION['myaccount_useredition_cdrgeo_country_situation'], false);                                      
                    if(!empty($_SESSION['msg_myaccount_useredition_cdrgeo_country_situation']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_cdrgeo_country_situation']); ?></div>
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
<?php
if(count($main_activatedidlang) > 1)
{
?>
<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_language', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <select name="cboUserEditionLanguage">
<?php   
                            try
                            {
                                $prepared_query = 'SELECT * FROM language
                                                   INNER JOIN translation
                                                   ON translation.code_translation = language.code_language
                                                   WHERE status_language = 1
                                                   ORDER BY L'.$main_id_language;
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->execute();
                                while($data = $query->fetch())
                                {
?>
                                    <option value="<?php echo($data[0]); ?>"
                                        <?php if(empty($_SESSION['myaccount_useredition_cboUserEditionLanguage']) && $data['priority_language'] == 1){ echo('selected="selected"'); }else{ if(!empty($_SESSION['myaccount_useredition_cboUserEditionLanguage']) && $_SESSION['myaccount_useredition_cboUserEditionLanguage'] == $data[0]){ echo('selected="selected"'); } }?> 
                                            ><?php echo($data['L'.$data[0]]); ?></option>
<?php
                                }
                                $query->closeCursor();
                            }
                            catch(Exception $e)
                            {
                                $_SESSION['error400_message'] = $e->getMessage();
                                if($_SESSION['index'] == 'index.php')
                                {
                                    die(header('Location: '.$config_customheader.'Error/400'));
                                }
                                else
                                {
                                    die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
                                }
                            }                          
?>
                            </select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>            
    </table></td>
</tr>
<?php
}
?>
<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_birthday', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
<?php
                birthday('cboUserEditionBirthDay', 'cboUserEditionBirthMonth', 'cboUserEditionBirthYear', $_SESSION['myaccount_useredition_cboUserEditionBirthDay'], $_SESSION['myaccount_useredition_cboUserEditionBirthMonth'], $_SESSION['myaccount_useredition_cboUserEditionBirthYear'], 1920, $config_birthday_maxyear, $language);
                if(!empty($_SESSION['msg_myaccount_useredition_birthday']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_birthday']); ?></div>
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
                <input type="text" name="txtUserEditionWebsite" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionWebsite'])){ echo($_SESSION['myaccount_useredition_txtUserEditionWebsite']); } ?>"/>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_landline', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <input type="text" name="txtUserEditionLandline" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionLandline'])){ echo($_SESSION['myaccount_useredition_txtUserEditionLandline']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_myaccount_useredition_phone']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_myaccount_useredition_phone']); ?></div>
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
                <input type="text" name="txtUserEditionMobile" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionMobile'])){ echo($_SESSION['myaccount_useredition_txtUserEditionMobile']); } ?>"/>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_fax', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="text" name="txtUserEditionFax" value="<?php if(!empty($_SESSION['myaccount_useredition_txtUserEditionFax'])){ echo($_SESSION['myaccount_useredition_txtUserEditionFax']); } ?>"/>
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
                        <input type="submit" name="bt_save_newaddress" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                    </td>
                </tr> 
            </table></td>
        </tr>
    </table></td>
</tr>
