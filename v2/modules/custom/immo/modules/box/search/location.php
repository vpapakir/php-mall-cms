<tr>
    <td colspan="2" align="left">
        <table id="collapseLocationQuicksearch" width="100%" cellpadding="0" cellspacing="0"
<?php
            if(empty($_SESSION['expand_collapseLocationQuicksearch']) || $_SESSION['expand_collapseLocationQuicksearch'] == 'false')
            {
                echo('class="block_collapsetitle2"');
            }
            else
            {
                echo('class="block_expandtitle2"');
            }
?>
             width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseLocationQuicksearch', 'img_expand_collapseLocationQuicksearch', 'expand_collapseLocationQuicksearch', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle2','block_expandtitle2', 'collapseLocationQuicksearch');" style="cursor: pointer;">
            <td align="left" style="vertical-align: top;">                    
<?php
                    if(empty($_SESSION['expand_collapseLocationQuicksearch']) || $_SESSION['expand_collapseLocationQuicksearch'] == 'false')
                    {
?>
                        <img id="img_expand_collapseLocationQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                    }
                    else
                    {
?>
                        <img id="img_expand_collapseLocationQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                    }
?>   
            </td>
            <td width="100%">
                &nbsp;<LABEL for="txtLocationQuicksearch" style="cursor: pointer;"><?php give_translation('immo.quicksearch_title_location', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left"></td>
        </table>
        <input id="expand_collapseLocationQuicksearch" style="display: none;" type="hidden" name="expand_collapseLocationQuicksearch" value="<?php if(empty($_SESSION['expand_collapseLocationQuicksearch']) || $_SESSION['expand_collapseLocationQuicksearch'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
    </td>
</tr>
<tr id="block_expand_collapseLocationQuicksearch"
<?php
    if(empty($_SESSION['expand_collapseLocationQuicksearch']) || $_SESSION['expand_collapseLocationQuicksearch'] == 'false')
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
                #Location
                $prepared_query = 'SELECT * FROM cdreditor
                                   WHERE code_cdreditor = "cdreditor_location_situation"
                                   ORDER BY L'.$main_id_language.'S';
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();
                $p = 0;

                while($data = $query->fetch())
                {
                    $quicksearch_id_location[$p] = $data['id_cdreditor'];
                    $quicksearch_code_location = $data['code_cdreditor'];
                    $quicksearch_status_location = $data['status_cdreditor'];
                    $quicksearch_statusobject_location[$p] = $data['statusobject_cdreditor'];
                    $quicksearch_nameS_location[$p] = $data['L'.$main_id_language.'S'];
                    $quicksearch_nameP_location[$p] = $data['L'.$main_id_language.'P'];
                    $p++;
                }
                $query->closeCursor();
                
                #type object
                if($quicksearch_status_location == 1)
                {
?>
                    <tr>
                        <td align="left">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
<?php                       
                                    #cdreditor('checkbox', $quicksearch_nameS_location, $quicksearch_code_location.'Quicksearch', $quicksearch_statusobject_location, $quicksearch_id_location, $_SESSION['quicksearch_cdreditor_location_situationQuicksearch'], false, '', '', '', '', '', '', 'true', '', '', 'true', 'location_product_immo', '=', 'true', 10, '...', '', 'font_main', 'font-size: 10px;');                                      
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
