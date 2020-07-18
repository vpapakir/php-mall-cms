<?php
#title
if(!empty($kformprodemail_product_title) || !empty($kformprodemail_product_reference))
{
    $message .= '<tr>
                    <td colspan="2"><table width="100%" border="0" style="font-size: 16px; text-align: center; font-weight: bold; margin-bottom: 2px;" class="block_title3">   
                         <tr>  
                            <td>                           
                                <div>';
    if(!empty($kformprodemail_product_title))
    {
        $message .= $kformprodemail_product_title;
    }
    else
    {
        $message .= $kformprodemail_product_reference;
    }

    $message .= '               </div>
                            </td>
                         </tr>
                    </table></td>
                </tr>';
}
?>
