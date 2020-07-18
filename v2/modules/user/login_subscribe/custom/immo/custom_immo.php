<?php
if(!empty($_SESSION['msg_portfolioadd_needlogin'])) #custom immo
{
?>
    <tr>
        <td align="left">
            <table width="100%" class="block_msg1">
                <tr>
                    <td align="center">
                        <span><?php echo($_SESSION['msg_portfolioadd_needlogin']); ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
}
?>
