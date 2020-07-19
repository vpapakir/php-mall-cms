<?php
#tv
if($customgetinfo_displayvalue[29] == 1)
{
    if(!empty($customgetinfo_tv_other))
    {
        $customgetinfo_tv_other = split_string($customgetinfo_tv_other, '$');
    }
    
    if(!empty($customgetinfo_tv_other))
    {
?>
        <tr>    
            <td align="left" class="font_subtitle" width="<?php echo($custom_1column_width); ?>" style="vertical-align: top;">
<?php
            give_translation('displayvalueimmo.tv_product_immo');
?>
            </td>
            <td align="left" class="font_main">
<?php  
                for($i = 0, $count = count($customgetinfo_tv_other); $i < $count; $i++)
                {
                    $prepared_query = 'SELECT L'.$main_id_language.'S FROM cdreditor
                                       WHERE id_cdreditor = :id';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('id', $customgetinfo_tv_other[$i]);
                    $query->execute();

                    if(($data = $query->fetch()) != false)
                    {
                        echo($data[0]);
                    }
                    $query->closeCursor();

                    if($i < ($count - 1))
                    {
                        echo(', ');
                    }
                }
?>
            </td>
        </tr>
<?php        
    }
}
?>
