<?=boxHeader(array('title'=>setting('PageName'))); if (input('viewMode')=='edit') { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
		<form name="manageSection" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="actionMode" value="save" />
			<input type="hidden" name="Section<?=DTR?>SectionID" value="<?=setting('PageID')?>">
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<?=$out['DB']['Languages']['languageNames'][$langID]?>
				<br/>
				<?=getFormated(getValue($out['DB']['Section'][0]['SectionContent'],$langCode),'HTML','form',array('fieldName'=>'Section'.DTR.'SectionContent['.$langCode.']','editorName'=>'SectionContent'.$langCode,'editorWidth'=>550,'editorHeight'=>400,'editorToolbar'=>'Default'))?>
				<br/>
			<? } ?>								
			<br>			
			<? //setting('PageContent')?>
			<br>
			<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageSection.actionMode.value='cancell';submit();">			
		</form>
		</td> 
	</tr>
	<? } else { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<? if(hasRights('admin')) {?><a href="<?=setting('url').input('SID')?>/viewMode/edit">[<?=lang('-edit')?>]</a> <br/><? } ?>
			<?=setting('PageContent')?>
		</td> 
	</tr> 
	<? } ?>
<?=boxFooter()?>