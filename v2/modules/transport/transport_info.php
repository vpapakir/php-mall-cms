<td><TABLE width="100%">
<?php
try
{
    $query = $connectData->prepare('SELECT * FROM shipping_destination');
    $query->execute();

    $i = 0;

    while($data = $query->fetch())
    {
        $name_destination[$i] = $data[1];
        $id_destination[$i] = $data[0];
        $i++;
    }
    $query->closeCursor();
    
    for($i = 0; $i < count($name_destination); $i++)
    {
        $query = $connectData->prepare('SELECT * FROM shipping_special
                                        WHERE id_destination_shipping = :id');
        $query->bindParam('id', htmlspecialchars($id_destination[$i], ENT_QUOTES));
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
             $BoK_shipping_special = true;
             $description_special = $data['description_special_shipping'];
             $type_special = $data['type_special_shipping'];
             $value_special = $data['value_special_shipping'];
        }
        else
        {
             $BoK_shipping_special = false;
        }
        $query->closeCursor();
    ?>
        <td align="center"><TABLE width="100%" border="0" style="border: 1px solid cornflowerblue; padding: 3px; border-radius: 6px;">

        <td colspan="4" align="center">
            <div id="<?php echo($block_frontend_approach_result); ?>"><span id="<?php echo($text_frontend_approach_result); ?>"><?php echo($name_destination[$i]); ?></span></div>
        </td>

        <tr></tr>

        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Tranche</span></div></td>
        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">De (kilogramme)</span></div></td>
        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">A (kilogramme)</span></div></td>
        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Tarif T.T.C.</span></div></td>

        <tr></tr>
    <?php
        $query = $connectData->prepare('SELECT * FROM shipping
                                        WHERE id_destination_shipping = :id
                                        ORDER BY min_shipping');
        $query->bindParam('id', htmlspecialchars($id_destination[$i], ENT_QUOTES));
        $query->execute();


        $Bok_background = false;

        while($data = $query->fetch())
        {
            if($Bok_background == true)
            {
                $style = 'background-color: lightgray;';
                $Bok_background = false;
            }
            else
            {
                $style = null; 
                $Bok_background = true;
            }


            ?> 
                <td style="<?php echo($style); ?>">
                    <span style="margin-left: 6px;" id="center_text"><?php echo(upper_firstchar($data['part_shipping'])); ?></span>
                </td>                      
                <td align="right" style="<?php echo($style); ?>">
                    <span style="margin-right: 50px;" id="center_text"><?php echo(convert_to_kilo($data['min_shipping'])); ?></span>
                </td>
                <td align="right" style="<?php echo($style); ?>">
                    <span style="margin-right: 50px;" id="center_text"><?php echo(convert_to_kilo($data['max_shipping'])); ?></span>
                </td>
                <td align="right" style="<?php echo($style); ?>">
                    <span style="margin-right: 6px;" id="center_text"><?php echo(number_format($data['fee_shipping'], 2).' €'); ?></span>
                </td>

                <tr></tr>
            <?php
        }
        $query->closeCursor();
        
        if($BoK_shipping_special === true)
        {
            if($type_special == 'freeshippingEuro')
            {
                $suffix_special = ' €';
                $number_format = 2;
            }
            else
            {
                if($type_special == 'freeshippingKilo')
                {
                   $suffix_special = ' kg'; 
                   $number_format = 4;
                }
                else
                {
                   $suffix_special = null;
                   $number_format = 0;
                }

            }
?>
<!--                <td style="<?php //echo($style); ?>">
                    <span style="margin-left: 6px;" id="center_text">Tranche spéciale</span>
                </td>
                <td align="center" style="<?php //echo($style); ?>" colspan="2">
                    <span id="center_text"><?php //echo(upper_firstchar($description_special)); ?></span>
                </td>
                <td align="right" style="<?php //echo($style); ?>">
                    <span style="margin-right: 6px;" id="center_text"><?php //echo(number_format($value_special, $number_format, '.', '').$suffix_special); ?></span>
                </td>        -->
<?php
        }
?>
        </td></TABLE>
            
        <tr style="height: 12px;"></tr>
<?php
    }
}
catch (Exception $e)
{
    die("<br>Error : ".$e->getMessage());
}
?>
<!--        <tr></tr>
        <td><?php //echo(var_dump(@$_SESSION['test321'])); ?></td>
        <tr></tr>
        <td><?php //echo(var_dump(@$_SESSION['login_id'])); ?></td>-->
</td></TABLE>
