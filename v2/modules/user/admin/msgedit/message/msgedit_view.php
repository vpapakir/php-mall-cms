<tr>
<td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left" style="vertical-align: top;">
                    <span class="font_subtitle">
                        <?php give_translation('message_edit.view_status', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="85%">
                    <span class="font_main">
                       <?php echo($msgedit_view_status); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="left" style="vertical-align: top;">
                    <span class="font_subtitle">
                        <?php give_translation('message_edit.view_sender', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="85%">
                    <span class="font_main">
                       <?php echo($msgedit_view_sender_title); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="left" style="vertical-align: top;">
                    <span class="font_subtitle">
                        <?php give_translation('message_edit.view_receiver', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left">
                    <span class="font_main">
                       <?php echo($data['receiveremail_messages']); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="left" style="vertical-align: top;">
                    <span class="font_subtitle">
                        <?php give_translation('message_edit.view_date', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left">
                    <span class="font_main">
                       <?php echo($msgedit_view_longdate); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="left" style="vertical-align: top;">
                    <span class="font_subtitle">
                        <?php give_translation('message_edit.view_type', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left">
                    <span class="font_main">
                       <?php echo($msgedit_view_type); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="left" style="vertical-align: top;">
                    <span class="font_subtitle">
                        <?php give_translation('message_edit.view_subject', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left">
                    <span class="font_main">
                       <?php echo($msgedit_view_subject); ?>
                    </span>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left">
        <table class="block_main2" width="100%">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('message_edit.view_message', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td align="left">                           
                   <?php echo(str_replace('600', '490', $data['content_messages'])); ?>
                </td>
            </tr>
<?php 
            if(empty($data['reply_messages']) || $data['type_messages'] == 'mailing')
            {
                include('modules/user/admin/msgedit/message/msgedit_reply.php');
?>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>    
                <tr>
                    <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
                </tr>
                <tr>
                    <td colspan="2"><table width="100%">
                        <tr>        
                            <td align="center">
<?php
                            if($data['type_messages'] != 'mailing')
                            {
?>
                                <span id="msgedit_btreply" class="link_input" style="padding: 4px;" onclick="hideshow('msgedit_view_reply', 'msgedit_btreply', '<?php echo($msgedit_view_btreply_hide); ?>', '<?php echo($msgedit_view_btreply_show); ?>')"><?php echo($msgedit_view_btreply_show); ?></span>
<?php
                            }
?>
                                <input type="submit" name="bt_settoread_msgedit<?php echo($data[0]); ?>" value="<?php give_translation('main.bt_backtolist', '', $config_showtranslationcode); ?>"/>
                                <input type="submit" name="bt_cancel_msgedit" value="<?php give_translation('main.bt_cancel', '', $config_showtranslationcode); ?>"/>                          
                            </td>
                        </tr> 
                    </table></td>
                </tr>
<?php
            }
?>     
        </table>
    </td>
</tr>
<?php
if(!empty($data['reply_messages']))
{
    include('modules/user/admin/msgedit/message/msgedit_reply_view.php');
}
?>

