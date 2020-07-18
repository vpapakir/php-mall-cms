<?=boxHeader(array('titile'=>'Backup control'))?>
<tr>
<td>
<table width="100%" align="center" border="0">
<tr>
<td align="center">
    <form method="post" name="selectBackupType">
    <input type="hidden" name="SID" value="generateBackupLog" />
    <input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
    <input type="hidden" name="actionMode" value="" />


    <input type="button" name="fullBackupButton" value="<?=lang('FullBackup.core.button')?>" onClick="document.selectBackupType.actionMode.value='full'; submit()" />
    <input type="button" name="baseBackupButton" value="<?=lang('DataBaseBackup.core.button')?>" onClick="document.selectBackupType.actionMode.value='db'; submit()" />
    </form>
</td>
</tr>
</table>
<?getBox('core.displayBackupList')?>
<?getBox('core.displayBackupDownloadList')?>
<?=boxFooter();?>