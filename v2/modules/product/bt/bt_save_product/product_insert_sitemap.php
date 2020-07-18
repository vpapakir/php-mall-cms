<?php
$id_hierarchybox_productproperty = trim(htmlspecialchars($_POST['cboProductSitemap'], ENT_QUOTES));

if($id_hierarchybox_productproperty != 'no')
{
    $prepared_query = 'INSERT INTO hierarchy_box_content
                       (reference_hierarchy_box_content, code_hierarchy_box_content,
                        status_hierarchy_box_content, id_hierarchy_box,
                        id_parent_hierarchy_box_content, level_hierarchy_box_content,
                        type_hierarchy_box_content, menutitle_hierarchy_box_content,
                        position_hierarchy_box_content, typelink_hierarchy_box_content,
                        link_hierarchy_box_content, target_hierarchy_box_content,
                        margin_hierarchy_box_content, align_hierarchy_box_content)
                       VALUES
                       (:reference, :code, :status, :id_hierarchybox, :parent,
                        :level, :type, :menutitle, :position, :typelink,
                        :link, :target, :margin, :align)';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'reference' => 9999,
                          'code' => '9999$9999',
                          'status' => 1,
                          'id_hierarchybox' => $id_hierarchybox_productproperty,
                          'parent' => 0,
                          'level' => 0,
                          'type' => 'link_main',
                          'menutitle' => $code_productproperty,
                          'position' => 9999,
                          'typelink' => 'page',
                          'link' => $last_insert_idproduct,
                          'target' => '_self',
                          'margin' => '0$0$0$0',
                          'align' => 'left'
                          ));
    $query->closeCursor();
}
?>
