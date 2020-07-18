<?php
for($k = 0, $countk = count($idimage_saving_product); $k < $countk; $k++)
{
    $prepared_query = 'UPDATE page_image
                       SET name_image = :name,
                           alt_image = :alt,
                           position_image = :position
                       WHERE id_image = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'name' => $arrayimage_name_productcontent[$k],
                          'alt' => $arrayimage_alt_productcontent[$k],
                          'position' => $arrayimage_position_productcontent[$k],
                          'id' => $idimage_saving_product[$k]
                          ));
    $query->closeCursor();
    
    for($y = 0, $county = count($main_activatedidlang); $y < $county; $y++)
    {
        $prepared_query = 'UPDATE page_image
                           SET L'.$main_activatedidlang[$y].' = :translation
                           WHERE id_image = :id';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $query = $connectData->prepare($prepared_query);
        $query->execute(array(
                              'translation' => $arrayimage_title_productcontent[$k][$y],
                              'id' => $idimage_saving_product[$k]
                              ));
        $query->closeCursor();
    }
}
?>
