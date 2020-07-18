<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left" width="100%">
                    <input style="width: 99%;" type="text" name="txtSearchUserEdit" value="<?php if(!empty($_SESSION['useredit_search_keyword'])){ echo($_SESSION['useredit_search_keyword']); } ?>"/>                    
                </td>
                <td align="left">
                    <input type="submit" name="bt_search_useredit" value="<?php give_translation('main.bt_search', $echo, $config_showtranslationcode); ?>"/>
                </td>
            </tr>
        </table>
    </td>
</tr>
