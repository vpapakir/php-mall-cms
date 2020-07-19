<?
//templates functions library
function showTourExtraFieldForForm($fieldInCode,$out,$mode='')
{
	if(empty($mode)) {$mode='edit';/*details - 1 item page, search - search form, list - items list, edit -edit form */}
	if(is_array($out['DB']['TourField'])) { foreach($out['DB']['TourField'] as $fieldCode=>$field) { if($field['mode']!='option' && $field['code']==$fieldInCode) { $value = getValue($field['value']); ?>
  <tr>
	<td width="30%" class="subtitle" bgcolor="#ffffff" valign="top">
	<? if($field['status']==2  && !eregi("\|".$mode."\|",$field['places'])){
	?><input type="checkbox" name="TourFieldStatus[<?=$fieldCode?>]" value="1" ><?
	}else{
	?><input type="checkbox" name="TourFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
	}?>					
	<?=getValue($field['name'])?>
	</td>
		<td width="70%" class="subtitle" bgcolor="#ffffff" valign="top">
	
	<? if(is_array($field['options'])) { 
		echo getLists($field['options'],$field['value'],array('name'=>'TourField'.DTR.$fieldCode,'type'=>$field['type']));												
	} elseif ($field['type']=='text') {
		 foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<?=$out['DB']['Languages']['languageNames'][$langID]?><br/>
			<textarea name="TourField<?=DTR.$fieldCode.'['.$langCode.']';?>" cols="50" rows="5"><?=getValue($field['value'],$langCode)?></textarea>
			<br/>
	<? } } elseif ($field['type']=='input') {
		 foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<?=$out['DB']['Languages']['languageNames'][$langID]?><br/>
			<input type="text" size="25" name="TourField<?=DTR.$fieldCode.'['.$langCode.']';?>" value="<?=getValue($field['value'],$langCode)?>"/>
			<br/>		
	<? } } elseif ($field['type']=='image') { ?>
		<?  if(!empty($value)) { ?>
			<img src="<?=setting('urlfiles').$value?>" border="0" />
			<br/>
			<a href="<?=setting('url').input('SID')?>/TourID/<?=input('TourID')?>/CategoryID/<?=input('CategoryID')?>/TourType/<?=input('TourType')?>/TourField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deleteimage')?></a>
		<? } ?>			
			<br/>
			<input type="hidden" name="TourField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
			<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
			<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
		<? } elseif ($field['type']=='file') { ?>
			<?  if(!empty($value)) { ?>
				<br/>
				<a href="<?=setting('urlfiles').$value?>">[<?=lang('-download')?>]</a>
				<br/><br/>
				<a href="<?=setting('url').input('SID')?>/TourID/<?=input('TourID')?>/CategoryID/<?=input('CategoryID')?>/TourType/<?=input('TourType')?>/TourField<?=DTR.$fieldCode?>/deletefieldfile/actionMode/save1"><?=lang('-deletefile')?></a>
			<? } ?>			
				<br/>
				<input type="hidden" name="TourField<?=DTR.$fieldCode?>" value="<?=$field['type']?>">
				<input  type="file" name="uploadFile[<?=$fieldCode?>]" size="22" />
				<input type="hidden" name="oldUploadFile[<?=$fieldCode?>]" value="<?=$value?>" />
		<? } elseif($field['type']=='money') { ?>
		<input type="text" name="TourField<?=DTR.$fieldCode?>" value="<?=$value?>" size="15"> <?=setting('currency')?>
		<? } else { ?>
		<input type="text" name="TourField<?=DTR.$fieldCode?>" value="<?=$value?>" size="20">
		<? } ?>
		<? if(hasRights('admin')) {?><a href="<?=setting('url')?>manageTourFields/TourTypeFieldAlias/<?=$fieldInCode?>"><?=lang('-editbox')?></a><? }?>
	</td>
  </tr>	
	<? } } }	
}


function showTourExtraFieldsForm($out,$mode='')
{
	
	if(empty($mode)) {$mode='edit';/*details - 1 item page, search - search form, list - items list, edit -edit form */}
	if(is_array($out['DB']['TourField'])) { foreach($out['DB']['TourField'] as $fieldCode=>$field) { if(!empty($field['code']) && !eregi("\|".$mode."\|",$field['places'])) { ?>
		<? if($field['mode']!='option') { echo showTourExtraFieldForForm($fieldCode,$out,$mode); }
		else { echo showTourExtraOptionsForm($fieldCode,$out); }
		?>
	<? } } }	
}

