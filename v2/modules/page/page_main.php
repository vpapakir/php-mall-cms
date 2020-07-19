<?php
//nosubmit_form_historyback();
#content
include('modules/page/content/page_content_getinfo.php');
#main
include('modules/page/bt/bt_save_page.php');
//include('modules/page/bt/bt_radPageContent.php');
#upload
include('modules/page/bt/upload/bt_send_image_page.php');
include('modules/page/bt/upload/bt_delete_image_page.php');
#expand
include('modules/page/bt/page_expand.php');
#select
include('modules/page/select/bt_select/bt_cboPageSelect.php');
?>

<form method="post" enctype="multipart/form-data"><table width="100%">
<?php
    if(!empty($_SESSION['msg_page_savedone']))
    {
?>
        <tr>
            <td align="left">
                <table width="100%" class="block_msg1">
                    <tr>
                        <td align="center">
                            <span><?php echo($_SESSION['msg_page_savedone']); ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    } 

    include('modules/page/select/page_select.php');
    
    if(!empty($_SESSION['page_select_cboPageSelect']) && $_SESSION['page_select_cboPageSelect'] != 'new')
    {
?>
        <tr>
            <td align="left">
                <table width="100%">
                    <tr>
                        <td align="center">
                            <a  class="link_subtitle" href="<?php echo($config_customheader); change_link($_SESSION['page_url_txtPageURLRewritingF'.$main_activatedidlang[$main_id_language]], $_SESSION['page_url_txtPageURLRewritingB'.$main_activatedidlang[$main_id_language]]) ?>"><?php give_translation('page_edit.goto_page', '', $config_showtranslationcode); ?></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php 
    }
    
    include('modules/page/property/page_property.php');
 
    if(!empty($_SESSION['page_edit_display_content']) && $_SESSION['page_edit_display_content'] === true)
    {
        include('modules/page/content/page_content.php');    
    }
    
?>
    
</table></form>
