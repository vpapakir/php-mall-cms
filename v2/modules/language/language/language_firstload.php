<?php
if(empty($_SESSION['language_firstload']))
{
    $_SESSION['language_create_new'] = true;
    $_SESSION['language_firstload'] = 'notempty';
}
?>
