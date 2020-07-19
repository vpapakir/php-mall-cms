<?php
#display paging according to selected page
$paging_legend_first = give_translation('main.paging_firstpage', 'false', $config_showtranslationcode);
$paging_legend_previous = give_translation('main.paging_previouspage', 'false', $config_showtranslationcode);
$paging_legend_next = give_translation('main.paging_nextpage', 'false', $config_showtranslationcode);
$paging_legend_last = give_translation('main.paging_lastpage', 'false', $config_showtranslationcode);
$paging_legend_current = give_translation('main.paging_currentpage', 'false', $config_showtranslationcode);


echo('<tr><td width="50%"></td>');

if($paging_page_number <= $paging_page_max)
{ 
    for($paging_i = $paging_j; $paging_i <= $paging_page_number; $paging_i++)
    {
        if($paging_selected_page == $paging_i)
        {
            $paging_style = 'color: green; font-weight: bold; text-decoration: underline;';
        }
        else
        {
            $paging_style = 'color: black; font-weigth: bold;';
        }

        if($paging_selected_page != 1 && $paging_i == $paging_j && !empty($paging_page_number))
        {
            echo('<td>
                    <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging=1'.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging=1'.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_begin.gif" alt="'.$paging_legend_first.'" title="'.$paging_legend_first.'"/></a>
                 </td>
                 <td>
                     <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging='.$paging_previous.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging='.$paging_previous.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_previous.gif" alt="'.$paging_legend_previous.'" title="'.$paging_legend_previous.'"/></a>
                 </td>');            
        }

        if($paging_selected_page == $paging_i)
        {
          echo('<td align="center"> 
                    <div class="block_pagingact1" style="color: white; text-align: center;"><span title="'.$paging_legend_current.' '.$paging_i.'">'.$paging_i.'</span></div>     
                </td>');  
        }
        else
        {
           echo('<td align="center"> 
                    <a style="text-decoration: none;" class="font_main" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging='.$paging_i.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging='.$paging_i.$paging_anchor_id, 'false').'" title="'.$paging_legend_current.' '.$paging_i.'" '.$paging_jsevent.'><div class="block_pagingnorm1" style="text-align: center;" onmouseover="this.className=\'block_paginghov1\'" onmouseout="this.className=\'block_pagingnorm1\'"><span title="Page '.$paging_i.'">'.$paging_i.'</span></div></a> 
                 </td>');
        }
        
        echo('<td align="center"> 
              <div style="width: 2px;"></div>
              </td>');

        if($paging_selected_page != $paging_page_number && $paging_i == $paging_page_number && !empty($paging_page_number))
        {
            $paging_x = $paging_selected_page + 1;
            echo('<td> 
                     <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging='.$paging_x.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging='.$paging_x.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_next.gif" alt="'.$paging_legend_next.'" title="'.$paging_legend_next.'"/></a>
                  </td>
                  <td>
                      <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging='.$paging_page_number.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging='.$paging_page_number.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_end.gif" alt="'.$paging_legend_last.'" title="'.$paging_legend_last.'"/></a>                     
                  </td>');
        }
    }
}
else
{ 
    for($paging_i = $paging_j; $paging_i <= $paging_total_page; $paging_i++)
    {
        if($paging_selected_page == $paging_i)
        {
            $paging_style = 'color: green; font-weight: bold; text-decoration: underline;';
        }
        else
        {
            $paging_style = 'color: black; font-weigth: bold;';
        }

        if($paging_Bok_next_page === true && $paging_selected_page != 1 && !empty($paging_page_number))
        {
            $paging_Bok_next_page = false;
            echo('<td>
                      <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging=1'.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging=1'.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_begin.gif" alt="'.$paging_legend_first.'" title="'.$paging_legend_first.'"/></a>
                  </td>
                  <td>
                      <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging='.$paging_previous.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging='.$paging_previous.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_previous.gif" alt="'.$paging_legend_previous.'" title="'.$paging_legend_previous.'"/></a>
                  </td>');
        }
        else
        {
            if($paging_j == $paging_selected_page && $paging_Bok_disabled_left_arrow == true && $paging_selected_page <= $paging_page_max && $paging_i == $paging_j)
            {
                $paging_Bok_disabled_left_arrow = false;
            }
            else
            {
                if($paging_selected_page > $paging_j && $paging_Bok_activated_left_arrow == true && $paging_i == $paging_j)
                {
                    $paging_Bok_activated_left_arrow = false; 
                    echo('<td>
                              <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging=1'.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging=1'.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_begin.gif" alt="'.$paging_legend_first.'" title="'.$paging_legend_first.'"/></a>
                          </td>
                          <td>
                              <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging='.$paging_previous.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging='.$paging_previous.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_previous.gif" alt="'.$paging_legend_previous.'" title="'.$paging_legend_previous.'"/></a>
                          </td>');
                }
            }
        }

        if($paging_selected_page == $paging_i)
        {  
             echo('<td align="center">
                       <div class="block_pagingact1" style="color: white; text-align: center;"><span title="'.$paging_legend_current.' '.$paging_i.'">'.$paging_i.'</span></div>  
                   </td>');
        }
        else
        {
             echo('<td align="center">
                       <a style="text-decoration: none;" class="font_main" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging='.$paging_i.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging='.$paging_i.$paging_anchor_id, 'false').'" title="'.$paging_legend_current.' '.$paging_i.'" '.$paging_jsevent.'><div class="block_pagingnorm1" style="text-align: center;" onmouseover="this.className=\'block_paginghov1\'" onmouseout="this.className=\'block_pagingnorm1\'"><span title="Page '.$paging_i.'">'.$paging_i.'</span></div></a>
                   </td>');                 
        }
        
        echo('<td align="center"> 
              <div style="width: 2px;"></div>
              </td>');

         if($paging_i == $paging_total_page)
         {
            echo('</td>'); 
            if($paging_i == $paging_total_page && $paging_selected_page != $paging_page_number && !empty($paging_page_number))
            {
                $paging_x = $paging_selected_page + 1;
                echo('<td> 
                          <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging='.$paging_x.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging='.$paging_x.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_next.gif" alt="'.$paging_legend_next.'" title="'.$paging_legend_next.'"/></a>
                      </td>
                      <td>
                          <a class="" href="'.change_link('index.php?page='.$paging_urlscript.'&amp;paging='.$paging_page_number.$paging_anchor_id, 'index_backoffice.php?page='.$paging_urlscript.'&amp;paging='.$paging_page_number.$paging_anchor_id, 'false').'" '.$paging_jsevent.'><img style="border: none;" src="'.$config_customheader.'graphics/icons/paging/paging_end.gif" alt="'.$paging_legend_last.'" title="'.$paging_legend_last.'"/></a>                     
                      </td>');                    
            }
         }
    }
}
$paging_Bok_next_page = true;

echo('<td width="50%"></td></tr>');

?>
