<?
//templates functions library
function showUserExtraFieldsForm($out,$part='')
{
	if(empty($part)) {$part='main';}
	if(is_array($out['DB']['UserField'])) { 
	?>
	<?
	foreach($out['DB']['UserField'] as $fieldCode=>$field) { if(!empty($field['code']) && eregi('\|'.$part.'\|',$field['parts']) ) {$value = getValue($field['value']); ?>
		<tr>
		<td align="left" width="252"> <?=getValue($field['name'])?>:</td>

	<td align="left">	
	 <? if(is_array($field['options'])) { ?>
		
	 	<?	echo getLists($field['options'],$field['value'],array('name'=>'UserField'.DTR.$fieldCode,'type'=>$field['type']));												
	} elseif ($field['type']=='input') {?> 
			<input type="text" name="UserField<?=DTR.$fieldCode?>" value="<?=getValue($field['value'])?>" size="30" /> 			
	<? } elseif ($field['type']=='text') {?>
		<textarea name="UserField<?=DTR.$fieldCode?>" cols="70" rows="5"><?=getValue($field['value'])?></textarea>
	 <? } elseif ($field['type']=='date') {?>
		<?=getFormated($field['value'],'Date','form',array('fieldName'=>'UserField'.DTR.$fieldCode))?>
	<?  } elseif ($field['type']=='image') { ?>
		<?  if(!empty($value)) { ?>
			<img src="<?=setting('urlfiles').$value?>" border="0" />
			<a href="<?=setting('url').input('SID')?>/UserID/<?=input('UserID')?>/CategoryID/<?=input('CategoryID')?>/UserType/<?=input('UserType')?>/UserField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deleteimage')?></a>
		<? } ?>			
			<input type="hidden" name="UserField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
			<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
			<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
		<? } elseif ($field['type']=='file') { ?>
			<?  if(!empty($value)) { ?>
				
				<a href="<?=setting('urlfiles').$value?>">[<?=lang('-download')?>]</a> 
				<br/>
				<a href="<?=setting('url').input('SID')?>/UserID/<?=input('UserID')?>/CategoryID/<?=input('CategoryID')?>/UserType/<?=input('UserType')?>/UserField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deletefile')?></a>
			<? } ?>			
				<input type="hidden" name="UserField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
				<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
				<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
	
		<? } else { ?>
		<input type="text" name="UserField<?=DTR.$fieldCode?>" value="<?=$value?>" size="30"> </td>
	<? } ?>

	<? } 	?>
	</td>
	</tr>
<? } ?>
<? } ?>	
<? } ?>

<?
function showUserExtraFieldsView($out,$part='')
{
	if(empty($part)) {$part='main';}
	if(is_array($out['DB']['UserField'])) { 
	?>
	<?
	foreach($out['DB']['UserField'] as $fieldCode=>$field) { if(!empty($field['code']) && eregi('\|'.$part.'\|',$field['parts']) ) {$value = getValue($field['value']); ?>
		<tr>
		<td align="left" width="100"> <?=getValue($field['name'])?>:</td>
	<td align="left">	
	 <? if(is_array($field['options'])) { ?>
	 	<?	echo getListValue($field['options'],$field['value'],array('name'=>'UserField'.DTR.$fieldCode,'type'=>$field['type']));												
	} elseif ($field['type']=='input') {?> 
			<?=getValue($field['value'])?>			
	<? } elseif ($field['type']=='text') {?>
		<?=getFormated($field['value'],'TEXT')?>
	 <? } elseif ($field['type']=='date') {?>
		<?=getFormated($field['value'],'Date','get',array('fieldName'=>'UserField'.DTR.$fieldCode))?>
	<?  } elseif ($field['type']=='image') { ?>
		<?  if(!empty($value)) { ?>
			<img src="<?=setting('urlfiles').$value?>" border="0" />
			<a href="<?=setting('url').input('SID')?>/UserID/<?=input('UserID')?>/CategoryID/<?=input('CategoryID')?>/UserType/<?=input('UserType')?>/UserField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deleteimage')?></a>
		<? } ?>			
			<input type="hidden" name="UserField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
			<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
			<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
		<? } elseif ($field['type']=='file') { ?>
			<?  if(!empty($value)) { ?>
				
				<a href="<?=setting('urlfiles').$value?>">[<?=lang('-download')?>]</a> 
				<br/>
				<a href="<?=setting('url').input('SID')?>/UserID/<?=input('UserID')?>/CategoryID/<?=input('CategoryID')?>/UserType/<?=input('UserType')?>/UserField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deletefile')?></a>
			<? } ?>			
				<input type="hidden" name="UserField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
				<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
				<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
	
		<? } else { ?>
		<?=$value?> </td>
	<? } ?>

	<? } 	?>
	</td>
	</tr>
<? } ?>
<? } ?>	
<? } ?>

