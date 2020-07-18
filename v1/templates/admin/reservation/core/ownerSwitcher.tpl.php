<? //=boxHeader('','')?>
<?
	if(is_array($out['DB']['Owners']) && count($out['DB']['Owners'])>1)
	{?>
		<table border="0" cellpadding="0" cellspacing="0" >
		<form method="post" name="ownerSwitcher">
			<tr>
				<td>
					<? getBox('core.languageSwitcher');?>
					&nbsp;
					<select name="switchOwner" onChange="selectLink('ownerSwitcher','switchOwner','','')">
					<?
						foreach($out['DB']['Owners'] as $owner)
						{
							if($owner['OwnerCode']==setting('OwnerID')) {$selected = "selected";} else {$selected = '';}?>
							<option value="<?=setting('rooturl').setting('LoaderName').'/'.$owner['OwnerCode'].'.'.setting('lang')?>/<?=input('SID')?>/<?=getInputLink()?>" <?=$selected?> ><?=getValue($owner['OwnerName'])?></option>
					<?	}?>
					</select>
				</td>
			</tr>
		</form>
		</table>
<?	}?>
<? // =boxFooter()?>