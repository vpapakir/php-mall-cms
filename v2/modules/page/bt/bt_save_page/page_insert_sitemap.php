<?php
$id_hierarchybox_pageproperty = trim(htmlspecialchars($_POST['cboPageSitemap'], ENT_QUOTES));

if($id_hierarchybox_pageproperty != 'no')
{
    $prepared_query = 'INSERT INTO hierarchy_box_content
                       (reference_hierarchy_box_content, code_hierarchy_box_content,
                        status_hierarchy_box_content, id_hierarchy_box,
                        id_parent_hierarchy_box_content, level_hierarchy_box_content,
                        type_hierarchy_box_content, menutitle_hierarchy_box_content,
                        position_hierarchy_box_content, typelink_hierarchy_box_content,
                        link_hierarchy_box_content, target_hierarchy_box_content,
                        margin_hierarchy_box_content, align_hierarchy_box_content, ';
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        if($i == ($count - 1))
        {
            $prepared_query .= 'L'.$main_activatedidlang[$i].')';
        }
        else
        {
            $prepared_query .= 'L'.$main_activatedidlang[$i].', ';
        }
    }
    
    $prepared_query .= 'VALUES
                       (:reference, :code, :status, :id_hierarchybox, :parent,
                        :level, :type, :menutitle, :position, :typelink,
                        :link, :target, :margin, :align, ';
    
    for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
    {
        if($i == ($count - 1))
        {
            $prepared_query .= '"'.$code_pageproperty.'")';
        }
        else
        {
            $prepared_query .= '"'.$code_pageproperty.'", ';
        }
    }
    
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'reference' => 9999,
                          'code' => '9999$9999',
                          'status' => 1,
                          'id_hierarchybox' => $id_hierarchybox_pageproperty,
                          'parent' => 0,
                          'level' => 0,
                          'type' => 'link_main',
                          'menutitle' => null,
                          'position' => 9999,
                          'typelink' => 'page',
                          'link' => $last_insert_idpage,
                          'target' => '_self',
                          'margin' => '0$0$0$0',
                          'align' => 'left',
                          ));
    $query->closeCursor();
}
?>
