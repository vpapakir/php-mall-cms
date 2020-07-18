<?php
try
{
    $prepared_query = 'SELECT * FROM memo
                       WHERE id_memo = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('id', $_SESSION['memo_cboMemo']);
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $content_memo = $data['content_memo'];
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
    <td>
        <table width="100%" class="block_main2">
        <tr>
            <td align="left">
                <span class="font_main">
                    <span style="font-size: 12px; font-family: monospace, 'Courrier', 'Courrier New', 'American Typewriter', 'Fixedsys';">
                <?php if(!empty($content_memo)){ echo(nl2br($content_memo)); }; ?>
                    </span>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
        <tr>
            <td colspan="2"><table width="100%" style="">
                <tr>        
                    <td align="center">
                        <?php
                                    if(!empty($_SESSION['memo_view']) && $_SESSION['memo_view'] == true)
                                    {    
                        ?>
                                        <input type="submit" name="bt_edit_memo" value="<?php give_translation('main.bt_edit', $echo, $config_showtranslationcode); ?>"/>               
                                        <input type="submit" name="bt_delete_memo" value="<?php give_translation('main.bt_delete', $echo, $config_showtranslationcode); ?>"/>
                        <?php
                                    }
                                    else
                                    {
                        ?>
                                        <input type="submit" name="bt_save_memo" value="<?php give_translation('main.bt_save', $echo, $config_showtranslationcode); ?>"/>   
                        <?php
                                    }
                        ?>
                    </td>
                </tr> 
            </table></td>
        </tr>
        </table>
    </td>
</tr>
