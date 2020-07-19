<?php
if(isset($_GET['trans']))
{
    unset($_SESSION['translation_edit_urlpage']);
    $id_selected_translation = trim(htmlspecialchars($_GET['trans'], ENT_QUOTES));
    if((checkrights($main_rights_log, '9')) === false)
    {
        $readonly = true;        
    }
    else
    {
        $readonly = false;
    }
    $translation_edit = true;
    $_SESSION['translation_edit_id'] = $id_selected_translation;
    
    try
    {
        $prepared_query = 'SELECT * FROM translation
                           WHERE id_translation = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $id_selected_translation);
        $query->execute();
        
        if(($data = $query->fetch()) != false)
        {
            $_SESSION['translation_edit_txtCodeTranslation'] = $data['code_translation'];
            for($i = 0, $count = count($countactivated_language); $i < $count; $i++)
            {
                $_SESSION['translation_edit_areaTranslationL'.$countactivated_language[$i]] = $data['L'.$countactivated_language[$i]];
            }
            $_SESSION['translation_edit_chkProtectedcontentTranslation'] = $data['protected_translation'];
            $_SESSION['translation_edit_cboPageTranslation'] = $data['id_page'];
            $_SESSION['translation_new_cboPageTranslation'] = $data['id_page'];
            
        }
        
        if(!empty($_SESSION['translation_new_cboPageTranslation']))
        {
            $prepared_query = 'SELECT * FROM page
                               WHERE id_page = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $_SESSION['translation_new_cboPageTranslation']);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $_SESSION['translation_edit_urlpage'] = $data['url_page'];
            }
            $query->closeCursor();
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
            die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
        }
    }
    
    if($_SESSION['translation_edit_cboPageTranslation'] == 0)
    {
        $_SESSION['translation_edit_cboPageTranslation'] = 'main';
        $_SESSION['translation_new_cboPageTranslation'] = 'main';
        $_SESSION['translation_edit_urlpage'] = 'main';
    }
}
else
{
    unset($_SESSION['translation_edit_txtCodeTranslation'],
            $_SESSION['translation_edit_urlpage'],
            $_SESSION['translation_edit_cboPageTranslation']);
    for($i = 0, $count = count($countactivated_language); $i < $count; $i++)
    {
        unset($_SESSION['translation_edit_areaTranslationL'.$countactivated_language[$i]]);
        unset($_SESSION['translation_edit_chkProtectedcontentTranslation'.$countactivated_language[$i]]);
    }
}
?>
<td><table class="block_main2" width="100%">
        
    <td><table width="100%">
        
        <tr>
        <td>
            <span class="font_subtitle"><?php give_translation('edit_translation.subtitle_page_translation', '', $config_showtranslationcode); ?></span>
        </td>
        <td width="<?php echo($right_column_width); ?>">
            <select id="cboPageTranslation" name="cboPageTranslation" onchange="translation_code('cboPageTranslation', 'txtGroupCodeTranslation')">
                <option value="main" <?php if((!empty($readonly) && $readonly === true) && (!empty($_SESSION['translation_edit_cboPageTranslation']) && $_SESSION['translation_edit_cboPageTranslation'] != 'main')){ echo('disabled="true" '); }else{ echo(null); } ?>
                    <?php if(empty($_SESSION['translation_edit_urlpage']) || $_SESSION['translation_edit_urlpage'] == 'main'){ echo('selected="selected"'); }else{ echo(null); } ?>
                        ><?php give_translation('edit_translation.main_dd_general_page', '', $config_showtranslationcode); ?></option>
                <option value="immo" <?php if((!empty($readonly) && $readonly === true) && (!empty($_SESSION['translation_edit_cboPageTranslation']) && $_SESSION['translation_edit_cboPageTranslation'] != 'immo')){ echo('disabled="true" '); }else{ echo(null); } ?>
                    <?php if(!empty($_SESSION['translation_edit_urlpage']) && $_SESSION['translation_edit_urlpage'] == 'immo'){ echo('selected="selected"'); }else{ echo(null); } ?>
                        ><?php give_translation('edit_translation.main_dd_custom_page', '', $config_showtranslationcode); ?></option>
