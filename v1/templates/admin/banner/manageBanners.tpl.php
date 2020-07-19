<?=boxHeader(array('title'=>'ManageBanners.banner.tip'))?>
	<table cellpadding="2" cellspacing="0" width="100%" border="0">
	<tr> 
	<form name="getBanners" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td width="30%" bgcolor="#efefef">&nbsp;</td>
	<td valign=top bgcolor="#efefef" align="left">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('BannerNew.banner.tip').' -';
			echo getLists($out['DB']['Banners'],$out['DB']['Banner'][0]['BannerID'],array('name'=>'BannerID','id'=>'BannerID','value'=>'BannerAlias','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	</table>
	<form name="manageBanners" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['Banner'][0]['BannerID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="Banner<?=DTR?>BannerID" value="<?=$out['DB']['Banner'][0]['BannerID'];?>" />
		<input type="hidden" name="BannerID" value="<?=$out['DB']['Banner'][0]['BannerID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
			<tr>
			<td align="center" bgcolor="#efefef" width="100%" colspan="2">
					<span class="subtitle"><?=lang('SelectBannerSectionsAndCategoriesTip.banner.tip','html')?></span>
			</td>
			</tr>
			<tr>
			<td>&nbsp;
			 
			</td>
			</tr>
			<tr>
			<td align="left" valign="top" width="30%">
					<span class="subtitle"><?=lang('Banner.BannerSections')?>: </span>
			</td>
			<td align="left">
					<?=getLists($out['DB']['SectionsList'],$out['DB']['Banner'][0]['BannerSections'],array('name'=>'Banner'.DTR.'BannerSections','type'=>'multiple','id'=>'code','value'=>'value','style'=>'width:300px'))?>
			</td>
			</tr>
			<? if(setting('UseResourceCategories')=='Y'){?>
			<tr>
				<td align="left" valign="top">
						<span class="subtitle"><?=lang('Banner.BannerCategories')?>: </span>
				</td>
				<td align="left">
						<?=getLists($out['DB']['CategoriesList'],$out['DB']['Banner'][0]['BannerCategories'],array('name'=>'Banner'.DTR.'BannerCategories','type'=>'multiple','style'=>'width:300px'))?>
				</td>
			</tr>
			<? }?>
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('Banner.BannerPlace')?>: </span>
			</td>
			<td align="left">
					<?=getReference('bannerplace','Banner'.DTR.'BannerPlace',$out['DB']['Banner'][0]['BannerPlace'],array('code'=>'Y'))?>
			</td>
			</tr>
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('Banner.BannerAlias')?>*: </span>
			</td>
			<td align="left">
					<input type="text" name="Banner<?=DTR?>BannerAlias" value="<?=$out['DB']['Banner'][0]['BannerAlias'];?>" size="50">
			</td>
			</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('Banner.BannerText')?>*: </span><?=$out['DB']['Languages']['languageNames'][$langID]?>
						</td>
						<td align="left">
							<input type="text" name="Banner<?=DTR?>BannerText[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['Banner'][0]['BannerText'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('Banner.BennerLink')?>*: </span>
			</td>
			<td align="left">
					<input type="text" name="Banner<?=DTR?>BennerLink" value="<?=$out['DB']['Banner'][0]['BennerLink'];?>" size="50">
			</td>
			</tr>
			<tr>
			<td align="left" valign="top">
					<span class="subtitle"><?=lang('Banner.BannerTarget')?>: </span>
			</td>
			<td align="left">
					<?=getReference('target','Banner'.DTR.'BannerTarget',$out['DB']['Banner'][0]['BannerTarget'],array('code'=>'Y'))?>
			</td>
			</tr>
			<tr>
			<td align="left" valign="top">
					<span class="subtitle"><?=lang('Banner.BannerImage')?>: </span>
			</td>
			<td align="left">
					<? if(!empty($out['DB']['Banner'][0]['BannerImage'])) { ?>
						<img src="<?=setting('urlfiles').$out['DB']['Banner'][0]['BannerImage']?>" border="0" />
						<br />
						<a href="<?=setting('url').input('SID')?>/ResourceID/<?=$out['DB']['Banner'][0]['BannerID']?>/actionMode/deletefile/fileField/BannerImage"><?=lang('-deleteimage')?></a>
					<br />
					<? } ?>
					<input size="22" type="file" name="uploadFile[BannerImage]" />
			</td>
			</tr>
<!--			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('BannerWidthLimit.banner.tip')?>: </span>
			</td>
			<td align="left">
					<input size="22" type="file" name="uploadFile[BannerImage]" />
			</td>
			</tr>-->
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('BannerWidthLimit.banner.tip')?>: </span>
			</td>
			<td align="left">
					<input type="text" name="uploadFileSettings[BannerImage][ImageWidthLimit]" />
			</td>
			</tr>
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('BannerHeightLimit.banner.tip')?>: </span>
			</td>
			<td align="left">
					<input type="text" name="uploadFileSettings[BannerImage][ImageHeightLimit]" />
					<input type="hidden" name="oldUploadFile[BannerImage]" value="<?=$out['DB']['Banner'][0]['BannerImage']?>" />
			</td>
			</tr>
			<tr>
			<td align="left" valign="top">
					<span class="subtitle"><?=lang('Banner.BannerLanguages')?>: </span>
			</td>
			<td align="left">
					<?
						foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
						{
							$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
							$languagesList[$langID]['value']=$langName;		
						}								
						echo getLists($languagesList,$out['DB']['Banner'][0]['BannerLanguages'],array('name'=>'Banner'.DTR.'BannerLanguages','type'=>'checkboxes'));	
					?>	
			</td>
			</tr>
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('Banner.BannerCode')?>: </span>
			</td>
			<td align="left" valign="top"> 
					<textarea name="Banner<?=DTR?>BannerCode" rows="5" cols="60"><?=$out['DB']['Banner'][0]['BannerCode']?></textarea>
			</td>
			
			</tr>
			<tr>
			<td align="left" valign="top">
					<span class="subtitle"><?=lang('Banner.BannerComments')?>: </span>
			</td>
			<td align="left">
					<textarea name="Banner<?=DTR?>BannerComments" rows="5" cols="60"><?=$out['DB']['Banner'][0]['BannerComments']?></textarea>
			</td>
			</tr>
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('-addafter')?>: </span>
			</td>
			<td align="left">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['Banners']))
						{
						foreach($out['DB']['Banners'] as $row)
						{
							if ($row['BannerID']!=$out['DB']['Banner'][0]['BannerID'])
							{
								$i++;
								$options[$i]['id']=$row['BannerPosition']+1;	
								$options[$i]['value']=$row['BannerAlias'];
							}
						}
						}
						echo getLists('',$out['DB']['Banner'][0]['BannerPosition']-1,array('name'=>'Banner'.DTR.'BannerPosition','id'=>'BannerPosition','value'=>'BannerAlias','options'=>$options));	
						$options='';
					?>
			</td>
			</tr>
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('Banner.PermAll')?>: </span>
			</td>
			<td align="left">
					<?=getReference('PermAll','Banner'.DTR.'PermAll',$out['DB']['Banner'][0]['PermAll'],array('code'=>'Y'))?>
			</td>
			</tr>
			<tr>
			<td>&nbsp;
			 
			</td>
			</tr>
			<tr>
			<td align="center" bgcolor="#efefef" colspan="2">
					<? if(empty($out['DB']['Banner'][0]['BannerID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageBanners.actionMode.value='delete';confirmDelete('manageBanners', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			</td>
			</tr>
			</table>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>