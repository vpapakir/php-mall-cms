<? if(setting('PageIntroIsShown')!='Y') { ?>

<? if(eregi("\|hidetitle\|",setting('PageViewOptions'))) { ?>
	<?=boxHeader(array('title'=>''))?>
<? } else { 
		if(setting('PageTitle')) { $title = setting('PageTitle'); } else { $title = setting('PageName'); }
?>
	<?=boxHeader(array('title'=>$title)); ?>
<? } ?>
	<? if (input('viewMode')=='edit') { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
		<form name="manageSection" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="actionMode" value="save" />
			<input type="hidden" name="Section<?=DTR?>SectionID" value="<?=setting('PageID')?>">
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<?=lang('Section.SectionName')?> <?=$out['DB']['Languages']['languageNames'][$langID]?>
				<br/>
				<input type="text" name="Section<?=DTR?>SectionName[<?=$langCode?>]" value="<?=getValue($out['DB']['Section'][0]['SectionName'],$langCode)?>" size="30" />
				<br/>
			<? } ?>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<?=lang('Section.SectionTitle')?> <?=$out['DB']['Languages']['languageNames'][$langID]?>
				<br/>
				<input type="text" name="Section<?=DTR?>SectionTitle[<?=$langCode?>]" value="<?=getValue($out['DB']['Section'][0]['SectionTitle'],$langCode)?>" size="30" />
				<br/>
			<? } ?>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<?=lang('Section.SectionListingText')?> <?=$out['DB']['Languages']['languageNames'][$langID]?>
				<br/>
				<? //=getFormated(getValue($out['DB']['Section'][0]['SectionListingText'],$langCode),'HTML','form',array('fieldName'=>'Section'.DTR.'SectionListingText['.$langCode.']','editorName'=>'SectionListingText'.$langCode,'editorWidth'=>550,'editorHeight'=>200,'editorToolbar'=>'Default'))?>
                <textarea name="Section<?=DTR?>SectionListingText[<?=$langCode?>]" cols="80" rows="5"><?=getValue($out['DB']['Section'][0]['SectionListingText'],$langCode);?></textarea>
				<br/>
			<? } ?>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<?=lang('Section.SectionIntroContent')?> <?=$out['DB']['Languages']['languageNames'][$langID]?>
				<br/>
				<?=getFormated(getValue($out['DB']['Section'][0]['SectionIntroContent'],$langCode),'HTML','form',array('fieldName'=>'Section'.DTR.'SectionIntroContent['.$langCode.']','editorName'=>'SectionIntroContent'.$langCode,'editorWidth'=>550,'editorHeight'=>200,'editorToolbar'=>'Default'))?>
				<br/>
			<? } ?>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<?=lang('Section.SectionContent')?> <?=$out['DB']['Languages']['languageNames'][$langID]?>
				<br/>
				<?=getFormated(getValue($out['DB']['Section'][0]['SectionContent'],$langCode),'HTML','form',array('fieldName'=>'Section'.DTR.'SectionContent['.$langCode.']','editorName'=>'SectionContent'.$langCode,'editorWidth'=>550,'editorHeight'=>400,'editorToolbar'=>'Default'))?>
				<br/>
			<? } ?>								
			<br>			
			<? //setting('PageContent')?>
			
			<?=lang('Section.SectionViewOptions')?>
			<br>
			<?=getReference('Section.SectionViewOptions','Section'.DTR.'SectionViewOptions',setting('PageViewOptions'),array('code'=>'Y'))?>
			<br>
			<br>
			<?=lang('Section.SectionCommentsOptions')?>
			<br>
			<?=getReference('Section.SectionCommentsOptions','Section'.DTR.'SectionCommentsOptions',setting('PageCommentsOptions'),array('code'=>'Y'))?>
			<br>
			<br>
			<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageSection.actionMode.value='cancell';submit();">			
		</form>
		</td> 
	</tr>
	<? } else { ?>
	<? if(setting('PageIntroContent') || setting('PageContent')) { ?>
	<tr> 
		<td valign="top">
			<? if(setting('PageIntroContent')) { ?><br/><div><?=getFormated(setting('PageIntroContent'),'HTML')?></div><br/><? } ?>
			<? if(setting('PageContent')) { ?><?=getFormated(setting('PageContent'),'HTML')?><br/><br/><? } ?>
		</td> 
	</tr> 
	<? } ?>
	<? if(hasRights('admin') || eregi("\|".user('UserID')."\|",setting('PageAccessEditUsers'))) {?>
	<tr> 
		<td valign="top">
			<br/><a href="<?=setting('url').input('SID')?>/viewMode/edit">[<?=lang('-edit')?>]</a>
		</td> 
	</tr> 

	<tr>
        <td>
	<? } ?>
	<? if(eregi("\|lowerlevellist\|",setting('PageViewOptions'))) { getBox('core.getSectionsList'); } ?>
	<? if(setting('PageViewType')) { getBox(setting('PageViewType')); } ?>
	<? } ?>
	<? 
		if(eregi("\|active\|",setting('PageCommentsOptions'))) { 
			getBox('resource.getComments',array('side'=>'center')); 
		} 
	?> 
        </td>
    </tr>
<?=boxFooter()?>

<? } //end of if(setting('PageIntroIsShown')!='Y') { ?>