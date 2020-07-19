<?php
#all
include('modules/cdr/cdrgeo/bt/bt_all_geo.php');
#new
include('modules/cdr/cdrgeo/bt/new/bt_new_CDRgeoCity.php');
#delete
include('modules/cdr/cdrgeo/bt/delete/bt_delete_image_city.php');
include('modules/cdr/cdrgeo/bt/delete/bt_delete_image_district.php');
include('modules/cdr/cdrgeo/bt/delete/bt_delete_image_department.php');
include('modules/cdr/cdrgeo/bt/delete/bt_delete_image_region.php');
include('modules/cdr/cdrgeo/bt/delete/bt_delete_image_country.php');
#add
include('modules/cdr/cdrgeo/bt/add/bt_add_city_geo.php');
include('modules/cdr/cdrgeo/bt/add/bt_add_district_geo.php');
include('modules/cdr/cdrgeo/bt/add/bt_add_department_geo.php');
include('modules/cdr/cdrgeo/bt/add/bt_add_region_geo.php');
include('modules/cdr/cdrgeo/bt/add/bt_add_country_geo.php');
#edit
include('modules/cdr/cdrgeo/bt/edit/bt_edit_city_geo.php');
include('modules/cdr/cdrgeo/bt/edit/bt_edit_district_geo.php');
include('modules/cdr/cdrgeo/bt/edit/bt_edit_department_geo.php');
include('modules/cdr/cdrgeo/bt/edit/bt_edit_region_geo.php');
include('modules/cdr/cdrgeo/bt/edit/bt_edit_country_geo.php');
?>

<form method="post" enctype="multipart/form-data"><table width="100%">
<?php
    if(!empty($_SESSION['msg_cdrgeo_done']))
    {
?>
        <tr>
            <td align="left">
                <table width="100%" class="block_msg1">
                    <tr>
                        <td align="center">
                            <span><?php echo($_SESSION['msg_cdrgeo_done']); ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }
    
    include('modules/cdr/cdrgeo/city/city_main.php');
    include('modules/cdr/cdrgeo/district/district_main.php');
    include('modules/cdr/cdrgeo/department/department_main.php');
    include('modules/cdr/cdrgeo/region/region_main.php');
    include('modules/cdr/cdrgeo/country/country_main.php');
?>   
</table></form>
