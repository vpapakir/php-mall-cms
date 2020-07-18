<?
	$resultType = $params['resultType']; if(empty($resultType)) {$resultType='all';}
?>

<? if($resultType=='messagesonly') { ?>
<?=boxHeader(array('title'=>'ViewComboardNewMessages.comboard.title'))?> 
<? } elseif($resultType=='nomessages') { ?>
<?=boxHeader(array('title'=>'ViewComboardMessages.comboard.title'))?> 
<? } else { ?>
<?=boxHeader(array('title'=>'ViewComboardAllMessages.comboard.title'))?> 
<? } ?>
<script language="javascript">
	function change_message(id,parentid,action){
		var question='';
		if (action=='hide'){
			question="<?=lang('ConfirmHideMessage.comboard.tip')?>";
		}
		if(question==''){
			document.location="<?=setting('url')?>comboard2/actionMode/"+action+"/ComboardMessage<?=DTR?>ComboardMessageID/"+id+"/MessageID/"+parentid;
		}else if(window.confirm(question)){
			document.location="<?=setting('url')?>comboard2/actionMode/"+action+"/ComboardMessage<?=DTR?>ComboardMessageID/"+id+"/MessageID/"+parentid;
		}
	}
</script>
<?
	foreach($out['DB']['Administrators'] as $key=>$row){
		$administrators[$key]['id'] = $row['UserID'];
		$administrators[$key]['value'] = $row['UserName'];
	}

?>
<? if($resultType!='messagesonly') { ?>
<tr>
	<td>
		<table border="0" cellpadding="3" cellspacing="0" width="100%">
		<form name="getViewComboardMassages" method="post"> 
			<input type="hidden" name="SID" value="comboard2" /> 
			<input type="hidden" name="viewMode" value="<?=input('viewMode')?>" /> 
			<tr> 
				<td align="center">
					<input type="button" name="Day" value="<?=lang('Day.comboard.tip')?>" onClick="document.getViewComboardMassages.viewMode.value='day';submit();"/> 
					&nbsp;
					<input type="button" name="Day" value="<?=lang('Week.comboard.tip')?>" onClick="document.getViewComboardMassages.viewMode.value='week';submit();"/> 
					&nbsp;
					<input type="button" name="Day" value="<?=lang('Month.comboard.tip')?>" onClick="document.getViewComboardMassages.viewMode.value='month';submit();"/> 
				</td>
			</tr> 
			<tr>
				<td  align="center">
					<?
						if(input('SelectedAdministrators'))
						{
							$SelectedAdministrators = implode("|",input('SelectedAdministrators')).'|'; 
						}
					?>
					<?=getLists($administrators,$SelectedAdministrators,array('name'=>'SelectedAdministrators','type'=>'multiple','style'=>"width:200px; height:70px;"));?>
				</td>
			</tr>
			<tr>
				<td  align="center">
					<?=getFormated(input('ComboardMessageStartTime'),'Date','form',array('fieldName'=>'ComboardMessageStartTime','formName'=>'getViewComboardMassages'));?> 
					&nbsp;&nbsp;
					<?=getFormated(input('ComboardMessageEndTime'),'Date','form',array('fieldName'=>'ComboardMessageEndTime','formName'=>'getViewComboardMassages'));?>
					<br/>
					<input type="button" name="Period" value="<?=lang('ShowByPeriod.comboard.button')?>" onClick="document.getViewComboardMassages.viewMode.value='period';submit();"/> 
				</td>
			</tr>
		</form>
		</table>
	</td>
</tr> 
<tr> 
  <td valign="top" bgcolor="#ffffff" class="subtitle" align="center">&nbsp;  </td> 
</tr> 
<tr> 
  <td valign="top" bgcolor="#ffffff" class="subtitle" align="center"> <?=(lang('ComboardOf.comboard.subtitle').' '.user('UserName').' '.getFormated(input('chosenDate'),'date'))?> </td> 
</tr> 
<tr> 
  <td valign="top" bgcolor="#ffffff" class="subtitle" align="center">&nbsp;  </td> 
</tr>
<? } ?> 

