<?php
if(isset($_POST['bt_cboLevelxTypeLink']))
{
    unset($_SESSION['msg_sitemap_levelx_cboLevelxType'],
          $_SESSION['msg_sitemap_levelx_txtLevelxPosition'],
          $_SESSION['msg_sitemap_levelx_txtLevelxTitle']);
    
    $selected_type_link = trim(htmlspecialchars($_POST['cboLevelxTypeLink'], ENT_QUOTES));
    $type_levelx = trim(htmlspecialchars($_POST['cboLevelxType'], ENT_QUOTES));
    $family_levelx = trim(htmlspecialchars($_POST['cboLevelxFamily'], ENT_QUOTES));
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        $title_levelx[$i] = trim(htmlspecialchars($_POST['txtLevelxTitle'.$main_activatedidlang[$i]], ENT_QUOTES));
    }
        
    switch($typelink_levelx)
    {
       case 'page':
         $link_levelx = trim(htmlspecialchars($_POST['cboLevelxPage'], ENT_QUOTES));
           break;
       case 'script':
         $link_levelx = trim(htmlspecialchars($_POST['txtLevelxScriptPath'], ENT_QUOTES));
           break;
       case 'url':
         $link_levelx = trim(htmlspecialchars($_POST['txtLevelxURL'], ENT_QUOTES));
           break;
    }

    $target_levelx = trim(htmlspecialchars($_POST['cboLevelxTarget'], ENT_QUOTES));
    $reference_levelx = trim(htmlspecialchars($_POST['txtLevelxReference'], ENT_QUOTES));
    $position_levelx = trim(htmlspecialchars($_POST['txtLevelxPosition'], ENT_QUOTES));
    $status_levelx = trim(htmlspecialchars($_POST['cboLevelxStatus'], ENT_QUOTES));
    
    $marginT_levelx = trim(htmlspecialchars($_POST['txtLevelxMarginT'], ENT_QUOTES));
    $marginR_levelx = trim(htmlspecialchars($_POST['txtLevelxMarginR'], ENT_QUOTES));
    $marginB_levelx = trim(htmlspecialchars($_POST['txtLevelxMarginB'], ENT_QUOTES));
    $marginL_levelx = trim(htmlspecialchars($_POST['txtLevelxMarginL'], ENT_QUOTES));
    $align_levelx = trim(htmlspecialchars($_POST['cboLevelxTitleAlign'], ENT_QUOTES));
    //$id_levelx = trim(htmlspecialchars($_POST['cboLevelxLevel'], ENT_QUOTES));
    
    $margin_levelx = $marginT_levelx.'$'.$marginR_levelx.'$'.$marginB_levelx.'$'.$marginL_levelx;
    
    $rights_levelx = $_POST['cboLevelxRights'];

    $userrights_levelx = null;

    if($rights_levelx[0] == 'all')
    {
        $userrights_levelx = 'all';
    }
    else
    {
        for($i = 0, $count = count($rights_levelx); $i < $count; $i++)
        {
            if($i == 0)
            {
               $userrights_levelx = $rights_levelx[$i];
            }
            else
            {
               $userrights_levelx .= ','.$rights_levelx[$i]; 
            }
        } 
        $userrights_levelx .= ',9';
    }
    
    if(preg_match('#9,9$#', $userrights_levelx))
        {
            $userrights_levelx = '9,9';
        }

    if($selected_type_link == 'select')
    {
        unset($_SESSION['sitemap_levelx_cboLevelxTypeLink']);
    }
    else
    {
        $_SESSION['sitemap_levelx_cboLevelxTypeLink'] = $selected_type_link;
        $_SESSION['sitemap_levelx_cboLevelxType'] = $type_levelx;
        $_SESSION['sitemap_levelx_cboLevelxFamily'] = $family_levelx;
        $_SESSION['sitemap_levelx_txtLevelxLink'] = $link_levelx;
        $_SESSION['sitemap_levelx_txtLevelxPosition'] = $position_levelx;
        $_SESSION['sitemap_levelx_txtLevelxReference'] = $reference_levelx;
        $_SESSION['sitemap_levelx_cboLevelxStatus'] = $status_levelx;
        $_SESSION['sitemap_levelx_cboLevelxTarget'] = $target_levelx;
            
        $_SESSION['sitemap_levelx_txtLevelxMargin'] = $margin_levelx;
        $_SESSION['sitemap_levelx_cboLevelxTitleAlign'] = $align_levelx;
        
        for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
        {
            $_SESSION['sitemap_levelx_txtLevelxTitle'.$main_activatedidlang[$i]] = $title_levelx[$i];
        }
        $_SESSION['sitemap_levelx_cboLevelxRights'] = $userrights_levelx;
        //$_SESSION['sitemap_levelx_cboLevelxLevel'] = $id_levelx;
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
