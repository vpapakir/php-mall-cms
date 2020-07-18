<tr>
    <td align="left"><table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                    <span class="font_subtitle"><?php give_translation('propose_property.subtitle_typeoffer', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
<?php
                    cdreditor($proposep_type_offerobject, $proposep_nameS_offerobject, $proposep_code_offerobject, $proposep_statusobject_offerobject, $proposep_id_offerobject, $_SESSION['form_proposep_cdreditor_offer_object'], false);

                    if(!empty($_SESSION['msg_form_proposep_cdreditor_offer_object']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_form_proposep_cdreditor_offer_object']); ?></div>
<?php
                    }
?>

                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_error1" style="font-weight: bold; vertical-align: top;">*</span>
                    <span class="font_subtitle"><?php give_translation('propose_property.subtitle_typeproduct', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
<?php
                    cdreditor($proposep_type_typeobject, $proposep_nameS_typeobject, $proposep_code_typeobject, $proposep_statusobject_typeobject, $proposep_id_typeobject, $_SESSION['form_proposep_cdreditor_type_object'], false);
                    if(!empty($_SESSION['msg_form_proposep_cdreditor_type_object']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_form_proposep_cdreditor_type_object']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('propose_property.subtitle_condition', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
<?php
                    cdreditor($proposep_type_conditionobject, $proposep_nameP_conditionobject, $proposep_code_conditionobject, $proposep_statusobject_conditionobject, $proposep_id_conditionobject, $_SESSION['form_proposep_cdreditor_condition_object'], false);
?>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('propose_property.subtitle_location', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
<?php                       
                    cdreditor($proposep_type_locationsituation, $proposep_nameP_locationsituation, $proposep_code_locationsituation, $proposep_statusobject_locationsituation, $proposep_id_locationsituation, $_SESSION['form_proposep_cdreditor_location_situation'], false);                                      
?>                    
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php give_translation('propose_property.subtitle_price', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input type="text" name="txtPriceProposeP" value="<?php if(!empty($_SESSION['form_proposep_txtPriceProposeP'])){ echo($_SESSION['form_proposep_txtPriceProposeP']); } ?>"/>
                </td>
            </tr>
<!--            <tr>
                <td align="left">
                    <span class="font_subtitle"><?php //give_translation('propose_property.subtitle_picture', $echo, $config_showtranslationcode); ?></span>
                </td>
                <td align="left" width="<?php //echo($right_column_width); ?>">
                    
                </td>
            </tr>-->
    </table></td>
</tr>
