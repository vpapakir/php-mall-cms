<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0">
    <tr>
        <td align="left">
            <table id="collapsePageImage"
<?php
                if(empty($_SESSION['expand_page_image']) || $_SESSION['expand_page_image'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapsePageImage', 'img_expand_collapsePageImage', 'expand_page_image', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapsePageImage');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_page_image']) || $_SESSION['expand_page_image'] == 'false')
                        {
?>
                            <img id="img_expand_collapsePageImage" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapsePageImage" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="center">
                    <span>
                        <?php give_translation('page_edit.block_title_image', '', $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_page_image" style="display: none;" type="hidden" name="expand_page_image" value="<?php if(empty($_SESSION['expand_page_image']) || $_SESSION['expand_page_image'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapsePageImage"
<?php
        if(empty($_SESSION['expand_page_image']) || $_SESSION['expand_page_image'] == 'false')
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
                            <?php give_translation('page_edit.subtitle_addimage_image', '', $config_showtranslationcode); ?>
                        </td>
                        <td>
                            <input type="file" name="upload_page"></input>
                            <br clear="left">
                            <div class="font_error1">
<?php 
                                if(!empty($_SESSION['msg_page_edit_upload']))
                                { 
                                    echo(check_session_input($_SESSION['msg_page_edit_upload'])); 
                                } 
?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="font_subtitle">
                            <?php give_translation('page_edit.subtitle_name_image', '', $config_showtranslationcode); ?>
                        </td>
                        <td>
                            <input type="text" name="txtPageNameImage"></input>
                            &nbsp;
                            <input type="submit" name="bt_send_image_page" value="<?php give_translation('page_edit.main_bt_sendimage', '', $config_showtranslationcode); ?>"></input>
                        </td>

<?php
                        try
                        {
                            $prepared_query = 'SELECT * FROM page_image
                                               WHERE id_page = :id
                                               ORDER BY position_image';
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->bindParam('id', $_SESSION['page_select_cboPageSelect']);
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
                                                    <?php give_translation('page_edit.image_name_image', '', $config_showtranslationcode); ?>
                                                </td>
                                                <td class="font_main">
                                                    <input style="width: 100%;" type="text" name="txtListNameImage<?php echo($data[0]); ?>" value="<?php echo($data['name_image']); ?>"></input>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font_main">
                                                    <?php give_translation('page_edit.image_alt_image', '', $config_showtranslationcode); ?> 
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
                                                    <?php give_translation('page_edit.image_position_image', '', $config_showtranslationcode); ?> 
                                                </td>
                                                <td class="font_main">
                                                    <select name="cboListPositionImage<?php echo($data[0]); ?>">
<?php
                                                    for($i = 1; $i <= $total_position_image_saving_page; $i++)
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
                                                    <input type="submit" name="bt_save_page" value="<?php give_translation('page_edit.main_bt_save', '', $config_showtranslationcode); ?>"/>
                                                    <input type="submit" name="bt_delete_image_page<?php echo($data[0]); ?>" value="<?php give_translation('page_edit.main_bt_deleteimage', '', $config_showtranslationcode); ?>"></input>
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
                        die(header('Location: '.$config_customheader.$_SESSION['index'].'Backoffice/Error/400'));
                    } 
                }
?>
                <tr>
                    <td colspan="2" style="border-top: 1px solid lightgrey;"><table width="100%" style="margin-top: 4px;">
                        <tr>        
                            <td></td> 
                            <td></td>
                            <td width="<?php echo($right_column_width); ?>">
                                <input type="submit" name="bt_save_page" value="<?php give_translation('page_edit.main_bt_save', '', $config_showtranslationcode); ?>"/>
                            </td>
                        </tr> 
                    </table></td>
                </tr>
                </table></td>
            </tr>
        </table>
    </td>
</tr>