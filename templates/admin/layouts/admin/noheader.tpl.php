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
<div align="center">
<table width="994"  border="0" cellspacing="0" cellpadding="10">
	{SystemMessages}
  <tr>
    <td align="left" valign="top" class="center">
		 <?=getBoxes('center')?>
	</td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="content"><?=getFormated(setting('Copyright'),'HTML')?>&nbsp;&nbsp;<?=getFormated(setting('Version'),'HTML')?>&nbsp;&nbsp;<?=lang('License.core.tip')?>: <?=setting('SystemLicense')?></td>
  </tr>
</table>	
</div> 
</body>
</html>
