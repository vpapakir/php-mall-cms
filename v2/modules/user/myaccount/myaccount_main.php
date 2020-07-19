<?php
include('modules/user/myaccount/myaccount_getinfo.php');
#bt
include('modules/user/myaccount/bt/bt_modify_myaccount_email.php');
include('modules/user/myaccount/bt/bt_modify_myaccount_main.php');
include('modules/user/myaccount/bt/bt_modify_myaccount_password.php');
include('modules/user/myaccount/message/bt/bt_back_myaccountmsg.php');
include('modules/user/myaccount/message/bt/bt_sendreply_myaccountmsg.php');
include('modules/user/myaccount/message/bt/bt_deleted_myaccountmsg.php');
include('modules/user/myaccount/message/bt/bt_settounread_myaccountmsg.php');
include('modules/user/myaccount/message/bt/bt_settoread_myaccountmsg.php');
?>
<form method="post"><table width="100%" cellpadding="0" cellspacing="0">
<?php
if(isset($_GET['idmsg']))
{
    include('modules/user/myaccount/message/view/myaccountmsg_view.php');
}
else
{
    include('modules/user/myaccount/user/user_stats.php');
    include('modules/user/myaccount/message/myaccountmsg_main.php');
    include('modules/user/myaccount/user/user_main.php');
    if(!empty($config_module_immo) && $config_module_immo == 1)
    {
        include('modules/custom/immo/modules/myaccount/portfolio/portfolio_main.php');   
    } else {
        include('modules/custom/multishop/modules/myaccount/portfolio/portfolio_main.php');   
	}
}
?>      
</table></form>
