<?php
if(isset($_POST['bt_save_main_block']))
{
    unset($_SESSION['msg_structure_edit_main_block_txtNameBlock']);
    
    $block_main1 = htmlspecialchars($_POST['cboSelectmain1Block'], ENT_QUOTES);
    $block_main2 = htmlspecialchars($_POST['cboSelectmain2Block'], ENT_QUOTES);
    $block_main3 = htmlspecialchars($_POST['cboSelectmain3Block'], ENT_QUOTES);
    $block_main4 = htmlspecialchars($_POST['cboSelectmain4Block'], ENT_QUOTES);
    $block_main5 = htmlspecialchars($_POST['cboSelectmain5Block'], ENT_QUOTES);

    $block_title1 = htmlspecialchars($_POST['cboSelecttitle1Block'], ENT_QUOTES);
    $block_title2 = htmlspecialchars($_POST['cboSelecttitle2Block'], ENT_QUOTES);
    $block_title3 = htmlspecialchars($_POST['cboSelecttitle3Block'], ENT_QUOTES);
    $block_title4 = htmlspecialchars($_POST['cboSelecttitle4Block'], ENT_QUOTES);
    $block_title5 = htmlspecialchars($_POST['cboSelecttitle5Block'], ENT_QUOTES);

    $block_msg1 = htmlspecialchars($_POST['cboSelectmsg1Block'], ENT_QUOTES);
    $block_msg2 = htmlspecialchars($_POST['cboSelectmsg2Block'], ENT_QUOTES);
    $block_msg3 = htmlspecialchars($_POST['cboSelectmsg3Block'], ENT_QUOTES);
    $block_msg4 = htmlspecialchars($_POST['cboSelectmsg4Block'], ENT_QUOTES);
    $block_msg5 = htmlspecialchars($_POST['cboSelectmsg5Block'], ENT_QUOTES);

    $block_error1 = htmlspecialchars($_POST['cboSelecterror1Block'], ENT_QUOTES);
    $block_error2 = htmlspecialchars($_POST['cboSelecterror2Block'], ENT_QUOTES);
    $block_error3 = htmlspecialchars($_POST['cboSelecterror3Block'], ENT_QUOTES);
    $block_error4 = htmlspecialchars($_POST['cboSelecterror4Block'], ENT_QUOTES);
    $block_error5 = htmlspecialchars($_POST['cboSelecterror5Block'], ENT_QUOTES);

    $block_listing1 = htmlspecialchars($_POST['cboSelectlisting1Block'], ENT_QUOTES);
    $block_listing2 = htmlspecialchars($_POST['cboSelectlisting2Block'], ENT_QUOTES);
    $block_listing3 = htmlspecialchars($_POST['cboSelectlisting3Block'], ENT_QUOTES);
    $block_listing4 = htmlspecialchars($_POST['cboSelectlisting4Block'], ENT_QUOTES);
    $block_listing5 = htmlspecialchars($_POST['cboSelectlisting5Block'], ENT_QUOTES);

    $block_info1 = htmlspecialchars($_POST['cboSelectinfo1Block'], ENT_QUOTES);
    $block_info2 = htmlspecialchars($_POST['cboSelectinfo2Block'], ENT_QUOTES);
    $block_info3 = htmlspecialchars($_POST['cboSelectinfo3Block'], ENT_QUOTES);
    $block_info4 = htmlspecialchars($_POST['cboSelectinfo4Block'], ENT_QUOTES);
    $block_info5 = htmlspecialchars($_POST['cboSelectinfo5Block'], ENT_QUOTES);

    $block_expandmain1 = htmlspecialchars($_POST['cboSelectexpandmain1Block'], ENT_QUOTES);
    $block_expandmain2 = htmlspecialchars($_POST['cboSelectexpandmain2Block'], ENT_QUOTES);
    $block_expandmain3 = htmlspecialchars($_POST['cboSelectexpandmain3Block'], ENT_QUOTES);
    $block_expandmain4 = htmlspecialchars($_POST['cboSelectexpandmain4Block'], ENT_QUOTES);
    $block_expandmain5 = htmlspecialchars($_POST['cboSelectexpandmain5Block'], ENT_QUOTES);

    $block_expandtitle1 = htmlspecialchars($_POST['cboSelectexpandtitle1Block'], ENT_QUOTES);
    $block_expandtitle2 = htmlspecialchars($_POST['cboSelectexpandtitle2Block'], ENT_QUOTES);
    $block_expandtitle3 = htmlspecialchars($_POST['cboSelectexpandtitle3Block'], ENT_QUOTES);
    $block_expandtitle4 = htmlspecialchars($_POST['cboSelectexpandtitle4Block'], ENT_QUOTES);
    $block_expandtitle5 = htmlspecialchars($_POST['cboSelectexpandtitle5Block'], ENT_QUOTES);
    
    $block_collapsetitle1 = htmlspecialchars($_POST['cboSelectcollapsetitle1Block'], ENT_QUOTES);
    $block_collapsetitle2 = htmlspecialchars($_POST['cboSelectcollapsetitle2Block'], ENT_QUOTES);
    $block_collapsetitle3 = htmlspecialchars($_POST['cboSelectcollapsetitle3Block'], ENT_QUOTES);
    $block_collapsetitle4 = htmlspecialchars($_POST['cboSelectcollapsetitle4Block'], ENT_QUOTES);
    $block_collapsetitle5 = htmlspecialchars($_POST['cboSelectcollapsetitle5Block'], ENT_QUOTES);

    $block_image1 = htmlspecialchars($_POST['cboSelectimage1Block'], ENT_QUOTES);
    $block_image2 = htmlspecialchars($_POST['cboSelectimage2Block'], ENT_QUOTES);
    $block_image3 = htmlspecialchars($_POST['cboSelectimage3Block'], ENT_QUOTES);
    $block_image4 = htmlspecialchars($_POST['cboSelectimage4Block'], ENT_QUOTES);
    $block_image5 = htmlspecialchars($_POST['cboSelectimage5Block'], ENT_QUOTES);

    $block_comment1 = htmlspecialchars($_POST['cboSelectcomment1Block'], ENT_QUOTES);
    $block_comment2 = htmlspecialchars($_POST['cboSelectcomment2Block'], ENT_QUOTES);
    $block_comment3 = htmlspecialchars($_POST['cboSelectcomment3Block'], ENT_QUOTES);
    $block_comment4 = htmlspecialchars($_POST['cboSelectcomment4Block'], ENT_QUOTES);
    $block_comment5 = htmlspecialchars($_POST['cboSelectcomment5Block'], ENT_QUOTES);

    $block_priority1 = htmlspecialchars($_POST['cboSelectpriority1Block'], ENT_QUOTES);
    $block_priority2 = htmlspecialchars($_POST['cboSelectpriority2Block'], ENT_QUOTES);
    $block_priority3 = htmlspecialchars($_POST['cboSelectpriority3Block'], ENT_QUOTES);
    $block_priority4 = htmlspecialchars($_POST['cboSelectpriority4Block'], ENT_QUOTES);
    $block_priority5 = htmlspecialchars($_POST['cboSelectpriority5Block'], ENT_QUOTES);
    
    $block_pagingnorm1 = htmlspecialchars($_POST['cboSelectpagingnorm1Block'], ENT_QUOTES);
    $block_pagingnorm2 = htmlspecialchars($_POST['cboSelectpagingnorm2Block'], ENT_QUOTES);
    $block_pagingnorm3 = htmlspecialchars($_POST['cboSelectpagingnorm3Block'], ENT_QUOTES);
    $block_pagingnorm4 = htmlspecialchars($_POST['cboSelectpagingnorm4Block'], ENT_QUOTES);
    $block_pagingnorm5 = htmlspecialchars($_POST['cboSelectpagingnorm5Block'], ENT_QUOTES);

    $block_paginghov1 = htmlspecialchars($_POST['cboSelectpaginghov1Block'], ENT_QUOTES);
    $block_paginghov2 = htmlspecialchars($_POST['cboSelectpaginghov2Block'], ENT_QUOTES);
    $block_paginghov3 = htmlspecialchars($_POST['cboSelectpaginghov3Block'], ENT_QUOTES);
    $block_paginghov4 = htmlspecialchars($_POST['cboSelectpaginghov4Block'], ENT_QUOTES);
    $block_paginghov5 = htmlspecialchars($_POST['cboSelectpaginghov5Block'], ENT_QUOTES);

    $block_pagingact1 = htmlspecialchars($_POST['cboSelectpagingact1Block'], ENT_QUOTES);
    $block_pagingact2 = htmlspecialchars($_POST['cboSelectpagingact2Block'], ENT_QUOTES);
    $block_pagingact3 = htmlspecialchars($_POST['cboSelectpagingact3Block'], ENT_QUOTES);
    $block_pagingact4 = htmlspecialchars($_POST['cboSelectpagingact4Block'], ENT_QUOTES);
    $block_pagingact5 = htmlspecialchars($_POST['cboSelectpagingact5Block'], ENT_QUOTES);
    
    $selected_block = $_SESSION['structure_edit_id_element'];
    $selected_template = $_SESSION['structure_template_cboTemplate'];

    $name_block = trim(htmlspecialchars($_POST['txtNameBlock'], ENT_QUOTES));
    
    $BoK_name_block = true;  

    if(empty($name_block))
    {
       $_SESSION['msg_structure_edit_main_block_txtNameBlock'] = 'Veuillez indiquer un nom pour cet élément';
       $BoK_name_block = false; 
    }
    
    if($BoK_name_block === true)
    {     
        try
        {
            $prepared_query = 'UPDATE style_block_set 
                               SET id_template = :template,
                                   name_block = :name,
                                   block_main1= :main1,
                                   block_main2= :main2,
                                   block_main3= :main3,
                                   block_main4= :main4,
                                   block_main5= :main5,
                                   block_title1= :title1,
                                   block_title2= :title2,
                                   block_title3= :title3,
                                   block_title4= :title4,
                                   block_title5= :title5,
                                   block_msg1= :msg1,
                                   block_msg2= :msg2,
                                   block_msg3= :msg3,
                                   block_msg4= :msg4,
                                   block_msg5= :msg5,
                                   block_error1= :error1,
                                   block_error2= :error2,
                                   block_error3= :error3,
                                   block_error4= :error4,
                                   block_error5= :error5,
                                   block_listing1= :listing1,
                                   block_listing2= :listing2,
                                   block_listing3= :listing3,
                                   block_listing4= :listing4,
                                   block_listing5= :listing5,
                                   block_info1= :info1,
                                   block_info2= :info2,
                                   block_info3= :info3,
                                   block_info4= :info4,
                                   block_info5= :info5,
                                   block_expandmain1= :expandmain1,
                                   block_expandmain2= :expandmain2,
                                   block_expandmain3= :expandmain3,
                                   block_expandmain4= :expandmain4,
                                   block_expandmain5= :expandmain5,
                                   block_expandtitle1= :expandtitle1,
                                   block_expandtitle2= :expandtitle2,
                                   block_expandtitle3= :expandtitle3,
                                   block_expandtitle4= :expandtitle4,
                                   block_expandtitle5= :expandtitle5,
                                   block_collapsetitle1= :collapsetitle1,
                                   block_collapsetitle2= :collapsetitle2,
                                   block_collapsetitle3= :collapsetitle3,
                                   block_collapsetitle4= :collapsetitle4,
                                   block_collapsetitle5= :collapsetitle5,
                                   block_image1= :image1,
                                   block_image2= :image2,
                                   block_image3= :image3,
                                   block_image4= :image4,
                                   block_image5= :image5,
                                   block_comment1= :comment1,
                                   block_comment2= :comment2,
                                   block_comment3= :comment3,
                                   block_comment4= :comment4,
                                   block_comment5= :comment5,
                                   block_priority1= :priority1,
                                   block_priority2= :priority2,
                                   block_priority3= :priority3,
                                   block_priority4= :priority4,
                                   block_priority5= :priority5,
                                   block_pagingnorm1 = :pagingnorm1,
                                   block_pagingnorm2 = :pagingnorm2,
                                   block_pagingnorm3 = :pagingnorm3,
                                   block_pagingnorm4 = :pagingnorm4,
                                   block_pagingnorm5 = :pagingnorm5,
                                   block_paginghov1 = :paginghov1,
                                   block_paginghov2 = :paginghov2,
                                   block_paginghov3 = :paginghov3,
                                   block_paginghov4 = :paginghov4,
                                   block_paginghov5 = :paginghov5,
                                   block_pagingact1 = :pagingact1,
                                   block_pagingact2 = :pagingact2,
                                   block_pagingact3 = :pagingact3,
                                   block_pagingact4 = :pagingact4,
                                   block_pagingact5 = :pagingact5
                               WHERE id_block = :block';
            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
            $query = $connectData->prepare($prepared_query);
            $query->execute(array(
                                    'template' => $selected_template,
                                    'name' => $name_block,
                                    'main1' => $block_main1,
                                    'main2' => $block_main2,
                                    'main3' => $block_main3,
                                    'main4' => $block_main4,
                                    'main5' => $block_main5,
                                    'title1' => $block_title1,
                                    'title2' => $block_title2,
                                    'title3' => $block_title3,
                                    'title4' => $block_title4,
                                    'title5' => $block_title5,
                                    'msg1' => $block_msg1,
                                    'msg2' => $block_msg2,
                                    'msg3' => $block_msg3,
                                    'msg4' => $block_msg4,
                                    'msg5' => $block_msg5,
                                    'error1' => $block_error1,
                                    'error2' => $block_error2,
                                    'error3' => $block_error3,
                                    'error4' => $block_error4,
                                    'error5' => $block_error5,
                                    'listing1' => $block_listing1,
                                    'listing2' => $block_listing2,
                                    'listing3' => $block_listing3,
                                    'listing4' => $block_listing4,
                                    'listing5' => $block_listing5,
                                    'info1' => $block_info1,
                                    'info2' => $block_info2,
                                    'info3' => $block_info3,
                                    'info4' => $block_info4,
                                    'info5' => $block_info5,
                                    'expandmain1' => $block_expandmain1,
                                    'expandmain2' => $block_expandmain2,
                                    'expandmain3' => $block_expandmain3,
                                    'expandmain4' => $block_expandmain4,
                                    'expandmain5' => $block_expandmain5,
                                    'expandtitle1' => $block_expandtitle1,
                                    'expandtitle2' => $block_expandtitle2,
                                    'expandtitle3' => $block_expandtitle3,
                                    'expandtitle4' => $block_expandtitle4,
                                    'expandtitle5' => $block_expandtitle5,
                                    'collapsetitle1' => $block_collapsetitle1,
                                    'collapsetitle2' => $block_collapsetitle2,
                                    'collapsetitle3' => $block_collapsetitle3,
                                    'collapsetitle4' => $block_collapsetitle4,
                                    'collapsetitle5' => $block_collapsetitle5,
                                    'image1' => $block_image1,
                                    'image2' => $block_image2,
                                    'image3' => $block_image3,
                                    'image4' => $block_image4,
                                    'image5' => $block_image5,
                                    'comment1' => $block_comment1,
                                    'comment2' => $block_comment2,
                                    'comment3' => $block_comment3,
                                    'comment4' => $block_comment4,
                                    'comment5' => $block_comment5,
                                    'priority1' => $block_priority1,
                                    'priority2' => $block_priority2,
                                    'priority3' => $block_priority3,
                                    'priority4' => $block_priority4,
                                    'priority5' => $block_priority5,
                                    'pagingnorm1' => $block_pagingnorm1,
                                    'pagingnorm2' => $block_pagingnorm2,
                                    'pagingnorm3' => $block_pagingnorm3,
                                    'pagingnorm4' => $block_pagingnorm4,
                                    'pagingnorm5' => $block_pagingnorm5,
                                    'paginghov1' => $block_paginghov1,
                                    'paginghov2' => $block_paginghov2,
                                    'paginghov3' => $block_paginghov3,
                                    'paginghov4' => $block_paginghov4,
                                    'paginghov5' => $block_paginghov5,
                                    'pagingact1' => $block_pagingact1,
                                    'pagingact2' => $block_pagingact2,
                                    'pagingact3' => $block_pagingact3,
                                    'pagingact4' => $block_pagingact4,
                                    'pagingact5' => $block_pagingact5,
                                    'block' => $selected_block
                                  ));
            $query->closeCursor();
            
            $array_block_id = array(
                                    0 => $block_main1,
                                    1 => $block_main2,
                                    2 => $block_main3,
                                    3 => $block_main4,
                                    4 => $block_main5,
                                    5 => $block_title1,
                                    6 => $block_title2,
                                    7 => $block_title3,
                                    8 => $block_title4,
                                    9 => $block_title5,
                                    10 => $block_msg1,
                                    11 => $block_msg2,
                                    12 => $block_msg3,
                                    13 => $block_msg4,
                                    14 => $block_msg5,
                                    15 => $block_error1,
                                    16 => $block_error2,
                                    17 => $block_error3,
                                    18 => $block_error4,
                                    19 => $block_error5,
                                    20 => $block_listing1,
                                    21 => $block_listing2,
                                    22 => $block_listing3,
                                    23 => $block_listing4,
                                    24 => $block_listing5,
                                    25 => $block_info1,
                                    26 => $block_info2,
                                    27 => $block_info3,
                                    28 => $block_info4,
                                    29 => $block_info5,
                                    30 => $block_expandmain1,
                                    31 => $block_expandmain2,
                                    32 => $block_expandmain3,
                                    33 => $block_expandmain4,
                                    34 => $block_expandmain5,
                                    35 => $block_expandtitle1,
                                    36 => $block_expandtitle2,
                                    37 => $block_expandtitle3,
                                    38 => $block_expandtitle4,
                                    39 => $block_expandtitle5,
                                    40 => $block_collapsetitle1,
                                    41 => $block_collapsetitle2,
                                    42 => $block_collapsetitle3,
                                    43 => $block_collapsetitle4,
                                    44 => $block_collapsetitle5,
                                    45 => $block_image1,
                                    46 => $block_image2,
                                    47 => $block_image3,
                                    48 => $block_image4,
                                    49 => $block_image5,
                                    50 => $block_comment1,
                                    51 => $block_comment2,
                                    52 => $block_comment3,
                                    53 => $block_comment4,
                                    54 => $block_comment5,
                                    55 => $block_priority1,
                                    56 => $block_priority2,
                                    57 => $block_priority3,
                                    58 => $block_priority4,
                                    59 => $block_priority5,
                                    60 => $block_pagingnorm1,
                                    61 => $block_pagingnorm2,
                                    62 => $block_pagingnorm3,
                                    63 => $block_pagingnorm4,
                                    64 => $block_pagingnorm5,
                                    65 => $block_paginghov1,
                                    66 => $block_paginghov2,
                                    67 => $block_paginghov3,
                                    68 => $block_paginghov4,
                                    69 => $block_paginghov5,
                                    70 => $block_pagingact1,
                                    71 => $block_pagingact2,
                                    72 => $block_pagingact3,
                                    73 => $block_pagingact4,
                                    74 => $block_pagingact5
                                    );
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
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
