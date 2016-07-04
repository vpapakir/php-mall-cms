<?=boxHeader(array('title'=>lang('TourOrder.tour.title')))?>
		<form name="orderForm" method="post">
		<input type="hidden" name="SID" value="manageOrder"/>
		<input type="hidden" name="actionMode" value="save"/>
		<input type="hidden" name="TourOrderID" value="<?= input('TourOrderID')?>" />
		<tr>
		<td bgcolor="#ffffff">
			<table width="100%">
				<tr>
					<td valign="top">
						<?=getReference('TourOrderPaymentStatus','TourOrder'.DTR.'TourOrderPaymentStatus',$out['DB']['TourOrder'][0]['TourOrderPaymentStatus'],array('code'=>'Y'))?>
					</td>
					<td valign="top">
						<?=getReference('TourOrderStatus','TourOrder'.DTR.'TourOrderStatus',$out['DB']['TourOrder'][0]['TourOrderStatus'],array('code'=>'Y'))?>
					</td>
					<td align="center">
						<input type="submit" name="Save" value="<?=lang('-Save')?>" />
					</td>
				</tr>
				<tr> 
					<td valign="top" class="row1" width="30%" align="left">
						<?=lang('TourOrder.TourOrderFirstName')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderFirstName']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderLastName')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderLastName']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderAddress1')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderAddress1']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderCity')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderCity']?></strong>
						<br/>	
						<?=lang('TourOrder.TourOrderRegion')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderRegion']?></strong>
						<br/>				
						<?=lang('TourOrder.TourOrderPostCode')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderPostCode']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderPhone')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderPhone']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderEmail')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderEmail']?></strong>
						<br/>
					</td> 
					<td valign="top" class="row1" width="30%" align="left">
						<?=lang('TourOrder.TourOrderBillingFirstName')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderBillingFirstName']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderBillingLastName')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderBillingLastName']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderBillingAddress')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderBillingAddress']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderBillingCity')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderBillingCity']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderBillingRegion')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderBillingRegion']?></strong>
						<br/>				
						<?=lang('TourOrder.TourOrderBillingCountry')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderBillingCountry']?></strong>
						<br/>				
						<?=lang('TourOrder.TourOrderBillingPostCode')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderBillingPostCode']?></strong>
						<br/>
						<?=lang('TourOrder.TourOrderBillingPhone')?>:<br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderBillingPhone']?></strong>
					</td>
					<td  class="row1" align="left" nowrap>
						<!-- <b><?=lang('OrderTotal.tour.tip')?></b><br> -->
						<?=lang('NumberOfProducts.tour.tip')?><br>
						<strong><?=$out['DB']['TourOrder'][0]['NumberOfProducts']?></strong><br>
						<?=lang('OrderWeight.tour.tip')?><br>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderWeight']?></strong><br>
						<?=lang('OrderVolume.tour.tip')?><br>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderVolume']?></strong><br>
						<?=lang('DeliveryTime.tour.tip')?><br>
						<strong><?=$out['DB']['TourOrder'][0]['TourDeliveryTime']?></strong><br>
						<?=lang('DeliveryBy.tour.tip')?><br>
						<strong><?=$out['DB']['TourOrder'][0]['TourDeliveryBy']?></strong><br>
						<?=lang('OrderAmount.tour.tip')?><br>
						<strong><?=getFormated($out['DB']['TourOrder'][0]['TourOrderAmount'],'Money')?></strong><br>
						<?=lang('OrderShippingAmount.tour.tip')?><br>
						<strong><?=getFormated($out['DB']['TourOrder'][0]['TourOrderShippingAmount'],'Money')?></strong><br>
						<?=lang('OrderDiscountAmount.tour.tip')?><br>
						<strong><?=getFormated($out['DB']['TourOrder'][0]['TourOrderDiscountAmount'],'Money')?></strong><br>
						<?=lang('OrderTaxesAmount.tour.tip')?><br>
						<strong><?=getFormated($out['DB']['TourOrder'][0]['TourOrderTaxesAmount'],'Money')?></strong><br>
						<?=lang('OrderTotalAmount.tour.tip')?><br>
						<strong><?=getFormated($out['DB']['TourOrder'][0]['TourOrderTotalAmount'],'Money')?></strong><br>
					</td>
				</tr>
				<tr> 
					<td colspan="3" valign="top" class="row1" align="left">
						<strong><?=lang('Message')?>:</strong><br/>
						<strong><?=$out['DB']['TourOrder'][0]['TourOrderMessage']?></strong>
					</td> 
				</tr>	
				<tr> 
					<td colspan="3" valign="top" class="row1" align="left">
						<strong><?=lang('DeliveryDate')?>:</strong><br/>
						<?=getFormated(input('TourOrder'.DTR.'TourOrderDeliveryDate'),'Date')?>
					</td> 
				</tr>		
				<tr> 
					<td colspan="3" valign="top"  class="row1" align="left">
						<b><?=lang('OrderPaymentMethod.tour.tip')?>:</b><br/>
						<?=$out['DB']['TourOrder'][0]['TourOrderBillingEmail']?>
					</td> 
				</tr>
			</table>
			<br><br>
			<div align="center"><strong><?=lang('Tours')?></strong></div>
			<br><br>
			<table width="100%">
				<? if(!empty($out['DB']['TourOrderItem'])){ foreach($out['DB']['TourOrderItem'] as $id=>$row){?>
				<tr>
					<td valign="top"  class="row1" align="left" width="5%">
						<img src="<?= setting('urlfiles').$row['TourIcon']?>" border=0 width=30 height=30 alt="">
					</td>
					<td valign="center" class="row1" align="left">
						&nbsp;<a href="<?=setting('url')?>manageTour/TourID/<?=$row['TourID']?>"><?=getValue($row['TourTitle']);?></a>
					</td>
					<td valign="center" nowrap class="row1" align="center" width="5%">
						<?=getFormated($row['TourOrderItemPrice'],'Money')?>
					</td>
					<td valign="center"  class="row1" align="center" width="5%">
						<?=$row['TourOrderItemQuantity']?>
					</td>
				</tr>
				<? }}?>
			</table>		
			</td>	
		</tr>									
	</form>
<?=boxFooter()?>