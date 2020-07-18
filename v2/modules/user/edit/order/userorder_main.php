<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td class="font_subtitle" width="20%">
                    <?php give_translation('user_edit.subtitle_order_rightsuser', $echo, $config_showtranslationcode); ?>
                </td>
                <td>
                    <select name="cboOrderRightsUserEdit" onchange="OnChange('bt_search_useredit');">
                        <option value="all"
                            <?php if(empty($_SESSION['useredit_search_rights']) || $_SESSION['useredit_search_rights'] == 'all'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.multi_userrights_all', $echo, $config_showtranslationcode); ?></option>
<?php
                        try
                        {
                            $prepared_query = 'SELECT * FROM user_rights
                                               ORDER BY level_rights';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute();
                            while($data = $query->fetch())
                            {
?>
                                <option value="<?php echo($data['level_rights']); ?>"
                                    <?php if(!empty($_SESSION['useredit_search_rights']) && $_SESSION['useredit_search_rights'] == $data['level_rights']){ echo('selected="selected"'); } ?>
                                        ><?php give_translation('main.'.$data['name_rights'], $echo, $config_showtranslationcode); ?></option>
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
                    <input id="bt_search_useredit" hidden="hidden" style="display: none;" type="submit" name="bt_search_useredit"/>
                </td>
                <td class="font_subtitle">
                    <?php give_translation('user_edit.subtitle_order_statususer', $echo, $config_showtranslationcode); ?>
                </td> 
                <td>
                    <select name="cboOrderStatusUserEdit" onchange="OnChange('bt_search_useredit');">
                        <option value="1"
                            <?php if(empty($_SESSION['useredit_search_status']) || $_SESSION['useredit_search_status'] == 1){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.user_status_active', '', $config_showtranslationcode); ?></option>
                        <option value="2"
                            <?php if(!empty($_SESSION['useredit_search_status']) && $_SESSION['useredit_search_status'] == 2){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.user_status_onhold', '', $config_showtranslationcode); ?></option>
                        <option value="9"
                            <?php if(!empty($_SESSION['useredit_search_status']) && $_SESSION['useredit_search_status'] == 9){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.user_status_blocked', '', $config_showtranslationcode); ?></option>
                    </select>
                    <input id="bt_search_useredit" hidden="hidden" style="display: none;" type="submit" name="bt_search_useredit"/>
                </td>
            </tr>
            <tr>
                <td class="font_subtitle" width="20%">
                    <?php give_translation('user_edit.subtitle_order_typeuser', $echo, $config_showtranslationcode); ?>
                </td>
                <td>
                    <select name="cboOrderTypeUserEdit" onchange="OnChange('bt_search_useredit');">
                        <option value="name_user"
                            <?php if(empty($_SESSION['useredit_search_type']) || $_SESSION['useredit_search_type'] == 'name_user'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('user_edit.dd_orderby_name', $echo, $config_showtranslationcode); ?></option>
                        <option value="namecompany_user"
                            <?php if(!empty($_SESSION['useredit_search_type']) && $_SESSION['useredit_search_type'] == 'namecompany_user'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('user_edit.dd_orderby_namecompany', $echo, $config_showtranslationcode); ?></option>
                        <option value="zip_user"
                            <?php if(!empty($_SESSION['useredit_search_type']) && $_SESSION['useredit_search_type'] == 'zip_user'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('user_edit.dd_orderby_zip', $echo, $config_showtranslationcode); ?></option>
                        <option value="city_user"
                            <?php if(!empty($_SESSION['useredit_search_type']) && $_SESSION['useredit_search_type'] == 'city_user'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('user_edit.dd_orderby_city', $echo, $config_showtranslationcode); ?></option>
                        <option value="country_user"
                            <?php if(!empty($_SESSION['useredit_search_type']) && $_SESSION['useredit_search_type'] == 'country_user'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('user_edit.dd_orderby_country', $echo, $config_showtranslationcode); ?></option>
                        <option value="rights_user"
                            <?php if(!empty($_SESSION['useredit_search_type']) && $_SESSION['useredit_search_type'] == 'rights_user'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('user_edit.dd_orderby_rights', $echo, $config_showtranslationcode); ?></option>
                    </select> 
                    <input id="bt_search_useredit" hidden="hidden" style="display: none;" type="submit" name="bt_search_useredit"/>
                </td>
                <td class="font_subtitle">
                    <?php give_translation('user_edit.subtitle_order_modeuser', $echo, $config_showtranslationcode); ?>
                </td> 
                <td>
                    <select name="cboOrderModeUserEdit" onchange="OnChange('bt_search_useredit');">
                        <option value="ASC"
                            <?php if(empty($_SESSION['useredit_search_order']) || $_SESSION['useredit_search_order'] == 'ASC'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_modeorder_asc', $echo, $config_showtranslationcode); ?></option>
                        <option value="DESC"
                            <?php if(!empty($_SESSION['useredit_search_order']) && $_SESSION['useredit_search_order'] == 'DESC'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_modeorder_desc', $echo, $config_showtranslationcode); ?></option>
                    </select>
                    <input id="bt_search_useredit" hidden="hidden" style="display: none;" type="submit" name="bt_search_useredit"/>
                </td>
            </tr>
        </table>
    </td>
</tr>
