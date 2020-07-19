<tr>
    <td colspan="2" align="left">
        <table id="collapseConditionQuicksearch" width="100%" cellpadding="0" cellspacing="0"
<?php
            if(empty($_SESSION['expand_collapseConditionQuicksearch']) || $_SESSION['expand_collapseConditionQuicksearch'] == 'false')
            {
                echo('class="block_collapsetitle2"');
            }
            else
            {
                echo('class="block_expandtitle2"');
            }
?>
             width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseConditionQuicksearch', 'img_expand_collapseConditionQuicksearch', 'expand_collapseConditionQuicksearch', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle2','block_expandtitle2', 'collapseConditionQuicksearch');" style="cursor: pointer;">
            <td align="left" style="vertical-align: top;">                    
<?php
                    if(empty($_SESSION['expand_collapseConditionQuicksearch']) || $_SESSION['expand_collapseConditionQuicksearch'] == 'false')
                    {
?>
                        <img id="img_expand_collapseConditionQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                    }
                    else
                    {
?>
                        <img id="img_expand_collapseConditionQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                    }
?>   
            </td>
            <td width="100%">
                &nbsp;<LABEL for="txtConditionQuicksearch" style="cursor: pointer;"><?php give_translation('immo.quicksearch_title_condition', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left"></td>
        </table>
        <input id="expand_collapseConditionQuicksearch" style="display: none;" type="hidden" name="expand_collapseConditionQuicksearch" value="<?php if(empty($_SESSION['expand_collapseConditionQuicksearch']) || $_SESSION['expand_collapseConditionQuicksearch'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
    </td>
</tr>
<tr id="block_expand_collapseConditionQuicksearch"
<?php
    if(empty($_SESSION['expand_collapseConditionQuicksearch']) || $_SESSION['expand_collapseConditionQuicksearch'] == 'false')
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
                #Condition
                $prepared_query = 'SELECT * FROM cdreditor
                                   WHERE code_cdreditor = "cdreditor_condition_object"
                                   ORDER BY L'.$main_id_language.'S';
                //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                $query->execute();
                $p = 0;

                while($data = $query->fetch())
                {
                    $quicksearch_id_condition[$p] = $data['id_cdreditor'];
                    $quicksearch_code_condition = $data['code_cdreditor'];
                    $quicksearch_status_condition = $data['status_cdreditor'];
                    $quicksearch_statusobject_condition[$p] = $data['statusobject_cdreditor'];
                    $quicksearch_nameS_condition[$p] = $data['L'.$main_id_language.'S'];
                    $quicksearch_nameP_condition[$p] = $data['L'.$main_id_language.'P'];
                    $p++;
                }
                $query->closeCursor();
                
                #type object
                if($quicksearch_status_condition == 1)
                {
?>
                    <tr>
                        <td align="left">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
<?php                       
                                    cdreditor('checkbox', $quicksearch_nameS_condition, $quicksearch_code_condition.'Quicksearch', $quicksearch_statusobject_condition, $quicksearch_id_condition, $_SESSION['quicksearch_cdreditor_condition_objectQuicksearch'], false, '', '', '', '', '', '', 'true', '', '', 'true', 'condition_product_immo', '=', 'true', 10, '...', '', 'font_main', 'font-size: 10px;');                                      
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
                    die(header('Condition: '.$config_customheader.'Error/400'));
                }
                else
                {
                    die(header('Condition: '.$config_customheader.'Backoffice/Error/400'));
                }
            }
?>
    </table></td>
</tr>
