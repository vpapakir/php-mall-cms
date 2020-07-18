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
                       <?php echo($myaccount_msg_view_status); ?>
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
                       <?php echo($myaccount_msg_view_sender_title); ?>
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
                       <?php echo($myaccount_msg_view_receiver_title); ?>
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
                       <?php echo($myaccount_msg_view_longdate); ?>
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
                       <?php echo($myaccount_msg_view_type); ?>
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
                       <?php echo($myaccount_msg_view_subject); ?>
                    </span>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
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
            if(empty($data['reply_messages']))
            {
                include('modules/user/myaccount/message/view/myaccountmsg_reply.php');
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
                                <span id="myaccountmsg_btreply" class="link_input" style="padding: 4px;" onclick="hideshow('myaccountmsg_view_reply', 'myaccountmsg_btreply', '<?php echo($myaccount_msg_view_btreply_hide); ?>', '<?php echo($myaccount_msg_view_btreply_show); ?>')"><?php echo($myaccount_msg_view_btreply_show); ?></span>
                                <input type="submit" name="bt_back_myaccountmsg" value="<?php give_translation('main.bt_backtolist', '', $config_showtranslationcode); ?>"/>                               
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
    include('modules/user/myaccount/message/view/myaccountmsg_reply_view.php');
}
?>

