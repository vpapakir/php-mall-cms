<tr>
    <td align="left"><table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
            <td align="left" colspan="2" style="vertical-align: top;">
                <span class="font_subtitle"><?php give_translation('propose_property.subtitle_userinfo', '', $config_showtranslationcode); ?></span>
                <br clear="left"/>
                [<a class="link_main" href="<?php echo($config_customheader.$rewritingF_myaccount_page); ?>"><?php give_translation('propose_property.link_modify_userinfo', '', $config_showtranslationcode); ?></a>]
            </td>
            <td width="<?php echo($right_column_width); ?>" style="vertical-align: top;">
                <span class="font_main"><?php echo($proposep_user_firstname.' '.$proposep_user_lastname); ?></span>
                
<?php
                if(!empty($proposep_user_companyname))
                {
?>
                    <br clear="left"/>
                    <span class="font_main"><?php echo($proposep_user_companyname); ?></span>               
<?php
                }
                
                if(!empty($proposep_user_address1))
                {
?>
                    <br clear="left"/>
                    <span class="font_main"><?php echo($proposep_user_address1); ?></span>               
<?php
                }
                
                if(!empty($proposep_user_address2))
                {
?>
                    <br clear="left"/>
                    <span class="font_main"><?php echo($proposep_user_address2); ?></span>               
<?php
                }
                
                if(!empty($proposep_user_zip) && !empty($proposep_user_city))
                {
?>
                    <br clear="left"/>
                    <span class="font_main"><?php echo($proposep_user_zip.' '.$proposep_user_city); ?></span>               
<?php
                }
                
                if(!empty($proposep_user_country))
                {
                    $proposep_user_selected_country = giveCDRvalue($proposep_user_country, 'cdrgeo', $main_id_language);
?>
                    <br clear="left"/>
                    <span class="font_main"><?php echo($proposep_user_selected_country); ?></span>               
<?php
                }
                
                if(!empty($proposep_user_landline))
                {
?>
                    <br clear="left"/>
                    <span class="font_main"><?php give_translation('propose_property.subtitle_landline', '', $config_showtranslationcode); echo(' '.$proposep_user_landline); ?></span>               
<?php
                }
                
                if(!empty($proposep_user_mobile))
                {
?>
                    <br clear="left"/>
                    <span class="font_main"><?php give_translation('propose_property.subtitle_mobile', '', $config_showtranslationcode); echo(' '.$proposep_user_mobile); ?></span>               
<?php
                }
                
                if(!empty($proposep_user_fax))
                {
?>
                    <br clear="left"/>
                    <span class="font_main"><?php give_translation('propose_property.subtitle_fax', '', $config_showtranslationcode); echo(' '.$proposep_user_fax); ?></span>               
<?php
                }
                
                if(!empty($proposep_user_email))
                {
?>
                    <br clear="left"/>
                    <span class="font_main"><?php echo($proposep_user_email); ?></span>               
<?php
                }
?>

            </td>
        </tr>           
    </table></td>
</tr>
