<?php
try
{
    $prepared_query = 'SELECT * 
                       FROM style_font AS font
                       INNER JOIN structure_template AS temp
                       ON font.id_font = temp.id_font
                       WHERE status_template = 1';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $title_font = $data['title_font'];
        $intro_font = $data['intro_font'];
        $desc_font = $data['desc_font'];
        $subtitle_font = $data['subtitle_font'];
        $main_font = $data['main_font'];
        $comment_font = $data['comment_font'];
        $block1_font = $data['boxstyle1_font'];
        $block2_font = $data['boxstyle2_font'];
        $block3_font = $data['boxstyle3_font'];
        $error1_font = $data['error1_font'];
        $error2_font = $data['error2_font'];
        $error3_font = $data['error3_font'];
        $info1_font = $data['info1_font'];
        $info2_font = $data['info2_font'];
        $info3_font = $data['info3_font'];
        $info4_font = $data['info4_font'];
        $info5_font = $data['info5_font'];
    }
    $query->closeCursor();
    
    $title_font = split_string($title_font, '$');
    $intro_font = split_string($intro_font, '$');
    $desc_font = split_string($desc_font, '$');
    $subtitle_font = split_string($subtitle_font, '$');
    $main_font = split_string($main_font, '$');
    $comment_font = split_string($comment_font, '$');
    $block1_font = split_string($block1_font, '$');
    $block2_font = split_string($block2_font, '$');
    $block3_font = split_string($block3_font, '$');
    $error1_font = split_string($error1_font, '$');
    $error2_font = split_string($error2_font, '$');
    $error3_font = split_string($error3_font, '$');
    $info1_font = split_string($info1_font, '$');
    $info2_font = split_string($info2_font, '$');
    $info3_font = split_string($info3_font, '$');
    $info4_font = split_string($info4_font, '$');
    $info5_font = split_string($info5_font, '$');
    
    if(empty($title_font[0]) ? $title_font[0] = 10 : $title_font[0] = $title_font[0]);
    if(empty($intro_font[0]) ? $intro_font[0] = 10 : $intro_font[0] = $intro_font[0]);
    if(empty($desc_font[0]) ? $desc_font[0] = 10 : $desc_font[0] = $desc_font[0]);
    if(empty($subtitle_font[0]) ? $subtitle_font[0] = 10 : $subtitle_font[0] = $subtitle_font[0]);
    if(empty($main_font[0]) ? $main_font[0] = 10 : $main_font[0] = $main_font[0]);
    if(empty($comment_font[0]) ? $comment_font[0] = 10 : $comment_font[0] = $comment_font[0]);
    if(empty($block1_font[0]) ? $block1_font[0] = 10 : $block1_font[0] = $block1_font[0]);
    if(empty($block2_font[0]) ? $block2_font[0] = 10 : $block2_font[0] = $block2_font[0]);
    if(empty($block3_font[0]) ? $block3_font[0] = 10 : $block3_font[0] = $block3_font[0]);
    if(empty($error1_font[0]) ? $error1_font[0] = 10 : $error1_font[0] = $error1_font[0]);
    if(empty($error2_font[0]) ? $error2_font[0] = 10 : $error2_font[0] = $error2_font[0]);
    if(empty($error3_font[0]) ? $error3_font[0] = 10 : $error3_font[0] = $error3_font[0]);
    if(empty($info1_font[0]) ? $info1_font[0] = 10 : $info1_font[0] = $info1_font[0]);
    if(empty($info2_font[0]) ? $info2_font[0] = 10 : $info2_font[0] = $info2_font[0]);
    if(empty($info3_font[0]) ? $info3_font[0] = 10 : $info3_font[0] = $info3_font[0]);
    if(empty($info4_font[0]) ? $info4_font[0] = 10 : $info4_font[0] = $info4_font[0]);
    if(empty($info5_font[0]) ? $info5_font[0] = 10 : $info5_font[0] = $info5_font[0]);
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

