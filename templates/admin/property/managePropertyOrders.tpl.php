<!-- <? print_r($out);?> -->
<?=boxHeader(array('title'=>lang('PropertyOrder.property.title')))?>
	<tr>
		<form name="getOrders" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<td valign=top bgcolor="#ffffff"> 
			<?
				if(setting('UsePaymentForPropertyOrders')=='Y') {
					$options[0]['id'] = '';
					$options[0]['value'] = lang('AllPaymentStatuses.property.property.tip');
					echo getReference('PropertyOrderPaymentStatus','PropertyOrderPaymentStatus',input('PropertyOrderPaymentStatus'),array('code'=>'Y','type'=>'dropdown','options'=>$options));
				}
			?>	
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllOrderHandlingStatuses.property.tip');
				echo getReference('PropertyOrderStatus','PropertyOrderStatus',input('PropertyOrderStatus'),array('code'=>'Y','type'=>'dropdown','options'=>$options))
			?>	
			<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
			<br/><br/>
			</td> 
		</form>
	</tr>
	<? if(!empty($out['DB']['PropertyOrders'])) { ?>
	<tr>
		<td bgcolor="#ffffff">	
			<table border="0" cellspacing="1" cellpadding="5">
			<form name="ordersForm" method="post" >
			<input type="hidden" name="SID" value="<?=input('SID')?>"/>
			<input type="hidden" name="category" value="<?=input('category')?>" />
			<input type="hidden" name="actionMode" value="savelist" />
						<? if(!empty($out['DB']['PropertyOrders'])){ foreach($out['DB']['PropertyOrders'] as $id=>$value){?>
							<input type="hidden" name="PropertyOrderID[<?=$id?>]" value="<?=$value['PropertyOrderID']?>" />
							<tr> 
								<td valign="center" align="center" class="row1" width="1px">
									<a href="<?=setting('url')?>managePropertyOrder/PropertyOrderID/<?=$value['PropertyOrderID']?>"><?=$value['PropertyOrderIndex']?></a>
								</td>
								<td valign="top" nowrap class="row1" width="20%">
									<a href="<?=setting('url')?>managePropertyOrder/PropertyOrderID/<?=$value['PropertyOrderID']?>"><?= $value['PropertyOrderFirstName']?>&nbsp;<?= $value['PropertyOrderLastName']?></a>
									<br/>
									<a href="mailto:<?=$value['PropertyOrderEmail']?>"><?=$value['PropertyOrderEmail']?></a>, <?=$value['PropertyOrderPhone']?>
								</td>
								<td valign="top" align="center" class="row1" width="1%">
									<? if(!empty($value['PropertyIcon'])) { ?>
										<img src="<?=setting('layout')?>images/icons/picture.gif" width="15" height="13" id="<?=$value['PropertyID']?>" onmouseover="showDiv('<?=$value['PropertyID']?>','<?=$value['PropertyID']?>.content','right')" onmouseout="hideDiv('<?=$value['PropertyID']?>.content'); return false;" />
										<div id="<?=$value['PropertyID']?>.content" class="popup" style="width:150px"><img src="<?=setting('urlfiles').$value['PropertyIcon']?>" border="0"/></div>
									<? } else {?>
										<img src="<?=setting('layout')?>images/icons/nopicture.gif" width="15" height="13"/>
									<? }?>
								</td>																
								<td valign="top" nowrap class="row1" width="40%">
									<a href="<?=setting('url')?>managePropertyOrder/PropertyOrderID/<?=$value['PropertyOrderID']?>"><?=getValue($value['PropertyTitle'])?></a>
									<br/>
									<?=getFormated($value['PropertyLocation'],'Location')?>
									<br>
									<?=getValue($value['PropertyAddress']);?>
								</td>
								<td valign="top" class="row1" width="15%">
									<?=getReference('PropertyOrderPaymentStatus','PropertyOrder'.DTR.'PropertyOrderPaymentStatus'.'['.$id.']',$value['PropertyOrderPaymentStatus'],array('code'=>'Y'))?>
								</td>
								<td valign="top" class="row1" width="15%">
									<?=getReference('PropertyOrderStatus','PropertyOrder'.DTR.'PropertyOrderStatus'.'['.$id.']',$value['PropertyOrderStatus'],array('code'=>'Y'))?>
								</td> 
								<td valign="top" class="row1" nowrap width="10%">
									<?=getFormated($value['TimeCreated'],'DateTime')?>
								</td>
								<td valign="top" class="row1" align="center">
									<?=getFormated($value['PropertyOrderTotalAmount'],'Money')?> 
								</td>
							</tr>
						<? } }?>
						<tr> 
							<td valign="top" bgcolor="#ffffff" align="center">
								<input type="submit" name="Save" value="<?=lang('-Save')?>" />
							</td> 
						</tr>
						<tr>  
							<td valign="top" align="center" colspan="8"> 
								<?=getPages($out['pages']['PropertyOrders'])?>
							</td> 
						</tr>					
			</form>
			</table>
		</td>	
	</tr>
	<? } else { ?>
	<tr>
		<td bgcolor="#ffffff" align="center">	
			<p><?=lang('NoOrderHasBeenFound.property.tip')?>			</p>
		</td>
	</tr>	
	<? } ?>	
<?=boxFooter()?>