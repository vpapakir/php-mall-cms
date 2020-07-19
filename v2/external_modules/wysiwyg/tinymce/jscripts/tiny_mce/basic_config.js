var meta = document.getElementsByTagName('meta'); 
var selected_lang = meta[9].content;
if(selected_lang == undefined)
{
    selected_lang = 'en';
}

var sitename_browserpath = 'http://immo-sologne.com/external_modules/filemanage';

function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file: sitename_browserpath + '/kcfinder/browse.php?opener=tinymce&type=' + type,
        title: 'KCFinder',
        width: 700,
        height: 500,
        resizable: "yes",
        inline: true,
        close_previous: "no",
        popup_css: false
    }, {
        window: win,
        input: field_name
    });
    return false;
}

tinyMCE.init({
    file_browser_callback: 'openKCFinder',
    content_css : "../modules/css/main.css",
    theme : "advanced",
    plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
    mode : "specific_textareas",
    editor_selector : "tinyMCE_editor",
    language : selected_lang,
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,fontselect,fontsizeselect,|,fullscreen",                    
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,replace,|,bullist,numlist,|,undo,redo,|,outdent,indent,blockquote,|,forecolor,backcolor,|,charmap,|,link,unlink,anchor",
    theme_advanced_buttons3 : "image,media,cleanup,help,code,|,insertdate,inserttime,preview,|,advhr,|,styleprops,|,attribs,|,nonbreaking,|,sup",
    theme_advanced_buttons4 : "tablecontrols,|,removeformat,visualaid",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,

    style_formats : [
        {title : 'Texte', inline : 'span', classes : 'font_main'},
        {title : 'Sous-titre', inline : 'span', classes : 'font_subtitle'},
        {title : 'Titre', inline : 'span', classes : 'font_title'},
        {title : 'Introduction', inline : 'span', classes : 'font_intro'},
        {title : 'Description', inline : 'span', classes : 'font_desc'},
        {title : 'Commentaire', inline : 'span', classes : 'font_comment'}
    ]

});




