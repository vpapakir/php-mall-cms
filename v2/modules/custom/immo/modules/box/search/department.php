<tr>
    <td colspan="2" align="left">
        <table id="collapseDepartmentQuicksearch" width="100%" cellpadding="0" cellspacing="0"
<?php
            if(empty($_SESSION['expand_collapseDepartmentQuicksearch']) || $_SESSION['expand_collapseDepartmentQuicksearch'] == 'false')
            {
                echo('class="block_collapsetitle2"');
            }
            else
            {
                echo('class="block_expandtitle2"');
            }
?>
             width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseDepartmentQuicksearch', 'img_expand_collapseDepartmentQuicksearch', 'expand_collapseDepartmentQuicksearch', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle2','block_expandtitle2', 'collapseDepartmentQuicksearch');" style="cursor: pointer;">
            <td align="left" style="vertical-align: top;">                    
<?php
                    if(empty($_SESSION['expand_collapseDepartmentQuicksearch']) || $_SESSION['expand_collapseDepartmentQuicksearch'] == 'false')
                    {
?>
                        <img id="img_expand_collapseDepartmentQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                    }
                    else
                    {
?>
                        <img id="img_expand_collapseDepartmentQuicksearch" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                    }
?>   
            </td>
            <td width="100%">
                &nbsp;<LABEL for="txtDepartmentQuicksearch" style="cursor: pointer;"><?php give_translation('immo.quicksearch_title_department', $echo, $config_showtranslationcode); ?></LABEL>
            </td>
            <td align="left"></td>
        </table>
        <input id="expand_collapseDepartmentQuicksearch" style="display: none;" type="hidden" name="expand_collapseDepartmentQuicksearch" value="<?php if(empty($_SESSION['expand_collapseDepartmentQuicksearch']) || $_SESSION['expand_collapseDepartmentQuicksearch'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
    </td>
</tr>
<tr id="block_expand_collapseDepartmentQuicksearch"
<?php
    if(empty($_SESSION['expand_collapseDepartmentQuicksearch']) || $_SESSION['expand_collapseDepartmentQuicksearch'] == 'false')
    {
        echo('style="display: none;"');
    }
    else
    {
        echo(null);
    }
?>
    ><td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td><div style="height: 4px;"></div></td>
            </tr>
<?php
            try
            {
                #Department
                $prepared_query = 'SELECT * FROM cdrgeo
                                   WHERE code_cdrgeo = "cdrgeo_department_situation"
                                   ORDER BY L'.$main_id_language;
                if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                $query = $connectData->prepare($prepared_query);
                //$query->bindParam('code', 'cdrgeo.type_object');
                $query->execute();
                $p = 0;

                while($data = $query->fetch())
                {
                    $quicksearch_id_department[$p] = $data['id_cdrgeo'];
                    $quicksearch_code_department = $data['code_cdrgeo'];
                    $quicksearch_status_department = $data['status_cdrgeo'];
                    $quicksearch_statusobject_department[$p] = $data['statusobject_cdrgeo'];
                    $quicksearch_name_department[$p] = $data['L'.$main_id_language];
                    $p++;
                }
                $query->closeCursor();
                
                #type object
                if($quicksearch_status_department == 1)
                {
?>
                    <tr>
                        <td align="left">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
<?php                       
                                    #cdrgeo('multi', cut_string($quicksearch_name_department, 0, 20, '...'), $quicksearch_code_department.'Quicksearch', $quicksearch_statusobject_department, $quicksearch_id_department, $_SESSION['quicksearch_cdrgeo_department_situationQuicksearch'], false, '', '', '', '', '', '', '', '', '', '', '', '', 'true', 'department_product_immo', '=');                                      
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
