<? getBox('core.frontAdminController'); ?>
<?=getBoxes('system')?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=setting('PageTitle')?> <?=setting('SiteName')?></title>
<link href="<?=setting('layout')?>css/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript1.2" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/mainscript.js"></script>
<script language="javascript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/validator/validator.js"></script>
<script language="javascript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/calendar/calendar.js"></script>
<style type="text/css" >
	body{
		font-family:<?=setting('TextFont')?>;
		font-size:<?=setting('TextSize')?>px;
		color:<?=setting('TextColor')?>;
		<? if(setting('PageBackground')) { ?>background-image:<?=setting('urlfiles').setting('PageBackground')?>;<? } ?>
		<? if(setting('PageColor')) { ?>background-color:<?=setting('PageColor')?>;<? } ?>
	}	
	input, select {
		font-family:<?=setting('TextFont')?>;
		font-size:<?=setting('TextSize')?>px;
		color:<?=setting('TextColor')?>;
	}	
	a:hover 
	{ 
		font-family: <?=setting('TextFont')?>; 
		text-decoration: <?=setting('LinkHoverDecoration')?>; 
		color: <?=setting('LinkHoverColor')?>; 
	}
	a { 
		font-family: <?=setting('TextFont')?>; 
		text-decoration: <?=setting('LinkDecoration')?>; 
		color: <?=setting('LinkColor')?>; 
	}	
	td{
		font-family:<?=setting('TextFont')?>;
		font-size:<?=setting('TextSize')?>px;
		color:<?=setting('TextColor')?>;
	}		
	.title 
	{ 
		font-family:<?=setting('TitleFont')?>;
		font-size:<?=setting('TitleSize')?>px;
		color:<?=setting('TitleColor')?>; 
		font-weight: <?=setting('TitleWeight')?>; 
	}
	.text 
	{ 
		font-family:<?=setting('TextFont')?>;
		font-size:<?=setting('TextSize')?>px;
		color:<?=setting('TextColor')?>; 
		font-weight: <?=setting('TextWeight')?>; 
	}	
	.subtitle 
	{ 
		font-family:<?=setting('SubTitleFont')?>;
		font-size:<?=setting('SubTitleSize')?>px;
		color:<?=setting('SubTitleColor')?>; 
		font-weight: <?=setting('SubTitleWeight')?>; 
	}	
	a.subtitle 
	{ 
		font-family:<?=setting('SubTitleFont')?>;
		font-size:<?=setting('SubTitleSize')?>px;
		color:<?=setting('SubTitleColor')?>; 
		font-weight: <?=setting('SubTitleWeight')?>; 
	}	
	a.subtitle:hover 
	{ 
		font-family:<?=setting('SubTitleFont')?>;
		font-size:<?=setting('SubTitleSize')?>px;
		color:<?=setting('SubTitleColor')?>; 
		font-weight: <?=setting('SubTitleWeight')?>; 
	}	
	.boxtitle 
	{ 
		font-family:<?=setting('BoxHeaderFont')?>;
		font-size:<?=setting('BoxHeaderSize')?>px;
		color:<?=setting('BoxHeaderColor')?>; 
		font-weight: <?=setting('BoxHeaderWeight')?>;
		font-style:<?=setting('BoxHeaderStyle')?>;
	}
</style>
</head>
<body topmargin=0 leftmargin=0 marginheight=0 marginwidth=0 > 
<div align="center">
<? 
	$PageHeaderHTML = getValue(setting('PageHeaderHTML'));
	$PageHeaderImage = setting('PageHeaderImage');
    $PageFooterHTML = getValue(setting('PageFooterHTML'));
	$PageFooterImage = setting('PageFooterImage');
	$Column1HeaderImage = setting('Column1HeaderImage');
	$Column2HeaderImage = setting('Column2HeaderImage');
	$Column3HeaderImage = setting('Column3HeaderImage');
	$Column1FooterImage = setting('Column1HeaderImage'); 
	$Column2FooterImage = setting('Column2HeaderImage'); 
	$Column3FooterImage = setting('Column3HeaderImage');
	$Column1HeaderColor = setting('Column1HeaderColor');
	$Column1FooterColor = setting('Column1FooterColor');
	$Column2HeaderColor = setting('Column2HeaderColor');
	$Column2FooterColor = setting('Column2FooterColor');
	$Column3HeaderColor = setting('Column3HeaderColor');
	$Column3FooterColor = setting('Column3FooterColor');
	$MainTableBackgroundImage = setting('MainTableBackgroundImage');
	$MainTableBackgroundColor = setting('MainTableBackgroundColor');
