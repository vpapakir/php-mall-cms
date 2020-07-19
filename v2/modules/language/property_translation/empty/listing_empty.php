<tr>
    <td align="center" class="block_main2" style="width: 1%;">
        <div class="font_subtitle" style="text-align: center;">!</div>
    </td>
    <td align="center" class="block_main2" style="width: 30%;">
        <div class="font_subtitle" style="text-align: left;">URL</div>
    </td>
    <td align="center" class="block_main2" style="width: 70%;">
        <div class="font_subtitle" style="text-align: left;">Titre</div>
    </td>
</tr>
<?php
try
{
    $prepared_query = 'SELECT DISTINCT(page.id_page) FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE (family_page_translation = "intro"
                       OR family_page_translation = "desc"
                       OR family_page_translation = "title"
                       OR family_page_translation = "browser")
                       AND status_page = 1
                       AND (';
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        if($i == ($count - 1))
        {
            $prepared_query .= 'L'.$main_activatedidlang[$i].' = "") ';
        }
        else
        {
            $prepared_query .= 'L'.$main_activatedidlang[$i].' = "" OR ';
        }     
    }
    
    $prepared_query .= 'ORDER BY url_page ASC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        if($i > 0)
        {
            $propertytrans_style = 'lightgrey';
            $i = 0;
        }
        else
        {
            $propertytrans_style = 'white';
            $i++;
        }
        
        $prepared_query = 'SELECT * FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE family_page_translation = "title"
                           AND page.id_page = :idpage';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query_propertytrans = $connectData->prepare($prepared_query);
        $query_propertytrans->bindParam('idpage', $data[0]);
        $query_propertytrans->execute();
        
        if(($data_propertytrans = $query_propertytrans->fetch()) != false)
        {
            $propertytrans_page_family = $data_propertytrans['family_page'];
            $propertytrans_page_title = $data_propertytrans['L'.$main_id_language];
            $propertytrans_page_url = $data_propertytrans['url_page'];
        }
        $query_propertytrans->closeCursor();
?>
        <tr style="background-color: <?php echo($propertytrans_style); ?>;" onmouseover="this.style.backgroundColor='lightblue';" onmouseout="this.style.backgroundColor='<?php echo($propertytrans_style); ?>';">
            <td align="left">
                <input type="checkbox" name="chk_translationdone<?php echo($data[0]); ?>" value="1"/>
            </td>
            <td align="left">
                <a href="<?php if($propertytrans_page_family == 'product'){ echo($config_customheader.'edition/product/'.$data[0]); }else{ echo($config_customheader.'edition/page/'.$data[0]); } ?>" class="link_main" target="_blank"><?php echo($propertytrans_page_url); ?></a>
            </td>
            <td align="left" title="<?php echo($propertytrans_page_title); ?>">
                <a href="<?php if($propertytrans_page_family == 'product'){ echo($config_customheader.'edition/product/'.$data[0]); }else{ echo($config_customheader.'edition/page/'.$data[0]); } ?>" class="link_main" target="_blank"><?php echo(cut_string($propertytrans_page_title, 0, 50, '...')); ?></a>
            </td>
        </tr> 
<?php
        unset($propertytrans_page_title, $propertytrans_page_url, $propertytrans_page_family);
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
