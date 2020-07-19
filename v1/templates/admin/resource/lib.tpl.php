<?
//templates functions library
function showExtraFieldsForm($out)
{
	if(is_array($out['DB']['ResourceField'])) { foreach($out['DB']['ResourceField'] as $fieldCode=>$field) { if($field['mode']!='option' && !empty($field['code'])) { $value = getValue($field['value']); ?>
	<? if($field['status']==2){
	?><input type="checkbox" name="ResourceFieldStatus[<?=$fieldCode?>]" value="1" ><?
	}else{
	?><input type="checkbox" name="ResourceFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
	}?>					
	<?=getValue($field['name'])?>:<br/>
	<? if(is_array($field['options'])) { 
		echo getLists($field['options'],$field['value'],array('name'=>'ResourceField'.DTR.$fieldCode,'type'=>$field['type']));												
	} elseif ($field['type']=='text') {
		 foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<?=$out['DB']['Languages']['languageNames'][$langID]?><br/>
			<textarea name="ResourceField<?=DTR.$fieldCode.'['.$langCode.']';?>" cols="70" rows="5"><?=getValue($field['value'],$langCode)?></textarea>
			<br/>
	<? } } elseif ($field['type']=='input') {
		 foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
				<?=$out['DB']['Languages']['languageNames'][$langID]?><br/>
			<? }?>
			<input type="text" size="35" name="ResourceField<?=DTR.$fieldCode.'['.$langCode.']';?>" value="<?=getValue($field['value'],$langCode)?>"/>
			<br/>		
	<? } } elseif ($field['type']=='image') { ?>
		<?  if(!empty($value)) { ?>
			<img src="<?=setting('urlfiles').$value?>" border="0" />
			<br/>
			<a href="<?=setting('url').input('SID')?>/ResourceID/<?=input('ResourceID')?>/CategoryID/<?=input('CategoryID')?>/ResourceType/<?=input('ResourceType')?>/ResourceField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deleteimage')?></a>
		<? } ?>			
			<br/>
			<input type="hidden" name="ResourceField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
			<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
			<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
		<? } elseif ($field['type']=='file') { ?>
			<?  if(!empty($value)) { ?>
				<br/>
				<a href="<?=setting('urlfiles').$value?>">[<?=lang('-download')?>]</a>
				<br/><br/>
				<a href="<?=setting('url').input('SID')?>/ResourceID/<?=input('ResourceID')?>/CategoryID/<?=input('CategoryID')?>/ResourceType/<?=input('ResourceType')?>/ResourceField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deletefile')?></a>
			<? } ?>			
				<br/>
				<input type="hidden" name="ResourceField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
				<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
				<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
	
		<? } else { ?>
		<input type="text" name="ResourceField<?=DTR.$fieldCode?>" value="<?=$value?>" size="20">
	<? } ?>
	<br/><br/>
	<? } } }	
}

function showExtraOptionsForm($out)
{
 foreach($out['DB']['ResourceField'] as $fieldCode=>$field) { if($field['mode']=='option') { ?>
	<? if($field['status']==2){
	?><input type="checkbox" name="ResourceFieldStatus[<?=$fieldCode?>]" value="1" ><?
	}else{
	?><input type="checkbox" name="ResourceFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
	}?>	
	
	<b><?=getValue($field['name'])?>:</b><br/>
		<table border="0" cellpadding="0" cellspacing="3">
			<tr>
				<td>&nbsp;</td>
				<td width="150">&nbsp;</td>
				<td align="center"><?=lang('PlusMinusPrice.resource.tip')?></td>
				<td><?=lang('OptionPrice.resource.tip')?></td>
				<td align="center"><?=lang('PlusMinusWeight.resource.tip')?></td>
				<td><?=lang('OptionWeight.resource.tip')?></td>
			</tr>		
			<input type="hidden" name="ResourceField<?=DTR.$fieldCode?>" value="_" size="5">
			<? foreach ($field['options'] as $id=>$row) { $fieldTypeOptionID=$row['id'];?>
			<input type="hidden" name="ResourceOptionFieldCode[<?=$id?>]" value="<?=$fieldCode?>">
			<input type="hidden" name="ResourceOption<?=DTR?>ResourceOptionID[<?=$id?>]" value="<?=$row['ResourceOptionID']?>">
			<input type="hidden" name="ResourceOption<?=DTR?>ResourceFieldID[<?=$id?>]" value="<?=$row['ResourceFieldID']?>">
			<input type="hidden" name="ResourceOption<?=DTR?>ResourceTypeOptionID[<?=$id?>]" value="<?=$fieldTypeOptionID?>">
			<tr>
				<td>
					<?
						if($row['ResourceOptionStatus']==2){
						?><input type="checkbox" name="ResourceOption<?=DTR?>ResourceOptionStatus[<?=$id?>]" value="1" ><?
						}else{
						?><input type="checkbox" name="ResourceOption<?=DTR?>ResourceOptionStatus[<?=$id?>]" value="1" checked="1" ><?
						}
					?>
				</td>
				<td><?=getValue($row['value'])?></td>
				<td><input type="text" name="ResourceOption<?=DTR?>ResourceOptionPriceAction[<?=$id?>]" value="<?=$row['ResourceOptionPriceAction']?>" size="1" ></td>
				<td><input type="text" name="ResourceOption<?=DTR?>ResourceOptionPrice[<?=$id?>]" value="<?=$row['ResourceOptionPrice']?>" size="10"></td>
				<td><input type="text" name="ResourceOption<?=DTR?>ResourceOptionWeightAction[<?=$id?>]" value="<?=$row['ResourceOptionWeightAction']?>" size="1" ></td>
				<td><input type="text" name="ResourceOption<?=DTR?>ResourceOptionWeight[<?=$id?>]" value="<?=$row['ResourceOptionWeight']?>" size="10"></td>
			</tr>
			<? } ?>
		</table>
		<br/>
<? } }		
}
?>