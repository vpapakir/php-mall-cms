<tr>
    <td align="left"><table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php
    try
    {
        #Offer
        $prepared_query = 'SELECT * FROM cdreditor
                           WHERE code_cdreditor = "cdreditor_offer_object"
                           AND statusobject_cdreditor = 1
                           ORDER BY L'.$main_id_language.'S';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();
        $p = 0;

        while($data = $query->fetch())
        {
            $quicksearch_id_offer[$p] = $data['id_cdreditor'];
            $quicksearch_code_offer = $data['code_cdreditor'];
            $quicksearch_status_offer = $data['status_cdreditor'];
            $quicksearch_statusobject_offer[$p] = $data['statusobject_cdreditor'];
            $quicksearch_nameS_offer[$p] = $data['L'.$main_id_language.'S'];
            $p++;
        }
        $query->closeCursor();
        if($quicksearch_status_offer == 1)
        {
?>
            <td align="left">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>                                   
                        <td align="left">
<?php  
                        #cdreditor('checkbox', $quicksearch_nameS_offer, $quicksearch_code_offer.'Quicksearch', $quicksearch_statusobject_offer, $quicksearch_id_offer, $_SESSION['quicksearch_cdreditor_offer_objectQuicksearch'], false, '', '', '', '', '', '', 'true', 3, 1, 'true', 'offer_product_immo', '=');                                  
?>
                        </td>
                    </tr>
<?php
                    if(!empty($_SESSION['msg_quicksearch_offer']))
                    {
?>
                        <tr>
                            <td align="left">                        
                                <div class="font_error1"><?php echo($_SESSION['msg_quicksearch_offer']); ?></div>
                            </td>
                        </tr>
<?php
                    }
?>
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
    </table></td>
</tr>
