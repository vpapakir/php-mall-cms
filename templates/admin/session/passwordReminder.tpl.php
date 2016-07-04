<?=boxHeader(array('title'=>'PasswordReminder.session.title'))?>
	<? if($out['Vars']['Result']=='Y') { ?>
	<tr> 
		<td valign=top bgcolor="#ffffff" align="center">
			<br/><br/>
			<?=lang('PasswordSuccessfullySent.session.tip')?>
			<br/><br/>
		</td> 
	</tr>
	<?
	} else {
	?>	
	<form name="passwordReminder" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" align="center">
					<? if ($out['Vars']['Result']=='N') { ?>
					<div class="warning"><?=lang('EmailWrongPasswordReminder.session.tip','html')?></div>
					<? } else {?>					
					<?=lang('LoginBoxIntro.session.tip','html')?>
					<? } ?>
					<br/>
					<br/>
					<?=lang('EmailPasswordRemind.session.tip')?>:<br/>
					<input type="text" name="Email" value="<?=input('Email')?>" size="50">
					<br/><br/>		
					<input type="submit" value="<?=lang("SendPassword.session.button")?>">	
					<br/><br/>
			</td> 
		</tr> 
	</form>	
	<?
	}
	?>
<?=boxFooter()?>