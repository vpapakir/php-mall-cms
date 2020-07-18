<?php
#furnished
if($customgetinfo_displayvalue[31] == 1 && $customgetinfo_furnished_other != 'select')
{
    $message .= '<tr>    
                     <td  class="font_subtitle" align="left" width="'.$custom_1column_width.'" style="vertical-align: top;">
                        '.give_translation('displayvalueimmo.furnished_product_immo', 'false', $config_showtranslationcode).'
                     </td>
                     <td align="left" class="font_main">';

    $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                       WHERE id_cdreditor = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_furnished_other);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $message .= $data[0];
    }
    $query->closeCursor(); 
    
    $message .=  '</td>
                  </tr>';          
}
?>
