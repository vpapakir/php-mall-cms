<?=boxHeader(array('title'=>lang('ReservedPropertyOrder.reservedProperty.title')))?>
		<form name="orderForm" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>"/>
		<input type="hidden" name="actionMode" value="save"/>
		<input type="hidden" name="ReservedPropertyOrderID" value="<?= input('ReservedPropertyOrderID')?>" />
		<tr>
		<td bgcolor="#ffffff">
			<table width="30%">
				<tr>
					<td valign="top">
						<?=getReference('ReservedPropertyOrderPaymentStatus','ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPaymentStatus',$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderPaymentStatus'],array('code'=>'Y'))?>
					</td>
					<td valign="top">
						<?=getReference('ReservedPropertyOrderStatus','ReservedPropertyOrder'.DTR.'ReservedPropertyOrderStatus',$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderStatus'],array('code'=>'Y'))?>
					</td>
					<td align="center">
						<input type="submit" name="Save" value="<?=lang('-Save')?>" />
					</td>
				</tr>
			</table>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DEDEE1">
				<? if(setting('UsePaymentForReservedPropertyOrders')=='Y') { ?>
				<tr bgcolor="#FFFFFF"> 
					<td valign="top" align="left" class="subtitle">
						<?=lang('ReservedPropertyOrder.ReservedPropertyOrderPaymentStatus')?>:
					</td>
					<td>
						<strong><?=$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderPaymentStatus']?></strong>
					</td>
				</tr>
				<? } ?>
				<tr bgcolor="#FFFFFF"> 
					<td valign="top" align="left" class="subtitle" width="20%">
						<?=lang('ReservedPropertyOrder.ReservedPropertyOrderStatus')?>:
					</td>
					<td>
						<strong><?=$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderStatus']?></strong>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF"> 
					<td valign="top" align="left" colspan="2">
						<?=$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderFirstName']?> <?=$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderLastName']?>
						<br/>
						<?=$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderAddress1']?>, <?=getFormated($out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderLocation'],'Location')?>, <?=$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderPostCode']?>
						<br/>
						<? if(!empty($out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderPhone'])) { echo $out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderPhone'].', ';} ?>
						<? if(!empty($out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderEmail'])) { ?><a href="mailto:<?=$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderEmail']?>"><?=$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderEmail']?></a> <? } ?>
					</td>
				</tr>			
				<tr bgcolor="#FFFFFF"> 
					<td colspan="2" valign="top" align="left">
						<div class="subtitle"><?=lang('Message')?>:</div>
						<?=getFormated($out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderMessage'],'TEXT')?>
					</td> 
				</tr>
				<? if(setting('UseMutlipleReservedPropertiesPerOrder')=='Y') { ?>					
				<tr>
					<td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td class="subtitle">
						<?=lang('NumberOfReservedProperties.reservedProperty.tip')?>
					</td>
					<td>
						<strong>
						<? foreach($out['DB']['ReservedPropertyOrderItem'] as $qty) { $QTY+=$qty['ReservedPropertyOrderItemQuantity'];}?>
						<?=$QTY?>
						</strong>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td class="subtitle">
						<?=lang('OrderTotalAmount.reservedProperty.tip')?>
					</td>
					<td>
						<strong><?=getFormated($out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderTotalAmount'],'Money')?></strong>
					</td>
				</tr>
				<? } ?>

<?	if(!empty($out['DB']['ReservedPropertyOrderItem'])){ foreach($out['DB']['ReservedPropertyOrderItem'] as $k=>$row){ ?>
				<tr>
					<td width="150" bgcolor="#FFFFFF" valign="top">
					<img src="<?= setting('urlfiles').$row['ReservedPropertyIcon']?>" border=0 alt="<?=getValue($row['ReservedPropertyTitle']);?>">
					</td>
					<td colspan="1" bgcolor="#FFFFFF" valign="top">

					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
							<h1><?=getValue($row['ReservedPropertyTitle']);?></h1> 
							<?=getFormated($row['ReservedPropertyLocation'],'Location')?>
							<br>
							<?=getValue($row['ReservedPropertyAddress']);?>
							<br>
							<?=lang('Price.reservedProperties.tip')?>: <strong><?=getFormated($row['ReservedPropertyOrderItemPrice'],'Money')?></strong>
							<?
							if(setting('UseMutlipleReservedPropertiesPerOrder')=='Y') {
								echo '<br>'.lang('-quantity')?>: <strong><?=$row['ReservedPropertyOrderItemQuantity'];
							}
							?></strong>
							</td>
						</tr>
						<tr>
							<td>
<?
	$in['DB'] = getFormated($row['ReservedPropertyFields'],'serialized');
	//showReservedPropertyExtraFieldsList($in);
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
setInput('OrderID',$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderID']);
$params['fields'] ='<input type="hidden" name="ReservedPropertyOrder'.DTR.'ReservedPropertyOrderID" value="'.$out['DB']['ReservedPropertyOrder'][0]['ReservedPropertyOrderID'].'">';
getBox('mail.manageMessages',array("params"=>$params)) ?>

