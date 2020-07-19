<?php
if((checkrights($main_rights_log, $userrights_hierarchybox[$i])) === true)
{
    #tabbar L
    $id_box_structure = 9;

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
        include('modules/box/tabbarL');
    ?>

    </table>
    </td>                       
    </tr>
<?php
}
?>
