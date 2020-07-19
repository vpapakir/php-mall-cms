<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
        <tr>
            <td width="80%">
                <input style="width: 100%;" type="text" name="txtTranslationSearch" value="<?php if(!empty($_SESSION['translation_search_txtTranslationSearch_1'])){ echo($_SESSION['translation_search_txtTranslationSearch_1']); } ?>"></input>
                
            </td>   
            <td align="right">
                <input type="submit" name="bt_translation_search" value="<?php give_translation('main.bt_search'); ?>"></input>
            </td>
        </tr>
    </table></td>
</tr>
