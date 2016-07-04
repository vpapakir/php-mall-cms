<?=boxHeader(array('title'=>lang('PaymentForm.billing.title')))?>
<? if(input('actionMode')=='save'){?>
	<tr>
		<td valign="top" bgcolor="#ffffff" align="center">
			<?= lang('ResourceOrderSaved.billing.tip')?><br><br>
			<!--a href="javascript://" onClick="popup('<?= setting('url')?>bill/ResourceOrderID/<?=$out['DB']['ResourceOrderID']?>/windowMode/popup')"><?= lang('ResourceOrderPrintBill.billing.link')?></a-->
			<a href="<?= setting('url')?>myhome"><?= lang('ResourceOrderGoToAccount.billing.link')?></a>
			<br><br>
		</td>
	</tr>
<? }else{?>
		<form name="orderForm" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="order"/>
		<input type="hidden" name="actionMode" value="save" />
		<!-- <input type="hidden" name="windowMode" value="popup" /> -->
		<input type="hidden" name="orderMode" value="direct" />
		<input type="hidden" name="category" value="<?=input('category')?>" />
		<input type="hidden" name="ResourceID" value="<?=input('ResourceID')?>" />
		<input type="hidden" name="ResourceAuthor" value="<?=input('ResourceAuthor')?>" />
		<input type="hidden" name="ResourceOrderItem<?=DTR?>ResourceAuthor" value="<?=input('ResourceAuthor')?>" />
		<input type="hidden" name="ResourceOrderItem<?=DTR?>ResourceLink" value="<?=input('ResourceLink')?>" />
		<input type="hidden" name="ResourceLink" value="<?=input('ResourceLink')?>" />
		<input type="hidden" name="ResourceOrderItem<?=DTR?>ResourceTitle" value="<?=input('ResourceTitle')?>" />
		<input type="hidden" name="ResourceTitle" value="<?=input('ResourceTitle')?>" />
		<input type="hidden" name="ResourceOrderItem<?=DTR?>ResourceOrderItemQuantity" value="1" />
		
	<? if(input('ResourceTitle')) { ?>
		<tr>
			<td valign="top" bgcolor="#ffffff" align="center">
				<?=lang('ResourceOrderItem.ResourceTitle')?>
				<br/><br/>
				<b><?=input('ResourceTitle')?></b>
			</td>
		</tr>		
	<? } ?>
	<? if(!user('UserID')) { ?>
		<tr>
			<td valign="top" bgcolor="#ffffff" align="center">
				<?=lang('OrderLoginTip.billing.tip','html')?>
				<br/><br/>
				<?=lang('Email.session.tip')?>:<br/>
				<input type="text" name="Login" value="<?=input('Login')?>" size="30" />
				<br/>
				<?=lang('Password.session.tip')?>:<br/>
				<input type="password" name="Password" size="30" />
				<br/><br/>
				<input type="button" value="<?=lang('-login')?>" onClick="document.orderForm.actionMode.value='login';submit();">	
			</td>
		</tr>
		<? } ?>
		<tr>
			<td valign="top" bgcolor="#ffffff" align="center">
				<?=lang('OrderMainTip.billing.tip','html')?>
			</td>
		</tr>
		<? 
			if(user('UserID')) {
				$ResourceOrderFirstName = user('FirstName');
				$ResourceOrderLastName = user('LastName');
				$ResourceOrderAddress1 = user('Address');
				$ResourceOrderCity = user('City');
				$ResourceOrderRegion = user('Region');
				$ResourceOrderPostCode = user('PostCode');
				$ResourceOrderPhone = user('Phone');
				$ResourceOrderEmail = user('Email');
				$Country = user('Country');
			} else{
				$ResourceOrderFirstName = input('ResourceOrder'.DTR.'ResourceOrderFirstName');
				$ResourceOrderLastName = input('ResourceOrder'.DTR.'ResourceOrderLastName');
				$ResourceOrderAddress1 = input('ResourceOrder'.DTR.'ResourceOrderAddress1');
				$ResourceOrderCity = input('ResourceOrder'.DTR.'ResourceOrderCity');
				$ResourceOrderRegion = input('ResourceOrder'.DTR.'ResourceOrderRegion');
				$ResourceOrderPostCode = input('ResourceOrder'.DTR.'ResourceOrderPostCode');
				$ResourceOrderPhone = input('ResourceOrder'.DTR.'ResourceOrderPhone');
				$ResourceOrderEmail = input('ResourceOrder'.DTR.'ResourceOrderEmail');
				$Country = $input['ResourceOrder'.DTR.'ResourceOrderCountryID'];
			}
		?>
			<? /*
			<tr> 
				<td valign="top" bgcolor="#ffffff" align="center">
					<?=lang('ResourceOrder.ResourceOrderCountryID')?>:<br/>
					<?
						$options[0]['id']='';	
						$options[0]['value']=lang('ResourceOrderCountrySelect.billing.tip');
						echo getLists($out['DB']['Countries'],$Country,array('name'=>'ResourceOrder'.DTR.'ResourceOrderCountryID','id'=>'RegionID','value'=>'RegionName','style'=>'width:200px;','options'=>$options));	
					?>				
				</td> 
			</tr>
			*/ ?>
			<tr> 
				<td valign="top" bgcolor="#ffffff" align="center">
					<?=lang('ResourceOrder.ResourceOrderFirstName')?>:<br/>
					<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderFirstName" value="<?=$ResourceOrderFirstName?>" size="30" />
					<br/>
					<?=lang('ResourceOrder.ResourceOrderLastName')?>:<br/>
					<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderLastName" value="<?=$ResourceOrderLastName?>" size="30" />
					<br/>
					<? /*
					<?=lang('ResourceOrder.ResourceOrderAddress1')?>:<br/>
					<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderAddress1" value="<?=$ResourceOrderAddress1?>" size="30" />
					<br/>
					<?=lang('ResourceOrder.ResourceOrderCity')?>:<br/>
					<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderCity" value="<?=$ResourceOrderCity?>" size="30" />
					<br/>	
					<?=lang('ResourceOrder.ResourceOrderRegion')?>:<br/>
					<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderRegion" value="<?=$ResourceOrderRegion?>" size="30" />
					<br/>				
					<?=lang('ResourceOrder.ResourceOrderPostCode')?>:<br/>
					<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderPostCode" value="<?=$ResourceOrderPostCode?>" size="30" />
					<br/>
					*/ ?>
					<?=lang('ResourceOrder.ResourceOrderPhone')?>:<br/>
					<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderPhone" value="<?=$ResourceOrderPhone?>" size="30" />
					<br/>
					<?=lang('ResourceOrder.ResourceOrderEmail')?>:<br/>
					<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderEmail" value="<?=$ResourceOrderEmail?>" size="30" />
					<br/>
				</td> 
			</tr>
		<? /*
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<?=lang('OrderBillinAddressTip.billing.tip','html')?>
			</td> 
		</tr>		
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<?=lang('ResourceOrder.ResourceOrderBillingFirstName')?>:<br/>
				<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderBillingFirstName" value="<?=input('ResourceOrder'.DTR.'ResourceOrderBillingFirstName')?>" size="30" />
				<br/>
				<?=lang('ResourceOrder.ResourceOrderBillingLastName')?>:<br/>
				<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderBillingLastName" value="<?=input('ResourceOrder'.DTR.'ResourceOrderBillingLastName')?>" size="30" />
				<br/>
				<?=lang('ResourceOrder.ResourceOrderBillingAddress')?>:<br/>
				<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderBillingAddress" value="<?=input('ResourceOrder'.DTR.'ResourceOrderBillingAddress')?>" size="30" />
				<br/>
				<?=lang('ResourceOrder.ResourceOrderBillingCity')?>:<br/>
				<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderBillingCity" value="<?=input('ResourceOrder'.DTR.'ResourceOrderBillingCity')?>" size="30" />
				<br/>
				<?=lang('ResourceOrder.ResourceOrderBillingRegion')?>:<br/>
				<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderBillingRegion" value="<?=input('ResourceOrder'.DTR.'ResourceOrderBillingRegion')?>" size="30" />
				<br/>				
				<?=lang('ResourceOrder.ResourceOrderBillingCountry')?>:<br/>
				<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderBillingCountry" value="<?=input('ResourceOrder'.DTR.'ResourceOrderBillingCountry')?>" size="30" />
				<br/>				
				<?=lang('ResourceOrder.ResourceOrderBillingPostCode')?>:<br/>
				<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderBillingPostCode" value="<?=input('ResourceOrder'.DTR.'ResourceOrderBillingPostCode')?>" size="30" />
				<br/>
				<?=lang('ResourceOrder.ResourceOrderBillingPhone')?>:<br/>
				<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderBillingPhone" value="<?=input('ResourceOrder'.DTR.'ResourceOrderBillingPhone')?>" size="30" />
			</td> 
		</tr>	
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="left">
				<?=lang('ResourceOrder.ResourceOrderMessage')?>:<br/>
				<div align="center"><textarea name="ResourceOrder<?=DTR?>ResourceOrderMessage" cols="30" rows="5"><?=input('ResourceOrder'.DTR.'ResourceOrderMessage')?></textarea></div>
			</td> 
		</tr>	
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="left">
				<?=lang('ResourceOrder.ResourceOrderDeliveryDate')?>:<br/>
				<div align="center">
				<?=getFormated(input('ResourceOrder'.DTR.'ResourceOrderDeliveryDate'),'Date','form',array('fieldName'=>'ResourceOrder'.DTR.'ResourceOrderDeliveryDate'))?>
				</div>
			</td> 
		</tr>		
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('OrderTotal.billing.tip')?></b>
				<br/><br/>
				<table cellspacing="0" cellpadding="3" border="0" width="100%">
					<tr>
						<td width="70%"><?=lang('NumberOfProducts.billing.tip')?></td>
						<td width="30%"><?=$out['Vars']['OrderTotals']['quantity']?></td>
					</tr>
					<tr>
						<td><?=lang('OrderWeight.billing.tip')?></td>
						<td><?=getFormated($out['Vars']['OrderTotals']['weight'],'Weight')?></td>
					</tr>	
					<tr>
						<td><?=lang('OrderVolume.billing.tip')?></td>
						<td><?=getFormated($out['Vars']['OrderTotals']['volume'],'Volume')?></td>
					</tr>	
					<tr>
						<td><?=lang('DeliveryTime.billing.tip')?></td>
						<td><?=getFormated($out['Vars']['OrderTotals']['delivery'],'DateTime')?></td>
					</tr>	
					<tr>
						<td><?=lang('DeliveryBy.billing.tip')?></td>
						<td><?=$out['Vars']['DeliveryBy']?></td>
					</tr>
					<tr>
						<td><?=lang('OrderAmount.billing.tip')?></td>
						<td><?=getFormated($out['Vars']['OrderTotals']['price'],'Money')?></td>
					</tr>
					<tr>
						<td><?=lang('OrderShippingAmount.billing.tip')?></td>
						<td><?=getFormated($out['Vars']['OrderTotals']['shipping'],'Money')?></td>
					</tr>
					<tr>
						<td><?=lang('OrderDiscountAmount.billing.tip')?></td>
						<td><?=getFormated($out['Vars']['OrderTotals']['discounts'],'Money')?></td>
					</tr>
					<tr>
						<td><?=lang('OrderTaxesAmount.billing.tip')?></td>
						<td><?=getFormated($out['Vars']['OrderTotals']['taxes'],'Money')?></td>
					</tr>	
					<tr>
						<td><b><?=lang('OrderTotalAmount.billing.tip')?></b></td>
						<td><b><?=getFormated($out['Vars']['OrderTotals']['total'],'Money')?></b></td>
					</tr>																																								
				</table>
			</td> 
		</tr>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('OrderPaymentMethod.billing.tip')?></b>
				<br/><br/>
				<input type="text" name="ResourceOrder<?=DTR?>ResourceOrderBillingEmail" value="<?=input('ResourceOrder'.DTR.'ResourceOrderBillingEmail')?>" size="30" />
			</td> 
		</tr>	
		*/ ?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<b><?=lang('ResourceOrderAccessInfoTitle.billing.tip')?></b>
				<br/><br/>
				<?=lang('ResourceOrderAccessInfo.billing.tip')?>
			</td> 
		</tr>			
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<?=lang('ResourceOrderItem.ResourceLocation')?>:<br/>
				<textarea name="ResourceOrderItem<?=DTR?>ResourceLocation" cols="30" rows="3"><?=input('ResourceOrderItem'.DTR.'ResourceLocation')?></textarea>
			</td> 
		</tr>	
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<?=lang('ResourceOrderItem.ResourceIntro')?>:<br/>
				<textarea name="ResourceOrderItem<?=DTR?>ResourceIntro" cols="30" rows="3"><?=input('ResourceOrderItem'.DTR.'ResourceIntro')?></textarea>
			</td> 
		</tr>			
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<?=lang('ResourceOrder.ResourceOrderMessage')?>:<br/>
				<div align="center"><textarea name="ResourceOrder<?=DTR?>ResourceOrderMessage" cols="30" rows="3"><?=input('ResourceOrder'.DTR.'ResourceOrderMessage')?></textarea></div>
			</td> 
		</tr>		
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<!--b><?=lang('OrderTotal.billing.tip')?></b>
				<br/><br/-->
				<table cellspacing="0" cellpadding="3" border="0" width="200">
					<tr>
						<td><b><?=lang('OrderTotalAmount.billing.tip')?></b></td>
						<? if(input('ResourcePrice')) {$out['Vars']['OrderTotals']['total'] = input('ResourcePrice');} else {$out['Vars']['OrderTotals']['total']='50.00';}?>
						<td>
						<input type="hidden" name="ResourceOrderItem<?=DTR?>ResourceOrderItemPrice" value="<?=$out['Vars']['OrderTotals']['total']?>" />
						<b><?=getFormated($out['Vars']['OrderTotals']['total'],'Money')?></b>
						</td>
					</tr>																																								
				</table>
			</td> 
		</tr>
										
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<?=lang('ConfirmOrderTip.billing.tip','html')?>
				<br/><br/>
				<input type="checkbox" name="TermsConfirmation" value="Y"/>&nbsp;<?=lang('-agreeterms')?>
				<br/><br/>
				<input type="submit" name="confirmOrder" value="<?=lang('-confirmorder')?>" />
			</td> 
		</tr> 
		
		</form>
		<script language="JavaScript">
				var fromValidator = new Validator("orderForm");
				fromValidator.addValidation("ResourceOrder<?=DTR?>ResourceOrderFirstName","req","<?=lang('FirstNameOrderWarning.billing.tip')?>");
				fromValidator.addValidation("ResourceOrder<?=DTR?>ResourceOrderLastName","req","<?=lang('LastNameOrderWarning.billing.tip')?>");
				//fromValidator.addValidation("ResourceOrder<?=DTR?>ResourceOrderAddress1","req","<?=lang('AddressOrderWarning.billing.tip')?>");
				//fromValidator.addValidation("ResourceOrder<?=DTR?>ResourceOrderCity","req","<?=lang('CityOrderWarning.billing.tip')?>");
				//fromValidator.addValidation("ResourceOrder<?=DTR?>ResourceOrderRegion","req","<?=lang('RegionOrderWarning.billing.tip')?>");
				//fromValidator.addValidation("ResourceOrder<?=DTR?>ResourceOrderPostCode","req","<?=lang('PostCodeOrderWarning.billing.tip')?>");
				//fromValidator.addValidation("ResourceOrder<?=DTR?>ResourceOrderPhone","req","<?=lang('PhoneOrderWarning.billing.tip')?>");
				fromValidator.addValidation("ResourceOrder<?=DTR?>ResourceOrderEmail","req","<?=lang('EmailOrderWarning.billing.tip')?>");
				fromValidator.addValidation("ResourceOrder<?=DTR?>ResourceOrderEmail","email","<?=lang('EmailFormatOrderWarning.billing.tip')?>");
		</script>
	<? }?>		
<?=boxFooter()?>
