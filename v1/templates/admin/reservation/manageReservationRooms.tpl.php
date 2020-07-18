
<?
if (empty($user['UserID']))
{?>
	<table border="0" width="100%">
	    <tr>
	        <td width="50%">
		        <?=getBox('session.login')?>
	        </td>
	        <td width="50%">
	        </td>
	    </tr>
	</table>
<? }
else { ?>
<?=boxHeader(array('title'=>'','tabs'=>'manageReservationRooms'))?>
	<table width="100%">
		<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
		<input type="hidden" name="viewMode" value="<?=input('viewMode')?>" />

		<tr>
            <td align="left" colspan="3" height=14 valign=middle bgcolor="#eeeeee">
                <span class="listingfont"><?=lang('RoomReservationTitle.reservation.tip')?></span>
            </td>
        </tr>
		<tr>
			<td class="subtitle"><?=lang('SelectRoom.reservation.tip')?></td>
			<td>
					<? 
						$options[0]['id']='---';	
						$options[0]['value']='- '.lang('NewRoom.reservation.option').' -';
						echo getLists($out['DB']['ReservationRooms'],input('ReservationRoom'.DTR.'ReservationRoomID'),array('name'=>'ReservationRoom'.DTR.'ReservationRoomID','id'=>'ReservationRoomID','value'=>'OptionName','options'=>$options,'action'=>'submit();'));	
					
					?>	

		
			</td>
		</tr>
		</form>
	<? $formName  = 'ReservationOrderRooms'; ?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="<?=input('actionMode')?>" />
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
 	    <input type="hidden" name="ReservationRoom<?=DTR?>ReservationRoomID" value="<?=input('ReservationRoom'.DTR.'ReservationRoomID')?>" />
 	    <!--<input type="hidden" name="ReservationRoom<?=DTR?>OptionCode" value="<?=$out['DB']['ReservationRoom'][0]['OptionCode']?>" />-->
 	    <input type="hidden" name="viewMode" value="<?=input('viewMode')?>" />

<? //print_r($input);?>
<? //print_r($config)?>
<? //print_r($user)?>
<? //print_r($out)?>
<? //print_r($out['DB']['ReservationRooms'])?>
                <tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.ReservationOrderId')?>
                    </td>
                    <td>
                        <?if ($out['DB']['ReservationRoom'][0]['OptionCode'] == 'new') {?>
                        	<input type="text" name="ReservationRoom<?=DTR?>OptionCode" size="30">
                        <?} else {?>
                            <input type="text" name="ReservationRoom<?=DTR?>OptionCode" size="30" value="<?=$out['DB']['ReservationRoom'][0]['OptionCode']?>">
                        <?}?>
                    </td>
                </tr>
                    <? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
                        <tr>
							<td class="subtitle">
								<?=lang('ReservationOrder.ReservationOrderValue')?> <?echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
							</td>
							<td>
								<input type="text" name="ReservationRoom<?=DTR?>OptionName[<?=$langCode?>]" value="<?=getValue($out['DB']['ReservationRoom'][0]['OptionName'],$langCode)?>" size="30">
							</td>
						</tr>
					<? } ?>
                    
                <tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.ReservationOrderType')?>
                    </td>
                    <td>
						<? if(empty($out['DB']['ReservationRoom'][0]['OptionRoomType'])) {$out['DB']['ReservationRoom'][0]['OptionRoomType']='room';} ?>
						<?//print_r($out['DB']['ReservationRoom'][0])?>
						<?=getReference('ReservationRoom.ReservationOrderType','ReservationRoom'.DTR.'OptionRoomType',$out['DB']['ReservationRoom'][0]['OptionRoomType'],array('code'=>'Y'))?>
                    </td>
                </tr>
                <? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
                        <tr>
							<td class="subtitle">
								<?=lang('ReservationOrder.ReservationOrderDescription')?> <?echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
							</td>
							<td>
								<TEXTAREA rows=3 cols=18 name="ReservationRoom<?=DTR?>OptionDescription[<?=$langCode?>]"><?=getValue($out['DB']['ReservationRoom'][0]['OptionDescription'],$langCode)?></TEXTAREA>
							</td>
						</tr>
					<? } ?>
                <!--<tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.ReservationOrderDescription')?>
                    </td>
                    <td>
                        <TEXTAREA rows=3 cols=18 name="ReservationRoom<?=DTR?>OptionDescription"><?=$out['DB']['ReservationRoom'][0]['OptionDescription']?></TEXTAREA>
                    </td>
                </tr>-->
                <tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.ReservationOrderMinimumOccupation')?>
                    </td>
                    <td>
                        <input type="text" name="ReservationRoom<?=DTR?>OptionMinOccupation" size="30" value="<?=$out['DB']['ReservationRoom'][0]['OptionMinOccupation']?>">
                    </td>
                </tr>
                <tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.ReservationOrderMaximumOccupation')?>
                    </td>
                    <td>
                        <input type="text" name="ReservationRoom<?=DTR?>OptionMaxOccupation" size="30" value="<?=$out['DB']['ReservationRoom'][0]['OptionMaxOccupation']?>">
                    </td>
                </tr>
                <tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.ReservationOrderMaximumChildren')?>
                    </td>
                    <td>
                        <input type="text" name="ReservationRoom<?=DTR?>OptionMaxChildren" size="30" value="<?=$out['DB']['ReservationRoom'][0]['OptionMaxChildren']?>">
                    </td>
                </tr>
                <tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.ReservationOrderRoomThumb')?>
                    </td>
                    <td>
						<input type="hidden" name="fileField"/>
						<input type="hidden" name="ResourceID" value="<?=$out['DB']['ReservationRoom'][0]['ReferenceOptionID']?>">
						<?$fieldName = 'OptionIcon';?>

						<?echo getFormated($out['DB']['ReservationRoom'][0]['OptionIcon'],'Image','form',array('imageSizeType'=>'all','fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'));
                        ?>
					</td>
                </tr>
                <? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
                    <tr>
						<td class="subtitle">
							<?=lang('ReservationOrder.ReservationOrderUrl')?> <?echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
						</td>
						<td>
							<input type="text" name="ReservationRoom<?=DTR?>OptionRoomUrl[<?=$langCode?>]" value="<?=getValue($out['DB']['ReservationRoom'][0]['OptionRoomUrl'],$langCode)?>" size="30">
						</td>
					</tr>
				<? } ?>
                <tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.ReservationOrderTarget')?>
                    </td>
                    <td>
						<? if(empty($out['DB']['ReservationRoom'][0]['OptionRoomTarget'])) {$out['DB']['ReservationRoom'][0]['OptionRoomTarget']='_self';} ?>
						<?=getReference('target','ReservationRoom'.DTR.'OptionRoomTarget',$out['DB']['ReservationRoom'][0]['OptionRoomTarget'],array('code'=>'Y'))?>
                    </td>
                </tr>
                <tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.addafter.tip')?>
                    </td>
                    <td>                        
 <? 
                               $options[0]['id']='1';      
                               $options[0]['value']='- '.lang('-first').' -'; 
                               if(is_array($out['DB']['ReservationRooms'])) 
                               { 
                                    foreach($out['DB']['ReservationRooms'] as $row) 
                                    { 
                                         if ($row['ReservationRoomID']!=$out['DB']['ReservationRoom'][0]['ReservationRoomID']) 
                                         { 
                                              $i++; 
                                              $options[$i]['id']=$row['OptionPosition']+1;      
                                              $options[$i]['value']=$row['OptionName']; 
                                         } 
                                    } 
                               } 
                               echo getLists('',$out['DB']['ReservationRoom'][0]['OptionPosition']-1,array('name'=>'ReservationRoom'.DTR.'OptionPosition','id'=>'OptionPosition','value'=>'OptionName','options'=>$options));      
                               $options=''; 
                          ?>           
                    </td>
                </tr>
                <tr>
                    <td class="subtitle">
                        <?=lang('ReservationOrder.ReservationOrderReflection')?>
                    </td>
                    <td>
						<? if(empty($out['DB']['ReservationRoom'][0]['OptionReflection'])) {$out['DB']['ReservationRoom'][0]['OptionReflection']='active';} ?>
						<?=getReference('ReservationRoom.OptionReflection','ReservationRoom'.DTR.'OptionReflection',$out['DB']['ReservationRoom'][0]['OptionReflection'],array('code'=>'Y'))?>
                    </td>
                </tr>
                <tr>
					<td>&nbsp;</td>
                    <td align="left">
                    
                    <? if (empty($out['DB']['ReservationRoom'][0]['ReservationRoomID'])) {?>
                        <input type="button" value="<?=lang("ReservationOrder.Add.tip")?>" onClick="document.<?=$formName?>.actionMode.value='addRoom';submit();">
                    <? }
                    else { ?>
                          <input type="button" value="<?=lang("ReservationOrder.Save.tip")?>" onClick="document.<?=$formName?>.actionMode.value='saveRoom';submit();">
                          <? if(hasRights('root')) {  ?>
						  <input type="button" value="<?=lang("ReservationOrder.Delete.tip")?>" onClick="document.<?=$formName?>.actionMode.value='deleteRoom';confirmDelete('ReservationOrderRooms', '<?=lang("-deleteconfirmation")?>');">
						  <? } ?>
                    <? } ?>
                    </td>
                </tr>
				</form>
			</table>
<?=boxFooter()?>
<?}?>