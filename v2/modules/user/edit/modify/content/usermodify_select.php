<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('user_edit.subtitle_choiceuser', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboSelectUserEdit" onchange="OnChange('bt_cboSelectUserEdit');">
                        <option value="new"
                            <?php if(empty($_SESSION['useredit_iduser']) || $_SESSION['useredit_iduser'] == 'new'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('user_edit.dd_new', $echo, $config_showtranslationcode); ?></option>
                        <option value="---" disabled="disabled">---</option>
<?php                   
                        try
                        {
                            $prepared_query = 'SELECT DISTINCT(rights_user), name_rights FROM user
                                               INNER JOIN user_rights
                                               ON user_rights.level_rights = user.rights_user ';

                            if((checkrights($main_rights_log, '9', $redirection)) === true)
                            { 
                                $_SESSION['prepared_query'] = $prepared_query;      
                            }
                            else
                            {
                                $prepared_query .= 'WHERE rights_user < 9 ';
                            }
                            $prepared_query .= 'ORDER BY level_rights';
                            $query = $connectData->prepare($prepared_query);
                            $query->execute();
                            $i = 0;
                            while($data = $query->fetch())
                            {
                                $useredit_dd_levelrights[$i] = $data[0];
                                $useredit_dd_namerights[$i] = $data[1];
                                $i++;
                            }
                            $query->closeCursor();
                            
                            for($i = 0, $count = count($useredit_dd_levelrights); $i < $count; $i++)
                            {
?>
                                <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="<?php give_translation('main.'.$useredit_dd_namerights[$i], $echo, $config_showtranslationcode); ?>">
<?php
                                $prepared_query = 'SELECT * FROM user
                                                   WHERE rights_user = :rights
                                                   ORDER BY status_user, COALESCE(namecompany_user, "z") ASC, COALESCE(name_user, "z") ASC';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->bindParam('rights', $useredit_dd_levelrights[$i]);
                                $query->execute();
                                while($data = $query->fetch())
                                {
                                    switch ($data['status_user'])
                                    {
                                        case '1':
                                            $useredit_dd_status = 'white';
                                            break;
                                        case '2':
                                            $useredit_dd_status = '#FF8100';
                                            break;
                                        case '9':
                                            $useredit_dd_status = '#A60800';
                                            break;
                                    }
                                    
                                    if(!empty($data['namecompany_user']))
                                    {
                                        $useredit_dd_name = $data['namecompany_user'];
                                        $useredit_dd_legendname = $data['namecompany_user'].' - '.$data['firstname_user'].' '.$data['name_user'];
                                    }
                                    else
                                    {
                                        $useredit_dd_name = $data['name_user'].' '.substr($data['firstname_user'], 0 , 1).'.';
                                        $useredit_dd_legendname = $data['firstname_user'].' '.$data['name_user'];
                                    }
?>
                                    <option value="<?php echo($data[0]); ?>" style="background-color: <?php echo($useredit_dd_status); ?>;" title="<?php echo($useredit_dd_legendname); ?>"
                                        <?php if(!empty($_SESSION['useredit_iduser']) && $_SESSION['useredit_iduser'] == $data[0]){ echo('selected="selected"'); } ?>
                                            ><?php echo($useredit_dd_name); ?></option>
<?php
                                }
                                $query->closeCursor();
?>
                                </optgroup>
<?php
                            }       
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
                    <input id="bt_cboSelectUserEdit" style="display: none;" hidden="hidden" type="submit" name="bt_cboSelectUserEdit" value="select"/>
                </td>
            </tr>
    </table></td>
</tr>
