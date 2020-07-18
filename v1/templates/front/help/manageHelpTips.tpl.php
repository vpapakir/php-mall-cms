<?=boxHeader(array('title'=>'ManageHelpArticles.HelpArticle.title'))?>
	<tr> 
	<form name="getHelpArticles" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('HelpArticleNew.HelpArticle.tip').' -';
			echo getLists($out['DB']['HelpArticles'],$out['DB']['HelpArticle'][0]['HelpArticleID'],array('name'=>'HelpArticleID','id'=>'HelpArticleID','value'=>'HelpArticleAlias','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageHelpArticles" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['HelpArticle'][0]['HelpArticleID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="HelpArticle<?=DTR?>HelpArticleID" value="<?=$out['DB']['HelpArticle'][0]['HelpArticleID'];?>" />
		<input type="hidden" name="HelpArticle<?=DTR?>HelpArticleType" value="tips" />
		<input type="hidden" name="HelpArticleID" value="<?=$out['DB']['HelpArticle'][0]['HelpArticleID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<?=lang('HelpArticle.HelpArticleClientType')?>: <br/>
					<? if(empty($out['DB']['HelpArticle'][0]['HelpArticleClientType'])) $out['DB']['HelpArticle'][0]['HelpArticleClientType'] = input('HelpArticle'.DTR.'HelpArticleClientType'); ?>
					<?=getReference('ViewType','HelpArticle'.DTR.'HelpArticleClientType',$out['DB']['HelpArticle'][0]['HelpArticleClientType'],array('code'=>'Y','action'=>'submit();'))?>
					<br/><br/>
					<?=lang('HelpArticle.HelpArticleSections')?>:<br/>
					<?=getLists($out['DB']['SectionsList'],$out['DB']['HelpArticle'][0]['HelpArticleSections'],array('name'=>'HelpArticle'.DTR.'HelpArticleSections[]','style'=>'width:300px;'))?>
					<br/><br/>
					<?=lang('HelpArticle.HelpArticleAlias')?>*:<br/>
					<input type="text" name="HelpArticle<?=DTR?>HelpArticleAlias" value="<?=$out['DB']['HelpArticle'][0]['HelpArticleAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('HelpArticle.HelpArticleTitle')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="HelpArticle<?=DTR?>HelpArticleTitle[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['HelpArticle'][0]['HelpArticleTitle'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>	
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('HelpArticle.HelpArticleContent')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<textarea name="HelpArticle<?=DTR?>HelpArticleContent[<?=$langCode?>]" cols="70" rows="5"><?=getValue($out['DB']['HelpArticle'][0]['HelpArticleContent'],$langCode);?></textarea>
						</td>
					</tr>	
					<? } ?>			
					</table>							
					<br/>
					<br/>
					<?=lang('HelpArticle.HelpArticleImage')?>:<br/>
					<? if(!empty($out['DB']['HelpArticle'][0]['HelpArticleImage'])) { ?>
						<img src="<?=setting('urlfiles').$out['DB']['HelpArticle'][0]['HelpArticleImage']?>" border="0" />
						<br/>
						<a href="<?=setting('url').input('SID')?>/ResourceID/<?=$out['DB']['HelpArticle'][0]['HelpArticleID']?>/actionMode/deletefile/fileField/HelpArticleImage"><?=lang('-deleteimage')?></a>
					<? } ?>
					<br/>
					<input size="22" type="file" name="uploadFile[HelpArticleImage]" />
					<input type="hidden" name="oldUploadFile[HelpArticleImage]" value="<?=$out['DB']['HelpArticle'][0]['HelpArticleImage']?>" />
					<br/><br/>
					<?=lang('HelpArticle.HelpArticleLanguages')?>:<br/>
					<?
						foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
						{
							$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
							$languagesList[$langID]['value']=$langName;		
						}								
						echo getLists($languagesList,$out['DB']['HelpArticle'][0]['HelpArticleLanguages'],array('name'=>'HelpArticle'.DTR.'HelpArticleLanguages','type'=>'checkboxes'));	
					?>	
					<br/><br/>
					<?=lang('HelpArticle.HelpArticleComments')?>:<br/>
					<textarea name="HelpArticle<?=DTR?>'HelpArticleComments'" rows="5" cols="60"><?=$out['DB']['HelpArticle'][0]['HelpArticleComments']?></textarea>
					<br/><br/>
					<? /* =lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['HelpArticles']))
						{
						foreach($out['DB']['HelpArticles'] as $row)
						{
							if ($row['HelpArticleID']!=$out['DB']['HelpArticle'][0]['HelpArticleID'])
							{
								$i++;
								$options[$i]['id']=$row['HelpArticlePosition']+1;	
								$options[$i]['value']=$row['HelpArticleAlias'];
							}
						}
						}
						echo getLists('',$out['DB']['HelpArticle'][0]['HelpArticlePosition']-1,array('name'=>'HelpArticle'.DTR.'HelpArticlePosition','id'=>'HelpArticlePosition','value'=>'HelpArticleAlias','options'=>$options));	
						$options='';
					*/?>
					
					<?=lang('HelpArticle.PermAll')?>:<br/>
					<?=getReference('PermAll','HelpArticle'.DTR.'PermAll',$out['DB']['HelpArticle'][0]['PermAll'],array('code'=>'Y'))?>
					<br/><br/>
					<? if(empty($out['DB']['HelpArticle'][0]['HelpArticleID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageHelpArticles.actionMode.value='delete';confirmDelete('manageHelpArticles', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>