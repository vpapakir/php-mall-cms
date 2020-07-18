<?=boxHeader(array('title'=>lang('TourOrder.tour.title')))?>
	<tr>
		<form name="getOrders" method="post">
			<input type="hidden" name="SID" value="manageOrders" />
			<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllPaymentStatuses.tour.tip');
				echo getReference('TourOrderPaymentStatus','TourOrder'.DTR.'TourOrderPaymentStatus',input('TourOrder'.DTR.'TourOrderPaymentStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			?>	
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllOrderHandlingStatuses.tour.tip');
				echo getReference('TourOrderStatus','TourOrder'.DTR.'TourOrderStatus',input('TourOrder'.DTR.'TourOrderStatus'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
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
						<? if(!empty($out['DB']['TourOrders'])){ foreach($out['DB']['TourOrders'] as $id=>$value){?>
							<input type="hidden" name="TourOrderID[<?=$id?>]" value="<?=$value['TourOrderID']?>" />
							<tr> 
								<td valign="center" align="center" class="row1" width="1px">
									<?=$value['TourOrderID']?>
								</td>
								<td valign="top" nowrap class="row1" width="60%">
									<a href="<?=setting('url')?>manageOrder/TourOrderID/<?=$value['TourOrderID']?>">&nbsp;<?= $value['TourOrderFirstName']?>&nbsp;<?= $value['TourOrderLastName']?></a>
								</td>
								<td valign="top" class="row1" width="10%">
									<?=getReference('TourOrderPaymentStatus','TourOrder'.DTR.'TourOrderPaymentStatus'.'['.$id.']',$value['TourOrderPaymentStatus'],array('code'=>'Y'))?>
								</td>
								<td valign="top" class="row1" width="10%">
									<?=getReference('TourOrderStatus','TourOrder'.DTR.'TourOrderStatus'.'['.$id.']',$value['TourOrderStatus'],array('code'=>'Y'))?>
								</td> 
								<td valign="top" class="row1" nowrap width="20%">
									<small><?=getFormated($value['TimeCreated'],'DateTime')?></small>
								</td>
								<td valign="top" class="row1" align="center">
									<?=$value['TourOrderTotalAmount']?> 
								</td>
								<!-- <td valign="top" class="row1" align="center" width="9%">
									<select name="manageR<?=$value['TourOrderID']?>" onChange="selectLink('ordersForm', 'manageR<?=$value['TourOrderID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
										<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
										<option value="<?=setting('url')?>manageOrder/TourOrderID/<?=$value['TourOrderID']?>"><?=lang('-edit')?></option>
										<option value="<?=setting('url')?>manageOrder/TourOrder<?=DTR?>TourOrderID/<?=$value['TourOrderID']?>/actionMode/delete/"><?=lang('-delete')?></option>
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