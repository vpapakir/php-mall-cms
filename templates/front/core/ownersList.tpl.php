<form name="selectGroup" method="post">
<input type="hidden" name="SID" value="<?=input('SID')?>" />
<?=getLists($out['DB']['Owners'],$out['Vars']['GroupID'],array('name'=>'GroupID','id'=>'OwnerCode','value'=>'OwnerName','action'=>'submit();'))?>
</form>