<? getBox('core.frontAdminController'); ?>
<?=getBoxes('system')?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head>
<title><?=setting('PageTitle')?> <?=setting('SiteName')?></title>
<link href="<?=setting('layout')?>css/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript1.2">popupDefaultHeight = <?=setting('popupheight')?>;popupDefaultWith = <?=setting('popupwith')?>;</script>
<script language="JavaScript1.2" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/mainscript.js"></script>
<script language="JavaScript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/calendar/calendar.js"></script>
<script language="javascript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/validator/validator.js"></script>
<script language="JavaScript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/menu/JSCookMenu.js"></script>
<script language="JavaScript"> rooturl='<?=setting('rooturl')?>';</script>
<link href="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/menu/ThemeOffice/theme.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/menu/ThemeOffice/theme.js"></script>
</head>
<body> 
<table width="994"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="middle" class="header">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td width="80%" valign="middle"><a href="<?=setting('url')?>homeadmin/" style="text-decoration:none">
				<? if (setting('SiteLogo')) { ?>
					<img src="<?=setting('urlfiles')?><?=setting('SiteLogo')?>" border="0"/>
				<? } else { ?>
					  <font color="#333333" size="+2"><?=setting('SiteName')?> - <?=lang('-adminpanel')?></font>
				<? } ?>
				</a></td>
				<td width="20%" align="right" valign="middle">
					<? getBox('core.ownerSwitcher');?>
				</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td align="left" valign="top" background="<?=setting('layout')?>images/bg-line.gif"><img src="<?=setting('layout')?>images/bg-line.gif" width="1" height="2"></td>
  </tr>
  <? if(hasRights('admin')) { ?>
  <tr>
  	<td>
		<iframe id=myiframe scrolling="no" frameborder="0" src="<?=setting('url')?>reddotsiframeadm/windowMode/frame" height="23px" width="994px">
		</iframe>
	</td>
  </tr>
  <tr>
    <td align="left" valign="top" background="<?=setting('layout')?>images/bg-line.gif"><img src="<?=setting('layout')?>images/bg-line.gif" width="1" height="2"></td>
  </tr>
  <? }?>
  <tr>
    <td height="23" align="left" valign="middle" class="menu" >
		<? getBox('core.adminMenu');?>
	</td>
  </tr>
  <tr>
    <td background="<?=setting('layout')?>images/grd.gif"><img src="<?=setting('layout')?>images/grd.gif" width="1" height="1"></td>
  </tr>
	{SystemMessages}
	<? getBox('help.getHelpTipBox')?>	 
  <tr><td  class="center" ><table width=100%><tr>
    <td align="left" valign="top" width=33%>
		 <?=getBox('taskboard.Taskboard')?>
	</td>
	</tr></table></td>
  </tr>
  <tr>
    <td background="<?=setting('layout')?>images/bg-line.gif"><img src="<?=setting('layout')?>images/bg-line.gif" width="1" height="2"></td>
  </tr>
  <tr>
    <td height="23" align="left" valign="middle" class="bottom">&copy; 2005-<?=date('Y')?> Coomall. Version 1.0.1 </td>
  </tr>
  <tr>
    <td background="<?=setting('layout')?>images/bg-line.gif"><img src="<?=setting('layout')?>images/bg-line.gif" width="1" height="2"></td>
  </tr>
</table>	 
</body>
</html>
