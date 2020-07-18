<?php
try
{
    unset($name_block, $border_block, $bordercolor_block, $borderradius_lt_block,
        $borderradius_rt_block, $borderradius_rb_block, $borderradius_lb_block,
        $bgcolor_block, $width_block,$height_block,$padding_block,
        $image_block,$bgcolorhover_block,$font_block);
    
    $prepared_query = 'SELECT * FROM style_block
                       ORDER BY name_block';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    
    while($data = $query->fetch())
    {
        $id_block[$i] = $data['id_block'];
        $name_block[$i] = $data['name_block'];
        
        $border_block[$i] = $data['border_block'];
        $bordercolor_block[$i] = $data['bordercolor_block'];
        $borderradius_lt_block[$i] = $data['borderradius_lt_block'];
        $borderradius_rt_block[$i] = $data['borderradius_rt_block'];
        $borderradius_rb_block[$i] = $data['borderradius_rb_block'];
        $borderradius_lb_block[$i] = $data['borderradius_lb_block'];
        $bgcolor_block[$i] = $data['bgcolor_block'];
        $width_block[$i] = $data['width_block'];
        $height_block[$i] = $data['height_block'];
        $padding_block[$i] = $data['padding_block'];
        $image_block[$i] = $data['image_block'];
        $bgcolorhover_block[$i] = $data['bgcolorhover_block'];
        $font_block[$i] = $data['font_block'];
        $i++;
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT * FROM style_block_set
                       WHERE id_block = :block';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->bindParam('block', $id_element);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $id_blockset = $data['id_block'];
        $name_blockset = $data['name_block'];
        
        $block_main1 = $data['block_main1'];
        $block_main2 = $data['block_main2'];
        $block_main3 = $data['block_main3'];
        $block_main4 = $data['block_main4'];
        $block_main5 = $data['block_main5'];
        
        $block_title1 = $data['block_title1'];
        $block_title2 = $data['block_title2'];
        $block_title3 = $data['block_title3'];
        $block_title4 = $data['block_title4'];
        $block_title5 = $data['block_title5'];
        
        $block_msg1 = $data['block_msg1'];
        $block_msg2 = $data['block_msg2'];
        $block_msg3 = $data['block_msg3'];
        $block_msg4 = $data['block_msg4'];
        $block_msg5 = $data['block_msg5'];
        
        $block_error1 = $data['block_error1'];
        $block_error2 = $data['block_error2'];
        $block_error3 = $data['block_error3'];
        $block_error4 = $data['block_error4'];
        $block_error5 = $data['block_error5'];
        
        $block_listing1 = $data['block_listing1'];
        $block_listing2 = $data['block_listing2'];
        $block_listing3 = $data['block_listing3'];
        $block_listing4 = $data['block_listing4'];
        $block_listing5 = $data['block_listing5'];
        
        $block_info1 = $data['block_info1'];
        $block_info2 = $data['block_info2'];
        $block_info3 = $data['block_info3'];
        $block_info4 = $data['block_info4'];
        $block_info5 = $data['block_info5'];
        
        $block_expandmain1 = $data['block_expandmain1'];
        $block_expandmain2 = $data['block_expandmain2'];
        $block_expandmain3 = $data['block_expandmain3'];
        $block_expandmain4 = $data['block_expandmain4'];
        $block_expandmain5 = $data['block_expandmain5'];
        
        $block_expandtitle1 = $data['block_expandtitle1'];
        $block_expandtitle2 = $data['block_expandtitle2'];
        $block_expandtitle3 = $data['block_expandtitle3'];
        $block_expandtitle4 = $data['block_expandtitle4'];
        $block_expandtitle5 = $data['block_expandtitle5'];
        
        $block_collapsetitle1 = $data['block_collapsetitle1'];
        $block_collapsetitle2 = $data['block_collapsetitle2'];
        $block_collapsetitle3 = $data['block_collapsetitle3'];
        $block_collapsetitle4 = $data['block_collapsetitle4'];
        $block_collapsetitle5 = $data['block_collapsetitle5'];
        
        $block_image1 = $data['block_image1'];
        $block_image2 = $data['block_image2'];
        $block_image3 = $data['block_image3'];
        $block_image4 = $data['block_image4'];
        $block_image5 = $data['block_image5'];
        
        $block_comment1 = $data['block_comment1'];
        $block_comment2 = $data['block_comment2'];
        $block_comment3 = $data['block_comment3'];
        $block_comment4 = $data['block_comment4'];
        $block_comment5 = $data['block_comment5'];
        
        $block_priority1 = $data['block_priority1'];
        $block_priority2 = $data['block_priority2'];
        $block_priority3 = $data['block_priority3'];
        $block_priority4 = $data['block_priority4'];
        $block_priority5 = $data['block_priority5'];
        
        $block_pagingnorm1 = $data['block_pagingnorm1'];
        $block_pagingnorm2 = $data['block_pagingnorm2'];
        $block_pagingnorm3 = $data['block_pagingnorm3'];
        $block_pagingnorm4 = $data['block_pagingnorm4'];
        $block_pagingnorm5 = $data['block_pagingnorm5'];
        
        $block_paginghov1 = $data['block_paginghov1'];
        $block_paginghov2 = $data['block_paginghov2'];
        $block_paginghov3 = $data['block_paginghov3'];
        $block_paginghov4 = $data['block_paginghov4'];
        $block_paginghov5 = $data['block_paginghov5'];
        
        $block_pagingact1 = $data['block_pagingact1'];
        $block_pagingact2 = $data['block_pagingact2'];
        $block_pagingact3 = $data['block_pagingact3'];
        $block_pagingact4 = $data['block_pagingact4'];
        $block_pagingact5 = $data['block_pagingact5'];
    }
    $query->closeCursor();

    $_SESSION['structure_edit_id_element'] = $id_blockset;
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

<td><table width="100%">
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('edit_structure.subtitle_name_element', '', $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <input type="text" name="txtNameBlock" value="<?php echo($name_blockset); ?>"></input>
            </td>
        </tr>
<?php
        if(!empty($_SESSION['msg_structure_edit_main_block_txtNameBlock']))
        {
?>
            <tr>
                <td align="left">
                    <table width="100%" class="block_main1" style="border: 1px solid red;">
                        <tr>
                            <td align="center">
                                <span class="font_info1"><?php echo($_SESSION['msg_structure_edit_main_block_txtNameBlock']); ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
<?php
        }

        include('modules/structure/main/style/main_block/main/block_main.php');
        include('modules/structure/main/style/main_block/title/block_title.php');
        include('modules/structure/main/style/main_block/msg/block_msg.php');
        include('modules/structure/main/style/main_block/error/block_error.php');
        include('modules/structure/main/style/main_block/listing/block_listing.php');
        include('modules/structure/main/style/main_block/info/block_info.php');
        include('modules/structure/main/style/main_block/expand/block_expand.php');
        include('modules/structure/main/style/main_block/image/block_image.php');
        include('modules/structure/main/style/main_block/comment/block_comment.php');
        include('modules/structure/main/style/main_block/priority/block_priority.php');
        include('modules/structure/main/style/main_block/paging/block_paging.php');
?>
        
</table></td>