$message .= '<STYLE type="text/css">
            .font_title, .link_title, #font_title, #link_title
            {
                font-size: '.$title_font[0].'px;
                font-weight: '.$title_font[1].';
                color: '.$title_font[2].';
                text-decoration: '.$title_font[3].';
                text-align: '.$title_font[4].';
                font-family: '.$title_font[5].';
            }

            .font_intro, .link_intro, #font_intro, #link_intro
            {
                font-size: '.$intro_font[0].'px;
                font-weight: '.$intro_font[1].';
                color: '.$intro_font[2].';
                text-decoration: '.$intro_font[3].';
                text-align: '.$intro_font[4].';
                font-family: '.$intro_font[5].';
            }

            .font_desc, .link_desc, #font_desc, #link_desc
            {
                font-size: '.$desc_font[0].'px;
                font-weight: '.$desc_font[1].';
                color: '.$desc_font[2].';
                text-decoration: '.$desc_font[3].';
                text-align: '.$desc_font[4].';
                font-family: '.$desc_font[5].';
            }

            .font_subtitle, .link_subtitle, #font_subtitle, #link_subtitle
            {
                font-size: '.$subtitle_font[0].'px;
                font-weight: '.$subtitle_font[1].';
                color: '.$subtitle_font[2].';
                text-decoration: '.$subtitle_font[3].';
                text-align: '.$subtitle_font[4].';
                font-family: '.$subtitle_font[5].';
            }

            .font_main, .link_main, #font_main, #link_font, #link_main
            {
                font-size: '.$main_font[0].'px;
                font-weight: '.$main_font[1].';
                color: '.$main_font[2].';
                text-decoration: '.$main_font[3].';
                text-align: '.$main_font[4].';
                font-family: '.$main_font[5].';
            }

            .font_comment, .link_comment, #font_comment, #link_comment
            {
                font-size: '.$comment_font[0].'px;
                font-weight: '.$comment_font[1].';
                color: '.$comment_font[2].';
                text-decoration: '.$comment_font[3].';
                text-align: '.$comment_font[4].';
                font-family: '.$comment_font[5].';
            }

            .font_block1, .link_block1, #font_block1, #link_block1
            {
                font-size: '.$block1_font[0].'px;
                font-weight: '.$block1_font[1].';
                color: '.$block1_font[2].';
                text-decoration: '.$block1_font[3].';
                text-align: '.$block1_font[4].';
                font-family: '.$block1_font[5].';
            }

            .font_block2, .link_block2, #font_block2, #link_block2
            {
                font-size: '.$block2_font[0].'px;
                font-weight: '.$block2_font[1].';
                color: '.$block2_font[2].';
                text-decoration: '.$block2_font[3].';
                text-align: '.$block2_font[4].';
                font-family: '.$block2_font[5].';
            }

            .font_block3, .link_block3, #font_block3, #font_block3
            {
                font-size: '.$block3_font[0].'px;
                font-weight: '.$block3_font[1].';
                color: '.$block3_font[2].';
                text-decoration: '.$block3_font[3].';
                text-align: '.$block3_font[4].';
                font-family: '.$block3_font[5].';
            }

            .font_error1, .link_error1, #font_error1, #link_error1
            {
                font-size: '.$error1_font[0].'px;
                font-weight: '.$error1_font[1].';
                color: '.$error1_font[2].';
                text-decoration: '.$error1_font[3].';
                text-align: '.$error1_font[4].';
                font-family: '.$error1_font[5].';
            }

            .font_error2, .link_error2, #font_error2, #link_error2
            {
                font-size: '.$error2_font[0].'px;
                font-weight: '.$error2_font[1].';
                color: '.$error2_font[2].';
                text-decoration: '.$error2_font[3].';
                text-align: '.$error2_font[4].';
                font-family: '.$error2_font[5].';
            }

            .font_error3, .link_error3, #font_error3, #link_error3
            {
                font-size: '.$error3_font[0].'px;
                font-weight: '.$error3_font[1].';
                color: '.$error3_font[2].';
                text-decoration: '.$error3_font[3].';
                text-align: '.$error3_font[4].';
                font-family: '.$error3_font[5].';
            }

            .font_info1, .link_info1, #font_info1, #link_info1
            {
                font-size: '.$info1_font[0].'px;
                font-weight: '.$info1_font[1].';
                color: '.$info1_font[2].';
                text-decoration: '.$info1_font[3].';
                text-align: '.$info1_font[4].';
                font-family: '.$info1_font[5].';
            }

            .font_info2, .link_info2, #font_info2, #link_info2
            {
                font-size: '.$info2_font[0].'px;
                font-weight: '.$info2_font[1].';
                color: '.$info2_font[2].';
                text-decoration: '.$info2_font[3].';
                text-align: '.$info2_font[4].';
                font-family: '.$info2_font[5].';
            }

            .font_info3, .link_info3
            {
                font-size: '.$info3_font[0].'px;
                font-weight: '.$info3_font[1].';
                color: '.$info3_font[2].';
                text-decoration: '.$info3_font[3].';
                text-align: '.$info3_font[4].';
                font-family: '.$info3_font[5].';
            }

            .font_info4, .link_info4
            {
                font-size: '.$info4_font[0].'px;
                font-weight: '.$info4_font[1].';
                color: '.$info4_font[2].';
                text-decoration: '.$info4_font[3].';
                text-align: '.$info4_font[4].';
                font-family: '.$info4_font[5].';
            }

            .font_info5, .link_info5
            {
                font-size: '.$info5_font[0].'px;
                font-weight: '.$info5_font[1].';
                color: '.$info5_font[2].';
                text-decoration: '.$info5_font[3].';
                text-align: '.$info5_font[4].';
                font-family: '.$info5_font[5].';
            }

            .link_title, .link_intro, .link_desc, .link_subtitle, .link_main, .link_comment,
            .link_block1, .link_block2, .link_block3, 
            .link_error1, .link_error2, .link_error3,
            .link_info1, .link_info2, .link_info3,
            .link_info4, .link_info5,
            #link_title, #link_intro, #link_desc, #link_subtitle, #link_font, #link_main, #link_comment,
            #link_block1, #link_block2, #link_block3, 
            #link_error1, #link_error2, #link_error3,
            #link_info1, #link_info2, #link_info3
            {
                border-bottom: 1px dotted black;
            }

            .link_title:hover, .link_intro:hover, .link_desc:hover, .link_subtitle:hover, .link_main:hover, .link_comment:hover,
            .link_block1:hover, .link_block2:hover, .link_block3:hover, 
            .link_error1:hover, .link_error2:hover, .link_error3:hover,
            .link_info1:hover, .link_info2:hover, .link_info3:hover,
            .link_info4:hover, .link_info5:hover,
            #link_title:hover, #link_intro:hover, #link_desc:hover, #link_subtitle:hover, #link_font:hover, #link_main:hover, #link_comment:hover,
            #link_block1:hover, #link_block2:hover, #link_block3:hover, 
            #link_error1:hover, #link_error2:hover, #link_error3:hover,
            #link_info1:hover, #link_info2:hover, #link_info3:hover
            {
            /*    text-decoration: ;*/
                border-bottom: 1px solid black;
            }

            </STYLE>';
?>