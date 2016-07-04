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
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<? if (!empty($out)) { ?>
					<div class="warning"><?=lang($out,'html')?></div>
					<? } else {?>					
					<?=lang('LoginIntro.session.tip','html')?>
					<? } ?>
					<br/>
					<br/>
					<?=lang('Login.session.tip')?>:<br/>
					<input type="text" name="Login" value="<?=input('Login')?>" size="30">
					<br/>
					<?=lang('Password.session.tip')?>:<br/>
					<input type="password" name="Password" value="<?=input('Password')?>" size="30">
					<br/><br/>		
					<input type="submit" value="<?=lang("Login.session.button")?>">	
					<br/><br/>
			</td> 
		</tr> 
	</form>	
	<?
	}
	?>
<?=boxFooter()?>