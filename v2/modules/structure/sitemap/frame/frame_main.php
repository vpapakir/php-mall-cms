<?php
try
{
    $prepared_query = 'SELECT id_frame FROM structure_template
                       WHERE status_template = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $temp_id_frame = $data[0];
    }
    $query->closeCursor();
    
    $temp_id_frame = split_string($temp_id_frame, ',');
    
    $prepared_query = 'SELECT * FROM structure_frame
                       WHERE ';
    
    for($i = 0, $count = count($temp_id_frame); $i < $count; $i++)
    {
        if($i < ($count - 1))
        {
            $prepared_query .= 'id_frame = '.$temp_id_frame[$i].' OR ';
        }
        else
        {
            $prepared_query .= 'id_frame = '.$temp_id_frame[$i].' ORDER BY name_frame ASC';
        }
    }
    
    
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    $i = 0;
    
    while($data = $query->fetch())
    {
        $id_frame_sitemap[$i] = $data[0];
        $name_frame_sitemap[$i] = $data['name_frame'];
        $i++;     
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
<tr>
<td><form method="post"><table class="block_main2" width="100%">
    <tr>        
        <td class="font_subtitle">
            <?php give_translation('sitemap.subtitle_choose_frame', '', $config_showtranslationcode); ?>
        </td>

        <td width="<?php echo($right_column_width); ?>">
            <select name="cboSitemapFrame" onchange="OnChange('bt_cboSitemapFrame')">
                <option value="select" <?php if(empty($_SESSION['sitemap_frame_cboSitemapFrame']) || $_SESSION['sitemap_frame_cboSitemapFrame'] == 'select'){ echo('selected'); }else{ echo(null); } ?>
                ><?php give_translation('sitemap.main_dd_frame', '', $config_showtranslationcode); ?></option>
<?php
                for($i = 0, $count = count($id_frame_sitemap); $i < $count; $i++)
                {
?>
                    <option value="<?php echo($id_frame_sitemap[$i]); ?>" 
                    <?php if(!empty($_SESSION['sitemap_frame_cboSitemapFrame']) && $_SESSION['sitemap_frame_cboSitemapFrame'] == $id_frame_sitemap[$i]){ echo('selected'); }else{ echo(null); } ?>>
                    <?php echo($name_frame_sitemap[$i]); ?></option>
<?php          
                }
?>
            </select>
            <input style="display: none;" hidden="true" id="bt_cboSitemapFrame" type="submit" name="bt_cboSitemapFrame" value="Choix Frame"></input>
        </td>
    </tr>

</table></form></td>
</tr>
