<?=boxHeader(array('title'=>'ManageServiceProducts.billing.title'))?>
<? $entityID = $out['DB']['Service'][0]['ServiceID']; $categoryID = input('CategoryID'); ?>
	<form name="manageServices" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageServices" />
		<input type="hidden" name="CategoryID" value="<?= input(CategoryID)?>" />
		<? if(empty($out['DB']['Service'][0]['ServiceID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<input type="hidden" name="ServiceType" value="servis" />	
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="Service<?=DTR?>ServiceID" value="<?=$out['DB']['Service'][0]['ServiceID']?>">
		<input type="hidden" name="Service<?=DTR?>ServiceType" value="<?=$out['DB']['Service'][0]['ServiceType']?>">
		<? } ?>		
		<? if(empty($out['DB']['Service'][0]['ServiceType'])) { ?>
		<input type="hidden" name="Service<?=DTR?>ServiceType" value="<?=input('ServiceType')?>" />		
		<? } else { ?>
		<input type="hidden" name="Service<?=DTR?>ServiceType" value="<?=$out['DB']['Service'][0]['ServiceType']?>">
		<? } ?>			
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="fieldNames">
							<input type="hidden" name="Service<?=DTR?>ServicePosition" value="<? if(!empty($entityID)){ echo $out['DB']['Service'][0]['ServicePosition'];} else { echo input('ServicePosition');}?>" size="5">					
							<?=lang('Service.ServiceCategories')?>:<br/>
							<?
								if(!empty($out['DB']['Service'][0]['ServiceCategories']))
								{
									$parentID = $out['DB']['Service'][0]['ServiceCategories'];
								}
								else
								{
									$parentID = '|'.$categoryID.'|';
								}
								echo getLists($out['DB']['ServiceCategories'],$parentID,array('name'=>'Service'.DTR.'ServiceCategories','type'=>'multipledropdown','style'=>'width=500px;'));	
							?>
							<br/>
							<?=lang('Service.ServiceAlias')?>:<br/>
							<input type="text" name="Service<?=DTR?>ServiceAlias" value="<?=$out['DB']['Service'][0]['ServiceAlias'];?>" size="30">
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Service.ServiceTitle')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<input type="text" name="Service<?=DTR?>ServiceTitle[<?=$langCode?>]" size="30" value="<?=getValue($out['DB']['Service'][0]['ServiceTitle'],$langCode);?>">
								<br/>
							<? } ?>	
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Service.ServiceDescription')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="Service<?=DTR?>ServiceDescription[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['Service'][0]['ServiceDescription'],$langCode);?></textarea>
								<br/>
							<? } ?>	
							<br/>
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Service.ServiceComments')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="Service<?=DTR?>ServiceComments[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['Service'][0]['ServiceComments'],$langCode);?></textarea>
								<br/>
							<? } ?>	
							<br>
							<hr size="1">
							
							<? /* =lang('Service.ServiceLanguages')?>:<br/>
							<?
								foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
								{
									$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
									$languagesList[$langID]['value']=$langName;		
								}								
								echo getLists($languagesList,$out['DB']['Service'][0]['ServiceLanguages'],array('name'=>'Service'.DTR.'ServiceLanguages','type'=>'checkboxes'));	
								*/
							?>	
							
							<br/>					
							<hr size="1">
							<?=lang('Service.ServicePeriod')?>:<br/>
							<input type="text" name="Service<?=DTR?>ServicePeriod" value="<?=$out['DB']['Service'][0]['ServicePeriod']?>" size="5"> <?=lang('ServicePeriodDays.billing.tip')?>
							<br/>	
							<?=lang('Service.ServicePriceRangeMin')?>:<br/>
							<?=getFormated($out['DB']['Service'][0]['ServicePriceRangeMin'],'Money','form',array('fieldName'=>'Service'.DTR.'ServicePriceRangeMin'))?>
							<br/>	
							<?=lang('Service.ServicePriceRangeMax')?>:<br/>
							<?=getFormated($out['DB']['Service'][0]['ServicePriceRangeMax'],'Money','form',array('fieldName'=>'Service'.DTR.'ServicePriceRangeMax'))?>
							<hr size="1">
							<?=lang('Service.ServicePrice')?>:<br/>
							<?=getFormated($out['DB']['Service'][0]['ServicePrice'],'Money','form',array('fieldName'=>'Service'.DTR.'ServicePrice'))?>
							<br/>	
							<?=lang('Service.ServiceCommission')?>:<br/>
							<input type="text" name="Service<?=DTR?>ServiceCommission" value="<?=$out['DB']['Service'][0]['ServiceCommission']?>" size="5"> %
							<hr size="1">
							<br/>
							<!-- Icon Image -->
							<? if(!empty($out['DB']['Service'][0]['ServiceIcon'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['Service'][0]['ServiceIcon']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/ServiceID/<?=$out['DB']['Service'][0]['ServiceID']?>/CategoryID/<?=input('CategoryID')?>/actionMode/deletefile/fileField/ServiceIcon"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br>
							<?=lang('Service.ServiceIcon')?>:<br/>
							<input size="22" type="file" name="uploadFile[ServiceIcon]" />
							<input type="hidden" name="oldUploadFile[ServiceIcon]" value="<?=$out['DB']['Service'][0]['ServiceIcon']?>" />
							<br/>
							<hr size="1">
							<?=lang('Service.PermAll')?>:<br/>
							<? if(empty($out['DB']['Service'][0]['PermAll'])) {$out['DB']['Service'][0]['PermAll']=1;} ?>
							<?=getReference('PermAll','Service'.DTR.'PermAll',$out['DB']['Service'][0]['PermAll'],array('code'=>'Y'))?>
							<br/>	
						</td>
					</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['Service'][0]['ServiceID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageServices.actionMode.value='delete';confirmDelete('manageServices', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageServices.actionMode.value='cancell';submit();">
					
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>