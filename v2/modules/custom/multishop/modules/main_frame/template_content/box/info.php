<?php
try 
{ 
    unset($stats_currentpage_totalviews);
    
    $prepared_query = 'SELECT * FROM hierarchy_box
                       WHERE id_hierarchy_box = 13';
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    { 
        $title_box = $data['L'.$main_id_language];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM hierarchy_box_content
                       WHERE status_hierarchy_box_content = 1
                       AND id_hierarchy_box = 13
                       ORDER BY code_hierarchy_box_content';
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    $x = 0;

    while($data = $query->fetch())
    { 
        $id_box_content[$x] = $data['id_hierarchy_box_content'];
        $code_box_content[$x] = $data['code_hierarchy_box_content'];
        $type_box_content[$x] = $data['type_hierarchy_box_content'];
        $typelink_box_content[$x] = $data['typelink_hierarchy_box_content'];
        $title_box_content[$x] = $data['L'.$main_id_language];
        $link_box_content[$x] = $data['link_hierarchy_box_content'];
        $level_box_content[$x] = $data['level_hierarchy_box_content'];
        $margin_box_content[$x] = $data['margin_hierarchy_box_content'];
        $position_box_content[$x] = $data['position_hierarchy_box_content'];
        $userrights_box_content[$x] = $data['userrights_hierarchy_box_content'];
        $x++;
    }
    $query->closeCursor();
    
    #[stats]
    $prepared_query = 'SELECT * FROM stats_page
                       WHERE id_page = :idpage';
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('idpage', $id_page);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $stats_currentpage_totalviews = $data['count_statspage'];
        $stats_currentpage_totalviews = number_format($stats_currentpage_totalviews, 0, ',', '.');
    }
    $query->closeCursor();
    #[/stats]
?>
<tr>
    <td align="center">
        <table class="block_title1" width="100%" style="width: 180px;">
            <tr>
                <td>
                   <?php echo($title_box); ?>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="center">
        <table class="block_main3"  cellpadding="0" cellspacing="0" width="100%">
<?php
            if($stats_currentpage_totalviews > 0)
            {
?>
                <tr>
                    <td align="left" width="100%">        
                        <span class="font_main" style="font-size: 10px;">
                            <?php give_translation('immo.stats_currentpage_totalviews', $echo, $config_showtranslationcode); ?>                
                        </span>
                    </td>
                    <td align="right">
                        <span class="font_main" style="font-size: 10px;">
                            <?php
                                echo($stats_currentpage_totalviews);
                            ?>
                        </span>
                    </td>
                </tr>
<?php
            }
       
    
    for($x = 1, $countx = count($type_box_content); $x < $countx; $x++)
    {     
        if($typelink_box_content[$x] == 'page')
        {
            if(!empty($_SESSION['index']) && $_SESSION['index'] == 'index.php')
            {
                 $prepared_query = 'SELECT * FROM page
                                    INNER JOIN page_translation
                                    ON page_translation.id_page = page.id_page
                                    WHERE page.id_page = :page
                                    AND family_page_translation = "rewritingF"';
            }
            else
            {
                 $prepared_query = 'SELECT * FROM page
                                    INNER JOIN page_translation
                                    ON page_translation.id_page = page.id_page
                                    WHERE page.id_page = :page
                                    AND family_page_translation = "rewritingB"';
            }

            $query = $connectData->prepare($prepared_query);
            $query->bindParam('page', $link_box_content[$x]);
            $query->execute();    

            if(($data = $query->fetch()) != false)
            {
                if(!empty($data['L'.$main_id_language]))
                {
                    $temphref_box_content = $data['L'.$main_id_language];
                }
                else
                {
                    $href_box_content = $config_customheader.$_SESSION['index'].'?page='.$data['url_page'];
                }
            }

            if(!empty($temphref_box_content))
            {
                //$temphref_box_content = split_string($temphref_box_content, '$');


                    $href_box_content = $config_customheader.$temphref_box_content;
            }
        }

        if($typelink_box_content[$x] == 'url')
        {
           $href_box_content = $link_box_content[$x];
        }

        $temp_code_box_content = split_string($code_box_content[$x], '$');
        $temp_margin_box_content = split_string($margin_box_content[$x], '$');

        $result_margin_box_content = $temp_margin_box_content[0].'px '.$temp_margin_box_content[1].'px '.$temp_margin_box_content[2].'px '.$temp_margin_box_content[3].'px';
        $href_box_content = str_replace('[#id_product]', $id_page, $href_box_content); 
        $href_box_content = str_replace('[#url_product]', $url_page, $href_box_content); 

        if($href_box_content == '[#print]')
        {
            $href_box_content = str_replace('[#print]', 'index_print.php?page='.$url_page, $href_box_content);
            $boxcontent_eventjs = 'onclick="popup(\''.$href_box_content.'\', \'600\', \'auto\')"';
            $href_box_content = '#';
        }                      
        
        
        if(checkrights($main_rights_log, $userrights_box_content[$x], $redirection) === true)
        {
?>
            <tr>
                <td width="65%" align="left" colspan="2">                    
                    <a style="margin: <?php echo($result_margin_box_content); ?>;" href="<?php echo($href_box_content); ?>" class="<?php echo($type_box_content[$x]); ?>" <?php if(!empty($boxcontent_eventjs)){ echo($boxcontent_eventjs); } ?> ><?php echo($title_box_content[$x]); ?></a>
                </td>
            </tr>
<?php
        }
        unset($temp_margin_box_content, $result_margin_box_content, $boxcontent_eventjs);
    }
    
?>
        </table>
    </td>
</tr>
<?php    
    

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

unset($id_box_content, $code_box_content, $type_box_content, $typelink_box_content,
      $title_box_content, $link_box_content, $level_box_content, $margin_box_content,
      $position_box_content);
?>
