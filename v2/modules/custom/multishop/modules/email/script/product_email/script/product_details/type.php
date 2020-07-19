<?php
#type
if($customgetinfo_displayvalue[2] == 1)
{     
    $message .= '<tr>    
                 <td  class="font_subtitle" align="left" width="'.$custom_1column_width.'" style="vertical-align: top;">
                    '.give_translation('displayvalueimmo.type_product_immo', 'false', $config_showtranslationcode).'
                 </td>
                 <td align="left" class="font_main">';
 
    $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                       WHERE id_cdreditor = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $customgetinfo_type);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $message .= $data[0];
    } 
    
    $message .=  '</td>
                  </tr>';          
}
?>
