<?php
if (isset($_COOKIE["language"])) {
	$main_id_language = $_COOKIE["language"];
	$_SESSION['current_language'] = $_COOKIE["language"];
}
try
{
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
        $dispatcher_forgottenpwd_rewritingF = $data[0];
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
<td align="left" width="50%" style="vertical-align: top;"><table class="block_main2" width="100%">

    <tr>
        <td><table class="block_expandtitle1" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div><?php give_translation('login_subscribe.blocktitle_alreadyregistered', $echo, $config_showtranslationcode); ?></div>
                    </td>
                </tr>
        </table></td>
    </tr>    
    <tr>
        <td><table class="font_main" width="100%" cellpadding="0" cellspacing="0" style="height: 120px;">
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
                <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 1px;"></div></td>
            </tr>
            <tr>
                <td colspan="2"><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td align="left" colspan="2">
    <?php
                        if(!empty($_SESSION['msg_logmebox_wronglogin']))
                        {
    ?>
                            <div class="font_error1"><?php echo($_SESSION['msg_logmebox_wronglogin']); ?></div>
    <?php
                        }
    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td colspan="2" align="left">
                    <span><a class="link_main" style="font-size: 10px;" href="<?php echo($config_customheader.$dispatcher_forgottenpwd_rewritingF); ?>"><?php give_translation('login_subscribe.link_pwd_forgotten', $echo, $config_showtranslationcode); ?></a></span>
                </td>
            </tr>
        </table></td>
    </tr>

</table></td>