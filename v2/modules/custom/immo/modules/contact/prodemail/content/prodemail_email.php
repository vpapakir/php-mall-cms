<?php
for($i = 0; $i < 5; $i++)
{
 if(!empty($_SESSION['kform_prodemail_txtOtheremailProdemail'.$i]))
 {
     $kformprodemail_bok_display = true;
     $i = 5;
 }
 else
 {
     $kformprodemail_bok_display = false;
 }
}
?>

<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('kform_prodemail.subtitle_youremail', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <input style="width: 99%;" type="text" name="txtUseremailProdemail" value="<?php if(empty($_SESSION['kform_prodemail_txtUseremailProdemail'])){ echo($kformprodemail_user_email); }else{ echo($_SESSION['kform_prodemail_txtUseremailProdemail']); } ?>"/>
<?php
                    if(!empty($_SESSION['msg_kform_prodemail_txtUseremailProdemail']))
                    {
?>
                        <br clear="left"/>
                        <div class="font_error1"><?php echo($_SESSION['msg_kform_prodemail_txtUseremailProdemail']); ?></div>
<?php
                    }
?>
                </td>
            </tr>
            <tr>
                <td align="left"></td>
                <td align="left">
                    <br clear="left"/>
                    <span id="kformProdemail_bt_otheremail" class="link_input" onclick="hideshow('kformProdemail_otheremail', 'kformProdemail_bt_otheremail', '<?php echo($kformprodemail_bt_value_hide); ?>', '<?php echo($kformprodemail_bt_value_show); ?>')">
                        <?php if($kformprodemail_bok_display === false){ echo($kformprodemail_bt_value_show); }else{ echo($kformprodemail_bt_value_hide); } ?>
                    </span>
                </td>         
            </tr>
        </table>
    </td>
</tr>
<tr id="kformProdemail_otheremail" style="
    <?php 
    if($kformprodemail_bok_display === false)
    {
        echo('display: none;');
    }
?>">
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
<?php
            for($i = 0, $y = 1; $i < 5; $i++, $y++)
            {
?>
                <tr>
                    <td align="left">
                        <span class="font_subtitle">
                            <?php give_translation('kform_prodemail.subtitle_otheremail', $echo, $config_showtranslationcode); echo(' - '.$y); ?>
                        </span>
                    </td>
                    <td align="left" width="<?php echo($right_column_width); ?>">
                        <input style="width: 99%;" type="text" name="txtOtheremailProdemail<?php echo($i); ?>" value="<?php if(!empty($_SESSION['kform_prodemail_txtOtheremailProdemail'.$i])){ echo($_SESSION['kform_prodemail_txtOtheremailProdemail'.$i]); } ?>"/>
                        <?php
                        if(!empty($_SESSION['msg_kform_prodemail_txtOtheremailProdemail'.$i]))
                        {
?>
                            <br clear="left"/>
                            <div class="font_error1"><?php echo($_SESSION['msg_kform_prodemail_txtOtheremailProdemail'.$i]); ?></div>
<?php
                        }
?>
                    </td>
                </tr>
<?php
            }
?>
        </table>
    </td>
</tr>
