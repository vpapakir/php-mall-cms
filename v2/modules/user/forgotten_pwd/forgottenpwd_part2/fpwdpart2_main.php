<?php
if(isset($_GET['pwd']))
{
    $forgottenpwd2_code = trim(htmlspecialchars($_GET['pwd'], ENT_QUOTES));
    
    try
    {
        $prepared_query = 'SELECT L'.$main_id_language.' FROM page
                           INNER JOIN page_translation
                           ON page_translation.id_page = page.id_page
                           WHERE url_page = "forgotten_pwd_part2"
                           AND family_page_translation = "rewritingF"';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $forgottenpwd2_rewritingF_page = $data[0];
        }
        $query->closeCursor();
        
        $prepared_query = 'SELECT email_forgottenpwd FROM forgottenpwd_codeconfirm
                           WHERE code_forgottenpwd = :code';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('code', $forgottenpwd2_code);
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $forgottenpwd2_email = $data[0];
        }
        $query->closeCursor();
        
        $_SESSION['forgottenpwd2_email'] = $forgottenpwd2_email;
        
        $prepared_query = 'DELETE FROM forgottenpwd_codeconfirm
                           WHERE code_forgottenpwd = :code';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('code', $forgottenpwd2_code);
        $query->execute();
        $query->closeCursor();
        
        reallocate_table_id('id_forgottenpwd', 'forgottenpwd_codeconfirm');
        
        header('Location: '.$config_customheader.$forgottenpwd2_rewritingF_page);
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
}
#bt
include('modules/user/forgotten_pwd/forgottenpwd_part2/bt/bt_backto_home2.php');
include('modules/user/forgotten_pwd/forgottenpwd_part2/bt/bt_save_pwd.php');
?>
<form method="post">
    <table width="100%">
        <tr>
            <td align="left"><table class="block_main2" width="100%">
                    <tr>
                        <td align="left">
                            <span class="font_subtitle">
                                <?php give_translation('forgotten_pwd_part2.subtitle_newpwd', $echo, $config_showtranslationcode); ?>
                            </span>
                        </td>
                        <td align="left" width="<?php echo($right_column_width); ?>">
                            <input type="password" name="txtNewPwdForgottenpwd2" value="<?php if(!empty($_SESSION['forgottenpwd2_txtNewPwdForgottenpwd2'])){ echo($_SESSION['forgottenpwd2_txtNewPwdForgottenpwd2']); } ?>"/>
<?php
                            if(!empty($_SESSION['msg_forgottenpwd2_txtNewPwdForgottenpwd2']))
                            {
?>
                                <br clear="left"/>
                                <div class="font_error1"><?php echo($_SESSION['msg_forgottenpwd2_txtNewPwdForgottenpwd2']); ?></div>
<?php
                            }
?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <span class="font_subtitle">
                                <?php give_translation('forgotten_pwd_part2.subtitle_newpwdconfirm', $echo, $config_showtranslationcode); ?>
                            </span>
                        </td>
                        <td align="left" width="<?php echo($right_column_width); ?>">
                            <input type="password" name="txtNewPwdConfirmForgottenpwd2"/>
<?php
                            if(!empty($_SESSION['msg_forgottenpwd2_txtNewPwdConfirmForgottenpwd2']))
                            {
?>
                                <br clear="left"/>
                                <div class="font_error1"><?php echo($_SESSION['msg_forgottenpwd2_txtNewPwdConfirmForgottenpwd2']); ?></div>
<?php
                            }
?>
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
                                    <input type="submit" name="bt_backto_home2" value="<?php give_translation('main.bt_home', '', $config_showtranslationcode); ?>"/>
                                    <input type="submit" name="bt_save_pwd" value="<?php give_translation('main.bt_save', '', $config_showtranslationcode); ?>"/>
                                </td>
                            </tr> 
                        </table></td>
                    </tr>
            </table></td>
        </tr>
    </table>
</form>
