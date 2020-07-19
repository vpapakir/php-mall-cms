<table border="0" cellpadding="0" cellspacing="0">
    <tr>
<?php 
try
{
    $prepared_query = 'SELECT COUNT(id_language) FROM language
                       WHERE status_language = 1';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $available_language = $data[0]; 
    }
    $query->closeCursor();
    
    if($available_language > 1)
    {
        $prepared_query = 'SELECT * FROM language
                           INNER JOIN language_image
                           ON language.id_language = language_image.id_language
                           INNER JOIN translation
                           ON translation.code_translation = language.code_language
                           WHERE status_language = 1
                           AND status_image = 9
                           ORDER BY priority_language DESC, position_language';
        //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        $i = 1;

        while($data = $query->fetch())
        {
?>
            <td>
                <a title="<?php echo($data['L'.$main_id_language]); ?>" href="<?php echo($config_customheader.$_SESSION['index'].'?page='.$_SESSION['current_page']); ?>&amp;lang=<?php echo($data[0]); ?>" ><img id="flaglang<?php echo($i); ?>" style="margin-left: 3px; border: none;" <?php if(!empty($main_id_language) && $main_id_language != $data['id_language']){ ?> src="<?php echo($config_customheader.$data['paththumb_image']); ?>" alt="<?php echo($data['alt_image']); ?>" <?php }else{ ?> src="<?php echo($config_customheader.str_replace('disabled', 'activated', $data['paththumb_image'])); ?>" <?php } ?> title="<?php echo($data['title_image']); ?>" <?php if(!empty($main_id_language) && $main_id_language != $data['id_language']){ ?>onmouseover="langimage('flaglang<?php echo($i); ?>', '<?php echo($config_customheader.str_replace('disabled', 'activated', $data['paththumb_image'])); ?>')" onmouseout="langimage('flaglang<?php echo($i); ?>', '<?php echo($config_customheader.$data['paththumb_image']); ?>')" <?php } ?>></img></a> 
            </td>  
<?php
            if($i == $available_language)
            { 
?>
                <td><div style="margin-right: <?php echo($marginr_logo); ?>px;"></div></td>
<?php                    
            }    

            $i++;
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
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
?> 
    </tr>
</table>
