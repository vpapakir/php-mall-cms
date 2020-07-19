<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapseProdImage"
<?php
                if(empty($_SESSION['expand_product_image']) || $_SESSION['expand_product_image'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseProdImage', 'img_expand_collapseProdImage', 'expand_product_image', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseProdImage');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_product_image']) || $_SESSION['expand_product_image'] == 'false')
                        {
?>
                            <img id="img_expand_collapseProdImage" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseProdImage" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('edit_product.block_title_image_product', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_product_image" style="display: none;" type="hidden" name="expand_product_image" value="<?php if(empty($_SESSION['expand_product_image']) || $_SESSION['expand_product_image'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseProdImage"
<?php
        if(empty($_SESSION['expand_product_image']) || $_SESSION['expand_product_image'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        >
                <td><table width="100%">
                    <tr>
                        <td class="font_subtitle">
                            <?php give_translation('edit_product.subtitle_image_product', $echo, $config_showtranslationcode); ?>
                        </td>
                        <td>
                            <input type="file" name="upload_product"></input>
                            <br clear="left">
                            <div class="font_error1">
<?php 
                                if(!empty($_SESSION['msg_product_edit_upload']))
                                { 
                                    echo(check_session_input($_SESSION['msg_product_edit_upload'])); 
                                } 
?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="font_subtitle">
                            <?php give_translation('edit_product.subtitle_name_image_product', $echo, $config_showtranslationcode); ?>
                        </td>
                        <td>
                            <input type="text" name="txtProductNameImage"></input>
                            &nbsp;
                            <input type="submit" name="bt_send_image_product" value="<?php give_translation('edit_product.product_content_image.bt_send_image_product', $echo, $config_showtranslationcode); ?>"></input>
                        </td>

<?php
                        try
                        {
                            $prepared_query = 'SELECT * FROM page_image
                                               WHERE id_page = :id
                                               ORDER BY position_image';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->bindParam('id', $_SESSION['product_select_cboProductSelect']);
                            $query->execute();


                            if(($data = $query->fetch()) != false)
                            {
                                $query->execute();
?>
                                </tr>


<?php        
                            while($data = $query->fetch())
                            {
?>
                                <tr>
                                <td colspan="2"><table width="100%" border="0">
                                    <tr>
                                        <td><table width="100%">
                                            <td>
                                                <a class="highslide" href="<?php echo($config_customheader.$data['path_image']); ?>" onclick="return hs.expand(this);"><img src="<?php echo($config_customheader.$data['paththumb_image']); ?>" style="border: 1px solid lightgray;"></img></a>
                                            </td>
                                        </table></td>
                                        <td width="100%" style="vertical-align: top;"><table width="100%">
                                            <tr>
                                                <td class="font_main" width="30%">
                                                    <?php give_translation('edit_product.subtitle_name_image_product', $echo, $config_showtranslationcode); ?>
                                                </td>
                                                <td class="font_main">
                                                    <input style="width: 100%;" type="text" name="txtListNameImage<?php echo($data[0]); ?>" value="<?php echo($data['name_image']); ?>"></input>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font_main">
                                                    <?php give_translation('edit_product.subtitle_alt_image_product', $echo, $config_showtranslationcode); ?>
                                                </td>
                                                <td class="font_main">
                                                    <input style="width: 100%;" type="text" name="txtListAltImage<?php echo($data[0]); ?>" value="<?php echo($data['alt_image']); ?>"></input>
                                                </td>
                                            </tr>
<!--                                            <tr>
                                                <td class="font_main">
                                                    Titre 
                                                </td>
                                                <td class="font_main">
                                                    <input style="width: 100%;" type="text" name="txtListTitleImage<?php //echo($data[0]); ?>" value="<?php //echo($data['title_image']); ?>"></input>
                                                </td>
                                            </tr>-->
                                            <tr>
                                                <td class="font_main">
                                                    <?php give_translation('edit_product.subtitle_position_image_product', $echo, $config_showtranslationcode); ?>
                                                </td>
                                                <td class="font_main">
                                                    <select name="cboListPositionImage<?php echo($data[0]); ?>">
<?php
                                                    for($i = 1; $i <= $total_position_image_saving_product; $i++)
                                                    {
?>
                                                        <option value="<?php echo($i); ?>"
                                                                <?php if(!empty($data['position_image']) && $data['position_image'] == $i){ echo('selected'); }else{ echo(null); } ?>
                                                                ><?php echo($i); ?></option>
<?php
                                                    }
?>
                                                    </select>              
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td align="left">
                                                    <input type="submit" name="bt_save_product" value="<?php give_translation('main.bt_save', $echo, $config_showtranslationcode); ?>"/>
                                                    <input type="submit" name="bt_delete_image_product<?php echo($data[0]); ?>" value="<?php give_translation('main.bt_delete', $echo, $config_showtranslationcode); ?>"></input>
                                                </td>
                                            </tr>
                                        </table></td>
                                    </tr>
                                </table></td>
                                </tr>
<?php                
                        }
                    }
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
                </table></td>
            </tr>
        </table>
    </td>
</tr>