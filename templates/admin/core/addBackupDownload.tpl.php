<SCRIPT language=JavaScript>
    //window.location.href = '<?=$out[0]["BackupPath"]?><?=$out[0]["BackupFileName"]?>';
    //window.location.href = 'http://www.selteq.com/ABT/coomall/adm/generateBackupLog';
    //open('http://www.selteq.com/ABT/coomall/backup_13_04.tar.gz','test');
    open('<?=$out[0]["BackupPath"]?><?=$out[0]["BackupFileName"]?>','Download');

</SCRIPT>
