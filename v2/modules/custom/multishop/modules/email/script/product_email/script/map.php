<?php
#[map]
if(!empty($customgetinfo_district_situation) && $customgetinfo_district_situation > 0)
{
    try 
    {
        $prepared_query = 'SELECT * FROM cdrgeo_image
                           WHERE id_cdrgeo = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $customgetinfo_district_situation);
        $query->execute();
        if(($data = $query->fetch()) != false)
        {
            unset($href_district_situation);

            #link page related
            $prepared_query = 'SELECT cdrgeo.pageinfo_cdrgeo, page_translation.L'.$main_id_language.' 
                               FROM `cdrgeo`
                               INNER JOIN `page`
                               ON page.id_page = cdrgeo.pageinfo_cdrgeo
                               INNER JOIN `page_translation`
                               ON page_translation.id_page = page.id_page
                               WHERE family_page_translation = "rewritingF"
                               AND id_cdrgeo = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query_district_situation = $connectData->prepare($prepared_query);
            $query_district_situation->bindParam('id', $customgetinfo_district_situation);
            $query_district_situation->execute();

            if(($data_district_situation = $query_district_situation->fetch()) != false)
            {
                $href_district_situation = $data_district_situation[1];
            }
            $query_district_situation->closeCursor();
            unset($query_district_situation);
            
            $message .= '<tr>
                            <td><table class="block_main5" width="100%" style="margin: 0px 0px 4px 0px;">
                                <tr>
                                    <td><table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="vertical-align: top;" align="center" title="'.give_translation('main.legend_productmap', 'false', $config_showtranslationcode).'">
                                                <a href="'.$config_customheader.$href_district_situation.'" target="_blank">
                                                    <img style="border: none;" src="'.$config_customheader.$data['paththumb_image'].'" alt="'.$data['alt_image'].'"/>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: top;" align="left">                                                                   
                                                <div style="margin: 0px 3px 0px 3px; 
                                                            font-size: 12px;
                                                            font-weight: normal;
                                                            color: #000000;
                                                            text-decoration: none;
                                                            text-align: left;">'.give_translation('main.legend_productmap', 'false', $config_showtranslationcode).'</div>
                                            </td>
                                        </tr>
                                    </table></td>
                                </tr>
                            </table></td>
                        </tr>';                                           
        }
        $query->closeCursor();
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
unset($href_district_situation);
#[/map]
?>
