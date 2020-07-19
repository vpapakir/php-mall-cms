<tr>
    <td width="25%" class="font_subtitle" style="vertical-align: top;"><?php give_translation('immo.searchproperty_refine_condition', $echo, $config_showtranslationcode); ?></td>
<?php
    try
    {
        #Condition
        $prepared_query = 'SELECT * FROM cdreditor
                           WHERE code_cdreditor = "cdreditor_condition_object"
                           AND statusobject_cdreditor = 1
                           ORDER BY L'.$main_id_language.'S';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $i = 0;

        while($data = $query->fetch())
        {
            $salesearch_id_condition[$i] = $data['id_cdreditor'];
            $salesearch_code_condition = $data['code_cdreditor'];
            $salesearch_status_condition = $data['status_cdreditor'];
            $salesearch_statusobject_condition[$i] = $data['statusobject_cdreditor'];
            $salesearch_nameS_condition[$i] = $data['L'.$main_id_language.'S'];
            $i++;
        }
        $query->closeCursor();
        if($salesearch_status_condition == 1)
        {
?>
            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>                                   
                        <td>
<?php  
                        cdreditor('checkbox', $salesearch_nameS_condition, $salesearch_code_condition.'SaleSearch', $salesearch_statusobject_condition, $salesearch_id_condition, $_SESSION['SaleSearch_cdreditor_condition_objectSaleSearch'], false, '', '', '', '', '', '', 'false', '', '', 'true', 'condition_product_immo', '=');                                  
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
