<?php
try
{
    $total_amount_order_history_closed = null;
    
    $prepared_query = 'SELECT COUNT(id_order_history) FROM order_history
                       WHERE (status_order_history = \'delivered\' OR status_order_history = \'transferred\'
                             OR status_order_history = \'cancelled\') AND new_order_history = 0';
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $count_order_history_closed = $data[0];
    }
    $query->closeCursor();
    
    $prepared_query = 'SELECT amount_order_history FROM order_history
                       WHERE (status_order_history = \'delivered\' OR status_order_history = \'transferred\') AND new_order_history = 0';
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    while($data = $query->fetch())
    {
        $total_amount_order_history_closed += $data[0];
    }
    $query->closeCursor();
    
    $total_amount_order_history_closed = number_format($total_amount_order_history_closed, 2, '.', '');
}
catch(Exception $e)
{
    die('<br>Error: '.$e->getMessage());
}


if(isset($_GET['expandord']))
{
    if($_GET['expandord'] == 'true')
    {
        $_SESSION['order_history_expand_block'] = true;
    }
    else
    {
        $_SESSION['order_history_expand_block'] = false;
    }
}
else
{
    if(!empty($_SESSION['order_history_expand_block']) && $_SESSION['order_history_expand_block'] == 'false')
    {
        $_SESSION['order_history_expand_block'] = false;
    }
    else
    {
        $_SESSION['order_history_expand_block'] = true;
    }
}

if($_SESSION['order_history_expand_block'] == true)
{
?>
    <td>
        <TABLE width="100%" cellpadding="0" cellspacing="0">

            <td colspan="6">
                <!--[if !IE]>--><a style="text-decoration: none;" href="<?php echo($_SESSION['index'].'?page='.$_SESSION['redirect'].'&expandord=false'); ?>"><!--<![endif]-->
                <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0"> 
                    <td>
                        <!--[if IE]><a style="text-decoration: none;" href="<?php echo($_SESSION['index'].'?page='.$_SESSION['redirect'].'&expandord=false'); ?>"><![endif]-->
                        <image src="graphics/icons/minus16x16.png" alt="collapse" title="Cacher"></image>
                        <!--[if IE]></a><![endif]-->
                    </td>
                    <td width="100%">
                        <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">
                            <?php

                            echo('Commandes clôturées ('.$count_order_history_closed.') pour un montant total de '.$total_amount_order_history_closed.'&nbsp€ TTC');
?>

                        </span>
                    </td>
                </TABLE>
                <!--[if !IE]>--></a><!--<![endif]-->
            </td>
<?php
if($count_order_history_closed > 0)
{
?>
            <tr style="height: 6px;"></tr>

            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">No.</span></div></td>
            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Client</span></div></td>
            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Type</span></div></td>
            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Montant</span></div></td>            
            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Date</span></div></td>
            <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Statut</span></div></td>

            <tr style="height: 6px;"></tr>
<?php
}
else
{
?>
        <tr style="height: 6px;"></tr>    
            
        <td id="center_text_table" align="center">Aucune commande clôturée</td>   
<?php
}

    try
    {
        $BoK_style_order_history_pending = false;

        $prepared_query = 'SELECT * FROM order_history
                           INNER JOIN user_real
                           ON order_history.id_user = user_real.id_user
                           WHERE (status_order_history = \'delivered\' OR status_order_history = \'transferred\'
                           OR status_order_history = \'cancelled\')
                           AND new_order_history = 0
                           ORDER BY date_order_history DESC';

        $query = $connectData->prepare($prepared_query);
        $query->execute();

        while($data = $query->fetch())
        {

            if($BoK_style_order_history_pending == false)
            {
                $style_order_history_pending = 'style="background-color: white;"';
                $BoK_style_order_history_pending = true;
            }
            else
            {
                $style_order_history_pending = 'style="background-color: #EEEEEE;"';
                $BoK_style_order_history_pending = false;
            }

            if(!empty($data['name_company_real']))
            {
                $name_order_history_pending = upper_firstchar($data['name_company_real']);
            }
            else
            {
                $name_order_history_pending = upper_firstchar($data['name_real']).' '.upper_firstchar(substr($data['name_real'], 0 , 1)).'.';
            }

            switch($data['type_real'])
            {
                case 'reseller':
                    $type_order_history_pending = 'Revendeur';
                    break;
                case 'public':
                    $type_order_history_pending = 'Particulier';
                    break;
                case 'admin':
                    $type_order_history_pending = 'Administrateur';
                    break;
            }

            $timestamp = converto_timestamp($data['date_payment_order_history']);

?>
                    <td <?php echo($style_order_history_pending); ?> align="center">
                        <span id="center_text"><?php echo($data['number_order_history']); ?></span>
                    </td>
                    <td <?php echo($style_order_history_pending); ?>>
                        <span id="center_text" style="margin-left: 4px;"><?php echo($name_order_history_pending); ?></span>
                    </td>
                    <td <?php echo($style_order_history_pending); ?>>
                        <span id="center_text" style="margin-left: 4px;"><?php echo($type_order_history_pending); ?></span>
                    </td>
                    <td <?php echo($style_order_history_pending); ?> align="right">
                        <span id="center_text" style="margin-right: 4px;"><?php echo(number_format($data['amount_order_history'], 2, '.', '').' €'); ?></span>
                    </td>           
                    <td <?php echo($style_order_history_pending); ?> align="center">
                        <span id="center_text" style="margin-left: 4px;"><?php echo(date('d/m/Y', $timestamp)); ?></span>
                    </td> 
                    <td <?php echo($style_order_history_pending); ?> align="center">
                        <span id="center_text" style="margin-left: 4px;">
                            <SELECT name="cboOrderClosedStatus<?php echo($data['id_order_history']) ?>" onchange="OnChange('bt_change_order_closed_status<?php echo($data['id_order_history']) ?>')">
                                <option value="onhold" <?php if($data['status_order_history'] == 'onhold'){ echo('selected'); }else{ echo(null); } ?>>En attente</option>
                                <option value="transferred" <?php if($data['status_order_history'] == 'transferred'){ echo('selected'); }else{ echo(null); } ?>>Transféré</option>
                                <option value="paid" <?php if($data['status_order_history'] == 'paid'){ echo('selected'); }else{ echo(null); } ?>>Payé</option>
                                <option value="delivered" <?php if($data['status_order_history'] == 'delivered'){ echo('selected'); }else{ echo(null); } ?>>Livré</option>
                                <option value="cancelled" <?php if($data['status_order_history'] == 'cancelled'){ echo('selected'); }else{ echo(null); } ?>>Annulé</option>
                            </SELECT>
                            <input id="bt_change_order_closed_status<?php echo($data['id_order_history']) ?>" hidden style="display: none;" type="submit" name="bt_change_order_closed_status<?php echo($data['id_order_history']) ?>" value="Choix Statut"></input> 
                        </span>
                    </td> 

                    <tr></tr>

<?php
        }
        $query->closeCursor();
    }
    catch(Exception $e)
    {
        die('<br>Error: '.$e->getMessage());
    }
}
else
{
?>
<td>
    <TABLE width="100%" cellpadding="0" cellspacing="0">

        <td colspan="6">
            <!--[if !IE]>--><a style="text-decoration: none;" href="<?php echo($_SESSION['index'].'?page='.$_SESSION['redirect'].'&expandord=true'); ?>"><!--<![endif]-->
            <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0"> 
                <td>
                    <!--[if IE]><a style="text-decoration: none;" href="<?php echo($_SESSION['index'].'?page='.$_SESSION['redirect'].'&expandord=true'); ?>"><![endif]-->
                    <image src="graphics/icons/plus16x16.png" alt="expand" title="Afficher"></image>
                    <!--[if IE]></a><![endif]-->
                </td>
                <td width="100%">
                    <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">
                        <?php

                        echo('Commandes clôturées ('.$count_order_history_closed.') pour un montant total de '.$total_amount_order_history_closed.'&nbsp€ TTC');

                        if(count($id_user_stats_main) > 0)
                        {
                            //echo(' (depuis le '.date('d/m/Y \à H:i', $date_stats_main[(count($id_user_stats_main) - 1)]).')'); 
                            echo(' (depuis le '.$start_date.')'); 
                        }
?>

                    </span>
                </td>
            </TABLE>
            <!--[if !IE]>--></a><!--<![endif]-->
        </td>
<?php
}
?>
                    

    </TABLE>
</td>
