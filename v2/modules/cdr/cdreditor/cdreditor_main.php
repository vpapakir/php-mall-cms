<?php
nosubmit_form_historyback();
#getinfo
include('modules/cdr/cdreditor/cdreditor_getinfo.php');
#add or edit
include('modules/cdr/cdreditor/bt/bt_new_cdreditor.php');
include('modules/cdr/cdreditor/bt/bt_delete_cdreditor.php');
include('modules/cdr/cdreditor/bt/bt_add_edit_cdreditor.php');
#select
include('modules/cdr/cdreditor/bt/bt_cboSelectCDReditor.php');
include('modules/cdr/cdreditor/bt/bt_cboFamilyCDReditor.php');
?>

<form method="post"><table width="100%">
<?php
    include('modules/cdr/cdreditor/msg/cdreditor_msg.php');
    include('modules/cdr/cdreditor/select/cdreditor_select.php');
    include('modules/cdr/cdreditor/content/cdreditor_content.php');
?>    
</table></form>
