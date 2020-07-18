<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="center" width="<?php echo($right_column_width); ?>">
                    <select name="cboSelectSiteAdminconfig" onchange="OnChange('bt_cboSelectSiteAdminconfig');">
                        <option value="select"
                            <?php if(empty($_SESSION['adminconfig_cboSelectSiteAdminconfig']) || $_SESSION['adminconfig_cboSelectSiteAdminconfig'] == 'select'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_select', $echo, $config_showtranslationcode); ?></option>
                        <option value="---" disabled="disabled">---</option>
                        <option value="new"
                            <?php if(!empty($_SESSION['adminconfig_cboSelectSiteAdminconfig']) && $_SESSION['adminconfig_cboSelectSiteAdminconfig'] == 'new'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_new', $echo, $config_showtranslationcode); ?></option>
                        <option value="---" disabled="disabled">---</option>
<?php
                    try
                    {
                        $prepared_query = 'SELECT name_configadmin, id_configadmin FROM config_admin';
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();
                        while($data = $query->fetch())
                        {
?>
                            <option value="<?php echo($data[0]); ?>" <?php if(!empty($adminconfig_currentused_config) && $adminconfig_currentused_config == $data[1]){ echo('style="background-color: lightblue;"'); } ?>
                                <?php if(!empty($_SESSION['adminconfig_cboSelectSiteAdminconfig']) && $_SESSION['adminconfig_cboSelectSiteAdminconfig'] == $data[0]){ echo('selected="selected"'); } ?>    
                                    ><?php echo($data[0]); ?></option>
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
                    <input id="bt_cboSelectSiteAdminconfig" style="display: none;" hidden="hidden" type="submit" name="bt_cboSelectSiteAdminconfig" value="select"/>
                </td>
            </tr>
        </table>
    </td>
</tr>
