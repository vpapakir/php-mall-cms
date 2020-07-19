<?php
$prepared_query = 'INSERT INTO rewriting_url
                   (content_rewriting_url, date_rewriting_url)
                   VALUES
                   (:content, NOW())';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->bindParam('content', $content_rewritingurl);
$query->execute();
$query->closeCursor();
?>
