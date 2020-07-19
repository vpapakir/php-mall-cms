<tr>
    <td align="left"><form method="post"><table width="100%" cellpadding="0" cellspacing="0">
<?php
	$prepared_query = 'SELECT * FROM config_module';
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
	$query = $connectData->prepare($prepared_query);
	$query->execute();
	while(($data = $query->fetch()) != false)
	{
		if($data['immo_module'] == 1) { // select to include the appropriate module file
			include('modules/custom/'.$data['name_configmodule'].'/modules/box/search/offer.php');
		}
	}
?>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
<?php
	$prepared_query = 'SELECT * FROM config_module';
	if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
	$query = $connectData->prepare($prepared_query);
	$query->execute();
	while(($data = $query->fetch()) != false)
	{
		if($data['immo_module'] == 1) { // select to include the appropriate module file
			include('modules/custom/'.$data['name_configmodule'].'/modules/box/search/price.php');
		}
	}
?>
        <tr>
            <td colspan="2" style="border-top: 1px solid lightgrey;" align="center">
                <table width="100%" cellpadding="1" cellspacing="1" style="margin: 4px 0px 4px 0px;">
                    <tr>
                        <td align="center">
                            <input type="submit" name="bt_box_quicksearch" value="<?php give_translation('main.bt_search', $echo, $config_showtranslationcode); ?>"/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table></form></td>   
</tr>


