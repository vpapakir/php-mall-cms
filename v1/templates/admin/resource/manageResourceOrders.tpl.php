<?=boxHeader(array('title'=>lang('ResourceOrder.resource.title')))?>
	<tr>
		<form name="getOrders" method="post">
			<input type="hidden" name="SID" value="manageOrders" />
			<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllPaymentStatuses.resource.resource.tip');
				echo getReference('ResourceOrderPaymentStatus','ResourceOrderPaymentStatus',input('ResourceOrderPaymentStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			?>	
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllOrderHandlingStatuses.resource.tip');
				echo getReference('ResourceOrderStatus','ResourceOrderStatus',input('ResourceOrderStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
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
						<? if(!empty($out['DB']['ResourceOrders'])){ foreach($out['DB']['ResourceOrders'] as $id=>$value){?>
							<input type="hidden" name="ResourceOrderID[<?=$id?>]" value="<?=$value['ResourceOrderID']?>" />
							<tr> 
								<td valign="center" align="center" class="row1" width="1px">
									<?=$value['ResourceOrderID']?>
								</td>
								<td valign="top" nowrap class="row1" width="60%">
									<a href="<?=setting('url')?>manageOrder/ResourceOrderID/<?=$value['ResourceOrderID']?>">&nbsp;<?= $value['ResourceOrderFirstName']?>&nbsp;<?= $value['ResourceOrderLastName']?></a>
								</td>
								<td valign="top" class="row1" width="10%">
									<?=getReference('ResourceOrderPaymentStatus','ResourceOrder'.DTR.'ResourceOrderPaymentStatus'.'['.$id.']',$value['ResourceOrderPaymentStatus'],array('code'=>'Y'))?>
								</td>
								<td valign="top" class="row1" width="10%">
									<?=getReference('ResourceOrderStatus','ResourceOrder'.DTR.'ResourceOrderStatus'.'['.$id.']',$value['ResourceOrderStatus'],array('code'=>'Y'))?>
								</td> 
								<td valign="top" class="row1" nowrap width="20%">
									<small><?=getFormated($value['TimeCreated'],'DateTime')?></small>
								</td>
								<td valign="top" class="row1" align="center">
									<?=$value['ResourceOrderTotalAmount']?> 
								</td>
								<!-- <td valign="top" class="row1" align="center" width="9%">
									<select name="manageR<?=$value['ResourceOrderID']?>" onChange="selectLink('ordersForm', 'manageR<?=$value['ResourceOrderID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
										<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
										<option value="<?=setting('url')?>manageOrder/ResourceOrderID/<?=$value['ResourceOrderID']?>"><?=lang('-edit')?></option>
										<option value="<?=setting('url')?>manageOrder/ResourceOrder<?=DTR?>ResourceOrderID/<?=$value['ResourceOrderID']?>/actionMode/delete/"><?=lang('-delete')?></option>
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