<?=boxHeader(array('title'=>'ManageTour.tour.title','tabs'=>'manageTour','tabslink'=>'TourID/'.input('TourID')))?>
<? $formName = 'manageTours'; $entityID = $out['DB']['Tour']['TourID']; $categoryID = input('CategoryID'); ?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="Tour<?=DTR?>TourID" value="<?=$out['DB']['Tour']['TourID']?>">
		<input type="hidden" name="TourID" value="<?=$out['DB']['Tour']['TourID']?>">
		<!-- <input type="hidden" name="viewMode" value="<?=input('viewMode')?>" > -->
		<input type="hidden" name="viewMode" value="profile" >
		<? if(empty($out['DB']['Tour'][0]['TourID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<? } ?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table width="100%"  border="0" cellspacing="1" cellpadding="3" bgcolor="#eeeeee">
				  <tr>
					<td width="100%" class="subtitle" bgcolor="#ffffff" colspan="2" align="center">
						<? if(input('TourRateFactor')) {$tourFactor = input('TourRateFactor'); } else {$tourFactor = 1; } ?>
						<?=getReference('TourRateFactors','TourRateFactor',$tourFactor,array('code'=>'Y','delimiter'=>' ','attributes'=>'onChange="submit();"'))?>
					</td>
				  </tr>
				  <tr>
					<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourTitle')?></td>
					<td width="70%" class="subtitle" bgcolor="#ffffff">
						<?=$out['DB']['Tour']['TourContactFirstName']?> <?=$out['DB']['Tour']['TourContactLastName']?> <? if(!empty($out['DB']['Tour']['TourTitle'])) { ?> (<?=getValue($out['DB']['Tour']['TourTitle']) ?>) <? } ?>
					</td>
				  </tr>
				  <tr>
					<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactAddress')?></td>
					<td width="70%" class="subtitle" bgcolor="#ffffff">
						<?=$out['DB']['Tour']['TourContactFirstName']?> <?=$out['DB']['Tour']['TourContactLastName']?>, <?=$out['DB']['Tour']['TourContactAddress']?>, <?=$out['DB']['Tour']['TourContactCity']?>, <?=$out['DB']['Tour']['TourContactPostalCode']?>,
						<?=getListValue($out['DB']['Regions'],$out['DB']['Tour']['TourContactRegionID'],array('id'=>'RegionID','value'=>'RegionName','type'=>'dropdown'))?>,  
						<?=getListValue($out['DB']['Countries'],$out['DB']['Tour']['TourContactCountryID'],array('id'=>'RegionID','value'=>'RegionName','type'=>'dropdown'))?>
						<br/>
						<?=lang('Tour.TourContactPhone')?>: <?=$out['DB']['Tour']['TourContactPhone']?>, <?=lang('Tour.TourContactFax')?>: <?=$out['DB']['Tour']['TourContactFax']?>, <?=lang('Tour.TourContactICQ')?>: <?=$out['DB']['Tour']['TourContactICQ']?>, <?=lang('Tour.TourContactSkype')?>: <?=$out['DB']['Tour']['TourContactSkype']?>
						<br/>
						<? $email = $out['DB']['Tour']['TourContactEmail']?>
						<br/>
						<a href="mailto:<?=$email?>"><?=$email?></a>, <a href="mailto:<?=$out['DB']['Tour']['TourContactWebsite']?>"><?=$out['DB']['Tour']['TourContactWebsite']?></a>
						<br/>
						<?=$out['DB']['Tour']['TourContactComments']?>
					</td>
				  </tr>	
				  <tr>
					<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourType')?></td>
					<td width="70%" class="subtitle" bgcolor="#ffffff">
						<?=getListValue($out['DB']['TourTypes'],$out['DB']['Tour']['TourType'],array('id'=>'TourTypeAlias','value'=>'TourTypeName','type'=>'dropdown'))?>
					</td>
				  </tr>			
				  <tr>
					<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourCountryID')?></td>
					<td width="70%" class="subtitle" bgcolor="#ffffff">
						<?=getListValue($out['DB']['Countries'],$out['DB']['Tour']['TourCountryID'],array('id'=>'RegionID','value'=>'RegionName','type'=>'dropdown'))?>
					</td>
				  </tr>				  	  
				  <tr>
					<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourRegionID')?></td>
					<td width="70%" class="subtitle" bgcolor="#ffffff">
						<?=getListValue($out['DB']['Regions'],$out['DB']['Tour']['TourRegionID'],array('id'=>'RegionID','value'=>'RegionName','type'=>'dropdown'))?>
					</td>
				  </tr>	
				  <tr>
					<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourCity')?></td>
					<td width="70%" class="subtitle" bgcolor="#ffffff">
						<?=$out['DB']['Tour']['TourCity']?>
					</td>
				  </tr>		
					<?=showTourExtraFieldsList($out,'details')?>	
					<? 
						// ======================== START SHOW RATES =================
						//get room types
						$roomTypes = getTourFieldsTypesForRatesShow($out,'TourAvailableRoomsValue1');
						//get service types
						$serviceTypes = getTourFieldsTypesForRatesShow($out,'TourAvailableBoardValue1');
						//get all season types
						$seasonAllTypes = getTourFieldsTypesForRatesShow($out,'TourAvailableSeasonsValue2');
						//filter and get only active season types
						$seasonTypes = getTourActiveSeasonsForRatesShow($out,$seasonAllTypes);
						//print_r($seasonTypes);
					?>		  
					<? 
						if(is_array($seasonTypes)) { foreach($seasonTypes as $seasonType) {
						//$seasonType['code']='s1';
						$i++;
						$TourRatePricePerPerson = ''; 
						$TourRateMinimumNights = ''; 
						$TourRateComments = ''; 
						
						if(is_array($out['DB']['TourRates'])) { 
							foreach($out['DB']['TourRates'] as $row) { 
								if($row['SeasonType']==$seasonType['code'] && empty($row['RoomType']) && empty($row['ServiceType']) && $row['TourID']==$out['DB']['Tour']['TourID'] ) { 
									$TourRatePricePerPerson=$row['TourRatePricePerPerson']; 
									$TourRateMinimumNights=$row['TourRateMinimumNights']; 
									$TourRateComments=$row['TourRateComments']; 
								} 
							} 
						} 
					?>		
					  <tr>
						<td width="30%" class="subtitle" bgcolor="#EEEEEE" valign="top"><?=$seasonType['name']?> <?=lang('SeasonSubtitle.tour.tip')?></td>
						<td width="70%" class="subtitle" bgcolor="#EEEEEE">
							<? foreach ($seasonType['options'] as $seasonTypeOption) { ?>
								<?=$seasonTypeOption['name']?><br/>
							<? } ?>
						</td>
					  </tr>		
					  <tr>
						<td width="30%"  bgcolor="#ffffff"><?=lang('TourRate.TourRatePricePerPerson')?></td>
						<td width="70%"  bgcolor="#ffffff">
							<?=getReferenceValue('TourRate.TourRatePricePerPerson',$TourRatePricePerPerson)?>
						</td>
					  </tr>		
					  <tr>
						<td width="30%"  bgcolor="#ffffff"><?=lang('TourRate.TourRateMinimumNights')?></td>
						<td width="70%"  bgcolor="#ffffff">
							<?=$TourRateMinimumNights?>
						</td>
					  </tr>
					  <tr>
						<td width="30%"  bgcolor="#ffffff"><?=lang('TourRate.TourRateComments')?></td>
						<td width="70%"  bgcolor="#ffffff">
							<?=$TourRateComments?>
						</td>
					  </tr>		  		  
					  <tr>		  
						<td width="100%" class="subtitle" bgcolor="#ffffff" colspan="2">
							<? if(is_array($roomTypes) && is_array($serviceTypes)) { ?>
							<table cellpadding="3" cellspacing="1" border="0" width="100%">
								<tr>
									<td width="30%">
										<b><?=lang('ServiceRateColumnName.tour.tip')?></b>
									</td>
									<? foreach($serviceTypes as $serviceType) { ?>
									<td class="row1" align="center">
										<b><?=$serviceType['name']?></b>
									</td>
									<? } ?>
								</tr>				
								<? foreach($roomTypes as $roomType) {  ?>
								<tr>
									<td>
										<?=$roomType['name']?>
									</td>
									<? foreach($serviceTypes as $serviceType) { $i++;  ?>
									<td class="row1" align="center">
										<? if(is_array($out['DB']['TourRates'])) { foreach($out['DB']['TourRates'] as $row) { ?>
											<? if($row['SeasonType']==$seasonType['code'] && $row['RoomType']==$roomType['code'] && $row['ServiceType']==$serviceType['code'] && $row['TourID']==$out['DB']['Tour']['TourID'] ) { ?>
											<?=round($row['TourRatePrice']*$tourFactor,2)?>
											<? } ?>
										<? }} else { ?>
											
 										<? } ?>
									</td>
									<? } ?>
								</tr>
								<? } ?>
							</table>	
							<? } ?>			
						</td>
					  </tr>		
					  <? } } // end of if(is_array($seasonTypes)) { foreach($seasonTypes as $seasonType)  ?>  					
					  <? //// ======================== END SHOW RATES =================?>
					<td colspan="2" align="left" bgcolor="#EEEEEE" class="subtitle">
						<?=lang('PolicyTitle.tour.tip')?>
					</td>
					<?=showTourExtraFieldsList($out,'rates')?>	
					<?=showTourExtraFieldsList($out,'description')?>	
				  <tr>
					<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourComments')?></td>
					<td width="70%" class="subtitle" bgcolor="#ffffff">
						<?=$out['DB']['Tour']['TourComments']?>
					</td>
				  </tr>
				  <tr>
					<td width="30%" c valign="top" bgcolor="#ffffff">
						<?=lang('Tour.TourIntro')?>
					</td>
					<td width="70%" bgcolor="#ffffff">
						<?=getValue($out['DB']['Tour']['TourIntro'])?>
					</td>
				</tr>
				  <tr>
					<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContent')?></td>
					<td width="70%" class="subtitle" bgcolor="#ffffff">
						<?=getValue($out['DB']['Tour']['TourContent'])?>
					</td>
				  </tr>	
				  <tr>								  		  			  			  			  				  
					<td colspan="2" align="center" bgcolor="#EEEEEE">
						<? if(empty($out['DB']['Tour']['TourID'])) { ?>
						<input type="submit" value="<?=lang("-add")?>">
						<? } else { ?>
						<input type="submit" value="<?=lang("-edit")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.<?=$formName?>.actionMode.value='delete';confirmDelete('manageTour', '<?=lang("-deleteconfirmation")?>');">
						<? } ?>					
						&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.<?=$formName?>.actionMode.value='cancell';document.<?=$formName?>.SID.value='manageTours';submit();">
					</td>
				  </tr>
				</table>	
				<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>