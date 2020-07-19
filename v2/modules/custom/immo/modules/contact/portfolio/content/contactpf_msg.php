<tr>
    <td colspan="2"><table class="block_main2">   
        <tr>
            <td align="left" colspan="2">
                <textarea style="width: 99%;" name="areaRequestPortfolioMsg" rows="5"><?php if(empty($_SESSION['form_visit_areaRequestPortfolioMsg'])){ give_translation('contact_portfolio.textarea_myrequest_default', $echo, $config_showtranslationcode); echo(':&nbsp;'); }else{ echo($_SESSION['form_visit_areaRequestPortfolioMsg']); } ?></textarea>
            </td>
        </tr>
    </table></td>
</tr>
