<? //=boxHeader('','')?>
<?
	if(is_array($out['DB']['Languages']) && count($out['DB']['Languages'])>1)
	{
		foreach($out['DB']['Languages'] as $key=>$language)
		{
			$swicher[$key]['id'] = setting('rooturl').setting('LoaderName').'/'.setting('OwnerID').'.'.$language['LanguageCode'].'/'.input('SID').'/'.getInputLink();
			$swicher[$key]['value'] = getValue($language['LanguageName'],$language['LanguageCode']);
		}
	}
?>
<? echo input('Language');?>
<?	echo getLists($swicher,setting('rooturl').setting('LoaderName').'/'.setting('OwnerID').'.'.setting('lang').'/'.input('SID').'/'.getInputLink(),array('name'=>'Language','id'=>'id','value'=>'value','action'=>'location = this.options[this.selectedIndex].value'));?>	
<? // =boxFooter()?>