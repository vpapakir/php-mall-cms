<select name="cboObjectOrderSaleSearch">
    <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Infos generales">
        <option value="RAND()"
            <?php if(empty($_SESSION['SaleSearch_cboObjectOrderSaleSearch']) || $_SESSION['SaleSearch_cboObjectOrderSaleSearch'] == 'RAND()'){ echo('selected="selected"'); }else{ echo(null); } ?>
                ><?php give_translation('immo.searchproperty_dd_optionorder_random', $echo, $config_showtranslationcode); ?></option>
<?php

try
{
    //$prepared_query = 'SHOW COLUMNS FROM immo_product';
	$prepared_query = 'SHOW COLUMNS FROM product';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;

    $salesearch_array_orderobject = array(
                                          0 => 7,
                                          1 => 4,
                                          2 => 6,
                                          3 => 47,
                                          4 => 12,
                                          5 => 13,
                                          6 => 18,
                                          7 => 19,
                                          8 => 20,
                                          9 => 23,
                                          10 => 43,
                                          11 => 44
                                          );
    while($data = $query->fetch())
    {
        $salesearch_name_orderobject[$i] = $data[0];
        $i++;
    }
    $query->closeCursor();

    $y = 0;
    for($i = 0, $count = count($salesearch_name_orderobject); $i < $count; $i++)
    {
        if($i == $salesearch_array_orderobject[$y])
        {
?>
            <option value="<?php echo($salesearch_name_orderobject[$i]); ?>" style="background-color: white;"
                <?php if(!empty($_SESSION['SaleSearch_cboObjectOrderSaleSearch']) && $_SESSION['SaleSearch_cboObjectOrderSaleSearch'] == $salesearch_name_orderobject[$i]){ echo('selected="selected"'); }else{ echo(null); } ?>
                    ><?php give_translation('displayvalueimmo.'.$salesearch_name_orderobject[$i]); ?></option>                               
<?php     
            $y++;

            if($y < count($salesearch_array_orderobject))
            {
                $i = 0;
            }
        }
    }
?>
    </optgroup>
    <optgroup style="background-color: lightgray; color: black; font-style: normal; font-weight: normal;" label="Options">
<?php
    $prepared_query = 'SELECT id_cdreditor, L'.$main_id_language.'S FROM cdreditor
                       WHERE code_cdreditor = "cdreditor_comdetails_admin"
                       AND statusobject_cdreditor = 1
                       ORDER BY position_cdreditor, L'.$main_id_language.'S';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();

    while($data = $query->fetch())
    {
?>
            <option value="comdetails_product_immo<?php echo($data[0]); ?>" style="background-color: white;"
                <?php if(!empty($_SESSION['SaleSearch_cboObjectOrderSaleSearch']) && $_SESSION['SaleSearch_cboObjectOrderSaleSearch'] == 'comdetails_product_immo'.$data[0]){ echo('selected="selected"'); }else{ echo(null); } ?>
                    ><?php echo($data[1]); ?></option>                               
<?php                                
    }
    $query->closeCursor();
?>
    </optgroup>
<?php                            

}
catch (Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
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
</select>
&nbsp;
<select name="cboTypeOrderSaleSearch">
    <option value="ASC"
        <?php if(empty($_SESSION['SaleSearch_cboTypeOrderSaleSearch']) || $_SESSION['SaleSearch_cboTypeOrderSaleSearch'] == 'ASC'){ echo('selected="selected"'); }else{ echo(null); } ?>
            ><?php give_translation('immo.searchproperty_dd_typeorder_asc', $echo, $config_showtranslationcode); ?></option>
    <option value="DESC"
        <?php if(!empty($_SESSION['SaleSearch_cboTypeOrderSaleSearch']) && $_SESSION['SaleSearch_cboTypeOrderSaleSearch'] == 'DESC'){ echo('selected="selected"'); }else{ echo(null); } ?>
            ><?php give_translation('immo.searchproperty_dd_typeorder_desc', $echo, $config_showtranslationcode); ?></option>
</select>
&nbsp;
<select name="cboNrPageOrderSaleSearch">
    <option value="5"
        <?php if(!empty($_SESSION['SaleSearch_cboNrPageOrderSaleSearch']) && $_SESSION['SaleSearch_cboNrPageOrderSaleSearch'] == 2){ echo('selected="selected"'); }else{ echo(null); } ?>
            ><?php give_translation('immo.searchproperty_dd_pageorder_5', $echo, $config_showtranslationcode); ?></option>
    <option value="10"
        <?php if(!empty($_SESSION['SaleSearch_cboNrPageOrderSaleSearch']) && $_SESSION['SaleSearch_cboNrPageOrderSaleSearch'] == 10){ echo('selected="selected"'); }else{ echo(null); } ?>
            ><?php give_translation('immo.searchproperty_dd_pageorder_10', $echo, $config_showtranslationcode); ?></option>
    <option value="25"
        <?php if(empty($_SESSION['SaleSearch_cboNrPageOrderSaleSearch']) || $_SESSION['SaleSearch_cboNrPageOrderSaleSearch'] == 25){ echo('selected="selected"'); }else{ echo(null); } ?>
            ><?php give_translation('immo.searchproperty_dd_pageorder_25', $echo, $config_showtranslationcode); ?></option>
    <option value="50"
        <?php if(!empty($_SESSION['SaleSearch_cboNrPageOrderSaleSearch']) && $_SESSION['SaleSearch_cboNrPageOrderSaleSearch'] == 50){ echo('selected="selected"'); }else{ echo(null); } ?>
            ><?php give_translation('immo.searchproperty_dd_pageorder_50', $echo, $config_showtranslationcode); ?></option>
    <option value="100"
        <?php if(!empty($_SESSION['SaleSearch_cboNrPageOrderSaleSearch']) && $_SESSION['SaleSearch_cboNrPageOrderSaleSearch'] == 100){ echo('selected="selected"'); }else{ echo(null); } ?>
            ><?php give_translation('immo.searchproperty_dd_pageorder_100', $echo, $config_showtranslationcode); ?></option>
</select>
&nbsp;
<input type="submit" name="bt_productsearch" value="Ok"/>
