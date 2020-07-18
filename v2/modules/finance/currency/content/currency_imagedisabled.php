   
        <tr>
            <td align="left" class="font_subtitle">
               Image - devise non utilisée
            </td>
            <td align="left">
               <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
               <input type="file" name="upload_currency[]"></input>
               <br clear="left">
               <div class="font_info1">
<?php 
                if(!empty($_SESSION['msg_currency_upload_disabled']))
                { 
                    echo(check_session_input($_SESSION['msg_currency_upload_disabled'])); 
                } 
?>
                </div>
            </td>
        </tr>

<?php
        try
        {
            $prepared_query = 'SELECT * FROM currency_image
                               WHERE id_currency = :id
                               AND status_image = 9
                               ORDER BY date_image DESC';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $_SESSION['currency_cboSelectCurrency']);
            $query->execute(); 

            if(($data = $query->fetch()) != false)
            {
                $query->execute();

                while($data = $query->fetch())
                {
?>
                    <tr>
                    <td align="left" colspan="2"><table width="100%">
                        <tr>
                            <td align="left"><table width="100%">
                                <tr>    
                                <td>

                                </td>
                                <td>
                                    <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: none;"></img></a>
                                </td>
                                </tr>
                            </table></td>

                            <td align="left" width="<?php echo($right_column_width); ?>"><table width="100%">
                                <tr>
                                    <td align="left" class="font_main" width="30%">
                                        Nom
                                    </td>
                                    <td align="left" class="font_main">
                                        <input style="width: 100%;" type="text" name="txtDisNameImageCurrency" value="<?php echo($data['name_image']); ?>"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="font_main">
                                        Alt 
                                    </td>
                                    <td align="left" class="font_main">
                                        <input style="width: 100%;" type="text" name="txtDisAltImageCurrency" value="<?php echo($data['alt_image']); ?>"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="font_main">
                                        Titre 
                                    </td>
                                    <td align="left" class="font_main">
                                        <input style="width: 100%;" type="text" name="txtDisTitleImageCurrency" value="<?php echo($data['title_image']); ?>"></input>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" class="font_main">
                                        Répétition
                                    <td align="left" class="font_main">
                                        <select name="cboDisRepeatImageCurrency">
                                            <option value="no-repeat" <?php if(empty($data['repeat_image']) || $data['repeat_image'] == 'no-repeat'){ echo('selected'); }else{ echo(null); } ?>>Aucune</option>
                                            <option value="repeat-x" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-x'){ echo('selected'); }else{ echo(null); } ?>>Horizontale</option>
                                            <option value="repeat-y" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat-y'){ echo('selected'); }else{ echo(null); } ?>>Verticale</option>
                                            <option value="repeat" <?php if(!empty($data['repeat_image']) && $data['repeat_image'] == 'repeat'){ echo('selected'); }else{ echo(null); } ?>>Les deux</option>
                                        </select>    
                                    </td>
                                </tr>
                            </table></td>
                        </tr>

                    </table></td>
                    </tr>
                    <tr>
                        <td colspan="2"><div style="height: 4px;"></div></td>
                    </tr>    
                    <tr>
                        <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
                    </tr>
<?php                
                }
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