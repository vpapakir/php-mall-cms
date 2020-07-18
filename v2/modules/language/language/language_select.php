<tr>
<td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
    <tr>    
    <td class="font_subtitle">
        <?php give_translation('edit_language.subtitle_choice_language', '', $config_showtranslationcode); ?>
    </td> 
    <td class="font_main" width="<?php echo($right_column_width); ?>">
<?php
        try
        {
            $prepared_query = 'SELECT * FROM language
                               INNER JOIN translation
                               ON language.code_language = translation.code_translation
                               WHERE status_language = 1
                               ORDER BY priority_language DESC, position_language';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            
            if(($data = $query->fetch()) == false)
            {
                $count_activated_language = false;
                $count_language = 0;
            }
            else
            {
                $count_activated_language = true;
                $query->execute();
                $i = 0;
                $y = 1;
                while($data = $query->fetch())
                {
                    $code_activated_language[$i] = $data[0];
                    $name_activated_language[$i] = $data['L1'];
                    $count_language += $y;
                    $i++;
                }
            }
            $query->closeCursor();
            
            $prepared_query = 'SELECT * FROM language
                               INNER JOIN translation
                               ON language.code_language = translation.code_translation
                               WHERE status_language = 0
                               ORDER BY priority_language DESC, position_language';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            
            if(($data = $query->fetch()) == false)
            {
                $count_disabled_language = false;
            }
            else
            {
                $count_disabled_language = true;
                $query->execute();
                $i = 0;
                while($data = $query->fetch())
                {
                    $code_disabled_language[$i] = $data[0];
                    $name_disabled_language[$i] = $data['L1'];
                    $i++;
                }              
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
                die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
            }
        }
        
        
        
        if($count_activated_language === false && $count_disabled_language === false)
        {
?>
            <select name="cboLanguage" onchange="OnChange('bt_cboLanguage')">
                <option value="new" 
                        <?php if(empty($_SESSION['language_select_cboLanguage']) || $_SESSION['language_select_cboLanguage'] == 'new'){ echo('selected'); }else{ echo(null); } ?>
                        ><?php give_translation('edit_language.main_dd_newlanguage', '', $config_showtranslationcode); ?></option>
            </select>
            <input style="display: none;" hidden="true" id="bt_cboLanguage" type="submit" name="bt_cboLanguage" value="Choix Langue"></input>
<?php        
        }
        else
        {
?>
            <select name="cboLanguage" onchange="OnChange('bt_cboLanguage')">
                <option value="new" 
                        <?php if(empty($_SESSION['language_select_cboLanguage']) || $_SESSION['language_select_cboLanguage'] == 'new'){ echo('selected'); }else{ echo(null); } ?>
                        ><?php give_translation('edit_language.main_dd_newlanguage', '', $config_showtranslationcode); ?></option>
<?php            
            for($i = 0, $count = count($code_activated_language); $i < $count; $i++)
            {
?>
                <option value="<?php echo($code_activated_language[$i]); ?>" 
                <?php if(!empty($_SESSION['language_select_cboLanguage']) && $_SESSION['language_select_cboLanguage'] == $code_activated_language[$i]){ echo('selected'); }else{ echo(null); } ?>
                        ><?php echo($name_activated_language[$i]); ?></option>
<?php            
            }
            
            for($i = 0, $count = count($code_disabled_language); $i < $count; $i++)
            {
?>
                <option style="background-color: lightgray;" value="<?php echo($code_disabled_language[$i]); ?>" 
                <?php if(!empty($_SESSION['language_select_cboLanguage']) && $_SESSION['language_select_cboLanguage'] == $code_disabled_language[$i]){ echo('selected'); }else{ echo(null); } ?>
                        ><?php echo($name_disabled_language[$i]); ?></option>
<?php            
            }
            
?>
            </select>
            <input style="display: none;" hidden="true" id="bt_cboLanguage" type="submit" name="bt_cboLanguage" value="Choix Langue"></input>
<?php            
        }

?>
    </td>     
    </tr>
</table></td>
</tr>
