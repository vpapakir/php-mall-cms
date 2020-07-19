<?php
$search_result = $_SESSION['translation_search_result_count'];
$search_sentence = $_SESSION['translation_search_txtTranslationSearch_1'];
$array_translation_search_result = $_SESSION['translation_search_listing_result'];
$array_keywords = $_SESSION['translation_search_keywords'];

try
{
    if($search_sentence == '*')
    {
        $prepared_query = 'SELECT COUNT(id_translation) FROM translation';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            $search_result = $data[0];
        }
        $query->closeCursor();
    }
    
    $prepared_query = 'SELECT * FROM language
                       INNER JOIN translation
                       ON language.code_language = translation.code_translation
                       WHERE id_language = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $main_id_language);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $name_language = $data['L'.$main_id_language];
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


if($search_result == 0 || $search_result == 'null')
{
    $result_sentence = give_translation('edit_translation.msg_info_noresult', 'false', $config_showtranslationcode);
    $result_sentence = str_replace('[#keyword_translationedit]', '<strong>'.$search_sentence.'</strong>', $result_sentence);
}
else
{
    if($search_result == 1)
    {
        $result_sentence = give_translation('edit_translation.msg_info_oneresult', 'false', $config_showtranslationcode);
        $result_sentence = str_replace('[#keyword_translationedit]', '<strong>'.$search_sentence.'</strong>', $result_sentence);
    }
    else
    {
        $result_sentence = give_translation('edit_translation.msg_info_moreresult', 'false', $config_showtranslationcode);
        $result_sentence = str_replace('[#count_translationedit]', '<strong>'.$search_result.'</strong>', $result_sentence);
        $result_sentence = str_replace('[#keyword_translationedit]', '<strong>'.$search_sentence.'</strong>', $result_sentence);
    }
}
?>

<td align="center"><table>
    <tr>
        <td class="font_main">
            <?php echo($result_sentence); ?>
        </td>   
    </tr>
</table></td>

<?php
if($search_result > 0)
{
?>
    <tr>
    <td><table class="block_main2" width="100%">
            <tr>
                <td>
                    <span class="font_subtitle" style="margin-left: 8px;">
                        <?php give_translation('edit_translation.subtitle_code_translation', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td>
                    <span class="font_subtitle" style="margin-left: 8px;">
                        <?php echo($name_language); ?>
                    </span>
                </td>
            </tr>
<?php
    $Bok_style_colored = true;
    
    if($search_sentence != '*')
    {  
        for($i = 0, $count = count($array_translation_search_result); $i < $count; $i++)
        {
            if($array_translation_search_result[$i] != 'and' && $array_translation_search_result[$i] != 'or')
            {
                try
                {

                    $prepared_query = 'SELECT id_translation, code_translation, L'.$main_id_language.'
                                       FROM translation
                                       WHERE id_translation = :id';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $array_translation_search_result[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        if($Bok_style_colored === true)
                        {
                            $Bok_style_colored = false;
                            $translation_listing_style = 'lightgrey';
                        }
                        else
                        {
                            $Bok_style_colored = true;
                            $translation_listing_style = 'white';
                        }

?>
                        <tr style="background-color: <?php echo($translation_listing_style); ?>;" onmouseover="this.style.backgroundColor = 'lightblue';" onmouseout="this.style.backgroundColor = '<?php echo($translation_listing_style); ?>';">
                            <td title="<?php echo($data['code_translation']); ?>">
                                <a style="margin-left: 8px;" class="link_main" href="<?php echo($config_customheader); change_link('Gestion/Traductions/'.$data[0], 'Backoffice/Gestion/Traductions/'.$data[0])?>">
                                    <?php 
                                        echo(cut_string($data['code_translation'], 0, 40, '...'));
                                    ?>
                                </a>
                            </td>
                            <td width="<?php echo($right_column_width); ?>" title="<?php echo($data['L'.$main_id_language]); ?>">
                                <a style="margin-left: 8px;" class="link_main" href="<?php echo($config_customheader); change_link('Gestion/Traductions/'.$data[0], 'Backoffice/Gestion/Traductions/'.$data[0])?>">
                                    <?php 
                                        if(empty($data['L'.$main_id_language]))
                                        {
                                            echo('<I style="color: orange;">');
                                            give_translation('edit_translation.listing_novalue', '', $config_showtranslationcode);
                                            echo('</I>');
                                        }
                                        else
                                        {
                                            echo(cut_string($data['L'.$main_id_language], 0, 20, '...')); 
                                        }
                                    ?>
                                </a>
                            </td>
                        </tr>

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
                        die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
                    }
                }
            }
        }
    }
    else
    {
        
        try
        {
            $prepared_query = 'SELECT id_translation, code_translation, L'.$main_id_language.'
                               FROM translation';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();

            while($data = $query->fetch())
            {
                if($Bok_style_colored === true)
                {
                    $Bok_style_colored = false;
                    $translation_listing_style = 'lightgrey';
                }
                else
                {
                    $Bok_style_colored = true;
                    $translation_listing_style = 'white';
                }

?>
                <tr style="background-color: <?php echo($translation_listing_style); ?>;" onmouseover="this.style.backgroundColor = 'lightblue';" onmouseout="this.style.backgroundColor = '<?php echo($translation_listing_style); ?>';">
                    <td title="<?php echo($data['code_translation']); ?>">
                        <a style="margin-left: 8px;" class="link_main" href="<?php echo($config_customheader); change_link('Gestion/Traductions/'.$data[0], 'Backoffice/Gestion/Traductions/'.$data[0])?>">
                            <?php 
                                echo(cut_string($data['code_translation'], 0, 40, '...'));
                            ?>
                        </a>
                    </td>
                    <td width="<?php echo($right_column_width); ?>" title="<?php echo($data['L'.$main_id_language]); ?>">
                        <a style="margin-left: 8px;" class="link_main" href="<?php echo($config_customheader); change_link('Gestion/Traductions/'.$data[0], 'Backoffice/Gestion/Traductions/'.$data[0])?>">
                            <?php 
                                if(empty($data['L'.$main_id_language]))
                                {
                                    echo('<I style="color: orange;">');
                                    give_translation('edit_translation.listing_novalue', '', $config_showtranslationcode);
                                    echo('</I>');
                                }
                                else
                                {
                                    echo(cut_string($data['L'.$main_id_language], 0, 20, '...')); 
                                }
                            ?>
                        </a>
                    </td>
                </tr>

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
    }
?>
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
                        <input type="submit" name="bt_new_translation_edit" value="<?php give_translation('main.bt_add', '', $config_showtranslationcode); ?>"/>
                    </td>
                </tr> 
            </table></td>
        </tr>
    </table></td>
    </tr>
<?php
}
?>
