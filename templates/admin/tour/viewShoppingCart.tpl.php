<?=boxHeader(array('title'=>lang('viewCartContent.tour.title')))?>
	<? //print_r($out);?>
	<tr> 
		<form name="shoppingCart" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>"/>
		<input type="hidden" name="actionMode" value="order" />
		<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
		<!-- <input type="hidden" name="TourCartItemType" value="order"/> -->
		<td valign="top" bgcolor="#ffffff" align="left" class="subtitle">
		<?=lang('ShoppingCartTips.tour.tip','html')?>
		<br/><br/>
			<table width="100%"  border="0" cellspacing="1" cellpadding="3" bgcolor="#eeeeee">
  			  <tr>
				<td colspan="2" align="center" bgcolor="#EEEEEE" class="subtitle"><?=lang('GeneralInformationCart.tour.tip')?></td>
			  </tr>
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrderDepartureDate.tour.tip')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderDeparture'],'Date')?>
				</td>
			  </tr>
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrderReturnDate.tour.tip')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderReturn'],'Date')?>
				</td>
			  </tr>
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.FlightFromTo')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderFlightFromTo']?>
				</td>
			  </tr>
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderTransfers')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getReferenceValue('YesNo',$out['DB']['TourOrder'][0]['TourOrderTransfers'])?>
				</td>
			  </tr>	
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderNumberOfAdults')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderNumberOfAdults']?>
				</td>
			  </tr>		
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderNumberOfChildren')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderNumberOfChildren']?>
				</td>
			  </tr>		
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderAgeOfChildren')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderAgeOfChildren']?>
				</td>
			  </tr>		
			  </table>
			<table width="100%"  border="0" cellspacing="1" cellpadding="3" bgcolor="#eeeeee">
  			  <tr>
				<td colspan="2" align="center" bgcolor="#EEEEEE" class="subtitle"><?=lang('ProductsInCart.tour.tip')?></td>
			  </tr>
				<? if(is_array($out['DB']['TourOrderItem'])){ $i=0; foreach($out['DB']['TourOrderItem'] as $id=>$row) { ?>
				<input type="hidden" name="TourCartItem<?=DTR?>TourCartItemID[]" value="<?=$row['TourCartItemID']?>" />
				<tr>
					<td valign="top" bgcolor="#ffffff" width="10%">
						<a href="javascript://" onClick="popup('<?=setting('url')?>product/TourID/<?=$row['TourID']?>/windowMode/popup/')" class="subtitle">
							<img src="<?=setting('urlfiles').$row['TourIcon']?>" border="0" />
						</a>
					</td>	
					<td valign="top" bgcolor="#ffffff" width="55%">
						
						<b>[<?=getListValue($out['DB']['TourTypes'],$row['TourType'],array('id'=>'TourTypeAlias','value'=>'TourTypeName'))?>] [<?=lang($row['TourTitle'])?>] [<?=getListValue($out['DB']['Countries'],$row['TourCountryID'],array('id'=>'RegionID','value'=>'RegionName'))?>]</b>
						<br/>
						<?=lang('TourOrderItemDepartureDate.tour.tip')?>:
						<br/>
						<?=getFormated($row['TourOrderItemDeparture'],'Date')?>
						<br/>
						<?=lang('TourOrderItem.TourOrderItemMessage')?>:
						<br/>
						<?=$row['TourOrderItemMessage']?>
					</td>
					<td valign="top" bgcolor="#ffffff" width="35%">
						<?=showTourExtraFieldForCartValue('TourAvailableRoomsValue1',$out,$i)?>
						<br/><br/>
						<?=showTourExtraFieldForCartValue('TourAvailableBoardValue1',$out,$i)?>
					</td>
				</tr>	
			<?  $i++; } } ?>				  
			</table>		
			<table width="100%"  border="0" cellspacing="1" cellpadding="3" bgcolor="#eeeeee">
  			  <tr>
				<td colspan="2" align="center" bgcolor="#EEEEEE" class="subtitle"><?=lang('ContactDetailsCart.tour.tip')?></td>
			  </tr> 
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderFullName')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderFullName']?>
				</td>
			  </tr>
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderEmail')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderEmail']?>
				</td>
			  </tr>
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderCountry')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderCountry']?>
				</td>
			  </tr>
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderAddress')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderAddress']?>
				</td>
			  </tr>
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderPostCode')?>/<?=lang('TourOrder.TourOrderCity')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderPostCode']?>&nbsp;<?=$out['DB']['TourOrder']['TourOrderCity']?>
				</td>
			  </tr>
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderPhone')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderPhone']?>
				</td>
			  </tr>
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderICQ')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderICQ']?>
				</td>
			  </tr>
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderSkype')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderSkype']?>
				</td>
			  </tr>
			  <tr>
				<td width="251" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderMessage')?></td>
				<td width="359" class="subtitle" bgcolor="#ffffff">
					<?=$out['DB']['TourOrder'][0]['TourOrderMessage']?>
				</td>
			  </tr>
			  <!-- <tr>
			  	<td colspan="2">
					<input type="button" name="goCheckout" value="<?=lang('-continue')?>" onClick="" />&nbsp;&nbsp;<input type="submit" name="goChange" value="<?=lang('-order')?>" />
				</td>
			  </tr> -->
			  </table>			
		</td> 
		</form>
	</tr> 
<?=boxFooter()?>