function showTourExtraOptionsForm($inFieldCode,$out)
{
 if(is_array($out['DB']['TourField'])) { foreach($out['DB']['TourField'] as $fieldCode=>$field) { if($field['mode']=='option' && $fieldCode==$inFieldCode) { ?>
  
  <tr>
	<td width="30%" class="subtitle" bgcolor="#ffffff" valign="top">

	<? if($field['status']==2){
	?><input type="checkbox" name="TourFieldStatus[<?=$fieldCode?>]" value="1" ><?
	}else{
	?><input type="checkbox" name="TourFieldStatus[<?=$fieldCode?>]" value="1" checked="1" ><?
	}?>	
	<? $fieldName=getValue($field['name']); echo $fieldName; ?>
	<br/><br/>
	<input type="text" name="AddFieldOptions[<?=$fieldCode?>]" value="1" size="1"/>
	&nbsp;<input type="button" name="goAddOption" value="<?=lang('-add').' '.$fieldName?>" onClick="AddFieldOptionFieldCode.value='<?=$fieldCode?>';viewMode.value='<?=input('viewMode')?>';submit();" />
	</td>
		<td width="70%" class="subtitle" bgcolor="#ffffff" valign="top">
		<table border="0" cellpadding="0" cellspacing="3">
			<input type="hidden" name="TourField<?=DTR.$fieldCode?>" value="_">
			<? if(is_array($out['DB']['TourField'][$fieldCode]['options'])) { foreach ($out['DB']['TourField'][$fieldCode]['options'] as $id=>$row) { $fieldTypeOptionID=$row['id'];?>
			<input type="hidden" name="TourOptionFieldCode[<?=$id?>]" value="<?=$fieldCode?>">
			<input type="hidden" name="TourOption<?=DTR?>TourOptionID[<?=$id?>]" value="<?=$row['TourOptionID']?>">
			<input type="hidden" name="TourOption<?=DTR?>TourFieldID[<?=$id?>]" value="<?=$row['TourFieldID']?>">
			<input type="hidden" name="TourOption<?=DTR?>TourTypeOptionID[<?=$id?>]" value="<?=$fieldTypeOptionID?>">
			<tr>
				<td><?=showExtraOptionsDropDownFieldForm($fieldCode.'Value1','Value1',$id,$row,$out)?></td>
				<td><?=showExtraOptionsDropDownFieldForm($fieldCode.'Value2','Value2',$id,$row,$out)?></td>
				<? if($fieldCode=='TourAvailableRooms') { ?>
				<td><?=showExtraOptionsDropDownFieldForm($fieldCode.'Value3','Value3',$id,$row,$out)?></td>
				<? } ?>
				<td><a href="#" onClick="javascript:document.manageTours.viewMode.value='<?=input('viewMode')?>';document.manageTours.DeleteFieldOptionID.value='<?=$row['TourOptionID']?>';document.manageTours.submit();"><?=lang('DeleteTourServiceOption.tour.link')?></a></td>
			</tr>
			<? }} else {  ?>
				<? if(is_array($out['DB']['TourField'][$fieldCode.'Value1']['options'])) { foreach ($out['DB']['TourField'][$fieldCode.'Value1']['options'] as $id=>$row) { $fieldTypeOptionID=$row['id'];?>
				<? if ($kk<1) {?>
				<input type="hidden" name="TourOptionFieldCode[<?=$id?>]" value="<?=$fieldCode?>">
				<input type="hidden" name="TourOption<?=DTR?>TourOptionID[<?=$id?>]" value="<?=$row['TourOptionID']?>">
				<input type="hidden" name="TourOption<?=DTR?>TourFieldID[<?=$id?>]" value="<?=$row['TourFieldID']?>">
				<input type="hidden" name="TourOption<?=DTR?>TourTypeOptionID[<?=$id?>]" value="<?=$fieldTypeOptionID?>">
				<tr>
					<td><?=showExtraOptionsDropDownFieldForm($fieldCode.'Value1','Value1',$id,$row,$out)?></td>
					<td><?=showExtraOptionsDropDownFieldForm($fieldCode.'Value2','Value2',$id,$row,$out)?></td>
					<? if($fieldCode=='TourAvailableRooms') { ?>
					<td><?=showExtraOptionsDropDownFieldForm($fieldCode.'Value3','Value3',$id,$row,$out)?></td>
					<? } ?>
					<td>&nbsp;</td>
				</tr>
				<? $kk++; }}}  ?>
			<? } ?>
		</table>
	</td>
  </tr>			
<? } } }		
}

