<tr>
    <td align="left" class="font_subtitle">
        <?php give_translation('edit_structure.subtitle_expandtitle4_block', '', $config_showtranslationcode); ?>
    </td>
    <td align="left">
        <select name="cboSelectexpandtitle4Block">
            <option value="select"><?php give_translation('main.dd_select', '', $config_showtranslationcode); ?></option>
<?php
        for($i = 0, $count = count($id_block); $i < $count; $i++)
        {
?>
            <option value="<?php echo($id_block[$i]); ?>"
                    style="border: <?php echo($border_block[$i].'px solid'); ?>;
                            border-color: <?php echo($bordercolor_block[$i]); ?>;
                            border-radius: <?php echo($borderradius_lt_block[$i].'px '.$borderradius_rt_block[$i].'px '.$borderradius_rb_block[$i].'px '.$borderradius_lb_block[$i].'px'); ?>;
                            -moz-border-radius: <?php echo($borderradius_lt_block[$i].'px '.$borderradius_rt_block[$i].'px '.$borderradius_rb_block[$i].'px '.$borderradius_lb_block[$i].'px'); ?>;
                            -webkit-border-radius: <?php echo($borderradius_lt_block[$i].'px '.$borderradius_rt_block[$i].'px '.$borderradius_rb_block[$i].'px '.$borderradius_lb_block[$i].'px'); ?>;
                            background-color: <?php echo($bgcolor_block[$i]); ?>;
                            width: 100%;
                            height: 100%;
                            padding: <?php echo($padding_block[$i].'px'); ?>;
                            background-image: url('<?php echo($image_block[$i]); ?>');"
                    class="<?php echo($font_block[$i]); ?>"
                    <?php if(!empty($block_expandtitle4) && $block_expandtitle4 == $id_block[$i]){ echo('selected="selected"'); }else{ echo(null); } ?>
                ><?php echo($name_block[$i]); ?></option>
<?php            
        }
?>
        </select>
    </td>
</tr>
<tr>
    <td align="left" class="font_subtitle">
        <?php give_translation('edit_structure.subtitle_collapsetitle4_block', '', $config_showtranslationcode); ?>
    </td>
    <td align="left" width="<?php echo($right_column_width); ?>">
        <select name="cboSelectcollapsetitle4Block">
            <option value="select"><?php give_translation('main.dd_select', '', $config_showtranslationcode); ?></option>
<?php
        for($i = 0, $count = count($id_block); $i < $count; $i++)
        {
?>
            <option value="<?php echo($id_block[$i]); ?>"
                    style="border: <?php echo($border_block[$i].'px solid'); ?>;
                            border-color: <?php echo($bordercolor_block[$i]); ?>;
                            border-radius: <?php echo($borderradius_lt_block[$i].'px '.$borderradius_rt_block[$i].'px '.$borderradius_rb_block[$i].'px '.$borderradius_lb_block[$i].'px'); ?>;
                            -moz-border-radius: <?php echo($borderradius_lt_block[$i].'px '.$borderradius_rt_block[$i].'px '.$borderradius_rb_block[$i].'px '.$borderradius_lb_block[$i].'px'); ?>;
                            -webkit-border-radius: <?php echo($borderradius_lt_block[$i].'px '.$borderradius_rt_block[$i].'px '.$borderradius_rb_block[$i].'px '.$borderradius_lb_block[$i].'px'); ?>;
                            background-color: <?php echo($bgcolor_block[$i]); ?>;
                            width: 100%;
                            height: 100%;
                            padding: <?php echo($padding_block[$i].'px'); ?>;
                            background-image: url('<?php echo($image_block[$i]); ?>');"
                    class="<?php echo($font_block[$i]); ?>"
                    <?php if(!empty($block_collapsetitle4) && $block_collapsetitle4 == $id_block[$i]){ echo('selected="selected"'); }else{ echo(null); } ?>
                ><?php echo($name_block[$i]); ?></option>
<?php            
        }
?>
        </select>
    </td>
</tr>
<tr>
    <td align="left" class="font_subtitle">
        <?php give_translation('edit_structure.subtitle_expandcontent4_block', '', $config_showtranslationcode); ?>
    </td>
    <td align="left">
        <select name="cboSelectexpandmain4Block">
            <option value="select"><?php give_translation('main.dd_select', '', $config_showtranslationcode); ?></option>
<?php
        for($i = 0, $count = count($id_block); $i < $count; $i++)
        {
?>
            <option value="<?php echo($id_block[$i]); ?>"
                    style="border: <?php echo($border_block[$i].'px solid'); ?>;
                            border-color: <?php echo($bordercolor_block[$i]); ?>;
                            border-radius: <?php echo($borderradius_lt_block[$i].'px '.$borderradius_rt_block[$i].'px '.$borderradius_rb_block[$i].'px '.$borderradius_lb_block[$i].'px'); ?>;
                            -moz-border-radius: <?php echo($borderradius_lt_block[$i].'px '.$borderradius_rt_block[$i].'px '.$borderradius_rb_block[$i].'px '.$borderradius_lb_block[$i].'px'); ?>;
                            -webkit-border-radius: <?php echo($borderradius_lt_block[$i].'px '.$borderradius_rt_block[$i].'px '.$borderradius_rb_block[$i].'px '.$borderradius_lb_block[$i].'px'); ?>;
                            background-color: <?php echo($bgcolor_block[$i]); ?>;
                            width: 100%;
                            height: 100%;
                            padding: <?php echo($padding_block[$i].'px'); ?>;
                            background-image: url('<?php echo($image_block[$i]); ?>');"
                    class="<?php echo($font_block[$i]); ?>"
                    <?php if(!empty($block_expandmain4) && $block_expandmain4 == $id_block[$i]){ echo('selected="selected"'); }else{ echo(null); } ?>
                ><?php echo($name_block[$i]); ?></option>
<?php            
        }
?>
        </select>
    </td>
</tr>

<tr>
    <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
</tr>
