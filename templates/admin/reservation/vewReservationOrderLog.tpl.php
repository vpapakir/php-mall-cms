<?=boxHeader(array('title'=>'VewReservationOrderLog.loan.title','tabs'=>'manageReservationOrders'))?>
<?
$currentValue = $out['DB']['ReservationOrder'];
$selectedLog = $out['DB']['ReservationOrderLog'];
?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table bgcolor="#ffffff" cellpadding="2" cellspacing="2" width="100%" border="0">
					<form method="post" name="goSelectLog">
					<input type="hidden" name="SID" value="<?=input('SID')?>" />
					<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
					<input type="hidden" name="ReservationOrderID" value="<?=input('ReservationOrderID')?>" />
					<tr>
						<td valign="top" class="subtitle" colspan="3">
							<? if(!input('ReservationOrderID')) { 
								$optionsDel[0]['id'] = '';
								$optionsDel[0]['value'] = '---';
							?>
							<b><?=lang('SelectLogDeltedRecord.loan.tip')?>:</b> <?=getLists($out['DB']['ReservationOrderLogDeletedRecords'],input('ReservationOrderID'),array('name'=>'ReservationOrderID','id'=>'ReservationOrderID','value'=>'ReservationOrderClientType','type'=>'dropdown','options'=>$optionsDel,'action'=>'submit();'));			?>	
							<br/><br/>
							<? } else { ?>
						
							<b><?=lang('SelectLogRecord.loan.tip')?>:</b> <?=getLists($out['DB']['ReservationOrderLogRecords'],input('RequestedLogID'),array('name'=>'RequestedLogID','id'=>'ReservationOrderLogID','value'=>'ReservationOrderLogTimeCreated','type'=>'dropdown','options'=>$options,'action'=>'submit();'));			?>	
							<br/><br/>
							<b><?=lang('SelectedLogRecordUser.loan.tip')?>:</b> <a href="<?=setting('url')?>manageUser/UserID/<?=$selectedLog['ReservationOrderLogUserID']?>/" target="_blank"><?=$selectedLog['ReservationOrderLogUserID']?></a>
							<br/>
							<? } ?>
						</td>
					</tr>
					</form>
					<tr>
						<td width="40%" class="toprow"><?=lang('LogFieldName.loan.tip')?></td>
						<td width="30%" class="toprow"><?=lang('CurrentLogValue.loan.tip')?></td>
						<td width="30%" class="toprow"><?=lang('SelectedLogValue.loan.tip')?></td>
					</tr>
					<? foreach($currentValue as $fieldCode=>$fieldValue) { 
					if ($fieldCode!='UserExtraFields') {
					$logFieldValue = $selectedLog[$fieldCode];
					if($logFieldValue!=$fieldValue) { $classRow = 'redRow';} else {$classRow = 'row1';} 
					 ?>
					<tr>
						<td class="<?=$classRow?>"><b><?=lang('ReservationOrder.'.$fieldCode)?></b></td>
						<td class="<?=$classRow?>"><?=$fieldValue?></td>
						<td class="<?=$classRow?>"><?=$selectedLog[$fieldCode]?></td>
					</tr>
					<?  } } ?>
				</table>
		</td> 
	</tr> 
<?=boxFooter()?>