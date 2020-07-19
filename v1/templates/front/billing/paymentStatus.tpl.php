<? // boxHeader(array('title'=>lang('PaymentForm.billing.title')))?>
<?
	$OrderCreatorID = $params['OrderCreatorID'];
?>
	<tr> 
		<td valign="top" bgcolor="#ffffff" align="center" class="subtitle">
			<?=getValue($out['DB']['PaymentMethod']['PaymentMethodDescription'])?>
			
			<br/><br/>
			<?=lang('TotalForPayment.billing.tip')?> : <?=getFormated($out['DB']['BillingOrder']['OrderAmount'],'Money');?>
		</td> 
	</tr>
<? // boxFooter()?>