<? 
	if($resultType=='messagesonly') {$codesToShow = 'message';} elseif($resultType=='nomessages') {$codesToShow = 'event,task,calendar';} else {$codesToShow='all';} 
	foreach($out['DB']['ComboardMessagesByType'] as $key=>$row){
	if(eregi($key,$codesToShow) || $codesToShow=='all') {
	?>
		<tr>
			<td class="subtitleline" align="center">
				<b><?=lang($key.'Type.comboard.title')?></b>
			</td>
		</tr>
        <? if(!empty($row)){?>
		<? foreach($row as $value){?>
			<tr>
				<td>
					<?
						if(!empty($value['ComboardMessageParentID']))
						{
							$ComboardMessageID = $value['ComboardMessageParentID'];
						}
						else
						{
							$ComboardMessageID = $value['ComboardMessageID'];
						}

						$icon = setting('layout').'/images/icons/cb_'.$value['ComboardMessageType'];
						if($value['ComboardMessageType']=='task'){
							if(strstr($value['ComboardMessageStatus'],'|completed|'))
								$icon .= '_completed';
							elseif($value['ComboardMessageStartTime']<date('Y-m-d H:i:s'))
								$icon .= '_delayed';
						}
						if($value['ComboardMessageType']=='calendar' && strstr($value['ComboardMessageStatus'],'|completed|')){
							$icon .= '_completed';
						}
						$icon .= '.gif';
						if($value['ComboardMessageType']=='task' || $value['ComboardMessageType']=='calendar')
							echo '<a href="#" onclick="change_message('.$value['ComboardMessageID'].',\''.$ComboardMessageID.'\',\'complete\')"><img src="'.$icon.'" alt="'.$value['ComboardMessageTitle'].'" border=0></a>';
						elseif($value['ComboardMessageType']=='event')
							echo '<a href="#" onclick="change_message('.$value['ComboardMessageID'].',\''.$ComboardMessageID.'\',\'hide\')"><img src="'.$icon.'" alt="'.$value['ComboardMessageTitle'].'" border=0></a>';
						elseif($value['ComboardMessageType']=='memo')
							echo '<a href="'.setting('url').input('SID').'/ComboardMessageID/'.$value['ComboardMessageID'].'"><img src="'.$icon.'" alt="'.$value['ComboardMessageTitle'].'" border=0></a>';
						elseif($value['ComboardMessageType']=='message')
							echo '<a href="#" onclick="change_message('.$value['ComboardMessageID'].',\''.$ComboardMessageID.'\',\'hide\')"><img src="'.$icon.'" alt="'.$value['ComboardMessageTitle'].'" border=0></a>';
					?>
					<a href="<?=setting('url')?>comboard2/MessageID/<?=$ComboardMessageID?>"><?=$value['ComboardMessageTitle']?></a> 
					&nbsp;<? if(user('UserID')==$value['UserID'] && empty($value['ComboardMessageParentID'])) { ?> <a href="<?=setting('url')?><?=input('SID')?>/MessageID/<?=$value['ComboardMessageID']?>/actionMode/edit/"><?=lang('EditMessage.comboard.link')?></a> <? } ?>
					<br/>
					[<?=lang('CreatedBy.comboard.tip')?> <?=getListValue($administrators,$value['UserID'],array('name'=>'User'.DTR.'OwnerParentID'));?> <?=lang('CreatedOn.comboard.tip')?> <?=getFormated($value['TimeCreated'],'DateTime')?> <?=lang('CreatedFor.comboard.tip')?> <?=getListValue($administrators,$value['ComboardMessageUsers'],array('name'=>'User'.DTR.'OwnerParentID','type'=>'checkboxes'));?>]
					<? if($value['ComboardMessageType']=='calendar') { ?>
						<br/><?=lang('MeetingTime.comboard.tip')?>: <?=getFormated($value['ComboardMessageStartTime'],'DateTime')?> |  <?=lang('MeetingDuration.comboard.tip')?>: <?=$value['ComboardMessageDuration']?> <?=lang('MeetingDurationMinutes.comboard.tip')?>
					<? } elseif($value['ComboardMessageType']=='task') { ?>
						<br/><?=lang('TaskDeadLine.comboard.tip')?>: <?=getFormated($value['ComboardMessageStartTime'],'DateTime')?>
					<? } elseif($value['ComboardMessageType']=='event') { ?>
						<br/><?=lang('EventStart.comboard.tip')?>: <?=getFormated($value['ComboardMessageStartTime'],'DateTime')?> | <?=lang('EventEnd.comboard.tip')?>: <?=getFormated($value['ComboardMessageEndTime'],'DateTime')?>
					<? } ?>
					<? if(!empty($value['ComboardMessageReadBy'])) { ?>
					<br/>
					<font color="#FF0000">[<?=lang('ReadBy.comboard.tip')?>: <?=getListValue($administrators,$value['ComboardMessageReadBy'],array('type'=>'checkboxes'));?>]</font>
					<? } ?>
				</td>
			</tr>
		<? }  }
	}
	}
?>
<?=boxFooter()?>