<?=boxHeader(array('title'=>lang('ResourceOrder.resource.title')))?>
		<!-- <form name="orderForm" method="post">
		<input type="hidden" name="SID" value="manageOrder"/>
		<input type="hidden" name="actionMode" value="save"/>
		<input type="hidden" name="ResourceOrderID" value="<?= input('ResourceOrderID')?>" /> -->
		<tr>
		<td bgcolor="#ffffff">
			<table width="100%">
				<tr> 
					<td valign="top" class="row1" width="30%" align="left">
						<?=lang('ResourceOrder.ResourceOrderFirstName')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderFirstName']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderLastName')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderLastName']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderAddress1')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderAddress1']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderCity')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderCity']?></strong>
						<br/>	
						<?=lang('ResourceOrder.ResourceOrderRegion')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderRegion']?></strong>
						<br/>				
						<?=lang('ResourceOrder.ResourceOrderPostCode')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderPostCode']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderPhone')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderPhone']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderEmail')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderEmail']?></strong>
						<br/>
					</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
					<td valign="top" class="row1" width="30%" align="left">
						<?=lang('ResourceOrder.ResourceOrderBillingFirstName')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderBillingFirstName']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderBillingLastName')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderBillingLastName']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderBillingAddress')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderBillingAddress']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderBillingCity')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderBillingCity']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderBillingRegion')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderBillingRegion']?></strong>
						<br/>				
						<?=lang('ResourceOrder.ResourceOrderBillingCountry')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderBillingCountry']?></strong>
						<br/>				
						<?=lang('ResourceOrder.ResourceOrderBillingPostCode')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderBillingPostCode']?></strong>
						<br/>
						<?=lang('ResourceOrder.ResourceOrderBillingPhone')?>:<br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderBillingPhone']?></strong>
					</td>
					</tr>
					<tr>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr> 
					<td  class="row1" align="left" nowrap>
						<!-- <b><?=lang('OrderTotal.resource.tip')?></b><br> -->
						<?=lang('NumberOfProducts.resource.tip')?><br>
						<strong><?=$out['DB']['ResourceOrder'][0]['NumberOfProducts']?></strong><br>
						<?=lang('OrderWeight.resource.tip')?><br>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderWeight']?></strong><br>
						<?=lang('OrderVolume.resource.tip')?><br>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderVolume']?></strong><br>
						<?=lang('DeliveryTime.resource.tip')?><br>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceDeliveryTime']?></strong><br>
						<?=lang('DeliveryBy.resource.tip')?><br>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceDeliveryBy']?></strong><br>
						<?=lang('OrderAmount.resource.tip')?><br>
						<strong><?=getFormated($out['DB']['ResourceOrder'][0]['ResourceOrderAmount'],'Money')?></strong><br>
						<?=lang('OrderShippingAmount.resource.tip')?><br>
						<strong><?=getFormated($out['DB']['ResourceOrder'][0]['ResourceOrderShippingAmount'],'Money')?></strong><br>
						<?=lang('OrderDiscountAmount.resource.tip')?><br>
						<strong><?=getFormated($out['DB']['ResourceOrder'][0]['ResourceOrderDiscountAmount'],'Money')?></strong><br>
						<?=lang('OrderTaxesAmount.resource.tip')?><br>
						<strong><?=getFormated($out['DB']['ResourceOrder'][0]['ResourceOrderTaxesAmount'],'Money')?></strong><br>
						<?=lang('OrderTotalAmount.resource.tip')?><br>
						<strong><?=getFormated($out['DB']['ResourceOrder'][0]['ResourceOrderTotalAmount'],'Money')?></strong><br>
					</td>
				</tr>
				<tr> 
					<td colspan="3" valign="top" class="row1" align="left">
						<strong><?=lang('Message')?>:</strong><br/>
						<strong><?=$out['DB']['ResourceOrder'][0]['ResourceOrderMessage']?></strong>
					</td> 
				</tr>	
				<tr> 
					<td colspan="3" valign="top" class="row1" align="left">
						<strong><?=lang('DeliveryDate')?>:</strong><br/>
						<?=getFormated(input('ResourceOrder'.DTR.'ResourceOrderDeliveryDate'),'Date')?>
					</td> 
				</tr>		
				<tr> 
					<td colspan="3" valign="top"  class="row1" align="left">
						<b><?=lang('OrderPaymentMethod.resource.tip')?>:</b><br/>
						<?=$out['DB']['ResourceOrder'][0]['ResourceOrderBillingEmail']?>
					</td> 
				</tr>
			</table>
			<br><br>
			<div align="center"><strong><?=lang('Resources')?></strong></div>
			<br><br>
			<table width="100%">
				<? if(!empty($out['DB']['ResourceOrderItem'])){ foreach($out['DB']['ResourceOrderItem'] as $id=>$row){?>
				<tr>
					<td valign="top"  class="row1" align="left" width="5%">
						<? if(!empty($out['DB']['Resource']['ResourceImagePreview'])) { ?>
							<img src="<?= setting('urlfiles').$row['ResourceIcon']?>" border=0 alt="">
						<? } else { ?>
							<img src="<?=setting('urlfiles').setting('NoImageIcon')?>" border="0" />
						<? } ?>
					</td>
					<td valign="center" class="row1" align="left">
						<?=getValue($row['ResourceTitle']);?>
					</td>
					<td valign="center" nowrap class="row1" align="center" width="5%">
						<?=getFormated($row['ResourceOrderItemPrice'],'Money')?>
					</td>
					<td valign="center"  class="row1" align="center" width="5%">
						<?=$row['ResourceOrderItemQuantity']?>
					</td>
				</tr>
				<? }}?>
			</table>		
			</td>	
		</tr>									
	<!-- </form> -->
<?=boxFooter()?>