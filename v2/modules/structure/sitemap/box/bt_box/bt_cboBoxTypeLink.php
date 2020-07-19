<?php
if(isset($_POST['bt_cboBoxTypeLink']))
{
    unset($_SESSION['msg_sitemap_box_cboBoxType'],
          $_SESSION['msg_sitemap_box_txtBoxPosition'],
          $_SESSION['msg_sitemap_box_txtBoxTitle']);
    
    $selected_type_link = trim(htmlspecialchars($_POST['cboBoxTypeLink'], ENT_QUOTES));
    
    if($selected_type_link == 'select')
    {
        unset($_SESSION['sitemap_box_cboBoxTypeLink']);
    }
    else
    {
        $_SESSION['sitemap_box_cboBoxTypeLink'] = $selected_type_link;
    }
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>
