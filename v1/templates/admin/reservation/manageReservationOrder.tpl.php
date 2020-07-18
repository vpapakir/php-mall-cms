<? if($input['actionMode']=='save1' || $input['actionMode']=='add' || $input['actionMode']=='view') { ?>
<?=getBox('ReservationOrder.getReservationOrder')?>
<? } else { ?>
<?
	/*$ReservationOrderTemplate = input('ReservationOrderTemplate');
	$ReservationOrderType = $out['DB']['ReservationOrder'][0]['ReservationOrderType']; if(empty($ReservationOrderType)) {$ReservationOrderType=$input['ReservationOrderType'];}
	if(!empty($ReservationOrderType)) {$ReservationOrderTypeName = getListValue($out['DB']['ReservationOrderTypes'],$ReservationOrderType,array('id'=>'ReservationOrderTypeAlias','value'=>'ReservationOrderTypeName'));}
	if(!empty($ReservationOrderTypeName)) {$ReservationOrderTypeTitle = ' > '.$ReservationOrderTypeName;}
	*/
	$title = lang('AddEditReservationOrder.reservation.title').$ReservationOrderTypeTitle;
?>
<?=boxHeader(array('title'=>$title))?>
<? $entityID = $out['DB']['ReservationOrder'][0]['ReservationOrderID']; $categoryID = input('CategoryID'); ?>

	<? 
	   $formName = 'editReservationOrder';
	?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageReservationOrders" />
		<? if(empty($out['DB']['ReservationOrder'][0]['ReservationOrderID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<input type="hidden" name="HelpType" value="<?=input('HelpType')?>" />
		<input type="hidden" name="HelpClientType" value="<?=input('HelpClientType')?>" />
		<?
			$HelpType = input('HelpType');
			$HelpClientType = input('HelpClientType');
			$ReservationOrderCategoryID = input('ReservationOrderCategoryID');
		?>	
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderID" value="<?=$out['DB']['ReservationOrder'][0]['ReservationOrderID']?>">
		<input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderType" value="<?=$out['DB']['ReservationOrder'][0]['ReservationOrderType']?>">
		<? } ?>		
		<? if(empty($out['DB']['ReservationOrder'][0]['ReservationOrderType'])) { ?>
		<input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderType" value="<?=input('ReservationOrderType')?>" />		
		<input type="hidden" name="ReservationOrderType" value="<?=input('ReservationOrderType')?>" />		
		<? } else { ?>
		<input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderType" value="<?=$out['DB']['ReservationOrder'][0]['ReservationOrderType']?>">
		<input type="hidden" name="ReservationOrderType" value="<?=$out['DB']['ReservationOrder'][0]['ReservationOrderType']?>">
		<? } ?>
		<input type="hidden" name="ReservationOrderCategoryID" value="<?=input('ReservationOrderCategoryID')?>" />
		<input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderPosition" value="<? if(!empty($entityID)){ echo $out['DB']['ReservationOrder'][0]['ReservationOrderPosition'];} else { echo input('ReservationOrderPosition');}?>" size="5">
		<!-- <input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
		<input type="hidden" name="ReservationOrderStatus" value="<?=input('ReservationOrderStatus')?>" /> -->
		<!-- <input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderType" value="<?=input('ReservationOrderType')?>" /> -->
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="fieldNames">
							<?
								/*$options[0]['id']='';	
								$options[0]['value']='- '.lang('ReservationOrderTypeSelect.reservation.tip').' -';
								echo getLists($out['DB']['ReservationOrderTypes'],$input['ReservationOrderType'],array('name'=>'ReservationOrderType','id'=>'ReservationOrderTypeAlias','value'=>'ReservationOrderTypeName','style'=>'width:200px;','options'=>$options));	
								*/
							?>	
							<table>
								<tr>
									<td align="center" class="subtitleline" colspan="2">
										<?=lang('ReservationOrderTitle.reservation.tip')?>
									</td>
								</tr>
								<? if(empty($out['DB']['ReservationOrder'][0]['ReservationOrderID']) && (!empty($HelpType) && !empty($HelpClientType) && !empty($ReservationOrderCategoryID))){?>
									<input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderType" value="<?=input('HelpType')?>" />
									<input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderClientType" value="<?=input('HelpClientType')?>" />
								<? }else{?>
								<tr>
									<td>
										<span class="subtitle"><?=lang('ReservationOrder.reservation.ReservationOrderType')?></span>
									</td>
									<td>
										<?=getReference('ReservationOrderType','ReservationOrder'.DTR.'ReservationOrderType',$out['DB']['ReservationOrder'][0]['ReservationOrderType'],array('code'=>'Y'))?>
									</td>
								</tr>
								<tr>
									<td>
										<span class="subtitle"><?=lang('ReservationOrder.reservation.ReservationOrderClientType')?></span>
									</td>
									<td>
										<?=getReference('ViewType','ReservationOrder'.DTR.'ReservationOrderClientType',$out['DB']['ReservationOrder'][0]['ReservationOrderClientType'],array('code'=>'Y'))?>
									</td>
								</tr>
								<? }?>
								<tr>
									<td>
										<span class="subtitle"><?=lang('ReservationOrder.reservation.ReservationOrderCategories')?></span><!-- :<br/> -->
									</td>
									<td>
										<? 
											$ReservationOrderCategoryID = input('ReservationOrderCategoryID');
											if(!empty($out['DB']['ReservationOrder'][0]['ReservationOrderCategories']))
											{
												$parentID = $out['DB']['ReservationOrder'][0]['ReservationOrderCategories'];
											}
											else
											{
												$parentID = '|'.$ReservationOrderCategoryID.'|';
											}								
											echo getLists($out['DB']['ReservationOrderCategories'],$parentID,array('name'=>'ReservationOrder'.DTR.'ReservationOrderCategories','attributes'=>'size="1"','type'=>'multipledropdown','style'=>'width:250px;'));	
										?>
									</td>
								</tr>
								<tr>
									<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<td>	
										<span class="subtitle"><?=lang('ReservationOrder.reservation.ReservationOrderTitle')?></span> 
											<? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
									</td>
									<td>
										<input type="text" name="ReservationOrder<?=DTR?>ReservationOrderTitle[<?=$langCode?>]" id="ReservationOrderTitle_<?=$langCode?>" size="35" value="<?=getValue($out['DB']['ReservationOrder'][0]['ReservationOrderTitle'],$langCode);?>">
									</td>
									<? } ?>	
								</tr>
								<tr>
									<td>
										<span class="subtitle"><?=lang('ReservationOrder.reservation.ReservationOrderLink')?></span>
									</td>
									<td>
										<? if(!empty($out['DB']['ReservationOrder'][0]['ReservationOrderLink'])) {$link = $out['DB']['ReservationOrder'][0]['ReservationOrderLink'];} else {$link='http://';} ?>
										<input type="text" name="ReservationOrder<?=DTR?>ReservationOrderLink" value="<?=$link?>" size="35">
									</td>
								</tr>
								<tr>
									<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
										<td valign="top">
										<span class="subtitle"><?=lang('ReservationOrder.reservation.ReservationOrderIntro')?></span> 
											<? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
										</td>
										<td>
										<textarea name="ReservationOrder<?=DTR?>ReservationOrderIntro[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['ReservationOrder'][0]['ReservationOrderIntro'],$langCode);?></textarea>
										</td>
									<? } ?>	
								</tr>
								<tr>
									<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
										<td valign="top">
										<span class="subtitle"><?=lang('ReservationOrder.reservation.ReservationOrderFull')?></span> 
											<? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
										</td>
										<td>
										<textarea name="ReservationOrder<?=DTR?>ReservationOrderContent[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['ReservationOrder'][0]['ReservationOrderContent'],$langCode);?></textarea>
										</td>
									<? } ?>	
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>
										<input type="hidden" name="fileField"/>
										<? $fieldName = 'ReservationOrderImage';  echo getFormated($out['DB']['ReservationOrder'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'ReservationOrder','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
									</td>
								</tr>
								<? if(count($out['DB']['ReservationOrderField'])>0) {?>
								<tr>
									<td>
										<span class="subtitle"><?=lang('ReservationOrderExtraFieldsList.reservation.tip')?>:</span>&nbsp;&nbsp;<a href="<?=setting('url')?>manageReservationOrderTypes/ReservationOrderType/<?=input('ReservationOrderType')?>" target="_blank">[<?=lang('EditReservationOrderExtraFields.reservation.link')?>]</a><br/><br/>
									</td>
									<td>
										<?=showExtraFieldsForm($out)?>
									</td>
								</tr>
								<tr>
									<td>
										<span class="subtitle"><?=lang('ReservationOrderOptionsList.reservation.tip')?>:</span>&nbsp;&nbsp;<a href="<?=setting('url')?>manageReservationOrderTypes/ReservationOrderType/<?=input('ReservationOrderType')?>" target="_blank">[<?=lang('EditReservationOrderExtraOptions.reservation.link')?>]</a><br/><br/>
									</td>
									<td>
										<?=showExtraOptionsForm($out)?>
									</td>
								</tr>
								<?  } ?>
								<tr>
									<td>
										<span class="subtitle"><?=lang('ReservationOrder.reservation.PermAll')?></span>
									</td>
									<td>
										<? if(empty($out['DB']['ReservationOrder'][0]['PermAll'])) { $out['DB']['ReservationOrder'][0]['PermAll'] = 'active';} ?>
										<? //getReference('ReservationOrder.ReservationOrderStatus','ReservationOrder'.DTR.'ReservationOrderStatus',$out['DB']['ReservationOrder'][0]['ReservationOrderStatus'],array('code'=>'Y'))?>
										<?=getReference('PermAll','ReservationOrder'.DTR.'PermAll',$out['DB']['ReservationOrder'][0]['PermAll'],array('code'=>'Y'))?>
									</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td colspan="2" align="center">
										<span class="subtitle"><?=lang('SaveReservationOrderWarning.reservation.tip')?></span>
									</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td align="center" class="subtitleline" colspan="2">
										<? if(empty($out['DB']['ReservationOrder'][0]['ReservationOrderID'])) { ?>
										<input type="submit" value="<?=lang("-add")?>">
										<? } else { ?>
										<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.editReservationOrder.actionMode.value='delete';confirmDelete('editReservationOrder', '<?=lang("-deleteconfirmation")?>');">
										<? } ?>
										&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.editReservationOrder.actionMode.value='cancell';submit();">
									</td>
								</tr>
							</table>
						</td>
					</tr>	
					</table>	
			</td> 
		</tr> 
	</form>
	<? /*?>
	<script language="JavaScript">
			var fromValidator = new Validator("<?=$formName?>");
			//fromValidator.addValidation("ReservationOrder<?=DTR?>ReservationOrderAlias","req","<?=lang('ReservationOrderCategoryAlias.products.tip')?>");
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				fromValidator.addValidation("ReservationOrder<?=DTR?>ReservationOrderTitle[<?=$langCode?>]","req","<?=lang('ReservationOrderTitle.products.tip')?>");
			<? }?>
	</script>	
	<? */ ?>
<?=boxFooter()?>
<? } ?>