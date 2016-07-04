<?
//templates functions library
function showExtraFieldsForm($out)
{
	if(is_array($out['DB']['DomainField'])) { foreach($out['DB']['DomainField'] as $fieldCode=>$field) { if($field['mode']!='option' && !empty($field['code'])) { $value = getValue($field['value']); ?>
	<tr>
		<td class="subtitle">
		<? /*if($field['status']==2){
		?><input type="checkbox" name="DomainFieldStatus[<?=$fieldCode?>]" value="1" ><?
		}else{
		?><input type="checkbox" name="DomainFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
		}*/?>					
		<?=getValue($field['name'])?>:<br/>
		</td>
		<td>
		<? if(is_array($field['options'])) { 
			echo getLists($field['options'],$field['value'],array('name'=>'DomainField'.DTR.$fieldCode,'type'=>$field['type']));												
		} elseif ($field['type']=='text') { ?>
				<textarea name="DomainField<?=DTR.$fieldCode?>" cols="50" rows="5"><?=$field['value']?></textarea>
				<br/>
		<? } elseif ($field['type']=='date') {
			 	echo getFormated($value,'Date','form',array('mode'=>'dropdowns','fieldName'=>'DomainField'.DTR.$fieldCode)); 
			  }elseif ($field['type']=='image') { ?>
			<?  if(!empty($value)) { ?>
				<img src="<?=setting('urlfiles').$value?>" border="0" />
				<br/>
				<a href="<?=setting('url').input('SID')?>/DomainID/<?=input('DomainID')?>/CategoryID/<?=input('CategoryID')?>/DomainType/<?=input('DomainType')?>/DomainField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deleteimage')?></a>
			<? } ?>			
				<br/>
				<input type="hidden" name="DomainField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
				<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
				<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
			<? } elseif ($field['type']=='file') { ?>
				<?  if(!empty($value)) { ?>
					<br/>
					<a href="<?=setting('urlfiles').$value?>">[<?=lang('-download')?>]</a>
					<br/><br/>
					<a href="<?=setting('url').input('SID')?>/DomainID/<?=input('DomainID')?>/CategoryID/<?=input('CategoryID')?>/DomainType/<?=input('DomainType')?>/DomainField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deletefile')?></a>
				<? } ?>			
					<br/>
					<input type="hidden" name="DomainField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
					<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
					<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
		
			<? } else { ?>
			<input type="text" name="DomainField<?=DTR.$fieldCode?>" value="<?=$value?>" size="20">
		<? } ?>
		<a href="<?=setting('url')?>manageDomainFields/DomainTypeAlias/<?=$DomainTypeForLink?>/DomainTypeFieldAlias/<?=$fieldCode?>/"><?=lang('-editbox')?></a>	
		<!-- <br/><br/> -->
		</td>
	</tr>
	<? } } }	
}

function showExtraOptionsForm($out)
{
 foreach($out['DB']['DomainField'] as $fieldCode=>$field) { if($field['mode']=='option') { ?>
	<? if($field['status']==2){
	?><input type="checkbox" name="DomainFieldStatus[<?=$fieldCode?>]" value="1" ><?
	}else{
	?><input type="checkbox" name="DomainFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
	}?>	
	
	<b><?=getValue($field['name'])?>:</b><br/>
		<table border="0" cellpadding="0" cellspacing="3">
			<input type="hidden" name="DomainField<?=DTR.$fieldCode?>" value="_" size="5">
			<? foreach ($field['options'] as $id=>$row) { $fieldTypeOptionID=$row['id'];?>
			<input type="hidden" name="DomainOption<?=DTR?>DomainOptionID[<?=$id?>]" value="<?=$row['DomainOptionID']?>">
			<input type="hidden" name="DomainOption<?=DTR?>DomainFieldID[<?=$id?>]" value="<?=$row['DomainFieldID']?>">
			<input type="hidden" name="DomainOption<?=DTR?>DomainTypeOptionID[<?=$id?>]" value="<?=$fieldTypeOptionID?>">
			<tr>
				<td>
					<?
						if($row['DomainOptionStatus']==2){
						?><input type="checkbox" name="DomainOption<?=DTR?>DomainOptionStatus[<?=$id?>]" value="1" ><?
						}else{
						?><input type="checkbox" name="DomainOption<?=DTR?>DomainOptionStatus[<?=$id?>]" value="1" checked="1" ><?
						}
					?>
				</td>
				<td><?=getValue($row['value'])?></td>
				<td><input type="text" name="DomainOption<?=DTR?>DomainOptionPriceAction[<?=$id?>]" value="<?=$row['DomainOptionPriceAction']?>" size="1" ></td>
				<td><input type="text" name="DomainOption<?=DTR?>DomainOptionPrice[<?=$id?>]" value="<?=$row['DomainOptionPrice']?>" size="10"></td>
				<td><input type="text" name="DomainOption<?=DTR?>DomainOptionWeightAction[<?=$id?>]" value="<?=$row['DomainOptionWeightAction']?>" size="1" ></td>
				<td><input type="text" name="DomainOption<?=DTR?>DomainOptionWeight[<?=$id?>]" value="<?=$row['DomainOptionWeight']?>" size="10"></td>
			</tr>
			<? } ?>
		</table>
<? } }		
}
?>