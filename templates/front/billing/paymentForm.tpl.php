<? // boxHeader(array('title'=>lang('PaymentForm.billing.title')))?>
<?
	$formMode = $params['formMode'];
	$OrderAmount = $params['OrderAmount'];
	$buttonMode = $params['buttonMode'];
?>
	<? /* if(input('paymentMethod')=='bank'){?>
	<tr>	
		<td valign="top" bgcolor="#ffffff" align="center">
			<? if(input('actionMode')=='pay'){?>
				<input type="hidden" name="paymentMethod" value="bank"/>
				<span class="subtitle"><?=getValue($out['DB']['PaymentMethods'][0]['PaymentMethodName'])?></span>
				<br/><br/>
				<?=getValue($out['DB']['PaymentMethods'][0]['PaymentMethodDescription'])?>
				<br/>
				<? if (hasRights('content')) { ?><a href="<?=setting('adminurl')?>managePaymentMethod/PaymentMethodID/<?=$out['DB']['PaymentMethods'][0]['PaymentMethodID']?>/frontBackLinkAction/save/"><?=lang('-editbox')?></a><br/><? } ?>
				<br/><br/>
				<input type="submit" name="goToBank" value="<?=lang('BillButton.billing.button')?>" />
			<? }else{?>
				<span class="subtitle"><?=lang('ThanksForPayment.billing.tip')?></span>
			<? }?>
		</td>
	</tr>	
	<? } */ 
	if($formMode=='deposit' || $out['Balance']<=0 ) { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff" align="center">
			<?=lang('PaymentDepositIntro.billing.tip')?>
			<br/><br/>
			<!--
			<?=lang('PaymentBalance.billing.tip')?>: <?=getFormated($out['Balance'],'Money')?>
			<br/><br/>
			-->
			<?=lang('SelectPaymentMethodIntro.billing.tip')?>:<br/>
			<? 
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('SelectPaymentMethod.billing.tip').' -';
				//echo getLists($out['DB']['PaymentMethods'],input('paymentMethod'),array('name'=>'paymentMethod','id'=>'PaymentMethodAlias','value'=>'PaymentMethodName','action'=>'document.paymentForm.actionMode.value = '."'view'".';submit();','style'=>'width:300px;','options'=>$options));	
				echo getLists($out['DB']['PaymentMethods'],input('paymentMethod'),array('name'=>'paymentMethod','id'=>'PaymentMethodAlias','value'=>'PaymentMethodName','style'=>'width:300px;','options'=>$options));	
			?>
			
			<? if(count($out['DB']['Services'])>1) { ?>
			<br/><br/>
			<? 
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('SelectServicePrice.billing.tip').' -';
				$i=1;
				foreach ($out['DB']['Services'] as $row)
				{
					$dataList[$i]['id'] = $row['ServiceID'];
					$dataList[$i]['value'] = getValue($row['ServiceTitle']).' '.getFormated($row['ServicePrice'],'Money');
					$i++;
				}
				echo getLists($dataList,input('ServiceID'),array('name'=>'ServiceID','style'=>'width:300px;','options'=>$options));	
			?>
			<? } elseif (count($out['DB']['Services'])>0) { ?>
			<br/><br/>
			<span class="subtitle"><?=lang('PaymentAmount.billing.tip')?>: <?=getFormated($out['DB']['Services'][0]['ServicePrice'],'Money')?></span>
			<input type="hidden" name="ServiceID" value="<?=$out['DB']['Services'][0]['ServiceID']?>" />
			<? } elseif(!empty($OrderAmount)) { ?>
					<input type="hidden" name="BillingOrder<?=DTR?>OrderAmount" value="<?=$OrderAmount?>" />
			<? } else { ?>
			<?=lang('PaymentAmount.billing.tip')?>:<br/>
			<input type="text" name="BillingOrder<?=DTR?>OrderAmount" size="10" /> <?=setting('currency')?>
			<? } ?>
			<? if($buttonMode!='nobutton') { ?>
			<br/><br/>
			<input type="submit" name="goToDeposit" value="<?=lang('PaymentDepositButton.billing.button')?>" />
			<? } ?>
		</td> 
	</tr>
	<? } else { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff" align="center">
			<?=lang('PaymentIntro.billing.tip')?>
			<br/><br/>
			<?=lang('PaymentBalance.billing.tip')?>: <?=getFormated($out['Balance'],'Money')?>
			<br/><br/>
			<? if(count($out['DB']['Services'])>1) { ?>
			<br/><br/>
			<? 
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('SelectServicePrice.billing.tip').' -';
				$i=1;
				foreach ($out['DB']['Services'] as $row)
				{
					$dataList[$i]['id'] = $row['ServiceID'];
					$dataList[$i]['value'] = getValue($row['ServiceTitle']).' '.getFormated($row['ServicePrice'],'Money');
					$i++;
				}
				echo getLists($dataList,input('ServiceID'),array('name'=>'ServiceID','style'=>'width:300px;','options'=>$options));	
			?>
			<? } elseif (count($out['DB']['Services'])>0) { ?>
			<br/><br/>
			<span class="subtitle"><?=lang('PaymentAmount.billing.tip')?>: <?=getFormated($out['DB']['Services'][0]['ServicePrice'],'Money')?></span>
			<input type="hidden" name="ServiceID" value="<?=$out['DB']['Services'][0]['ServiceID']?>" />
			<? } elseif(!empty($OrderAmount)) { ?>
					<input type="hidden" name="BillingOrder<?=DTR?>OrderAmount" value="<?=$OrderAmount?>" />
			<? } else { ?>
			<?=lang('PaymentAmount.billing.tip')?>:<br/>
			<input type="text" name="BillingOrder<?=DTR?>OrderAmount" size="10" /> <?=setting('currency')?>
			<? } ?>
			<br/><br/>
			
			<input type="submit" name="goToPayBill" value="<?=lang('PaymentButton.billing.button')?>" />
		</td> 
	</tr>	
	<? }?>		
<? // boxFooter()?>
