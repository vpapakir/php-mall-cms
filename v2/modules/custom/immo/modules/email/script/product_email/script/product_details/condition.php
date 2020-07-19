<?php
#condition
if($customgetinfo_displayvalue[19] == 1)
{
    if($customgetinfo_condition != 'select')
    {
        $message .= '<tr>    
                    <td class="font_subtitle" width="'.$custom_1column_width.'" style="vertical-align: top;">';
        
        $message .= give_translation('displayvalueimmo.condition_product_immo', 'false', $config_showtranslationcode);
        
        $message .= '</td>
                    <td class="font_main">';

        $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                           WHERE id_cdreditor = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $customgetinfo_condition);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $message .= $data[0];
        }
        $query->closeCursor();
        
        $message .= '</td>
                    </tr>'; 
    }
}
?>
