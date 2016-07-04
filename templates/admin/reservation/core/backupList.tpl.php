<?=boxHeader(array('title'=>lang('backupListBackup.core.title')));?>
<tr>
<td>
<?//print_r($out)?>
<?if (!empty($input['downloadItem'])) {?>
<? //echo $out['Download'][0]['BackupPath'].$out['Download'][0]['BackupFileName'];?>
<SCRIPT language=JavaScript>
    open('<?=$out['Download'][0]['BackupPath']?><?=$out['Download'][0]['BackupFileName']?>','Download');
    //window.location = '<?=$out['Download'][0]['BackupPath']?><?=$out['Download'][0]['BackupFileName']?>';
</SCRIPT>
<?}?>
<table width="100%" align="center" border="0">
<tr>
<td align="center">
<table width="100%" border="0">
<tr>
<td align="center">
<b><?=lang('timeBackupBackupLog.core.title')?></b>
</td>
<td  align="center">
<b><?=lang('typeBackupBackupLog.core.title')?></b>
</td>
<td  align="center">
<b><?=lang('fileNameBackupBackupLog.core.title')?></b>
</td>
<td  align="center">
<b><?=lang('downloadBackupBackupLog.core.title')?></b>
</td>
<td  align="center">
<b><?=lang('fileSizeBackupBackupLog.core.title')?></b>
</td>
</tr>
<?$grayColor = TRUE; if (!empty($out['BackupLog'])){
 foreach ($out['BackupLog'] as $id=>$row){?>
<tr>
<?if ($grayColor == TRUE) { ?>
<td bgcolor="#F0F0E3">
<?} else {?>
<td>
<?}?>
<?=getFormated($row['TimeCreated'], "DateTime");?>
</td>
<?if ($grayColor == TRUE) { ?>
<td bgcolor="#F0F0E3">
<?} else {?>
<td>
<?}?>
<?=$row['BackupType']?>
</td>
<?if ($grayColor == TRUE) { ?>
<td bgcolor="#F0F0E3">
<?} else {?>
<td>
<?}?>
<?=$row['BackupPath']?><?=$row['BackupFileName']?>
</td>
<?if ($grayColor == TRUE) { ?>
<td bgcolor="#F0F0E3">
<?} else {?>
<td>
<?}?>
<a href="<?=setting('url')?>generateBackupLog--downloadItem--<?=$row['BackupLogID']?>"><?=lang('download.link')?></a>
</td>
<?if ($grayColor == TRUE) { ?>
<td bgcolor="#F0F0E3">
<?} else {?>
<td>
<?}?>
<?=round($row['BackupLogFileSize']/1000000, 3)?> <?=lang('MB_Backup.core.title')?>
</td>
<td>
</tr>
<? if ($grayColor == TRUE) {$grayColor = FALSE;} else {$grayColor = TRUE;} } }?>
</table>
</td>
</tr>
</table>

<?//getBox('core.displayBackupDownloadList')?>
<?=boxFooter();?>