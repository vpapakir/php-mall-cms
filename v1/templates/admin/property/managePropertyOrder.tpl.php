<?=boxHeader(array('title'=>lang('PropertyOrder.property.title')))?>
		<form name="orderForm" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>"/>
		<input type="hidden" name="actionMode" value="save"/>
		<input type="hidden" name="PropertyOrderID" value="<?= input('PropertyOrderID')?>" />
		<tr>
		<td bgcolor="#ffffff">
			<table width="30%">
				<tr>
					<td valign="top">
						<?=getReference('PropertyOrderPaymentStatus','PropertyOrder'.DTR.'PropertyOrderPaymentStatus',$out['DB']['PropertyOrder'][0]['PropertyOrderPaymentStatus'],array('code'=>'Y'))?>
					</td>
					<td valign="top">
						<?=getReference('PropertyOrderStatus','PropertyOrder'.DTR.'PropertyOrderStatus',$out['DB']['PropertyOrder'][0]['PropertyOrderStatus'],array('code'=>'Y'))?>
					</td>
					<td align="center">
						<input type="submit" name="Save" value="<?=lang('-Save')?>" />
					</td>
				</tr>
			</table>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DEDEE1">
				<? if(setting('UsePaymentForPropertyOrders')=='Y') { ?>
				<tr bgcolor="#FFFFFF"> 
					<td valign="top" align="left" class="subtitle">
						<?=lang('PropertyOrder.PropertyOrderPaymentStatus')?>:
					</td>
					<td>
						<strong><?=$out['DB']['PropertyOrder'][0]['PropertyOrderPaymentStatus']?></strong>
					</td>
				</tr>
				<? } ?>
				<tr bgcolor="#FFFFFF"> 
					<td valign="top" align="left" class="subtitle" width="20%">
						<?=lang('PropertyOrder.PropertyOrderStatus')?>:
					</td>
					<td>
						<strong><?=$out['DB']['PropertyOrder'][0]['PropertyOrderStatus']?></strong>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF"> 
					<td valign="top" align="left" colspan="2">
						<?=$out['DB']['PropertyOrder'][0]['PropertyOrderFirstName']?> <?=$out['DB']['PropertyOrder'][0]['PropertyOrderLastName']?>
						<br/>
						<?=$out['DB']['PropertyOrder'][0]['PropertyOrderAddress1']?>, <?=getFormated($out['DB']['PropertyOrder'][0]['PropertyOrderLocation'],'Location')?>, <?=$out['DB']['PropertyOrder'][0]['PropertyOrderPostCode']?>
						<br/>
						<? if(!empty($out['DB']['PropertyOrder'][0]['PropertyOrderPhone'])) { echo $out['DB']['PropertyOrder'][0]['PropertyOrderPhone'].', ';} ?>
						<? if(!empty($out['DB']['PropertyOrder'][0]['PropertyOrderEmail'])) { ?><a href="mailto:<?=$out['DB']['PropertyOrder'][0]['PropertyOrderEmail']?>"><?=$out['DB']['PropertyOrder'][0]['PropertyOrderEmail']?></a> <? } ?>
					</td>
				</tr>			
				<tr bgcolor="#FFFFFF"> 
					<td colspan="2" valign="top" align="left">
						<div class="subtitle"><?=lang('Message')?>:</div>
						<?=getFormated($out['DB']['PropertyOrder'][0]['PropertyOrderMessage'],'TEXT')?>
					</td> 
				</tr>
				<? if(setting('UseMutliplePropertiesPerOrder')=='Y') { ?>					
				<tr>
					<td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td class="subtitle">
						<?=lang('NumberOfProperties.property.tip')?>
					</td>
					<td>
						<strong>
						<? foreach($out['DB']['PropertyOrderItem'] as $qty) { $QTY+=$qty['PropertyOrderItemQuantity'];}?>
						<?=$QTY?>
						</strong>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td class="subtitle">
						<?=lang('OrderTotalAmount.property.tip')?>
					</td>
					<td>
						<strong><?=getFormated($out['DB']['PropertyOrder'][0]['PropertyOrderTotalAmount'],'Money')?></strong>
					</td>
				</tr>
				<? } ?>

<?	if(!empty($out['DB']['PropertyOrderItem'])){ foreach($out['DB']['PropertyOrderItem'] as $k=>$row){ ?>
				<tr>
					<td width="150" bgcolor="#FFFFFF" valign="top">
					<img src="<?= setting('urlfiles').$row['PropertyIcon']?>" border=0 alt="<?=getValue($row['PropertyTitle']);?>">
					</td>
					<td colspan="1" bgcolor="#FFFFFF" valign="top">

					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
							<h1><?=getValue($row['PropertyTitle']);?></h1> 
							<?=getFormated($row['PropertyLocation'],'Location')?>
							<br>
							<?=getValue($row['PropertyAddress']);?>
							<br>
							<?=lang('Price.properties.tip')?>: <strong><?=getFormated($row['PropertyOrderItemPrice'],'Money')?></strong>
							<?
							if(setting('UseMutliplePropertiesPerOrder')=='Y') {
								echo '<br>'.lang('-quantity')?>: <strong><?=$row['PropertyOrderItemQuantity'];
							}
							?></strong>
							</td>
						</tr>
						<tr>
							<td>
<?
	$in['DB'] = getFormated($row['PropertyFields'],'serialized');
	//showPropertyExtraFieldsList($in);
?>
							</td>
						</tr>
					</table>
					</td>
				</tr>
<? }} ?>

			</table>	
			</td>	
		</tr>									
	</form>
<?=boxFooter()?>
<?
setInput('OrderID',$out['DB']['PropertyOrder'][0]['PropertyOrderID']);
$params['fields'] ='<input type="hidden" name="PropertyOrder'.DTR.'PropertyOrderID" value="'.$out['DB']['PropertyOrder'][0]['PropertyOrderID'].'">';
getBox('mail.manageMessages',array("params"=>$params)) ?>

