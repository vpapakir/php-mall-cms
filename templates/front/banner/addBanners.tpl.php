<?=boxHeader(array('title'=>'addBanner.banner.title'))?>

	<!-- <tr> 
		<form name="getBanners" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<td valign=top bgcolor="#ffffff">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('BannerNew.banner.tip').' -';
					echo getLists($out['DB']['Banners'],$out['DB']['Banner'][0]['BannerID'],array('name'=>'BannerID','id'=>'BannerID','value'=>'BannerAlias','action'=>'submit();','style'=>'width:200px;','options'=>$options));	
				?>	
			</td> 
		</form>
	</tr> --> 
	<form name="addBanner" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="Banner<?=DTR?>BannerID" value="<?=$out['DB']['Banner'][0]['BannerID'];?>" />
		<input type="hidden" name="BannerID" value="<?=$out['DB']['Banner'][0]['BannerID'];?>" />
		<? if(!user('UserID')) { ?>
		<tr>
			<td valign="top" align="center">
				<?=lang('AddResourceLoginTip.resource.tip','html')?>
				<br/><br/>
				<?=lang('Email.session.tip')?>:<br/>
				<input type="text" name="Login" value="<?=input('Login')?>" size="30" />
				<br/>
				<?=lang('Password.session.tip')?>:<br/>
				<input type="password" name="Password" size="30" />
				<br/><br/>
				<input type="button" value="<?=lang('-login')?>" onClick="document.addBanner.actionMode.value='login';submit();">	
			</td>
		</tr>
		<tr>
			<td valign="top" align="center"><br>
				<?=lang('AddResourceRegisterTip.resource.tip','html')?>
				<br/><br/>
				<?=lang('User.Email')?>:<br/>
				<input type="text" name="User<?=DTR?>Email" value="<?=$out['DB']['User'][0]['Email']?>" size="30">
				<br/>
				<?=lang('User.Password')?>:<br/>
				<input type="password" name="User<?=DTR?>Password" value="<?=$out['DB']['User'][0]['Password']?>" size="30">
				<br/>
				<?=lang('UserField.FirstName')?>:<br/>
				<input type="text" name="UserField<?=DTR?>FirstName" value="<?=input('UserField'.DTR.'FirstName')?>" size="30">
				<br/>
				<?=lang('UserField.LastName')?>:<br/>
				<input type="text" name="UserField<?=DTR?>LastName" value="<?=input('UserField'.DTR.'LastName')?>" size="30">
				<br/>
				<?=lang('UserField.CompanyName')?>: <!-- <?=lang('-optional')?> --><br/>
				<input type="text" name="UserField<?=DTR?>CompanyName" value="<?=input('UserField'.DTR.'CompanyName')?>" size="30">
				<br/>
				<?=lang('UserField.Web')?>:<br/>
				<input type="text" name="UserField<?=DTR?>UserLink" value="<?=input('UserField'.DTR.'Web')?>" size="30">
				<br/>
				<?=lang('UserField.HowDidYouFind')?>:<br/>
				<input type="text" name="UserField<?=DTR?>HowDidYouFind" value="<?=input('UserField'.DTR.'HowDidYouFind')?>" size="30">
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<? }?>
		<tr> 
			<td width="235" valign="top" bgcolor="#ffffff" align="center" class="fieldNames">
					<input type="hidden" name="actionMode" value="add" />
					<?=lang('SelectBannerSectionsAndCategoriesTip.banner.tip','html')?>
					<!-- <br/><br/>
					<?=lang('Banner.BannerSections')?>:<br/>
					<?=getLists($out['DB']['SectionsList'],$out['DB']['Banner'][0]['BannerSections'],array('name'=>'Banner'.DTR.'BannerSections','type'=>'multiple','style'=>'width:200px'))?> -->
					<br/><br/>
					<?=lang('Banner.BannerCategories')?>:<br/>
					<?=getLists($out['DB']['CategoriesList'],$out['DB']['Banner'][0]['BannerCategories'],array('name'=>'Banner'.DTR.'BannerCategories','type'=>'multiple','style'=>'width:200px'))?>
					<br/><br/>
					
					<?=lang('Banner.BannerPlace')?>:<br/>
					<?=getReference('bannerplace','Banner'.DTR.'BannerPlace',$out['DB']['Banner'][0]['BannerPlace'],array('code'=>'Y'))?>
					<br/><br>
					<?=lang('Banner.BannerAlias')?>*:<br/>
					<input type="text" name="Banner<?=DTR?>BannerAlias" value="<?=$out['DB']['Banner'][0]['BannerAlias'];?>" size="30">
					<br/><br>
					<table cellspacing="0" cellpadding="0" align="center">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="center">
							<?=lang('Banner.BannerText')?>*: 
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
							<br/>
							<input type="text" name="Banner<?=DTR?>BannerText[<?=$langCode?>]" size="30" value="<?=getValue($out['DB']['Banner'][0]['BannerText'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>		
					<br/><br>
					<?=lang('Banner.BennerLink')?>*:<br/>
					<input type="text" name="Banner<?=DTR?>BennerLink" value="<?=$out['DB']['Banner'][0]['BennerLink'];?>" size="30">
					<br/><br>
					<?=lang('Banner.BannerTarget')?>:<br/>
					<?=getReference('target','Banner'.DTR.'BannerTarget',$out['DB']['Banner'][0]['BannerTarget'],array('code'=>'Y'))?>
					<br/><br>
					<?=lang('Banner.BannerImage')?>:<br/>
					<? if(!empty($out['DB']['Banner'][0]['BannerImage'])) { ?>
						<img src="<?=setting('urlfiles').$out['DB']['Banner'][0]['BannerImage']?>" border="0" />
						<br/>
						<a href="<?=setting('url').input('SID')?>/ResourceID/<?=$out['DB']['Banner'][0]['BannerID']?>/actionMode/deletefile/fileField/BannerImage"><?=lang('-deleteimage')?></a>
					<? } ?>
					<br/>
					<input size="22" type="file" name="uploadFile[BannerImage]" />
					<input type="hidden" name="uploadFileSettings[BannerImage][ImageWidthLimit]" value="245" />
					<input type="hidden" name="uploadFileSettings[BannerImage][ImageHeightLimit]" value="60" />
					<input type="hidden" name="oldUploadFile[BannerImage]" value="<?=$out['DB']['Banner'][0]['BannerImage']?>" />
					<br/><br>
					<?=lang('Banner.BannerLanguages')?>:<br/>
					<?
						foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
						{
							$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
							$languagesList[$langID]['value']=$langName;		
						}								
						echo getLists($languagesList,$out['DB']['Banner'][0]['BannerLanguages'],array('name'=>'Banner'.DTR.'BannerLanguages','type'=>'checkboxes'));	
					?>	
					<!-- <br/><br/>
					<?=lang('Banner.BannerCode')?>:<br/>
					<textarea name="Banner<?=DTR?>'BannerCode'" rows="5" cols="60"><?=$out['DB']['Banner'][0]['BannerCode']?></textarea>
					<br/><br/>
					<?=lang('Banner.BannerComments')?>:<br/>
					<textarea name="Banner<?=DTR?>'BannerComments'" rows="5" cols="60"><?=$out['DB']['Banner'][0]['BannerComments']?></textarea>
					<br/><br/> -->
					<!-- <?=lang('-addafter')?>:
					&nbsp;
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
					?> -->
					<br/><br/>
					<!-- <?=lang('Banner.PermAll')?>:<br/>
					<?=getReference('PermAll','Banner'.DTR.'PermAll',$out['DB']['Banner'][0]['PermAll'],array('code'=>'Y'))?>
					<br/><br/> -->
					<? if(empty($out['DB']['Banner'][0]['BannerID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageBanners.actionMode.value='delete';confirmDelete('manageBanners', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>