<tr>
    <td width="25%" class="font_subtitle" style="vertical-align: top;"><?php give_translation('immo.searchproperty_refine_district', $echo, $config_showtranslationcode); ?></td>
<?php
        if(!empty($_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'][0]) && $_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'][0] != 'select')
        {
            $salesearch_parent_district = $_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'];
        }
        else
        {
            $salesearch_parent_district = $_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'];
        }

    try
    {
        #District
        $prepared_query = 'SELECT * FROM cdrgeo
                           WHERE ';
        for($i = 0, $count = count($salesearch_parent_district); $i < $count; $i++)
        {
            if($i == ($count - 1))
            {
                $prepared_query .= 'parentdepartment_cdrgeo = '.$salesearch_parent_district[$i].' ';
            }
            else
            {
                $prepared_query .= 'parentdepartment_cdrgeo = '.$salesearch_parent_district[$i].' OR ';
            }
        }
        $prepared_query .= ' ORDER BY L'.$main_id_language;
        
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $i = 0;

        while($data = $query->fetch())
        {
            $salesearch_id_district[$i] = $data['id_cdrgeo'];
            $salesearch_code_district = $data['code_cdrgeo'];
            $salesearch_status_district = $data['status_cdrgeo'];
            $salesearch_statusobject_district[$i] = $data['statusobject_cdrgeo'];
            $salesearch_name_district[$i] = $data['L'.$main_id_language];
            $i++;
        }
        $query->closeCursor();
        //echo('<tr><td>'.var_dump($salesearch_name_district).'</td></tr>');
        if($salesearch_status_district == 1)
        {
?>

            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>                                   
                        <td>
<?php                       
                        cdrgeo('checkbox', $salesearch_name_district, $salesearch_code_district, $salesearch_statusobject_district, $salesearch_id_district, $_SESSION['SaleSearch_cdrgeo_district_situationSaleSearch'], false, '', '', '', '', '', '', '', '', 'false', '', '', '', 'true', 'district_product_immo', '=');                                      
?>
                        </td>
                    </tr>
                </table>
            </td>    

<?php
        }
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
?>
</tr>
