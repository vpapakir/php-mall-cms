<?php
if(empty($main_iduser_log))
{
    #LOGIN
    include('modules/user/box/login/bt_logme_loginbox.php');

    $id_box_structure = 13;

    include('structure/box/block_getinfo.php');
    include('structure/box/box_getinfo.php');
    if(isset($url_page) && $url_page != 'login_subscribe')
    {
?>
    <tr>
    <td style="background-color: <?php echo($tablebg_frame); ?>; vertical-align: top;"><form method="post"><table style="width: <?php echo($width_box); ?>; 
               border: <?php echo($border_box.' solid '.$bordercolor_box); ?>;
               position: <?php echo($position_box); ?>; margin: <?php echo($margin_box); ?>;
               <?php if(!empty($tablebg_box)){ ?>background-color: <?php echo($tablebg_box); ?>;<?php } ?>" 
               cellpadding="<?php echo($cp_box); ?>" cellspacing="<?php echo($cs_box); ?>">
<?php
                if(empty($blocktitle_box_structure) && empty($blockcontent_box_structure))
                {
?>             
                   <tr> 
                   <td <?php if(!empty($tablebg_box)){ ?>style="background-color: <?php echo($tablebg_box); ?>;"<?php } ?>><table class="block_main1" cellpadding="0" cellspacing="0"> 
<?php                       
                }
                else
                {
                   if(empty($blocktitle_box_structure) || empty($blockcontent_box_structure))
                   {
                       if(!empty($blocktitle_box_structure))
                       {
?>
                           <tr>
                           <td <?php if(!empty($tablebg_box)){ ?>style="background-color: <?php echo($tablebg_box); ?>;"<?php } ?>><table id="block_box_title<?php echo($id_box_structure); ?>" cellpadding="0" cellspacing="0">        
<?php                       
                       }

                       if(!empty($blockcontent_box_structure))
                       {
?>
                           <tr>        
                           <td <?php if(!empty($tablebg_box)){ ?>style="background-color: <?php echo($tablebg_box); ?>;"<?php } ?>><table id="block_box_content<?php echo($id_box_structure); ?>" cellpadding="0" cellspacing="0">
<?php                       
                       }
                   }
                   else
                   {
?>
                       <tr>            
                       <td <?php if(!empty($tablebg_box)){ ?>style="background-color: <?php echo($tablebg_box); ?>;"<?php } ?>>
                           <table id="collapseBoxLogin"
<?php
                                if(empty($_SESSION['expand_box_login']) || $_SESSION['expand_box_login'] == 'false')
                                {
                                    echo('class="block_collapsetitle1"');
                                }
                                else
                                {
                                    echo('class="block_expandtitle1"');
                                }
?> 
                                style="cursor: pointer; padding: 2px;" cellspacing="0"
                                onclick="expand_collapse_tab('block_expand_collapseBoxLogin', 'img_expand_collapseBoxLogin', 'expand_box_login', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseBoxLogin');" style="cursor: pointer;">
                               <tr>
                                   <td align="left" style="vertical-align: middle;">                    
<?php
                                    if(empty($_SESSION['expand_box_login']) || $_SESSION['expand_box_login'] == 'false')
                                    {
?>
                                        <img id="img_expand_collapseBoxLogin" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                                    }
                                    else
                                    {
?>
                                        <img id="img_expand_collapseBoxLogin" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                                    }
?>                    
                                   </td>    
                                   <td width="100%" align="left">
                                       &nbsp;
                                       <span id="<?php echo($font_blocktitle); ?>" style="margin: <?php echo($titlemargin_hierarchybox[$i]); ?>; text-align: <?php echo($titlealign_hierarchybox[$i]);  ?>;">
                                           <?php echo($title_hierarchybox[$i]); ?>                                 
                                       </span>
                                   </td>
                               </tr>
                            </table>
                           <input id="expand_box_login" style="display: none;" type="hidden" name="expand_box_login" value="<?php if(empty($_SESSION['expand_box_login']) || $_SESSION['expand_box_login'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
                       </td>

                       </tr>

                       <tr id="block_expand_collapseBoxLogin" <?php
                            if(empty($_SESSION['expand_box_login']) || $_SESSION['expand_box_login'] == 'false')
                            {
                                echo('style="display: none;"');
                            }
                            else
                            {
                                echo(null);
                            }
?>
                        >

                       <td <?php if(!empty($tablebg_box)){ ?>style="background-color: <?php echo($tablebg_box); ?>;"<?php } ?>>
                           <table id="block_box_content<?php echo($id_box_structure); ?>" cellpadding="<?php echo($padding_blockcontent); ?>" style="margin-top: 2px;">
<?php
                   }
                }
?>        


<?php
        if($Bok_include_both === true)
        {
            include($include_path);

?>
            <tr>

            <td>     
<?php 

            echo($include_code);
?>
            </td>
            </tr>
<?php            
        }
        else
        {
            if($Bok_include_path === false)
            {
                echo($include_script);
            }
            else
            {

                include($include_script);
            }
        }
?>

<?php
                if(empty($blocktitle_box_structure) && empty($blockcontent_box_structure))
                {
?>              
                   </table></td>
                   </tr>
<?php                       
                }
                else
                {
                    if(empty($blocktitle_box_structure) || empty($blockcontent_box_structure))
                    {
                       if(!empty($blocktitle_box_structure))
                       {
?>
                           </table></td> 
                           </tr>
<?php                       
                       }

                       if(!empty($blockcontent_box_structure))
                       {
?>
                           </table></td>
                           </tr>
<?php                       
                       }

                    }
                    else
                    {
?>        
                           </table></td>
                           </tr>

<?php 
                    }
                }
?>

    </table></form>
    </td> 
    </tr>
<?php
    }
}
?>
