<tr>
    <td><table class="block_main2">               
            <tr>
                <td align="left" class="font_subtitle">
                    Nom (code traduction)
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input id="txtTransCodeCurrency" readonly="readonly" type="text" name="txtTransCodeCurrency" value="<?php if(!empty($_SESSION['currency_txtTransCodeCurrency'])){ echo($_SESSION['currency_txtTransCodeCurrency']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_currency_transcode']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_currency_transcode']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    Nom (code)
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input id="txtCodeCurrency" style="width: 50px;" type="text" name="txtCodeCurrency" value="<?php if(!empty($_SESSION['currency_txtCodeCurrency'])){ echo($_SESSION['currency_txtCodeCurrency']); } ?>" onblur="copyandpaste('txtCodeCurrency', 'txtTransCodeCurrency', 'currency_', '', 'true', 'true'); touppercase('txtCodeCurrency');"/>
<?php
                    if(!empty($_SESSION['msg_currency_code']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_currency_code']); ?></div>
<?php
                    }
?>         
                    <input style="width: 50px;" type="hidden" name="hiddenOldCodeCurrency" value="<?php if(!empty($_SESSION['currency_txtCodeCurrency'])){ echo($_SESSION['currency_txtCodeCurrency']); } ?>"/>
                </td>
            </tr>
            <tr>
                <td align="left" class="font_subtitle">
                    Symbole
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 50px;" type="text" name="txtSymbolCurrency" value="<?php if(!empty($_SESSION['currency_txtSymbolCurrency'])){ echo($_SESSION['currency_txtSymbolCurrency']); } ?>"/>
                </td>
            </tr>
<?php
            if(!empty($_SESSION['currency_chkPriorityCurrency']) && $_SESSION['currency_chkPriorityCurrency'] == 1)
            {
?>
                <tr>
                    <td align="left" class="font_subtitle">
                        Indice par défaut
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <input style="width: 50px;" type="text" name="txtDefaultvalueCurrency" value="<?php if(!empty($_SESSION['currency_txtDefaultvalueCurrency'])){ echo(number_format($_SESSION['currency_txtDefaultvalueCurrency'], 5, '.', '')); } ?>"/>
                    </td>
                </tr>
            
<?php
                for($i = 0, $count = count($main_activatedidcurrency); $i < $count; $i++)
                {
                    if($main_activatedidcurrency[$i] != $_SESSION['currency_cboSelectCurrency'])
                    {
?>                
                        <tr>
                            <td align="left" class="font_subtitle">
                                Indice - <?php give_translation($main_activatedtranscodecurrency[$i]); echo(' ('.$main_activatedsymbolcurrency[$i].')');?>
                            </td>
                            <td align="left" width="<?php echo($right_column_width); ?>">
                                <input style="width: 50px;" type="text" name="txtValueCurrency<?php echo($main_activatedidcurrency[$i]); ?>" value="<?php if(!empty($_SESSION['currency_ValueCurrency'.$main_activatedidcurrency[$i]])){ echo(number_format($_SESSION['currency_ValueCurrency'.$main_activatedidcurrency[$i]], 5, '.', '')); } ?>"/>
                            </td>
                        </tr>
<?php                
                    }
                }
            }
?>
            
    </table></td>
</tr>
