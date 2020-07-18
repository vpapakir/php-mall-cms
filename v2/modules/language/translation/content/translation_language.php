<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
<?php
        $y = 0;
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {      
            if($y == 0)
            {
?>
                <tr>
                    <td align="left" style="vertical-align: top;">
                        <span class="font_subtitle">
<?php
                            if($i == 0)
                            {
                                give_translation('edit_translation.subtitle_choice_language', $echo, $config_showtranslationcode);
                            }
?>  
                        </span>
                    </td>   
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <table width="100%" cellpadding="0" cellspacing="1">
                            <tr>
                                <td aling="left" width="33%">
                                    <input id="chkLangTranslation<?php echo($main_activatedidlang[$i]); ?>" type="checkbox" name="chkLangTranslation<?php echo($main_activatedidlang[$i]); ?>" value="1" <?php if(!empty($_SESSION['translation_chkLangTranslation'.$main_activatedidlang[$i]]) && $_SESSION['translation_chkLangTranslation'.$main_activatedidlang[$i]] == 1){ echo('checked="checked"'); } ?>/>
                                    <label class="font_main" for="chkLangTranslation<?php echo($main_activatedidlang[$i]); ?>" style="cursor: pointer;">
<?php
                                        give_translation($main_activatedcodelang[$i], $echo, $config_showtranslationcode);
?>     
                                    </label>
                                </td>
<?php
            }
            
            if($y > 0)
            {
?>
                <td aling="left" width="33%">                
                    <input id="chkLangTranslation<?php echo($main_activatedidlang[$i]); ?>" type="checkbox" name="chkLangTranslation<?php echo($main_activatedidlang[$i]); ?>" value="1" <?php if(!empty($_SESSION['translation_chkLangTranslation'.$main_activatedidlang[$i]]) && $_SESSION['translation_chkLangTranslation'.$main_activatedidlang[$i]] == 1){ echo('checked="checked"'); } ?>/>
                    <label class="font_main" for="chkLangTranslation<?php echo($main_activatedidlang[$i]); ?>" style="cursor: pointer;">
<?php
                        give_translation($main_activatedcodelang[$i], $echo, $config_showtranslationcode);
?>     
                    </label>
                </td>
<?php                
            }
            
            if($y == 2 || $i == ($count - 1))
            {
                $y = 0;
?>         
                            </table>
                        </tr>
                    </td>
                </tr>
<?php
            }
            else
            {            
                $y++;
            }
        }
?>
    </table></td>
</tr>