<?php
#getinfo
include('modules/structure/sitemap/sitemap_getinfo.php');

#frame
include('modules/structure/sitemap/frame/bt_frame/bt_cboSitemapFrame.php');

#box
include('modules/structure/sitemap/box/bt_box/bt_show_box.php');
include('modules/structure/sitemap/box/bt_box/bt_cboBox.php');
include('modules/structure/sitemap/box/bt_box/bt_cboBoxTypeLink.php');
include('modules/structure/sitemap/box/bt_box/bt_edit_box.php');
include('modules/structure/sitemap/box/bt_box/bt_add_box.php');
#levelx
include('modules/structure/sitemap/levelx/bt_levelx/bt_cboLevelx.php');
include('modules/structure/sitemap/levelx/bt_levelx/bt_cboLevelxTypeLink.php');
include('modules/structure/sitemap/levelx/bt_levelx/bt_delete_image_levelx.php');
include('modules/structure/sitemap/levelx/bt_levelx/bt_edit_levelx.php');
include('modules/structure/sitemap/levelx/bt_levelx/bt_add_levelx.php');
include('modules/structure/sitemap/levelx/bt_levelx/bt_delete_levelx.php');

#GET levelx
include('modules/structure/sitemap/levelx/levelx_getid.php');

?>

<td><table width="100%">

<?php
    include('modules/structure/sitemap/frame/frame_main.php');
    
    if(!empty($_SESSION['sitemap_frame_cboSitemapFrame']) && $_SESSION['sitemap_frame_cboSitemapFrame'] != 'select')
    {
        include('modules/structure/sitemap/box/box_main.php');
    }
    
    if(!empty($_SESSION['sitemap_accesstolevelx']) && $_SESSION['sitemap_accesstolevelx'] === true)
    {
        include('modules/structure/sitemap/levelx/levelx_main.php');
    }
?>
            
</table></td>