<?php
                try
                {
                    $prepared_query = 'SELECT DISTINCT(family_page) FROM page
                                       WHERE family_page <> "product"';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->execute();
                    $i = 0;
                    while($data = $query->fetch())
                    {
                        $translationedit_family_page[$i] = $data[0];
                        $i++;
                    }
                    $query->closeCursor();
                    
                    for($i = 0, $count = count($translationedit_family_page); $i < $count; $i++)
                    {
?>
                        <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="<?php give_translation('main.dd_family_'.$translationedit_family_page[$i], $echo, $config_showtranslationcode); ?>">
<?php
                        $prepared_query = 'SELECT * FROM page
                                           INNER JOIN page_translation
                                           ON page_translation.id_page = page.id_page
                                           WHERE page.id_page <> 0
                                           AND family_page <> "product"
                                           AND family_page = :family
                                           AND family_page_translation = "title"
                                           ORDER BY L'.$main_id_language;
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->bindParam('family', $translationedit_family_page[$i]);
                        $query->execute();

                        while($data = $query->fetch())
                        {
                            if(empty($data['L'.$main_id_language]))
                            {
                                $pagetitle_translation_edit = $data['url_page'];
                            }
                            else
                            {
                                $pagetitle_translation_edit = cut_string($data['L'.$main_id_language], 0, 30, '...').' ('.$data['url_page'].')';
                            }
?>
                            <option style="background-color: white;" value="<?php echo($data['url_page']); ?>" title="<?php echo($data['L'.$main_id_language]); ?>" <?php if((!empty($readonly) && $readonly === true) && (!empty($_SESSION['translation_edit_cboPageTranslation']) && $_SESSION['translation_edit_cboPageTranslation'] != $data[0])){ echo('disabled="true" '); }else{ echo(null); } ?>
                                <?php if(!empty($_SESSION['translation_edit_urlpage']) && $_SESSION['translation_edit_urlpage'] == $data['url_page']){ echo('selected="selected"'); }else{ echo(null); } ?>
                                    ><?php echo($pagetitle_translation_edit); ?></option>
<?php                   
                            $namelang_translation_edit = $data['L'.$main_id_language];
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
        </td>    
        </tr>
        
        <tr>
        <td>
            <span class="font_subtitle"><?php give_translation('edit_translation.subtitle_code_translation', '', $config_showtranslationcode); ?></span>
        </td>
        <td width="<?php echo($right_column_width); ?>" align="left">
<?php
            if((empty($readonly) || $readonly === false) && (empty($translation_edit) || $translation_edit === false))
            {
?>
                <input id="txtGroupCodeTranslation" style="border: none; background-color: transparent;" readonly="true" name="txtGroupCodeTranslation" <?php if((empty($_SESSION['translation_edit_cboPageTranslation']) || $_SESSION['translation_edit_cboPageTranslation'] == 'main') && empty($_SESSION['translation_new_txtGroupCodeTranslation'])){ echo('value="main."'); }else{ echo('value="'.$_SESSION['translation_new_txtGroupCodeTranslation'].'"'); } ?>></input>
<?php
            }
?>
            <input <?php if((checkrights($main_rights_log, '9')) === false){ echo('readonly="readonly"'); } ?> style="<?php if((!empty($readonly) && $readonly === true) || !empty($translation_edit) && $translation_edit == true){ echo('width: 100%;'); } ?>" type="text" name="txtCodeTranslation" value="<?php if(!empty($_SESSION['translation_edit_txtCodeTranslation'])){ echo($_SESSION['translation_edit_txtCodeTranslation']); } ?>"></input>
<?php
            if(!empty($_SESSION['msg_translation_code_error']))
            {
?>
                <br clear="left"/>
                <div class="font_error1"><?php echo($_SESSION['msg_translation_code_error']); ?></div>
<?php
            }
?>        
        </td>
        </tr>
            
<?php
    $protectedcontent_translation_edit = split_string($_SESSION['translation_edit_chkProtectedcontentTranslation'], '$');
    for($i = 0, $y = 1, $count = count($countactivated_language); $i < $count; $i++, $y++)
    {
        
        
        try
        {
            $prepared_query = 'SELECT * FROM language
                               INNER JOIN translation
                               ON language.code_language = translation.code_translation
                               WHERE id_language = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $countactivated_language[$i]);
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $namelang_translation_edit = $data['L'.$main_id_language];
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
        
        <tr>
        <td style="vertical-align: top;">
            <span style="margin-top: 2px;" class="font_subtitle">
<?php
            if(!empty($_SESSION['translation_edit_urlpage']) && $_SESSION['translation_edit_urlpage'] != 'main' && $_SESSION['translation_edit_urlpage'] != 'immo')
            {
?>
                <span class="link_subtitle" href="<?php echo($config_customheader.'index.php?page='.$_SESSION['translation_edit_urlpage']); ?>" target="_blank" style="cursor: pointer;" onclick="popup('<?php echo($config_customheader.'index.php?page='.$_SESSION['translation_edit_urlpage'].'&amp;lang='.$countactivated_language[$i]); ?>', 970, 500)">
                    <?php echo($namelang_translation_edit); ?>
                </span>
<?php
            }
            else
            {
                echo($namelang_translation_edit);
            }
?>
            </span>
            <br/>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="right">
                       <input id="chk_ProtectedcontentTranslation<?php echo($countactivated_language[$i]); ?>" type="checkbox" name="chk_ProtectedcontentTranslation<?php echo($countactivated_language[$i]); ?>" value="1" <?php if(!empty($protectedcontent_translation_edit[$i]) && $protectedcontent_translation_edit[$i] == 1){ echo('checked="checked"'); } ?>/> 
                    </td>
                    <td align="left" width="100%">
                       <label class="font_main"  style="font-size: 10px; cursor: pointer;" for="chk_ProtectedcontentTranslation<?php echo($countactivated_language[$i]); ?>">
                           &nbsp;<?php give_translation('edit_translation.subtitle_protectedcontent', $echo, $config_showtranslationcode); ?>
                       </label> 
                    </td>
                </tr>   
            </table>
        </td>
        <td width="<?php echo($right_column_width); ?>">
            <textarea style="width: 100%;" rows="7" name="areaTranslationL<?php echo($countactivated_language[$i]); ?>"><?php if(!empty($_SESSION['translation_edit_areaTranslationL'.$countactivated_language[$i]])){ echo($_SESSION['translation_edit_areaTranslationL'.$countactivated_language[$i]]); } ?></textarea>
        </td>
        </tr>
<?php        
    }
?>
            
    </table></td> 
    
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
<?php
                    if(isset($_GET['trans']))
                    {
?>
                        <input type="submit" name="bt_modifyprevious_translation_edit" value="<-" title="<?php give_translation('main.bt_title_modifynprevious', '', $config_showtranslationcode); ?>"></input>
                        <input type="submit" name="bt_modify_translation_edit" value="<?php give_translation('main.bt_modify', '', $config_showtranslationcode); ?>"></input>
                        <input type="submit" name="bt_modifynext_translation_edit" value="->" title="<?php give_translation('main.bt_title_modifynnext', '', $config_showtranslationcode); ?>"></input>
                        <input type="submit" name="bt_modifynextempty_translation_edit" value="<?php give_translation('main.bt_modifynnextempty', '', $config_showtranslationcode); ?>" title="<?php give_translation('main.bt_title_modifynnextempty', '', $config_showtranslationcode); ?>"></input>
                        <input type="submit" name="bt_new_translation_edit" value="<?php give_translation('main.bt_new', '', $config_showtranslationcode); ?>"></input>           
<?php

                    }
                    else
                    {
?>
                        <input type="submit" name="bt_save_new_translation_edit" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"></input>
                        <input type="submit" name="bt_modifynextempty_translation_edit" value="<?php give_translation('main.bt_modifyempty', '', $config_showtranslationcode); ?>"></input>
<?php
                    }
?>
                </td>
            </tr> 
        </table></td>
    </tr>
    
</table></td>
