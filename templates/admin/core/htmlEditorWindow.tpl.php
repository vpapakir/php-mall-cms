<?=boxHeader(array('title'=>'HTMLEditorWindow'))?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
		<form name="htmlEditor" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="actionMode" value="save" />
			<input type="hidden" name="Section<?=DTR?>SectionID" value="<?=setting('PageID')?>">
			
				<?=getFormated(getValue($out['DB']['Section'][0]['SectionContent'],$langCode),'HTML','form',array('fieldName'=>'Section'.DTR.'SectionContent['.$langCode.']','editorName'=>'SectionContent'.$langCode,'editorWidth'=>550,'editorHeight'=>400,'editorToolbar'=>'Default'))?>
								
			<br>			
			<? //setting('PageContent')?>
			<br>
			<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageSection.actionMode.value='cancell';submit();">			
		</form>
		</td> 
	</tr>
<?=boxFooter()?>