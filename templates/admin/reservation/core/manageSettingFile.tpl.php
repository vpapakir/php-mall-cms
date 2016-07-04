<?=boxHeader(array('title'=>'ManageSettingFile.core.title'))?>
	<form name="manageSettings" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageSettings" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
		<input type="hidden" name="SettingID" value="<?=input('SettingID')?>" />
		<? if(empty($out['DB']['Setting'][0]['SettingID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="Setting<?=DTR?>SettingID" value="<?=$out['DB']['Setting'][0]['SettingID']?>">
		<input type="hidden" name="Setting<?=DTR?>SettingVariableName" value="<?=$out['DB']['Setting'][0]['SettingVariableName']?>">
		<? } ?>		
		<!--input type="hidden" name="Setting<?=DTR?>SettingID" value="<?=$out['DB']['Setting'][0]['SettingID'];?>" /-->
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="fieldNames">
						<br/>
							<? if($out['DB']['Setting'][0]['SettingValueType']=='image') { ?>
							<? if(!empty($out['DB']['Setting'][0]['SettingValue'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['Setting'][0]['SettingValue']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/SettingID/<?=$out['DB']['Setting'][0]['SettingID']?>/GroupID/<?=input('GroupID')?>/actionMode/deletefile/fileField/SettingValue"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<input size="22" type="file" name="uploadFile[SettingValue]" />
							<input type="hidden" name="oldUploadFile[SettingValue]" value="<?=$out['DB']['Setting'][0]['SettingValue']?>" />
							
							<? } elseif($out['DB']['Setting'][0]['SettingValueType']=='file') { ?>
							<? if(!empty($out['DB']['Setting'][0]['SettingValue'])) { ?>
								<a href="<?=setting('urlfiles').$out['DB']['Setting'][0]['SettingValue']?>"><?=lang('-download')?></a>
								<br/>
								<a href="<?=setting('url').input('SID')?>/SettingID/<?=$out['DB']['Setting'][0]['SettingID']?>/GroupID/<?=input('GroupID')?>/actionMode/deletefile/fileField/SettingValue"><?=lang('-deleteimage')?></a>
							<? } ?>
							<input size="22" type="file" name="uploadFile[SettingValue]" />
							<input type="hidden" name="oldUploadFile[SettingValue]" value="<?=$out['DB']['Setting'][0]['SettingValue']?>" />
																	
							<? } ?>
						</td>
					</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['Setting'][0]['SettingID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">
					<? } ?>					
					
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>