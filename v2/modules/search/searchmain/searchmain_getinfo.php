<?php

$searchmain_orderby_nrpage = 5;

$searchmain_listing_result = $_SESSION['searchmain_search_listing_result']; #result list [array]
$searchmain_count_result = $_SESSION['searchmain_search_result_count'];

#[paging]
$paging_resultperpage = $searchmain_orderby_nrpage;
$paging_page_max = 5;
$paging_countresult = $searchmain_count_result;
include('modules/search/paging/paging_getinfo.php');

if(empty($_SESSION['paging_selected_page']))
{
    $searchmain_selectedpage = 1;
    $ipagingmax = $searchmain_count_result;
    $ipaging = 0;
}
else
{
    $_SESSION['paging_defaultdisplay'] = 'false';
    $searchmain_selectedpage = $_SESSION['paging_selected_page'];
    $ipagingmax = $searchmain_selectedpage * $searchmain_orderby_nrpage;
    $ipaging = ($searchmain_selectedpage * $searchmain_orderby_nrpage) - $searchmain_orderby_nrpage;

    if($ipagingmax > $paging_countresult)
    {
        $ipagingmax = $paging_countresult;
    }
}


#[/paging]
#result
$searchmain_keywords = $_SESSION['searchmain_search_keywords'];

unset($msg_info_searchmain_result);

if(!empty($_SESSION['searchmain_search_txtsearchmainSearch_1']))
{
    if($searchmain_count_result == 0)
    {
        $msg_info_searchmain_result = give_translation('messages.msg_info_searchmain_noresult', true, $config_showtranslationcode);
        $msg_info_searchmain_result = str_replace('[#search_keywords]', '"<span class="font_main" style="font-weight: bold;">'.$_SESSION['searchmain_search_txtsearchmainSearch_1'].'</span>"', $msg_info_searchmain_result);
    }
    else
    {
        if($searchmain_count_result == 1)
        {
            $msg_info_searchmain_result = give_translation('messages.msg_info_searchmain_oneresult', true, $config_showtranslationcode);
            $msg_info_searchmain_result = str_replace('[#search_keywords]', '"<span class="font_main" style="font-weight: bold;">'.$_SESSION['searchmain_search_txtsearchmainSearch_1'].'</span>"', $msg_info_searchmain_result);
        }
        else
        {
            $msg_info_searchmain_result = give_translation('messages.msg_info_searchmain_moreresult', true, $config_showtranslationcode);
            $msg_info_searchmain_result = str_replace('[#search_totalresult]', '<span class="font_main" style="font-weight: bold;">'.$searchmain_count_result.'</span>', $msg_info_searchmain_result);
            $msg_info_searchmain_result = str_replace('[#search_keywords]', '"<span class="font_main" style="font-weight: bold;">'.$_SESSION['searchmain_search_txtsearchmainSearch_1'].'</span>"', $msg_info_searchmain_result);
        }
    }
}
else
{
    $msg_info_searchmain_result = give_translation('messages.msg_info_searchmain_emptyresult', true, $config_showtranslationcode);
}
?>
