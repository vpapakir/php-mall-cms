<tr>
    <td width="25%" class="font_subtitle" style="vertical-align: top;"><?php give_translation('immo.searchproperty_refine_typeobject', $echo, $config_showtranslationcode); ?></td>
<?php
    try
    {
        #Type Object
        $prepared_query = 'SELECT * FROM cdreditor
                           WHERE code_cdreditor = "cdreditor_type_object"
                           AND statusobject_cdreditor = 1
                           ORDER BY L'.$main_id_language.'S';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $i = 0;

        while($data = $query->fetch())
        {
            $salesearch_id_typeobject[$i] = $data['id_cdreditor'];
            $salesearch_code_typeobject = $data['code_cdreditor'];
            $salesearch_status_typeobject = $data['status_cdreditor'];
            $salesearch_statusobject_typeobject[$i] = $data['statusobject_cdreditor'];
            $salesearch_nameS_typeobject[$i] = $data['L'.$main_id_language.'S'];
            $i++;
        }
        $query->closeCursor();
        if($salesearch_status_typeobject == 1)
        {
?>

            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>                                   
                        <td>                           
<?php                      
                        cdreditor('checkbox', $salesearch_nameS_typeobject, $salesearch_code_typeobject.'SaleSearch', $salesearch_statusobject_typeobject, $salesearch_id_typeobject, $_SESSION['SaleSearch_cdreditor_type_objectSaleSearch'], false, '', '', '', '', '', '', 'false', '', '', 'true', 'type_product_immo', '=');                                    
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
