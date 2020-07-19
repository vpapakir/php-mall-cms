<TABLE width="100%">
    
        <td id="center_subtitle" align="center">Détails</td>
        
    <tr><td colspan="2"><hr></hr></td></tr>
    
        <td><TABLE width="100%" border="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
                <tr>
                    <td width="30%" id="center_subtitle">Prix en Euro</td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Détail TTC</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Promo TTC</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Revendeur HT</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Eco-Taxe</span></div></td>
                </tr>
                <tr>
                    <td id="center_text_table"></td>
                    <td id="center_text_table"><input id="textfield_cells" type="text" name="txtPublic" value="<?php if(!empty($_SESSION['product_edit_price_public'])){ unset($_SESSION['product_add_price_public']); echo(number_format($_SESSION['product_edit_price_public'], 2, '.', '')); }else{ unset($_SESSION['product_edit_price_public']); } if(!empty($_SESSION['product_add_price_public'])){ echo(number_format($_SESSION['product_add_price_public'], 2, '.', '')); }else{ unset($_SESSION['product_add_price_public']); } ?>"/></td>
                    <td id="center_text_table"><input id="textfield_cells" type="text" name="txtPromo" value="<?php if(!empty($_SESSION['product_edit_price_promo'])){ unset($_SESSION['product_add_price_promo']); echo(number_format($_SESSION['product_edit_price_promo'], 2, '.', '')); }else{ unset($_SESSION['product_edit_price_promo']); } if(!empty($_SESSION['product_add_price_promo'])){ echo(number_format($_SESSION['product_add_price_promo'], 2, '.', '')); }else{ unset($_SESSION['product_add_price_promo']); } ?>"/></td>
                    <td id="center_text_table"><input id="textfield_cells" type="text" name="txtResale" value="<?php if(!empty($_SESSION['product_edit_price_resale'])){ unset($_SESSION['product_add_price_resale']); echo(number_format($_SESSION['product_edit_price_resale'], 2, '.', '')); }else{ unset($_SESSION['product_edit_price_resale']); } if(!empty($_SESSION['product_add_price_resale'])){ echo(number_format($_SESSION['product_add_price_resale'], 2, '.', '')); }else{ unset($_SESSION['product_add_price_resale']); } ?>"/></td>
                    <td id="center_text_table"><input id="textfield_cells" type="text" name="txtEcoTax" value="<?php if(!empty($_SESSION['product_edit_price_ecotax'])){ unset($_SESSION['product_add_price_ecotax']); echo(number_format($_SESSION['product_edit_price_ecotax'], 2, '.', '')); }else{ unset($_SESSION['product_edit_price_ecotax']); } if(!empty($_SESSION['product_add_price_ecotax'])){ echo(number_format($_SESSION['product_add_price_ecotax'], 2, '.', '')); }else{ unset($_SESSION['product_add_price_ecotax']); } ?>"/></td>
                </tr>              
            </TABLE></td>
        
    <tr></tr>
     
         <td><TABLE width="100%" border="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
                <tr>
                    <td width="30%" id="center_subtitle">Dimensions et poids</td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Longeur/cm</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Largeur/cm</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Profondeur</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Poids/gr</span></div></td>
                </tr>
                <tr>
                    <td id="center_text_table"></td>
                    <td id="center_text_table"><input id="textfield_cells" type="text" name="txtLength" value="<?php if(!empty($_SESSION['product_edit_length'])){ unset($_SESSION['product_add_length']); echo($_SESSION['product_edit_length']); }else{ unset($_SESSION['product_edit_length']); } if(!empty($_SESSION['product_add_length'])){ echo($_SESSION['product_add_length']); }else{ unset($_SESSION['product_add_length']); } ?>"/></td>
                    <td id="center_text_table"><input id="textfield_cells" type="text" name="txtWidth" value="<?php if(!empty($_SESSION['product_edit_width'])){ unset($_SESSION['product_add_width']); echo($_SESSION['product_edit_width']); }else{ unset($_SESSION['product_edit_width']); } if(!empty($_SESSION['product_add_width'])){ echo($_SESSION['product_add_width']); }else{ unset($_SESSION['product_add_width']); } ?>"/></td>
                    <td id="center_text_table"><input id="textfield_cells" type="text" name="txtDepth" value="<?php if(!empty($_SESSION['product_edit_depth'])){ unset($_SESSION['product_add_depth']); echo($_SESSION['product_edit_depth']); }else{ unset($_SESSION['product_edit_depth']); } if(!empty($_SESSION['product_add_depth'])){ echo($_SESSION['product_add_depth']); }else{ unset($_SESSION['product_add_depth']); } ?>"/></td>
                    <td id="center_text_table"><input id="textfield_cells" type="text" name="txtWeigth" value="<?php if(!empty($_SESSION['product_edit_weigth'])){ unset($_SESSION['product_add_weigth']); echo($_SESSION['product_edit_weigth']); }else{ unset($_SESSION['product_edit_weigth']); } if(!empty($_SESSION['product_add_weigth'])){ echo($_SESSION['product_add_weigth']); }else{ unset($_SESSION['product_add_weigth']); } ?>"/></td>
                </tr>              
            </TABLE></td>
            
     <tr></tr>
     
         <td><TABLE width="100%" border="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">
                <tr>
                    <td width="30%" id="center_subtitle">Stock</td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Nom</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Disponible</span></div></td>
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Seuil alerte</span></div></td>        
                    <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Délais/jour</span></div></td>
                </tr>
                <tr>
                    <td id="center_text_table"></td>
                    <td id="center_text_table" align="right"><input id="textfield_cells" style="direction: ltr" type="text" name="txtNameStock" value="Dépôt Ivoy"/></td> 
                    <td id="center_text_table" align="right"><input id="textfield_cells" type="text" name="txtAvailableStock" value="<?php if(!empty($_SESSION['product_edit_available_stock'])){ unset($_SESSION['product_add_available_stock']); echo($_SESSION['product_edit_available_stock']); }else{ unset($_SESSION['product_edit_available_stock']); } if(!empty($_SESSION['product_add_available_stock'])){ echo($_SESSION['product_add_available_stock']); }else{ unset($_SESSION['product_add_available_stock']); } ?>"/></td>
                    <td id="center_text_table" align="right"><input id="textfield_cells" type="text" name="txtAlertStock" value="<?php if(!empty($_SESSION['product_edit_alert_stock'])){ unset($_SESSION['product_add_alert_stock']); echo($_SESSION['product_edit_alert_stock']); }else{ unset($_SESSION['product_edit_alert_stock']); } if(!empty($_SESSION['product_add_alert_stock'])){ echo($_SESSION['product_add_alert_stock']); }else{ unset($_SESSION['product_add_alert_stock']); } ?>"/></td>      
                    <td id="center_text_table" align="right"><input id="textfield_cells" type="text" name="txtDelayStock" value="<?php if(!empty($_SESSION['product_edit_delay_stock'])){ unset($_SESSION['product_add_delay_stock']); echo($_SESSION['product_edit_delay_stock']); }else{ unset($_SESSION['product_edit_delay_stock']); } if(!empty($_SESSION['product_add_delay_stock'])){ echo($_SESSION['product_add_delay_stock']); }else{ unset($_SESSION['product_add_delay_stock']); } ?>""/></td>
                </tr>              
            </TABLE></td>
      
</TABLE>

