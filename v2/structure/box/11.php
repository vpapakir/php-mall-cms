<?php
    #Search Main
    $id_box_structure = 11;

    include('structure/box/block_getinfo.php');
    #include('structure/box/box_getinfo.php');
?>

    <table style="width: <?php echo($width_box); ?>; 
                  border: <?php echo($border_box.' solid '.$bordercolor_box); ?>;
                  position: <?php echo($position_box); ?>; margin: <?php echo($margin_box); ?>;
                  <?php if(!empty($tablebg_box)){ ?>background-color: <?php echo($tablebg_box); ?>;<?php } ?>" 
                  cellpadding="<?php echo($cp_box); ?>" cellspacing="<?php echo($cs_box); ?>">

        <tr>
            <td <?php if(!empty($tablebg_box)){ ?>style="background-color: <?php echo($tablebg_box); ?>;"<?php } ?>><?php include($include_script); ?></td>
        </tr>

    </table> 
<?php
?>

