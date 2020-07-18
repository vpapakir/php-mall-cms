<?php
nosubmit_form_historyback();
include('modules/stats/visit/visit_view/visitview_getinfo.php');
#bt
include('modules/stats/visit/visit_view/button/bt_reset_statsvisitview_known.php');
include('modules/stats/visit/visit_view/button/bt_reset_statsvisitview_unknown.php');
include('modules/stats/visit/visit_view/button/bt_removetostats_statsvisitview_known.php');
include('modules/stats/visit/visit_view/button/bt_removetostats_statsvisitview_unknown.php');
?>
<form method="post"><table width="100%">
<?php
    include('modules/stats/visit/visit_view/content/visitview_numberinfo.php');
    include('modules/stats/visit/visit_view/content/visitview_listing_known.php');
    include('modules/stats/visit/visit_view/content/visitview_listing_unknown.php');
?>
</table></form>
