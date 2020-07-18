<?	if(is_array($out['DB']['Languages']) && count($out['DB']['Languages'])>1){
	echo boxHeader(array('title'=>'LanguageSwitcher.core.title'));?>
		<?	foreach($out['DB']['Languages'] as $language){?>
			<tr>	
				<td align="left" bgcolor="#FFFFFF">	
				<a href="<?=setting('rooturl').setting('LoaderName').'/'.setting('OwnerID').'.'.$language['LanguageCode']?>/<?=input('SID')?>/<?=getInputLink()?>">
					<? if(!empty($language['LanguageIcon'])){?>
						<img src="<?=setting('urlfiles').$language['LanguageIcon']?>" alt="<?=getValue($language['LanguageName'],$language['LanguageCode'])?>" hspace="5" border="0"/>
					<? }else{?>
						<?=getValue($language['LanguageName'],$language['LanguageCode'])?>						
					<? }?>
				</a>
				</td>
			</tr>
		<?	}?>
	<?	echo boxFooter();
}?>
