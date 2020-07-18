<tr>
    <td><table class="block_main1" width="100%">

            <td align="center">                
                <select name="cboProductSelect" onchange="OnChange('bt_cboProductSelect');">
                    <option value="new" 
                        <?php if(empty($_SESSION['product_select_cboProductSelect']) || $_SESSION['product_select_cboProductSelect'] == 'new'){ echo('selected="selected"'); }else{ echo(null); } ?>
                            ><?php give_translation('edit_product.dd_newproduct', $echo, $config_showtranslationcode); ?></option>
                    <option value="---" disabled="disabled">-------</option>
                        
<?php
                    try
                    {
                        $prepared_query = 'SELECT * FROM page
                                           INNER JOIN page_translation
                                           ON page_translation.id_page = page.id_page
                                           WHERE family_page_translation = "title"
                                           AND family_page = "product"';
                        if(!empty($config_module_immo) && $config_module_immo == 1)
                        {
                            $prepared_query .= ' AND family_page = "immo_product"';
                        }
                        $prepared_query .= ' ORDER BY page.status_page, url_page DESC, L'.$main_id_language;
                                           
                        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                        $query = $connectData->prepare($prepared_query);
                        $query->execute();
                        
                        while($data = $query->fetch())
                        {
?>
                            <option value="<?php echo($data[0]); ?>" title="<?php echo($data['code_page'].' ('.$data['L'.$main_id_language].')'); ?>" <?php if($data['status_page'] == 9){ echo('style="background-color: lightblue;"'); } ?>
                                 <?php if(!empty($_SESSION['product_select_cboProductSelect']) && $_SESSION['product_select_cboProductSelect'] == $data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>   
                                    ><?php 
                                        if(empty($data['L'.$main_id_language]))
                                        {
                                            echo($data['code_page']); 
                                        }
                                        else
                                        {
                                            echo($data['code_page'].' ('.cut_string($data['L'.$main_id_language], 0, 50, '...').')'); 
                                        }
                                    ?>
                                
                                    </option>
<?php                    
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
                </select>   
                <input type="submit" style="display: none;" hidden="true" id="bt_cboProductSelect" name="bt_cboProductSelect" value="<?php give_translation('edit_product.product_select.bt_cboProductSelect', $echo, $config_showtranslationcode); ?>"></input>              
            </td>

    </table></td>
</tr>


