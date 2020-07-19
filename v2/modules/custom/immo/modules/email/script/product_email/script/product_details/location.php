<?php
#location & locdetails
if(($customgetinfo_displayvalue[43] == 1 && !empty($customgetinfo_location_situation)) || ($customgetinfo_displayvalue[44] == 1 && !empty($customgetinfo_locdetails_situation)))
{ 
    if($customgetinfo_location_situation != 'select' || !empty($customgetinfo_locdetails_situation))
    {
        $message .= '<tr>    
                    <td class="font_subtitle" width="'.$custom_1column_width.'" style="vertical-align: top;">';
        
        $message .= give_translation('displayvalueimmo.location_product_immo', 'false', $config_showtranslationcode);       
         
        $message .= '</td>
                    <td class="font_main">';

        $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                           WHERE id_cdreditor = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $customgetinfo_location_situation);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $customgetinfo_location_situation = $data[0];
        }

        $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                           WHERE id_cdreditor = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $customgetinfo_locdetails_situation);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $customgetinfo_locdetails_situation = $data[0];
        }

        if($customgetinfo_displayvalue[43] == 1 && $customgetinfo_displayvalue[44] == 1 && $customgetinfo_location_situation != 'select' && !empty($customgetinfo_locdetails_situation))
        {
            $white_space = ', ';
        }
        else
        {
            $white_space = null;
        }

        if($customgetinfo_displayvalue[43] == 1 && $customgetinfo_location_situation != 'select')
        {
            $message .=$customgetinfo_location_situation;
        }

        $message .= $white_space;

        if($customgetinfo_displayvalue[44] == 1 && !empty($customgetinfo_locdetails_situation))
        {
            $message .=$customgetinfo_locdetails_situation;
        }

        $message .= '</td>
                    </tr>'; 
    }
}
?>
