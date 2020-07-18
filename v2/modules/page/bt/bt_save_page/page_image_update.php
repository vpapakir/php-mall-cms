<?php
for($i = 0, $count = count($idimage_saving_page); $i <= $count; $i++)
{
    $prepared_query = 'UPDATE page_image
                       SET name_image = :name,
                           alt_image = :alt,
                           position_image = :position
                       WHERE id_image = :id';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'name' => $arrayimage_name_pagecontent[$i],
                          'alt' => $arrayimage_alt_pagecontent[$i],
                          'position' => $arrayimage_position_pagecontent[$i],
                          'id' => $idimage_saving_page[$i]
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
                              'translation' => $arrayimage_title_pagecontent[$i][$y],
                              'id' => $idimage_saving_page[$i]
                              ));
        $query->closeCursor();
    }
}
?>
