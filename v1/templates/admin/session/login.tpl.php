<?=boxHeader(array('title'=>'LoginBox.session.title'))?>
	<? if($out=='session.login.msg.logged') { ?>
	<tr> 
	<td valign=top bgcolor="#ffffff">
		<?=lang('LoggedIn.session.tip')?>
	</td> 
	</tr>
	<?
	} else {
	?>	
	<form name="manageLangFields" method="post">
		<input type="hidden" name="SID" value="login" />
		<input type="hidden" name="actionMode" value="login" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
			 <tr>
			 <td colspan="2" width="100%" bgcolor="#efefef" align="center">
			 	<span class="subtitle">
					<? if (!empty($out)) { ?>
					<div class="warning"><?=lang($out,'html')?></div>
					<? } else {?>					
					<?=lang('LoginIntro.session.tip','html')?>
					<? } ?>
				</span>
			</td>
			</tr>
			<tr><td align="left">
					<span class="subtitle"><?=lang('Login.session.tip')?>:</span>
			</td>
			<td align="left">
					<input type="text" name="Login" value="<?=input('Login')?>" size="30">
			</td></tr>
			<tr><td align="left">
					<span class="subtitle"><?=lang('Password.session.tip')?>:</span>
			</td><td align="left">
					<input type="password" name="Password" value="<?=input('Password')?>" size="30">
			</td></tr>
			<tr><td align="center" colspan="2">
					<a href="<?=setting('url')?>passwordReminder"><?=lang('PasswordReminderForm.session.link')?></a>
			</td></tr>
			<tr><td align="center" colspan="2" bgcolor="#efefef">
					<input type="submit" value="<?=lang("Login.session.button")?>">	
			 </td>
			 </tr>
			</table>
			</td> 
		</tr> 
	</form>	
	<?
	}
	?>
<?=boxFooter()?>