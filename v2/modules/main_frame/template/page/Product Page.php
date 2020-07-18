<?php
if(!empty($title_page))
{
?>
<tr>        
<td><table width="100%" cellpadding="0" cellspacing="0">    
        <tr>
            <td><table class="block_title3" width="100%" border="0" style="margin-bottom: 2px;">   
                 <tr>  
                    <td align="center" width="100%">                           
                        <span><?php echo($title_page); ?></span>
                    </td> 
<?php
                    if((checkrights($main_rights_log, '8')) === true)
                    {
?>  
                        <td align="center">
                            <span style="vertical-align: middle; margin-right: 20px;">
                                <a href="<?php echo($config_customheader); change_link('edition/page/'.$id_page, 'backoffice/edition/page/'.$id_page); ?>" target="_blank" style="text-decoration: none;"><img src="<?php echo($config_customheader.'graphics/icons/use/edit.gif'); ?>" alt="edit.gif" style="border: none;" title="<?php give_translation('main.admin_editpage', $echo, $config_showtranslationcode); ?>" onmouseover="this.src='<?php echo($config_customheader.'graphics/icons/use/edit-hover.gif'); ?>';" onmouseout="this.src='<?php echo($config_customheader.'graphics/icons/use/edit.gif'); ?>';"></img></a>
                            </span> 
                        </td>
<?php
                    }                           
?>
                 </tr>
            </table></td>
        </tr>   
</table></td>
</tr>
<?php
}
    
if(!empty($intro_page) || !empty($desc_page) || !empty($insert_script_page) || !empty($listingrelated_page))
{
?>
    <tr>
    <td><table class="block_main1" width="100%" border="0">
        <tr>
            <td align="left"><table width="100%" border="0">
            
<?php   
    if(!empty($intro_page))
    {    
?>    
        <tr>
            <td class="font_intro">                           
                <?php echo($intro_page); ?>
            </td>
        </tr>   
<?php   
    } else {
?>
        <tr>
            <td class="font_intro">                           
                <?php echo($intro_page); ?>
            </td>
        </tr>           
<?php
	}
    if(!empty($desc_page))
    {    
?>    
		<tr>
            <td class="font_desc">                           
                <?php echo($desc_page); ?>
            </td>
        </tr>   
<?php   
    } else {
?>  
		<tr>
            <td class="font_desc">                           
                <?php echo($desc_page); ?>
            </td>
        </tr>   
<?php
	}
?>
            </table></td>
        </tr>
<?php
    if(!empty($insert_script_page))
    {
        echo('<tr><td>');
        include($insert_script_page);
        echo('</td></tr>');
    }
    
    include('modules/main_frame/listing/listing_relatedpage.php');
?>
    </table></td>
    </tr>
<?php
}
?>
