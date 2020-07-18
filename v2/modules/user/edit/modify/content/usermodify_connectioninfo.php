<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
<?php
if(count($main_activatedidlang) > 1)
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_language', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <select name="cboUserdataLanguage">
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
                                        <?php if(empty($_SESSION['userdata_cboUserdataLanguage']) && $data['priority_language'] == 1){ echo('selected="selected"'); }else{ if(!empty($_SESSION['userdata_cboUserdataLanguage']) && $_SESSION['userdata_cboUserdataLanguage'] == $data[0]){ echo('selected="selected"'); } }?> 
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
<?php
}
?>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_nickname', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <input type="text" name="txtUserdataNickname" value="<?php if(!empty($_SESSION['userdata_txtUserdataNickname'])){ echo($_SESSION['userdata_txtUserdataNickname']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataNickname']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataNickname']); ?></div>
<?php
                }
?>
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_email', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <input type="text" name="txtUserdataEmail" value="<?php if(!empty($_SESSION['userdata_txtUserdataEmail'])){ echo($_SESSION['userdata_txtUserdataEmail']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataEmail']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataEmail']); ?></div>
<?php
                }
?>          
            </td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                <?php give_translation('subscription.subtitle_password', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <input type="password" name="txtUserdataPassword" value="<?php if(!empty($_SESSION['userdata_txtUserdataPassword'])){ echo($_SESSION['userdata_txtUserdataPassword']); } ?>"/>
<?php
                if(!empty($_SESSION['msg_userdata_txtUserdataPassword']))
                {
?>
                    <br clear="left"/>
                    <div class="font_error1"><?php echo($_SESSION['msg_userdata_txtUserdataPassword']); ?></div>
<?php
                }
?>
            </td>
        </tr>
<?php
        if(!empty($_SESSION['useredit_iduser']))
        {
?>
            <tr>
                <td align="right">
                    <input id="chk_useredit_changepassword" type="checkbox" name="chk_useredit_changepassword" value="1" <?php if(!empty($_SESSION['useredit_chkchangepassword']) && $_SESSION['useredit_chkchangepassword'] == 1){ echo('checked="checked"'); } ?>/>
                </td>
                <td align="left">
                    <label class="font_main" for="chk_useredit_changepassword" style="cursor: pointer;">
                        <?php give_translation('user_edit.subtitle_modify_applynewpassword', $echo, $config_showtranslationcode); ?>
                    </label>
                </td>
            </tr>
<?php
        }            
?>
    </table></td>
</tr>
