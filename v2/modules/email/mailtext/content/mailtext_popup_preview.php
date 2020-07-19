<table width="100%" border="0">
    <tr>
        <td align="right" colspan="2">
           <a class="highslide-move link_main" href="#" onclick="return false" title="<?php give_translation('main.legend_move', $echo, $config_showtranslationcode); ?>"><?php give_translation('main.legend_move', $echo, $config_showtranslationcode); ?></a>
           <a class="highslide-close link_main" href="#" onclick="hs.close(this)" title="<?php give_translation('main.legend_close', $echo, $config_showtranslationcode); ?>"><?php give_translation('main.legend_close', $echo, $config_showtranslationcode); ?></a>
        </td>
    </tr>
    <tr>
        <td align="left">
            <span class="font_subtitle">
               <?php give_translation('mail_edit.subtitle_name_mailtext', '', $config_showtranslationcode) ?>:
            </span>
        </td>
        <td align="left" width="90%">
            <span class="font_main">
               <?php echo($_SESSION['mailtext_txtNameMailtext'.$main_id_language]); ?>
            </span>
        </td>
    </tr>
    <tr>
        <td align="left">
            <span class="font_subtitle">
               <?php give_translation('mail_edit.subtitle_subject_mailtext', '', $config_showtranslationcode) ?>:
            </span>
        </td>
        <td align="left">
            <span class="font_main">
               <?php echo($_SESSION['mailtext_txtSubjectMailtext'.$main_id_language]); ?>
            </span>
        </td>
    </tr>
    <tr>
        <td align="left" colspan="2">
            <table class="block_main2" width="100%" cellpadding="0" cellspacing="1">
    
<?php
    if(!empty($_SESSION['mailtext_areaTopMailtext'.$main_id_language]))
    {
?>
        <tr>
            <td align="left" colspan="2">
                <table width="100%" cellpadding="0" cellspacing="1">
                    <tr>
                        <td align="left">
                            <?php echo($_SESSION['mailtext_areaTopMailtext'.$main_id_language]); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }

    if(!empty($_SESSION['mailtext_txtScriptpathMailtext']))
    {
?>
        <tr>
            <td align="left" colspan="2">
                <table width="100%" cellpadding="0" cellspacing="1">
                    <tr>
                        <td align="left">
                            <?php echo('*** SCRIPT ***'); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }
    
    if(!empty($_SESSION['mailtext_areaBottomMailtext'.$main_id_language]))
    {
?>
        <tr>
            <td align="left" colspan="2">
                <table width="100%" cellpadding="0" cellspacing="1">
                    <tr>
                        <td align="left">
                            <?php echo($_SESSION['mailtext_areaBottomMailtext'.$main_id_language]); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }
    
    if(!empty($_SESSION['mailtext_cboSignatureMailtext']))
    {
?>
        <tr>
            <td align="left" colspan="2">
                <table width="100%" cellpadding="0" cellspacing="1">
                    <tr>
                        <td align="left">
<?php 
                            try
                            {
                                $prepared_query = 'SELECT *
                                                   FROM `email_signature`
                                                   WHERE id_signature = :id';
                                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                                $query = $connectData->prepare($prepared_query);
                                $query->bindParam('id', $_SESSION['mailtext_cboSignatureMailtext']);
                                $query->execute();

                                if(($data = $query->fetch()) != false)
                                {
                                    echo(stripslashes($data['L'.$main_id_language.'S']));
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
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }
?>
            </table>
        </td>
    </tr>           
</table>