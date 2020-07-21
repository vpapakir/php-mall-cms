<?php
try
{
    $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                       INNER JOIN page_translation
                       ON page_translation.id_page = page.id_page
                       WHERE url_page = "subscription"
                       AND family_page_translation = "rewritingF"';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $logsub_rewritingF_subscription = $data[0];
    }
    $query->closeCursor();
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    echo $_SESSION['error400_message'] ;
    /*if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }*/
}
?>
<td align="left" width="50%" style="vertical-align: top;"><table class="block_main2" width="100%">

    <tr>
        <td><table class="block_expandtitle1" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div><?php give_translation('login_subscribe.blocktitle_notalreadyregistered', $echo, $config_showtranslationcode); ?></div>
                    </td>
                </tr>
        </table></td>
    </tr>    
    <tr>
        <td style="background-color: <?php echo($tablebg_box); ?>;"><table class="font_main" width="100%" cellpadding="0" cellspacing="0" style="height: 120px;">
            <tr>
                <td colspan="2" align="center">
                    <a class="link_subtitle" href="<?php echo($config_customheader.$logsub_rewritingF_subscription); ?>"><?php give_translation('login_subscribe.link_clickhere_subscription', $echo, $config_showtranslationcode); ?></a>
                    <br clear="left"/>
                    <span class="font_main"><?php give_translation('login_subscribe.subtitle_subscription', $echo, $config_showtranslationcode); ?></span>
                </td>
            </tr>
        </table></td>
    </tr>

</table></td>
<?php
unset($logsub_rewritingF_subscription);
?>
