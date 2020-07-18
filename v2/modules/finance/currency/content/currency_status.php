<tr>
    <td><table class="block_main2">     
            <tr>
                <td align="left"></td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input id="chkPriorityCurrency" type="checkbox" name="chkPriorityCurrency" value="1" <?php if(!empty($_SESSION['currency_chkPriorityCurrency']) && $_SESSION['currency_chkPriorityCurrency'] == 1){ echo('checked="checked"'); }else{ echo(null); } ?>/>
                    <LABEL style="cursor: pointer;" for="chkPriorityCurrency">
                        <span class="font_main">Devise par défaut</span>
                    </LABEL>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    Position
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 50px;" type="text" name="txtPositionCurrency" value="<?php if(!empty($_SESSION['currency_txtPositionCurrency'])){ echo($_SESSION['currency_txtPositionCurrency']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_currency_position']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_currency_position']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            
            <tr>
                <td align="left" class="font_subtitle">
                    Statut
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboStatusCurrency">
                        <option value="1" 
                            <?php if(empty($_SESSION['currency_cboStatusCurrency']) || $_SESSION['currency_cboStatusCurrency'] == 1){ echo('selected="selected"'); }else{ echo(null); } ?>
                                >Activé</option>
                        <option value="9"
                            <?php if(!empty($_SESSION['currency_cboStatusCurrency']) && $_SESSION['currency_cboStatusCurrency'] == 9){ echo('selected="selected"'); }else{ echo(null); } ?>
                                >Désactivé</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                    <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                        <tr>
                            <td align="center">
<?php
                            if(empty($_SESSION['currency_cboSelectCurrency']) || $_SESSION['currency_cboSelectCurrency'] == 'new')
                            {
?>
                                <input type="submit" name="bt_add_currency" value="Ajouter"/>
<?php
                            }
                            else
                            {
?>
                                <input type="submit" name="bt_edit_currency" value="Sauvegarder"/>
<?php
                            }
?>                                
                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
    </table></td>
</tr>
