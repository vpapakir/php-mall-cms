<? //print_r($out);?>
<? //print_r($input);?>
<?=boxHeader(array('title'=>lang('BillingOrder.resource.title')))?>
	<tr>
		<form name="getOrders" method="post">
			<input type="hidden" name="SID" value="manageBillingOrders" />
			<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllPaymentStatuses.billing.resource.tip');
				echo getReference('OrderPaymentStatus','OrderPaymentStatus',input('OrderPaymentStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			?>	
			<? if(setting('clientType') == 'admin'){ ?> <a href="<?=setting('url')?>manageReferences"><?=lang('-editbox')?></a><? }?>
			<? /*
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllOrderHandlingStatuses.billing.tip');
				echo getReference('ResourceOrderStatus','ResourceOrderStatus',input('ResourceOrderStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			?>	
			<? if(setting('clientType') == 'admin'){ ?> <a href="<?=setting('url')?>manageReferences"><?=lang('-editbox')?></a><? } //*/?>
			<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
			</td> 
		</form>
	</tr>
	<tr>
		<td bgcolor="#ffffff">	
			<table border="0" cellspacing="1" cellpadding="5">
			<form name="ordersForm" method="post" >
			<input type="hidden" name="SID" value="manageBillingOrders"/>
			<input type="hidden" name="category" value="<?=input('category')?>" />
			<input type="hidden" name="actionMode" value="savelist" />
						<? if(!empty($out/*['DB']['BillingOrders']*/)){ foreach($out/*['DB']['BillingOrders']*/ as $id=>$value){?>
							<input type="hidden" name="BillingOrderID[<?=$id?>]" value="<?=$value['BillingOrderID']?>" />
							<tr> 
								<td valign="center" align="center" class="row1" width="1%" style="width:1%; ">
									<?=$value['BillingOrderID']?>
								</td>
								<td valign="top" nowrap class="row1" width="60%">
									<a href="<?=setting('url')?>manageOrder/BillingOrderID/<?=$value['BillingOrderID']?>">&nbsp;<?= $value['OrderFirstName']?>&nbsp;<?= $value['UserID']//$value['OrderLastName']?></a>
								</td>
								<td valign="top" class="row1" width="10%">
									<?=getReference('OrderPaymentStatus','BillingOrder'.DTR.'OrderPaymentStatus'.'['.$id.']',$value['OrderPaymentStatus'],array('code'=>'Y'))?>
									<? if(setting('clientType') == 'admin'){ ?> <a href="<?=setting('url')?>manageReferences"><?=lang('-editbox')?></a><? }?>
								</td>
								<!-- <td valign="top" class="row1" width="10%">
									<? //getReference('ResourceOrderStatus','BillingOrder'.DTR.'OrderStatus'.'['.$id.']',$value['OrderStatus'],array('code'=>'Y'))?>
									<? // if(setting('clientType') == 'admin'){ ?> <a href="<?=setting('url')?>manageReferences"><? //lang('-editbox')?></a><? //}?>
								</td>  -->
								<td valign="top" class="row1" nowrap width="20%">
									<small><?=getFormated($value['TimeCreated'],'DateTime')?></small>
								</td>
								<td valign="top" class="row1" align="center">
									<?=$value['BillingOrderTotalAmount']?> 
								</td>
								<!-- <td valign="top" class="row1" align="center" width="9%">
									<select name="manageR<?=$value['OrderID']?>" onChange="selectLink('ordersForm', 'manageR<?=$value['BillingOrderID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
										<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
										<option value="<?=setting('url')?>manageOrder/BillingOrderID/<?=$value['OrderID']?>"><?=lang('-edit')?></option>
										<option value="<?=setting('url')?>manageOrder/BillingOrder<?=DTR?>BillingOrderID/<?=$value['OrderID']?>/actionMode/delete/"><?=lang('-delete')?></option>
									</select>
								</td> -->
							</tr>
						<? } }?>
						<tr> 
							<td valign="top" bgcolor="#ffffff" align="left" width="100%" colspan="5">
								<input type="submit" name="Save" value="<?=lang('-Save')?>" />
							</td> 
						</tr>
			</form>
			</table>
		</td>	
	</tr>	
<?=boxFooter()?>