<?php
if(isset($_GET['paging']))
{

    $paging_selected_page = trim(htmlspecialchars($_GET['paging'], ENT_QUOTES));

    $_SESSION['paging_limit'] = $paging_resultperpage;     

    if($paging_selected_page == 1)
    {
        $paging_limit_min = 0;
        $paging_limit_max = $_SESSION['paging_limit'];
    }
    else
    {
        $paging_limit_min = ($_SESSION['paging_limit'] * $paging_selected_page) - ($_SESSION['paging_limit']);
        $paging_limit_max = $_SESSION['paging_limit'];
    }
}
else
{
   if(!empty($_SESSION['paging_selected_page']))
   {

       $paging_selected_page = $_SESSION['paging_selected_page']; 

   }
   else
   {
       $paging_selected_page = 1;

   }
}


#get total pages number and give limit
if($paging_countresult > $paging_resultperpage)
{
    $paging_Bok_insert_paging = true;

    $paging_page_number = paging_number_page($paging_countresult, $paging_resultperpage);

    if(empty($_SESSION['paging_defaultdisplay']))
    {
        $paging_limit_min = 0;

        $paging_limit_max = $paging_resultperpage;

        $paging_selected_page = 1; 
    }
    else
    {
//        $paging_limit_min = $_SESSION['paging_limitmin'];
//        $paging_limit_max = $_SESSION['paging_limitmax'];
    }
}
else
{
    $paging_limit_min = 0;

    $paging_limit_max = $paging_resultperpage;
}

$_SESSION['paging_limitmin'] = $paging_limit_min;
$_SESSION['paging_limitmax'] = $paging_limit_max;

$paging_Bok_next_page = false;
$paging_Bok_disabled_left_arrow = true;
$paging_Bok_activated_left_arrow = true;



if($paging_page_number != null)
{
    if($paging_selected_page > $paging_page_max)
    {
        $y = 0;

        for($i = 1; $i <= $paging_page_number; $i++)
        {
           if($paging_selected_page == $i)
           {
               $i = $paging_page_number + 1; 
           }

           if($y == $paging_page_max) 
           {
               $paging_page_part++;
               $y = 0;
           }

           $y++;
        }
        $paging_j = ($paging_page_part * $paging_page_max) + 1;

        $paging_total_page = ($paging_page_part + 1) * $paging_page_max;
        
        if($paging_total_page > $paging_page_number)
        {
           $paging_j = ($paging_page_number - $paging_page_max);
           $paging_total_page = $paging_page_number - 1;
        }
        
        $paging_previous = $paging_selected_page - 1;

        $paging_Bok_next_page = true;

        if($paging_selected_page == $paging_page_number)
        {
           $paging_j = $paging_page_number - ($paging_page_max - 1);
           $paging_total_page = $paging_page_number; 
        }
    }
    else
    {
        $paging_previous = $paging_selected_page - 1;
        $paging_j = 1;
        $paging_total_page = $paging_page_max;
    }
}

$_SESSION['paging_selected_page'] = $paging_selected_page;
?>
