<?php 
$used_language = $_SESSION['lang'];
$i = 0;
$j = 0;

$Bok_invisible_linecolor = true;

try
{
    $query = $connectData->prepare('SELECT id_product, number_product, 
                                    name_product_'.$used_language.', id_page
                                    FROM product
                                    WHERE status_product = 9
                                    ORDER BY name_product_'.$used_language);
    $query->execute();

    while($data = $query->fetch())
    {
        $invisible_product_id[$i] = $data[0];
        $invisible_product_number[$i] = $data[1];
        $invisible_product_name[$i] = $data[2];
        $invisible_product_id_page[$i] = $data[3];
        $i++;
    }
    $query->closeCursor();
}
catch (Exception $e)
{
    die("<br id=\"msg_wrong\">Error : ".$e->getMessage());
}

$i = 0;


if(isset($_POST['bt_enable_product']))
{
    unset($_SESSION['msg_product_invisible_enabled_part1'], $_SESSION['msg_product_invisible_enabled_part2'], $_SESSION['msg_product_invisible_enabled_part3']);
    $_SESSION['msg_product_invisible_enabled_part1'] = 'Les produits suivants ont été activés:';
    for($i = 0; $i < count($invisible_product_id); $i++)
    {
        $checked_invisible_product = $_POST['chk_invisible_product_'.$invisible_product_id[$i]];
        
        if($checked_invisible_product == true)
        {
            try
            {
                $query = $connectData->prepare('UPDATE product SET status_product = 1
                                                WHERE id_product = :id');
                $query->bindParam('id', htmlspecialchars($invisible_product_id[$i], ENT_QUOTES));
                $query->execute();
                $query->closeCursor();
                
                $query = $connectData->prepare('UPDATE page SET status_page = 1
                                                WHERE id_page = :id');
                $query->bindParam('id', htmlspecialchars($invisible_product_id_page[$i], ENT_QUOTES));
                $query->execute();
                $query->closeCursor();
                
                $_SESSION['msg_product_invisible_enabled_part2'][$j] = $invisible_product_number[$i]; 
                $_SESSION['msg_product_invisible_enabled_part3'][$j] = $invisible_product_name[$i]; 
                $j++;
            }
            catch (Exception $e)
            {
                die("<br id=\"msg_wrong\">Error : ".$e->getMessage());
            }          
        }
    }
    
    header('Location: '.$header.$_SESSION['index'].'?page='.$_SESSION['redirect']);
}

include($backoffice_html_skeleton_part1); ?>

<TABLE width="100%" bgcolor="white">
   <form method="post">
   <td><TABLE width="100%">
        
            <td id="center_title">
                Liste des produits "invisibles"
            </td>
            
        <tr><td><hr></hr></td></tr>
        
            <td align="center">
                <input type="submit" name="bt_enable_product" value="Réactiver la sélection"></input>
            </td>
            
        <tr></tr>
<?php
if(!empty($_SESSION['msg_product_invisible_enabled_part1']))
{
?>
            <td><TABLE width="100%">
                <td colspan="2" align="left">
                    <span id="msg_wrong">
                    <?php 
                    if(!empty($_SESSION['msg_product_invisible_enabled_part1']))
                    { 
                        echo($_SESSION['msg_product_invisible_enabled_part1']);    
                    }
                    else
                    { 
                        echo(null); 
                    } 
                    ?>
                    </span>
                </td>
    <?php 
    if(!empty($_SESSION['msg_product_invisible_enabled_part2']))
    { 
        for($i = 0; $i < count($_SESSION['msg_product_invisible_enabled_part2']); $i++)
        {

    ?>                
                    <tr></tr>
                    <td>
                        <span id="msg_wrong">
                           <?php echo($_SESSION['msg_product_invisible_enabled_part2'][$i]); ?> 
                        </span>
                    </td>
                    <td width="100%">
                        <span id="msg_wrong">
                           <?php echo($_SESSION['msg_product_invisible_enabled_part3'][$i]); ?>  
                        </span>
                    </td>
    <?php
        }
    }
    ?>
            </TABLE></td>
            
        <tr></tr>
<?php
}
?>
            <td><TABLE width="100%">
                    
                    <tr>
                        <td>
                            <span></span>
                        </td>
                        <td align="left">
                            <span id="center_subtitle">Nom produit</span>
                        </td>
                        <td align="center">
                            <span id="center_subtitle">Num. produit</span>
                        </td>
                    </tr>
                    
<?php
for($i = 0; $i < count($invisible_product_id); $i++)
{   
    if($Bok_invisible_linecolor == true)
    {
        $style_invisible = 'style="background-color: lightgray;"';
        $Bok_invisible_linecolor = false;
    }
    else
    {
        $style_invisible = 'style="background-color: none;"';
        $Bok_invisible_linecolor = true;
    }
?>  
                    <tr <?php echo($style_invisible); ?>>
                        <td align="center">
                            <input id="invisible_product_<?php echo($invisible_product_id[$i]); ?>" type="checkbox" name="chk_invisible_product_<?php echo($invisible_product_id[$i]); ?>"></input>
                        </td>
                        <td>
                            <label for="invisible_product_<?php echo($invisible_product_id[$i]); ?>"><span style="cursor: pointer; margin-left: 2px;" id="center_text"><?php echo($invisible_product_name[$i]); ?></span></label>
                        </td>
                        <td align="center">
                            <span id="center_text"><?php echo($invisible_product_number[$i]); ?></span>
                        </td>
                    </tr>
<?php
}
?>                 
            </TABLE></td>
            
        <tr></tr>
            
            <td align="center">
                <input type="submit" name="bt_enable_product" value="Réactiver la sélection"></input>
            </td>
                      
   </TABLE></td>
   </form>
</TABLE>

<?php include($backoffice_html_skeleton_part2); ?>
