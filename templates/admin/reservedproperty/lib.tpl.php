<?
//templates functions library
function showExtraFieldsForm($out)
{
	if(is_array($out['DB']['ReservedPropertyField'])) { foreach($out['DB']['ReservedPropertyField'] as $fieldCode=>$field) { if($field['mode']!='option' && !empty($field['code'])) { $value = getValue($field['value']); ?>
	<tr>
		<td valign="top" class="subtitle">
			<? if($field['status']==2){
			?><input type="checkbox" name="ReservedPropertyFieldStatus[<?=$fieldCode?>]" value="1" ><?
			}else{
			?><input type="checkbox" name="ReservedPropertyFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
			}?>					
			<?=getValue($field['name'])?>
		</td>
	<td>
	<? if(is_array($field['options'])) { 
		echo getLists($field['options'],$field['value'],array('name'=>'ReservedPropertyField'.DTR.$fieldCode,'type'=>$field['type']));												
	} elseif ($field['type']=='text') {
		 foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<?=$out['DB']['Languages']['languageNames'][$langID]?><br/>
			<textarea name="ReservedPropertyField<?=DTR.$fieldCode.'['.$langCode.']';?>" cols="70" rows="5"><?=getValue($field['value'],$langCode)?></textarea>
			<br/>
	<? } } elseif ($field['type']=='image') { ?>
		<?  if(!empty($value)) { ?>
			<img src="<?=setting('urlfiles').$value?>" border="0" />
			<br/>
			<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/CategoryID/<?=input('CategoryID')?>/ReservedPropertyType/<?=input('ReservedPropertyType')?>/ReservedPropertyField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deleteimage')?></a>
		<? } ?>			
			<br/>
			<input type="hidden" name="ReservedPropertyField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
			<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
			<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
		<? } elseif ($field['type']=='file') { ?>
			<?  if(!empty($value)) { ?>
				<br/>
				<a href="<?=setting('urlfiles').$value?>">[<?=lang('-download')?>]</a>
				<br/><br/>
				<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/CategoryID/<?=input('CategoryID')?>/ReservedPropertyType/<?=input('ReservedPropertyType')?>/ReservedPropertyField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deletefile')?></a>
			<? } ?>			
				<br/>
				<input type="hidden" name="ReservedPropertyField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
				<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
				<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
	
		<? } else { ?>
		<input type="text" name="ReservedPropertyField<?=DTR.$fieldCode?>" value="<?=$value?>" size="20">
	<? } ?>
	<br/><br/>
	<? } } }?>
	</td>
	</tr>
	<?
}

function showExtraOptionsForm($out)
{
 foreach($out['DB']['ReservedPropertyField'] as $fieldCode=>$field) { if($field['mode']=='option') { ?>
	<tr>
		<td valign="top" class="subtitle">
			<? if($field['status']==2){
			?><input type="checkbox" name="ReservedPropertyFieldStatus[<?=$fieldCode?>]" value="1" ><?
			}else{
			?><input type="checkbox" name="ReservedPropertyFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
			}?>	
			<?=getValue($field['name'])?>
		</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="3">
			<tr>
				<td>&nbsp;</td>
				<td width="150">&nbsp;</td>
				<td align="center"><?=lang('PlusMinusPrice.reservedProperty.tip')?></td>
				<td><?=lang('OptionPrice.reservedProperty.tip')?></td>
				<td align="center"><?=lang('PlusMinusWeight.reservedProperty.tip')?></td>
				<td><?=lang('OptionWeight.reservedProperty.tip')?></td>
			</tr>		
			<input type="hidden" name="ReservedPropertyField<?=DTR.$fieldCode?>" value="_" size="5">
			<? foreach ($field['options'] as $id=>$row) { $fieldTypeOptionID=$row['id'];?>
			<input type="hidden" name="ReservedPropertyOptionFieldCode[<?=$id?>]" value="<?=$fieldCode?>">
			<input type="hidden" name="ReservedPropertyOption<?=DTR?>ReservedPropertyOptionID[<?=$id?>]" value="<?=$row['ReservedPropertyOptionID']?>">
			<input type="hidden" name="ReservedPropertyOption<?=DTR?>ReservedPropertyFieldID[<?=$id?>]" value="<?=$row['ReservedPropertyFieldID']?>">
			<input type="hidden" name="ReservedPropertyOption<?=DTR?>ReservedPropertyTypeOptionID[<?=$id?>]" value="<?=$fieldTypeOptionID?>">
			<tr>
				<td>
					<?
						if($row['ReservedPropertyOptionStatus']==2){
						?><input type="checkbox" name="ReservedPropertyOption<?=DTR?>ReservedPropertyOptionStatus[<?=$id?>]" value="1" ><?
						}else{
						?><input type="checkbox" name="ReservedPropertyOption<?=DTR?>ReservedPropertyOptionStatus[<?=$id?>]" value="1" checked="1" ><?
						}
					?>
				</td>
				<td><?=getValue($row['value'])?></td>
				<td><input type="text" name="ReservedPropertyOption<?=DTR?>ReservedPropertyOptionPriceAction[<?=$id?>]" value="<?=$row['ReservedPropertyOptionPriceAction']?>" size="1" ></td>
				<td><input type="text" name="ReservedPropertyOption<?=DTR?>ReservedPropertyOptionPrice[<?=$id?>]" value="<?=$row['ReservedPropertyOptionPrice']?>" size="10"></td>
				<td><input type="text" name="ReservedPropertyOption<?=DTR?>ReservedPropertyOptionWeightAction[<?=$id?>]" value="<?=$row['ReservedPropertyOptionWeightAction']?>" size="1" ></td>
				<td><input type="text" name="ReservedPropertyOption<?=DTR?>ReservedPropertyOptionWeight[<?=$id?>]" value="<?=$row['ReservedPropertyOptionWeight']?>" size="10"></td>
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
	if(is_array($out['DB']['ReservedPropertyField'])) { foreach($out['DB']['ReservedPropertyField'] as $fieldCode=>$field) { if($field['mode']!='option' && !empty($field['code'])) { $value = getValue($field['value']); ?>
	<tr>
		<td valign="top" class="subtitle">
			<?=getValue($field['name'])?>
		</td>
		<td>
		<? if(is_array($field['options'])) { 
			echo getListValue($field['options'],$field['value'],array('name'=>'ReservedPropertyField'.DTR.$fieldCode,'type'=>$field['type']));												
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
 foreach($out['DB']['ReservedPropertyField'] as $fieldCode=>$field) { if($field['mode']=='option') { ?>
	<tr>
		<td valign="top" class="subtitle">
			<?=getValue($field['name'])?>
		</td>
	<td>
		<table border="0" cellpadding="0" cellspacing="3">
			<tr>
				<td>&nbsp;</td>
				<td width="150">&nbsp;</td>
				<td align="center"><?=lang('PlusMinusPrice.reservedProperty.tip')?></td>
				<td><?=lang('OptionPrice.reservedProperty.tip')?></td>
				<td align="center"><?=lang('PlusMinusWeight.reservedProperty.tip')?></td>
				<td><?=lang('OptionWeight.reservedProperty.tip')?></td>
			</tr>		
			<? foreach ($field['options'] as $id=>$row) { $fieldTypeOptionID=$row['id'];?>
			<tr>
				<td><?=getValue($row['value'])?></td>
				<td><?=$row['ReservedPropertyOptionPriceAction']?></td>
				<td><?=$row['ReservedPropertyOptionPrice']?></td>
				<td><?=$row['ReservedPropertyOptionWeightAction']?></td>
				<td><?=$row['ReservedPropertyOptionWeight']?></td>
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