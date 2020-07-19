<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('adminconfig_edit.subtitle_addname', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input type="text" name="txtAddNameConfigAdmin"/>
<?php
                    if(!empty($_SESSION['msg_adminconfig_txtAddNameConfigAdmin']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_adminconfig_txtAddNameConfigAdmin']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
        </table>
    </td>
</tr>