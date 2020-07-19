<tr>
    <td><table class="block_main2">    
        <tr>
            <td align="left" class="font_subtitle">
                Devise
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <select name="cboSelectCurrency" onchange="OnChange('bt_cboSelectCurrency');">
                    <option value="new"
                        <?php if(empty($_SESSION['currency_cboSelectCurrency']) || $_SESSION['currency_cboSelectCurrency'] == 'new'){ echo('selected="selected"'); }else{ echo(null); } ?>
                            ><?php give_translation('currency_edit.new_currency'); ?></option>
                    
<?php
        try
        {
            $prepared_query = 'SELECT * FROM currency
                               WHERE status_currency = 1
                               ORDER BY priority_currency, position_currency, shortname_currency';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();

            while($data = $query->fetch())
            {
?>
                <option value="<?php echo($data[0]); ?>"
                    <?php if(!empty($_SESSION['currency_cboSelectCurrency']) && $_SESSION['currency_cboSelectCurrency'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>
                        ><?php give_translation('main.'.$data['longname_currency']); echo(' ('.$data['symbol_currency'].')'); ?></option>
<?php                    
            }
            $query->closeCursor();
            
            $prepared_query = 'SELECT * FROM currency
                               WHERE status_currency = 9
                               ORDER BY priority_currency, position_currency, shortname_currency';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute();

            while($data = $query->fetch())
            {
?>
                <option value="<?php echo($data[0]); ?>" style="background-color: lightblue;"
                    <?php if(!empty($_SESSION['currency_cboSelectCurrency']) && $_SESSION['currency_cboSelectCurrency'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>
                        ><?php give_translation('main.'.$data['longname_currency']); echo(' ('.$data['symbol_currency'].')'); ?></option>
<?php                    
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
                </select>
                <input type="submit" style="display: none;" hidden="hidden" id="bt_cboSelectCurrency" name="bt_cboSelectCurrency" value="Choix devise"/>
            </td>
        </tr>
    </table></td>
</tr>
