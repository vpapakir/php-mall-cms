<!-- <? print_r($out);?> -->
<?=boxHeader(array('title'=>lang('ReservedPropertyOrder.reservedProperty.title')))?>
	<tr>
		<form name="getOrders" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<td valign=top bgcolor="#ffffff"> 
			<?
				if(setting('UsePaymentForReservedPropertyOrders')=='Y') {
					$options[0]['id'] = '';
					$options[0]['value'] = lang('AllPaymentStatuses.reservedProperty.reservedProperty.tip');
					echo getReference('ReservedPropertyOrderPaymentStatus','ReservedPropertyOrderPaymentStatus',input('ReservedPropertyOrderPaymentStatus'),array('code'=>'Y','type'=>'dropdown','options'=>$options));
				}
			?>	
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('AllOrderHandlingStatuses.reservedProperty.tip');
				echo getReference('ReservedPropertyOrderStatus','ReservedPropertyOrderStatus',input('ReservedPropertyOrderStatus'),array('code'=>'Y','type'=>'dropdown','options'=>$options))
			?>	
			<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
			<br/><br/>
			</td> 
		</form>
	</tr>
	<? if(!empty($out['DB']['ReservedPropertyOrders'])) { ?>
	<tr>
		<td bgcolor="#ffffff">	
			<table border="0" cellspacing="1" cellpadding="5">
			<form name="ordersForm" method="post" >
			<input type="hidden" name="SID" value="<?=input('SID')?>"/>
			<input type="hidden" name="category" value="<?=input('category')?>" />
			<input type="hidden" name="actionMode" value="savelist" />
						<? if(!empty($out['DB']['ReservedPropertyOrders'])){ foreach($out['DB']['ReservedPropertyOrders'] as $id=>$value){?>
							<input type="hidden" name="ReservedPropertyOrderID[<?=$id?>]" value="<?=$value['ReservedPropertyOrderID']?>" />
							<tr> 
								<td valign="center" align="center" class="row1" width="1px">
									<a href="<?=setting('url')?>manageReservedPropertyOrder/ReservedPropertyOrderID/<?=$value['ReservedPropertyOrderID']?>"><?=$value['ReservedPropertyOrderIndex']?></a>
								</td>
								<td valign="top" nowrap class="row1" width="20%">
									<a href="<?=setting('url')?>manageReservedPropertyOrder/ReservedPropertyOrderID/<?=$value['ReservedPropertyOrderID']?>"><?= $value['ReservedPropertyOrderFirstName']?>&nbsp;<?= $value['ReservedPropertyOrderLastName']?></a>
									<br/>
									<a href="mailto:<?=$value['ReservedPropertyOrderEmail']?>"><?=$value['ReservedPropertyOrderEmail']?></a>, <?=$value['ReservedPropertyOrderPhone']?>
								</td>
								<td valign="top" align="center" class="row1" width="1%">
									<? if(!empty($value['ReservedPropertyIcon'])) { ?>
										<img src="<?=setting('layout')?>images/icons/picture.gif" width="15" height="13" id="<?=$value['ReservedPropertyID']?>" onmouseover="showDiv('<?=$value['ReservedPropertyID']?>','<?=$value['ReservedPropertyID']?>.content','right')" onmouseout="hideDiv('<?=$value['ReservedPropertyID']?>.content'); return false;" />
										<div id="<?=$value['ReservedPropertyID']?>.content" class="popup" style="width:150px"><img src="<?=setting('urlfiles').$value['ReservedPropertyIcon']?>" border="0"/></div>
									<? } else {?>
										<img src="<?=setting('layout')?>images/icons/nopicture.gif" width="15" height="13"/>
									<? }?>
								</td>																
								<td valign="top" nowrap class="row1" width="40%">
									<a href="<?=setting('url')?>manageReservedPropertyOrder/ReservedPropertyOrderID/<?=$value['ReservedPropertyOrderID']?>"><?=getValue($value['ReservedPropertyTitle'])?></a>
									<br/>
									<?=getFormated($value['ReservedPropertyLocation'],'Location')?>
									<br>
									<?=getValue($value['ReservedPropertyAddress']);?>
								</td>
								<td valign="top" class="row1" width="15%">
									<?=getReference('ReservedPropertyOrderPaymentStatus','ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPaymentStatus'.'['.$id.']',$value['ReservedPropertyOrderPaymentStatus'],array('code'=>'Y'))?>
								</td>
								<td valign="top" class="row1" width="15%">
									<?=getReference('ReservedPropertyOrderStatus','ReservedPropertyOrder'.DTR.'ReservedPropertyOrderStatus'.'['.$id.']',$value['ReservedPropertyOrderStatus'],array('code'=>'Y'))?>
								</td> 
								<td valign="top" class="row1" nowrap width="10%">
									<?=getFormated($value['TimeCreated'],'DateTime')?>
								</td>
								<td valign="top" class="row1" align="center">
									<?=getFormated($value['ReservedPropertyOrderTotalAmount'],'Money')?> 
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
								<?=getPages($out['pages']['ReservedPropertyOrders'])?>
							</td> 
						</tr>					
			</form>
			</table>
		</td>	
	</tr>
	<? } else { ?>
	<tr>
		<td bgcolor="#ffffff" align="center">	
			<p><?=lang('NoOrderHasBeenFound.reservedProperty.tip')?>			</p>
		</td>
	</tr>	
	<? } ?>	
<?=boxFooter()?>