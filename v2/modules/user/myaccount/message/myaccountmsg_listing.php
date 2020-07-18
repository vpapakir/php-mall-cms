<tr>
    <td align="left">
        <table width="100%" cellpadding="0" cellspacing="1" border="0">
            <tr>  
                <td align="center" class="block_main2" style="width: 19%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('message_edit.listing_title_type', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 20%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('message_edit.listing_title_sender', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 40%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('message_edit.listing_title_subject', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 15%;">
                    <div class="font_subtitle" style="text-align: center;"><?php give_translation('message_edit.listing_title_date', '', $config_showtranslationcode); ?></div>
                </td>
                <td align="center" class="block_main2" style="width: 6%;">
                    <input id="chk_myaccountmsg_listingall" type="checkbox" name="chk_myaccountmsg_all" value="1" <?php if(!empty($_SESSION['myaccountmsg_chkall']) && $_SESSION['myaccountmsg_chkall'] == 1){ echo('checked="checked"'); } ?> onclick="check_all('chk_myaccountmsg_listingall', 'input', 'chk_myaccountmsg_listing');"/>
                </td>
            </tr>
        </table>
    </td>
</tr>
<?php
try
{
    $prepared_query = 'SELECT * FROM email_messages
                       WHERE target_messages = "user"
                       AND id_user = :iduser
                       ORDER BY status_messages, firstdate_messages DESC';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('iduser', $main_iduser_log);
    $query->execute();
        

    while($data = $query->fetch())
    {       
        $myaccount_msg_shortdate = converto_timestamp($data['firstdate_messages']);
        $myaccount_msg_longdate = date('d-m-Y, H:i', $myaccount_msg_shortdate);
        $myaccount_msg_shortdate = date('d-m-Y', $myaccount_msg_shortdate);
        
        $myaccount_msg_prepared_query = 'SELECT * FROM user
                                         WHERE email_user = :emailuser';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $myaccount_msg_prepared_query; }
        $myaccount_msg_query = $connectData->prepare($myaccount_msg_prepared_query);
        $myaccount_msg_query->bindParam('emailuser', $data['email_user']);
        $myaccount_msg_query->execute();
        if(($myaccount_msg_data = $myaccount_msg_query->fetch()) != false)
        {
            if(!empty($myaccount_msg_data['namecompany_user']))
            {
                $myaccount_msg_sender = $myaccount_msg_data['namecompany_user'];
                $myaccount_msg_sender_title = $myaccount_msg_data['namecompany_user']."\r\n".$myaccount_msg_data['firstname_user'].' '.$myaccount_msg_data['name_user']."\r\n".$data['senderemail_messages'];
            }
            else
            {
                $myaccount_msg_sender = substr($myaccount_msg_data['firstname_user'], 0, 1).'. '.$myaccount_msg_data['name_user'];
                $myaccount_msg_sender_title = $myaccount_msg_data['firstname_user'].' '.$myaccount_msg_data['name_user']."\r\n".$data['senderemail_messages'];   
            }
        }
        else
        {
            $myaccount_msg_sender = $data['senderemail_messages'];
            $myaccount_msg_sender_title = $data['senderemail_messages'];
        }
        $myaccount_msg_query->closeCursor();
        
        $myaccount_msg_subject = $data['subject_messages'];
        $myaccount_msg_subject_toreplace = strstr($myaccount_msg_subject, ']', true);
        $myaccount_msg_subject = trim(str_replace($myaccount_msg_subject_toreplace.']', '', $myaccount_msg_subject));
        $myaccount_msg_type = give_translation('mail_edit.dd_family_'.$data['type_messages'], 'false', $config_showtranslationcode);
        
        if((strstr($myaccount_msg_type, '(', true)) == true)
        {
            $myaccount_msg_type = strstr($myaccount_msg_type, '(', true);
        }
        $myaccount_msg_sender_title = nl2br($myaccount_msg_sender_title);
        
        $myaccount_msg_style = null;
        if($data['status_messages'] == 1)
        {
            $myaccount_msg_style = 'font-weight: bold;';
        }
        else
        {
            $myaccount_msg_style = 'color: grey;';
        }
?>
        <tr>
            <td align="left" onmouseover="this.style.backgroundColor = 'lightblue';" onmouseout="this.style.backgroundColor = 'white';">
                <table width="100%" cellpadding="0" cellspacing="1" border="0">
                    <tr>
                        <td class="tooltip" align="left" width="19%" title="<?php echo($myaccount_msg_type); ?>">                 
<?php
                            if(!empty($data['reply_messages']))
                            {
?>
                                <img src="<?php echo($config_customheader); ?>graphics/icons/mail/mailreply.gif" alt="mailreply.gif"/>
<?php
                            }
?>                            
                            <a class="link_main" href="<?php echo($config_customheader.'index.php?page='.$_SESSION['current_page'].'&amp;idmsg='.rawurlencode($data[0])); ?>">
                                <span class="font_main" style="margin-left: 4px; <?php echo($myaccount_msg_style); ?>">
                                    <?php echo(cut_string($myaccount_msg_type, 0, 8, '...', true)); ?>
                                </span>
                            </a>
                        </td>
                        <td class="tooltip" align="left" width="20%" title="<?php echo($myaccount_msg_sender_title); ?>">
                            <span class="font_main" style="margin-left: 4px; <?php echo($myaccount_msg_style); ?>">
                                <?php echo(cut_string($myaccount_msg_sender, 0, 10, '...', true)); ?>
                            </span>
                        </td>
                        <td class="tooltip" align="left" width="40%" title="<?php echo($myaccount_msg_subject); ?>">
                            <span class="font_main" style="margin-left: 4px; <?php echo($myaccount_msg_style); ?>">
                                <?php echo(cut_string($myaccount_msg_subject, 0, 25, '...', true)); ?>
                            </span> 
                        </td>
                        <td class="tooltip" align="center" width="15%" title="<?php echo($myaccount_msg_longdate); ?>">
                            <span class="font_main" style="<?php echo($myaccount_msg_style); ?>">
                                <?php echo($myaccount_msg_shortdate); ?>
                            </span> 
                        </td>
                        <td align="center" width="6%">                           
                            <input class="chk_myaccountmsg_listing" type="checkbox" name="chk_myaccountmsg<?php echo($data[0]); ?>" <?php if(!empty($_SESSION['myaccountmsg_chk'.$data[0]]) && $_SESSION['myaccountmsg_chk'.$data[0]] == 1){ echo('checked="checked"'); } ?> value="1"/>                                                 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
        unset($myaccount_msg_style);
    }
    $query->closeCursor();
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
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
                <input type="submit" name="bt_settoread_myaccountmsg" value="<?php give_translation('message_edit.bt_settoread', '', $config_showtranslationcode); ?>"/>
                <input type="submit" name="bt_settounread_myaccountmsg" value="<?php give_translation('message_edit.bt_settounread', '', $config_showtranslationcode); ?>"/>
                <input type="submit" name="bt_deleted_myaccountmsg" value="<?php give_translation('main.bt_delete', '', $config_showtranslationcode); ?>"/>
            </td>
        </tr> 
    </table></td>
</tr>
