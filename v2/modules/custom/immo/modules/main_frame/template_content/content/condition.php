<?php
#condition
if($customgetinfo_displayvalue[19] == 1)
{
    if($customgetinfo_condition != 'select')
    {
?>
        <tr>    
            <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
            give_translation('displayvalueimmo.condition_product_immo');
?>
            </td>
            <td align="left" class="font_main">
<?php
            $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                               WHERE id_cdreditor = :id';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->bindParam('id', $customgetinfo_condition);
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
}
?>
