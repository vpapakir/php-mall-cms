<?php
include('modules/settings/memo/bt/bt_select_memo.php');
include('modules/settings/memo/bt/bt_save_memo.php');
include('modules/settings/memo/bt/bt_edit_memo.php');
include('modules/settings/memo/bt/bt_delete_memo.php');
?>

<form method="post"><table width="100%">
    
<?php
    include('modules/settings/memo/memo_select/memo_select.php');
    
    if(!empty($_SESSION['memo_view']) && $_SESSION['memo_view'] == true)
    {
        include('modules/settings/memo/memo_view/memo_view.php');
    }
    else
    {
        include('modules/settings/memo/memo_edit/memo_edit.php');
    }
?>       
</table></form>

