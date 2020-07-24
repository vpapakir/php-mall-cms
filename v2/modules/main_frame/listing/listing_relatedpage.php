<?php
if(!empty($listingrelated_page))
{
?>
    <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 4px;">  
<?php
    $listingrelated_page = split_string($listingrelated_page, '$');
    $temp_listingpagerelated_title = null;
    for($i = 0, $count = count($listingrelated_page); $i < $count; $i++)
    {
        #title to sort array order by alpha
        $prepared_query = 'SELECT L'.$main_id_language.', level_rights FROM page_translation
                           INNER JOIN page
                           ON page_translation.id_page = page.id_page
                           WHERE page.id_page = :id
                           AND family_page_translation = "title"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $listingrelated_page[$i]);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $temp_listingpagerelated_title[$i] = $listingrelated_page[$i].'$'.$data[0].'$'.$data[1];
        }
        $query->closeCursor();
    }
    
    sort($temp_listingpagerelated_title);
 
    for($i = 0, $count = count($temp_listingpagerelated_title); $i < $count; $i++)
    {
        $temp2_listingpagerelated_title = null;
        $temp2_listingpagerelated_title = split_string($temp_listingpagerelated_title[$i], '$');
        $listingrelated_page[$i] = $temp2_listingpagerelated_title[0];
        
        if((checkrights($main_rights_log, $temp2_listingpagerelated_title[2], $redirection, $excludeSA = "")) === true)
        {
            if(!empty($listingrelated_page[$i]))
            {
                try
                {
                    #image
                    $prepared_query = 'SELECT * FROM page_image
                                       WHERE id_page = :id
                                       AND position_image = 1
                                       ORDER BY position_image';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $listingrelated_page[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $listingpagerelated_firstimage_search = $data['pathsearch_image'];
                        $listingpagerelated_firstimage_alt = $data['alt_image'];
                    }
                    $query->closeCursor(); 

                    #title
                    $prepared_query = 'SELECT L'.$main_id_language.' FROM page_translation
                                       WHERE id_page = :id
                                       AND family_page_translation = "title"';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $listingrelated_page[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $listingpagerelated_title = $data[0];
                    }
                    $query->closeCursor(); 

                    #intro
                    $prepared_query = 'SELECT L'.$main_id_language.' FROM page_translation
                                       WHERE id_page = :id
                                       AND family_page_translation = "intro"';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $listingrelated_page[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $listingpagerelated_intro = $data[0];
                    }
                    $query->closeCursor(); 

                    #rewritingF
                    $prepared_query = 'SELECT L'.$main_id_language.' FROM page_translation
                                       WHERE id_page = :id
                                       AND family_page_translation = "rewritingF"';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $listingrelated_page[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $listingpagerelated_rewritingF = $data[0];
                    }
                    $query->closeCursor();

                    #rewritingB
                    $prepared_query = 'SELECT L'.$main_id_language.' FROM page_translation
                                       WHERE id_page = :id
                                       AND family_page_translation = "rewritingF"';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $listingrelated_page[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        $listingpagerelated_rewritingB = $data[0];
                    }
                    $query->closeCursor();

                    if(empty($listingpagerelated_firstimage_search))
                    {
                        $listingpagerelated_firstimage_search = $config_noimage_search;
                        $listingpagerelated_firstimage_alt = 'noimage.gif';
                    }
                    
                    if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y))
                    {
                        $listingpagerelated_mainimage_width = 100;
                        $listingpagerelated_mainimage_height = ($listingpagerelated_mainimage_width/$config_image_ratio_x * $config_image_ratio_y);
                    }

    ?>
                        <tr>                        
                            <td>
                                <a href="<?php echo($config_customheader); ?><?php change_link($listingpagerelated_rewritingF, $listingpagerelated_rewritingB) ?>" class="font_main">
                                <table class="block_listing2" width="100%" style="margin-bottom: 4px;">
                                    <tr>
                                        <td colspan="3"><table class="block_title2" width="100%">
                                            <tr>
                                                <td align="left">
        <?php 
                                                    echo($listingpagerelated_title);                                          
        ?>
                                                </td>
                                            </tr>
                                        </table></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <img style="border: 1px solid lightgray; <?php if(!empty($config_image_ratio_x) && !empty($config_image_ratio_y)){ ?>width: <?php echo($listingpagerelated_mainimage_width); ?>px; height: <?php echo($listingpagerelated_mainimage_height); ?>px;<?php } ?>" src="<?php echo($config_customheader.$listingpagerelated_firstimage_search); ?>" alt="<?php echo($listingpagerelated_firstimage_alt); ?>">
                                        </td>
                                        <td style="vertical-align: top;" width="100%">
                                            <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="left">
                                                        <span>
        <?php
                                                        echo(cut_string($listingpagerelated_intro, 0, 300, '...'));
        ?>
                                                        </span>
                                                    </td>
                                                </tr>                                           
                                            </table>
                                        </td>
                                        <td class="font_main" style="height: 100%; vertical-align: top;" width="30%">
                                            <table class="font_main" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="left">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left">
        <?php 

        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left">

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
        <?php

        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>              
                                    </tr>
                                </table>
                                </a>
                            </td>
                        </tr>
    <?php

                }
                catch (Exception $e)
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
        }
        
        unset($listingpagerelated_firstimage_search, $listingpagerelated_firstimage_alt,
                        $listingpagerelated_title, $listingpagerelated_intro, $listingpagerelated_rewritingF, $listingpagerelated_rewritingB);
    }
?>
    </table></td>
    </tr>
<?php
}
?>
