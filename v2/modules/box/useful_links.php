<?php
    unset($id_box_content, $code_box_content, $type_box_content, $typelink_box_content,
          $title_box_content, $link_box_content, $level_box_content, $margin_box_content,
          $position_box_content);

//for($y = 0, $count = count($id_hierarchybox); $y < $count; $y++)
//{
    try 
    {  
        $prepared_query = 'SELECT * FROM hierarchy_box_content
                           WHERE status_hierarchy_box_content = 1
                           AND id_hierarchy_box = :parent
                           ORDER BY code_hierarchy_box_content';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('parent', $id_hierarchybox[$i]);
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
            $userrights_box_content[$x] = $data['userrights_hierarchy_box_content'];
            $position_box_content[$x] = $data['position_hierarchy_box_content'];
            $x++;
        }
        
?>
        <tr>
            <td style="background-color: <?php echo($tablebg_box); ?>;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php

        for($x = 0, $countx = count($type_box_content); $x < $countx; $x++)
        { 
            unset($temp_margin_box_content, $result_margin_box_content, $temp_code_box_content, $href_box_content, $temphref_box_content, $prepared_query);
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
               
               if(!preg_match('#^http#', $href_box_content))
               {
                   $href_box_content = $config_customheader.$link_box_content[$x];
               }
            }
            
            $temp_code_box_content = split_string($code_box_content[$x], '$');
            $temp_margin_box_content = split_string($margin_box_content[$x], '$');
            
            $result_margin_box_content = $temp_margin_box_content[0].'px '.$temp_margin_box_content[1].'px '.$temp_margin_box_content[2].'px '.$temp_margin_box_content[3].'px';
            
            if(checkrights($main_rights_log, $userrights_box_content[$x], $redirection) === true)
            {
?>
                <tr>
<?php
                if($_SESSION['current_page'] == 'sitemap')
                {
?>
                    <td align="left" title="<?php echo('Référence: '.$temp_code_box_content[0].' - Position: '.$temp_code_box_content[1]); ?>"  width="35%">
                        <a class="link_main" style="font-size: 9px; margin-right: 4px;" href="<?php echo($config_customheader); change_link('Gestion/Sitemap/', 'Backoffice/Gestion/Sitemap/'); echo($id_box_content[$x]); ?>"><?php echo($temp_code_box_content[0].'-'.$temp_code_box_content[1]); ?></a>
                    </td>
<?php
                }
?>
                    <td width="65%" align="left">                    
                        <a class="<?php echo($type_box_content[$x]); ?>" style="margin: <?php echo($result_margin_box_content); ?>;" href="<?php echo($href_box_content);//if($_SESSION['current_page'] == 'sitemap'){ echo($header); change_link('Gestion/Sitemap', 'Backoffice/Gestion/Sitemap'); }else{ echo($href_box_content); }?>"><?php echo($title_box_content[$x]); ?></a>
                    </td>
                </tr>
<?php
            }
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
//}
?>    



