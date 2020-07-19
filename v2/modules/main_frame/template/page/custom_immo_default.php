<tr>        
<td><table width="100%" border="0"> 
    <tr>
        <td>
        <div class="highslide-body">

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
<?php
                if(!empty($title_page))
                {    
?>    
                    <tr>
                        <td colspan="2">                           
                            <h1 class="font_title"><?php echo($title_page); ?></h1>
                        </td>
                    </tr>   
<?php   
                }
?>        
                <tr>
                <td><table class="block_main1" width="100%" border="0" style="border: none;">  
<?php
                if(!empty($intro_page))
                {    
?>    
                    <tr>
                        <td colspan="2">                           
                            <h2 class="font_intro"><?php echo($intro_page); ?></h2>
                        </td>
                    </tr>   
<?php   
                }
?>
                <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">    
<?php
                        for($i = 0, $count = count($id_image_page); $i < $count; $i++)
                        {
?>
                            <tr>
                                <td style="vertical-align: top;">
                                    <a class="highslide" href="<?php echo($config_customheader.$path_origin_page[$i]); ?>" onclick="return hs.expand(this);">
                                        <img style="border: 1px solid lightgrey;" src="<?php echo($config_customheader.$path_thumb_page[$i]); ?>" alt="<?php echo($alt_image_page[$i]); ?>"/>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style="height: 20px; vertical-align: super;">
                                    <span class="font_main" style="margin: 0px 0px 0px 0px;"><?php echo($legend_image_page[$i]); ?></span>
                                </td>
                            </tr>
<?php
                        }
?>
                        </table>
                    </td> 

                    <td width="100%" style="vertical-align: top;">
                        <table style="margin: 0px 3px 0px 3px;" width="100%" cellpadding="0" cellspacing="0">
<?php                            
                                if(empty($insert_script_page))
                                {
                                    if(!empty($desc_page))
                                    {    
?>    
                                        <tr>
                                            <td colspan="2">                           
                                                <h3 class="font_desc"><?php echo($desc_page); ?></h3>
                                            </td>
                                        </tr>   
<?php   
                                    }
                                }

                                if(!empty($insert_script_page))
                                {    
                                    echo('<tr><td>');
                                    include($insert_script_page);
                                    echo('</td></tr>');
                                }

                                if(!empty($insert_script_page))
                                {
                                    if(!empty($desc_page))
                                    {    
?>    
                                        <tr>
                                            <td colspan="2">                           
                                                <h3 class="font_desc"><?php echo($desc_page); ?></h3>
                                            </td>
                                        </tr>   
<?php   
                                    }
                                }
?>

                        </table>                   
                    </td>
                    </tr>
                </table></td>
                </tr>

            </table>

        </div>
        </td>
    </tr>
    </table>
</td>
</tr>
