<tr>
    <td>
    <table width="100%" class="block_main2" cellpadding="0" cellspacing="0">

        <tr>
            <td align="left">
                <input type="checkbox" id="chk_all_displayvalue" name="chk_all_displayvalue" value="1" onclick="check_all('chk_all_displayvalue', 'input', 'chk_displayvalue');" <?php if(!empty($_SESSION['displayvalue_checkbox_all']) && $_SESSION['displayvalue_checkbox_all'] == true){ echo('checked="checked"'); }else{ echo(null); } ?>/>
            </td>
            <td>
                <label for="chk_all_displayvalue" style="cursor: pointer;"><span class="font_main"><?php give_translation('displayvalueimmo.main_chk_all'); ?></span></label>
            </td>               
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
<?php
        if(!empty($_SESSION['displayvalue_checkbox']))
        {
            $checked_option_displayvalue = $_SESSION['displayvalue_checkbox'];
            $checked_option_displayvalue = split_string($checked_option_displayvalue, '$');
        }


        try
        {
            $prepared_query = 'SHOW COLUMNS FROM immo_product';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();
            $i = 0;
            $y = 0;
            while($data = $query->fetch())
            {
                if($i >= 4 && $i != 14) #14 = surfacegroundm2
                {
?>
                    <tr>
                        <td align="left">
                            <input class="chk_displayvalue" type="checkbox" id="chk_<?php echo($data[0]); ?>" name="chk_<?php echo($data[0]); ?>" value="1" <?php if(!empty($checked_option_displayvalue[$y]) && $checked_option_displayvalue[$y] == 1){ echo('checked="checked"'); }else{ echo(null); } ?>/>
                        </td>
                        <td align="left">
                            <label for="chk_<?php echo($data[0]); ?>" style="cursor: pointer;"><span class="font_main"><?php give_translation('displayvalueimmo.'.$data[0]); ?></span></label>
                        </td>
                    </tr>
<?php
                    $y++;
                }
                $i++;
            }
            $query->closeCursor();
        }
        catch(Exception $e)
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
        <tr>
            <td><div style="height: 4px;"></div></td>
        </tr>
        <tr>
            <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                    <tr>
                        <td align="center">
                            <input type="submit" name="bt_save_displayvalue" value="Appliquer"/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
    </table>
    </td>
</tr>
