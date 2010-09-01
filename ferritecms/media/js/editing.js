function contentToTextarea() {
    $('.ferritecms_content').load(
        baseURL + '/ferritecms/ajax/editPage.php?type=content&id=' + pageID, function() {
            $('#ferritecms_contentform').submit(function() {
                $.post(baseURL + 'ferritecms/ajax/updatePage.php', {
                    'id': pageID,
                    'update': 'content',
                    'content': $('#ferritecms_contentfield').val()
                }, function(data) {
                    // TODO: find a better way of displaying success/failure
                    alert(data);
                });
                
                return false;
            });
        })
        .addClass('ferritecms_editing');
}

function titleToTextField() {
    $('.ferritecms_title').load(
        baseURL + 'ferritecms/ajax/editPage.php?type=title&id=' + pageID, function() {
            $('#ferritecms_titleform').submit(function() {
                $.post(baseURL + 'ferritecms/ajax/updatePage.php', {
                    'id': pageID,
                    'update': 'title',
                    'content': $('#ferritecms_titlefield').val()
                }, function(data) {
                    // TODO: find a better way of displaying success/failure
                    alert(data);
                    
                    // Update navigation bar
                    $('title, .ferritecms_nav #ferritecms_nav-' + pageID + ' a')
                        .html($('#ferritecms_titlefield').val());
                });
                
                return false;
            });
        })
        .addClass('ferritecms_editing');
}