<tr>
    <td width="25%" class="font_subtitle" style="vertical-align: top;"><?php give_translation('immo.searchproperty_refine_department', $echo, $config_showtranslationcode); ?></td>
<?php
    try
    {
        #District
        $prepared_query = 'SELECT * FROM cdrgeo
                           WHERE code_cdrgeo = "cdrgeo_department_situation"
                           AND statusobject_cdrgeo = 1
                           ORDER BY L'.$main_id_language;
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);

        $query->execute();
        $i = 0;

        while($data = $query->fetch())
        {
            $salesearch_id_department[$i] = $data['id_cdrgeo'];
            $salesearch_code_department = $data['code_cdrgeo'];
            $salesearch_status_department = $data['status_cdrgeo'];
            $salesearch_statusobject_department[$i] = $data['statusobject_cdrgeo'];
            $salesearch_name_department[$i] = $data['L'.$main_id_language];
            $i++;
        }
        $query->closeCursor();
        //echo('<tr><td>'.var_dump($salesearch_name_department).'</td></tr>');
        if($salesearch_status_department == 1)
        {
?>

            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>                                   
                        <td>
<?php                       
                        cdrgeo('multi', $salesearch_name_department, $salesearch_code_department.'SaleSearch', $salesearch_statusobject_department, $salesearch_id_department, $_SESSION['SaleSearch_cdrgeo_department_situationSaleSearch'], false, '', '', '', '', '', '', '', '', 'false', '', '', '', 'true', 'department_product_immo', '=');                                      
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
