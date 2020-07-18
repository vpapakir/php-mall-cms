<?php
$prepared_query = 'DELETE FROM style_color
                   WHERE id_color = :id';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('id', $color_id);
$query->execute();
$query->closeCursor();

reallocate_table_id('id_color', 'style_color');

$msg_done_color_delete = str_replace('[#name_color]', $color_name[$color_selected_lang], $msg_done_color_delete);
$_SESSION['msg_color_done'] = $msg_done_color_delete;
?>
