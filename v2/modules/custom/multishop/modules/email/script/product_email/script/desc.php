<?php
#desc
if(!empty($kformprodemail_product_desc))
{
    $message .= '<tr>
                    <td>                           
                        <h3 style="margin: 4px 4px 4px 4px; color: black; font-size: 12px; text-align: left; font-weight: normal;" class="font_desc">'.$kformprodemail_product_desc.'</h3>
                    </td>
                 </tr>';
}
else
{
   $message .= '<tr>
                    <td>                           
                        <div style="margin: 4px 4px 4px 4px;"></div>
                    </td>
                </tr>'; 
}
unset($kformprodemail_product_desc);
?>
