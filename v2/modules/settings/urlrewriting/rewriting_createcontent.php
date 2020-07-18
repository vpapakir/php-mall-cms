<?php
$content_rewritingurl = null;
$content_rewritingurl = 'AuthName "fp-distribution.com - Identification Page"'."\n";
$content_rewritingurl .= 'AuthType Basic'."\n";
$content_rewritingurl .= 'AuthUserFile "/var/www/fp-distribution/.htpasswd'."\n";
$content_rewritingurl .= 'Require valid-user'."\n";
$content_rewritingurl .= "\n";
$content_rewritingurl .= 'AddType text/x-component .htc'."\n";
$content_rewritingurl .= "\n";
$content_rewritingurl .= '# Follow symbolic links :'."\n";
$content_rewritingurl .= 'Options +FollowSymlinks'."\n";
$content_rewritingurl .= "\n";
$content_rewritingurl .= '# URL Rewriting is activated :'."\n";
$content_rewritingurl .= 'RewriteEngine On'."\n";
$content_rewritingurl .= "\n";

for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $content_rewritingurl .= '# '.$main_activatedcodelang[$i]."\n\n";
    $content_rewritingurl .= 'RewriteRule ^'.strtolower($main_activatedcodelang[$i]).'/$   '.'index.php?page=home_frontend&lang='.$main_activatedidlang[$i].' [L]'."\n";
    $content_rewritingurl .= 'RewriteRule ^'.strtolower($main_activatedcodelang[$i]).'/$   '.'index_backoffice.php?page=home_backoffice&lang='.$main_activatedidlang[$i].' [L]'."\n";
    $content_rewritingurl .= 'RewriteRule ^'.strtolower($main_activatedcodelang[$i]).'$   '.'index.php?page=home_frontend&lang='.$main_activatedidlang[$i].' [L]'."\n";
    $content_rewritingurl .= 'RewriteRule ^'.strtolower($main_activatedcodelang[$i]).'$   '.'index_backoffice.php?page=home_backoffice&lang='.$main_activatedidlang[$i].' [L]'."\n\n";
    
    for($x = 0, $countx = count($pagename_rewritingurl[$i]); $x < $countx; $x++)
    {
        $content_rewritingurl .= '# '.$pagename_rewritingurl[$i][$x]."\n";
        $content_rewritingurl .= 'RewriteRule ^'.$pagefrontend_rewritingurl[$i][$x].'$   '.'index.php?page='.$pageurl_rewritingurl[$i][$x].' [L]'."\n";
        $content_rewritingurl .= 'RewriteRule ^'.$pagebackoffice_rewritingurl[$i][$x].'$   '.'index_backoffice.php?page='.$pageurl_rewritingurl[$i][$x].' [L]'."\n";
//        $content_rewritingurl .= 'RewriteRule ^'.strtolower($main_activatedcodelang[$i]).'/'.$pagefrontend_rewritingurl[$i][$x].'$   '.'index.php?page='.$pageurl_rewritingurl[$i][$x].'&lang='.$main_activatedidlang[$i].' [L]'."\n";
//        $content_rewritingurl .= 'RewriteRule ^'.strtolower($main_activatedcodelang[$i]).'/'.$pagebackoffice_rewritingurl[$i][$x].'$   '.'index_backoffice.php?page='.$pageurl_rewritingurl[$i][$x].'&lang='.$main_activatedidlang[$i].' [L]'."\n";
        $content_rewritingurl .= "\n";
    }
}

$content_rewritingurl .= 'RewriteRule ^Gestion/Sitemap/([0-9]+)$   /index.php?page=sitemap&levelx=$1 [L]'."\n";
$content_rewritingurl .= 'RewriteRule ^Backoffice/Gestion/Sitemap/([0-9]+)$   /index_backoffice.php?page=sitemap&levelx=$1 [L]'."\n\n";

$content_rewritingurl .= 'RewriteRule ^Gestion/Traductions/([0-9]+)$   /index.php?page=edit_translation&trans=$1 [L]'."\n";
$content_rewritingurl .= 'RewriteRule ^Backoffice/Gestion/Traductions/([0-9]+)$   /index_backoffice.php?page=edit_translation&trans=$1 [L]'."\n\n";

$content_rewritingurl .= 'RewriteRule ^edition/product/([0-9]+)$   /index.php?page=edit_product&product=$1 [L]'."\n";
$content_rewritingurl .= 'RewriteRule ^backoffice/edition/product/([0-9]+)$   /index_backoffice.php?page=edit_product&product=$1 [L]'."\n\n";

$content_rewritingurl .= 'RewriteRule ^edition/page/([0-9]+)$   /index.php?page=page_edit&pg=$1 [L]'."\n";
$content_rewritingurl .= 'RewriteRule ^backoffice/edition/page/([0-9]+)$   /index_backoffice.php?page=page_edit&pg=$1 [L]'."\n\n";

$content_rewritingurl .= 'RewriteRule ^sale/page/([0-9]+)$   /index.php?page=imos_rent_main&paging=$2 [L]'."\n";
$content_rewritingurl .= 'RewriteRule ^backoffice/sale/page/([0-9]+)$   /index_backoffice.php?page=imos_rent_main&paging=$2 [L]'."\n\n";

$content_rewritingurl .= 'RewriteRule ^edition/user/([0-9]+)$   /index.php?page=user_edit&user=$1 [L]'."\n";
$content_rewritingurl .= 'RewriteRule ^backoffice/edition/user/([0-9]+)$   /index_backoffice.php?page=user_edit&user=$1 [L]'."\n\n";

//$content_rewritingurl .= 'ErrorDocument 404 http://immo-sologne.com/Error/404'."\n";
$content_rewritingurl .= 'RewriteBase /'."\n";
$content_rewritingurl .= 'RewriteCond %{HTTP_HOST} !^'.str_replace("http:","",str_replace(".","\.",str_replace("/","",$myUrl1))).' [NC]'."\n";
$content_rewritingurl .= 'RewriteRule ^(.*)$ '.$myUrl1.'$1 [R=301,L]';
?>