function showExtraOptionsDropDownFieldForm($inCode,$optionFieldNumber,$id,$row,$out)
{
//print_r($row);
	$optionField = 'TourOption'.$optionFieldNumber;
	foreach($out['DB']['TourField'] as $fieldCode=>$field) { if($field['mode']!='option' && $fieldCode==$inCode) { //echo 'code3='.$fieldCode.' ttt3='.$inCode.'<br>'; 
		$shown='Y';
		if(is_array($field['options'])) { 
			echo getLists($field['options'],$row[$optionField],array('name'=>'TourOption'.DTR.$optionField.'['.$id.']','type'=>$field['type']));												
		} else {
		?> <input type="text" name="TourOption<?=DTR.$optionField?>[<?=$id?>]" value="<?=$row[$optionField]?>" size="10" > <?
		}
	}}
	if($shown!='Y')
	{
		?> <input type="text" name="TourOption<?=DTR.$optionField?>[<?=$id?>]" value="<?=$row[$optionField]?>" size="10" > <?
	}
	?>
	<? if(hasRights('admin')) {?><a href="<?=setting('url')?>manageTourFields/TourTypeFieldAlias/<?=$inCode?>"><?=lang('-editbox')?></a><? }?>
	<?
}

function showTourExtraFieldsList($out,$mode='')
{
	if(empty($mode)) {$mode='edit';/*details - 1 item page, search - search form, list - items list, edit -edit form */}
	if(is_array($out['DB']['TourField'])) { foreach($out['DB']['TourField'] as $fieldCode=>$field) { if(!empty($field['code']) && !eregi("\|".$mode."\|",$field['places'])) { ?>
		<? if($field['mode']!='option') { echo showTourExtraFieldsListFieldValues($fieldCode,$out,$mode); }
		else { echo showTourExtraOptionsList($fieldCode,$out); }
		?>
	<? } } }	
}

function showTourExtraFieldsListFieldValues($fieldInCode,$out,$mode='')
{
	if(empty($mode)) {$mode='details';/*details - 1 item page, search - search form, list - items list, edit -edit form */}
	foreach($out['DB']['TourField'] as $fieldCode=>$field) { $value = getValue($field['value']);  if($field['code']==$fieldInCode && !empty($value)) {?>
	<? if($field['status']!=2 && !eregi("\|".$mode."\|",$field['places'])){ ?>					
  <tr>
	<td width="30%" class="subtitle" bgcolor="#ffffff" valign="top">
	<?=getValue($field['name'])?>&nbsp;
	</td>
		<td width="70%" class="subtitle" bgcolor="#ffffff" valign="top">
	
	<? if(is_array($field['options'])) { 
		echo getListValue($field['options'],$field['value'],array('name'=>'TourField'.DTR.$fieldCode,'type'=>$field['type']));												
	} elseif ($field['type']=='text') {?>
		<?=$value?>
	<?  } elseif ($field['type']=='image') { ?>
		<?  if(!empty($value)) { ?>
			<br/>
			<img src="<?=setting('urlfiles').$value?>" border="0" />
		<? } ?>			
		<? } elseif ($field['type']=='file') { ?>
			<?  if(!empty($value)) { ?>
				<br/>
				<a href="<?=setting('urlfiles').$value?>">[<?=lang('-download')?>]</a>
			<? } ?>	
		<? } elseif($field['type']=='input') { ?>
		<?=$value?>		
		<? } elseif($field['type']=='money') { ?>
		<?=$value?> <?=setting('currency')?>
		<? } else { ?>
		<?=$value?>
		<? } ?>
	</td>
  </tr>
	<? } }	
	}//if($TourFieldType['status']!=2)	
}

