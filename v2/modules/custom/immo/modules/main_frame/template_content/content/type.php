<?php
#type
if($customgetinfo_displayvalue[2] == 1)
{               
?>
    <tr>    
        <td class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        give_translation('displayvalueimmo.type_product_immo');
?>
        </td>
        <td class="font_main">
<?php 
        $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                           WHERE id_cdreditor = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $customgetinfo_type);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            echo($data[0]);
        } 
?>
        </td>
    </tr>
<?php            
}
?>
