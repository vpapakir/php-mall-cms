<?php
include('shop/order_history/order_pending/order_pending_operation.php');
include('shop/order_history/order_closed/order_closed_operation.php');

if($_SESSION['autorisation'] === true)
{

    if($_SESSION['index'] == 'index_backoffice.php')
    {
        include($backoffice_html_skeleton_part1);    
    }
    else
    {
        echo('<td>');
    }
?>

<form method="post"><TABLE width="100%">
<?php
            if($_SESSION['index'] == 'index_backoffice.php')
            {
?>
                <td id="center_title">
                    Gestion des commandes
                </td>

                <tr><td colspan="2"><hr></hr></td></tr>   

<?php
            }
?>
                <tr style="height: 6px;"></tr>   
                
                <td><TABLE width="100%">
                    <td align="center"><a id="link" href="index.php?page=history_cart_order">Voir l'historique des paniers</a></td>
                </TABLE></td>
                
                <tr style="height: 6px;"></tr> 
<?php                
            
                    include('shop/order_history/order_pending.php');
?>    

            <tr style="height: 6px;"></tr>                 
            
<?php
                    include('shop/order_history/order_closed.php');
?>

                

    </TABLE></form>


<?php
    if($_SESSION['index'] == 'index_backoffice.php')
    {
        include($backoffice_html_skeleton_part2);    
    }
    else
    {
        echo('</td>');
    }
}
else
{
    header('Location: '.$header.'index.php?page=frontend_main');
}
?>