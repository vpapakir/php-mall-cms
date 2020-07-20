<table border="0" cellpadding="0" cellspacing="0">
    <tr>
<?php 
try
{
    $prepared_query = 'SELECT COUNT(id_currency) FROM currency
                       WHERE status_currency = 1';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    if(($data = $query->fetch()) != false)
    {
        $available_currency = $data[0]; 
    }
    $query->closeCursor();
    
    if($available_currency > 1)
    {
        $prepared_query = 'SELECT * FROM currency
                           INNER JOIN currency_image
                           ON currency.id_currency = currency_image.id_currency
                           WHERE status_currency = 1
                           AND status_image = 9
                           ORDER BY position_currency ASC';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute();

        $i = 1;

        while($data = $query->fetch())
        {
?>  
            <td>
                <a href="<?php echo($config_customheader.$_SESSION['index'].'?page='.$_SESSION['current_page']); ?>&amp;currency=<?php echo($data[0]); ?>" ><img id="flagcurrency<?php echo($i); ?>" style="margin-left: 3px; border: none;" <?php if(!empty($main_id_currency) && $main_id_currency != $data['id_currency']){ ?> src="<?php echo($config_customheader.$data['paththumb_image']); ?>" alt="<?php echo($data['alt_image']); ?>" <?php }else{ ?> src="<?php echo($config_customheader.str_replace('disabled', 'activated', $data['paththumb_image'])); ?>" <?php } ?> title="<?php echo($data['title_image']); ?>" <?php if(!empty($main_id_currency) && $main_id_currency != $data['id_currency']){ ?>onmouseover="langimage('flagcurrency<?php echo($i); ?>', '<?php echo($config_customheader.str_replace('disabled', 'activated', $data['paththumb_image'])); ?>')" onmouseout="langimage('flagcurrency<?php echo($i); ?>', '<?php echo($config_customheader.$data['paththumb_image']); ?>')" <?php } ?>></img></a> 
            </td>  
<?php
            if($i == $available_currency)
            { 
?>
                <td><div style="margin-right: <?php if(isset($marginr_logo)) { echo($marginr_logo); } else {echo "5"; } ?>px;"></div></td>
<?php                    
            }    

            $i++;
        }
        $query->closeCursor();
    }
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    echo $_SESSION['error400_message'];
    if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
?> 
    </tr>
</table>
