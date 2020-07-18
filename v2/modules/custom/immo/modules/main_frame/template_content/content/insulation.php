<?php
#insulation
if($customgetinfo_displayvalue[24] == 1 && $customgetinfo_isolation_energy != 'select')
{
?>
    <tr>    
        <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
        give_translation('displayvalueimmo.insulation_product_immo');
?>
        </td>
        <td align="left" class="font_main">
<?php
        $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                           WHERE id_cdreditor = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('id', $customgetinfo_isolation_energy);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            echo($data[0]);
        }
        $query->closeCursor();
?>
        </td>
    </tr>
<?php            
}
?>
