<?php
try
{
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page.id_page = page_translation.id_page
                       WHERE family_page_translation = "rewritingF"
                       AND url_page = "subscription"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $boxlogin_subscription_rewritingF = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page.id_page = page_translation.id_page
                       WHERE family_page_translation = "rewritingF"
                       AND url_page = "forgotten_pwd"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $boxlogin_forgottenpwd_rewritingF = $data[0];
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
    <td style="background-color: <?php echo($tablebg_box); ?>;"><table class="font_main" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2">
                <?php give_translation('login_subscribe.subtitle_nickemail', $echo, $config_showtranslationcode); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input style="width: 97%;" type="text" name="txtPseudoEmailLoginBox" value=""/>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php give_translation('login_subscribe.subtitle_pwd', $echo, $config_showtranslationcode); ?>
            </td>
        </tr>
        <tr>
            <td>
                <input style="width: 90%;" type="password" name="txtPasswordLoginBox" value=""/> 
            </td>
            <td align="right">
                <input type="submit" name="bt_logme_loginbox" value="OK"/>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>
<?php
            if(!empty($_SESSION['msg_logmebox_wronglogin']))
            {
                $_SESSION['unset_afterrefresh_logmebox_wronglogin']++;
?>
                <tr>
                    <td align="left" colspan="2">
                        <div class="font_error1"><?php echo($_SESSION['msg_logmebox_wronglogin']); ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div style="height: 4px;"></div></td>
                </tr>
<?php
                if($_SESSION['unset_afterrefresh_logmebox_wronglogin'] >= 2)
                {
                    unset($_SESSION['msg_logmebox_wronglogin']);
                    unset($_SESSION['unset_afterrefresh_logmebox_wronglogin']);
                }
            }
?>
        <tr>
            <td align="left" colspan="2">
                <a class="link_main" style="font-size: 10px;" href="<?php echo($config_customheader.$boxlogin_forgottenpwd_rewritingF); ?>"><?php give_translation('login_subscribe.link_pwd_forgotten', $echo, $config_showtranslationcode); ?></a>
                <br clear="left"/>
                <a class="link_main" style="font-size: 10px;" href="<?php echo($config_customheader.$boxlogin_subscription_rewritingF); ?>"><?php give_translation('login_subscribe.link_subscription', $echo, $config_showtranslationcode); ?></a>
            </td>
        </tr>
    </table></td>
</tr>
