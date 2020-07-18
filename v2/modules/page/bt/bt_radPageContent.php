<?php
if(isset($_POST['bt_radPageContent']))
{
    $radcontent_selectedpage = trim(htmlspecialchars($_POST['radPageContent'], ENT_QUOTES));
    
    $_SESSION['page_property_radPageContent'] = $radcontent_selectedpage;
    
    if($radcontent_selectedpage == 'html')
    {
        $_SESSION['page_edit_active_ckEditor'] = true;
    }
    else
    {
        unset($_SESSION['page_edit_active_ckEditor']);
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
