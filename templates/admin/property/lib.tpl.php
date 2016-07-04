<?
//templates functions library
function showExtraFieldsForm($out)
{
	if(is_array($out['DB']['PropertyField'])) { foreach($out['DB']['PropertyField'] as $fieldCode=>$field) { if($field['mode']!='option' && !empty($field['code'])) { $value = getValue($field['value']); ?>
	<tr>
		<td valign="top" class="subtitle">
			<? if($field['status']==2){
			?><input type="checkbox" name="PropertyFieldStatus[<?=$fieldCode?>]" value="1" ><?
			}else{
			?><input type="checkbox" name="PropertyFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
			}?>					
			<?=getValue($field['name'])?>
		</td>
	<td>
	<? if(is_array($field['options'])) { 
		echo getLists($field['options'],$field['value'],array('name'=>'PropertyField'.DTR.$fieldCode,'type'=>$field['type']));												
	} elseif ($field['type']=='text') {
		 foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<?=$out['DB']['Languages']['languageNames'][$langID]?><br/>
			<textarea name="PropertyField<?=DTR.$fieldCode.'['.$langCode.']';?>" cols="70" rows="5"><?=getValue($field['value'],$langCode)?></textarea>
			<br/>
	<? } } elseif ($field['type']=='image') { ?>
		<?  if(!empty($value)) { ?>
			<img src="<?=setting('urlfiles').$value?>" border="0" />
			<br/>
			<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/CategoryID/<?=input('CategoryID')?>/PropertyType/<?=input('PropertyType')?>/PropertyField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deleteimage')?></a>
		<? } ?>			
			<br/>
			<input type="hidden" name="PropertyField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
			<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
			<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
		<? } elseif ($field['type']=='file') { ?>
			<?  if(!empty($value)) { ?>
				<br/>
				<a href="<?=setting('urlfiles').$value?>">[<?=lang('-download')?>]</a>
				<br/><br/>
				<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/CategoryID/<?=input('CategoryID')?>/PropertyType/<?=input('PropertyType')?>/PropertyField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deletefile')?></a>
			<? } ?>			
				<br/>
				<input type="hidden" name="PropertyField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
				<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
				<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
	
		<? } else { ?>
		<input type="text" name="PropertyField<?=DTR.$fieldCode?>" value="<?=$value?>" size="20">
	<? } ?>
	<br/><br/>
	<? } } }?>
	</td>
	</tr>
	<?
}

function showExtraOptionsForm($out)
{
 foreach($out['DB']['PropertyField'] as $fieldCode=>$field) { if($field['mode']=='option') { ?>
	<tr>
		<td valign="top" class="subtitle">
			<? if($field['status']==2){
			?><input type="checkbox" name="PropertyFieldStatus[<?=$fieldCode?>]" value="1" ><?
			}else{
			?><input type="checkbox" name="PropertyFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
			}?>	
			<?=getValue($field['name'])?>
		</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="3">
			<tr>
				<td>&nbsp;</td>
				<td width="150">&nbsp;</td>
				<td align="center"><?=lang('PlusMinusPrice.property.tip')?></td>
				<td><?=lang('OptionPrice.property.tip')?></td>
				<td align="center"><?=lang('PlusMinusWeight.property.tip')?></td>
				<td><?=lang('OptionWeight.property.tip')?></td>
			</tr>		
			<input type="hidden" name="PropertyField<?=DTR.$fieldCode?>" value="_" size="5">
			<? foreach ($field['options'] as $id=>$row) { $fieldTypeOptionID=$row['id'];?>
			<input type="hidden" name="PropertyOptionFieldCode[<?=$id?>]" value="<?=$fieldCode?>">
			<input type="hidden" name="PropertyOption<?=DTR?>PropertyOptionID[<?=$id?>]" value="<?=$row['PropertyOptionID']?>">
			<input type="hidden" name="PropertyOption<?=DTR?>PropertyFieldID[<?=$id?>]" value="<?=$row['PropertyFieldID']?>">
			<input type="hidden" name="PropertyOption<?=DTR?>PropertyTypeOptionID[<?=$id?>]" value="<?=$fieldTypeOptionID?>">
			<tr>
				<td>
					<?
						if($row['PropertyOptionStatus']==2){
						?><input type="checkbox" name="PropertyOption<?=DTR?>PropertyOptionStatus[<?=$id?>]" value="1" ><?
						}else{
						?><input type="checkbox" name="PropertyOption<?=DTR?>PropertyOptionStatus[<?=$id?>]" value="1" checked="1" ><?
						}
					?>
				</td>
				<td><?=getValue($row['value'])?></td>
				<td><input type="text" name="PropertyOption<?=DTR?>PropertyOptionPriceAction[<?=$id?>]" value="<?=$row['PropertyOptionPriceAction']?>" size="1" ></td>
				<td><input type="text" name="PropertyOption<?=DTR?>PropertyOptionPrice[<?=$id?>]" value="<?=$row['PropertyOptionPrice']?>" size="10"></td>
				<td><input type="text" name="PropertyOption<?=DTR?>PropertyOptionWeightAction[<?=$id?>]" value="<?=$row['PropertyOptionWeightAction']?>" size="1" ></td>
				<td><input type="text" name="PropertyOption<?=DTR?>PropertyOptionWeight[<?=$id?>]" value="<?=$row['PropertyOptionWeight']?>" size="10"></td>
			</tr>
			<? } ?>
		</table>
		<br/>
<? } }		
?>
	</td>
	</tr>
<?
}
?>

<?
//templates functions library
function showExtraFieldsShow($out)
{
	if(is_array($out['DB']['PropertyField'])) { foreach($out['DB']['PropertyField'] as $fieldCode=>$field) { if($field['mode']!='option' && !empty($field['code'])) { $value = getValue($field['value']); ?>
	<tr>
		<td valign="top" class="subtitle">
			<?=getValue($field['name'])?>
		</td>
		<td>
		<? if(is_array($field['options'])) { 
			echo getListValue($field['options'],$field['value'],array('name'=>'PropertyField'.DTR.$fieldCode,'type'=>$field['type']));												
		} elseif ($field['type']=='text') {?>
				<?=getValue($field['value'])?>
				<br/>
			<? } else { ?>
			<?=$value?>
		<? } ?>
		<? } } }?>
		</td>
	</tr>
	<?
}

function showExtraOptionsShow($out)
{
 foreach($out['DB']['PropertyField'] as $fieldCode=>$field) { if($field['mode']=='option') { ?>
	<tr>
		<td valign="top" class="subtitle">
			<?=getValue($field['name'])?>
		</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="3">
			<tr>
				<td>&nbsp;</td>
				<td width="150">&nbsp;</td>
				<td align="center"><?=lang('PlusMinusPrice.property.tip')?></td>
				<td><?=lang('OptionPrice.property.tip')?></td>
				<td align="center"><?=lang('PlusMinusWeight.property.tip')?></td>
				<td><?=lang('OptionWeight.property.tip')?></td>
			</tr>		
			<? foreach ($field['options'] as $id=>$row) { $fieldTypeOptionID=$row['id'];?>
			<tr>
				<td><?=getValue($row['value'])?></td>
				<td><?=$row['PropertyOptionPriceAction']?></td>
				<td><?=$row['PropertyOptionPrice']?></td>
				<td><?=$row['PropertyOptionWeightAction']?></td>
				<td><?=$row['PropertyOptionWeight']?></td>
			</tr>
			<? } ?>
		</table>
		<br/>
<? } }		
?>
	</td>
	</tr>
<?
}
?>