function showTourExtraOptionsList($inFieldCode,$out)
{
 if(is_array($out['DB']['TourField'])) { foreach($out['DB']['TourField'] as $fieldCode=>$field) { if($fieldCode==$inFieldCode && !eregi("\|view\|",$field['places'])) {?>
  
  <tr>
	<td width="30%" class="subtitle" bgcolor="#ffffff" valign="top">
	<? $fieldName=getValue($field['name']); echo $fieldName; ?>
	</td>
		<td width="70%" class="subtitle" bgcolor="#ffffff" valign="top">
		<table border="0" cellpadding="0" cellspacing="3">
			<? if(is_array($out['DB']['TourField'][$fieldCode]['options'])) { foreach ($out['DB']['TourField'][$fieldCode]['options'] as $id=>$row) { $fieldTypeOptionID=$row['id'];?>
			<tr>
				<td><?=showExtraOptionsDropDownFieldList($fieldCode.'Value1','Value1',$id,$row,$out)?>&nbsp;</td>
				<td>&nbsp;<?=showExtraOptionsDropDownFieldList($fieldCode.'Value2','Value2',$id,$row,$out)?>&nbsp;</td>
				<? if($fieldCode=='TourAvailableRooms') { ?>
				<td>&nbsp;<?=showExtraOptionsDropDownFieldList($fieldCode.'Value3','Value3',$id,$row,$out)?>&nbsp;</td>
				<? } ?>
				
			</tr>
			<? }} ?>
		</table>
	</td>
  </tr>			
<? } } }
}

function showExtraOptionsDropDownFieldList($inCode,$optionFieldNumber,$id,$row,$out)
{
//print_r($row);
	$optionField = 'TourOption'.$optionFieldNumber;
	foreach($out['DB']['TourField'] as $fieldCode=>$field) { if($field['mode']!='option' && $fieldCode==$inCode) { //echo 'code3='.$fieldCode.' ttt3='.$inCode.'<br>'; 
		$shown='Y';
		if(is_array($field['options'])) { 
			echo getListValue($field['options'],$row[$optionField],array('type'=>$field['type']));												
		} else {
		?> <?=$row[$optionField]?> <?
		}
	}}
	if($shown!='Y')
	{
		?> <?=$row[$optionField]?> <?
	}
	?>
	<?
}

function getTourFieldsTypesForRatesShow($out,$fieldName)
{
	foreach($out['DB']['TourField'] as $fieldCode=>$field) { 
		if($fieldCode==$fieldName) {
			if(is_array($field['options'])) {
				foreach($field['options'] as $id=>$option){
					$types[$id]['id'] = $option['id'];
					$types[$id]['code'] = $option['code'];
					$types[$id]['name'] = getValue($option['value']);
				}
			}
		}
	}	
	return $types;	
}

function getTourActiveSeasonsForRatesShow($out,$seasonAllTypes)
{
	//print_r($out['DB']['TourField']);
	foreach($out['DB']['TourField'] as $fieldCode=>$field) { 
		if($fieldCode=='TourAvailableSeasons') {
			if(is_array($field['options'])) {
			
				foreach($field['options'] as $seasonOption){
					foreach($seasonAllTypes as $seasonTypeInfo)
					{
						//print_r($seasonOption);
						if($seasonTypeInfo['id']==$seasonOption['TourOptionValue2'])
						{
							$k++;
							$seasonID = $seasonTypeInfo['id'];
							$seasonTypes[$seasonID]['id'] = $seasonTypeInfo['id'];
							$seasonTypes[$seasonID]['code'] = $seasonTypeInfo['code'];
							$seasonTypes[$seasonID]['name'] = $seasonTypeInfo['name'];
							foreach($out['DB']['TourField']['TourAvailableSeasonsValue1']['options'] as $tourAvailableSeasonsValue1)
							{
								//echo 'id='.$tourAvailableSeasonsValue1['id'].' vvv='.$seasonOption['value'].'<br>' ;
								if($tourAvailableSeasonsValue1['id']==$seasonOption['value'])
								{
									$seasonTypes[$seasonID]['options'][$k]['name'] = getValue($tourAvailableSeasonsValue1['value']);
								}
							}
						}
					}
				}
			}
		}
	}	
	//print_r($seasonTypes);
	return $seasonTypes;
}

