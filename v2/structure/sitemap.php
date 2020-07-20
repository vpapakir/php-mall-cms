<?php
unset($idbox_hierarchybox, $id_hierarchybox);

$prepared_query = 'SELECT * FROM `hierarchy_box` 
                   WHERE id_frame = :frame 
                   AND status_hierarchy_box = 1';
/*if(empty($config_module_immo) || $config_module_immo == 9)
{
    $prepared_query .= ' AND family_hierarchy_box = "main"';
}
else
{
    $prepared_query .= ' AND (family_hierarchy_box = "main"';
    
    if(!empty($config_module_immo) && $config_module_immo == 1)
    {
       $prepared_query .= ' OR family_hierarchy_box = "immo"';
    }
    
    $prepared_query .= ')';
}*/
$prepared_query .= ' ORDER BY position_hierarchy_box';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('frame', $sitemap_id_frame);
$query->execute();
$i = 0;

while($data = $query->fetch())
{
    $id_hierarchybox[$i] = $data[0];
    $idbox_hierarchybox[$i] = $data['id_box'];
    $title_hierarchybox[$i] = $data['L'.$main_id_language];
    $userrights_hierarchybox[$i] = $data['userrights_hierarchy_box'];
    $titlemargin_hierarchybox[$i] = $data['titlemargin_hierarchy_box'];
    $temp_titlemargin_hierarchybox = split_string($titlemargin_hierarchybox[$i], '$');
    $titlemargin_hierarchybox[$i] = $temp_titlemargin_hierarchybox[0].'px '.$temp_titlemargin_hierarchybox[1].'px '.$temp_titlemargin_hierarchybox[2].'px '.$temp_titlemargin_hierarchybox[3].'px';
    $titlealign_hierarchybox[$i] = $data['titlealign_hierarchy_box'];
    $i++;
}
$query->closeCursor();


?>
