<?=boxHeader(array('title'=>lang('backupListBackupDownload.core.title')))?>
<tr>
<td>
<? if (!empty($out)){?>
<table width="100%" align="center" border="0">
<tr>
<td align="center">
<table width="100%" border="0">
<tr>
<td align="center">
<b><?=lang('timeBackupDownloadLog.core.title')?></b>
</td>
<td  align="center">
<b><?=lang('fileNameBackupDownloadLog.core.title')?></b>
</td>
<td  align="center">
<b><?=lang('fileSizeBackupDownload.core.title')?></b>
</td>
</tr>
<?
if (is_array($out)){
$grayColor = TRUE; 
foreach ($out as $id=>$row){?>
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
<?=$row['BackupDownloadFileName']?>
</td>
<?if ($grayColor == TRUE) { ?>
<td bgcolor="#F0F0E3">
<?} else {?>
<td>
<?}?>
<?=round($row['BackupDownloadFileSize']/1000000, 3)?> <?=lang('MB_Backup.core.title')?>
</td>
</tr>
<?if ($grayColor == TRUE) {$grayColor = FALSE;} else {$grayColor = TRUE;}  }}?>
</table>
</td>
</tr>
</table>
<?}?>
<?=boxFooter()?>