?>
<? 
	if(!empty($Column1HeaderImage)) {$Column1Header = ' background="'.setting('urlfiles').setting('Column1HeaderImage').'"';}
	else{$Column1Header = ' bgcolor="'.setting('Column1HeaderColor').'"';}
	if(!empty($Column1FooterImage)) {$Column1Footer = ' background="'.setting('urlfiles').setting('Column1FooterImage').'"';}
	else{$Column1Footer = ' bgcolor="'.setting('Column1FooterColor').'"';}

	if(!empty($Column2HeaderImage)) {$Column2Header = ' background="'.setting('urlfiles').setting('Column2HeaderImage').'"';}
	else{$Column2Header = ' bgcolor="'.setting('Column2HeaderColor').'"';}
	if(!empty($Column2FooterImage)) {$Column2Footer = ' background="'.setting('urlfiles').setting('Column2FooterImage').'"';}
	else{$Column2Footer = ' bgcolor="'.setting('Column2FooterColor').'"';}
	
	if(!empty($Column3HeaderImage)) {$Column3Header = ' background="'.setting('urlfiles').setting('Column3HeaderImage').'"';}
	else{$Column3Header = ' bgcolor="'.setting('Column3HeaderColor').'"';}
	if(!empty($Column3FooterImage)) {$Column3Footer = ' background="'.setting('urlfiles').setting('Column3FooterImage').'"';}
	else{$Column3Footer = ' bgcolor="'.setting('Column3FooterColor').'"';}

	if(setting('Column1BackgroundImage')) {$Column1Background = ' background="'.setting('urlfiles').setting('Column1BackgroundImage').'"';}
	else{$Column1Background = ' bgcolor="'.setting('Column1BackgroundColor').'"';}

	if(setting('Column2BackgroundImage')) {$Column2Background = ' background="'.setting('urlfiles').setting('Column2BackgroundImage').'"';}
	else{$Column2Background = ' bgcolor="'.setting('Column2BackgroundColor').'"';}

	if(setting('Column3BackgroundImage')) {$Column3Background = ' background="'.setting('urlfiles').setting('Column3BackgroundImage').'"';}
	else{$Column3Background = ' bgcolor="'.setting('Column3BackgroundColor').'"';}

?>
<? if(!empty($MainTableBackgroundImage)){ ?>
<table width="<?=setting('MainTableWidth')?>" border="0" cellspacing="0" cellpadding="0" background="<?=setting('urlfiles').$MainTableBackgroundImage?>">
<? } else { ?>
<table width="<?=setting('MainTableWidth')?>" border="0" cellspacing="0" cellpadding="0" bgcolor="<?=$MainTableBackgroundColor?>">
<? } ?>
	<? if(getValue(setting('PageHeaderHTML'))) { ?>
	 <tr align="center" valign="top">
		<td colspan="5" align="center" valign="top">
			<?=getFormated(setting('PageHeaderHTML'),'HTML')?>
		</td>
	</tr>			
	<? } else { ?>
	 <tr align="center" valign="top">
		<td colspan="5" align="center" valign="top">
			<a href="<?=setting('url')?>home/"><img src="<?=setting('urlfiles')?><?=setting('SiteLogo')?>" border="0"/></a>
		</td>
	</tr>	
	<? } ?>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">{SystemMessages}</td>
	</tr>	
	<tr>
		<td width="<?=setting('Column1Width')?>" align="center" valign="top" <?=$Column1Background?> >
			<!-- START LEFT COLUMN -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td align="center" valign="top" bgcolor="<?=setting('ColumnBorderColor')?>">
				<table width="100%"  border="0" cellspacing="1" cellpadding="3">
				  <tr>
					<form name="getResources" method="post">
						<td height="40" align="center" valign="middle" <?=$Column1Header?> class="columntitle">&nbsp;</td>
					</form>				
				  </tr>
					<?=getBoxes('left')?>	
					<tr>
						<td height="20" <?=$Column1Footer?> >&nbsp;</td>
					</tr>				  
				</table>
				</td>
			  </tr>
			</table>			
			<!-- END LEFT COLUMN -->
		</td>
		<td width="<?=setting('Gap1Width')?>"><img src="<?=setting('layout')?>images/pixel.gif" width="<?=setting('Gap1Width')?>"/></td>
		<td width="<?=setting('Column2Width')*2 + setting('Gap1Width')?>" align="left" valign="top" <?=$Column2Background?> >
			<!-- START CENTER COLUMN -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td align="center" valign="top" bgcolor="<?=setting('ColumnBorderColor')?>">
				<table width="100%"  border="0" cellspacing="1" cellpadding="3">
				  <tr>
					<form name="centerHeaderForm" method="post">
						<td height="40" align="center" valign="middle" <?=$Column2Header?> class="columntitle">&nbsp;</td>
					</form>				
				  </tr>
				  	<? getBox('help.getHelpTipBox')?>
					<?=getBoxes('center')?>					
					<tr>
						<td height="20" <?=$Column2Footer?> >&nbsp;</td>
					</tr>				  
				</table>
				</td>
			  </tr>
			</table>				
			<!-- END CENTER COLUMN -->		
		</td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr align="center" valign="bottom">
		<td colspan="5" align="center" valign="bottom">
			<? if(!empty($PageFooterHTML)){?>
				<?=getFormated($PageFooterHTML,'HTML')?>
			<? }elseif(!empty($PageFooterImage)){?>
				<img src="<?=setting('urlfiles')?><?=setting('PageFooterImage')?>" border="0"/>
			<? }?>		
		</td>
	</tr>
</table>	
</div> 
</body>
</html>
