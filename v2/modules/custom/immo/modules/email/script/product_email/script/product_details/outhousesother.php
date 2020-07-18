<?php
#outhouses other
if($customgetinfo_displayvalue[49] == 1)
{
    if(!empty($customgetinfo_other_exterior))
    {
        $customgetinfo_other_exterior = split_string($customgetinfo_other_exterior, '$');
    }
    
    if(!empty($customgetinfo_other_exterior))
    {
        $message .= '<tr>    
                         <td  class="font_subtitle" align="left" width="'.$custom_1column_width.'" style="vertical-align: top;">
                            '.give_translation('displayvalueimmo.exteriorother_product_immo', 'false', $config_showtranslationcode).'
                         </td>
                         <td align="left" class="font_main">';
        for($i = 0, $count = count($customgetinfo_other_exterior); $i < $count; $i++)
        {
            $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                               WHERE id_cdreditor = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $customgetinfo_other_exterior[$i]);
            $query->execute();

            if(($data = $query->fetch()) != false)
            {
                $message .= $data[0];
            }
            $query->closeCursor();

            if($i < ($count - 1))
            {
                $message .= ', ';
            }
        }
        $message .=  '</td>
                  </tr>'; 
    }
}
?>
