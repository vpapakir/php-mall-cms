<?php
#getinfo
include('modules/settings/clipboard/clipboard_getinfo.php');
#bt
include('modules/settings/clipboard/bt/bt_save_clipboard.php');
include('modules/settings/clipboard/bt/bt_truncate_clipboard.php');
?>
<form method="post">
    <table width="100%">
<?php
    include('modules/settings/clipboard/content/clipboard_content.php');
?>    
    </table>
</form>
