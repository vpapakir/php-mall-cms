<?
	if(input('actionMode')=='save')
	{
		goLink(setting('url').'comboard2/MessageID/'.input('MessageID').'/');
	}
?>
<?=boxHeader(array('title'=>'AnswerComboardMessages.comboard.title'))?>

<script language="javascript">
	/*
	function change_message(id,action){
		var question='';
		if (action=='hide'){
			question="<?=lang('ConfirmHideMessage.comboard.tip')?>";
		}
		if(question==''){
			document.location="<?=setting('url').input('SID')?>/actionMode/"+action+"/ComboardMessage<?=DTR?>ComboardMessageID/"+id;
		}else if(window.confirm(question)){
			document.location="<?=setting('url').input('SID')?>/actionMode/"+action+"/ComboardMessage<?=DTR?>ComboardMessageID/"+id;
		}
	}
	*/
</script>
<?
	foreach($out['DB']['Administrators'] as $key=>$row){
		$administrators[$key]['id'] = $row['UserID'];
		$administrators[$key]['value'] = $row['UserName'];
	}

?>
 
<tr> 
	<td valign="top" bgcolor="#ffffff" class="subtitle" align="center">
		<?=(lang('ComboardOf.comboard.subtitle').' '.user('UserName').' '.getFormated(input('chosenDate'),'date'))?>
	</td> 
</tr> 
<tr>
	<td>
		<?
			$value = $out['DB']['ParentComboardMessage'][0];
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
				echo '<img src="'.$icon.'" alt="'.$value['ComboardMessageTitle'].'" border=0>';
			elseif($value['ComboardMessageType']=='event')
				echo '<img src="'.$icon.'" alt="'.$value['ComboardMessageTitle'].'">';
			elseif($value['ComboardMessageType']=='memo')
				echo '<img src="'.$icon.'" alt="'.$value['ComboardMessageTitle'].'" border=0>';
			elseif($value['ComboardMessageType']=='message' && !$value['ComboardMessageParentID'])
				echo '<img src="'.$icon.'" alt="'.$value['ComboardMessageTitle'].'" border=0>';
		?>
		<b><?=$value['ComboardMessageTitle']?></b> 
		&nbsp;<? if(user('UserID')==$value['UserID']) { ?> <a href="<?=setting('url')?><?=input('SID')?>/MessageID/<?=$value['ComboardMessageID']?>/actionMode/edit/"><?=lang('EditMessage.comboard.link')?></a> <? } ?>
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
		<br/>
		<span class="subtitle"><?=getFormated($out['DB']['ParentComboardMessage'][0]['TimeCreated'],'DateTime');?></span>
		<br/>
		<?=$out['DB']['ParentComboardMessage'][0]['ComboardMessageContent']?>
	</td>
</tr>
<?
if(input('actionMode')=='edit')
{
	$ComboardMessageTitle = $out['DB']['ComboardMessage'][0]['ComboardMessageTitle'];
	$ComboardMessageContent = $out['DB']['ComboardMessage'][0]['ComboardMessageContent'];
}
else
{
	$ComboardMessageTitle = '';
	$ComboardMessageContent = '';
}
?>
<form name="sendComboardMessage" method="post"> 
	<input type="hidden" name="SID" value="<?=input('SID')?>" /> 
	<input type="hidden" name="actionMode" value="save" /> 
	<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageParentID" value="<?=input('MessageID')?>" /> 
	<input type="hidden" name="MessageID" value="<?=input('MessageID')?>" /> 
	<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageType" value="message" /> 
	<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageStartTime" value="<?=getFormated('','date')?>"/> 
	<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageUsers" value="<?=$out['DB']['ParentComboardMessage'][0]['ComboardMessageUsers'].$out['DB']['ParentComboardMessage'][0]['UserID']?>|"/>
	<input type="hidden" name="ComboardMessage<?=DTR?>ComboardMessageGroups" value="<?=$out['DB']['ParentComboardMessage'][0]['ComboardMessageGroups']?>" />
	<tr> 
		<td valign="top" bgcolor="#ffffff" class="fieldNames" align="left">
			<br/> 
			<?=lang('ComboardMessage.ComboardMessageTitle')?> 
			<br/> 
			<input type="text" name="ComboardMessage<?=DTR?>ComboardMessageTitle" value="<?=$ComboardMessageTitle?>" size="50">
		</td> 
	</tr> 
	<tr> 
		<td valign="top" bgcolor="#ffffff" class="fieldNames" align="left"> <?=lang('ComboardMessage.ComboardMessageContent')?> 
			<br/> 
			<textarea name="ComboardMessage<?=DTR?>ComboardMessageContent" cols="35" rows="10"><?=$ComboardMessageContent?></textarea>
		</td> 
	</tr> 
	<tr> 
		<td valign="top" bgcolor="#ffffff" class="fieldNames" align="left">
			<input type="submit" value="<?=lang("-send")?>">
			<? if(user('UserID')==$out['DB']['ParentComboardMessage'][0]['UserID']){?>
				<input type="button" name="goComboardHome" value="<?=lang('-edit')?>" onClick="location.replace('<?=setting('url').input('SID')?>/ComboardMessageID/<?=input('MessageID')?>');"/> 
			<? }?>
		</td> 
	</tr> 
	<tr> 
		<td>
			<table> 
			<? foreach($out['DB']['ThreadComboardMessages'] as $value){?>
				<tr>
					<td>
						<span class="subtitle"><?=getFormated($value['TimeCreated'],'DateTime');?> sent by <?=getUserName($out,$value['UserID'])?></span>
						<br>
						<span class="subtitle"><?=$value['ComboardMessageTitle']?></span>
						<br>
						[<?=lang('ReadByMessage.comboard.tip')?>: <?=getListValue($administrators,$value['ComboardMessageReadBy'],array('type'=>'checkboxes'));?>]
						<br>
						<?=$value['ComboardMessageContent']?>
					</td>
				</tr>
			<? }?>
				<!-- <tr> 
					<? //echo getComboardMessagesLib($out['DB']['ThreadComboardMessages']);?> 
				</tr>  -->
			</table>
		</td> 
	</tr> 
</form>
<?=boxFooter()?>
