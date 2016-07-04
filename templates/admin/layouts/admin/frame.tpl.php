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
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0 bgcolor="#EEEEEE"> 
	<? getBoxes('center');?>
</body>
</html>

