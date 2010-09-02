/**
 * Initialize editor mode
 */
function editorInit() {
    // Verify if the user is logged in
    $.get(baseURL + 'ferritecms/ajax/verifyUser.php', function(data) {
        if (data) {
            $('.ferritecms_editlink').html('Leave editor mode')
                .addClass('ferritecms_leaveeditor');
                
            contentToTextarea();
            titleToTextField();
            
            newPage();
            editPageInfo();
        }
    });
    
    return false;
}

function leaveEditorMode() {
    // Revert content textarea
    $('.ferritecms_content').load(
        baseURL + 'ferritecms/ajax/getPage.php?type=content&id=' + pageID)
        .removeClass('ferritecms_editing');
    
    // Revert title field
    $('.ferritecms_title').load(
        baseURL + 'ferritecms/ajax/getPage.php?type=title&id=' + pageID)
        .removeClass('ferritecms_editing');
    
    // Hide new page links
    $('.ferritecms_newpage').hide();
    
    // Get rid of edit page links
    $('.ferritecms_nav li').not('.ferritecms_newlink').each(function() {
        $(this).css('width', $(this).width() - $('.ferritecms_editpage').width());
        $(this).find('.ferritecms_editpage').remove();
    });
    
    // Get rid of all dialogs
    $('.ferritecms_dialog').remove();
    
    // Log the user out and delete the cookie
    if ($.cookie('fcms_admin')) {
        $.cookie('fcms_admin', null, { 'path': basePath });
    }
    
    $('.ferritecms_editlink').html(editLinkText)
        .removeClass('ferritecms_leaveeditor');
}