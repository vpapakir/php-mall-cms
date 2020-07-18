<?php
nosubmit_form_historyback();
#save
include('modules/custom/immo/modules/displayvalueimmo/bt/bt_save_displayvalue.php');
#select
include('modules/custom/immo/modules/displayvalueimmo/bt/bt_cboTemplateDisplayValue.php');
?>
<form method="post"><table width="100%">
<?php
    include('modules/custom/immo/modules/displayvalueimmo/select/select_main.php');
    
    if(!empty($_SESSION['displayvalue_cboTemplateDisplayValue']) && $_SESSION['displayvalue_cboTemplateDisplayValue'] != 'select')
    {
        include('modules/custom/immo/modules/displayvalueimmo/value/value_main.php');
    }
?>
</table></form>   
       
