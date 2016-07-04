<?=boxHeader(array('title'=>'ManageMailTemplates.core.title'))?>
	<tr> 
	<form name="getMailTemplates" method="post">
	<input type="hidden" name="SID" value="manageMailTemplates" />
	<td valign=top bgcolor="#efefef" align="center" width="100%">
		<?=$out['Refs']['MailTemplates']?>
	</td> 
	</form>
	</tr> 
	<tr>
					<td>
					&nbsp;
					</td>
					</tr>
	<form name="manageMailTemplates" method="post">
		<input type="hidden" name="SID" value="manageMailTemplates" />
		<? if(empty($out['DB']['MailTemplate'][0]['MailTemplateID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="MailTemplate<?=DTR?>MailTemplateID" value="<?=$out['DB']['MailTemplate'][0]['MailTemplateID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
			<tr>
			<td align="left" colspan="2">
					<span class="subtitle"><?=lang('MailTemplateGlobalVariables.core.tip','html')?></span>
			</td>
			</tr>
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('MailTemplate.MailTemplateCode')?>: </span>
			</td>
			<td align="left">	
					<? if(!empty($out['DB']['MailTemplate'][0]['MailTemplateCode'])) { $MailTemplateCode = $out['DB']['MailTemplate'][0]['MailTemplateCode'];} else {$MailTemplateCode = input('MailTemplateCode');} ?>
					<input type="text" name="MailTemplate<?=DTR?>MailTemplateCode" value="<?=$MailTemplateCode?>" size="50">
			</td>
			</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('MailTemplate.MailTemplateName')?>: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
							<input type="text" name="MailTemplate<?=DTR?>MailTemplateName[<?=$langCode?>]" value="<?=getValue($out['DB']['MailTemplate'][0]['MailTemplateName'],$langCode);?>" size="50"/>
						</td>
					</tr>	
					<? } ?>					
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('MailTemplate.MailTemplateSubject')?>: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
							<input type="text" name="MailTemplate<?=DTR?>MailTemplateSubject[<?=$langCode?>]" value="<?=getValue($out['DB']['MailTemplate'][0]['MailTemplateSubject'],$langCode);?>" size="50"/>
						</td>
					</tr>	
					<? } ?>							
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('MailTemplate.MailTemplateBody')?>: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
							<?=getFormated(getValue($out['DB']['MailTemplate'][0]['MailTemplateBody'],$langCode),'HTML','form',array('fieldName'=>'MailTemplate'.DTR.'MailTemplateBody['.$langCode.']','editorName'=>'MailTemplateBody'.$langCode,'editorWidth'=>650,'editorHeight'=>400,'editorToolbar'=>'Default'))?>
						</td>
					</tr>	
					<? } ?>		
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('MailTemplate.MailTemplateBodyText')?>: </span>
						</td>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						<td align="left">
							<textarea name="MailTemplate<?=DTR?>MailTemplateBodyText[<?=$langCode?>]" cols="80" rows="10"><?=getValue($out['DB']['MailTemplate'][0]['MailTemplateBodyText'],$langCode);?></textarea>
						</td>
					</tr>	
					<? } ?>						
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"<?=lang('MailTemplate.MailTemplateDescription')?>: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
							<textarea name="MailTemplate<?=DTR?>MailTemplateDescription[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['MailTemplate'][0]['MailTemplateDescription'],$langCode);?></textarea>
						</td>
					</tr>	
					<? } ?>
					<tr>
					<td align="left">
					<span class="subtitle"><?=lang('MailTemplate.MailTemplateNoHeader')?>: </span>
					</td>
					<td align="left">
					<?=getReference('YesNo','MailTemplate'.DTR.'MailTemplateNoHeader',$out['DB']['MailTemplate'][0]['MailTemplateNoHeader'],array('code'=>'Y'))?>
					</td>
					<tr>
					<td>
					 &nbsp;
					</td>
					</tr>
					<tr>
					<td align="left">
					<span class="subtitle"><?=lang('MailTemplate.PermAll')?>: </span>
					</td>
					<td align="left">
					<?=getReference('PermAll','MailTemplate'.DTR.'PermAll',$out['DB']['MailTemplate'][0]['PermAll'],array('code'=>'Y'))?>
					</td>
					</tr>
					<tr>
					<td>
					&nbsp;
					</td>
					</tr>
					<tr>
					<td align="center" width="100%" colspan="2" bgcolor="#efefef">
					<? if(empty($out['DB']['MailTemplate'][0]['MailTemplateID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageMailTemplates.actionMode.value='delete';confirmDelete('manageMailTemplates', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			</td>
			</tr>
			</table>
			</td> 
		</tr> 
		
	</form>	

<?=boxFooter()?>