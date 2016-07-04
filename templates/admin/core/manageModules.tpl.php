<?=boxHeader(array('title'=>'ManageModule.core.title'))?>
	<tr> 
	<form name="getModules" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="ModuleAlias" value="<?=input('ModuleAlias')?>" />		
	
	<td valign=top bgcolor="#efefef" width="100%" align="center">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('ModuleNew.core.tip').' -';
			echo getLists($out['DB']['Modules'],$out['DB']['Module'][0]['ModuleID'],array('name'=>'ModuleID','id'=>'ModuleID','value'=>'ModuleName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr>
	<form name="manageModules" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['Module'][0]['ModuleID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="Module<?=DTR?>ModuleID" value="<?=$out['DB']['Module'][0]['ModuleID'];?>" />
		<input type="hidden" name="ModuleID" value="<?=$out['DB']['Module'][0]['ModuleID'];?>" />
		<input type="hidden" name="ModuleAlias" value="<?=input('ModuleAlias')?>" />		
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('Module.ModuleAlias')?>*:</span>
			</td>
			<td align="left">
					<input type="text" name="Module<?=DTR?>ModuleAlias" value="<?=$out['DB']['Module'][0]['ModuleAlias']?>" size="50">
			</td>
			</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('Module.ModuleName')?>*: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
							<input type="text" name="Module<?=DTR?>ModuleName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['Module'][0]['ModuleName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<span class="subtitle"><?=lang('Module.ModuleDescription')?>*: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
							<textarea name="Module<?=DTR?>ModuleDescription[<?=$langCode?>]" cols="70" rows="5"><?=getValue($out['DB']['Module'][0]['ModuleName'],$langCode);?></textarea>
						</td>
					</tr>	
					<? } ?>						
					<? /* =lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['Modules']))
						{
						foreach($out['DB']['Modules'] as $row)
						{
							if ($row['ModuleID']!=$out['DB']['Module'][0]['ModuleID'])
							{
								$i++;
								$options[$i]['id']=$row['ModulePosition']+1;	
								$options[$i]['value']=$row['ModuleName'];
							}
						}
						}
						echo getLists('',$out['DB']['Module'][0]['ModulePosition']-1,array('name'=>'Module'.DTR.'ModulePosition','id'=>'ModulePosition','value'=>'ModuleName','options'=>$options));	
						$options='';
					*/?>
					<tr>
					<td align="center" bgcolor="#efefef" colspan="2">
					<? if(empty($out['DB']['Module'][0]['ModuleID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageModules.actionMode.value='delete';confirmDelete('manageModules', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
				</td>
				</tr>
				</table>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>