<tr>        
<td>XXXXXXX<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr>
        <td>
        <div class="highslide-body">

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php
                if(!empty($title_page) || !empty($code_page))
                {    
?>    
                    <tr>
                        <td colspan="2"><table class="block_title3" width="100%" border="0" style="margin-bottom: 2px;">   
                             <tr>  
                                <td align="center" width="100%"> 
                                    <span><?php if(!empty($title_page))
                                                {
                                                    echo($title_page); 
                                                }
                                                else
                                                {
                                                    echo($code_page); 
                                                } 
                                         ?>
                                    </span>
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
<?php   
                }
?>        
                <tr>
                <td><table class="block_main1" width="100%" border="0">  
<?php
                if(!empty($intro_page))
                {    
?>    
                    <tr>
                        <td>                           
                            <h2 class="font_intro" style="margin: 0px 4px 0px 4px;"><?php echo($intro_page); ?></h2>
                        </td>
                    </tr>   
<?php   
                }
                
                if(!empty($path_origin_page[0]))
                {
?>
                    <tr>
                        <td><table class="block_main5" width="100%" border="0">
                            <tr>
                                <td><table width="100%" cellpadding="0" cellspacing="0">                           
                                    <tr>
                                    <td style="vertical-align: top;" align="center">
                                        <a class="highslide" href="<?php echo($config_customheader.$path_origin_page[0]); ?>" onclick="return hs.expand(this);">
                                            <img style="border: none;" src="<?php echo($config_customheader.$path_origin_page[0]); ?>" alt="<?php echo($alt_image_page[0]); ?>" width="<?php echo($widthmax_frame_image); ?>"/> 
                                        </a>
                                    </td>
                                    </tr>
<?php
                                    if(!empty($legend_image_page[0]))
                                    {
?>
                                        <tr>
                                            <td align="center">
                                                <span class="font_main" style="margin: 0px 3px 0px 3px;"><?php echo($legend_image_page[0]); ?></span>
                                            </td>
                                        </tr>
<?php
                                    }
?>
                                </table></td>
                            </tr>
                        </table></td>
                    </tr>
<?php
                }
?>
                    
                    <tr>
                        <td style="vertical-align: top;"><table width="100%" border="0" cellspacing="0" cellpadding="0">    
                            <tr>
                                <td style="vertical-align: top;"><table width="100%"  cellspacing="0" cellpadding="0">                                  
<?php
                                //include('modules/custom/multishop/modules/main_frame/template_content/box/navbox.php');

                                for($i = 1, $count = count($id_image_page); $i < $count; $i++)
                                {
?>
                                    <tr>
                                        <td><table class="block_main5" width="100%" style="margin: 0px 0px 4px 0px;">
                                            <tr>
                                                <td><table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="vertical-align: top;" align="center">
                                                            <a class="highslide" href="<?php echo($config_customheader.$path_origin_page[$i]); ?>" onclick="return hs.expand(this);">
                                                                <img style="border: none;" src="<?php echo($config_customheader.$path_thumb_page[$i]); ?>" alt="<?php echo($alt_image_page[$i]); ?>"/>
                                                            </a>
                                                        </td>
                                                    </tr>
<?php
                                                    if(!empty($legend_image_page[$i]))
                                                    {
?>
                                                        <tr>
                                                            <td>
                                                                <span class="font_main" style="margin: 0px 3px 0px 3px;"><?php echo($legend_image_page[$i]); ?></span>
                                                            </td>
                                                        </tr>
<?php
                                                    }
        ?>
                                                </table></td>
                                            </tr>
                                        </table></td>
                                    </tr>
<?php
                                }
?>
                        
                                    </table></td>

                                    <td><div style="width: 4px;"></div></td>

                                    <td width="100%" style="vertical-align: top;">
                                        <table style="margin: 0px 0px 0px 0px;" width="100%" cellpadding="0" cellspacing="0">
                                            
                                            
<?php                                           
                                            if(!empty($desc_page))
                                            {    
?>    
                                                <tr>
                                                    <td>                           
                                                        <h3 class="font_desc" style="margin: 4px 4px 4px 4px;"><?php echo($desc_page); ?></h3>
                                                    </td>
                                                </tr>   
<?php   
                                            }
                                            else
                                            {
?>    
                                                <tr>
                                                    <td>                           
                                                        <div style="margin: 4px 4px 4px 4px;"></div>
                                                    </td>
                                                </tr>   
<?php                                                
                                            }
?>                                            
                                
                                        </table>                   
                                    </td>
                                    </tr>
                            
                            </table></td> 
                        </tr>
                        
<?php
                        include('modules/main_frame/listing/listing_relatedpage.php');
?>
                    
                    </table></td>
                </tr>

            </table>

        </div>            
        </td>
    </tr>
    
    </table>
</td>
</tr>
