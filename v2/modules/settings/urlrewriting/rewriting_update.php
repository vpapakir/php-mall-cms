<?php
$prepared_query = 'UPDATE rewriting_url
                   SET content_rewriting_url = :content,
                       date_rewriting_url = NOW()
                   WHERE id_rewriting_url = :id';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('content', $content_rewritingurl);
$query->execute(array(
                      'content' => $content_rewritingurl,
                      'id' => $lastid_rewritingurl
                      ));
$query->closeCursor();
?>
