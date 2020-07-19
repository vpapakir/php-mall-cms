<?php
if(isset($_GET['pdf']))
{
    if($_GET['pdf'] == 'true')
    {
        $content = 
        '<page>
            <div>
                <div>

                    <table width="100%" cellpaddin="0" cellspacing="0" border="0">

                    
                    <tr>
                    <td colspan="2" align="center">
                        Maison de village entre Ivoy-le-Pré et Bourges
                    </td>
                    </tr>

                    <tr style="height: 8px;">

                        <td><table width="100%" cellspacing="1" cellpadding="0">
                                <td>
                                    <img style="border: 1px solid lightgrey;" src="./modules/custom/immo/image/Brusseau.jpg" alt="Photo" width="180">
                                </td>
                                <tr></tr>
                                <td>
                                    <img style="border: 1px solid lightgrey;" src="./modules/custom/immo/image/Brusseau002.jpg" alt="Photo" width="180">
                                </td>
                                <tr></tr>
                                <td>
                                    <img style="border: 1px solid lightgrey;" src="./modules/custom/immo/image/Brusseau003.jpg" alt="Photo" width="180">
                                </td>
                                <tr></tr>
                                <td>
                                    <img style="border: 1px solid lightgrey;" src="./modules/custom/immo/image/Brusseau004.jpg" alt="Photo" width="180">
                                </td>
                                <tr></tr>
                                <td>
                                    <img style="border: 1px solid lightgrey;" src="./modules/custom/immo/image/Brusseau005.jpg" alt="Photo" width="180">
                                </td>
                                <tr></tr>
                                <td>
                                    <img style="border: 1px solid lightgrey;" src="./modules/custom/immo/image/Brusseau006.jpg" alt="Photo" width="180">
                                </td>
                        </table></td>
                    
                    </tr>
                    
                    </table>

                </div>
            </div>
        </page>';

        require_once('external_modules/html2pdf/html2pdf.class.php');
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->WriteHTML($content);
        $html2pdf->Output('exemple.pdf');
    }
}
?>
