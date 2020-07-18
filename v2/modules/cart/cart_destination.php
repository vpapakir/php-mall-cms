<?php
$i = 0;

try
{
   $query = $connectData->prepare('SELECT id_country, code_country, name_country_L1 FROM country
                                   WHERE authorized_shipment = 1
                                   ORDER BY code_country'); 
   
   $query->execute();
   
   while($data = $query->fetch())
   {
       $available_country[$i] = $data[0];
       $i++;
   }
   $query->closeCursor();
}
catch (Exception $e)
{
    die("<br>Error : ".$e->getMessage());
}

if(isset($_POST['bt_save_destination']))
{
    $radio_country = $_POST['rad_shipment_destination'];
    
    try
    {
       if(!empty($_SESSION['login_id']))
       {
           $query = $connectData->prepare('UPDATE user SET id_country = :id
                                           WHERE id_user = :id_user');

           $query->execute(array(
                                 'id' => htmlspecialchars($radio_country, ENT_QUOTES),
                                 'id_user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES)
                                 ));
           
           $query = $connectData->prepare('UPDATE user_real SET id_country = :id
                                           WHERE id_real = :id_user');

           $query->execute(array(
                                 'id' => htmlspecialchars($radio_country, ENT_QUOTES),
                                 'id_user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES)
                                 ));
       }
       else
       {
           $_SESSION['keep_shipment_destination'] = $radio_country;
       }
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
    
    $_SESSION['cart_destination_radio'] = $radio_country;
    
    //header('Location: '.$header.$_SESSION['index'].'?page='.$_SESSION['redirect_after_chosen_destination']);
}

?>

<td><TABLE width="100%" border="0">
        <form method="post">
        <?php
        for($i = 0;$i < count($available_country); $i++)
        {
            $query = $connectData->prepare('SELECT id_country, code_country, name_country_L1 FROM country
                                            WHERE id_country = :id'); 
   
            $query->bindParam('id', htmlspecialchars($available_country[$i], ENT_QUOTES));
            $query->execute();
            
            if(($data = $query->fetch()) != false)
            {
                $name_country = $data[2];
        ?>
                <tr>
                    <td align="center"><label style="margin-left: 5px; cursor: pointer;" for="rad_shipment_destination<?php echo($i); ?>"><div class="<?php echo($shipment_destination) ?>" style="<?php echo($background_color_backoffice_navbar.' '.$border_blocks.' ') ?>width: 200px; cursor: pointer;">
                            <TABLE width="100%" border="0">
                                <td>                     
                                    <input <?php if($i == 0 || !empty($_SESSION['cart_destination_radio']) && $_SESSION['cart_destination_radio'] == $data[0]){ echo('checked'); }else{ echo(null); } ?> id="rad_shipment_destination<?php echo($i); ?>" type="radio" name="rad_shipment_destination" value="<?php echo($data[0]); ?>"></input>                   
                                </td>
                                <td width="100%">
                                    <span id="center_subtitle"><?php echo($name_country.' ('.$data[1].')'); ?></span>                             
                                </td>
                            </TABLE>
                        </div></label></td>
                </tr>
                
                
        <?php
            }
        }
        ?>
        
        <tr></tr>
        
            <td align="center">
                <input type="submit" name="bt_save_destination" value="Valider"></input>
            </td>
<?php
if(isset($_POST['bt_save_destination']))
{
    $radio_country = $_POST['rad_shipment_destination'];
    
    try
    {
           $query = $connectData->prepare('SELECT name_country_L1 FROM country
                                           WHERE id_country = :id');
           $query->bindParam('id', htmlspecialchars($radio_country, ENT_QUOTES));
           $query->execute();
           
           if(($data = $query->fetch()) != false)
           {
               $name_country = $data[0];
           }
           
           //$name_country = upper_firstchar($name_country);
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }
?>
        <tr></tr>
        
            <td align="center">
                <span id="msg_info" style="font-size: 10px">Destination validée vers le pays: <?php echo($name_country); ?>, redirection vers la précédente page...</span>
            </td>
<?php
}              
 ?>
            
        </form>
    </TABLE></td>
    
