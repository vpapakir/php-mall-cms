<tr>
    <td align="left"><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td align="left" colspan="2">
                <textarea style="width: 99%;" name="areaMsgProposeP" rows="5"><?php if(empty($_SESSION['form_proposep_areaMsgProposeP'])){ give_translation('propose_property.textarea_myrequest_default', $echo, $config_showtranslationcode); echo(':&nbsp;'); }else{ echo($_SESSION['form_proposep_areaMsgProposeP']); }?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
        <tr>
            <td colspan="2"><table width="100%" style="">
                <tr>        
                    <td align="center">
                        <input type="submit" name="bt_send_proposeproperty" value="<?php give_translation('main.bt_submit', '', $config_showtranslationcode); ?>"/>
                    </td>
                </tr> 
            </table></td>
        </tr>
    </table></td>
</tr>
