<?php
if(empty($_SESSION['language_switch_firstload']))
{
    $_SESSION['language_switch_firstload'] = 'notempty';
    try
    {
       $prepared_query = 'SELECT id_language FROM language
                          WHERE priority_language = 1';
       $query = $connectData->prepare($prepared_query);
       $query->execute();
       
       if(($data = $query->fetch()) != false)
       {
			if( isset($_COOKIE["language"]) ) {
				$main_id_language = $_COOKIE["language"];
			} else {
				$main_id_language = $data[0];
				setcookie( 'language', $main_id_language, time() + 3600,'/' );
			}
       }
    }
    catch(Exception $e)
    {
        $_SESSION['error400_message'] = $e->getMessage();
        if($_SESSION['index'] == 'index.php')
        {
            die(header('Location: '.$config_customheader.'Error/400'));
        }
        else
        {
            die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
        }
    }
    #
    $_SESSION['current_language'] = $main_id_language;
}

if(isset($_GET['lang']))
{
    #
	//$pageeee = $_SESSION['current_page'];
    $main_id_language = trim(htmlspecialchars($_GET['lang'], ENT_QUOTES));
    $_SESSION['current_language'] = $main_id_language;
	if( isset($_COOKIE["language"]) ) {
		setcookie( 'language', $_COOKIE["language"], time() - 3600,'/' );
		setcookie( 'language', $main_id_language, time() + 1800,'/' );
	}
    //$sec = "0";
    //header("Refresh: $sec; url=$pageeee");
}

try
{
    $prepared_query = 'SELECT * FROM language
                       WHERE status_language = 1
                       ORDER BY priority_language DESC, position_language';
    //if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    $i = 0;
    while($data = $query->fetch())
    {
        $main_activatedidlang[$i] = $data[0];
        $main_activatedcodelang[$i] = $data['code_language'];
        $i++;
    }
    $query->closeCursor();
}
catch(Exception $e)
{
    $_SESSION['error400_message'] = $e->getMessage();
    if($_SESSION['index'] == 'index.php')
    {
        die(header('Location: '.$config_customheader.'Error/400'));
    }
    else
    {
        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
    }
}
?>
