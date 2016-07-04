<?=boxHeader(array('title'=>'ManageTabLink.core.title'))?>
	<tr> 
	<form name="getTabLinks" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="TabLinkAlias" value="<?=input('TabLinkAlias')?>" />		
	
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('TabLinkNew.core.tip').' -';
			echo getLists($out['DB']['TabLinks'],$out['DB']['TabLink'][0]['TabLinkID'],array('name'=>'TabLinkID','id'=>'TabLinkID','value'=>'TabLinkName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageTabLinks" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['TabLink'][0]['TabLinkID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="TabLink<?=DTR?>TabLinkID" value="<?=$out['DB']['TabLink'][0]['TabLinkID'];?>" />
		<input type="hidden" name="TabLinkID" value="<?=$out['DB']['TabLink'][0]['TabLinkID'];?>" />
		<input type="hidden" name="TabLinkAlias" value="<?=input('TabLinkAlias')?>" />		
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<input type="hidden" name="TabLink<?=DTR?>TabLinkAlias" value="<?=input('TabLinkAlias')?>" size="50">
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TabLink.TabLinkName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="TabLink<?=DTR?>TabLinkName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['TabLink'][0]['TabLinkName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>	
					<br/>
					<?=lang('TabLink.TabLinkValue')?>*:<br/>
					<input type="text" name="TabLink<?=DTR?>TabLinkValue" value="<?=$out['DB']['TabLink'][0]['TabLinkValue'];?>" size="50">
					<br/>
					<?=lang('TabLink.TabLinkTarget')?>:<br/>
					<?=getReference('target','TabLink'.DTR.'TabLinkTarget',$out['DB']['TabLink'][0]['TabLinkTarget'],array('code'=>'Y'))?>
					<br/>					
					<?=lang('TabLink.AccessGroups')?>:<br/>
					<?
						$options[0]['id']='all';	
						$options[0]['value']=lang('-allgroups');
						echo getLists($out['DB']['UserGroups'],$out['DB']['TabLink'][0]['AccessGroups'],array('name'=>'TabLink'.DTR.'AccessGroups','id'=>'GroupID','value'=>'GroupName','type'=>'checkboxes','options'=>$options));	
					?>						
					<br/>					
					<br/>
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['TabLinks']))
						{
						foreach($out['DB']['TabLinks'] as $row)
						{
							if ($row['TabLinkID']!=$out['DB']['TabLink'][0]['TabLinkID'])
							{
								$i++;
								$options[$i]['id']=$row['TabLinkPosition']+1;	
								$options[$i]['value']=$row['TabLinkName'];
							}
						}
						}
						echo getLists('',$out['DB']['TabLink'][0]['TabLinkPosition']-1,array('name'=>'TabLink'.DTR.'TabLinkPosition','id'=>'TabLinkPosition','value'=>'TabLinkName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['TabLink'][0]['TabLinkID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTabLinks.actionMode.value='delete';confirmDelete('manageTabLinks', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>