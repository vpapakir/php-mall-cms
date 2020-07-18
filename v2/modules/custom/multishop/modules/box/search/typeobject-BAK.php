<tr>
    <td colspan="2" align="left">
        <table id="collapseTypeobjectQuicksearch" width="100%" cellpadding="0" cellspacing="0"
<?php
            if(empty($_SESSION['expand_collapseTypeobjectQuicksearch']) || $_SESSION['expand_collapseTypeobjectQuicksearch'] == 'false')
            {
                echo('class="block_collapsetitle2"');
            }
            else
            {
                echo('class="block_expandtitle2"');
            }
?>
             width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseTypeobjectQuicksearch', 'img_expand_collapseTypeobjectQuicksearch', 'expand_collapseTypeobjectQuicksearch', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle2','block_expandtitle2', 'collapseTypeobjectQuicksearch');" style="cursor: pointer;">
            <td align="left" style="vertical-align: top;">                    
<?php
                    if(empty($_SESSION['expand_collapseTypeobjectQuicksearch']) || $_SESSION['expand_collapseTypeobjectQuicksearch'] == 'false')
                    {
?>
                        <img id="img_expand_collapseTypeobjectQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                    }
                    else
                    {
?>
                        <img id="img_expand_collapseTypeobjectQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                    }
?>   
            </td>
            <td width="100%">
                &nbsp;<LABEL for="txtTypeobjectQuicksearch" style="cursor: pointer;"><?php give_translation('immo.quicksearch_title_typeobject', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left"></td>
        </table>
        <input id="expand_collapseTypeobjectQuicksearch" style="display: none;" type="hidden" name="expand_collapseTypeobjectQuicksearch" value="<?php if(empty($_SESSION['expand_collapseTypeobjectQuicksearch']) || $_SESSION['expand_collapseTypeobjectQuicksearch'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
    </td>
</tr>
<tr id="block_expand_collapseTypeobjectQuicksearch"
<?php
    if(empty($_SESSION['expand_collapseTypeobjectQuicksearch']) || $_SESSION['expand_collapseTypeobjectQuicksearch'] == 'false')
    {
        echo('style="display: none;"');
    }
    else
    {
        echo(null);
    }
?>
    ><td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
<?php
            try
            {
                #Type Object
                $prepared_query = 'SELECT * FROM cdreditor
                                   WHERE code_cdreditor = "cdreditor_type_object"
                                   ORDER BY L'.$main_id_language.'S';
                //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                //$query->bindParam('code', 'cdreditor.type_object');
                $query->execute();
                $p = 0;

                while($data = $query->fetch())
                {
                    $quicksearch_id_typeobject[$p] = $data['id_cdreditor'];
                    $quicksearch_code_typeobject = $data['code_cdreditor'];
                    $quicksearch_status_typeobject = $data['status_cdreditor'];
                    $quicksearch_statusobject_typeobject[$p] = $data['statusobject_cdreditor'];
                    $quicksearch_nameS_typeobject[$p] = $data['L'.$main_id_language.'S'];
                    $p++;
                }
                $query->closeCursor();
                
                #type object
                if($quicksearch_status_typeobject == 1)
                {
?>
                    <tr>
                        <td align="left">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
<?php                       
                                    cdreditor('checkbox', $quicksearch_nameS_typeobject, $quicksearch_code_typeobject.'Quicksearch', $quicksearch_statusobject_typeobject, $quicksearch_id_typeobject, $_SESSION['quicksearch_cdreditor_type_objectQuicksearch'], false, '', '', '', '', '', '', 'true', '', '', 'true', 'type_product_immo', '=', 'true', 10, '...', '', 'font_main', 'font-size: 10px;');                                      
?>
                                    </td>
                                </tr>
                            </table>
                        </td>    
                    </tr>
<?php
                }
            }
            catch (Exception $e)
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
    </table></td>
</tr>
