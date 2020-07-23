<?php
try 
{   
    if(!isset($type_box_content)) {
	$type_box_content = [];
    }
    $prepared_query = 'SELECT * FROM hierarchy_box
                       WHERE id_hierarchy_box = 6';
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('id', $id_hierarchybox[$i]);
    $query->execute();

    if(($data = $query->fetch()) != false)
    { 
        $title_box = $data['L'.$main_id_language];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM hierarchy_box_content
                       WHERE status_hierarchy_box_content = 1
                       AND id_hierarchy_box = 6
                       ORDER BY code_hierarchy_box_content';
    $query = $connectData->prepare($prepared_query);
    //$query->bindParam('id', $id_hierarchybox[$i]);
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
?>
<tr>
    <td align="left">
        <table width="100%" cellpadding="0" cellspacing="1">
            <tr>
                <td align="left">             
                    <span class="font_main" style="font-size: 10px;">
                        <?php give_translation('main.software_name', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="right" >       
                    <span class="font_main" style="font-size: 10px;">
                        <?php give_translation('main.software_version', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="left">             
                    <span class="font_main" style="font-size: 10px;">
                        <?php give_translation('main.copyright_license', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="right">       
                    <span class="font_main" style="font-size: 10px;">
                        <?php give_translation('main.build_number', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="left">             
                    <span class="font_main" style="font-size: 10px;">
                        <?php give_translation('main.copyright_by', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="right">       
                    <a class="link_main" href="<?php give_translation('main.software_website', $echo, $config_showtranslationcode); ?>" target="_blank" style="font-size: 10px;"><?php give_translation('main.software_publisher', $echo, $config_showtranslationcode); ?></a>
                </td>
            </tr>
            <tr>
                <td align="left">             
                    <span class="font_main" style="font-size: 10px;">
                        <?php give_translation('main.copyright_authorized', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="right"> 
                    <span class="font_main" style="font-size: 10px;">
                        <?php give_translation('main.copyright_authorized_check', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
            </tr>
<?php
 
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
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    echo $_SESSION['error400_message'];
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
        </table>
    </td>
</tr>
