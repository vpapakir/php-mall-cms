<? //=boxHeader('','')?>
	<?
		//$options[0]['code'] = '';
		//$options[0]['value'] = lang('SelectCategoryDropDown.resource.option');
		$currentValue = $params['currentValue']; if(empty($currentValue)){$currentValue=input('location');}
		$fieldName = $params['fieldName']; if(empty($fieldName)) {$fieldName='location';}
		$id = $params['id']; 
		if(!empty($out['DB']['RegionsList'])) 
		{	
			$listArray = $out['DB']['RegionsList'];
			$valueName = 'value';
			if(empty($id)) {$id='code';}
		} 
		elseif(!empty($out['DB']['Countries'])) 
		{
			$listArray = $out['DB']['Countries'];
			$valueName = 'RegionName';
			if(empty($id)) {$id='RegionCode';}
			$options[0]['id'] = '';
			$options[0]['value'] = lang('SelectRegion.core.option');			
		}
		elseif(!empty($out['DB']['Regions'])) 
		{
			$listArray = $out['DB']['Regions'];
			$valueName = 'RegionName';
			if(empty($id)) {$id='RegionCode';}
			$options[0]['id'] = '';
			$options[0]['value'] = lang('SelectRegion.core.option');			
		}
		elseif(!empty($out['DB']['Cities'])) 
		{
			$listArray = $out['DB']['Cities'];
			$valueName = 'RegionName';
			if(empty($id)) {$id='RegionCode';}
			$options[0]['id'] = '';
			$options[0]['value'] = lang('SelectRegion.core.option');			
		}		
		echo getLists($listArray,$currentValue,array('name'=>$fieldName,'id'=>$id,'value'=>$valueName,'options'=>$options,'style'=>'width:200px'));
if (hasRights('admin')){
?><a href="<?=setting('url')?>manageRegions"><?=lang('-editbox')?></a><?}
	?>
	<? //getLists($out['DB']['ResourceCategories'],$input['category'],array('name'=>'category','id'=>'ResourceCategoryAlias','value'=>'ResourceCategoryTitle','action'=>'submit();','options'=>$options))?>
<? // =boxFooter()?>