function addToTourShopingCartForm($out)
{
	?>
		<form name="addToCart" method="post">
		<input type="hidden" name="SID" value="cart" />
		<input type="hidden" name="actionMode" value="add" />
		<input type="hidden" name="Tour<?=DTR?>TourID" value="<?=$out['DB']['Tour']['TourID']?>" />
		<input type="hidden" name="TourID" value="<?=$out['DB']['Tour']['TourID']?>" />
		<input type="hidden" name="category" value="<?=input('category')?>" />
		
		<tr>
			<td valign="top" class="row1" width="70%">
				<hr size="1">
				<?=showTourExtraFieldsList($out)?>
				<? //showTourExtraOptionsList($out)?>
			</td>
		</tr>	
		<tr>
			<td valign="top" class="row1" width="70%" align="center">
				<hr size="1">
				<?=lang('-quantity')?>: <input type="text" name="CartItemQuantity" size="2"/>&nbsp;<input type="submit" name="addToCart" value="<?=lang('-addtocart')?>" />
			</td>
		</tr>
		</form>	
	<?	
}

function addTourBidForm($out)
{
	?>
		<form name="addBid" method="post">
		<? if(input('actionMode')=='save1' || input('actionMode')=='add'  || input('actionMode')=='view') {?>
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? } else {?>
			<input type="hidden" name="SID" value="addBid" />
		<? } ?>
		<input type="hidden" name="actionMode" value="viewform" />
		<input type="hidden" name="Tour<?=DTR?>TourID" value="<?=$out['DB']['Tour']['TourID']?>" />
		<input type="hidden" name="TourID" value="<?=$out['DB']['Tour']['TourID']?>" />
		<input type="hidden" name="category" value="<?=input('category')?>" />
		<tr>
			<td valign="top" class="row1" width="70%">
				<hr size="1">
				<?=showTourExtraFieldsList($out)?>
			</td>
		</tr>	
		<tr>
			<td valign="top" class="row1" width="70%">
				<hr size="1"/>
				<b><?=lang('TourMinimumBid.tour.tip')?>: </b><?=$out['Vars']['TourMinimumBid']?>
				<br/>
				<!--b><?=lang('Tour.offers.TourPrice')?>: </b><?=$out['DB']['Tour']['TourPrice']?>
				<br/-->
				<b><?=lang('TourNumberOfBids.tour.tip')?>: </b><?=$out['Vars']['TourNumberOfBids']?>
				<br/>
				<b><?=lang('TourHighestBid.tour.tip')?>: </b><?=$out['Vars']['TourHighestBid']?>
				<br/>
				<b><?=lang('Tour.offers.TimeEnd')?>: </b><?=getFormated($out['DB']['Tour']['TimeEnd'],'DateTime')?>
				<br/>
				<b><?=getValue($out['DB']['TourField']['DeliveryPrice']['name'])?>: </b><?=$out['DB']['TourField']['DeliveryPrice']['value']?> <?=setting('currency')?>
				<br/>
			</td>
		</tr>
		<tr>
			<td valign="top" class="row1" width="70%" align="center">
				<hr size="1">
				<? if($out['DB']['Tour']['TourStatus']!='closed') { ?>
				<? if(input('actionMode')=='save1' || input('actionMode')=='add'  || input('actionMode')=='view') {?>
					<input type="submit" name="edit" value="<?=lang('-edit')?>" />
				<? } else {?>
					<input type="submit" name="addBid" value="<?=lang('-addbid')?>" />
				<? } } ?>				
			</td>
		</tr>
		</form>		
	<?
}

function getTourTabsForTourTypes($out)
{
	$tabs[0]['TabLinkName'] = lang('Top10.tour.link');
	$tabs[0]['TabLinkValue'] = 'tops';
	if(is_array($out['DB']['TourCategoryTypes']))
	{
		foreach($out['DB']['TourCategoryTypes'] as $id=>$typeRow)
		{
			$index = $id+1;
			$tabs[$index]['TabLinkName'] = $typeRow['TourTypeName']; 
			$tabs[$index]['TabLinkValue'] = 'offers__type__'.$typeRow['TourTypeAlias'];
		}
	}
	return $tabs;
}

?>