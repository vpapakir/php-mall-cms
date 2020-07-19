<?php
nosubmit_form_historyback();
include('modules/stats/page/page_view/pageview_getinfo.php');
#bt
include('modules/stats/page/page_view/button/bt_reset_statspageview.php');
include('modules/stats/page/page_view/button/bt_removetostats_statspageview.php');
?>
<form method="post"><table width="100%">
<?php
    include('modules/stats/page/page_view/content/pageview_numberinfo.php');
    include('modules/stats/page/page_view/content/pageview_listing.php');
?>
</table></form>
