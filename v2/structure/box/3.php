<?php
if((checkrights($main_rights_log, '9',$userrights_hierarchybox[$i])) === true)
{
    #Stats
    $id_box_structure = 3;

    include('structure/box/block_getinfo.php');
    include('structure/box/box_getinfo.php');

    ?>
    <tr>
    <td style="background-color: <?php echo($tablebg_frame); ?>; vertical-align: top;"><table style="width: <?php echo($width_box); ?>; 
               border: <?php echo($border_box.' solid '.$bordercolor_box); ?>;
               position: <?php echo($position_box); ?>; margin: <?php echo($margin_box); ?>;
               <?php if(!empty($tablebg_box)){ ?>background-color: <?php echo($tablebg_box); ?>;<?php } ?>" 
               cellpadding="<?php echo($cp_box); ?>" cellspacing="<?php echo($cs_box); ?>">

    <?php
                if(empty($blocktitle_box_structure) && empty($blockcontent_box_structure))
                {
    ?>             <tr> 
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
                       <td <?php if(!empty($tablebg_box)){ ?>style="background-color: <?php echo($tablebg_box); ?>;"<?php } ?>><table id="block_box_title<?php echo($id_box_structure); ?>" cellpadding="<?php //echo($padding_blocktitle); ?>" style="margin-bottom: 2px;">
                               <tr>
                               <td>
                                   <div class="<?php echo($font_blocktitle); ?>" style="margin: <?php echo($titlemargin_hierarchybox[$i]); ?>; text-align: <?php echo($titlealign_hierarchybox[$i]);  ?>;">
                                       <?php echo($title_hierarchybox[$i]); ?> 
                                   </div>
                               </td>
                               </tr>
                        </table></td>

                       </tr>

                       <tr>

                       <td <?php if(!empty($tablebg_box)){ ?>style="background-color: <?php echo($tablebg_box); ?>;"<?php } ?>><table id="block_box_content<?php echo($id_box_structure); ?>" cellpadding="<?php echo($padding_blockcontent); ?>" border="0">
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

    </table>
    </td> 
    </tr>
<?php
}
?>
