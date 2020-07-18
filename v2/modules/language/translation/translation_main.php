<?php
include('modules/language/translation/translation_count.php');
include('modules/language/translation/search/bt_search/bt_translation_search.php');

#translation edit
include('modules/language/translation/bt_translation/bt_modifyprevious_translation_edit.php');
include('modules/language/translation/bt_translation/bt_modifynextempty_translation_edit.php');
include('modules/language/translation/bt_translation/bt_new_translation_edit.php');
include('modules/language/translation/bt_translation/bt_add_edit_translation.php');
?>
<div class="highslide-body" id="translation_main"><form action="" method="post"><table width="100%">
<?php
    if(!empty($_SESSION['msg_translation_edit_modify_done']))
    {
?>
        <tr>
            <td align="left">
                <table width="100%" class="block_msg1">
                    <tr>
                        <td align="center">
                            <span><?php echo($_SESSION['msg_translation_edit_modify_done']); ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
<?php
    }

    include('modules/language/translation/search/search_skeleton.php');
    include('modules/language/translation/content/translation_language.php');
    include('modules/language/translation/msg/translation_msg.php');
    
    if((isset($_GET['trans']) || empty($_SESSION['translation_search_done']) || $_SESSION['translation_search_done'] === false) && !isset($_POST['bt_translation_search']))
    {
        $_SESSION['translation_search_done'] = false;
        include('modules/language/translation/translation_edit.php');
    }
    
    if(!empty($_SESSION['translation_search_done']) && $_SESSION['translation_search_done'] === true)
    {
        include('modules/language/translation/translation_listing.php');
    }        
?>            
    
            
</table></form></div>