<?=boxHeader(array('title'=>lang('PropertyOrder.property.title')))?>
	<tr>
		<form name="getOrders" method="post">
			<input type="hidden" name="SID" value="manageOrders" />
			<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllPaymentStatuses.property.tip');
				echo getReference('PropertyOrderPaymentStatus','PropertyOrder'.DTR.'PropertyOrderPaymentStatus',input('PropertyOrder'.DTR.'PropertyOrderPaymentStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			?>	
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllOrderHandlingStatuses.property.tip');
				echo getReference('PropertyOrderStatus','PropertyOrder'.DTR.'PropertyOrderStatus',input('PropertyOrder'.DTR.'PropertyOrderStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			?>	
			<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
			</td> 
		</form>
	</tr>
	<tr>
		<td bgcolor="#ffffff">	
			<table border="0" cellspacing="1" cellpadding="5">
			<form name="ordersForm" method="post" >
			<input type="hidden" name="SID" value="manageOrders"/>
			<input type="hidden" name="category" value="<?=input('category')?>" />
			<input type="hidden" name="actionMode" value="savelist" />
						<? if(!empty($out['DB']['PropertyOrders'])){ foreach($out['DB']['PropertyOrders'] as $id=>$value){?>
							<input type="hidden" name="PropertyOrderID[<?=$id?>]" value="<?=$value['PropertyOrderID']?>" />
							<tr> 
								<td valign="center" align="center" class="row1" width="1px">
									<?=$value['PropertyOrderID']?>
								</td>
								<td valign="top" nowrap class="row1" width="60%">
									<a href="<?=setting('url')?>manageOrder/PropertyOrderID/<?=$value['PropertyOrderID']?>">&nbsp;<?= $value['PropertyOrderFirstName']?>&nbsp;<?= $value['PropertyOrderLastName']?></a>
								</td>
								<td valign="top" class="row1" width="10%">
									<?=getReference('PropertyOrderPaymentStatus','PropertyOrder'.DTR.'PropertyOrderPaymentStatus'.'['.$id.']',$value['PropertyOrderPaymentStatus'],array('code'=>'Y'))?>
								</td>
								<td valign="top" class="row1" width="10%">
									<?=getReference('PropertyOrderStatus','PropertyOrder'.DTR.'PropertyOrderStatus'.'['.$id.']',$value['PropertyOrderStatus'],array('code'=>'Y'))?>
								</td> 
								<td valign="top" class="row1" nowrap width="20%">
									<small><?=getFormated($value['TimeCreated'],'DateTime')?></small>
								</td>
								<td valign="top" class="row1" align="center">
									<?=$value['PropertyOrderTotalAmount']?> 
								</td>
								<!-- <td valign="top" class="row1" align="center" width="9%">
									<select name="manageR<?=$value['PropertyOrderID']?>" onChange="selectLink('ordersForm', 'manageR<?=$value['PropertyOrderID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
										<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
										<option value="<?=setting('url')?>manageOrder/PropertyOrderID/<?=$value['PropertyOrderID']?>"><?=lang('-edit')?></option>
										<option value="<?=setting('url')?>manageOrder/PropertyOrder<?=DTR?>PropertyOrderID/<?=$value['PropertyOrderID']?>/actionMode/delete/"><?=lang('-delete')?></option>
									</select>
								</td> -->
							</tr>
						<? } }?>
						<tr> 
							<td valign="top" bgcolor="#ffffff" align="center">
								<input type="submit" name="Save" value="<?=lang('-Save')?>" />
							</td> 
						</tr>
			</form>
			</table>
		</td>	
	</tr>	
<?=boxFooter()?>