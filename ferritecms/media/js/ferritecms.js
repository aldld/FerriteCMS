
var editLinkText = '';

/**
 * Initialize editor mode
 */
function editorInit() {
    // Verify if the user is logged in
    $.get(baseURL + 'ferritecms/ajax/verifyUser.php', function(data) {
        if (data) {
            $('.ferritecms_editlink').html('Leave editor mode')
                .addClass('ferritecms_leaveeditor');
            
            // Convert content areas to textareas
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
            
            // Convert titles to text fields
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
            
            // TODO: navigation stuff
        }
    });
    
    return false;
}

/**
 * Function handling the login form
 */
function editorLogin(event) {
    if ($(event.target).is('.ferritecms_leaveeditor')) {
        // Revert content textarea
        $('.ferritecms_content').load(
            baseURL + 'ferritecms/ajax/getPage.php?type=content&id=' + pageID)
            .removeClass('ferritecms_editing');
        
        // Revert title field
        $('.ferritecms_title').load(
            baseURL + 'ferritecms/ajax/getPage.php?type=title&id=' + pageID)
            .removeClass('ferritecms_editing');
        
        // Log the user out and delete the cookie
        if ($.cookie('fcms_admin')) {
            $.cookie('fcms_admin', null);
        }
        
        $('.ferritecms_editlink').html(editLinkText)
            .removeClass('ferritecms_leaveeditor');
        return false;
    }
    
    if (!$.cookie('fcms_admin')) {
        $loginform = $('#ferritecms_loginform');
        $loginform.css({
            'top': ($(window).height()/2) - ($loginform.outerHeight()/2),
            'left': ($(window).width()/2) - ($loginform.outerWidth()/2)
        });
        $loginform.fadeIn(100);
        $('#ferritecms_password').focus();
        $('#ferritecms_loginform').submit(function() {
            $.post(baseURL + 'ferritecms/ajax/login.php', {
                'password': $('#ferritecms_password').val()
            }, function(data) {
                if (data) {
                    $('#ferritecms_loginform').hide();
                    editorInit();
                } else { // login falied
                    alert('Login failed');
                }
            });
            return false;
        })
        $('#ferritecms_logincancel').click(function() {
            $('#ferritecms_loginform').hide();
            return false;
        });
    }
    
    return false;
}

$(document).ready(function() {
    editLinkText = $('.ferritecms_editlink').html();
    editorInit();
    // Load the login form, hidden by default
    if ($('#ferritecms_loginform').length == 0) {
        $.get(baseURL + 'ferritecms/media/html/login.html', function(data) {
            $('body').append(data);
        });
    }
    
    $('.ferritecms_editlink').click(editorLogin);
    
});
