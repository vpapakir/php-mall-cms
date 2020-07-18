<?php
nosubmit_form_historyback();
#custom
if(!empty($config_module_immo) && $config_module_immo == 1)
{
    include('modules/custom/immo/modules/Kprodimmo/general/general_getinfo.php');
    include('modules/custom/immo/modules/Kprodimmo/energy/energy_getinfo.php');
    include('modules/custom/immo/modules/Kprodimmo/other/other_getinfo.php');
    include('modules/custom/immo/modules/Kprodimmo/admin/admin_getinfo.php');
    include('modules/custom/immo/modules/Kprodimmo/situation/situation_getinfo.php');
    include('modules/custom/immo/modules/Kprodimmo/interior/interior_getinfo.php');
    include('modules/custom/immo/modules/Kprodimmo/exterior/exterior_getinfo.php');
	echo $config_module_immo;
} else {
    include('modules/custom/multishop/modules/Kprodimmo/general/general_getinfo.php');
    include('modules/custom/multishop/modules/Kprodimmo/energy/energy_getinfo.php');
    include('modules/custom/multishop/modules/Kprodimmo/other/other_getinfo.php');
    include('modules/custom/multishop/modules/Kprodimmo/admin/admin_getinfo.php');
    include('modules/custom/multishop/modules/Kprodimmo/situation/situation_getinfo.php');
    include('modules/custom/multishop/modules/Kprodimmo/interior/interior_getinfo.php');
    include('modules/custom/multishop/modules/Kprodimmo/exterior/exterior_getinfo.php');
	//echo "TEST";
}
#content
include('modules/product/content/product_content_getinfo.php');
#main
include('modules/product/bt/bt_save_product.php');
//include('modules/product/bt/bt_radProductContent.php');
#upload
include('modules/product/bt/upload/bt_send_image_product.php');
include('modules/product/bt/upload/bt_delete_image_product.php');
#select
include('modules/product/select/bt_select/bt_cboProductSelect.php');
#expand
include('modules/product/bt/product_expand.php');
?>

<form method="post" enctype="multipart/form-data"><table width="100%">
<?php
if(!empty($_SESSION['msg_product_savedone']))
{
    $_SESSION['unset_afterrefresh_product_savedone']++;
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_product_savedone']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
    if($_SESSION['unset_afterrefresh_product_savedone'] >= 2)
    {
        unset($_SESSION['msg_product_savedone']);
        unset($_SESSION['unset_afterrefresh_product_savedone']);
    }
}    

    include('modules/product/select/product_select.php');
   
    if(!empty($_SESSION['product_select_cboProductSelect']) && $_SESSION['product_select_cboProductSelect'] != 'new')
    {
?>
        <tr>
            <td align="left">
                <table width="100%">
                    <tr>
                        <td align="center">
                            <a  class="link_subtitle" href="<?php echo($config_customheader); change_link($_SESSION['product_url_txtProductURLRewritingF'.$main_activatedidlang[$main_id_language]], $_SESSION['product_url_txtProductURLRewritingB'.$main_activatedidlang[$main_id_language]]) ?>"><?php give_translation('edit_product.link_showpage', $echo, $config_showtranslationcode); ?></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }
    
    include('modules/product/property/product_property.php');
 
    if(!empty($_SESSION['product_edit_display_content']) && $_SESSION['product_edit_display_content'] === true)
    {
        if(!empty($config_module_immo) && $config_module_immo == 1)
        {
            include('modules/custom/immo/modules/Kprodimmo/general/general_main.php');
            include('modules/custom/immo/modules/Kprodimmo/energy/energy_main.php');
            //include('modules/custom/immo/modules/Kprodimmo/other/other_main.php');
            //include('modules/custom/immo/modules/Kprodimmo/admin/admin_main.php');
        } else {
            include('modules/custom/multishop/modules/Kprodimmo/general/general_main.php');
            //include('modules/custom/multishop/modules/Kprodimmo/other/other_main.php');
            //include('modules/custom/multishop/modules/Kprodimmo/admin/admin_main.php');
		}
        include('modules/product/content/product_content.php');
        if(!empty($config_module_immo) && $config_module_immo == 1)
        {
            include('modules/custom/immo/modules/Kprodimmo/Kprodimmo_main.php');
        } else {
            include('modules/custom/multishop/modules/Kprodimmo/Kprodimmo_main.php');
		}
        include('modules/product/content/product_content_url.php');
    }
    else
    {
        if(!empty($config_module_immo) && $config_module_immo == 1)
        {
            include('modules/custom/immo/modules/Kprodimmo/general/general_main.php');
            //include('modules/custom/immo/modules/Kprodimmo/energy/energy_main.php');
            //include('modules/custom/immo/modules/Kprodimmo/other/other_main.php');
            //include('modules/custom/immo/modules/Kprodimmo/admin/admin_main.php');
        } else {
            include('modules/custom/multishop/modules/Kprodimmo/general/general_main.php');
            //include('modules/custom/multishop/modules/Kprodimmo/other/other_main.php');
           // include('modules/custom/multishop/modules/Kprodimmo/admin/admin_main.php');
		}
    }
    
?>   
</table></form>
