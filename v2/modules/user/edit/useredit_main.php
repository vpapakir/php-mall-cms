<?php
nosubmit_form_historyback();
#getinfo
include('modules/user/edit/useredit_getinfo.php');
#bt
include('modules/user/edit/button/bt_search_useredit.php');
include('modules/user/edit/button/bt_resetlisting_useredit.php');
include('modules/user/edit/button/bt_neworedit_useredit.php');
include('modules/user/edit/button/bt_backtolisting_useredit.php');
include('modules/user/edit/button/bt_gotomailing_useredit.php');

if(!empty($_SESSION['useredit_gotoedition']) && $_SESSION['useredit_gotoedition'] == true)
{
    include('modules/user/userdata/userdata_getinfo.php');
    include('modules/user/edit/button/bt_save_useredit.php');
}
?>
<form method="post"><table width="100%">
    <tr>
        <td align="center">
            <span class="font_main"><?php echo($useredit_info_totalregistereduser); ?></span>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>    
    <tr>
        <td colspan="2" style="border-top: 1px dashed lightgrey;"></td>
    </tr>
    <tr>
        <td colspan="2"><div style="height: 4px;"></div></td>
    </tr>
<?php  
if(empty($_SESSION['useredit_gotoedition']))
{
    include('modules/user/edit/search/usersearch_main.php');
    include('modules/user/edit/order/userorder_main.php');
    include('modules/user/edit/listing/userlisting_main.php');
}
else
{
    include('modules/user/edit/modify/usermodify_main.php');
}
?>
</table></form>
