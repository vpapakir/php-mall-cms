<?php
if((checkrights($main_rights_log, '9', $userrights_hierarchybox[$i])) === true)
{
    $id_box_structure = 5;

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
    ?>              
    <!--               <td><table class="block_main1" cellpadding="0" cellspacing="0"> -->
    <?php                       
                }
                else
                {
                   if(empty($blocktitle_box_structure) || empty($blockcontent_box_structure))
                   {
                       if(!empty($blocktitle_box_structure))
                       {
    ?>
                           <td><table id="block_box_title<?php echo($id_box_structure); ?>" cellpadding="0" cellspacing="0">        
    <?php                       
                       }

                       if(!empty($blockcontent_box_structure))
                       {
    ?>
                           <td><table id="block_box_content<?php echo($id_box_structure); ?>" cellpadding="0" cellspacing="0">
    <?php                       
                       }
                   }
                   else
                   {
    ?>
                       <td><table id="block_box_title<?php echo($id_box_structure); ?>" cellpadding="0" cellspacing="0" style="border-style:none;">

                               <!-- <td class="font_subtitle" style="text-align: center;">
                                    &nbsp;
                               </td> -->

                        </table></td>

                        <tr style="height: 2px;"></tr>

                        <td>
    <?php
                   }
                }
    ?>        


        <?php
        if($Bok_include_both === true)
        {
            include($include_path);

    ?>
           
    <?php 

            echo($include_code);
    ?>
           
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
    <!--               </table></td>-->
    <?php                       
                }
                else
                {
                    if(empty($blocktitle_box_structure) || empty($blockcontent_box_structure))
                    {
                       if(!empty($blocktitle_box_structure))
                       {
    ?>
                           <!-- </table></td> -->   
    <?php                       
                       }

                       if(!empty($blockcontent_box_structure))
                       {
    ?>
                           <!-- </table></td> -->
    <?php                       
                       }

                    }
                    else
                    {
    ?>        
                           <!-- </table></td> -->

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
