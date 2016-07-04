<?=boxHeader(array('title'=>'viewCategoriesBox.tip.resource'))?>
		<tr> 
			<td valign="top" bgcolor="#ffffff">
				Please select the country where you want your order to be delivered. Delivery is only possible to listed countries. We need this information to calculate shipping fees.
			</td> 
		</tr> 
		<tr> 
			<td valign="top" bgcolor="#eeeeee" align="center">
			<form method="post" name="selectCountry">
				Country:
				<br/>
<?=$out['Refs']['Regions']?>
						<br/>				
						</form>
				If you select &quot;Just visit the site&quot; you will not be able to open the order form
			</td> 
		</tr>		
		<tr> 
			<td valign="top" bgcolor="#ffffff">
One you decide to order you will need to fill in a form giving the following information:

1. Your address and contact details
2. The address of delivery if different
3. The mode of payment you desire

You can pay by credit card, PayPal, bank transfer or check
			</td> 
		</tr>		
<?=boxFooter()?>