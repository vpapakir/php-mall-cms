<? //print_r($out);?>
<?=boxHeader(array('title'=>lang('TourOrder.tour.title')))?>
	<tr>
		<td valign="top" bgcolor="#ffffff" align="left" class="subtitle">
		
			<table width="100%"  border="0" cellspacing="1" cellpadding="3" bgcolor="#eeeeee">
  				<form name="getTourOrders" method="post">
				<!-- <input type="hidden" name="TourCartItemType" value="order"/> -->
			   <tr>
				<td colspan="2" align="center" bgcolor="#EEEEEE" class="subtitle" height="50">
				 <? if(empty($input['TourOrderStatus'])){ $input['TourOrderStatus'] = 'all'; } ?>
					<?=getReference('TourOrder.TourOrderStatus','TourOrderStatus',$input['TourOrderStatus'],array('code'=>'Y','action'=>'submit();'))?>
					<?
						$options[0]['id']='';	
						$options[0]['value']='- '.lang('TourOrderSelect.tour.tip').' -';
						echo getLists($out['DB']['TourOrders'],$input['TourOrderID'],array('name'=>'TourOrderID','id'=>'TourOrderID','value'=>'TourOrderFullName','action'=>'submit();','style'=>'width:400px;','options'=>$options));	
					?>
					<?=getReference('TourOrder.TourOrderSort','TourOrderSort',input('TourOrderSort'),array('code'=>'Y','action'=>'submit();'))?>
				</td>
			   </tr>
			  </form>
	<? $TourOrderID = input('TourOrderID'); if(!empty($TourOrderID)){?>
			  <? $formName = 'manageTourOrders'?>
			  <form name="manageTourOrders" method="post">
				<input type="hidden" name="SID" value="<?=input('SID')?>"/>
				<input type="hidden" name="actionMode" value="save" />
				<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
				<input type="hidden" name="TourOrderID" value="<?=input('TourOrderID')?>"/>
				<input type="hidden" name="TourOrder<?=DTR?>TourOrderID" value="<?=input('TourOrderID')?>"/>
				<? if(!empty($out['DB']['TourOrder'][0]['TourOrderID'])){?>
					<input type="hidden" name="TourOrder<?=DTR?>TourOrderID" value="<?=$out['DB']['TourOrder'][0]['TourOrderID']?>"/>
				<? }?>
			  <tr>
				<td colspan="2" align="center" bgcolor="#ffffff" height="50">
					<?=lang('ShoppingCartTips.tour.tip','html')?>
				</td>
			  </tr>
			  <tr>
				<td colspan="2" align="center" bgcolor="#EEEEEE" class="subtitle" height="50"><?=lang('LatestMessage.tour.tip')?></td>
			  </tr>
			<? if(!empty($out['TourMessages']['DB']['NewTourMessages'][0]['TourMessageID'])) {?>
			<tr> 
				<td valign="top" colspan="2" bgcolor="#ffffff" class="fieldNames">	
				<? foreach($out['TourMessages']['DB']['NewTourMessages'] as $row) {?>
					<a href="<?=setting('url')?>manageTourOrders/TourOrderID/<?=$row['TourOrderID']?>/TourMessageID/<?=$row['TourMessageID']?>"><b><?=$row['MessageSubject']?></b></a>
					<br/>
					<?=getFormated($row['MessageText'],'TEXT')?>
					<br/>
					<i><?=lang('MessageSentOn.mail.tip')?><?=getFormated($row['TimeCreated'],'DateTime')?> <?=lang('MessageSentBy.mail.tip')?> <?=$row['MessageSenderNickName']?></i>
					<hr size="1"/>
				<? } ?>
				</td> 
			</tr> 
			<?  }?>
			<? if(!empty($out['DB']['TourOrder'][0]['TourOrderID'])){?>
				<tr>
					<td colspan="2" align="center" bgcolor="#ffffff">
						<a href="javascript://" onClick="popup('<?=setting('url')?>viewShoppingCart/TourOrderID/<?=$out['DB']['TourOrder'][0]['TourOrderID']?>/windowMode/popup')"><?=lang('ViewUserDetail.tour.tip')?></a>
					</td>
				</tr>
			<? }?>
  			  <tr>
				<td colspan="2" align="center" bgcolor="#EEEEEE" class="subtitle"><?=lang('GeneralInformationOrder.tour.tip')?></td>
			  </tr>
  			  <tr>
				<td colspan="2" align="center" bgcolor="#ffffff"><?=lang('OrderIntroTip.tour.tip')?></td>
			  </tr>
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderStatus')?>/<?=lang('TourOrder.TourOrderLanguage')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<? //session('TourOrder'.DTR.'TourOrderStatus')?>
					<?=getReference('TourOrder.SetTourOrderStatus','TourOrder'.DTR.'TourOrderStatus',$out['DB']['TourOrder'][0]['TourOrderStatus'],array('code'=>'Y'))?>
					&nbsp;&nbsp;
					<? if(count($out['DB']['Languages']['languageNames'])>1) { ?>														
						<?
							foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
							{
								$languagesList[$langID]['id']=$out['DB']['Languages']['languageCodes'][$langID];	
								$languagesList[$langID]['value']=$langName;		
							}								
							echo getLists($languagesList,$out['DB']['TourOrder'][0]['TourOrderLanguage'],array('name'=>'TourOrder'.DTR.'TourOrderLanguage','type'=>'dropdown'));	
						?>	
					<? } ?>						
				</td>
			  </tr>
			  <? if($out['DB']['TourOrder'][0]['TourOrderStatus']=='booked'){?>
			  		<tr>
						<td  width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderPayment')?></td>
						<td  width="70%" class="subtitle" bgcolor="#ffffff">
							<? echo getLists($out['DB']['PaymentMethods'],$out['DB']['TourOrder'][0]['TourOrderPayment'],array('name'=>'PaymentMethodID','id'=>'PaymentMethodID','value'=>'PaymentMethodName'));?>
							<input type="text" name="TourOrder<?=DTR?>TourOrderPaymentComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderPaymentComment']?>"/>
						</td>
					</tr>
					<tr>
						<td  width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderDueDate')?></td>
						<td  width="70%" class="subtitle" bgcolor="#ffffff">
							<?=getFormated($out['DB']['TourOrder'][0]['TourOrderDueDate'],'Date','form',array('mode'=>'dropdowns','fieldName'=>'TourOrder'.DTR.'TourOrderDueDate'))?>
							<input type="text" name="TourOrder<?=DTR?>TourOrderDueDateComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderDueDateComment']?>"/>
						</td>
					</tr>
			  <? }?>	
			  <tr>
				<td  width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderNextPresentation')?></td>
				<td  width="70%" class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderNextPresentation'],'Date','form',array('mode'=>'dropdowns','fieldName'=>'TourOrder'.DTR.'TourOrderNextPresentation','formName'=>$formName))?>
				</td>
			  </tr>
			  <tr>
				<td  class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderDestimation')?></td>
				<td  class="subtitle" bgcolor="#ffffff">
					
					<? setInput('CountryID','118'); ?>
					<? 
						$params['currentValue'] = $out['DB']['TourOrder'][0]['TourOrderDestimation'];
						$params['fieldName'] = 'TourOrder'.DTR.'TourOrderDestimation';
						$params['id'] = 'id';
						getBox('core.getRegionsDropDwon',array("params"=>$params)); 
					?>	
					<? //getReference('TourOrder.TourOrderDestimation','TourOrder'.DTR.'TourOrderDestimation',$out['DB']['TourOrder'][0]['TourOrderDestimation'],array('code'=>'Y'))?>
				</td>
			  </tr>
			  <tr>
				<td  class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderAgents')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<? //echo getLists($out['DB']['TourOrderAgents'],$out['DB']['TourOrder'][0]['TourOrderAgents'],array('name'=>'TourOrder'.DTR.'TourOrderAgents','type'=>'multipledropdown','style'=>'width=200px;'));?>
					<?=getReference('TourOrder.TourOrderAgents','TourOrder'.DTR.'TourOrderAgents',$out['DB']['TourOrder'][0]['TourOrderAgents'],array('code'=>'Y','type'=>'multiple'))?>
					&nbsp;&nbsp;
					<textarea cols="35" rows="5" name="TourOrder<?=DTR?>TourOrderAgentsComment"><?=$out['DB']['TourOrder'][0]['TourOrderAgentsComment']?></textarea>
				</td>
			  </tr>
			  <tr>
				<td  class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderProgramStart')?></td>
				<td  class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderProgramStart'],'Date','form',array('mode'=>'dropdowns','fieldName'=>'TourOrder'.DTR.'TourOrderProgramStart'))?>
				</td>
			  </tr>
			  <tr>
				<td  class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderProgramEnd')?></td>
				<td  class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderProgramEnd'],'Date','form',array('mode'=>'dropdowns','fieldName'=>'TourOrder'.DTR.'TourOrderProgramEnd'))?>
				</td>
			  </tr>
			   <tr>
				<td width="30%" class="subtitle" bgcolor="#ffffff" valign="top">
				<span class="subtitle"><?=lang('TourOrder.TourOrderParticipants')?></span><br/><br/>
				<input type="text" name="AddTourParticipant[<?=$fieldCode?>]" value="1" size="1"/>
				&nbsp;<input type="button" name="goAddTourParticipant" value="<?=lang('-add')?>" onClick="document.manageTourOrders.actionMode.value='add2';submit();" />
				</td>
					<td width="70%" class="subtitle" bgcolor="#ffffff" valign="top">
					<table border="0" cellpadding="0" cellspacing="3">
						<? if(is_array($out['DB']['TourParticipants'])) { foreach ($out['DB']['TourParticipants'] as $id=>$row) {?>
						<input type="hidden" name="TourParticipant<?=DTR?>TourParticipantID[<?=$id?>]" value="<?=$row['TourParticipantID']?>">
						<tr>
							<td><input type="text" name="TourParticipant<?=DTR?>TourParticipantName[<?=$id?>]" value="<?=$row['TourParticipantName']?>"/></td>
							<td><?=getFormated($row['TourParticipantDate'],'Date','form',array('fieldName'=>'TourParticipant'.DTR.'TourParticipantDate_'.$id,'formName'=>$formName))?></td>
							<!-- <input type="text" name="TourParticipant<?=DTR?>TourParticipantDate[<?=$id?>]" value="<?=$row['TourParticipantDate']?>"/> -->
							<td><input type="text" name="TourParticipant<?=DTR?>TourParticipantPassport[<?=$id?>]" value="<?=$row['TourParticipantPassport']?>"/></td>
							<td><a href="<?=setting('url')?><?=input('SID')?>/TourOrderID/<?=input('TourOrderID')?>/TourParticipant<?=DTR?>TourParticipantID/<?=$row['TourParticipantID']?>/actionMode/delete1"><?=lang('DeleteTourServiceOption.tour.link')?></a></td>
						</tr>
						<? }} else {  ?>
							<input type="hidden" name="TourParticipantID" value="">
							<tr>
								<td><input type="text" name="TourParticipant<?=DTR?>TourParticipantName" value=" "/></td>
								<td><?=getFormated($out['TourParticipantDate'],'Date','form',array('fieldName'=>'TourParticipant'.DTR.'TourParticipantDate','formName'=>$formName))?></td>
								<!-- <input type="text" name="TourParticipant<?=DTR?>TourParticipantDate" value=" "/> -->
								<td><input type="text" name="TourParticipant<?=DTR?>TourParticipantPassport" value=" "/></td>
							</tr>
						<? } ?>
					</table>
				</td>
			  </tr>
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderAmount')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderAmount'],'Money','form',array('fieldName'=>'TourOrder'.DTR.'TourOrderAmount'))?>&nbsp;&nbsp;<input type="text" name="TourOrder<?=DTR?>TourOrderAmountComment" size="35" value="<?=session('TourOrder'.DTR.'TourOrderAmountComment')?>" />
				</td>
			  </tr>		
  			  <tr>
				<td colspan="2" align="center" bgcolor="#EEEEEE"><?=lang('OrderProgram.tour.tip')?></td>
			  </tr>
  			  <tr>
				<td colspan="2" align="center" bgcolor="#ffffff"><?=lang('OrderProgramIntro.tour.tip')?></td>
			  </tr>
			  <? if(is_array($out['DB']['TourTourOrderPrograms'])){ foreach($out['DB']['TourTourOrderPrograms'] as $key=>$row){?>
			 <tr>
			 	<td class="subtitle" bgcolor="#ffffff" valign="top">
					<?=getFormated($row['TourProgramDate'],'Date');?>
				</td>
			 	<td  colspan="2" bgcolor="#ffffff">
					 <input type="hidden" name="TourProgram<?=DTR?>TourProgramID[<?=$key?>]" value="<?=$row['TourProgramID']?>">
					 <textarea name="TourProgram<?=DTR?>TourProgramMessage[<?=$key?>]" cols="30" rows="5"><?=$row['TourProgramMessage']?></textarea>
				</td>
			 </tr>
			 <? }}?>
  			  <tr>
				<td colspan="2" align="center" bgcolor="#EEEEEE"><?=lang('OrderTarifs.tour.tip')?></td>
			  </tr>
  			  <tr>
				<td colspan="2" align="center" bgcolor="#ffffff"><?=lang('OrderTarifsIntro.tour.tip')?></td>
			  </tr>			
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderFlightAmount')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderFlightAmount'],'Money','form',array('fieldName'=>'TourOrder'.DTR.'TourOrderFlightAmount'))?>&nbsp;&nbsp;<input type="text" name="TourOrder<?=DTR?>TourOrderFlightAmountComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderFlightAmountComment']?>" />
				</td>
			  </tr>		
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderTransferAmount')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderTransferAmount'],'Money','form',array('fieldName'=>'TourOrder'.DTR.'TourOrderTransferAmount'))?>&nbsp;&nbsp;<input type="text" name="TourOrder<?=DTR?>TourOrderTransferAmountComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderTransferAmountComment']?>" />
				</td>
			  </tr>		
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderAssistanceAmount')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderAssistanceAmount'],'Money','form',array('fieldName'=>'TourOrder'.DTR.'TourOrderAssistanceAmount'))?>&nbsp;&nbsp;<input type="text" name="TourOrder<?=DTR?>TourOrderAssistanceAmountComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderAssistanceAmountComment']?>" />
				</td>
			  </tr>		
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderAccommodationAmount')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderAccommodationAmount'],'Money','form',array('fieldName'=>'TourOrder'.DTR.'TourOrderAccommodationAmount'))?>&nbsp;&nbsp;<input type="text" name="TourOrder<?=DTR?>TourOrderAccommodationAmountComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderAccommodationAmountComment']?>" />
				</td>
			  </tr>		
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderCarRentalAmount')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderCarRentalAmount'],'Money','form',array('fieldName'=>'TourOrder'.DTR.'TourOrderCarRentalAmount'))?>&nbsp;&nbsp;<input type="text" name="TourOrder<?=DTR?>TourOrderCarRentalAmountComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderCarRentalAmountComment']?>" />
				</td>
			  </tr>		
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderExcursionsAmount')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderExcursionsAmount'],'Money','form',array('fieldName'=>'TourOrder'.DTR.'TourOrderExcursionsAmount'))?>&nbsp;&nbsp;<input type="text" name="TourOrder<?=DTR?>TourOrderExcursionsAmountComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderExcursionsAmountComment']?>" />
				</td>
			  </tr>
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderOtherServicesAmount')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderOtherServicesAmount'],'Money','form',array('fieldName'=>'TourOrder'.DTR.'TourOrderOtherServicesAmount'))?>&nbsp;&nbsp;<input type="text" name="TourOrder<?=DTR?>TourOrderOtherServicesAmountComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderOtherServicesAmountComment']?>" />
				</td>
			  </tr>		
			  <tr>
				<td class="subtitle" bgcolor="#ffffff"><?=lang('TourOrder.TourOrderInsuranceAmount')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<?=getFormated($out['DB']['TourOrder'][0]['TourOrderInsuranceAmount'],'Money','form',array('fieldName'=>'TourOrder'.DTR.'TourOrderInsuranceAmount'))?>&nbsp;&nbsp;<input type="text" name="TourOrder<?=DTR?>TourOrderInsuranceAmountComment" size="35" value="<?=$out['DB']['TourOrder'][0]['TourOrderInsuranceAmountComment']?>" />
				</td>
			  </tr>
			  <tr>
				<td class="subtitle" bgcolor="#ffffff" valign="top"><?=lang('TourOrder.TourOrderConfidentialInfo')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<textarea name="TourOrder<?=DTR?>TourOrderConfidentialInfo" rows="4" cols="40"><?=$out['DB']['TourOrder'][0]['TourOrderConfidentialInfo']?></textarea>
				</td>
			  </tr>		
			  <tr>
				<td class="subtitle" bgcolor="#ffffff" valign="top"><?=lang('TourOrder.TourOrderRemarksForClient')?></td>
				<td class="subtitle" bgcolor="#ffffff">
					<textarea name="TourOrder<?=DTR?>TourOrderRemarksForClient" rows="4" cols="40"><?=$out['DB']['TourOrder'][0]['TourOrderRemarksForClient']?></textarea>
				</td>
			  </tr>		
			 <tr>
			 	<td colspan="2" align="center" bgcolor="#ffffff">
					<input type="submit" name="goChange" value="<?=lang('-save')?>" />
					&nbsp;&nbsp;<input type="button" name="goCheckout" value="<?=lang('-order')?>" onClick="shoppingCart.actionMode.value='view';shoppingCart.SID.value='order';submit();" />
					&nbsp;&nbsp;<input type="button" name="goRefresh" value="<?=lang('-refresh')?>" onClick="" />
				</td>
			 </tr>
			 </form>	
		 </table> 
	  </td> 
	</tr>
	<? getBox('mail.manageTourMessages'); ?>
<? }?>
<?=boxFooter()?>